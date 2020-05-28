FROM php:7.4-fpm
WORKDIR "/www"

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    libicu-dev \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    libbz2-dev \
    libonig-dev \
    libmagickwand-dev \
    libjpeg62-turbo-dev \
    curl \
    git \
    wget \
    libzip-dev \
    zip \
    zlibc \
    subversion \
    libmcrypt-dev \
  && rm -rf /var/lib/apt/lists/*  \
  && pecl install mcrypt-1.0.3 \
  && pecl install imagick \
   && wget https://github.com/luvvien/resources/raw/master/ghostscript-9.22-linux-x86_64.tar.gz \
      && tar -xzvf ghostscript-9.22-linux-x86_64.tar.gz \
      && cd ghostscript-9.22-linux-x86_64 \
      && cp gs-922-linux-x86_64 /usr/local/bin/gs \
      && cp gs-922-linux-x86_64 /usr/bin/gs \
      && rm ../ghostscript-9.22-linux-x86_64.tar.gz \
      && rm -rf ghostscript-9.22-linux-x86_64

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
        mysqli \
        intl \
        mbstring \
        gd \
        pcntl \
        pdo_mysql
