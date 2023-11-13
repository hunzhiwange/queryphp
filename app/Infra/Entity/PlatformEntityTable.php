<?php

declare(strict_types=1);

namespace App\Infra\Entity;

trait PlatformEntityTable
{
    public static function table(): string
    {
        return get_platform_entity_table(parent::table());
    }
}
