<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Dto\Project\Template;
use App\Domain\Dto\Project\TemplateData;
use App\Domain\Entity\Project\Project;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use InvalidArgumentException;
use Leevel\Support\TypedDtoArray;

/**
 * 项目保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    public ?Template $template = null;

    protected string $entityClass = Project::class;

    /**
     * @throws \InvalidArgumentException
     */
    protected function templateTransformValue(array $value): Template
    {
        if (!isset($value['data']) || !is_array($value['data'])) {
            throw new InvalidArgumentException('Template data struct error');
        }
        $value['data'] = TypedDtoArray::fromRequest($value['data'], TemplateData::class);

        return new Template($value);
    }
}
