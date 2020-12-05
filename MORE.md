<p align="center">
```
_____________                           _______________
 ______/     \__  _____  ____  ______  / /_  _________
  ____/ __   / / / / _ \/ __`\/ / __ \/ __ \/ __ \___
   __/ / /  / /_/ /  __/ /  \  / /_/ / / / / /_/ /__
     \_\ \_/\____/\___/_/   / / .___/_/ /_/ .___/
        \_\                /_/_/         /_/
```
</p>

<p align="center">
    <a href="./MORE.md">English</a> | <a href="./MORE-zh-CN.md">中文</a>
</p>

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

- Home http://127.0.0.1:9527/
- MVC router http://127.0.0.1:9527/api/test
- MVC restful router http://127.0.0.1:9527/restful/123
- MVC restful router with method http://127.0.0.1:9527/restful/123/show
-  Annotation api router http://127.0.0.1:9527/api/v1/demo/liu
- Annotation web router http://127.0.0.1:9527/web/v2/demo
- php leevel link:public http://127.0.0.1:9527/public/css/page.css
- php leevel link:storage http://127.0.0.1:9527/storage/logo.png
- php leevel link:apis http://127.0.0.1:9527/apis/
- php leevel link:debugbar http://127.0.0.1:9527/debugbar/debugbar.css

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
