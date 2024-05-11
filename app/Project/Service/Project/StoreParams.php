<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\StoreParams as CommonStoreParams;
use App\Infra\Dto\Project\Template;
use App\Infra\Dto\Project\TemplateData;
use App\Project\Entity\Project;
use Leevel\Support\VectorDto;

/**
 * 项目保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public ?Template $template = null;

    public string $entityClass = Project::class;

    /**
     * @throws \InvalidArgumentException
     */
    protected function templateTransformValue(array $value): Template
    {
        if (!isset($value['data']) || !\is_array($value['data'])) {
            throw new \InvalidArgumentException('Template data struct error');
        }
        $value['data'] = VectorDto::fromRequest($value['data'], TemplateData::class);

        return new Template($value);
    }
}
