<p align="center">
  <a href="https://queryphp.com">
    <img src="./queryphp.png" />
  </a>
</p>

<p align="center">
  <a href='https://packagist.org/packages/hunzhiwange/queryphp'><img src='http://img.shields.io/packagist/v/hunzhiwange/queryphp.svg' alt='Latest Stable Version' /></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-%3E%3D%208.0.0-8892BF.svg" alt="Minimum PHP Version"></a>
  <a href="https://www.swoole.com/"><img src="https://img.shields.io/badge/Swoole-%3E%3D%204.5.9-008de0.svg" alt="Minimum Swoole Version"></a>
  <a href="https://github.com/spiral/roadrunner"><img alt="RoadRunner Version" src="https://img.shields.io/badge/RoadRunner-%3E=1.8.2-brightgreen.svg" /></a>
  <a href="http://opensource.org/licenses/MIT">
    <img alt="QueryPHP License" src="https://poser.pugx.org/hunzhiwange/queryphp/license.svg" /></a>
  <br />
  <a href="https://github.styleci.io/repos/78216574"><img src="https://github.styleci.io/repos/78216574/shield?branch=master" alt="StyleCI"></a>
  <a href='https://www.queryphp.com/docs/'><img src='https://img.shields.io/badge/docs-passing-green.svg?maxAge=2592000' alt='QueryPHP Doc' /></a>
  <a href="https://github.com/hunzhiwange/queryphp/actions">
    <img alt="Build Status" src="https://github.com/hunzhiwange/queryphp/workflows/tests/badge.svg" /></a>
  <a href="https://codecov.io/gh/hunzhiwange/queryphp">
    <img src="https://codecov.io/gh/hunzhiwange/queryphp/branch/master/graph/badge.svg?token=D4WV1IC2R3"/>
  </a>
</p>

<p align="center">
  <a href="https://github.com/hunzhiwange/framework"><b>The Core Framework</b></a>
  <br />
  <a href="https://github.com/hunzhiwange/framework/actions">
    <img alt="Build Status" src="https://github.com/hunzhiwange/framework/workflows/tests/badge.svg" /></a>
  <a href="https://codecov.io/gh/hunzhiwange/framework">
    <img src="https://codecov.io/gh/hunzhiwange/framework/branch/master/graph/badge.svg?token=GMWV1X9F7T"/>
  </a>
</p>

<p align="center">
    <a href="./README.md">English</a> | <a href="./README-zh-CN.md">中文</a>
</p>

# The QueryPHP Application

