<?php

declare(strict_types=1);

namespace App\Config\Service\Validator;

use App\Config\Exceptions\OptionBusinessException;
use App\Config\Exceptions\OptionErrorCode;
use App\Infra\Entity\EnabledEnum;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\Validator;

class SiteStatusValidator extends Validator
{
    /**
     * @throws \Exception
     */
    public function handle(string $key, int $value): void
    {
        $validator = Validate::make(
            [$key => $value],
            [
                'site_status' => [
                    ['in', EnabledEnum::values()],
                ],
            ],
            [
                'site_status' => __('站点状态'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            // @phpstan-ignore-next-line
            throw new OptionBusinessException(OptionErrorCode::SITE_STATUS_ERROR, $e, true);
        }
    }
}
