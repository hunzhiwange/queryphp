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

namespace home\domain\listener;

class test2 extends abstracts
{
    public function run()
    {
        print_r(func_get_args());
        // throw new RuntimeException(sprintf('Observer %s must has run method',get_class($this)));
    }
}
