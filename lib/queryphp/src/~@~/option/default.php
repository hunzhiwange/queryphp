<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */

/**
 * 系统默认配置文件
 *
 * @author Xiangmin Liu
 */
return [ 
        
        'default_app' => 'home', // 默认应用
        'default_controller' => 'index', // 默认控制器
        'default_action' => 'index', // 默认方法
        '~apps~' => [ ], // 默认 app 名字
        
        /**
         * 杂项
         */
        'option_extend' => '', // 配置扩展项
        'option_system_extend' => 'db,theme,i18n,cookie,url,log,debug,cache', // 隐性默认加载 db,theme,i18n,cookie,url,log,debug,cache
        'globals_tags' => [ ], // 全局标签
        'start_gzip' => TRUE, // Gzip 压缩
        'time_zone' => 'Asia/Shanghai', // 时区
        'q_auth_key' => 'queryphp-872-028-111-222-sn7i', // 安全 key
        'upload_file_rule' => 'time', // 文件上传保存文件名函数
        
        /**
         * 数据库
         */
        
        // 数据库默认连接参数
        'db_type' => 'mysql', // 数据库类型
        'db_host' => 'localhost', // 数据库地址
        'db_user' => 'root', // 数据库用户名
        'db_password' => '', // 数据库密码
        'db_prefix' => '', // 数据库表前缀
        'db_char' => 'utf8', // 数据库编码
        'db_name' => '', // 数据库名字
        'db_schema' => '', // 数据库SCHEMA
        'db_port' => 3306, // 端口
        'db_dsn' => '', // [优先解析]数据 dsn 解析 mysql://username:password@localhost:3306/dbname
        'db_params' => [ ], // 数据库连接参数
        'db_persistent' => FALSE, // 数据库是否支持长连接
        'db_distributed' => FALSE, // 是否采用分布式
        'db_rw_separate' => FALSE, // 数据库读写是否分离[注意：主从式有效]
        'db_master' => [], // 主服务器
        'db_slave' => [], // 副服务器
                                   
        // 数据库缓存
        'db_cache' => FALSE, // 数据库查询是否缓存
        'db_meta_cached' => TRUE, // 数据库元是否缓存
        
        /**
         * 主题 && 语言包
         */
        'theme_cache_lifetime' => - 1, // 模板编译缓存时间,单位秒,-1 表示永不过期
        'theme_cache_children' => FALSE, // 模板编译是否将子模板的缓存写入父模板以达到降低 IO 开销
        'theme_switch' => FALSE, // 是否允许模板切换
        'theme_default' => 'default', // 模板默认主题
        'theme_tag_note' => FALSE, // 注释版标签风格
        'theme_notallows_func' => 'exit,die,return', // 系统不允许解析的函数-英文半角“,”隔开*
        'theme_notallows_func_js' => 'alert', // js 不允许函数
        'theme_suffix' => '.html', // 模板后缀
        'theme_var_identify' => '', // 为空表示模板解析自动识别为 obj,array
        'theme_action_fail' => 'public+fail', // 默认错误跳转对应的模板文件
        'theme_action_success' => 'public+success', // 默认成功跳转对应的模板文件
        'theme_moduleaction_depr' => '_', // 默认模块和方法分割符
        'theme_strip_space' => true, // 模板编译文件是否清除空格
        'i18n_on' => FALSE, // 是否使用语言包
        'i18n_switch' => FALSE, // 是否允许切换语言包
        'i18n_default' => 'zh-cn', // 当前语言环境
        'i18n_develop' => 'zh-cn', // 当前开发语言环境，为当前开发语言则不载入语言包直接返回
        'i18n_auto_accept' => TRUE, // 自动侦测语言
        
        /**
         * cookie
         */
        'cookie_prefix' => 'q_', // cookie 前缀
        'cookie_langtheme_app' => TRUE, // 语言包和模板 cookie 是否包含应用名
        'cookie_domain' => '', // cookie 域名
        'cookie_path' => '/', // cookie 路径
        'cookie_expire' => 86400, // cookie 默认过期时间一天
        
        /**
         * Url相关
         */
        'url_model' => 'pathinfo', // default = 普通，pathinfo = pathinfo 模式
        'url_rewrite' => FALSE, // 是否开启重写
        'url_pathinfo_depr' => '/', // url 分割符
        'url_html_suffix' => '.html', // 伪静态后缀
        'url_router_on' => FALSE, // 是否开启 url 路由
        'url_router_strict' => false, // 是否启用严格 url 匹配模式
        'url_router_extend' => '', // 路由扩展支持文件
        'url_router_domain_on' => false, // 是否开启域名路由解析
        'url_router_domain_top' => '', // 顶级域名，如 queryphp.com
        'url_make_subdomain_on' => FALSE, // 是否开启子域名
        
        /**
         * 日志 && 调试
         */
        'log_enabled' => FALSE, // 默认不记录日志
        'log_level' => 'error,sql,debug,info', // 允许记录的日志级别，随意自定义 error 和 sql 为系统内部使用
        'log_error_enabled' => FALSE, // 是否记录系统中的错误日志
        'log_sql_enabled' => FALSE, // 是否记录系统中的 sql 日志
        'log_file_size' => 2097152, // 日志文件大小限制
        'log_file_name' => 'Y-m-d H', // 日志文件名时间格式化
        'log_time_format' => '【Y-m-d H:i】', // 日志时间格式化
        'show_page_trace' => FALSE, // 显示页面调式信息
        'show_exception_redirect' => '', // 重定向错误页面
        'show_exception_tpl' => '', // 自定义错误模板
        'show_exception_default_message' => 'error', // 默认异常错误消息
        'show_exception_show_message' => TRUE, // 是否显示具体错误
        
        /**
         * 缓存系统
         */
        'runtime_cache_backend' => 'file', // 程序运行指定缓存
        'runtime_cache_force_name' => '~@update_cache', // 缓存调试 GET 参数，强制不启用缓存
        'runtime_cache_time' => 86400, // 程序缓存时间
        'runtime_cache_prefix' => '~@', // 缓存键值前缀
        'runtime_cache_times' => [ ], // 缓存时间预植,键值=缓存值，键值不带前缀 ['option' => 60]
        'runtime_file_path' => '', // 文件缓存路径
        'runtime_memcache_servers' => [ ], // memcache 多台服务器
        'runtime_memcache_host' => '127.0.0.1', // memcache 默认缓存服务器
        'runtime_memcache_port' => 11211, // memcache 默认缓存服务器端口
        'runtime_memcache_compressed' => false, // memcache 是否压缩缓存数据
        'runtime_memcache_persistent' => true 
]; // memcache 是否使用持久连接

