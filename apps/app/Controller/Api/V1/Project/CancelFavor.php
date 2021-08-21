<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\CancelFavor as Service;
use App\Domain\Service\Project\Project\CancelFavorParams;
use Leevel\Auth\Proxy\Auth;
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

    public function handle(Request $request, Service $service): array
    {
        $params = new CancelFavorParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
