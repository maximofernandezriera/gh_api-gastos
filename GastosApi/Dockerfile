# Imatge base de PHP amb Nginx
FROM php:8.4-fpm

# Instal·lem dependències per a PHP i altres eines necessàries
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instal·lem Composer per gestionar les dependències de Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuració del directori de treball
WORKDIR /var/www

# Copiem els arxius de l'aplicació dins del contenidor
COPY . .

# Instal·lem les dependències de Laravel amb Composer
RUN composer install --no-dev --optimize-autoloader

# Exposem el port en el qual Laravel està corrent (per defecte, 8000)
EXPOSE 8000

# Comandament per iniciar el servidor Laravel
CMD ["php-fpm"]