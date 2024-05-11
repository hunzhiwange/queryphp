<?php

declare(strict_types=1);

namespace App\Config\Service;

use App\Config\Entity\Config as ConfigEntity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr;
use Leevel\Support\Str;

/**
 * 配置更新.
 */
class ConfigUpdate
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ConfigUpdateParams $params): array
    {
        $this->validateParams($params);
        $this->save($params);

        return [];
    }

    private function validateParams(ConfigUpdateParams $params): void
    {
        foreach ($params->all() as $k => $v) {
            $validatorClass = __NAMESPACE__.'\\Validator\\'.ucfirst(Str::camelize($k)).'Validator';
            if (class_exists($validatorClass)) {
                $validator = new $validatorClass();
                // @phpstan-ignore-next-line
                $validator->handle($k, $v, $params);
            }
        }
    }

    /**
     * 保存.
     */
    private function save(ConfigUpdateParams $params): void
    {
        foreach ($params->all() as $k => $v) {
            $this->w->replace($this->entity($k, $v));
        }

        $this->w->flush();
    }

    /**
     * 组成实体.
     */
    private function entity(string $name, string $value): ConfigEntity
    {
        $config = new ConfigEntity();
        $config->name = $name;
        if (Arr::shouldJson($value)) {
            $value = Arr::convertJson($value);
        }
        $config->value = $value;
        $config->{$config->deleteAtColumn()} = 0;

        return $config;
    }
}
