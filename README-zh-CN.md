<p align="center">
  <a href="https://queryphp.com">
    <img src="./assets/images/queryphp.png" />
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
  <a href="https://travis-ci.org/hunzhiwange/queryphp">
    <img alt="Build Status" src="https://img.shields.io/travis/hunzhiwange/queryphp.svg" /></a>
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

# QueryPHP 应用

QueryPHP 是一款现代化的高性能 PHP 渐进式框架, 以提供稳定可靠的高品质企业级框架为历史使命。**<span style="color:#e82e7d;">USE LEEVEL DO BETTER</span>** **[And More Information...](assets/readme/MORE-zh-CN.md)**

* 官方网站: <https://www.queryphp.com/>
* 官方网站国内镜像: <https://queryphp.gitee.io/>
* 开发文档: <https://www.queryphp.com/docs/>

## 特性

- 生产就绪 (Production-ready)
- [简单高性能路由](https://www.queryphp.com/docs/router/)
- [富于表现力的模板引擎](https://www.queryphp.com/docs/template/)
- [基于领域驱动设计的强大 ORM](https://www.queryphp.com/docs/database/)
- 高质量代码及高覆盖率[单元测试](https://github.com/hunzhiwange/framework/tree/master/tests)

## 如何安装

```
composer create-project hunzhiwange/queryphp myapp
php leevel server <Visite http://127.0.0.1:9527/>
```

### Swoole Http 服务

```
php leevel http:server # php leevel http:server -d
php leevel http:reload
php leevel http:stop
php leevel http:status
```

### Swoole Websocket 服务

```
php leevel websocket:server # php leevel websocket:server -d
php leevel websocket:reload
php leevel websocket:stop
php leevel websocket:status
```

### Go RoadRunner 服务 

```
/data/server/roadrunner-1.8.2-darwin-amd64/rr serve -d -v # -d = debug
/data/server/roadrunner-1.8.2-darwin-amd64/rr http:reset
/data/server/roadrunner-1.8.2-darwin-amd64/rr http:workers -i
```

## 版权协议

QueryPHP 是一个基于 [MIT license](http://opensource.org/licenses/MIT) 授权许可协议的开源软件.
