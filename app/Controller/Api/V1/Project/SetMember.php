<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\SetMember as Service;
use App\Domain\Service\Project\Project\SetMemberParams;
use Leevel\Http\Request;

/**
 * 设为成员.
 *
 * @codeCoverageIgnore
 */
class SetMember
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
        $params = new SetMemberParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
