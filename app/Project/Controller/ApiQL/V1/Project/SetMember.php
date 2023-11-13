<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\SetMember as Service;
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
        $params = new \App\Project\Service\Project\SetMemberParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
