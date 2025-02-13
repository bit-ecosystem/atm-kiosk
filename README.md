## About Kiosk

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Installation

1. at /srv
2. Do
git clone https://github.com/bit-ecosystem/kiosk.git
composer install
cp .env.example .env
php artisan key:generate

sudo systemctl enable nginx
sudo systemctl restart nginx

php artisan storage:link

php artisan migrate
php artisan migrate:fresh --seed

npm install
npm run build

sudo chown -R nginx:nginx /srv/kiosk/storage
sudo chmod -R 755 /srv/kiosk/storage

sudo chown -R nginx:nginx /srv/kiosk/bootstrap/cache
sudo chmod -R 755 /srv/kiosk/bootstrap/cache

sudo chown nginx:nginx /srv/kiosk/database/database.sqlite
sudo chmod 755 /srv/kiosk/database/database.sqlite

sudo chown -R nginx:nginx /srv/kiosk/public
sudo chmod -R 755 /srv/kiosk/public

sudo chcon -R -t httpd_sys_rw_content_t /srv/kiosk/storage
sudo systemctl restart nginx

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
