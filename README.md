![](public/images/queryphp.png)

<p align="center">
  <a href="https://github.com/hunzhiwange/queryphp/releases">
    <img alt="Latest Version" src="https://img.shields.io/packagist/vpre/hunzhiwange/queryphp.svg?style=for-the-badge" /></a>
  <a href="https://travis-ci.org/hunzhiwange/queryphp">
    <img alt="Build Status" src="https://img.shields.io/travis/hunzhiwange/queryphp.svg?style=for-the-badge" /></a>
  <a href="https://secure.php.net/">
    <img alt="Php Version" src="https://img.shields.io/packagist/php-v/hunzhiwange/queryphp.svg?style=for-the-badge" /></a>
  <a href="http://opensource.org/licenses/MIT">
    <img alt="QueryPHP License" src="https://img.shields.io/packagist/l/hunzhiwange/queryphp.svg?style=for-the-badge" /></a>
</p>


# The QueryPHP Application

QueryPHP is a powerful PHP framework for code poem as free as wind. [Query Yet Simple]

QueryPHP was founded in 2010 and released the first version on 2010.10.03.

QueryPHP was based on the DoYouHaoBaby framework，we have a large code refactoring.

## Optional C Extension

<p>
  <a href="https://github.com/hunzhiwange/queryyetsimple">
    <img alt="Queryyetsimple Version" src="https://img.shields.io/badge/queryyyetsimple-%3E=1.0.0-brightgreen.svg" /></a>
  <a href="http://pecl.php.net/package/swoole">
    <img alt="Swoole Version" src="https://img.shields.io/badge/swoole-%3E=2.1.1-brightgreen.svg" /></a>
  <a href="https://github.com/apache/thrift/tree/master/lib/php">
    <img alt="Thrift Version" src="https://img.shields.io/badge/thrift-%3E=0.10.0-brightgreen.svg" /></a>
  <a href="http://pecl.php.net/package/inotify">
    <img alt="Inotify Version" src="https://img.shields.io/badge/inotify-%3E=2.0.0-brightgreen.svg" /></a>
  <a href="http://pecl.php.net/package/v8js">
    <img alt="V8js Version" src="https://img.shields.io/badge/v8js-%3E=2.1.0-brightgreen.svg" /></a>
</p>

## About DoYouHaoBaby Framework

![](doyouhaobaby.png)

<p>DoYouHaoBaby has a lot of features: MVC, ActiveRecord, i18n, cache, databases, template engine, RBAC, and so on.</p>

<p>DoYouHaoBaby released 0.0.1 version at 2010/10/03, the last version was released in 2014/10 version 3, and now it has stopped maintenance.</p>

## How to install

```
composer create-project hunzhiwange/queryphp myapp
```

## Query Yet Simple To Do Right Things

It is index.php.

```
<?php
/**
 * _____________                           _______________
 *  ______/     \__  _____  ____  ______  / /_  _________
 *   ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
 *    __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
 *      \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
 *         \_\                /_/_/         /_/
 *
 * (c) 2010-2018 http://queryphp.com All rights reserved.
 */

version_compare(PHP_VERSION, '7.1.3', '<') && die('PHP 7.1.3 OR Higher');

$composer = require_once dirname(__DIR__) . '/vendor/autoload.php';
Queryyetsimple\Bootstrap\Project::singletons($composer);
```

## Official Documentation

Documentation for the framework can be found on the [QueryPHP website](http://www.queryphp.com).

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
