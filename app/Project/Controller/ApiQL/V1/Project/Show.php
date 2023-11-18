<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\Show as Service;
use App\Project\Service\Project\ShowParams;
use Leevel\Http\Request;

/**
 * 项目查询.
 *
 * @codeCoverageIgnore
 */
class Show
{
    use Controller;

    private array $allowedInput = [
        'num',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new ShowParams($this->input($request));

        return $service->handle($params);
    }
}
