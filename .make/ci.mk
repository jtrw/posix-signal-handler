.PHONY: ci-push-all
ci-push-all: ## git push with deploying
	git push -o ci.variable="DEPLOY=1"

.PHONY:ci-push-skip
ci-push-skip: ## git push without deploying any brand
	git push -o ci.skip
