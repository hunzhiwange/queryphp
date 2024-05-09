<?php

declare(strict_types=1);

namespace App\Controller\Swagger;

use Leevel\Router\Route;
use OpenApi\Attributes as OA;

/**
 * @codeCoverageIgnore
 */
class WebDemo
{
    #[OA\Get(
        path: '/swagger/web/v1/demo/{name}/',
        summary: 'Just test the router',
        tags: ['Web Demo'],
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
        path: '/swagger/web/v1/demo/{name:[A-Za-z]+}/',
    )]
    public function index(string $name): string
    {
        return 'swagger web demo '.$name;
    }
}
