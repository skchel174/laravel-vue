run: down build up composer-install

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
