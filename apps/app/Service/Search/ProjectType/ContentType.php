<?php

declare(strict_types=1);

namespace App\Service\Search\ProjectType;

use App\Domain\Entity\Project\ProjectType;

class ContentType
{
    public function handle(array $input): array
    {
        return ProjectType::valueDescriptionMap('content_type');
    }
}
