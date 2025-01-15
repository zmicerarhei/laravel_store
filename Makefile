.PHONY: help

# Makefile for Laravel Catalog Project

# Variables
DOCKER_COMPOSE := docker compose
USER_ID := 1000

# Default target
all: create-env run install generate-key migrate seed permissions

# Step 0: Create .env file from .env.example and set database connection
create-env:
	cp .env.example .env || echo ".env file already exists." && \
	sed -i 's/^DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env && \
	sed -i 's/^# DB_HOST=.*/DB_HOST=mysql/' .env && \
	sed -i 's/^# DB_PORT=.*/DB_PORT=3306/' .env && \
	sed -i 's/^# DB_DATABASE=.*/DB_DATABASE=laravel_db/' .env && \
	sed -i 's/^# DB_USERNAME=.*/DB_USERNAME=user/' .env && \
	sed -i 's/^# DB_PASSWORD=.*/DB_PASSWORD=userpassword/' .env 

# Step 1: Run Docker containers
run:
	$(DOCKER_COMPOSE) up -d --build

# Step 2: Install dependencies
install:
	$(DOCKER_COMPOSE) exec -u $(USER_ID) -it app composer install

# Step 3: Generate application key
generate-key:
	$(DOCKER_COMPOSE) exec -u $(USER_ID) -it app php artisan key:generate

# Step 4: Run migrations
migrate:
	$(DOCKER_COMPOSE) exec -u $(USER_ID) -it app php artisan migrate

# Step 5: Seed the database
seed:
	$(DOCKER_COMPOSE) exec -u $(USER_ID) -it app php artisan db:seed

# Step 6: Set permissions
permissions:
	sudo chmod 755 -R ./ && \
	sudo chown -R www-data:www-data storage/ && \
	sudo chown -R www-data:www-data bootstrap/cache/

# Clean up - stop and remove containers
clean:
	$(DOCKER_COMPOSE) down


# Usefull commands

help: ## print help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

temp: ## temp
	@echo temp

ps: ## show running containers
	@docker ps

build: ## build all containers
	@docker compose up --build -d

start: ## start all containers
	@docker compose up --force-recreate -d

stop: ## stop all containers
	@docker compose down

restart: stop start ## restart all containers
	