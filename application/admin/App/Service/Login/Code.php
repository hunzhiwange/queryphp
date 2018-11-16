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

namespace Admin\App\Service\Login;

use Leevel\Seccode\Seccode;
use Leevel;
use Leevel\Cache;

/**
 * 验证码生成.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Code
{
    /**
     * 响应方法.
     *
     * @param array  $input
     */
    public function handle(array $input)
    {
        $seccode = new Seccode([
            'background_path' => Leevel::commonPath('ui/seccode/background'),
            'font_path'       => Leevel::commonPath('ui/seccode/font'),
            'width'  => 120,
            'height' => 36,
        ]);

        $seccode->display(4);

        Cache::set('code_'.$input['id'], $seccode->getCode());

        die;
    }
}
