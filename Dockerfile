FROM php:7.4-fpm

LABEL version="1.0.0" description="php74fpm" maintainer="moizesdocker<moizes@gmail.com>"

# Arguments defined in docker-compose.yml
ARG user=userdev
ARG uid=1000

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    p7zip \
    libzip-dev \
    libzip-dev \ 
    libwebp-dev \
    libxpm-dev 
    
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath calendar

# old com erro
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
# new
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install gd

RUN docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-install pdo_mysql \
    && pecl install redis-4.3.0 \
    && docker-php-ext-enable redis

# for mysqli if you want
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Get latest Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/html

USER $user
