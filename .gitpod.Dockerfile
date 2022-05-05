# Use the Gitpod full environment as the base
FROM gitpod/workspace-full

# Install PHP8.1 and MySQL client for CLI database access
USER root
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update && apt-get install -y mysql-client && apt-get clean && rm -rf /var/cache/apt/* && rm -rf /var/lib/apt/lists/* && rm -rf /tmp/*
RUN install-packages php8.1 \
    php8.1-dev \
    php8.1-bcmath \
    php8.1-ctype \
    php8.1-curl \
    php8.1-dom \
    php8.1-gd \
    php8.1-intl \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-pgsql \
    php8.1-sqlite3 \
    php8.1-tokenizer \
    php8.1-xml \
    php8.1-zip
RUN update-alternatives --set php /usr/bin/php8.1
# Set up default config file for CLI to connect to the project DB
RUN echo "[mysql]" > /etc/mysql/conf.d/mysql.cnf
RUN echo "host=0.0.0.0" >> /etc/mysql/conf.d/mysql.cnf
RUN echo "user=uberflip" >> /etc/mysql/conf.d/mysql.cnf
RUN echo "password=pass123" >> /etc/mysql/conf.d/mysql.cnf
RUN echo "database=university" >> /etc/mysql/conf.d/mysql.cnf

# Install the newest version of Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set up Sail alias, even if they don't choose Laravel, then this image can be reused
RUN echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.bashrc
