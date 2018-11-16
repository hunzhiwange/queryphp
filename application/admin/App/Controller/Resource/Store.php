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

namespace Admin\App\Controller\Resource;

//use admin\app\controller\aaction;
use Admin\App\Service\Resource\Store as service;
use Leevel\Http\Request;

/**
 * 后台职位分类新增保存.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.19
 *
 * @version 1.0
 * @menu
 * @title 保存
 * @name
 * @path
 * @component
 * @icon
 */
class Store
{
    /**
     * 职位分类状态值对象
     *
     * @var \admin\domain\value_object\position_category\status
     */
    //protected $oStatus;

    /**
     * 响应方法.
     *
     * @param \admin\app\service\position_category\store          $oService
     * @param \admin\domain\value_object\position_category\status $oStatus
     *
     * @return mixed
     */
    public function handle(Request $request, Service $service)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token, sessionId');


        // 跨域校验
        if ($request->isOptions()) {
            //echo '111';
            die;
        }

       // echo '111';
//die;

        return $service->handle($this->input($request)/**//*, $this->code($oCode)*/);


       // var_dump($result);
        // $this->oStatus = $oStatus;

        //$mixResult = $oService->run($this->data());
        //$mixResult = $mixResult->toArray();
       
        //$mixResult['message'] = __('职位分类保存成功');

      //  return $result;
    }

    /**
    /**
     * POST 数据.
     *
     * @return array
     */
    protected function input($request)
    {
        return $request->only([
            'name',
            'identity',
            'status',
        ]);
    }


}
