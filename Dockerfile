# Используем официальный образ PHP для Symfony
FROM php:8.1-fpm

# Установка необходимых зависимостей и инструментов
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    apt-utils \
    && docker-php-ext-install pdo pdo_pgsql

# Копирование и установка зависимостей Composer
COPY composer.lock composer.json /var/www/html/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader --no-dev

# Копирование файлов проекта
COPY . /var/www/html

# Установка правильных разрешений на директории и файлы
RUN chown -R www-data:www-data /var/www/html

# Установка правильного пользователя
USER www-data

# Генерация автозагрузки и кэша Symfony
RUN composer dump-autoload --optimize
RUN php bin/console cache:clear --no-debug --no-warmup
RUN php bin/console cache:warmup

# Установка рабочей директории
WORKDIR /var/www/html

# Указываем порт, на котором будет запущено приложение Symfony
EXPOSE 8000

# Запуск приложения
CMD ["php", "bin/console", "server:run", "0.0.0.0:8000"]
