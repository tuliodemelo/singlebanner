FROM php:7.1.17-fpm

RUN apt-get update \
    && apt-get install -y \
    cron \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libxslt1-dev \
	mysql-client \
	vim

RUN docker-php-ext-configure \
  gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install \
  gd \
  intl \
  mbstring \
  mcrypt \
  pdo_mysql \
  soap \
  xsl \
  zip \
  bcmath

RUN curl -sS https://getcomposer.org/installer | \
    php -- \
      --install-dir=/usr/local/bin \
      --filename=composer \
      --version=1.6.5

RUN apt-get update \
    && apt-get install -y \
    && pecl install xdebug  \
    && docker-php-ext-enable xdebug

ADD ./conf/xdebug.ini /usr/local/etc/php/conf.d/

ENV PHP_MEMORY_LIMIT 2G
ENV PHP_PORT 9000
ENV PHP_PM dynamic
ENV PHP_PM_MAX_CHILDREN 48
ENV PHP_PM_START_SERVERS 13
ENV PHP_PM_MIN_SPARE_SERVERS 13
ENV PHP_PM_MAX_SPARE_SERVERS 24
ENV APP_MAGE_MODE develop

COPY ./conf/www.conf /usr/local/etc/php-fpm.d/
COPY ./conf/php.ini /usr/local/etc/php/
COPY ./conf/php-fpm.conf /usr/local/etc/
COPY ./bin/start /usr/local/bin/start

# Crontab
ADD ./conf/magento-cron /magento-cron
RUN /usr/bin/crontab /magento-cron
CMD ["/usr/sbin/crond"]

WORKDIR /src/www

# Setup script
RUN chmod +x /usr/local/bin/start
CMD ["/usr/local/bin/start"]