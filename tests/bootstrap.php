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

error_reporting(-1);

ini_set('xdebug.max_nesting_level', '200');

ini_set('memory_limit', '512M');

$vendorDir = __DIR__.'/../vendor';

require_once __DIR__.'/function.php';

if (false === is_file($vendorDir.'/autoload.php')) {
    throw new Exception('You must set up the project dependencies, run the following commands:
        wget http://getcomposer.org/composer.phar
        php composer.phar install');
}

include $vendorDir.'/autoload.php';

spl_autoload_register(function ($class) {
    if (0 === stripos($class, 'Tests\\')) {
        $path = __DIR__.'/'.strtr(substr($class, 5), '\\', '/').'.php';

        if (true === is_file($path) && true === is_readable($path)) {
            require_once $path;

            return true;
        }
    }
});
