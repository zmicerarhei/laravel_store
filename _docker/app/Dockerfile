FROM php:8.3-fpm

# Установка зависимостей и расширений PHP
RUN apt-get update && apt-get install -y \
      apt-utils \
      cron \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      libicu-dev \             
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-install intl && \
      docker-php-ext-install sockets && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Добавляем кастомный php.ini
COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Копируем файл crontab
COPY ./_docker/app/laravel_cron /etc/cron.d/laravel_cron

# Устанавливаем права для cron-файла
RUN chmod 0644 /etc/cron.d/laravel_cron

# Регистрируем crontab
RUN crontab /etc/cron.d/laravel_cron

# Установка Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Добавляем пользователя с UID 1000 и добавляем его в группу www-data
RUN useradd -u 1000 -m -s /bin/bash user \
    && usermod -a -G www-data user \
    && mkdir -p /var/www \
    && chown -R user:www-data /var/www \
    && chmod -R 775 /var/www

# Переключаемся на нового пользователя
USER user

# Устанавливаем рабочую директорию
WORKDIR /var/www

CMD service cron start && php-fpm