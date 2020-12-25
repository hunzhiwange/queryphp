# QueryVue

<a href="./README.md">English</a> | <a href="./README-zh-CN.md">中文</a>

这个应用可以帮助你更好地使用 QueryPHP.

本应用基于 [VueThink](https://github.com/honraytech/VueThink)、[VueElementAdmin](https://github.com/PanJiaChen/vue-element-admin)、[IViewAdmin](https://github.com/iview/iview-admin)，感谢这些优秀的应用。

## Development

首先创建配置文件,PHP 的 composer 会帮助你创建它.

```
# local
cp .env.example .env.local

# production
cp .env.example .env.production
```

接着

```bas
npm install -g cnpm --registry=https://registry.npm.taobao.org // Just once
cnpm install
npm run serve # npm run dev
```
访问 http://127.0.0.1:9528

## 发布

```bash
npm run build
```

## 运行测试文件

```
npm run test
```

## 统一团队代码风格

```
sh ./style.sh // All
```

配置 Git Hook 来格式化

See `./../build/pre-commit.sh`

```
gulp_path=$(cd `dirname $0`; pwd)"/../../frontend/node_modules/.bin/gulp"
prettier_path=$(cd `dirname $0`; pwd)"/../../frontend/node_modules/.bin/prettier

# for js
jsfiles=$(git diff --cached --name-only --diff-filter=ACM "*.js" "*.jsx" "*.vue" "*.css" "*.less" | tr '\n' ' ')
[ -z "$jsfiles" ] && exit 0

# format iview
$gulp_path iview --gulpfile frontend/gulpfile.js

# Prettify all staged .js files
echo "$jsfiles" | xargs $prettier_path --config frontend/.prettierrc.js --ignore-path frontend/.prettierignore --write

# Add back the modified/prettified files to staging
echo "$jsfiles" | xargs git add

git update-index -g

```

## 语言工作流

使用 Gulp 导出语言包.

```
./node_modules/.bin/gulp

...
[18:57:50] Using gulpfile /data/codes/queryphp/frontend/gulpfile.js
[18:57:50] Starting 'default'...
[18:57:50] Finished 'default' after 362 μs
Saved src_router_router.js.tmp.i18n.js
Saved src_utils_request.js.tmp.i18n.js
...
```

使用 poedit 软件导出 po 语言包.

```
./tmp-i18n/*

...
__('登录')
__('系统已锁定')
__('权限不足')
...

src/i18n/zh-CN/default.po
```

将 po 语言包转为 json.

```
./node_modules/.bin/gulp po

[21:42:09] Using gulpfile /data/codes/queryphp/frontend/gulpfile.js
[21:42:09] Starting 'po'...
[21:42:09] Finished 'po' after 733 μs
Saved src/i18n/en-US/index.js
Saved src/i18n/zh-TW/index.js
Saved src/i18n/zh-CN/index.js
```
