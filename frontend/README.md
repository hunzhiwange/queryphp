# QueryVue

<a href="./README.md">English</a> | <a href="./README-zh-CN.md">中文</a>

This will help php developer to use QueryPHP.

This app is base on [VueThink](https://github.com/honraytech/VueThink)、[VueElementAdmin](https://github.com/PanJiaChen/vue-element-admin)、[IViewAdmin](https://github.com/iview/iview-admin)，thanks

## Development

First to create config file,PHP composer will help you.

```
# local
cp .env.example .env.local

# production
cp .env.example .env.production
```

Then

```bas
npm install -g cnpm --registry=https://registry.npm.taobao.org // Just once
cnpm install
npm run serve # npm run dev
```
View http://127.0.0.1:9528

## Publish

```bash
npm run build
```

## Run tests

```
npm run test
```

## Style format

```
cnpm install --global prettier
cnpm install gulp -g
```

Then

```
sh ./style.sh // All
```

With git

See `./../build/pre-commit.sh`

```
# for js
jsfiles=$(git diff --cached --name-only --diff-filter=ACM "*.js" "*.jsx" "*.css" "*.vue" "*.css" "*.less" | tr '\n' ' ')
[ -z "$jsfiles" ] && exit 0

# Prettify all staged .js files
echo "$jsfiles" | xargs ./frontend/node_modules/.bin/prettier --config frontend/.prettierrc.js --ignore-path frontend/.prettierignore --write

# Add back the modified/prettified files to staging
echo "$jsfiles" | xargs git add

git update-index -g

```

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
