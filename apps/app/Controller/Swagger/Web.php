<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

use Leevel;

/**
 * Web 文档测试.
 *
 * - 文档太多加载速度就很慢，可以针对不同的服务加入不同的路径
 * - 访问地址 http://127.0.0.1:9527/apis/#/swagger/web
 *
 * @codeCoverageIgnore
 */
class Web extends Index
{
    /**
     * 扫描路径.
     */
    protected function path(): array
    {
        return [
            Leevel::appPath('app/Controller/Swagger/WebDemo.php'),
        ];
    }
}
