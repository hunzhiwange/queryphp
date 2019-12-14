<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Infra\Exception;

use App;
use Leevel\Kernel\Exception\BusinessException as BaseBusinessException;

/**
 * 业务操作异常.
 *
 * - 业务异常与系统异常不同，一般不需要捕捉写入日志.
 * - 核心业务异常可以记录日志.
 */
class BusinessException extends BaseBusinessException
{
    /**
     * 上报日志.
     */
    public function report(): void
    {
        if ($this->getImportance() < 1) {
            return;
        }

        /** @var \Leevel\Log\ILog $log */
        $log = App::make('log');
        $log->error($this->getMessage(), ['exception' => (string) $this]);
        $log->flush();
    }
}
