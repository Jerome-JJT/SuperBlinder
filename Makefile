
# APP_NAME	= superbli

COMPOSE_DIR	= -f docker-compose.yml
# ENV_FILE	= --env-file .env

#COMPOSE_DIR	= -f bonus/bonus-compose.yml
ENV_FILE	= --env-file .env.example
DOCKER		= docker-compose ${COMPOSE_DIR} ${ENV_FILE} 
# DOCKER		= docker-compose ${COMPOSE_DIR} ${ENV_FILE} -p ${APP_NAME}

RM			= rm -rf


all:		build start


build:		#wordpress nginx mariadb
		${DOCKER} build --no-cache

ps:
		${DOCKER} ps -a

logs:
		${DOCKER} logs

flogs:
	${DOCKER} logs -f

run:
		${DOCKER} exec -it server bash

reserver:
		${DOCKER} restart server

db:
		${DOCKER} exec -it mysql bash

dbnormal:
	${DOCKER} exec -it mysql mysql -u root -p -e "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"

dblogging:
	${DOCKER} exec -it mysql mysql -u root -p -e "SET global log_output = 'FILE'; SET global general_log_file='/mysql.log'; SET global general_log = 1;"

start:
		${DOCKER} up -d

down:
		${DOCKER} down

clean: down
		# ${DOCKER} down --volumes

re:		clean all

.PHONY:		all build wordpress nginx mariadb start down clean re