<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\user;

use queryyetsimple\http\request;
use queryyetsimple\bootstrap\auth\login;

/**
 * 解锁验证密码
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.12.06
 * @version 1.0
 */
class unlock
{
    use login;

    /**
     * HTTP REQUEST
     *
     * @var \queryyetsimple\http\request
     */
    protected $oRequest;

    /**
     * 构造函数
     *
     * @param \queryyetsimple\http\request $oRequest
     * @return void
     */
    public function __construct(request $oRequest)
    {
        $this->oRequest = $oRequest;
    }

    /**
     * 响应方法
     *
     * @param string $strName
     * @param string $strPassword
     * @return \queryyetsimple\http\response|array
     */
    public function run($strName, $strPassword)
    {
        $this->request($strName, $strPassword);
        return $this->unlock($this->oRequest);
    }

    /**
     * 设置 request 数据
     *
     * @param string $strName
     * @param string $strPassword
     * @return void
     */
    protected function request($strName, $strPassword)
    {
        $this->oRequest->setPuts(
            [
                'name' => trim($strName),
                'password' => trim($strPassword)
            ]
        );
    }
}
