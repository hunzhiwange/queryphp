<?php

declare(strict_types=1);

namespace App\Infra;

class RedisSequence
{
    protected string $prefix;

    public function __construct(protected \Redis $redis)
    {
    }

    public function sequence(PipelineCycleEnum $pipelineCycle, int $step = 1, int $beginNumber = 1, \Closure $sourceNext = null): int
    {
        $lua = <<<'LUA'
if redis.call('set', KEYS[1], ARGV[1], "EX", ARGV[2], "NX") then
    return ARGV[1]
else
    return redis.call('incrby', KEYS[1], ARGV[3])
end
LUA;

        $expireDate = match ($pipelineCycle) {
            PipelineCycleEnum::DAY => strtotime('23:59:59') - time(),
            PipelineCycleEnum::MONTH => strtotime(date('Y-m-t 23:59:59')) - time(),
            PipelineCycleEnum::YEAR => strtotime(date('Y-01-01 00:00:00', strtotime('+1 year'))) - time() - 1,
            default => strtotime('+99 year') - time(),
        };

        $currentTime = date($pipelineCycle->value);
        $next = (int) $this->redis->eval($lua, [$this->prefix.$currentTime, $beginNumber, $expireDate, $step], 1);

        // 返回为最小值，表示此前没有数据或者redis崩溃数据丢失，REDIS刚刚写入了一条数据
        // 此时，REDIS的键可能刚刚过期，比如处于切换的临界点的时候，返回源数据的最大值
        // 还有一种情况就是别的地方已经修改了REDIS的值，增加源数据的最大值
        if ($sourceNext && $next === $beginNumber) {
            $lua = <<<'LUA'
if redis.call('set', KEYS[1], ARGV[1], "EX", ARGV[2], "NX") then
    return ARGV[1]
else
    return redis.call('incrby', KEYS[1], ARGV[1])
end
LUA;
            $next = (int) $this->redis->eval($lua, [$this->prefix.$currentTime, $sourceNext(), $expireDate], 1);
        }

        return $next;
    }

    public function setCachePrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }
}
