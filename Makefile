start:
	setup
	./vendor/bin/sail up -d

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	php artisan sail:install
	migrate
	seed

migrate:
	php artisan migrate

seed:
	php artisan db:seed
	php artisan module:seed

