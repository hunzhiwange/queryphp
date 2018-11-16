<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Controller\Resource2222;

//use admin\app\controller\aaction;
// use Admin\App\Service\Resource\Index as service;
// use Leevel\Http\Request;

/**
 * 验证登录.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class S2how// extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\app\service\login\check $oService
     * @param \admin\is\seccode\code         $oCode
     *
     * @return array
     */
    public function handle(/*Request $request, Service $service*//*, code $oCode*/)
    {   
        echo '11';

    //throw new \Exception('xxx');

// print_r($this->data($request));
// die;
       // echo 'hello world';

       //return $service->handle($this->input($request)/**//*, $this->code($oCode)*/);
    }

    /**
     * POST 数据.
     *
     * @return array
     */
    protected function input($request)
    {
        return $request->only([
            'key',
            'status',
            'page',
            'size',
        ]);
    }
}

// /**
//  * 后台菜单列表.
//  *
//  * @author Name Your <your@mail.com>
//  *
//  * @since 2017.10.12
//  *
//  * @version 1.0
//  * @menu
//  * @title 列表
//  * @name
//  * @path
//  * @component
//  * @icon
//  */
// class Index// extends aaction
// {
//     /**
//      * 响应方法.
//      *
//      * @param \admin\app\service\menu\index $oService
//      *
//      * @return mixed
//      */
//     public function handle(Request $request/*, service $service*/)
//     {

//         //header('Access-Control-Allow-Origin: '.($_SERVER['HTTP_ORIGIN'] ?? ''));
//         header('Access-Control-Allow-Origin: *');
//         //header('Access-Control-Allow-Credentials: true');
//         header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//         header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token, sessionId');

// //var_dump(1);
//         // 跨域校验
//         if ($request->isOptions()) {
//             echo 1;
//              die;
//         }

//         echo 2; 
//         die;

//        // echo '111';
//        // die;

//         return $service->handle();
//     }
// }
