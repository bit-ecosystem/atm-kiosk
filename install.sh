#!/bin/bash
# Script to set up the kiosk application

# Copy kiosk.conf to /etc/nginx/conf.d
if [ -f kiosk.conf ]; then
    echo "kiosk.conf found. Copying to /etc/nginx/conf.d..."
    sudo cp kiosk.conf /etc/nginx/conf.d/
    echo "Copy completed."
else
    echo "kiosk.conf not found in the current directory."
fi

echo "Installing..."
# Delete existing storage link
rm -rf ./public/storage/

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build the assets
npm run build

echo "Install & Build completed."
echo "Setting up..."

# Set up environment file
cp .env.example .env
php artisan key:generate
php artisan storage:link

# Change user from nginx to root in /etc/nginx/nginx.conf
sudo sed -i 's/user nginx;/user root;/' /etc/nginx/nginx.conf

echo "Setup completed."
# Enable and restart Nginx
sudo systemctl enable nginx
sudo systemctl restart nginx
echo "Nginx restarted"

# Run database migrations and seeders
php artisan migrate --seed
echo "Database seeded"

# Clear and cache various Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan view:cache

echo "Ready to run"
