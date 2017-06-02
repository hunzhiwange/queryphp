<?php

namespace home\application\job;

class my_job {
    public function handle($arrArgs) {
        // sleep(4);
        // print_r($arrArgs);
        fwrite(STDOUT, json_encode($arrArgs)."\n\r");
        fwrite ( STDOUT, 'hello my job22!' . "\n\r" );
    }
}
