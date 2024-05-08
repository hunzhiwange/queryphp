<?php

declare(strict_types=1);

namespace App\Infra\Swagger\Controller;

use OpenApi\Attributes as OA;

class UserDemoController
{
    #[OA\Get(
        path: '/2.0/users/{username}',
        operationId: 'getUserByName',
        summary: 'Get user details by username',
        tags: ['Users'],
        parameters: [
            new OA\Parameter(
                name: 'username',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )],
        responses: [
            new OA\Response(
                response: 200,
                description: 'The User',
                content: new OA\JsonContent(ref: '#/components/schemas/user_demo'),
            ),
        ]
    )]
    public function getUserByName(string $username): void
    {
    }
}
