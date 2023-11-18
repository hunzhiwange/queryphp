<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Update as Service;
use Leevel\Http\Request;

/**
 * 项目问题内容更新.
 *
 * @codeCoverageIgnore
 */
class Content
{
    use Controller;

    private array $allowedInput = [
        'id',
        'content',
        'sub_title',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectIssue\UpdateParams($this->input($request));

        return success_message($service->handle($params), __('内容保存成功'));
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
