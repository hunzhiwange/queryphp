#!/usr/bin/env bash

set -e

./node_modules/.bin/gulp iview

./node_modules/.bin/prettier --config .prettierrc.js --ignore-path .prettierignore  --write src/**/**.js
./node_modules/.bin/prettier --config .prettierrc.js --write vue.config.js
./node_modules/.bin/prettier --config .prettierrc.js --write babel.config.js
./node_modules/.bin/prettier --config .prettierrc.js --write .eslintrc.js
./node_modules/.bin/prettier --config .prettierrc.js --write gulpfile.js
./node_modules/.bin/prettier --config .prettierrc.js --write .eslintrc.js
