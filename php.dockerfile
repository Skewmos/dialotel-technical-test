FROM dunglas/frankenphp:sha-b32e738-php8.3

RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    amqp \
    redis \
    xdebug


WORKDIR /app