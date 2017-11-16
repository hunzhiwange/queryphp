<?php

namespace home\application\job;

use Excption;

class my_job
{
    public function handle($arrArgs)
    {
        // sleep(4);
        // print_r($arrArgs);
        //
        // dump(func_get_args());


        //fwrite(STDOUT, json_encode($arrArgs)."\n\r");
        fwrite(STDOUT, 'hello my job22!' . "\n\r");

        throw new \Exception('s');
    }
    public function failed()
    {
        fwrite(STDOUT, 'failed' . "\n\r");
    }
}
