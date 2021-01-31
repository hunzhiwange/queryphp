<?php

declare(strict_types=1);

namespace App\Domain\Service\Base\Validator;

use App\Domain\Entity\Base\Option;
use App\Domain\Service\Base\OptionUpdateParams;
use App\Exceptions\OptionBusinessException;
use App\Exceptions\OptionErrorCode;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\Validator;

class SiteStatusValidator extends Validator
{
    public function handle(string $key, int|string $value, OptionUpdateParams $params): void
    {
        $value = (int) $value;
        $options = $params->options;
        $options[$key] = $value;
        $params->options = $options;

        $validator = Validate::make(
            [$key => $value],
            [
                'site_status'  => [
                    ['in', Option::values('site_status')],
                ],
            ],
            [
                'site_status'  => __('站点状态'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new OptionBusinessException(OptionErrorCode::SITE_STATUS_ERROR, $e, true);
        }
    }
}
