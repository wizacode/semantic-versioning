check: cs stan ## (PHP) Launch all lint tools. A good choice for pre-commit hook

cs: vendor/bin ## (PHP) Code style checker
	@echo
	./vendor/bin/php-cs-fixer fix -v --dry-run --allow-risky=yes --using-cache=no src/

fix: vendor/bin ## (PHP) Code style fixer
	@echo
	./vendor/bin/php-cs-fixer fix --verbose --allow-risky=yes src/

stan: vendor/bin ## (PHP) Static analysis
	@echo
	./vendor/bin/phpstan analyse -l max src

test: unit ## (PHP) Launch all test tools

unit: vendor/bin ## (PHP) Unit tests
	@echo
	./vendor/bin/phpunit --coverage-text --coverage-html var/coverage-report

vendor/bin:
	@echo
	composer install
