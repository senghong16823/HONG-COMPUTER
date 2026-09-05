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
    icu-dev \
    postgresql-dev \
    $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip intl opcache

# ២. តម្លើង Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ៣. កំណត់ PHP Configuration
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/docker-php-custom.ini

# ៤. កំណត់ Working Directory
WORKDIR /var/www

# ៥. Copy Source Code ចូល Container
COPY . /var/www

EXPOSE 9000
CMD ["php-fpm"]