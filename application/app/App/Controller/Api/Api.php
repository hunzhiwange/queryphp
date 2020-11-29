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

namespace App\App\Controller\Api;

/**
 * @codeCoverageIgnore
 */
class Api
{
    #[Route(
        path: "/api/v1/demo/{name:[A-Za-z]+}/",
        attributes: ["args1" => "hello", "args2" => "world"],
    )]
    public function demo1(string $name): string
    {
        return sprintf('Hi you, you name is %s in version 1', $name);
    }

    #[Route(
        path: "/api/v2/demo/{name:[A-Za-z]+}/",
        middlewares: "api",
    )]
    public function demo2(string $name): string
    {
        return sprintf('Hi you,your name is %s in version 2', $name);
    }
}
