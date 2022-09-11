FROM brdnlsrg/baseimage:php-light as backend

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

WORKDIR /app

#USER www-data