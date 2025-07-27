FROM php:8.4-fpm

ARG WORKDIR
WORKDIR ${WORKDIR}

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    vim \
    rsync \
    cron \
    wget \
    zip \
    libzip-dev \
    libxml2-dev \
    zlib1g-dev \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-install \
        exif \
        zip \
        soap \
        gd \
        intl \
        pdo \
        pdo_mysql \
    && apt-get clean

# PHP Extension Installer + additional moduls
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions http opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Start script
COPY ./docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 9000
CMD ["/start.sh"]