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
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     name="petstore_auth",
 *     securityScheme="petstore_auth",
 *     @OA\Flow(
 *         flow="implicit",
 *         authorizationUrl="http://petstore.swagger.io/oauth/dialog",
 *         scopes={
 *             "write:pets": "modify pets in your account",
 *             "read:pets": "read your pets",
 *         }
 *     )
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     securityScheme="api_key",
 *     name="api_key"
 * )
 */
class Foobar
{
}
