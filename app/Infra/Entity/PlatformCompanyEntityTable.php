<?php

declare(strict_types=1);

namespace App\Infra\Entity;

trait PlatformCompanyEntityTable
{
    public static function table(): string
    {
        return get_platform_company_entity_table(parent::table());
    }
}
