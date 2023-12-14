DOCKER = docker
DOCKER_COMPOSE = docker compose
EXEC = $(DOCKER_COMPOSE) run --rm

APP = $(DOCKER_COMPOSE) exec app
COMPOSER = $(EXEC) composer
NPM = $(EXEC) npm

SYMFONY_CONSOLE = $(APP) bin/console
PHP_CS_FIXER = $(APP) ./vendor/bin/phpcs -v --standard=PSR12 --ignore=./src/Kernel.php ./src
PHP_CBF = $(APP) ./vendor/bin/phpcbf -v --standard=PSR12 --ignore=./src/Kernel.php ./src
PHP_STAN = $(APP) ./vendor/bin/phpstan analyse src tests


## —— App ——
init: ## Init the project
	$(MAKE) start
	$(MAKE) composer-install
	$(MAKE) npm-install

cache-clear: ## Clear cache
	$(SYMFONY_CONSOLE) cache:clear

## —— Docker ——
start: ## Start app
	$(MAKE) docker-start
docker-start:
	$(DOCKER_COMPOSE) up -d
stop: ## Stop app
	$(MAKE) docker-stop
docker-stop:
	$(DOCKER_COMPOSE) down

## —— Code quality ——

php-cs:
	$(PHP_CS_FIXER)

php-cbf:
	$(PHP_CBF)

php-stan:
	$(PHP_STAN)

cs-cbf:
	$(MAKE) php-cs
	$(MAKE) php-cbf

php-cs-cbf-stan:
	$(MAKE) cs-cbf
	$(MAKE) php-stan

## —— Composer ——
composer-install: ## Install dependencies
	$(COMPOSER) install

composer-update: ## Update dependencies
	$(COMPOSER) update

## —— NPM —————————————————————————————————————————————————————————————————
npm-install: ## Install all npm dependencies
	$(NPM) install

npm-update: ## Update all npm dependencies
	$(NPM) update

npm-watch: ## Update all npm dependencies
	$(NPM) run watch

## —— Database ——
database-init: ## Init database
	$(MAKE) database-drop
	$(MAKE) database-create
	$(MAKE) database-migrate
	$(MAKE) database-fixtures-load

database-drop: ## Create database
	$(SYMFONY_CONSOLE) d:d:d --force --if-exists

database-create: ## Create database
	$(SYMFONY_CONSOLE) d:d:c --if-not-exists

database-remove: ## Drop database
	$(SYMFONY_CONSOLE) d:d:d --force --if-exists

database-migration: ## Make migration
	$(SYMFONY_CONSOLE) make:migration

migration: ## Alias : database-migration
	$(MAKE) database-migration

database-migrate: ## Migrate migrations
	$(SYMFONY_CONSOLE) d:m:m --no-interaction

migrate: ## Alias : database-migrate
	$(MAKE) database-migrate

database-fixtures-load: ## Load fixtures
	$(SYMFONY_CONSOLE) d:f:l --no-interaction

fixtures: ## Alias : database-fixtures-load
	$(MAKE) database-fixtures-load

## —— 🛠️  Others ——
help: ## List of commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

