<?php declare(strict_types=1);

namespace home\application\validate;

use Excption;

class test
{
    public function test2($arrArgs)
    {
        print_r(func_get_args());
        return true;
    }
}
