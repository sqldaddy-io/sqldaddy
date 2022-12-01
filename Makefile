##################
# Variables
##################
DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml --env-file ./backend/.env

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

dc_up:
	${DOCKER_COMPOSE} up -d --remove-orphans

up_backand:
	${DOCKER_COMPOSE} up -d --no-deps --build backend

up_frontend:
	${DOCKER_COMPOSE} up -d --no-deps --build frontend

dc_ps:
	${DOCKER_COMPOSE} ps

dc_logs:
	${DOCKER_COMPOSE} logs -f

dc_down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

dc_restart:
	make dc_stop dc_start


##################
# App
##################

php:
	${DOCKER_COMPOSE} exec -u www-data backend bash

cache:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console cache:clear

messenger_up:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console messenger:consume async --limit=20

messenger_stop:
	${DOCKER_COMPOSE} exec -u www-data backend bin/console messenger:stop-workers

# gen_ssl:
#     docker-compose run --rm  certbot certonly --webroot --webroot-path /var/www/certbot/ -d sqldaddy.io
