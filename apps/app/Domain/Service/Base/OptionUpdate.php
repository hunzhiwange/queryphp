<?php

declare(strict_types=1);

namespace App\Domain\Service\Base;

use App\Domain\Entity\Base\Option as OptionEntity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr;

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
        $this->save($params);

        return [];
    }

    /**
     * 保存.
     */
    private function save(OptionUpdateParams $params): void
    {
        foreach ($params->options as $k => $v) {
            $this->w->replace($this->entity($k, $v));
        }

        $this->w->flush();
    }

    /**
     * 组成实体.
     */
    private function entity(string $name, string $value): OptionEntity
    {
        $option = new OptionEntity();
        $option->name = $name;
        if(Arr::shouldJson($value)) {
            $value = Arr::convertJson($value);
        }
        $option->value = $value;

        return $option;
    }
}
