FROM php:8.3-fpm

# Устанавливаем зависимости и PHP-расширения
RUN apt-get update && apt-get install -y --no-install-recommends \
    cron \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    zip unzip \
    git && \
    docker-php-ext-install \
    pdo_mysql \
    bcmath \
    gd \
    zip \
    intl \
    sockets && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Добавляем кастомный php.ini
COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Копируем файл crontab
COPY ./_docker/app/laravel_cron /etc/cron.d/laravel_cron

# Устанавливаем права и регистрируем crontab
RUN chmod 0644 /etc/cron.d/laravel_cron && crontab /etc/cron.d/laravel_cron

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаем пользователя и добавляем его в нужные группы
ARG USER_ID=1000
RUN useradd -u ${USER_ID} -m -s /bin/bash user \
    && usermod -a -G www-data user \
    && mkdir -p /home/user/.composer \
    && chown -R user:user /home/user

# Подготавливаем каталоги Laravel
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache && \
    chown -R user:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Создаем директорию для composer cache
RUN mkdir -p /var/www/.composer && \
    chown -R user:www-data /var/www/.composer

# Переключаемся на пользователя
USER user

# Настраиваем переменные окружения для composer
ENV COMPOSER_HOME=/var/www/.composer
ENV PATH="${PATH}:/var/www/.composer/vendor/bin"

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Устанавливаем команду на случай использования в режиме PHP-FPM
CMD ["php-fpm"]