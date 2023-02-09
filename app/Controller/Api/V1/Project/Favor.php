<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\Favor as Service;
use App\Domain\Service\Project\Project\FavorParams;
use Leevel\Http\Request;

/**
 * 项目收藏.
 *
 * @codeCoverageIgnore
 */
class Favor
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
        $params = new FavorParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['user_id' => $this->userId()];
    }
}
