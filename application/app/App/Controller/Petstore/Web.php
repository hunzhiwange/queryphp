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
 * Class Web.
 *
 *
 * @author  Xiangmin Liu <635750556@qq.com>
 */
class Web
{
    /**
     * @OAS\Get(
     *     path="/web/v1/petLeevelForWeb/{petId:[A-Za-z]+}/",
     *     tags={"pet"},
     *     summary="Just test the router",
     *     operationId="petLeevelForWeb",
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
    public function petLeevelForWeb()
    {
    }

    /**
     * @OAS\Get(
     *     path="/web/v2/petLeevelV2Web/",
     *     tags={"pet"},
     *     summary="Just test ignore the router",
     *     operationId="petLeevelV2Web",
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
    public function petLeevelV2ForWeb()
    {
    }

    /**
     * @OAS\Get(
     *     path="/web/v1/petLeevelIgnoreForWeb/",
     *     tags={"pet"},
     *     summary="Just test ignore the router",
     *     operationId="petLeevelIgnoreForWeb",
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
    public function petLeevelIgnoreForWeb()
    {
    }
}
