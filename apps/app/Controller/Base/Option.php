<?php

declare(strict_types=1);

namespace App\Controller\Base;

use App\Controller\Support\Controller;
use Leevel\Http\Request;
use App\Domain\Service\Option\OptionUpdate;
use App\Domain\Service\Option\OptionUpdateParams;

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
        $params = new OptionUpdateParams($this->input($request));

        return $service->handle($params);
    }
}
