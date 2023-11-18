<?php

declare(strict_types=1);

namespace App\Auth\Controller\ApiQL\V1\Login;

use App\Auth\Service\Code as Service;
use App\Auth\Service\CodeParams;
use App\Controller\Support\CloseDebug;
use Leevel\Http\Request;
use Leevel\Http\Response;

/**
 * 验证码.
 *
 * @codeCoverageIgnore
 */
class Code
{
    use CloseDebug;

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): Response
    {
        $this->closeDebug();

        $params = new CodeParams($request->all());
        $code = $service->handle($params);

        return new Response($code, 200, ['Content-type' => 'image/jpeg']);
    }
}
