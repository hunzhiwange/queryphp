<?php

declare(strict_types=1);

namespace Admin\Controller\Base;

use Admin\Controller\Support\Controller;
use Leevel\Http\Request;
use App\Domain\Service\Base\OptionUpdate;
use App\Domain\Service\Base\OptionUpdateParams;

/**
 * 配置更新.
 *
 * @codeCoverageIgnore
 */
class Option
{
    use Controller;

    private array $allowedInput = [
        'site_name',
        'site_status',
    ];

    public function handle(Request $request, OptionUpdate $service): array
    {
        $params = OptionUpdateParams::fromRequest($this->input($request));

        return $service->handle($params);
    }
}
