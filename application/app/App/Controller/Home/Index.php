<?php

declare(strict_types=1);

namespace App\App\Controller\Home;

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
        return View::display('home');
    }
}
