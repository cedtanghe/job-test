# Initialize variables
NETWORK = jobtest
COMPOSER_ARGS = --no-interaction -a
APP_ENV ?= dev

-include .ci/makefiles/Makefile

.PHONY: install
## Install the project
install: configure containers dependencies

.PHONY: dependencies
## Install the project's dependencies
dependencies: node composer

.PHONY: composer
## Install composer dependencies
composer:
	$(COMPOSE) run --rm cli bash -c 'export APP_ENV=$(APP_ENV); composer install $(COMPOSER_ARGS)'

.PHONY: node
## Install node dependencies
node:
	$(COMPOSE) run --rm node npm install

.PHONY: fixtures
## Load fixtures
fixtures:
	$(COMPOSE) run --rm cli bash -c 'APP_ENV=$(APP_ENV) bin/console hautelook:fixtures:load'; \

.PHONY: rights
## Rights
rights:
	$(COMPOSE) run --rm cli chmod 777 -R var/cache
	$(COMPOSE) exec phpmyadmin bash -c 'chmod -v 0555 /etc/phpmyadmin/config.inc.php'