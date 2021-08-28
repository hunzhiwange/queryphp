<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Leevel\Database\Ddd\Select;
use App;

/**
 * 公司 ID 过滤.
 */
trait CompanyId
{
    protected static function addCompanyIdGlobalScope(): void
    {
        static::addGlobalScope('company_id', function (Select $select) {
            $select->where('company_id', App::container()->make('company_id') ?: 1);
        });
    }
}
