<?php

declare(strict_types=1);

error_reporting(E_ALL);

ini_set('xdebug.max_nesting_level', '200');
ini_set('memory_limit', '512M');

$vendorDir = __DIR__.'/../vendor';
require_once __DIR__.'/function.php';

if (false === is_file($vendorDir.'/autoload.php')) {
    throw new Exception('You must set up the app dependencies, run the following commands:
        wget http://getcomposer.org/composer.phar
        php composer.phar install');
}

$composer = include $vendorDir.'/autoload.php';
$composer->addPsr4('Tests\\', __DIR__);

if (!class_exists(\PHPUnit\Framework\TestCase::class)) {
    $e = 'If you execute command `composer dump-autoload --optimize --no-dev`,'.
    'then this will not be available.'.PHP_EOL.
    'PHPUnit and PHPStan belongs to development dependence and `composer dump-autoload --optimize` is ok.';

    throw new RuntimeException($e);
}
