<?php

declare(strict_types=1);

namespace App\Infra\Swagger\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'user_demo'
)]
class UserDemoModel
{
    #[OA\Property(
        type: 'string'
    )]
    public string $username;

    #[OA\Property(
        type: 'string'
    )]
    public string $uuid;
}
