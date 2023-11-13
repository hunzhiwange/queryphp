<?php

declare(strict_types=1);

namespace App\Infra\Console;

use App\Base\Entity\City;
use App\Infra\Entity\YesEnum;
use Leevel\Console\Command;
use Leevel\Filesystem\Helper\CreateFile;
use Leevel\Support\Arr\ConvertJson;

/**
 * 生成城市JSON.
 */
class MakeCity extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:city';

    /**
     * 命令行描述.
     */
    protected string $description = 'Create city JSON.';

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $data = City::repository()
            ->where('is_show', YesEnum::YES->value)
            ->setColumns(['city_id', 'parent_id', 'name'])
            ->orderBy('id ASC')
            ->findAll()
        ;

        $result = [];
        foreach ($data as $v) {
            $result[] = [(string) $v['city_id'], (string) $v['parent_id'], $v['name']];
        }
        CreateFile::handle(\Leevel::path('storage/city.js'), ConvertJson::handle($result));

        return self::SUCCESS;
    }
}
