## About laravel-blog

A simple blog site having a CRUD feature using the Laravel framework.

## To run unit test

php vendor/bin/phpunit --coverage-html tests/codecoverage

php artisan test

## To pass sonar qube quality test. Run these reports and add same path in sonar-project.properties file.
 php vendor/bin/phpunit --coverage-html tests/codecoverage/html
 php vendor/bin/phpunit --junit tests/codecoverage/tests-report.xml
 php vendor/bin/phpunit --coverage-clover tests/codecoverage/coverage-report.xml