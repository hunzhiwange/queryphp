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

namespace admin\app\controller\position;

use admin\app\controller\aaction;
use admin\domain\service\admin_position\enables as service;
use admin\domain\service\admin_position\enables_failed;
use queryyetsimple\request;

/**
 * 后台职位批量禁用启用.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class enables extends aaction
{
    /**
     * 响应方法.
     *
     * @param \admin\domain\service\admin_position\enables $oService
     *
     * @return mixed
     */
    public function run(service $oService)
    {
        try {
            $mixResult = $oService->run($this->ids(), $this->status());

            return [
                'message' => sprintf('职位%s成功', 'enable' === $this->status() ? '启用' : '禁用'),
            ];
        } catch (enables_failed $oE) {
            return [
                'code'    => 400,
                'message' => $oE->getMessage(),
            ];
        }
    }

    /**
     * 启用禁用状态
     *
     * @return string
     */
    protected function status()
    {
        return trim(request::all('status'));
    }

    /**
     * 批量启用禁用 ID.
     *
     * @return array
     */
    protected function ids()
    {
        return request::all('ids');
    }
}
