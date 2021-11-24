# Parspack Process List

An API written in Laravel for retreiving a list of current operating system running processes.

## Usage
    * Clone the repo via `git clone {REPOSITORY_URL}`
    * Create database and its migrations via `php artians migrate`
    * Seed the tables via `php artisan db:seed` to create default users

## Features
    - Create zip files for multiple users via custom command line: `php artisan users:zip user1 user2...`
    - Daily cron job to archive users files

## Routes
A Postman collection provided for testing the API.

## TODO

    [X] Sign up
    [X] Authenticate via token
    [X] Get list of running processes on the server
    [X] Get a directory name and create a directory with that name in user’s "/opt/myprogram/$username/" directory
    [X] Get a filename and create a file with that name in user’s "/opt/myprogram/$username/"directory
    [X] Get list of all directories in "/opt/myprogram/$username/" directory
    [X] Get list of all files in "/opt/myprogram/$username/" directory

### Plus points

    [X] Having test for endpoints
    [X] Using PSR5 (documentaion check!)
    [X] Add a daily cron job to zip users files and send it to: /opt/backups/$username/Y-m-d.zip
    [X] Add a console command to zip files for selected users

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
