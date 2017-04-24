<?php
/**
 * 路由配置文件
 */
return [ 
        'url_router_on' => true,
        'url_router_strict' => false,
        'url_domain_on' => true,
        'url_router_domain_on' => true,
        'url_router_domain_top' => 'queryphp.cn',
        'url_make_subdomain_on' => true,
        'url_make_domain_suffix' => '/subdir',
        
        // 'url_make_domain_on' => true,
        // 'url_make_domain' => 'http://www.queryphp.com'
        
        // 'runtime_cache_backend' => 'memcache'
        
        'log_enabled' => true, // 默认不记录日志
        'log_level' => 'error,sql,test,hello,debug', //
                                                     // 'log_file_size' => '1',
        'log_error_enabled' => true,
        'log_sql_enabled' => true,
        
        'runtime_cache_times' => [ 
                'test1' => 86400,
                'test2' => 3600,
                'goods*city' => 3600,
                'city_*_*_cache' => 3600 
        ],
        
        'test_option' => [ 
                'hello_option' => [ 
                        'world' => 5,
                        'me' => '你好' 
                ] 
        ],
        
        'db_host' => 'localhost', // 数据库地址
        'db_user' => 'root', // 数据库用户名
        'db_password' => '', // 数据库密码
        'db_prefix' => 'zt_', // 数据库表前缀
        'db_char' => 'utf8', // 数据库编码
        'db_name' => 'candao_project', // 数据库名字
        'db_type' => 'mysql', // 数据库类型
//         'db_schema' => '', // 数据库SCHEMA
         'db_port' => 3306, // 端口
//         'db_cache' => FALSE, // 数据库查询是否缓存
//         'db_meta_cached' => TRUE, // 数据库元是否缓存
//         'db_distributed' => FALSE, // 是否采用分布式
//         'db_rw_separate' => FALSE, // 数据库读写是否分离主从式有效
//         'db_dsn' => 'mysql://username:password@localhost:3306/dbname', // 数据 dsn 解析
//         'db_params' => [ ], // 数据库连接参数
];
