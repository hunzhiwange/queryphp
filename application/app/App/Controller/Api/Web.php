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
class Web
{
    #[Route(
        path: "/web/v1/demo/{name:[A-Za-z]+}/",
    )]
    public function demo1(string $name): string
    {
        return sprintf('web demo, your name is %s'. $name);
    }

    #[Route(
        path: "/web/v2/demo/",
    )]
    public function demo2(): string
    {
        return 'web demo2';
    }
}
