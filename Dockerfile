# Dockerfile EVILLALBA, Laravel and Lumen Framework

# Pull base image ubuntu
FROM ubuntu:18.04

# Install common tools 
RUN apt-get update
RUN apt-get install -y wget curl nano htop git unzip bzip2 software-properties-common locales

# Set env var to enable xterm terminal
ENV TERM=xterm

# Set timezone to UTC to avoid tzdata interactive mode during build
ENV TZ=Etc/UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Set working directory
WORKDIR /var/www/html

# Application Specific
# Install PHP 7.4 and ext
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt update
RUN apt-get install -y \
    php7.4-fpm \ 
    php7.4-common \ 
    php7.4-curl \ 
    php7.4-mysql \ 
    php7.4-mbstring \ 
    php7.4-json \
    php7.4-xml \
    php7.4-bcmath

# Install NPM and Node.js
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs 

# FPM & Nginx configuration, VH
# Config fpm to use TCP instead of unix socket
ADD images/nginx/www.conf /etc/php/7.4/fpm/pool.d/www.conf
RUN mkdir -p /var/run/php

# Install Nginx
RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys ABF5BD827BD9BF62
RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 4F4EA0AAE5267A6C
RUN echo "deb http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN echo "deb-src http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN apt-get update
RUN apt-get install -y nginx

ADD images/nginx/default /etc/nginx/sites-enabled/
ADD images/nginx/nginx.conf /etc/nginx/

# Composer & Laravel/Lumen configuration
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Supervisor Process Manager
# Install supervisor
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor
ADD images/nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Container Config
# Expose port 80
EXPOSE 80

# Set supervisor to manage container processes
ENTRYPOINT ["/usr/bin/supervisord"]