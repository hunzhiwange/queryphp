<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\App\Controller\Api;

use Leevel;

/**
 * api 文档入口.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class Show
{
    /**
     * @SWG\Swagger(
     *     schemes={"http"},
     *     host="/",
     *     basePath="/v2",
     *     @SWG\Info(
     *         version="1.0.0",
     *         title="QueryPHP APIS",
     *         description="Welcome to use QueryPHP."
     *     ),
     *     @SWG\ExternalDocumentation(
     *         description="The QueryPHP Site",
     *         url="https://www.queryphp.com"
     *     )
     * )
     */
    public function handle()
    {
        error_reporting(E_ERROR | E_PARSE | E_STRICT);

        $path = [
            Leevel::appPath(),
        ];

        if (!function_exists('\\Swagger\\scan')) {
            require_once Leevel::path('vendor').'/zircote/swagger-php/src/functions.php';
        }

        $swagger = \Swagger\scan($path);

        echo $swagger->__toString();

        exit();
    }
}
