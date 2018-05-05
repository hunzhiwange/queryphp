<?php declare(strict_types=1);

namespace home\domain\listener;

class test2 extends abstracts
{
    public function run()
    {
        print_r(func_get_args());
        // throw new RuntimeException(sprintf('Observer %s must has run method',get_class($this)));
    }
}
