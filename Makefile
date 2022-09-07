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

## Download CI configuration files
.ci/makefiles/Makefile:
	@curl \
		--silent \
		-H 'PRIVATE-TOKEN: MbmkKbvyrmDYu_jLNotx' \
		https://gitlab.oxygem.tv/api/v4/projects/579/repository/files/install-config-files.sh?ref=master \
		| sed -En 's/.*"content":"(.*)".*/\1/p' | base64 --decode | bash -s - $@

.PHONY: composer
## Install composer dependencies
composer:
	$(COMPOSE) run --rm cli bash -c 'export APP_ENV=$(APP_ENV); composer install $(COMPOSER_ARGS)'

.PHONY: node
## Install node dependencies
node:
	$(COMPOSE) run --rm node npm install