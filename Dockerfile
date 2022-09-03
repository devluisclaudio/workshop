FROM php:8.1-fpm

#Instalação de pacotes
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update && apt-get install -y \
    build-essential \
    libedit-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nano \
    bash \
    cron \
    libpq-dev \
    net-tools


RUN apt-get install libxml2-dev -y
RUN echo "America/Sao_Paulo" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql xml opcache soap zip exif pcntl 
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ 
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN /bin/bash -c 'find /var/www/html -type f -exec chmod 0640 {} \;'
# RUN /bin/bash -c 'find /var/www/html -type d -exec chmod 2750 {} \;'
# RUN chown -R www-data. /var/www/html
# RUN chmod 0777 /env.php /init.sh /bin/artisan /bin/composer /bin/quickstart
RUN export TERM=xterm


EXPOSE 9000
WORKDIR /var/www/html