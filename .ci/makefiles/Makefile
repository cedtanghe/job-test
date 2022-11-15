COMPOSE ?= docker-compose
REGISTRY_HOSTNAME = registry.oxygem.tv
CI_CONF_FILES_PATH = .ci
NPM_CONFIGURATION_FILE = .npmrc
GIT_CONF_FILES_PATH = ~/git-config
GIT_HOOK_PATH = .git/hooks
SHELL = /bin/bash
# Defined the default target if none is used when we call make
.DEFAULT_GOAL := install
# Bash output format
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m
COLOR_RED     = \033[31m
COLOR_SUCCESS = \033[1;90;42m
RESET_LINE 	  = \033[1A

.PHONY: configure start
## Call targets << network >> << proxy >>
configure: network proxy
## Call targets << configure >> << containers >>
start: configure containers

.PHONY: network
## Create the docker network of the project
network:
	@if ! docker network ls -f 'name=$(NETWORK)' | grep -qw $(NETWORK); then \
		printf "\e[33mCreate network $(NETWORK)\e[0m\n"; \
		docker network create $(NETWORK) &> /dev/null; \
		sleep 3; \
	fi

.PHONY: proxy
## Create or start nginx-proxy and connect it to our docker network
proxy:
	@if [ -z $$(docker ps -aqf "name=traefik") ]; then \
		printf "\e[33mCreating proxy container traefik\e[0m\n"; \
		docker run -d \
		  -v /var/run/docker.sock:/var/run/docker.sock \
		  -p 80:80 \
		  -p 8080:8080 \
		  --name traefik \
		  traefik:1.7.18 \
		  --api --docker --logLevel=INFO; \
	elif ! docker ps -aqf "name=traefik" --format "{{.Status}}" | grep --quiet 'Up'; then \
		printf "\e[33mStarting proxy container traefik\e[0m\n"; \
		docker start $$(docker ps -aqf "name=traefik"); \
	else \
		printf "\e[33mProxy container traefik is already running\e[0m\n"; \
	fi
	@docker network connect ${NETWORK} traefik &> /dev/null || true
	@printf "\e[32mDon't forget to add project domain(s) in your /etc/hosts file\e[0m\n"

.PHONY: containers
## docker-compose up -d
containers:
	$(COMPOSE) up -d

.PHONY: help
## Display this help and exit
help:
	@ \
	printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"; \
	printf " make [target]\n\n"; \
	printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"; \
	awk '/^[a-zA-Z\-_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpDependencies = substr($$0, index($$0, ":") + 2, length($$0)); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			spaces = 60; \
			if (length(helpDependencies)) { \
			    spaces = spaces + 1; \
			} \
			spaces = spaces - length($$0); \
			printf " ${COLOR_INFO}%s${COLOR_RESET} ${COLOR_RED}%s${COLOR_RESET} %"'spaces'"s%s\n", helpCommand, helpDependencies, "", helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST) | sort

.PHONY: disconnect-and-stop-traefik
## Disconnect traefik from docker network and stop it
disconnect-and-stop-traefik:
	docker network disconnect $(NETWORK) traefik || true
	docker rm -f traefik || true

.PHONY: dc-stop
## Stops containers
dc-stop: disconnect-and-stop-traefik
	$(COMPOSE) stop

.PHONY: dc-down
## Stops and removes containers and networks
dc-down: disconnect-and-stop-traefik
	$(COMPOSE) down

.PHONY: dc-down-rmi
## Stops and removes containers, networks and images
dc-down-rmi: disconnect-and-stop-traefik
	$(COMPOSE) down --rmi 'local' --remove-orphans

.PHONY: dc-erase
## Stops and removes containers, networks, images and volumes
dc-erase: disconnect-and-stop-traefik
	$(COMPOSE) down -v --rmi 'local' --remove-orphans
