# CompanyApp

A Laravel-based company management application for tracking rooms, positions, and employee access.

## Features

- Room management with image uploads
- Position tracking and assignment
- User authentication and authorization
- Admin controls for managing rooms and positions
- Entry logging system for room access

## Requirements

- PHP ^8.2
- Laravel ^11.31
- Node.js and NPM
- Composer

## Installation

1. Clone the repository
2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Set up the database:
```bash
php artisan migrate
```

6. Link storage:
```bash
php artisan storage:link
```

7. Start the development server:
```bash
php artisan serve
```

In a separate terminal, run:
```bash
npm run dev
```

## Development

For local development, you can use the convenient dev script that runs all necessary services:
```bash
composer run-script dev
```

This will concurrently run:
- Laravel development server
- Queue listener
- Log viewer
- Vite development server

## License

This project is licensed under the MIT License.