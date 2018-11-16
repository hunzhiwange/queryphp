#!/usr/bin/env bash

set -e

gulp iview

prettier --config .prettierrc.js --ignore-path .prettierignore  --write src/**/**.js
prettier --config .prettierrc.js --write build/**.js
prettier --config .prettierrc.js --write config/**.js
prettier --config .prettierrc.js --write gulpfile.js
prettier --config .prettierrc.js --write .eslintrc.js
