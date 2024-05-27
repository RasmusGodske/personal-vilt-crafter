#!/bin/bash

# Creates a fresh laravel project and adds vilt-crafter as a package

if [ -d "example-app" ]; then
    echo "example-app directory already exists. Deleting it..."
    rm -rf example-app
fi

curl -s https://laravel.build/example-app?with=pgsql | bash
echo "APP_PORT=8080" >> example-app/.env

# cp docker-compose.yml docker-compose.yml.backup
sed -i '/laravel.test:/,/volumes:/s|volumes:|&\n            - '\''../vilt-crafter:/var/www/packages/vilt-crafter'\''|' example-app/docker-compose.yml

# Add repository to composer.json
jq '.repositories += [{"type": "path", "url": "../packages/vilt-crafter"}]' example-app/composer.json > temp.json && mv temp.json example-app/composer.json

# Add vilt-crafter to require-dev in composer.json
jq '.["require-dev"] += {"rasmusgodske/vilt-crafter": "*"}' example-app/composer.json > temp.json && mv temp.json example-app/composer.json

# Change composer.json minimum-stability to dev
jq '.["minimum-stability"] = "dev"' example-app/composer.json > temp.json && mv temp.json example-app/composer.json
