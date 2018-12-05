# QueryVue #

This will help php developer to use QueryPHP.

This project is base on [VueThink](https://github.com/honraytech/VueThink)、[VueElementAdmin](https://github.com/PanJiaChen/vue-element-admin)、[IViewAdmin](https://github.com/iview/iview-admin)，thanks

## Development

First to create config file.

```
cp config/dev.env.js.example config/dev.env.js
cp config/prod.env.js.example config/prod.env.js
cp config/sit.env.js.example config/sit.env.js
```

Then

```bas
npm install -g cnpm --registry=https://registry.npm.taobao.org // Just once
cnpm install
npm run serve # npm run dev
```
View http://localhost:9528

## Publish

```bash
npm run build
```

## Other

### Run your tests
```
npm run test
```

### Lints and fixes files
```
npm run lint
```


## Style format

```
cnpm install --save-dev --save-exact prettier
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
