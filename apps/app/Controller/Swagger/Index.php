<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

use function App\Infra\Helper\force_close_debug;

use Exception;
use Leevel;
use function OpenApi\scan;

/**
 * Api 文档入口.
 *
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 响应.
     * 
     * @throws \Exception
     */
    public function handle(): string
    {
        if (!function_exists('OpenApi\\scan')) {
            $message = 'Swagger PHP do not support `composer dump-autoload --no-dev`, '.
                'because `zircote/swagger-php` is in `require-dev` of  composer.json';
            throw new Exception($message);
        }

        // 扫描路径
        $path = array_merge($this->basePath(), $this->path());
        $openApi = scan($path);

        // 关闭调试模式
        $this->forceCloseDebug();

        return json_encode($openApi) ?: '';
    }

    /**
     * 扫描路径.
     */
    protected function path(): array
    {
        return [
            Leevel::appPath('app/Controller'),
            Leevel::appPath('admin/Controller'),
        ];
    }

    /**
     * 基本路径.
     */
    protected function basePath(): array
    {
        return [
            Leevel::path('assets/swagger'),
        ];
    }

    /**
     * 关闭调试模式.
     */
    private function forceCloseDebug(): void
    {
        func(fn () => force_close_debug());
    }
}
