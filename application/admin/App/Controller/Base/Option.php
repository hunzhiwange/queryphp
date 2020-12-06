<?php

declare(strict_types=1);

namespace Admin\App\Controller\Base;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Base\Option as Service;
use Leevel\Http\Request;

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
        'site_close',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
