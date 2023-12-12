# Laravel CRUD

![Laravel Icon](laravel-icon.png)

## Laravel CRUD

Laravel CRUD is a feature-rich web application designed to showcase and implement basic CRUD (Create, Read, Update, Delete) operations using the Laravel framework. The application also includes additional features to enhance functionality and security.

## Features

- **User Roles (admin/user):** Differentiate between admin and user roles for tailored access and permissions.

- **Authentication:** Secure user authentication system to ensure user identity and authorization.

- **Pagination, Sorting, and Search:** Easily navigate through large datasets with paginated results, sortable columns, and efficient search functionality.

- **Migrations, Seeders, and Factories:** Utilize Laravel's powerful database tools to manage database schema, seed initial data, and generate fake data for testing.

- **Admin User Command:** A custom artisan command designed for creating admin users. This command accepts two parameters: username and password.

## Usage

To create an admin user, run the following command:

```bash
php artisan create:admin-user {username} {password}


### Architecture - architecture.md

```markdown
# Architecture

- **Service Logic:** All business logic is implemented in services rather than controllers for better separation of concerns.

- **Repository Pattern:** Queries are structured and managed using the repository pattern for a clean and organized data access layer.

- **Presenter Pattern:** Frontend/page work is structured using the presenter pattern for a more modular and maintainable presentation layer.


# Getting Started

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/laravel-crud.git

2. Install dependencies:
  composer install
  
3. Copy the .env.example file to .env and configure your database settings.
   cp .env.example .env

4. Key generate
   php artisan key:generate

4. Run migrations and seeders:
   php artisan migrate --seed

5. Run Project
   php artisan serve


