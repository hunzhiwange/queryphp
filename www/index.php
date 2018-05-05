<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.

use Leevel\Http\Request;
use Leevel\Bootstrap\IKernel;

/**
 * ---------------------------------------------------------------
 * 创建项目
 * ---------------------------------------------------------------
 *
 * 注册项目基础服务
 */
$project = require_once __DIR__ . '/../common/project.php';

/**
 * ---------------------------------------------------------------
 * 执行项目
 * ---------------------------------------------------------------
 *
 * 根据内核调度请求返回响应
 */
$kernel = $project->make(IKernel::class);

$response = $kernel->handle(
    $request = Request::createFromGlobals()
);

$response->send();

$kernel->terminate($request, $response);
