<?php declare(strict_types=1); 
// (c) 2018 http://your.domain.com All rights reserved.
namespace App\App\Controller;

use Leevel\Mvc\Controller;

/**
 * 首页
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class Home extends Controller
{

    /**
     * 默认方法
     *
     * @return void
     */
    public function handle() {
        return $this->display('home');
    }
}
