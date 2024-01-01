echo "CREATE DATABASE yii2basic;" > init.sql
docker-compose down
docker-compose up -d
docker-compose exec php pecl install --force redis && rm -rf /tmp/pear && docker-php-ext-enable redis
docker-compose exec php composer self-update && composer require predis/predis
docker-compose exec php composer install && composer update
docker-compose exec php php yii migrate --interactive=0
rm -rf ./init.sql