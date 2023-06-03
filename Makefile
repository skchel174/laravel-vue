run: down build up

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

build:
	docker-compose build

node-cli:
	docker-compose exec node sh
