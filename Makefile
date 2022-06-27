tester = vendor/bin/tester
tests_dir = tests/
coverage_name = $(tests_dir)coverage.html
php_bin = php

.PHONY: test coverage clean
test:
		@$(tester) -p $(php_bin) -C $(tests_dir)

coverage:
		@$(tester) -p $(php_bin) -C --coverage $(coverage_name) --coverage-src src/ $(tests_dir)

clean:
		@rm -f $(coverage_name)
