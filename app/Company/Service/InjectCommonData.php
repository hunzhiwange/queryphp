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
        Event::register(Repository::INSERT_ALL_EVENT, function (object|string $event, Repository $repository): void {
            $repository->insertAllBoot(function (&$data) use ($repository): void {
                $data = batch_inject_common_data(\get_class($repository->entity()), $data);
            });
        });
    }
}
