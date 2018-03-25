![](public/images/queryphp.png)

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
 */

version_compare(PHP_VERSION, '7.1.0', '<') && die('PHP 7.1.0 OR Higher');

$composer = require_once dirname(__DIR__) . '/vendor/autoload.php';
Queryyetsimple\Bootstrap\Project::singletons($composer);
```

## Official Documentation

Documentation for the framework can be found on the [QueryPHP website](http://www.queryphp.com).

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
