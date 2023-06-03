run: down build up

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

build:
	docker-compose build

php-cli:
	docker-compose exec php sh

node-cli:
	docker-compose exec node sh
