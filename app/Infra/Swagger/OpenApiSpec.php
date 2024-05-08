<?php

declare(strict_types=1);

namespace App\Infra\Swagger;

use OpenApi\Attributes as OAT;

#[OAT\Info(
    version: '1.0.0',
    description: '',
    title: 'The application Apis',
    contact: new OAT\Contact(
        name: 'Contact Name',
        email: 'support@example.com'
    )
)]
class OpenApiSpec
{
}
