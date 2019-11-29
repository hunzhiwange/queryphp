<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @OA\Info(
 *     description="This is a sample Petstore server.  You can find
 * out more about Swagger at
 * [http://swagger.io](http://swagger.io) or on
 * [irc.freenode.net, #swagger](http://swagger.io/irc/).",
 *     version="1.0.0",
 *     title="Swagger Petstore",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         email="apiteam@swagger.io"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class _
{
    // 占位防止代码格式化工具将注释破坏
}

/**
 * leevels 为路由全局设置.
 *
 * @OA\Tag(
 *     name="pet",
 *     leevelGroup="pet",
 *     description="Everything about your Pets",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 * @OA\Tag(
 *     name="store",
 *     leevelGroup="store",
 *     description="Access to Petstore orders",
 * )
 * @OA\Tag(
 *     name="user",
 *     leevelGroup="user",
 *     description="Operations about user",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about store",
 *         url="http://swagger.io"
 *     )
 * )
 * @OA\Server(
 *     description="SwaggerHUB API Mocking 1.0.0",
 *     url="https://virtserver.swaggerhub.com/swagger/Petstore"
 * )
 * @OA\ExternalDocumentation(
 *     description="Find out more about Swagger",
 *     url="http://swagger.io",
 *     leevels={
 *         "*": {
 *             "middlewares": "common"
 *         },
 *         "foo/*world": {
 *         },
 *         "api/test": {
 *             "middlewares": "api"
 *         },
 *         ":admin/*": {
 *             "middlewares": "admin_auth,cors"
 *         },
 *         "options/index": {
 *             "middlewares": "cors"
 *         },
 *         "admin/show": {
 *             "middlewares": "auth"
 *         },
 *         "/api/v1": {
 *             "middlewares": "api",
 *             "group": true
 *         },
 *         "api/v2": {
 *             "middlewares": "api",
 *             "group": true
 *         },
 *         "/web/v1": {
 *             "middlewares": "web",
 *             "group": true
 *         },
 *         "web/v2": {
 *             "middlewares": "web",
 *             "group": true
 *         }
 *     }
 * )
 */
class _
{
    // 占位防止代码格式化工具将注释破坏
}
