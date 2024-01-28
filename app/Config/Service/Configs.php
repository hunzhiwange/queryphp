<?php

declare(strict_types=1);

namespace App\Config\Service;

use App\Config\Entity\Config as ConfigEntity;
use JsonException;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 获取配置.
 */
class Configs
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(): array
    {
        $configs = $this->w
            ->repository(ConfigEntity::class)
            ->findAll()
        ;
        $result = $configs->toArray();
        $result = $result ? array_column($result, 'value', 'name') : [];
        foreach ($result as &$v) {
            try {
                $v = json_decode($v, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
            }
        }

        $defaultConfigs = new DefaultConfigs();

        return array_merge($defaultConfigs->toArray(), $result);
    }
}
