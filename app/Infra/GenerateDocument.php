<?php

declare(strict_types=1);

namespace App\Infra;

use Leevel\Cache\Redis;
use Leevel\Support\Dto;

class GenerateDocument extends Dto
{
    /**
     * 增长步长
     */
    public int $step = 1;

    /**
     * 序列长度.
     */
    public int $serialLength = 5;

    /**
     * 单据类型.
     */
    public string $guid = '';

    /**
     * 分隔符.
     */
    public SeparatorsEnum $separators = SeparatorsEnum::BLANK;

    /**
     * 开始值
     */
    public int $beginNumber = 0;

    /**
     * 安全值
     */
    public int $safeNext = 30;

    /**
     * 循环周期
     */
    public PipelineCycleEnum $pipelineCycle = PipelineCycleEnum::DAY;

    /**
     * 单据格式化.
     */
    public string $format = '';

    public function handle(\Closure $sourceNext = null): string
    {
        if ($sourceNext) {
            $sourceNext = $this->getNextSequenceClosure($sourceNext);
        }

        $next = $this->getRedisSequence()->sequence($this->pipelineCycle, $this->step, $this->beginNumber, $sourceNext);

        if (\strlen((string) $next) < $this->serialLength) {
            $next = str_pad((string) ($next + $this->step), $this->serialLength, '0', STR_PAD_LEFT);
        } else {
            $next = $next + $this->step;
        }

        $currentTime = date($this->format ?: $this->pipelineCycle->value);

        return implode($this->separators->value, array_filter([
            $this->guid,
            $currentTime,
            $next,
        ]));
    }

    protected function getRedisSequence(): RedisSequence
    {
        /** @var Redis $phpRedis */
        $phpRedis = \App::make('caches')->connect('redis');

        /** @var \Redis $redis */
        $redis = $phpRedis->getHandle();

        return (new RedisSequence($redis))->setCachePrefix('redis_sequence:'.$this->guid.':');
    }

    protected function getNextSequenceClosure(\Closure $sourceNext): \Closure
    {
        return function () use ($sourceNext): int {
            $sourceNext = (string) $sourceNext();

            $next = (int) substr($sourceNext, -$this->serialLength);
            $next = $next + $this->step;

            $time = substr($sourceNext, 0, -$this->serialLength - 1);
            $time = (string) preg_replace('/[^0-9]/i', '', $time);
            $time = strtotime($time);
            if (false === $time) {
                throw new \Exception('Invalid document.');
            }

            $pipelineCycleDate = $this->pipelineCycle->value;
            if (date($pipelineCycleDate) > date($pipelineCycleDate, $time)) {
                $next = $this->beginNumber;
            }

            // 拉开一段安全距离，避免这个期间数据库重复
            $next += $this->safeNext;

            return $next;
        };
    }
}
