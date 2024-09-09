# MetaSchool

**MetaSchool** is a web application for managing courses, sections, modules, and lessons, developed with Laravel. It allows teachers to create and manage courses and students to view available courses.

## Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributions](#contributions)
- [License](#license)

## Introduction

MetaSchool provides an interface for teachers to create and organize courses, as well as for students to explore and follow courses.

## Installation

### Prerequisites

- PHP >= 7.4
- Composer
- ~~Node.js (for frontend assets, if applicable)~~

### Clone the Repository

Clone the Git repository to your local machine:

```bash
git clone https://github.com/yourusername/metaschool.git
cd metaschool
```

### Install Dependencies

#### Install PHP dependencies via Composer

```bash
composer install
```

#### Install JavaScript dependencies via npm (or Yarn)

```bash
npm install
# ou
yarn install
```

#### After installing JavaScript dependencies, you may also need to build frontend assets:

```bash
npm run dev
# or
yarn run dev
```

### Configure the Environment

Copy the .env.example file to .env:

```bash
cp .env.example .env
```

### Generate the Application Key

```bash
php artisan key:generate
```

Configure your environment settings in the .env file. Make sure to set your database connection details and other specific parameters.

### Database Migration

Run migrations to set up your database:

```bash
php artisan migrate
```

If you have test data, you can import it using seeders:

```bash
php artisan db:seed
```

### Run the Server

Start the Laravel development server:

```bash
php artisan serve
```

Access the application at http://localhost:8000.

## Configuration

### Routes

The main routes of the application are defined in routes/web.php.

### Middleware

The application's middleware is configured in app/Http/Middleware/RoleMiddleware.php. Ensure that protected routes are correctly set up for roles and permissions.

### Authentication

Authentication routes are defined in routes/web.php. You can customize authentication views and controllers in the app/Http/Controllers/Auth directory.

## Usage

- Create a Course: Go to http://localhost:8000/teachers/courses/create to add a new course.
- View Courses: Go to http://localhost:8000/teachers/courses to see the list of courses.
- Edit a Course: Go to http://localhost:8000/teachers/courses/{id}/edit to edit an existing course.
- Delete a Course: Use the delete button on the course list page.

## Contributions

Contributions are welcome! Please follow these steps to contribute:

1. Fork the repository
2. Create a branch (git checkout -b feature/amazing-feature)
3. Make your changes
4. Commit your changes (git commit -am 'Add some amazing feature')
5. Push to the branch (git push origin feature/amazing-feature)
6. Open a Pull Request

## License

This project is licensed under the MIT License.