> This is the QueryPHP application, the core framework can be found here [Framework](https://github.com/hunzhiwange/framework).

QueryPHP is a modern, high performance PHP progressive framework, to provide a stable and reliable high-quality enterprise level framework as its historical mission. **<span style="color:#e82e7d;">USE LEEVEL DO BETTER</span>**

*The PHP Framework For Code Poem As Free As Wind*

* Site: <https://www.queryphp.com/>
* China Mirror Site: <https://queryphp.gitee.io/>
* Documentation: <https://www.queryphp.com/docs/>

![](doyouhaobaby.png)

QueryPHP was based on the [DoYouHaoBaby](https://github.com/hunzhiwange/dyhb.blog-x/tree/master/Upload/DoYouHaoBaby) framework which released 0.0.1 version at 2010.10.03,the latest version of DoYouHaoBaby is renamed as [QeePHP](https://github.com/hunzhiwange/windsforce/tree/master/upload/System/include/QeePHP).

## The core packages

 * QueryPHP On Github: <https://github.com/hunzhiwange/queryphp/>
 * QueryPHP On Gitee: <https://gitee.com/dyhb/queryphp/>
 * Framework On Github: <https://github.com/hunzhiwange/framework/>
 * Framework On Gitee: <https://gitee.com/dyhb/framework/>
 * Packages: <https://github.com/leevels/>
 * Packages From Hunzhiwange: <https://packagist.org/packages/hunzhiwange/>
 * Packages From Leevel: <https://packagist.org/packages/leevel/>


## Sponsor

<h3 align="center">Gold Sponsors</h3>

<table>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        <a href="https://www.jetbrains.com/?from=queryphp" target="_blank">
          <img width="100px" src="./jetbrains.svg" />
        </a>
      </td>
    </tr>
    <tr></tr>
  </tbody>
</table>

## How to install

## Base use

```
composer create-project hunzhiwange/queryphp myapp
```

## Visite it

![](index.jpg)

```
php leevel server <Visite http://127.0.0.1:9527/>
```

 * Home <http://127.0.0.1:9527/>
 * MVC router <http://127.0.0.1:9527/api/test>
 * MVC restful router http://127.0.0.1:9527/restful/123
 * MVC restful router with method http://127.0.0.1:9527/restful/123/show
 * Annotation api router http://127.0.0.1:9527/api/v1/demo/liu
 * Annotation web router http://127.0.0.1:9527/web/v2/demo
 * php leevel link:public <http://127.0.0.1:9527/public/css/page.css>
 * php leevel link:storage <http://127.0.0.1:9527/storage/logo.png>
 * php leevel link:apis <http://127.0.0.1:9527/apis/>
 * php leevel link:debugbar <http://127.0.0.1:9527/debugbar/debugbar.css>

## Connect database

### First to create a database.

```
CREATE DATABASE IF NOT EXISTS myapp DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
```

### Then modify .env

```
vim .env

...
// Database
DATABASE_DRIVER = mysql
DATABASE_HOST = 127.0.0.1
DATABASE_PORT = 3306
DATABASE_NAME = queryphp_development_db
DATABASE_USER = root
DATABASE_PASSWORD =
...

to

...
// Database
DATABASE_DRIVER = mysql
DATABASE_HOST = 127.0.0.1
DATABASE_PORT = 3306
DATABASE_NAME = myapp
DATABASE_USER = root
DATABASE_PASSWORD = 123456
...

```

### Migrate

```diff
- $php leevel migrate:migrate
+ $composer migrate
$php leevel server
```

### Test with database

<http://127.0.0.1:9527/api/entity>

```
{
    count: 4,
    :trace: {
        ...
    }
}
```

## Login to QueryVue

### Install frontend

First to install the frontend,see more detail on `frontend/README.md`.

```
cd frontend
npm install -g cnpm --registry=https://registry.npm.taobao.org // Just once
cnpm install
npm run serve # npm run dev
```

### Login

Then visite it. <http://127.0.0.1:9528/#/login>

```
user: admin
password: 123456
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
// Database
DATABASE_DRIVER = mysql
DATABASE_HOST = 127.0.0.1
DATABASE_PORT = 3306
DATABASE_NAME = test
DATABASE_USER = root
DATABASE_PASSWORD =
...

to

...
// Database
DATABASE_DRIVER = mysql
DATABASE_HOST = 127.0.0.1
DATABASE_PORT = 3306
DATABASE_NAME = test
DATABASE_USER = root
DATABASE_PASSWORD = 123456
...

```

### Migrate

```diff
- $php leevel migrate:migrate -e env.phpunit
+ $composer migrate-phpunit
```

### Run

```diff
_____________                           _______________
 ______/     \__  _____  ____  ______  / /_  _________
  ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
   __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
     \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
        \_\                /_/_/         /_/

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

Modify .env or bootstrap/option.php.

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
php leevel option:cache
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

Modify .env or bootstrap/option.php.

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
php leevel option:clear
php leevel router:clear
php leevel session:clear
php leevel view:clear
php leevel autoload --dev (Equivalent to `composer dump-autoload --optimize`)
```

Or

```
php leevel development
```

## Use Swoole With Ultra High Performance

### Http server

```
php leevel http:server # php leevel http:server -d
php leevel http:reload
php leevel http:stop
php leevel http:status
```

The same with php-fpm

```
root@vagrant-ubuntu-10-0-2-5:/data/codes/queryphp# php leevel http:server
_____________                           _______________
 ______/     \__  _____  ____  ______  / /_  _________
  ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
   __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
     \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
        \_\                /_/_/         /_/

                     HTTP SERVER

+-----------------------+---------------------------------+
| Item                  | Value                           |
+-----------------------+---------------------------------+
| host                  | 0.0.0.0                         |
| port                  | 9527                            |
| process_name          | leevel.http                     |
| pid_path              | @path/runtime/protocol/http.pid |
| worker_num            | 8                               |
| daemonize             | 0                               |
| enable_static_handler | 1                               |
| document_root         | @path/www                       |
| task_worker_num       | 4                               |
+-----------------------+---------------------------------+
```

 * Home http://127.0.0.1:9527/
 * MVC router http://127.0.0.1:9527/api/test
 * MVC restful router http://127.0.0.1:9527/restful/123
 * MVC restful router with method http://127.0.0.1:9527/restful/123/show
 * Annotation api router http://127.0.0.1:9527/api/v1/demo/liu
 * Annotation web router http://127.0.0.1:9527/web/v2/demo
 * php leevel link:public http://127.0.0.1:9527/public/css/page.css
 * php leevel link:storage http://127.0.0.1:9527/storage/logo.png
 * php leevel link:apis http://127.0.0.1:9527/apis/
 * php leevel link:debugbar http://127.0.0.1:9527/debugbar/debugbar.css

### Websocket server

```
php leevel websocket:server # php leevel websocket:server -d
php leevel websocket:reload
php leevel websocket:stop
php leevel websocket:status
```

A chat room demo

```
root@vagrant-ubuntu-10-0-2-5:/data/codes/queryphp# php leevel websocket:server
_____________                           _______________
 ______/     \__  _____  ____  ______  / /_  _________
  ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
   __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
     \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
        \_\                /_/_/         /_/

                  WEBSOCKET SERVER

+-----------------+--------------------------------------+
| Item            | Value                                |
+-----------------+--------------------------------------+
| host            | 0.0.0.0                              |
| port            | 9502                                 |
| process_name    | leevel.websocket                     |
| pid_path        | @path/runtime/protocol/websocket.pid |
| worker_num      | 8                                    |
| daemonize       | 0                                    |
| task_worker_num | 4                                    |
+-----------------+--------------------------------------+
```

Visite <http://127.0.0.1:9527/websocket/chat>

## RoadRunner Supported

RoadRunner is an open source high-performance PHP application server, load balancer and process manager. It supports running as a service with the ability to extend its functionality on a per-project basis.

### Install RoadRunner

You can download the binary file.

```
cd /data/server
wget https://github.com/spiral/roadrunner/releases/download/v1.8.2/roadrunner-1.8.2-darwin-amd64.zip
unzip roadrunner-1.8.2-darwin-amd64.zip
cd /data/codes/queryphp
```

### RoadRunner server

```
/data/server/roadrunner-1.8.2-darwin-amd64/rr serve -d -v # -d = debug
/data/server/roadrunner-1.8.2-darwin-amd64/rr http:reset
/data/server/roadrunner-1.8.2-darwin-amd64/rr http:workers -i
```

The same with php-fpm

```
root@vagrant-ubuntu-10-0-2-5:/data/codes/queryphp# /data/server/roadrunner-1.8.2-darwin-amd64/rr serve -d -v
DEBU[0000] [static]: disabled
DEBU[0000] [rpc]: started
DEBU[0000] [http]: started
INFO[0060] 127.0.0.1 {23.1ms} 200 GET http://127.0.0.1:9527/api/test
```

 * Home http://127.0.0.1:9527/
 * MVC router http://127.0.0.1:9527/api/test
 * MVC restful router http://127.0.0.1:9527/restful/123
 * MVC restful router with method http://127.0.0.1:9527/restful/123/show
 * Annotation api router http://127.0.0.1:9527/api/v1/demo/liu
 * Annotation web router http://127.0.0.1:9527/web/v2/demo
 * php leevel link:public http://127.0.0.1:9527/public/css/page.css
 * php leevel link:storage http://127.0.0.1:9527/storage/logo.png
 * php leevel link:apis http://127.0.0.1:9527/apis/
 * php leevel link:debugbar http://127.0.0.1:9527/debugbar/debugbar.css


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

## Thanks

Thanks for these excellent projects, we have absorbed a lot of excellent design and ideas, standing on the shoulders of giants for innovation.

Thanks to my lover JiaoJiao Xiong's support in the development process of the project for several years, so that I have more creative time and worry free. Thanks to Fei Mao, SiGui Zhao and other technical personnel for their help.

 * QeePHP: <https://github.com/dualface/qeephp2_x/>
 * Swoole: <https://github.com/swoole/>
 * JeCat: <https://github.com/JeCat/>
 * ThinkPHP: <https://github.com/top-think/>
 * Laravel: <https://github.com/laravel/>
 * Symfony: <https://github.com/symfony/>
 * Doctrine: <https://github.com/doctrine/>
 * Phalcon: <https://github.com/phalcon/>
 * Swoft: <https://github.com/swoft-cloud/>

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
