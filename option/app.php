<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 应用全局配置文件
 *
 * @author Xiangmin Liu <635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * 运行环境
     * ---------------------------------------------------------------
     *
     * 根据不同的阶段设置不同的开发环境
     * 可以为 production : 生产环境 testing : 测试环境 development : 开发环境
     */
    'environment' => env('environment', 'development'),

    /**
     * ---------------------------------------------------------------
     * 是否打开调试模式
     * ---------------------------------------------------------------
     *
     * 打开调试模式可以显示更多精确的错误信息
     */
    'debug' => env('debug', false),

    /**
     * ---------------------------------------------------------------
     * 默认异常错误消息
     * ---------------------------------------------------------------
     *
     * 使用默认消息避免暴露重要的错误消息给用户
     * 仅支持系统默认模板调试情况
     * 仅在未开启 DEBUG 模式下面有效
     */
    'custom_exception_message' => '',

    /**
     * ---------------------------------------------------------------
     * 服务提供者
     * ---------------------------------------------------------------
     *
     * 这里的服务提供者为类的名字，例如 common\is\provider\event
     * 每一个服务提供者必须包含一个 register 方法，还可以包含一个 bootstrap 方法
     * 系统所有 register 方法注册后，bootstrap 才开始执行以便于调用其它服务提供者 register 注册的服务
     * 相关文档请访问 [系统架构\应用服务提供者]
     * see https://github.com/hunzhiwange/document/blob/master/system-architecture/service-provider.md
     */
    'provider' => [

        // 框架服务提供者
        'Leevel\Auth\Provider\Register',
        'Leevel\Cache\Provider\Register',
        'Leevel\Cookie\Provider\Register',
        'Leevel\Database\Provider\Register',
        'Leevel\Encryption\Provider\Register',
        'Leevel\Filesystem\Provider\Register',
        'Leevel\I18n\Provider\Register',
        'Leevel\Mail\Provider\Register',
        'Leevel\Mvc\Provider\Register',
        'Leevel\Page\Provider\Register',
        'Leevel\Queue\Provider\Register',
        'Leevel\Session\Provider\Register',
        'Leevel\Swoole\Provider\Register',
        'Leevel\Throttler\Provider\Register',
        'Leevel\Validate\Provider\Register',
        'Leevel\View\Provider\Register',

        // 应用服务提供者
        'Common\Infra\Provider\Event',
        'Common\Infra\Provider\Router'
    ],

    /**
     * ---------------------------------------------------------------
     * 自定义命令
     * ---------------------------------------------------------------
     *
     * 如果你创建了一个命令，你需要在这里注册这个命令
     * 命令一行一条，直接书写完整的命名空间类
     */
    'console' => [],

    /**
     * ---------------------------------------------------------------
     * 默认响应方式
     * ---------------------------------------------------------------
     *
     * default 为默认的解析方式
     * api 接口模式，json、view 和默认返回 api 格式数据
     */
    'default_response' => 'default',

    /**
     * ---------------------------------------------------------------
     * Gzip 压缩
     * ---------------------------------------------------------------
     *
     * 启用页面 gzip 压缩，需要系统支持 gz_handler 函数
     */
    'start_gzip' => true,

    /**
     * ---------------------------------------------------------------
     * 系统时区
     * ---------------------------------------------------------------
     *
     * 此配置用于 date_default_timezone_set 应用设置系统时区
     * 此功能会影响到 date.time 相关功能
     */
    'time_zone' => 'Asia/Shanghai',

    /**
     * ---------------------------------------------------------------
     * 安全 key
     * ---------------------------------------------------------------
     *
     * 请妥善保管此安全 key,防止密码被人破解
     * \Leevel\Encryption\Encryption 安全 key
     */
    'auth_key' => env('app_auth_key', '7becb888f518b20224a988906df51e05'),

    /**
     * ---------------------------------------------------------------
     * 安全过期时间
     * ---------------------------------------------------------------
     *
     * 0 表示永不过期
     * \Leevel\Encryption\Encryption 安全过期时间
     */
    'auth_expiry' => 0,

    /**
     * ---------------------------------------------------------------
     * 伪静态后缀
     * ---------------------------------------------------------------
     *
     * 系统进行路由解析时将会去掉后缀后然后继续执行 url 解析
     */
    'html_suffix' => '.html',

    /**
     * ---------------------------------------------------------------
     * 顶级域名
     * ---------------------------------------------------------------
     *
     * 例如 queryphp.com，用于路由解析以及 \Leevel\Router\Router::url 生成
     */
    'top_domain' => env('top_domain', 'foo.bar'),

    /**
     * ---------------------------------------------------------------
     * url 生成是否开启子域名
     * ---------------------------------------------------------------
     *
     * 开启 url 子域名功能，用于 \Leevel\Router\Router::url 生成
     */
    'make_subdomain_on' => false,

    /**
     * ---------------------------------------------------------------
     * public　资源地址
     * ---------------------------------------------------------------
     *
     * 设置公共资源 url 地址
     */
    'public' => env('url_public', 'http://public.foo.bar')
];
