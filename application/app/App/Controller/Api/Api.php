<?php

declare(strict_types=1);

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
