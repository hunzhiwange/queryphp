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

QueryPHP was based on the DoYouHaoBaby framework.

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

## About The Old DoYouHaoBaby Framework

![](doyouhaobaby.png)

<p>DoYouHaoBaby 具备了大量丰富的特性: 包括 MVC、ActiveRecord、国际化语言包、缓存组件、主从数据库、模式扩展、模板引擎、RBAC 权限扩展等等。</p>

<p>DoYouHaoBaby 主要用于 WindsForce 社区（停止维护）、Dyhb-blog-x（停止维护）、114.MS 家居装修网（已挂停止维护）等自主产品的开发。</p>

<p>DoYouHaoBaby 于 2010/10/03 发布 0.0.1 版本，最后版本于 2014/10 发布 3.0 版本，感觉功能已经够自己用了并进入停止开发阶段。</p>

<p align="right">小牛哥 2014.10 @ HTTP://DoYouHaoBaby.NET</p>

## How to install

```
composer create-project hunzhiwange/queryphp myapp
```

## Query Yet Simple TO Do Right Things

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

version_compare(PHP_VERSION, '7.1.3', '<') && die('PHP 7.1.0 OR Higher');

$composer = require_once dirname(__DIR__) . '/vendor/autoload.php';
Queryyetsimple\Bootstrap\Project::singletons($composer);
```

## Official Documentation

Documentation for the framework can be found on the [QueryPHP website](http://www.queryphp.com).

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
