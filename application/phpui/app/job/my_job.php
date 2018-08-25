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

namespace home\application\job;

class my_job
{
    public function handle($arrArgs)
    {
        // sleep(4);
        // print_r($arrArgs);
        //
        // dump(func_get_args());

        //fwrite(STDOUT, json_encode($arrArgs)."\n\r");
        fwrite(STDOUT, 'hello my job22!'."\n\r");

        throw new \Exception('s');
    }

    public function failed()
    {
        fwrite(STDOUT, 'failed'."\n\r");
    }
}
