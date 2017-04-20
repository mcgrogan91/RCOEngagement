#!/bin/bash
pushd frontend
npm install
npm run build
popd

if [ -L api/public/app ]; then
  rm api/public/app
fi

ln -s frontend/dist api/public/app

pushd api
composer install
# If you're running this locally, uncomment the next line
#php artisan serve
popd
