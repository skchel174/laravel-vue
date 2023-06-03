run: down build up composer-install npm-install node-run-dev

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

build:
	docker-compose build

#Backend
php-cli:
	docker-compose exec php sh

composer-install:
	docker-compose exec php composer install

db-migrate:
	docker-compose exec php php artisan migrate

#Frontend
node-cli:
	docker-compose exec node sh

npm-install:
	docker-compose exec node npm install

node-run-dev:
	docker-compose exec node npm run dev
