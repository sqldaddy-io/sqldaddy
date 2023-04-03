##################
# Variables
##################
DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml -f ./docker/docker-compose-databases.yml --env-file ./backend/.env

DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

##################
# Docker compose
##################

dc_build:
	${DOCKER_COMPOSE} build

dc_start:
	${DOCKER_COMPOSE} start

dc_stop:
	${DOCKER_COMPOSE} stop

dc_ps:
	${DOCKER_COMPOSE} ps

dc_logs:
	${DOCKER_COMPOSE} logs -f

dc_down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

dc_restart:
	make dc_stop dc_start

dc_up:
	${DOCKER_COMPOSE} up -d --remove-orphans

up_backand:
	${DOCKER_COMPOSE} up -d --no-deps --build backend

up_frontend:
	${DOCKER_COMPOSE} up -d --no-deps --build frontend

up_mercure:
	${DOCKER_COMPOSE} up -d --no-deps --build mercure

up_webserver:
	${DOCKER_COMPOSE} up -d --no-deps --build webserver


##################
# App
##################

messenger_up:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console messenger:consume async --limit=20

messenger_stop:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console messenger:stop-workers

##################
# symfony app
##################

php:
	${DOCKER_COMPOSE} exec -u www-data backend bash

cache:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console cache:clear

messenger_up:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console messenger:consume async --limit=20

messenger_stop:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console messenger:stop-workers
