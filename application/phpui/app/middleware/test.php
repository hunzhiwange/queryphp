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

namespace home\application\middleware;

/**
 * test.
 *
 * @author your.name <your.email>
 *
 * @since 2017.06.27
 *
 * @version 1.0
 */
class test
{
    /**
     * 请求
     *
     * @param mixed|\queryyetsimple\request $mixRequest
     *
     * @return mixed
     */
    public function handle($mixRequest)
    {
        // echo 'sdfsdfsdf';
        $mixRequest->setUrl('333333333');

        return $mixRequest;
    }

    /**
     * 响应.
     *
     * @param mixed|\queryyetsimple\response $mixResponse
     *
     * @return mixed
     */
    public function terminate($mixResponse)
    {
        return $mixResponse;
    }
}
