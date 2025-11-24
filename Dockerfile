FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

RUN chmod -R 777 /var/www/html/files

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "router.php"]
