curl -L https://github.com/do-community/travellist-laravel-demo/archive/tutorial-1.0.1.zip -o travellist.zip

unzip travellist.zip && mv travellist-laravel-demo-tutorial-1.0.1 bid_managment

docker compose build --no-cache

docker compose up -d

docker-compose exec app rm -rf vendor composer.lock

docker-compose exec app composer install

docker-compose exec app php artisan key:generate

php artisan schedule:work