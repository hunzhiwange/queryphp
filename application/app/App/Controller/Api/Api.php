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
        path: "/api/v1/petLeevelForApi/{petId:[A-Za-z]+}/",
        attributes: ["args1" => "hello", "args2" => "world"],
    )]
    public function petLeevelForApi(string $petId): string
    {
        return sprintf('Hi you,i am petLeevelForApi and it petId is %s', $petId);
    }

    #[Route(
        path: "/api/v2/withBind/{petId:[A-Za-z]+}/",
        middlewares: "api",
    )]
    public function withBind(string $petId): string
    {
        return sprintf('Hi you,i am withBind and it petId is %s', $petId);
    }
}
