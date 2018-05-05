<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\controller\position;

use queryyetsimple\request;
use admin\app\controller\aaction;
use admin\app\service\position\destroy_failed;
use admin\app\service\position\destroy as service;

/**
 * 后台职位删除
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.23
 * @version 1.0
 */
class destroy extends aaction
{

    /**
     * 响应方法
     *
     * @param \admin\app\service\position\destroy $oService
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->id());
            return [
                'message' => '职位删除成功'
            ];
        } catch (destroy_failed $oE) {
            return [
                'code' => 400,
                'message' => $oE->getMessage()
            ];
        }
    }

    /**
     * 删除 ID
     *
     * @return int
     */
    protected function id()
    {
        return intval(request::all('args\0'));
    }
}
