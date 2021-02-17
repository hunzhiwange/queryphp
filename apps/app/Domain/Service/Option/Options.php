<?php

declare(strict_types=1);

namespace App\Domain\Service\Option;

use App\Domain\Entity\Base\Option as OptionEntity;
use JsonException;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 获取配置.
 */
class Options
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(): array
    {
        $options = $this->w
            ->repository(OptionEntity::class)
            ->findAll();
        $result = $options->toArray();
        $result = $result ? array_column($result, 'value', 'name') : [];
        foreach ($result as &$v) {
            try {
                $v = json_decode($v, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
            }
        }

        $defaultValue = [];
        foreach (DefaultOptions::descriptions('option')['value'] as $key => $value) {
            $defaultValue[strtolower($key)] = $value;
        }

        return array_merge($defaultValue, $result);
    }
}
