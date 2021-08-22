<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\SetAdministrator as Service;
use App\Domain\Service\Project\Project\SetAdministratorParams;
use Leevel\Http\Request;

/**
 * 设为成员.
 *
 * @codeCoverageIgnore
 */
class SetAdministrator
{
    use Controller;

    private array $allowedInput = [
        'project_id',
    ];

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
