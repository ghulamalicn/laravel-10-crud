# ![Laravel Crud App]



----------

# Getting started

## Installation


Clone the repository

    gh repo clone ghulamalicn/laravel-10-crud.git


Switch to the repo folder

    cd laravel-10-crud


Install all the dependencies using composer

    composer install


Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env


Generate a new application key

    php artisan key:generate




Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder for dummy record (**Set the database connection in .env before seeding**)

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

