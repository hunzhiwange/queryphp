<?php

declare(strict_types=1);

namespace App\Infra\Swagger\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    type: 'object',
    description: 'Api response demo',
    title: 'Api response demo'
)]
class ApiResponseDemoModel
{
    #[OA\Property(
        type: 'integer',
        description: 'Code',
        title: 'Code',
        format: 'int32'
    )]
    private $code;

    #[OA\Property(
        type: 'string',
        description: 'Type',
        title: 'Type'
    )]
    private $type;

    #[OA\Property(
        type: 'string',
        description: 'Message',
        title: 'Message'
    )]
    private $message;
}
