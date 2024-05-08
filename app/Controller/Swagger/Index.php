<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

use App\Infra\Helper\ForceCloseDebug;
use OpenApi\Generator;

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
        if (!\class_exists(Generator::class)) {
            throw new \Exception('Swagger PHP do not support `composer dump-autoload --no-dev`, '.
                'because `zircote/swagger-php` is in `require-dev` of  composer.json');
        }

        // 扫描路径
        $path = array_merge($this->basePath(), $this->path());
        $openApi = Generator::scan($path, ['validate' => false]);

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
            //\Leevel::appPath('app/Controller'),
        ];
    }

    /**
     * 基本路径.
     */
    protected function basePath(): array
    {
        return [
            \Leevel::path('app/Infra/Swagger'),
        ];
    }

    /**
     * 关闭调试模式.
     */
    private function forceCloseDebug(): void
    {
        ForceCloseDebug::handle();
    }
}
