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

namespace admin\app\service\user;

use queryyetsimple\bootstrap\auth\login;
use queryyetsimple\http\request;

/**
 * 解锁验证密码
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.12.06
 *
 * @version 1.0
 */
class unlock
{
    use login;

    /**
     * HTTP REQUEST.
     *
     * @var \queryyetsimple\http\request
     */
    protected $oRequest;

    /**
     * 构造函数.
     *
     * @param \queryyetsimple\http\request $oRequest
     */
    public function __construct(request $oRequest)
    {
        $this->oRequest = $oRequest;
    }

    /**
     * 响应方法.
     *
     * @param string $strName
     * @param string $strPassword
     *
     * @return array|\queryyetsimple\http\response
     */
    public function run($strName, $strPassword)
    {
        $this->request($strName, $strPassword);

        return $this->unlock($this->oRequest);
    }

    /**
     * 设置 request 数据.
     *
     * @param string $strName
     * @param string $strPassword
     */
    protected function request($strName, $strPassword)
    {
        $this->oRequest->setPuts(
            [
                'name'     => trim($strName),
                'password' => trim($strPassword),
            ]
        );
    }
}
