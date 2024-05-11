<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\AddUsers as Service;
use App\Project\Service\Project\AddUsersParams;
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

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new AddUsersParams($this->input($request));

        return $service->handle($params);
    }
}
