run: start node-run-dev

init: down build up composer-install npm-install node-run-dev

start:
	docker-compose start

stop:
	docker-compose stop

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

composer-install:
	docker-compose exec php composer install

npm-install:
	docker-compose exec node npm install

node-run-dev:
	docker-compose exec node npm run dev
