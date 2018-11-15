# QueryPHP-Vue #

This will help php developer to use QueryPHP.

This project is base on [VueThink](https://github.com/honraytech/VueThink)、[VueElementAdmin](https://github.com/PanJiaChen/vue-element-admin)、[IViewAdmin](https://github.com/iview/iview-admin)，thanks

## Development
```bas
npm install
npm install --registry=https://registry.npm.taobao.org
npm run dev
```
View http://localhost:9528

## I18n workflow

First use gulp to extract i18n.

```
gulp

...
[18:57:50] Using gulpfile /data/codes/queryphp/frontend/gulpfile.js
[18:57:50] Starting 'default'...
[18:57:50] Finished 'default' after 362 μs
Saved src_router_router.js.tmp.i18n.js
Saved src_utils_request.js.tmp.i18n.js
...
```

Then use poedit to extract po file.

```
./tmp-i18n/*

...
__('登录')
__('系统已锁定')
__('权限不足')
...

src/i18n/zh-CN/default.po
```

Then po to json.

```
gulp po

[21:42:09] Using gulpfile /data/codes/queryphp/frontend/gulpfile.js
[21:42:09] Starting 'po'...
[21:42:09] Finished 'po' after 733 μs
Saved src/i18n/en-US/index.js
Saved src/i18n/zh-TW/index.js
Saved src/i18n/zh-CN/index.js
```


## Publish
```bash
npm run build:sit-preview
npm run build:prod
```
