<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\CancelFavor as Service;
use Leevel\Http\Request;

/**
 * 项目收藏取消.
 *
 * @codeCoverageIgnore
 */
class CancelFavor
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
        $params = new \App\Project\Service\Project\CancelFavorParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
