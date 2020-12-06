<?php

declare(strict_types=1);

/**
 * API 定义.
 *
 * - 路由相关主要由路由服务提供者进行设置。
 * - 大部分场景只需要使用基于路径的默认路由，不需要配置路由。
 * - 1.1.0-alpha.2 之前的版本，定制路由都是基于 OpenAPI 的路由，之后采用 PHP 8 注解实现。
 *
 * @see 路由服务提供者 \Common\Infra\ProviderRouter
 * @see 基于 PHP 8 注解路由 \App\App\Controller\Petstore\Store
 *
 * @OA\Info(
 *     description="The QueryPHP application Apis",
 *     version="1.0.0",
 *     title="QueryPHP Apis",
 * )
 */
class _
{
    // 占位防止代码格式化工具将注释破坏
}
