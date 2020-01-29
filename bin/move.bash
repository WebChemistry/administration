#!/usr/bin/env bash

DIR="node_modules/admin-lte/dist"
DIR_PLG="node_modules/admin-lte/plugins"

if [ -d "$DIR" ]; then
  rm -r assets/*
  cp -r $DIR/* assets
  cp -r $DIR_PLG assets
else
  echo "Directory $DIR not found"

  exit 1
fi
