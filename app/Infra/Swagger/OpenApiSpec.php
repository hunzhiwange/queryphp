<?php

declare(strict_types=1);

namespace App\Infra\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: '',
    title: 'The application Apis',
    contact: new OA\Contact(
        name: 'Contact Name',
        email: 'support@example.com'
    )
)]
class OpenApiSpec {}
