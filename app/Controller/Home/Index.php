<?php

declare(strict_types=1);

namespace App\Controller\Home;

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
//        go(function() {
//            //sleep(100);
//            //sleep(10);
////            $fp = fopen('data.txt', 'a');//opens file in append mode
////            fwrite($fp, '23424');
////            fclose($fp);
//
//           // echo "File appended successfully";
//        });
//        return '3332222223';

        return View::display('home');
    }
}
