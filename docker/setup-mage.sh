#!/bin/sh

cd /src/www

echo "Initializing components and dependencies install..."

echo "composer install"
composer install --prefer-dist

echo "components and dependencies install finished..."

echo "Initializing setup..."

chown -R :www-data .
chmod u+x bin/magento

echo "setup"
php -d memory_limit=2G ./bin/magento setup:install \
    --db-host=$MAGE_SETUP_DB_HOST \
    --db-name=$MAGE_SETUP_DB_NAME \
    --db-user=$MAGE_SETUP_DB_USER \
    --db-password=$MAGE_SETUP_DB_PASSWORD \
    --base-url=$MAGE_SETUP_BASE_URL \
    --backend-frontname=$MAGE_SETUP_ADMIN_BACKEND_FRONTNAME \
    --admin-firstname=$MAGE_SETUP_ADMIN_FIRSTNAME \
    --admin-lastname=$MAGE_SETUP_ADMIN_LASTNAME \
    --admin-email=$MAGE_SETUP_ADMIN_EMAIL \
    --admin-user=$MAGE_SETUP_ADMIN_USER \
    --admin-password=$MAGE_SETUP_ADMIN_PASSWORD

find var vendor pub/static pub/media app/etc -type f -exec chmod g+w {} \;
find var vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} \;

echo "Setup finished..."
php -d memory_limit=2G ./bin/magento setup:di:compile

#########################################################
# Must be kept until it is fixed
# https://github.com/zendframework/zend-stdlib/issues/58
# já foi resolvido mas ficaremos
# esperando magento2  v2.2 virar release 
sed "s,=> GLOB_BRACE,=> defined('GLOB_BRACE') ? GLOB_BRACE : 0,g" -i ./vendor/zendframework/zend-stdlib/src/Glob.php