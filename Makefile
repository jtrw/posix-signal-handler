CUR_DIR = $(shell basename $(CURDIR))
MKFILE_PATH = $(abspath $(lastword $(MAKEFILE_LIST)))
FULL_DIR := $(dir $(MKFILE_PATH))

$(shell (if [ ! -e $(FULL_DIR)/.env ]; then cp default.env .env; fi))
include .env
export

export UID=$(shell ./uid.sh)
version = $(shell git describe --tags --dirty --always)
build_name = application-$(version)
# use the rest as arguments for "run"
RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
# ...and turn them into do-nothing targets
#$(eval $(RUN_ARGS):;@:)

include .make/ci.mk
include .make/utils.mk
include .make/composer.mk
include .make/static-analysis.mk

.PHONY: start
start: ##up-services ## spin up environment
	docker-compose up -d

.PHONY: tests
tests: ## look for service logs
	docker-compose run --rm --no-deps $(PHP_FPM) sh -lc 'php ./vendor/phpunit/phpunit/phpunit -c ./tests/phpunit.xml --testdox --stderr --coverage-clover=coverage.xml'
