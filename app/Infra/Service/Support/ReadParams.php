<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;
use Leevel\Support\MapStringMixed;
use Leevel\Support\VectorString;

/**
 * 查询参数.
 */
class ReadParams extends ParamsDto
{
    public const REMAINED_FIELD = [
        'page',
        'page_size',
        'limit',
        'key',
        'column',
        'key_column',
        'group_by',
        'order_by',
        'relation',
        'list_page',
        'list_only',
        'where',
        'entity',
        'entity_class',
    ];

    public const SEARCH_KEY_COLUMN = 'search_key_column';

    public const SEARCH_RAW = 'raw:';

    public const PAGE_SIZE_MAX = 2000;

    public int $page = 1;

    public int $pageSize = 30;

    public ?array $limit = null;

    public ?string $orderBy = 'id DESC';

    public ?string $groupBy = null;

    public ?string $key = null;

    public ?VectorString $column = null;

    public ?VectorString $keyColumn = null;

    public ?MapStringMixed $relation = null;

    public ?MapStringMixed $where = null;

    public bool $listPage = false;

    public bool $listOnly = false;

    public function prepareListPageSize(): void
    {
        if ($this->pageSize > static::PAGE_SIZE_MAX) {
            $this->pageSize = static::PAGE_SIZE_MAX;
        }
    }

    public function prepareListOnlyLimit(): void
    {
        if (isset($this->limit[1])) {
            if ((int) $this->limit[1] > static::PAGE_SIZE_MAX) {
                $this->limit[1] = static::PAGE_SIZE_MAX;
            }
        } elseif (isset($this->limit[0])) {
            if ((int) $this->limit[0] > static::PAGE_SIZE_MAX) {
                $this->limit[0] = static::PAGE_SIZE_MAX;
            }
        } else {
            $this->limit = [static::PAGE_SIZE_MAX];
        }
    }

    protected function limitTransformValue(array|string|int $value): array
    {
        if (\is_array($value)) {
            return $value;
        }

        if (\is_int($value)) {
            return [$value];
        }

        return explode(',', $value);
    }

    protected function relationTransformValue(array $value): MapStringMixed
    {
        return new MapStringMixed($value);
    }

    protected function whereTransformValue(array $value): MapStringMixed
    {
        return new MapStringMixed($value);
    }

    protected function columnTransformValue(array|string $value): VectorString
    {
        if (\is_string($value)) {
            $value = explode(',', $value);
        }

        return new VectorString($value);
    }

    protected function columnDefaultValue(): VectorString
    {
        return new VectorString($this->columnDefaultField());
    }

    protected function keyColumnDefaultValue(): VectorString
    {
        return new VectorString($this->keyColumnDefaultField());
    }

    protected function columnDefaultField(): array
    {
        return ['*'];
    }

    protected function keyColumnDefaultField(): array
    {
        return [];
    }
}
