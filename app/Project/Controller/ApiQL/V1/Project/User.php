<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\Users as Service;
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
        'project_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (isset($input['type'])) {
            $input['user_id'] = $this->userId();
        }
        $params = new \App\Project\Service\Project\UsersParams($input);

        return $service->handle($params);
    }
}
