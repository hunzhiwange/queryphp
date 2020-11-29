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

namespace App\App\Controller\Swagger;

/**
 * @codeCoverageIgnore
 */
class ApiDemo 
{
    /**
     * @OA\Get(
     *     path="/swagger/api/v1/demo/{name}/",
     *     summary="Just test the router",
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="name test",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     */
    #[Route(
        path: "/swagger/api/v1/demo/{name:[A-Za-z]+}/",
    )]
    public function index(string $name): string
    {
        return 'swagger api demo '. $name;
    }
}
