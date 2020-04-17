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

namespace App\App\Controller\Petstore;

/**
 * Class Pet.
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 * @codeCoverageIgnore
 */
class Pet
{
    /**
     * @OA\Get(
     *     path="/api/v2/withBind/{petId:[A-Za-z]+}/",
     *     tags={"pet"},
     *     summary="Just test the router",
     *     operationId="petLeevel",
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Pet"},
     *     leevelBind="\App\App\Controller\Petstore\Pet@withBind",
     *     leevelMiddlewares="api"
     * )
     *
     * @param mixed $petId
     */
    public function withBind($petId): string
    {
        return sprintf('Hi you,i am withBind and it petId is %s', $petId);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/petLeevel/{petId:[A-Za-z]+}/",
     *     tags={"pet"},
     *     summary="Just test the router",
     *     operationId="petLeevel",
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Pet"},
     *     leevelScheme="https",
     *     leevelDomain="{subdomain:[A-Za-z]+}-vip.{domain}",
     *     leevelAttributes={"args1": "hello", "args2": "world"},
     *     leevelMiddlewares="api"
     * )
     */
    public function petLeevel(): void
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v2/petLeevelIgnore/",
     *     tags={"pet"},
     *     summary="Just test ignore the router",
     *     operationId="petLeevelIgnore",
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     leevelIgnore=true
     * )
     */
    public function petLeevelIgnore(): void
    {
    }

    /**
     * @OA\Post(
     *     path="/pet",
     *     tags={"pet"},
     *     summary="Add a new pet to the store",
     *     operationId="addPet",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Pet"}
     * )
     */
    public function addPet(): void
    {
    }

    /**
     * @OA\Put(
     *     path="/pet",
     *     tags={"pet"},
     *     summary="Update an existing pet",
     *     operationId="updatePet",
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pet not found"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Validation exception"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Pet"}
     * )
     */
    public function updatePet(): void
    {
    }

    /**
     * @OA\Get(
     *     path="/pet/findByStatus",
     *     tags={"pet"},
     *     summary="Finds Pets by status",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="findPetsByStatus",
     *     deprecated=true,
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             default="available",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"available", "pending", "sold"},
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                    ref="#/components/schemas/Pet"
     *                 )
     *             )
     *         ),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                    ref="#/components/schemas/Pet"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     }
     * )
     */
    public function findPetsByStatus(): void
    {
    }

    /**
     * @OA\Get(
     *     path="/pet/findByTags",
     *     tags={"pet"},
     *     summary="Finds Pets by tags",
     *     description=">-
     * Muliple tags can be provided with comma separated strings. Use\ \ tag1,
     * tag2, tag3 for testing.",
     *     operationId="findByTags",
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Tags to filter by",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                    ref="#/components/schemas/Pet"
     *                 )
     *             )
     *         ),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                    ref="#/components/schemas/Pet"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     }
     * )
     */
    public function findByTags(): void
    {
    }

    /**
     * @OA\Get(
     *     path="/pet/{petId}",
     *     tags={"pet"},
     *     summary="Find pet by ID",
     *     description="Returns a single pet",
     *     operationId="getPetById",
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/Pet"
     *             ),
     *         ),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(
     *                 ref="#/components/schemas/Pet"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pet not found"
     *     ),
     *     security={
     *         {"api_key": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function getPetById($id): void
    {
    }

    /**
     * @OA\Post(
     *     path="/pet/{petId}",
     *     tags={"pet"},
     *     summary="Updates a pet in the store with form data",
     *     operationId="updatePetWithForm",
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet that needs to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Updated name of the pet",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     description="Updated status of the pet",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updatePetWithForm(): void
    {
    }

    /**
     * @OA\Delete(
     *     path="/pet/{petId}",
     *     tags={"pet"},
     *     summary="Deletes a pet",
     *     operationId="deletePet",
     *     @OA\Parameter(
     *         name="api_key",
     *         in="header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="Pet id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pet not found",
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     * )
     */
    public function deletePet(): void
    {
    }

    /**
     * @OA\Post(
     *     path="/pet/{petId}/uploadImage",
     *     tags={"pet"},
     *     summary="uploads an image",
     *     operationId="uploadFile",
     *     @OA\Parameter(
     *         name="petId",
     *         in="path",
     *         description="ID of pet to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/ApiResponse"
     *             )
     *         )
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     @OA\RequestBody(
     *         description="Upload images request body",
     *         @OA\MediaType(
     *             mediaType="application/octet-stream",
     *             @OA\Schema(
     *                 type="string",
     *                 format="binary"
     *             )
     *         )
     *     )
     * )
     */
    public function uploadFile(): void
    {
    }
}
