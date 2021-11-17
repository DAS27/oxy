start:
	./vendor/bin/sail up -d

setup: install migrate seed

migrate:
	php artisan migrate

seed:
	php artisan db:seed
	php artisan module:seed

install:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan sail:install
