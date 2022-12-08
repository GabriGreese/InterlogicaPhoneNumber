composer update

read -e -p "Please specify db username (better if root for this test): > " -i "root" mysql_uid
read -e -p "Please specify db password (better if root for this test): > " -i "root" mysql_pwd
read -e -p "Please specify db name: > " -i "gdg_test" mysql_db
read -e -p "Please specify MySQL host: > " -i "127.0.0.1" mysql_host
read -e -p "Please specify MySQL port: > " -i "3306" mysql_port

echo "Creating database '${mysql_db}'"
echo 'CREATE DATABASE IF NOT EXISTS $mysql_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;' | mysql -u $mysql_uid -p$mysql_pwd -P $mysql_port

read -e -p "Please specify project url without protocol: > " -i "gdg_test.local" host

printf "APP_NAME=GDGTest
APP_ENV=local
APP_KEY=base64:GA2E3WgVt9nFVTXWYF81RbE04HtO9sPd6HjAyw2HTPE=
APP_DEBUG=true
APP_URL=http://${host}

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_PORT=${mysql_port}
DB_HOST=${mysql_host}
DB_DATABASE=${mysql_db}
DB_USERNAME=${mysql_uid}
DB_PASSWORD=${mysql_pwd}

BROADCAST_DRIVER=log
CACHE_DRIVER=none
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
" > ./.env


echo 'Installing Laravel migrations'
php artisan session:table
php artisan migrate