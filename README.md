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

-   Then use Makefile for project installing
    (You have to make sure, that you have Docker Compose v.2^ and make utility installed. Also during the installation process,
    you may be asked to enter a password to configure access to the project directories.)

```shell
   make
```

# Usage

-   To see the product catalog, go to http://localhost:8000/products

(In order to check out admin functionality you have to register new account and set the role as a admin in DB for this user)

-   To use the admin panel, go to http://localhost:8000/admin/products
