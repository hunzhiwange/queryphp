<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

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
        path: '/swagger/api/v1/demo/{name:[A-Za-z]+}/',
    )]
    public function index(string $name): string
    {
        return 'swagger api demo '.$name;
    }
}
