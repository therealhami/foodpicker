FROM dunglas/frankenphp

RUN apt update \
    &&  curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt install -y nodejs \
    && apt-get install -y libzip-dev \
    && docker-php-ext-install zip

RUN npm install -g yarn

WORKDIR /var/www/foodpicker

RUN rm -rf /etc/caddy/Caddyfile

ADD Caddyfile /etc/caddy

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
