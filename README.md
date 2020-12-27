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

QueryPHP is a modern, high performance PHP progressive framework, to provide a stable and reliable high-quality enterprise level framework as its historical mission. **<span style="color:#e82e7d;">USE LEEVEL DO BETTER</span>** **[And More Information...](assets/readme/MORE.md)**

* Site: <https://www.queryphp.com/>
* China Mirror Site: <https://queryphp.gitee.io/>
* Documentation: <https://www.queryphp.com/docs/>

## Features

- Production-ready
- [Simple high performance routing](https://www.queryphp.com/docs/router/)
- [Expressive template engine](https://www.queryphp.com/docs/template/)
- [Powerful ORM based on domain driven design](https://www.queryphp.com/docs/database/)
- High quality code and high coverage [unit testing](https://github.com/hunzhiwange/framework/tree/master/tests)

## How to install

```
composer create-project hunzhiwange/queryphp myapp
php leevel server <Visite http://127.0.0.1:9527/>
```

### Swoole Http Server

```
php leevel http:server # php leevel http:server -d
php leevel http:reload
php leevel http:stop
php leevel http:status
```

### Swoole Websocket Server

```
php leevel websocket:server # php leevel websocket:server -d
php leevel websocket:reload
php leevel websocket:stop
php leevel websocket:status
```

### Go RoadRunner Server

```
/data/server/roadrunner-1.8.2-darwin-amd64/rr serve -d -v # -d = debug
/data/server/roadrunner-1.8.2-darwin-amd64/rr http:reset
/data/server/roadrunner-1.8.2-darwin-amd64/rr http:workers -i
```

## License

The QueryPHP framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
