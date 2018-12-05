#!/usr/bin/env bash

set -e

gulp iview

prettier --config .prettierrc.js --ignore-path .prettierignore  --write src/**/**.js
prettier --config .prettierrc.js --write vue.config.js
prettier --config .prettierrc.js --write babel.config.js
prettier --config .prettierrc.js --write .eslintrc.js
prettier --config .prettierrc.js --write gulpfile.js
prettier --config .prettierrc.js --write .eslintrc.js
