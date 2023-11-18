<?php

declare(strict_types=1);

namespace App\Infra\Entity;

trait CompanyEntityTable
{
    public static function table(): string
    {
        return get_company_entity_table(parent::table());
    }
}
