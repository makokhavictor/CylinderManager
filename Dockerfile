# Use the official PHP 8.1 Alpine image as the base image
FROM php:8.1-alpine

# Set the working directory to /app
WORKDIR /app

# Copy the composer.lock and composer.json files to the image
COPY composer.lock composer.json ./

# Install composer and dependencies
RUN apk add --no-cache git && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application files to the image


# Install dependencies for image support
RUN apk add --no-cache zip \
    unzip \
    git \
    postgresql-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-xpm --with-freetype \
    && docker-php-ext-install gd

# Install PostgreSQL extension
RUN apk add --no-cache postgresql-dev && docker-php-ext-install pdo pdo_pgsql

# Set the environment variables
# ENV DB_CONNECTION=pgsql
# ENV DB_HOST=db
# ENV DB_PORT=5432
# ENV DB_DATABASE=mydatabase
# ENV DB_USERNAME=mydatabaseuser
# ENV DB_PASSWORD=mypassword

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
