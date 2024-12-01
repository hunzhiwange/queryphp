<?php

declare(strict_types=1);

namespace App\Controller\Home;

use App\Infra\Entity\Platform;
use App\Infra\Entity\SearchPlan;
use Leevel\View\Proxy\View;

/**
 * 首页.
 *
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 默认方法.
     */
    public function handle(): string
    {
        return View::proxy()->display('home');
    }
}
