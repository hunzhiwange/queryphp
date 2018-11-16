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

//namespace admin\app\controller\position;

namespace Admin\App\Controller\Resource;

use Admin\App\Service\Resource\Destroy as service;
use Leevel\Http\Request;

/**
 * 后台职位删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Destroy// extends aaction
{
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

        //var_dump();

        return $service->handle($this->input($request)/**//*, $this->code($oCode)*/);


       // var_dump($result);
        // $this->oStatus = $oStatus;

        //$mixResult = $oService->run($this->data());
        //$mixResult = $mixResult->toArray();
       
        //$mixResult['message'] = __('职位分类保存成功');

      //  return $result;
    }

    // /**
    //  * 响应方法.
    //  *
    //  * @param \admin\app\service\position\destroy $oService
    //  *
    //  * @return mixed
    //  */
    // public function run(service $oService)
    // {
    //     try {
    //         $mixResult = $oService->run($this->id());

    //         return [
    //             'message' => '职位删除成功',
    //         ];
    //     } catch (destroy_failed $oE) {
    //         return [
    //             'code'    => 400,
    //             'message' => $oE->getMessage(),
    //         ];
    //     }
    // }

    /**
     * 删除 ID.
     *
     * @return int
     */
    protected function input($request)
    {
        return ['id' => (int) ($request->params->get('_param0'))];
    }
}
