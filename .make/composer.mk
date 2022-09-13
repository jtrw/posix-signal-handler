.PHONY: composer-install
composer-install: ## Install project dependencies
	docker-compose run --rm --no-deps $(PHP_FPM) sh -lc 'composer install -vvv'

.PHONY: composer-install-no-dev
composer-install-no-dev: ## Install project dependencies without dev
	docker-compose run --rm --no-deps $(PHP_FPM) sh -lc 'composer install --no-dev'

.PHONY: composer-update
composer-update: ## Update project dependencies
	docker-compose run --rm --no-deps $(PHP_FPM) sh -lc 'composer update'

.PHONY: composer-outdated
composer-outdated: ## Show outdated project dependencies
	docker-compose run --rm --no-deps $(PHP_FPM) sh -lc 'composer outdated'

.PHONY: composer-validate
composer-validate: ## Validate composer config
		docker-compose run --rm --no-deps $(PHP_FPM) sh -lc 'composer validate --no-check-publish'

.PHONY: composer
composer: ## Execute composer command
	docker-compose run --rm --no-deps $(PHP_FPM) sh -lc "composer $(RUN_ARGS)"