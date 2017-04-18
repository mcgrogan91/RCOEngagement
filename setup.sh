pushd frontend
npm install
npm run build
popd

ln -s frontend/src api/public/app

pushd api
composer install
# If you're running this locally, uncomment the next line
#php artisan serve
popd
