#!/usr/bin/env bash

cd template || exit 1

npm run build

cp -r build/* ../assets

rm ../assets/*.html
