<?php

declare(strict_types=1);

namespace App\Company\Service;

use Leevel\Database\Ddd\Repository;
use Leevel\Event\Proxy\Event;

class InjectCommonData
{
    /**
     * 注入公共信息.
     */
    public function handle(): void
    {
        Event::proxy()->register(Repository::INSERT_ALL_EVENT, static function (object|string $event, Repository $repository): void {
            $repository->setInsertAllBoot(static function (Repository $repository, array &$data): void {
                $data = batch_inject_common_data(\get_class($repository->entity()), $data);
            });
        });
    }
}
