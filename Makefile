run: down build up php-install node-install node-dev

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

php-cli:
	docker-compose exec php-cli sh

php-install:
	docker-compose exec php-cli composer install

node-cli:
	docker-compose exec node sh

node-install:
	docker-compose exec node npm install

node-dev:
	docker-compose exec node npm run dev
