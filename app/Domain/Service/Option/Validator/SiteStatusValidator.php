<?php

declare(strict_types=1);

namespace App\Domain\Service\Option\Validator;

use App\Domain\Entity\StatusEnum;
use App\Exceptions\OptionBusinessException;
use App\Exceptions\OptionErrorCode;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\Validator;

class SiteStatusValidator extends Validator
{
    public function handle(string $key, int $value): void
    {
        $validator = Validate::make(
            [$key => $value],
            [
                'site_status' => [
                    ['in', StatusEnum::values()],
                ],
            ],
            [
                'site_status' => __('站点状态'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new OptionBusinessException(OptionErrorCode::SITE_STATUS_ERROR, $e, true);
        }
    }
}
