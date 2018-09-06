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

namespace App\App\Controller\Petstore;

/**
 * Class Api.
 *
 *
 * @author  Xiangmin Liu <635750556@qq.com>
 */
class Api
{
    /**
     * @OAS\Get(
     *     path="/api/v1/petLeevelForApi/{petId:[A-Za-z]+}/",
     *     tags={"pet"},
     *     summary="Just test the router",
     *     operationId="petLeevelForApi",
     *     @OAS\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     }
     * )
     */
    public function petLeevelForApi()
    {
    }

    /**
     * @OAS\Get(
     *     path="/api/v2/petLeevelV2Api/",
     *     tags={"pet"},
     *     summary="Just test ignore the router",
     *     operationId="petLeevelV2Api",
     *     @OAS\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     leevelIgnore=true
     * )
     */
    public function petLeevelV2ForApi()
    {
    }

    /**
     * @OAS\Get(
     *     path="/api/v1/petLeevelIgnoreForApi/",
     *     tags={"pet"},
     *     summary="Just test ignore the router",
     *     operationId="petLeevelIgnoreForApi",
     *     @OAS\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OAS\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OAS\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     leevelIgnore=true
     * )
     */
    public function petLeevelIgnoreForApi()
    {
    }
}
