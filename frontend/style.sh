#!/usr/bin/env bash

set -e

./node_modules/.bin/gulp iview

./node_modules/.bin/prettier --config .prettierrc.js --ignore-path .prettierignore --write vue.config.js babel.config.js .eslintrc.js gulpfile.js **/src/**
