<?php

declare(strict_types=1);

namespace App\Company\Service;

use Leevel\Config\Proxy\Config;

class PlatformCompany
{
    public static function getCompanyDbAndTable(int $companyId): array
    {
        $companyId = (string) $companyId;
        if (\strlen($companyId) < 6) {
            throw new \Exception('Company id error.');
        }

        return [
            // 公司编号：自增ID+3位数据库+2位表名
            'db' => (int) substr($companyId, -5, 3),
            'table' => (int) substr($companyId, -2, 2),
        ];
    }

    public static function getPlatformDbAndTable(int $platformId): array
    {
        return self::getCompanyDbAndTable($platformId);
    }

    public static function createPlatformId(int $platformId, int $db, int $table): string
    {
        return self::createCompanyId($platformId, $db, $table);
    }

    public static function createCompanyId(int $companyId, int $db, int $table): string
    {
        if (\strlen((string) $db) > 3) {
            throw new \Exception('Db error.');
        }

        if (\strlen((string) $table) > 3) {
            throw new \Exception('Db table error.');
        }

        if (\strlen((string) $db) < 3) {
            $db = str_pad((string) $db, 3, '0', STR_PAD_LEFT);
        }

        if (\strlen((string) $table) < 2) {
            $table = str_pad((string) $table, 2, '0', STR_PAD_LEFT);
        }

        // 公司编号：自增ID+3位数据库+2位表名
        return $companyId.$db.$table;
    }

    public static function setPlatformCompanyConnect(int $platformDb, int $companyDb, string $dbPrefix, string $commonDbPrefix): void
    {
        // 业务库
        $database = ($platformDb ? 'plat'.$platformDb.'_' : '').$dbPrefix.($companyDb ?: '');
        Config::set('database\\connect.mysql.name', $database);

        // 公共库
        if ($platformDb) {
            $commonDatabase = 'plat'.$platformDb.'_'.$commonDbPrefix;
            Config::set('database\\connect.common.name', $commonDatabase);
        }
    }
}
