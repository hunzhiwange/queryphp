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

## 如何安装

## 基本使用

```
composer create-project hunzhiwange/queryphp myapp
```

## 打开浏览器访问

![](../images/index.jpg)

```
php leevel server <Visite http://127.0.0.1:9527/>
```

- Home http://127.0.0.1:9527/

## 连接数据库

### 首先创建一个数据库.

```
CREATE DATABASE IF NOT EXISTS myapp DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
```

### 修改 .env

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

### 执行数据库迁移命令

```diff
- $php leevel migrate:migrate
- $php leevel migrate:migrate --environment=data
- $php leevel migrate:migrate --environment=common
+ $composer migrate
+ $composer migrate-data
+ $composer migrate-common
$php leevel server
```

## 运行测试

### 首先创建一个用于测试的数据库 test.

```
CREATE DATABASE IF NOT EXISTS test DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
```

### 修改 .env.phpunit

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

### 执行数据库迁移命令

```diff
- $php leevel migrate:migrate --env=env.phpunit
+ $composer migrate-phpunit
- $php leevel migrate:migrate --env=env.phpunit --environment=common
+ $composer migrate-phpunit-common
```

### 运行

```diff
$cd /data/codes/queryphp/
$vim .env.phpunit # modify database redis and other
- $php leevel migrate:migrate -e env.phpunit
+ $composer migrate-phpunit
+ $php build/phpunit
+ $composer test
+ $composer test-coverage
```

## 生产环境优化

### 关闭调试

修改 .env

```
// Environment production、testing and development
ENVIRONMENT = production

// Debug
DEBUG = false
DEBUG_JSON = false 
DEBUG_CONSOLE = false
DEBUG_JAVASCRIPT = false
```

### 执行优化指令

下面的指令可以让 QueryPHP 运行得更加快速。

```
php leevel router:cache
php leevel config:cache
php leevel i18n:cache
php leevel view:cache
php leevel autoload (Equivalent to `composer dump-autoload --optimize --no-dev`)
```

或者

```
php leevel production
```

## 开发阶段

### 打开调试

修改 .env 或者 bootstrap/config.php.

```
// Environment production、testing and development
ENVIRONMENT = development

// Debug
DEBUG = true 
DEBUG_JSON = true 
DEBUG_CONSOLE = true
DEBUG_JAVASCRIPT = true
```

### 清理缓存指令

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

## RoadRunner 支持

RoadRunner 是一个开源的高性能 PHP 应用服务器、负载均衡器和流程管理器。它支持作为一个服务运行，能够在每个项目的基础上扩展其功能。

### 安装 RoadRunner

你可以下载二进制文件.

```
cd /data/server
wget https://github.com/spiral/roadrunner/releases/download/v2.12.1/roadrunner-2.12.1-darwin-amd64.zip
unzip roadrunner-2.12.1-darwin-amd64.zip
cd /data/codes/queryphp
```

安装依赖包

```          
composer require spiral/roadrunner ^2.12.1              
composer require spiral/dumper ^2.14.1.                 
composer require symfony/psr-http-message-bridge ^2.0  
composer require nyholm/psr7 ^1.5  
```

### RoadRunner 服务

```
/data/server/roadrunner-2.12.1-darwin-amd64/rr serve
/data/server/roadrunner-2.12.1-darwin-amd64/rr http:reset
```

RoadRunner 和 php-fpm 保持一致

```
root@vagrant-ubuntu-10-0-2-5:/data/codes/queryphp# /data/server/roadrunner-2.12.1-darwin-amd64/rr serve
2022-12-10T16:43:30.226+0800	DEBUG	rpc         	plugin was started	{"address": "tcp://127.0.0.1:6001", "list of the plugins with RPC methods:": ["app", "informer", "resetter"]}
```

## 统一团队代码风格

### 安装 PHP 代码格式化工具

<https://github.com/friendsofphp/php-cs-fixer>

不需要安装即可使用，我们已经下载了版本。

### 基本使用

```diff
$cd /data/codes/queryphp
- $php-cs-fixer fix --config=.php_cs.dist
+ $php build/php-cs-fixer fix --config=.php_cs.dist
+ $composer php-cs-fixer
```

### 使用 Git 钩子

添加一个 pre-commit 钩子.

```
cp build/pre-commit.sh .git/hooks/pre-commit
chmod 777 .git/hooks/pre-commit
```

跳过钩子

```
# git commit -h
# git commit -n -m 'pass hook' #bypass pre-commit and commit-msg hooks
```

## PHPStan 静态分析

```diff
- $php build/phpstan analyse
+ $composer phpstan
```

## 版权协议

QueryPHP 是一个基于 [MIT license](http://opensource.org/licenses/MIT) 授权许可协议的开源软件.
