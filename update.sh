#!/bin/bash

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd ${SCRIPT_DIR}

. $SCRIPTDIR.env

php artisan down

if [ $APP_ENV == 'production' ]
then
    composer install --no-dev
    npm install --production --no-bin-links
    php artisan migrate --force
else
    composer install
    php artisan migrate --force
    php artisan ide-helper:generate
    php artisan ide-helper:models --write --reset
    npm install --no-bin-links
fi

npm run prod

php artisan up