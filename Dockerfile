FROM php:8.4-fpm-alpine

# ១. តម្លើង System dependencies និង build tools
RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# ២. តម្លើង Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ៣. កំណត់ Working Directory
WORKDIR /var/www

# ៤. Copy Source Code ចូល Container
COPY . /var/www

EXPOSE 9000
CMD ["php-fpm"]