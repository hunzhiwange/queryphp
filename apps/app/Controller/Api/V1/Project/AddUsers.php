<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\AddUsers as Service;
use App\Domain\Service\Project\Project\AddUsersParams;
use Leevel\Http\Request;

/**
 * 添加成员.
 *
 * @codeCoverageIgnore
 */
class AddUsers
{
    use Controller;

    private array $allowedInput = [
        'project_id',
        'user_ids',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new AddUsersParams($this->input($request));

        return $service->handle($params);
    }
}
