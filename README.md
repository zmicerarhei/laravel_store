# laravel-catalog

Simple products catalog with client and admin functionality

_The project was developed as part of an internship at the Innowise_.

# Techs

-   PHP 8.3
-   Laravel 11
-   MySQL
-   jQuery
-   HTML/CSS
-   Bootstrap 4
-   Docker

# Installation

-   At first clone the repository:

```shell
   git clone https://github.com/zmicerarhei/laravel_store.git
```

-   Go to the project directory:

```shell
   cd laravel_store
```

-   Then create a .env file like .env.example and replace the variables for connecting to the database with the following:

        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=laravel_db
        DB_USERNAME=user
        DB_PASSWORD=userpassword

-   Then run containers with the required dependencies:

```shell
    docker compose up -d --build
```

-   Apply the necessary migrations and seeds:

```shell
    docker compose exec -it app php artisan migrate
```

```shell
    docker compose exec -it app php artisan db:seed
```

-   Generate application key:

```shell
    docker compose exec -it app php artisan key:generate
```

-   Set up access for the project directories:

```shell
    sudo chmod 755 -R ./
    sudo chown -R www-data:www-data storage/
    sudo chown -R www-data:www-data bootstrap/cache/
```

# Usage

-   To see the product catalog, go to http://localhost:8000/products
-   To use the admin panel, go to http://localhost:8000/admin/products
