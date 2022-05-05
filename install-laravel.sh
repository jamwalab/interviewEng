#!/bin/bash

# This script will install the Laravel Sail container and
# configure it for Gitpod.

# Create the app
docker info > /dev/null 2>&1

# Ensure that Docker is running...
if [ $? -ne 0 ]; then
    echo "Docker is not running."
    exit 1
fi

# Create Laravel project
docker run --rm -v "$(pwd)":/opt -w /opt --platform=linux/amd64 laravelsail/php80-composer:latest bash -c "laravel new university && cd university && php ./artisan sail:install --with=selenium "

cd university

# Make sure the user owns all of the new files
sudo chown -R $USER: .

# Install Tailwind CSS
npm install
npm install -D tailwindcss@3 postcss@8 autoprefixer@10
npx tailwindcss init
echo "@tailwind base;" >> resources/css/app.css
echo "@tailwind components;" >> resources/css/app.css
echo "@tailwind utilities;" >> resources/css/app.css
sed -i 's/^        \/\//        require(\d39tailwindcss\d39),/' webpack.mix.js
sed -i 's|content: \[\]|content: \[\
    ".\/resources\/views\/*.blade.php",\
    ".\/resources\/js\/*.js",\
    ".\/resources\/js\/*.ts",\
  \]|' tailwind.config.js

# Copy welcome HTML to default Laravel view, customize
cp ../web/index.html resources/views/welcome.blade.php
cp ../web/assets/* public/
sed -i 's/<link href="assets\//<link href="/' resources/views/welcome.blade.php
sed -i '/<link/a\        <link rel="stylesheet" href="/css/app.css" />' resources/views/welcome.blade.php
sed -i '/<body/a\        <div class="container mx-auto p-4">' resources/views/welcome.blade.php
sed -i '/<\d47body/i\        <\d47div>' resources/views/welcome.blade.php
sed -i 's/<img src="assets\//    <img class="w-16 h-16 mr-4 float-left" src="/' resources/views/welcome.blade.php
sed -i 's/<h1>Welcome to the Uberflip Technical Challenge/    <h1>{{ $title ?? \d39Welcome to the Uberflip Technical Challenge\d39 }}/' resources/views/welcome.blade.php

# Modify default .env.example to work in Gitpod
sed -i 's/APP_NAME=.*/APP_NAME=University/' .env.example
sed -i 's/APP_URL=.*/APP_URL="${GITPOD_WORKSPACE_URL}"/' .env.example
sed -i '/^APP_URL/a APP_PORT=9080' .env.example
sed -i 's/DB_HOST=.*/DB_HOST=db/' .env.example
sed -i 's/DB_USERNAME=.*/DB_USERNAME=uberflip/' .env.example
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=pass123/' .env.example

# Modify the Sail docker-compose to work with our external network
sed -i 's/- sail/- sail\n            - local/g' docker-compose.yml
sed -i '/^networks:/a\    local:\n        external: true' docker-compose.yml

cd ..

# Add the port config to .gitpod.yml
sed -i '/^ports:/a\  - port: 6379\n    onOpen: ignore' .gitpod.yml
sed -i '/^ports:/a\  - port: 1025\n    onOpen: ignore' .gitpod.yml
sed -i '/^ports:/a\  - port: 8025\n    onOpen: ignore' .gitpod.yml
sed -i '/^ports:/a\  - port: 7700\n    onOpen: ignore' .gitpod.yml
# Remove the default web browser preview and add one for Laravel
sed -i '/port: 8080/a\
    onOpen: ignore\
  - port: 9080' .gitpod.yml

# Add a terminal to run Sail
sed -i '/# Additional Terminals/a\
  - name: Laravel Sail\
    before: cd university\
    init: |\
      php -r \d34file_exists(\d39.env\d39) || copy(\d39.env.example\d39, \d39.env\d39);\d34\
      composer update\
      composer install\
      npm install\
      npm run dev\
      php artisan key:generate\
      sail up --no-start --build\
    command: sail up\
    openMode: tab-after' .gitpod.yml

echo ""
echo -e "Laravel installed successfully.  Please continue with the challenge instructions."
