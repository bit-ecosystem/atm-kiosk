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

# Change to /srv directory
cd /srv

# Clone the repository
git clone https://github.com/bit-ecosystem/kiosk.git

# Change to the cloned directory
cd /srv/kiosk
-
Got it! Let's make sure the permissions and ownership are correctly set for your SQLite database at /srv/kiosk/database/database.sqlite:
Set Permissions for the Database File:
Set Permissions for the Directory:
Verify Ownership: Ensure that the user running your application has ownership of the database file and directory. Replace your_user and your_group with the appropriate values:
Enable Write-Ahead Logging (WAL): Open the SQLite database and enable WAL mode:
These steps should help resolve the "attempt to write a readonly database" error. If you still encounter issues, please let me know more about your server setup and any specific error messages you're seeing. Are you working on a particular project that requires this setup?
sqlite3 /srv/kiosk/database/database.sqlite
PRAGMA journal_mode=WAL;
chown your_user:your_group /srv/kiosk/database/database.sqlite
chown your_user:your_group /srv/kiosk/database
chmod 777 /srv/kiosk/database
chmod 666 /srv/kiosk/database/database.sqlite
