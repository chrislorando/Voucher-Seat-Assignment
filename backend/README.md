# Airline Voucher Seat Assignment — Backend

PHP Laravel backend API for the Airline Voucher Seat Assignment application.

## Prerequisites

- **PHP 8.3+** (with `ext-sqlite3`, `ext-pdo`, `ext-mbstring`, `ext-fileinfo`, `ext-openssl`)
- **Composer** (latest stable)

## Quick Start

### 1. Install Dependencies

```bash
composer install
```

### 2. Configure Environment

Copy the example environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

By default the app uses **SQLite**. The `.env` file should contain:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/backend/database/vouchers.db
```

> If you prefer MySQL/PostgreSQL, update `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` accordingly.

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Start the Development Server

```bash
php artisan serve
```

The API will be available at **http://localhost:8000**.

## API Routes

| Method | Endpoint     | Description  |
| ------ | ------------ | ------------ |
| GET    | `/api/hello` | Health check |

> Registered routes are defined in `routes/api.php`. Run `php artisan route:list` to see the full route table.

## Testing

```bash
php artisan test
```

Tests are written with **Pest** and located in `tests/Feature/` and `tests/Unit/`.

## Tech Stack

- **Laravel 13.x** — Backend framework
- **Sanctum** — API token authentication
- **SQLite** — Default database
- **Pest** — Testing framework
