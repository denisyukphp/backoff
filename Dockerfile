FROM php:8.2-cli

RUN \
    apt-get update ; \
    apt-get install -y unzip ; \
    pecl install pcov ; \
    docker-php-ext-enable pcov ;

COPY --from=composer:2.4 /usr/bin/composer /usr/local/bin/composer

WORKDIR /usr/local/packages/backoff/
