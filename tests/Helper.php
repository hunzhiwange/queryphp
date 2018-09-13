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

namespace Tests;

/**
 * 助手方法.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.08.26
 *
 * @version 1.0
 */
trait Helper
{
    protected function varExport(array $data, ?string $method = null)
    {
        $traceDir = dirname(__DIR__).'/runtime/tests';

        if (!is_dir($traceDir)) {
            mkdir($traceDir, 0777, true);
        }

        file_put_contents(
            $trace.'/'.sprintf('%s:%s.export.log', $method, str_replace('\\', '_', static::class)),
            $result = var_export($data, true)
        );

        return $result;
    }

    protected function varJsonEncode(array $data, ?string $method = null)
    {
        $traceDir = dirname(__DIR__).'/runtime/tests';

        if (!is_dir($traceDir)) {
            mkdir($traceDir, 0777, true);
        }

        file_put_contents(
            $traceDir.'/'.sprintf('%s:%s.jsonencode.log', $method, str_replace('\\', '_', static::class)),
            $result = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );

        return $result;
    }
}
