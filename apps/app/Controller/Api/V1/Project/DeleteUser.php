<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\DeleteUser as Service;
use App\Domain\Service\Project\Project\DeleteUserParams;
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
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new DeleteUserParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
