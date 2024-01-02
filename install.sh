echo "CREATE DATABASE yii2basic;" > init.txt
docker-compose down
docker-compose up -d
docker-compose exec php pecl install --force redis && rm -rf /tmp/pear && docker-php-ext-enable redis
docker-compose exec php composer self-update && composer require predis/predis
docker-compose exec php composer install && composer update
