<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\Base\Option as OptionEntity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr;
use Leevel\Support\Str;

/**
 * 配置更新.
 */
class OptionUpdate
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(OptionUpdateParams $params): array
    {
        $this->validateParams($params);
        $this->save($params);

        return [];
    }

    private function validateParams(OptionUpdateParams $params)
    {
        foreach ($params->all() as $k => $v) {
            $validatorClass = __NAMESPACE__.'\\Validator\\'.ucfirst(Str::camelize($k)).'Validator';
            if (class_exists($validatorClass)) {
                $validator = new $validatorClass();
                $validator->handle($k, $v, $params);
            }
        }
    }

    /**
     * 保存.
     */
    private function save(OptionUpdateParams $params): void
    {
        foreach ($params->all() as $k => $v) {
            $this->w->replace($this->entity($k, $v));
        }

        $this->w->flush();
    }

    /**
     * 组成实体.
     */
    private function entity(string $name, mixed $value): OptionEntity
    {
        $option = new OptionEntity();
        $option->name = $name;
        if(Arr::shouldJson($value)) {
            $value = Arr::convertJson($value);
        }
        $option->value = $value;
        $option->{$option->deleteAtColumn()} = 0;

        return $option;
    }
}
