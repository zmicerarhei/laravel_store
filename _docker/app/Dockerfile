FROM php:8.3-fpm

# Установка зависимостей и расширений PHP
RUN apt-get update && apt-get install -y \
      apt-utils \
      cron \
      sudo \
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
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаем пользователя и добавляем его в нужные группы
ARG USER_ID=1000
RUN useradd -u ${USER_ID} -m -s /bin/bash user \
    && usermod -a -G www-data user \
    && mkdir -p /home/user/.composer \
    && chown -R user:user /home/user

# Даем права sudo на запуск cron без пароля
RUN echo "user ALL=(ALL) NOPASSWD: /etc/init.d/cron start" >> /etc/sudoers.d/user

# Создаем необходимые директории Laravel
RUN mkdir -p /var/www/storage/logs \
    /var/www/storage/framework/cache \
    /var/www/storage/framework/sessions \
    /var/www/storage/framework/views \
    /var/www/bootstrap/cache

# Устанавливаем правильные права
RUN chown -R user:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache \
    && find /var/www/storage -type d -exec chmod g+s {} \; \
    && find /var/www/bootstrap/cache -type d -exec chmod g+s {} \;

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

# Запускаем cron через sudo и php-fpm
CMD sudo /etc/init.d/cron start && php-fpm