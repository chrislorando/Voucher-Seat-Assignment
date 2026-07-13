# Airline Voucher Seat Assignment

**Technical Assessment: Airline Voucher Seat Assignment Application**

Full-stack application built with **React 19 + TypeScript** (frontend) and **PHP Laravel 13.x** (backend).

---

## Prerequisites

| Tool | Version | Notes |
|------|---------|-------|
| **PHP** | 8.3+ | Required extensions: `sqlite3`, `pdo`, `mbstring`, `fileinfo`, `openssl` |
| **Composer** | Latest stable | PHP dependency manager |
| **Node.js** | 20+ | LTS recommended |
| **npm** | 10+ | Bundled with Node.js |

---

## Project Structure

```
voucher-seat-assignment/
├── backend/          # Laravel 13.x API
│   ├── app/          # Models, Services, Controllers
│   ├── database/     # Migrations & SQLite database
│   ├── routes/       # API routes
│   └── tests/        # Pest tests
└── frontend/         # React 19 + Vite
    ├── src/
    │   ├── api/      # API client helpers
    │   ├── components/
    │   ├── services/
    │   └── types/
    └── public/
```

---

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/chrislorando/Voucher-Seat-Assignment.git
cd Voucher-Seat-Assignment
```

### 2. Backend Setup

```bash
cd backend

# Install PHP dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run database migrations
php artisan migrate

# Start the development server
php artisan serve
```

The API will run at **http://localhost:8000**.

> **Database note:** The default configuration uses **SQLite**. Set `DB_DATABASE` in `backend/.env` to an **absolute path**, e.g. `DB_DATABASE=/absolute/path/to/backend/database/vouchers.db`.

### 3. Frontend Setup

```bash
cd frontend

# Configure environment
cp .env.example .env

# Install Node.js dependencies
npm install

# Start the Vite dev server
npm run dev
```

The frontend will run at **http://localhost:5173**.

> The frontend expects the backend API at `http://localhost:8000/api`. To change this, update the `VITE_API_BASE_URL` variable in `frontend/.env`.

---

## Running Tests

### Backend (Pest)

```bash
cd backend
php artisan test
```

### Frontend (Lint)

```bash
cd frontend
npm run lint
```

---

## Tech Stack

### Backend
- **Laravel 13.x** — PHP framework
- **SQLite** — Default database
- **Pest** — Testing framework

### Frontend
- **React 19** — UI library
- **TypeScript** — Type safety
- **Vite** — Build tool & dev server
- **Tailwind CSS v4** — Utility-first CSS
- **shadcn/ui** — Accessible component primitives
- **Axios** — HTTP client
- **Lucide React** — Icon library

---

## Docker

A `docker-compose.yaml` is included to run both backend and frontend in containers.

### Prerequisites

- **Docker** and **Docker Compose** installed

### Start All Services

```bash
docker compose up
```

This will:

1. Build and start the **backend** container (PHP 8.3 Alpine):
   - Installs Composer and PHP extensions
   - Runs `composer install`
   - Copies `.env.example` → `.env` and generates `APP_KEY`
   - Runs `php artisan migrate --force`
   - Runs `php artisan test`
   - Starts the dev server on **http://localhost:8000**

2. Build and start the **frontend** container (Node 20 Alpine):
   - Copies `.env.example` → `.env`
   - Runs `npm install`
   - Runs `npm run lint`
   - Starts the Vite dev server on **http://localhost:5173**

### Rebuild from Scratch

```bash
docker compose down -v   # remove volumes (vendor, node_modules)
docker compose up
```

### Volumes

`vendor/` and `node_modules/` are stored in Docker named volumes for faster I/O across all platforms (especially Windows and macOS). The source code remains bind-mounted for live editing.
