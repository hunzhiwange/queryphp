<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\SetAdministrator as Service;
use App\Project\Service\Project\SetAdministratorParams;
use Leevel\Http\Request;

/**
 * 设为管理.
 *
 * @codeCoverageIgnore
 */
class SetAdministrator
{
    use Controller;

    private array $allowedInput = [
        'project_id',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new SetAdministratorParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
