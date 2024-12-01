```
_____________                           _______________
 ______/     \__  _____  ____  ______  / /_  _________
  ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
   __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
     \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
        \_\                /_/_/         /_/
```

<p align="center">
    <a href="./MORE.md">English</a> | <a href="./MORE-zh-CN.md">中文</a>
</p>

## How to install

## Base use

```
composer create-project hunzhiwange/queryphp myapp
```

## Visite it

![](../images/index.jpg)

```
php leevel server <Visite http://127.0.0.1:9527/>
```

- Home http://127.0.0.1:9527/

## Connect database

### First to create a database.

```
CREATE DATABASE IF NOT EXISTS myapp DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
```

### Then modify .env

```
vim .env

...
# Database
DATABASE_DRIVER = mysql
DATABASE_HOST = 127.0.0.1
DATABASE_PORT = 3307
DATABASE_NAME = apiql_data1
DATABASE_NAME_PREFIX = apiql_data
DATABASE_USER = root
DATABASE_PASSWORD = 123456

# Common database
DATABASE_COMMON_DRIVER = mysql
DATABASE_COMMON_HOST = 127.0.0.1
DATABASE_COMMON_PORT = 3307
DATABASE_COMMON_NAME = apiql_common
DATABASE_COMMON_NAME_PREFIX = apiql_common
DATABASE_COMMON_USER = root
DATABASE_COMMON_PASSWORD = 123456
...

```

### Migrate

```diff
- $php leevel migrate:migrate
- $php php leevel migrate:migrate --environment=data
- php leevel migrate:migrate --environment=common
+ $composer migrate
+ $composer migrate-data
+ $composer migrate-common
$php leevel server
```

## Run Tests

### First to create a test database.

```
CREATE DATABASE IF NOT EXISTS test DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
```

### Then modify .env.phpunit

```
vim .env.phpunit

...
# Database
DATABASE_DRIVER = mysql
DATABASE_HOST = 127.0.0.1
DATABASE_PORT = 3307
DATABASE_NAME = apiql_data1
DATABASE_NAME_PREFIX = apiql_data
DATABASE_USER = root
DATABASE_PASSWORD = 123456

# Common database
DATABASE_COMMON_DRIVER = mysql
DATABASE_COMMON_HOST = 127.0.0.1
DATABASE_COMMON_PORT = 3307
DATABASE_COMMON_NAME = apiql_common
DATABASE_COMMON_NAME_PREFIX = apiql_common
DATABASE_COMMON_USER = root
DATABASE_COMMON_PASSWORD = 123456
...

```

### Migrate

```diff
- php leevel migrate:migrate --env=env.phpunit
+ $composer migrate-phpunit
- php leevel migrate:migrate --env=env.phpunit --environment=common
+ $composer migrate-phpunit-common
```

### Run

```diff
$cd /data/codes/queryphp/
$vim .env.phpunit # modify database redis and other
- $php leevel migrate:migrate -e env.phpunit
+ $composer migrate-phpunit
+ $php build/phpunit 
+ $composer test
+ $composer test-coverage
```

## Production optimization

### Close Debug

Modify .env or bootstrap/config.php.

```
// Environment production、testing and development
ENVIRONMENT = production

// Debug
DEBUG = false
DEBUG_JSON = false 
DEBUG_CONSOLE = false
DEBUG_JAVASCRIPT = false
```

### Optimize Commands

The commands below can make queryphp faster.

```
php leevel router:cache
php leevel config:cache
php leevel i18n:cache
php leevel view:cache
php leevel autoload (Equivalent to `composer dump-autoload --optimize --no-dev`)
```

Or

```
php leevel production
```

## Development

### Open Debug

Modify .env or bootstrap/config.php.

```
// Environment production、testing and development
ENVIRONMENT = development

// Debug
DEBUG = true
DEBUG_JSON = true 
DEBUG_CONSOLE = true
DEBUG_JAVASCRIPT = true
```

### Clears Commands

```
php leevel i18n:clear
php leevel log:clear
php leevel config:clear
php leevel router:clear
php leevel session:clear
php leevel view:clear
php leevel autoload --dev (Equivalent to `composer dump-autoload --optimize`)
```

Or

```
php leevel development
```

## RoadRunner Supported

RoadRunner is an open source high-performance PHP application server, load balancer and process manager. It supports running as a service with the ability to extend its functionality on a per-project basis.

### Install RoadRunner

You can download the binary file.

```
cd /data/server
wget https://github.com/spiral/roadrunner/releases/download/2.12.1/roadrunner-1.8.2-darwin-amd64.zip
unzip roadrunner-2.12.1-darwin-amd64.zip
cd /data/codes/queryphp
```

Install dependency package

```          
composer require spiral/roadrunner ^2.12.1              
composer require spiral/dumper ^2.14.1.                 
composer require symfony/psr-http-message-bridge ^2.0  
composer require nyholm/psr7 ^1.5  
```

### RoadRunner server

```
/data/server/roadrunner-2.12.1-darwin-amd64/rr serve
/data/server/roadrunner-2.12.1-darwin-amd64/rr http:reset
```

The same with php-fpm

```
root@vagrant-ubuntu-10-0-2-5:/data/codes/queryphp# /data/server/roadrunner-2.12.1-darwin-amd64/rr serve
2022-12-10T16:43:30.226+0800	DEBUG	rpc         	plugin was started	{"address": "tcp://127.0.0.1:6001", "list of the plugins with RPC methods:": ["app", "informer", "resetter"]}
```

## Unified Code Style

### Install PHP Coding Standards Fixer

<https://github.com/friendsofphp/php-cs-fixer>

It can be used without installation,we download a version for you.

### Base use

```diff
$cd /data/codes/queryphp
- $php-cs-fixer fix --config=.php_cs.dist
+ $php build/php-cs-fixer fix --config=.php_cs.dist
+ $composer php-cs-fixer
```

### With Git hooks

Add a pre-commit for it.

```
cp build/pre-commit.sh .git/hooks/pre-commit
chmod 777 .git/hooks/pre-commit
```

Pass hook

```
# git commit -h
# git commit -n -m 'pass hook' #bypass pre-commit and commit-msg hooks
```

## PHPStan 

```diff
- $php build/phpstan analyse
+ $composer phpstan
```

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
