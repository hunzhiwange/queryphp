<?php

declare(strict_types=1);

namespace App\Controller\Login;

use App\Controller\Support\CloseDebug;
use App\Controller\Support\Controller;
use App\Domain\Service\Login\Code as Service;
use App\Domain\Service\Login\CodeParams;
use Leevel\Http\Request;
use Leevel\Http\Response;

/**
 * 验证码.
 *
 * @codeCoverageIgnore
 */
class Code
{
    use Controller;
    use CloseDebug;

    public function handle(Request $request, Service $service): Response
    {
        $this->closeDebug();
        $params = new CodeParams($this->input($request));
        $code = $service->handle($params);

        return new Response($code, 200, ['Content-type' => 'image/png']);
    }

    private function input(Request $request): array
    {
        return [
            'id' => $request->query->get('id'),
        ];
    }
}
