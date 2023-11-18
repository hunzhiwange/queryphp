<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;
use Leevel\Support\Dto;
use Leevel\Support\Type;

/**
 * API查询语言列表参数.
 */
class ApiQLBatchParams extends Dto
{
    public array $apis = [];

    public array $params = [];

    public function validate(): void
    {
        $this->validateApis();
        $this->validateParams();
    }

    private function validateApis(): void
    {
        if (!$this->apis) {
            throw new BusinessException(ErrorCode::API_QL_BATCH_APIS_EMPTY);
        }

        if (!Type::arr($this->apis, ['string:string'])) {
            throw new BusinessException(ErrorCode::API_QL_BATCH_APIS_INVALID);
        }
    }

    private function validateParams(): void
    {
        if (!$this->params) {
            throw new BusinessException(ErrorCode::API_QL_BATCH_PARAMS_EMPTY);
        }

        if (!Type::arr($this->params, ['string:array'])) {
            throw new BusinessException(ErrorCode::API_QL_BATCH_PARAMS_INVALID);
        }

        if (\count($this->apis) !== \count($this->params)) {
            throw new BusinessException(ErrorCode::ID2023040922413601);
        }
    }
}
