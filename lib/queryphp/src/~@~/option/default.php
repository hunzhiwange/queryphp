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
        'option_extend' => '', //主题扩展项，
        'option_system_extend' => 'db,theme,i18n,cookie,url,log,debug,cache,router',//隐性默认加载 db,theme,i18n,cookie,url,log,debug,cache,router
        'globals_tags' => [ ], // 全局标签
        'start_gzip' => TRUE, // Gzip压缩
        'time_zone' => 'Asia/Shanghai', // 时区
        'q_auth_key' => 'queryphp-872-028-111-222-sn7i', // 安全key
        'upload_file_rule' => 'time', // 文件上传保存文件名函数
        
        /**
         * 数据库
         */
        'db_host' => 'localhost', // 数据库地址
        'db_user' => 'root', // 数据库用户名
        'db_password' => '', // 数据库密码
        'db_prefix' => '', // 数据库表前缀
        'db_char' => 'utf8', // 数据库编码
        'db_name' => '', // 数据库名字
        'db_type' => 'mysql', // 数据库类型
        'db_schema' => '', // 数据库SCHEMA
        'db_port' => 3306, // 端口
        'db_cache' => FALSE, // 数据库查询是否缓存
        'db_meta_cached' => TRUE, // 数据库元是否缓存
        'db_distributed' => FALSE, // 是否采用分布式
        'db_rw_separate' => FALSE, // 数据库读写是否分离主从式有效
        'db_dsn' => 'mysql://username:password@localhost:3306/dbname', // 数据dsn解析
        'db_params' => [ ], // 数据库连接参数
        
        /**
         * 主题 && 语言包
         */
        'theme_cache_lifetime' => - 1, // 模板编译缓存时间,单位秒,-1表示永不过期
        'theme_cache_children' => FALSE, // 模板编译是否将子模板的缓存写入父模板以达到降低IO开销
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
        'cookie_prefix' => 'q_', // cookie前缀
        'cookie_langtheme_app' => TRUE, // 语言包和模板COOKIE是否包含应用名
        'cookie_domain' => '', // cookie域名
        'cookie_path' => '/', // cookie路径
        'cookie_expire' => 86400, // cookie默认过期时间一天
        
        /**
         * Url相关
         */
        'url_model' => 'pathinfo', // default=普通，pathinfo=pathinfo模式
        'url_rewrite' => FALSE, // 是否开启重写
        'url_pathinfo_depr' => '/', // url分割符
        'url_html_suffix' => '.html', // 伪静态后缀
        'url_pro_var' => 'Q', // URL生成受保护参数
        'url_start_router' => FALSE, // 是否开启URL路由
        'url_router' => [ ], // 路由配置
        'url_domain_on' => true, // 是否开启域名
        'url_domain' => '', // 域名，不为空将会被写入到生成的网址中，后面不能添加‘/’，如 http://myapp.queryphp.com
        'url_subdomain_on' => FALSE, // 是否开启多域名
        'url_domain_top' => '', // 顶级域名，如 queryphp.com
        'url_domain_suffix' => '', // 子目录
        'url_public' => '', // 公共
        
        /**
         * 日志 && 调试
         */
        'log_record' => FALSE, // 默认不记录日志
        'log_file_size' => 2097152, // 日志文件大小限制
        'log_record_level' => 'EMERG|ALERT|CRIT|ERR', // 允许记录的日志级别
        'log_must_record_exception' => FALSE, // 是否强制记录异常
        'log_sql_enabled' => FALSE, // 是否记录数据中的日志
        'show_page_trace' => FALSE, // 显示页面调式信息
        'show_exception_redirect' => '', // 重定向错误页面
        'show_exception_tpl' => '', // 自定义错误模板
        'show_exception_default_message' => 'error', // 默认异常错误消息
        'show_exception_show_message' => TRUE, // 是否显示具体错误
        
        /**
         * 缓存系统
         */
        'runtime_cache_force_name' => 'update_cache',
        'runtime_cache_backend' => 'FileCache', // 程序运行指定缓存,例如 MemcacheCache
        'runtime_cache_time' => 86400, // 程序缓存时间
        'runtime_cache_prefix' => '~@', // 缓存键值前缀
        'runtime_cache_times' => [ ], // 缓存时间预植,键值=缓存值，键值不带前缀 array('option'=>60)
        'runtime_memcache_servers' => [ ], // Memcache多台服务器
        'runtime_memcache_host' => '127.0.0.1', // Memcache默认缓存服务器
        'runtime_memcache_port' => 11211, // Memcache默认缓存服务器端口
        'runtime_memcache_compressed' => false, // Memcache是否压缩缓存数据
        'runtime_memcache_persistent' => true 
] // Memcache是否使用持久连接
;
