run-app-with-setup:
	docker compose up -d --build
	docker exec php /bin/sh -c "composer install && chmod -R 777 storage && php artisan key:generate && php artisan storage:link"

run-app-with-setup-db:
	docker compose up -d --build
	docker exec php /bin/sh -c "composer install && chmod -R 777 storage && php artisan key:generate && php artisan migrate:fresh --seed && php artisan storage:link"

run-app:
	docker compose up -d

kill-app:
	docker compose down

enter-nginx-container:
	docker exec -it nginx /bin/sh

enter-php-container:
	docker exec -it php /bin/sh

enter-mysql-container:
	docker exec -it mysql /bin/sh

flush-db:
	docker exec php /bin/sh -c "php artisan migrate:fresh"

flush-db-with-seeding:
	docker exec php /bin/sh -c "php artisan migrate:fresh --seed"