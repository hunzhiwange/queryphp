<?php /* 2018-04-05 00:02:32 */ ?>
<?php return array (
  'auth' => 
  array (
    'default' => 'web',
    'web_default' => 'session',
    'api_default' => 'token',
    'connect' => 
    array (
      'session' => 
      array (
        'driver' => 'session',
        'model' => 'common\\domain\\entity\\user',
        'user_persistence' => 'user_persistence',
        'token_persistence' => 'token_persistence',
        'field' => 'id,name,nikename,email,mobile',
      ),
      'token' => 
      array (
        'driver' => 'token',
        'model' => 'common\\domain\\entity\\user',
        'user_persistence' => 'user_persistence',
        'token_persistence' => 'token_persistence',
        'field' => 'id,name,nikename,email,mobile',
      ),
    ),
  ),
  'app' => 
  array (
    'environment' => 'development',
    'debug' => true,
    'debug_driver' => 'whoops',
    'custom_exception_template' => '',
    'custom_exception_message' => '',
    'namespace' => 
    array (
    ),
    'provider' => 
    array (
      0 => 'Queryyetsimple\\Auth\\Provider\\Register',
      1 => 'Queryyetsimple\\Cache\\Provider\\Register',
      2 => 'Queryyetsimple\\Cookie\\Provider\\Register',
      3 => 'Queryyetsimple\\Database\\Provider\\Register',
      4 => 'Queryyetsimple\\Encryption\\Provider\\Register',
      5 => 'Queryyetsimple\\Event\\Provider\\Register',
      6 => 'Queryyetsimple\\Filesystem\\Provider\\Register',
      7 => 'Queryyetsimple\\I18n\\Provider\\Register',
      8 => 'Queryyetsimple\\Log\\Provider\\Register',
      9 => 'Queryyetsimple\\Mail\\Provider\\Register',
      10 => 'Queryyetsimple\\Mvc\\Provider\\Register',
      11 => 'Queryyetsimple\\Option\\Provider\\Register',
      12 => 'Queryyetsimple\\Page\\Provider\\Register',
      13 => 'Queryyetsimple\\Queue\\Provider\\Register',
      14 => 'Queryyetsimple\\Router\\Provider\\Register',
      15 => 'Queryyetsimple\\Session\\Provider\\Register',
      16 => 'Queryyetsimple\\Swoole\\Provider\\Register',
      17 => 'Queryyetsimple\\Throttler\\Provider\\Register',
      18 => 'Queryyetsimple\\Validate\\Provider\\Register',
      19 => 'Queryyetsimple\\View\\Provider\\Register',
      20 => 'common\\is\\provider\\event',
    ),
    'system_path' => 'common/ui/system',
    'system_template' => 
    array (
      'error' => 'error.php',
      'exception' => 'exception.php',
      'trace' => 'trace.php',
      'url' => 'url.php',
    ),
    'event_strict' => false,
    'middleware_group' => 
    array (
      'web' => 
      array (
        0 => 'session',
      ),
      'api' => 
      array (
        0 => 'throttler:60,1',
      ),
      'common' => 
      array (
        0 => 'log',
      ),
    ),
    'middleware_alias' => 
    array (
      'session' => 'Queryyetsimple\\Session\\Middleware\\Session',
      'throttler' => 'Queryyetsimple\\Throttler\\Middleware\\Throttler',
      'log' => 'Queryyetsimple\\Log\\Middleware\\Log',
    ),
    'console' => 
    array (
    ),
    'default_app' => 'home',
    'default_controller' => 'index',
    'default_action' => 'index',
    'default_response' => 'default',
    'var_method' => '_method',
    'var_ajax' => '_ajax',
    'var_pjax' => '_pjax',
    'start_gzip' => true,
    'time_zone' => 'Asia/Shanghai',
    'auth_key' => '7becb888f518b20224a988906df51e05',
    'auth_expiry' => 0,
    'model' => 'pathinfo',
    'rewrite' => false,
    'html_suffix' => '.html',
    'router_cache' => true,
    'router_strict' => false,
    'router_domain_on' => true,
    'router_domain_top' => '',
    'make_subdomain_on' => false,
    'public' => 'http://public.foo.bar',
    'pathinfo_restful' => true,
    'args_protected' => 
    array (
    ),
    'args_regex' => 
    array (
      0 => '[0-9]+',
      1 => 'v([0-9])+',
    ),
    'args_strict' => false,
    'middleware_strict' => false,
    'method_strict' => false,
    'controller_dir' => 'app\\controller',
    '~apps~' => 
    array (
      0 => 'home',
      1 => 'admin',
      2 => 'phpui',
    ),
    '~envs~' => 
    array (
      'environment' => 'development',
      'debug' => 'true',
      'debug_driver' => 'whoops',
      'app_auth_key' => '7becb888f518b20224a988906df51e05',
      'url_public' => 'http://public.foo.bar',
      'router_domain_top' => '',
      'database_driver' => 'mysql',
      'database_host' => '127.0.0.1',
      'database_port' => '3306',
      'database_name' => 'queryphp_development_db',
      'database_user' => 'root',
      'database_password' => '',
      'cache_driver' => 'file',
      'cache_redis_host' => '127.0.0.1',
      'cache_redis_port' => '6379',
      'cache_redis_password' => 'null',
      'cache_memcache_host' => '127.0.0.1',
      'cache_memcache_port' => '11211',
      'session_driver' => 'cookie',
      'session_redis_host' => '127.0.0.1',
      'session_redis_port' => '6379',
      'session_redis_password' => 'null',
      'session_memcache_host' => '127.0.0.1',
      'session_memcache_port' => '11211',
      'queue_driver' => 'redis',
      'queue_redis_host' => 'redis',
      'queue_redis_port' => '6379',
      'queue_redis_password' => 'null',
      'log_driver' => 'file',
      'throttler_driver' => 'file',
      'mail_driver' => 'smtp',
      'mail_host' => 'smtp.qq.com',
      'mail_port' => '465',
      'mail_username' => 'null',
      'mail_password' => 'null',
      'mail_encryption' => 'null',
      'filesystem_driver' => 'local',
      'filesystem_ftp_host' => 'ftp.example.com',
      'filesystem_ftp_port' => '21',
      'filesystem_ftp_username' => 'your-username',
      'filesystem_ftp_password' => 'your-password',
      'filesystem_sftp_host' => 'sftp.example.com',
      'filesystem_sftp_port' => '22',
      'filesystem_sftp_username' => 'your-username',
      'filesystem_sftp_password' => 'your-password',
      'swoole_server' => 'http',
      'view_driver' => 'html',
    ),
    '~routers~' => 
    array (
      0 => '/data/codes/queryphp/common/ui/router/router.php',
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'global_from' => 
    array (
      'address' => NULL,
      'name' => NULL,
    ),
    'global_to' => 
    array (
      'address' => NULL,
      'name' => NULL,
    ),
    'connect' => 
    array (
      'smtp' => 
      array (
        'driver' => 'smtp',
        'host' => 'smtp.qq.com',
        'port' => '465',
        'username' => NULL,
        'password' => NULL,
        'encryption' => NULL,
      ),
      'sendmail' => 
      array (
        'driver' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs',
      ),
    ),
  ),
  'filesystem' => 
  array (
    'default' => 'local',
    'connect' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'path' => '/data/codes/queryphp/storage',
      ),
      'zip' => 
      array (
        'driver' => 'zip',
        'path' => '/data/codes/queryphp/storage/filesystem.zip',
      ),
      'ftp' => 
      array (
        'driver' => 'ftp',
        'host' => 'ftp.example.com',
        'port' => '21',
        'username' => 'your-username',
        'password' => 'your-password',
        'root' => '',
        'passive' => true,
        'ssl' => false,
        'timeout' => 20,
      ),
      'sftp' => 
      array (
        'driver' => 'sftp',
        'host' => 'sftp.example.com',
        'port' => '22',
        'username' => 'your-username',
        'password' => 'your-password',
        'root' => '',
        'privateKey' => '',
        'timeout' => 20,
      ),
    ),
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'fetch' => 5,
    'log' => true,
    'connect' => 
    array (
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'queryphp_development_db',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'readwrite_separate' => false,
        'distributed' => false,
        'master' => 
        array (
        ),
        'slave' => 
        array (
        ),
        'options' => 
        array (
          12 => false,
        ),
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'nocache_force' => '~@nocache_force',
    'prefix' => '~@',
    'expire' => 86400,
    'time_preset' => 
    array (
    ),
    'connect' => 
    array (
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/data/codes/queryphp/runtime/file',
        'serialize' => true,
        'prefix' => NULL,
        'expire' => NULL,
      ),
      'memcache' => 
      array (
        'driver' => 'memcache',
        'servers' => 
        array (
        ),
        'host' => '127.0.0.1',
        'port' => '11211',
        'compressed' => false,
        'persistent' => true,
        'prefix' => NULL,
        'expire' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'host' => '127.0.0.1',
        'port' => '6379',
        'password' => NULL,
        'select' => 0,
        'timeout' => 0,
        'persistent' => false,
        'serialize' => true,
        'prefix' => NULL,
        'expire' => NULL,
      ),
    ),
  ),
  'session' => 
  array (
    'default' => 'cookie',
    'id' => NULL,
    'name' => NULL,
    'cookie_domain' => NULL,
    'cache_limiter' => NULL,
    'save_path' => NULL,
    'gc_probability' => NULL,
    'prefix' => 'q_',
    'expire' => 86400,
    'connect' => 
    array (
      'cookie' => 
      array (
        'driver' => 'cookie',
      ),
      'memcache' => 
      array (
        'driver' => 'memcache',
        'servers' => 
        array (
        ),
        'host' => '127.0.0.1',
        'port' => '11211',
        'compressed' => false,
        'persistent' => true,
        'prefix' => NULL,
        'expire' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'host' => '127.0.0.1',
        'port' => '6379',
        'password' => NULL,
        'select' => 0,
        'timeout' => 0,
        'persistent' => false,
        'serialize' => true,
        'prefix' => NULL,
        'expire' => NULL,
      ),
    ),
  ),
  'cookie' => 
  array (
    'prefix' => 'q_',
    'domain' => '',
    'path' => '/',
    'expire' => 86400,
    'httponly' => false,
  ),
  'throttler' => 
  array (
    'driver' => 'file',
  ),
  'queue' => 
  array (
    'default' => 'redis',
    'connect' => 
    array (
      'redis' => 
      array (
        'servers' => 
        array (
          'host' => 'redis',
          'port' => '6379',
          'password' => NULL,
        ),
        'options' => 
        array (
        ),
      ),
    ),
  ),
  'console' => 
  array (
    'custom' => 
    array (
    ),
    'template' => 
    array (
      'header_comment' => '// (c) {{date_y}} {{product_homepage}} All rights reserved.',
      'file_comment' => '/**
  * {{file_name}}
  *
  * @author {{file_author}}
  * @package {{file_package}}
  * @since {{file_since}}
  * @version {{file_version}}
  */',
      'product_homepage' => 'http://your.domain.com',
      'product_name' => 'Your.Product',
      'product_description' => 'This project can help people to do things very funny.',
      'product_slogan' => 'To make the world better',
      'file_name' => '',
      'file_since' => '2018.04.05',
      'file_version' => '1.0',
      'file_package' => '$$',
      'file_author' => 'Name Your <your@mail.com>',
    ),
  ),
  'view' => 
  array (
    'default' => 'html',
    'theme_name' => 'default',
    'theme_path_default' => '',
    'action_fail' => 'public+fail',
    'action_success' => 'public+success',
    'controlleraction_depr' => '/',
    'connect' => 
    array (
      'html' => 
      array (
        'driver' => 'html',
        'suffix' => '.html',
        'cache_lifetime' => 2592000,
      ),
      'twig' => 
      array (
        'driver' => 'twig',
        'suffix' => '.twig',
      ),
      'v8' => 
      array (
        'driver' => 'v8',
        'suffix' => '.js',
        'vue_path' => '/data/codes/queryphp/node_modules/vue/dist/vue.js',
        'vue_renderer' => '/data/codes/queryphp/node_modules/vue-server-renderer/basic.js',
        'art_path' => '/data/codes/queryphp/node_modules/art-template/lib/template-web.js',
      ),
      'phpui' => 
      array (
        'driver' => 'phpui',
        'suffix' => '.php',
      ),
    ),
  ),
  'i18n' => 
  array (
    'on' => true,
    'default' => 'zh-cn',
    'develop' => 'zh-cn',
    'extend' => 
    array (
    ),
  ),
  'log' => 
  array (
    'default' => 'file',
    'enabled' => true,
    'runtime_enabled' => true,
    'time_format' => '[Y-m-d H:i]',
    'level' => 
    array (
      0 => 'debug',
      1 => 'info',
      2 => 'notice',
      3 => 'warning',
      4 => 'error',
      5 => 'critical',
      6 => 'alert',
      7 => 'emergency',
      8 => 'sql',
    ),
    'connect' => 
    array (
      'file' => 
      array (
        'driver' => 'file',
        'name' => 'Y-m-d H',
        'size' => 2097152,
        'path' => '/data/codes/queryphp/runtime/log',
      ),
      'monolog' => 
      array (
        'driver' => 'monolog',
        'type' => 
        array (
          0 => 'file',
        ),
        'channel' => 'Q',
        'name' => 'Y-m-d H',
        'size' => 2097152,
        'path' => '/data/codes/queryphp/runtime/log/monolog',
      ),
    ),
  ),
  'swoole' => 
  array (
    'default' => 'http',
    'autoreload_after_seconds' => 10,
    'autoreload_watch_dir' => 
    array (
      0 => '/data/codes/queryphp/application',
      1 => '/data/codes/queryphp/common',
    ),
    'server' => 
    array (
      'host' => '127.0.0.1',
      'port' => '9500',
      'worker_num' => 8,
      'daemonize' => 0,
      'task_worker_num' => 4,
      'process_name' => 'queryphp.swoole.default',
      'pid_path' => '/data/codes/queryphp/runtime/swoole/pid/default.pid',
    ),
    'http_server' => 
    array (
      'port' => '9501',
      'process_name' => 'queryphp.swoole.http',
      'pid_path' => '/data/codes/queryphp/runtime/swoole/pid/http.pid',
    ),
    'websocket_server' => 
    array (
      'host' => '0.0.0.0',
      'port' => '9502',
      'task_worker_num' => 4,
      'process_name' => 'queryphp.swoole.websocket',
      'pid_path' => '/data/codes/queryphp/runtime/swoole/pid/websocket.pid',
    ),
    'rpc_server' => 
    array (
      'host' => '127.0.0.1',
      'port' => '1355',
      'task_worker_num' => 4,
      'dispatch_mode' => 1,
      'open_length_check' => true,
      'package_max_length' => 8192000,
      'package_length_type' => 'N',
      'package_length_offset' => 0,
      'package_body_offset' => 4,
      'process_name' => 'queryphp.swoole.rpc',
      'pid_path' => '/data/codes/queryphp/runtime/swoole/pidrpc.pid',
    ),
  ),
); ?>