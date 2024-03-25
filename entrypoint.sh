#!/bin/bash

cd /var/www/src

sleep 5
echo "MySQL is ready, running migrations..."
../vendor/bin/doctrine-migrations migrate --no-interaction

/usr/sbin/apache2ctl -D FOREGROUND
