<?php

declare(strict_types=1);

namespace Admin\Controller\Login;

use Admin\Controller\Support\Controller;
use App\Domain\Service\Login\Code as Service;
use App\Domain\Service\Login\CodeParams;

use function App\Infra\Helper\force_close_debug;
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

    public function handle(Request $request, Service $service): Response
    {
        $params = new CodeParams($this->input($request));
        $code = $service->handle($params);
        $this->forceCloseDebug();

        return new Response($code, 200, ['Content-type' => 'image/png']);
    }

    private function input(Request $request): array
    {
        return [
            'id' => $request->query->get('id'),
        ];
    }

    /**
     * 关闭调试模式.
     * 
     * - 调试代码会导致验证码图像无法生成
     */
    private function forceCloseDebug(): void
    {
        func(fn () => force_close_debug());
    }
}
