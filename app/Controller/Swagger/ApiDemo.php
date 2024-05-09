<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

use Leevel\Router\Route;
use OpenApi\Attributes as OA;

/**
 * @codeCoverageIgnore
 */
class ApiDemo
{
    #[OA\Get(
        path: '/swagger/api/v1/demo/{name}/',
        summary: 'Just test the router',
        tags: ['Api Demo'],
        parameters: [
            new OA\Parameter(
                name: 'name',
                in: 'path',
                required: true,
                description: 'name test',
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(
                response: 405,
                description: 'Invalid input',
            ),
        ]
    )]
    #[Route(
        path: '/swagger/api/v1/demo/{name:[A-Za-z]+}/',
    )]
    public function index(string $name): string
    {
        return 'swagger api demo '.$name;
    }
}
