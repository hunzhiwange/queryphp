<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\DeleteUser as Service;
use Leevel\Http\Request;

/**
 * 删除成员.
 *
 * @codeCoverageIgnore
 */
class DeleteUser
{
    use Controller;

    private array $allowedInput = [
        'project_id',
        'user_id',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\Project\DeleteUserParams($this->input($request));

        return $service->handle($params);
    }
}
