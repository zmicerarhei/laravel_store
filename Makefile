.PHONY: help

# Makefile for Laravel Catalog Project

# Default target
all: create-env run install generate-key migrate seed

# Step 0: Create .env file from .env.example and set database connection
create-env:
	cp .env.example .env || echo ".env file already exists."

# Step 1: Run Docker containers
run:
	docker compose up -d --build

# Step 2: Install dependencies
install:
	docker compose exec -it app composer install

# Step 3: Generate application key
generate-key:
	docker compose exec -it app php artisan key:generate

# Step 4: Run migrations
migrate:
	docker compose exec -it app php artisan migrate

# Step 5: Seed the database
seed:
	docker compose exec -it app php artisan db:seed

# Step 6: Set permissions
permissions:
	sudo chmod 775 -R ./ && \
	sudo chown -R user:www-data storage/ && \
	sudo chown -R user:www-data bootstrap/cache/

# Clean up - stop and remove containers
clean:
	docker compose down


# Usefull commands

help: ## print help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

b: ## open bash in app container
	@docker compose exec -it app bash

ps: ## show running containers
	@docker ps

build: ## build all containers
	@docker compose up --build -d

start: ## start all containers
	@docker compose up --force-recreate -d

stop: ## stop all containers
	@docker compose down

restart: stop start ## restart all containers
	
setup-hooks: ## Set up Git hooks
	docker compose exec -it app vendor/bin/cghooks add