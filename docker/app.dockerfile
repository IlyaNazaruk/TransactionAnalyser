FROM php:8.2-fpm

RUN apt update && apt install -y \
    software-properties-common \
    unzip \
    zip \
    git \
    wget \
    curl \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

ADD ./docker/php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath mysqli \
    && docker-php-ext-configure mysqli \
    && docker-php-ext-install pdo_mysql pdo

# Set working directory
WORKDIR /var/www/html
