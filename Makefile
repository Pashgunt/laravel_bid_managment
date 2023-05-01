schedule:
	cd bid_managment && \
	docker exec -d bid_managment-app /bin/bash && \
	php artisan schedule:work

queue: 
	cd bid_managment && \
	docker exec -d bid_managment-app /bin/bash && \
	php artisan queue:work

migrate: 
	cd bid_managment && \
	docker exec -d bid_managment-app /bin/bash && \
	php artisan migrate

frontend:
	cd bid_managment/react && \
	npm run dev