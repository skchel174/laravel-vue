run: down build up

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

php-cli:
	docker-compose exec php-cli sh

node-cli:
	docker-compose exec node sh

php-install:
	docker-compose exec php-cli composer install

node-install:
	docker-compose exec node npm install
