<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\Users as Service;
use App\Domain\Service\Project\Project\UsersParams;
use Leevel\Http\Request;

/**
 * 项目成员列表.
 *
 * @codeCoverageIgnore
 */
class User
{
    use Controller;

    private array $allowedInput = [
        'key',
        'page',
        'size',
        'column',
        'order_by',
        'project_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (isset($input['type'])) {
            $input['user_id'] = $this->userId();
        }
        $params = new UsersParams($input);

        return $service->handle($params);
    }
}
