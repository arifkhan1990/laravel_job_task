# Task Management API with JWT Authentication

## Project Overview

Task Management API with JWT Authentication is a RESTful API developed using the Laravel PHP framework. It allows users to perform CRUD operations on tasks with JWT (JSON Web Token) authentication. Users can register, login, create, read, update, and delete tasks. Each task belongs to a specific user, ensuring data privacy and security.

## Features

#### User Authentication

    # JWT authentication for user registration, login, and authentication.
    # Endpoints for user registration, user login, and token refresh.

#### Task Management

    # CRUD operations for tasks (Create, Read, Update, Delete).
    # Task fields include title, description, due date, and status.
    # Users can only access, modify, and delete their own tasks.

#### Authorization

    # Authenticated users can access task-related endpoints.
    # Authorization checks prevent unauthorized access to other users' tasks.

#### Validation

    # Input data validation for creating and updating tasks.
    # Error messages for validation failures.

#### Pagination and Filtering

    # Pagination for task listing endpoints.
    # Filtering options (e.g., by status, due date) for task listing.

#### Testing

    # Automated tests using PHPUnit or Laravel Dusk.
    # Positive and negative scenarios, edge cases, and error handling.

#### Bonus Features

    # User Profile: Users can view and update their profile information.
    # Task Categories: Implement task categories or tags for task categorization.
    # Task Reminders: Set reminders for tasks and send email or SMS notifications.
    # Rate Limiting: Implement rate limiting to prevent excessive API usage.

### Tech Stack

    # Framework: Laravel (latest version)
    # Database: MySQL or SQLite
    # Authentication: JWT (JSON Web Token)
    # Testing: PHPUnit or Laravel Dusk

## Installation and Setup

##### Clone the repository

``` bash
    git clone https://github.com/arifkhan1990/laravel_job_task.git
```

##### Navigate to the project directory

``` bash
    cd laravel_job_task
```

##### Install composer dependencies

``` bash
    composer install
```

##### Set up environment variables

    .Copy the `.env.example` file to `.env` and configure database settings.
    .Generate application key and jwt secret key:

``` bash
    php artisan key:generate
    php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
    php artisan jwt:secret
```

##### Run database migrations

``` bash
    php artisan migrate
```

##### Start the development server

``` bash
    php artisan serve
```

##### Testing

    Run automated tests using PHPUnit:

``` bash
    php artisan test
    or
    php artisan test --filter=TaskReminderTest
    or
    php artisan test --filter=TaskControllerTest
    or
    php artisan test --filter=ApiTest
    or
    php artisan test --filter=AuthTest
```

### API Documentation

Document API endpoints, request/response formats, and authentication mechanisms using tools in Postman. API documentation Link [Click](https://documenter.getpostman.com/view/13515563/2sA3JJ9i7a)  or https://documenter.getpostman.com/view/13515563/2sA3JJ9i7a


#### Requirements:
    PHP ^8.1
    Laravel Framework ^10.10
    Guzzle HTTP ^7.2
    Laravel Sanctum ^3.3
    Laravel Tinker ^2.8
    JWT Auth (php-open-source-saver/jwt-auth) ^2.2
    Spatie Laravel Query Builder ^5.7
#### Development Dependencies:
    Barryvdh Laravel IDE Helper ^3.0
    Faker PHP ^1.9.1
    Laravel Pint ^1.0
    Laravel Sail ^1.18
    Mockery ^1.4.4
    Nunomaduro Collision ^7.0
    PHPUnit ^10.5
    Spatie Laravel Ignition ^2.0


#### Contributors:
    # Arif Khan
        [GitHub Profile] (https://github.com/arifkhan1990)
        [LinkedIn Profile] (https://www.linkedin.com/in/arifkhan1990/)
