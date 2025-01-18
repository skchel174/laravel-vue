init: down build up

build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down --remove-orphans

php-cli:
	docker compose exec php-cli sh

node-cli:
	docker compose exec node sh
