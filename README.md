![](public/images/queryphp.png)

<p align="center">
  <a href="https://github.com/hunzhiwange/queryphp/releases">
    <img alt="Latest Version" src="https://img.shields.io/badge/dev-master-brightgreen.svg?style=for-the-badge" /></a>
  <a href="https://travis-ci.org/hunzhiwange/queryphp">
    <img alt="Build Status" src="https://travis-ci.org/hunzhiwange/queryphp.svg?branch=master" /></a>
  <a href="https://secure.php.net/">
    <img alt="Php Version" src="https://img.shields.io/packagist/php-v/hunzhiwange/queryphp.svg?style=for-the-badge" /></a>
  <a href="https://github.com/swoole/swoole-src">
    <img alt="Swoole Version" src="https://img.shields.io/badge/swoole-%3E=2.1.1-brightgreen.svg?style=for-the-badge" /></a>
  <a href="https://github.com/hunzhiwange/queryphp/blob/master/LICENSE">
    <img alt="QueryPHP License" src="https://img.shields.io/packagist/l/hunzhiwange/queryphp.svg?style=for-the-badge" /></a>
</p>

# The QueryPHP Application

QueryPHP is a powerful PHP framework for code poem as free as wind. [Query Yet Simple]

QueryPHP was founded in 2010 and released the first version on 2010.10.03.

## Query Yet Simple

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

version_compare(PHP_VERSION, '7.1.0', '<') && die('PHP 7.1.0 OR Higher');

$composer = require_once dirname(__DIR__) . '/vendor/autoload.php';
Queryyetsimple\Bootstrap\Project::singletons($composer);
```

## Official Documentation

Documentation for the framework can be found on the [QueryPHP website](http://www.queryphp.com).

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
