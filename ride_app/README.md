# RideShare

**Your Ride, Your Price** — A ride-sharing web application built with Laravel.

Users can register, offer rides as drivers, book rides as passengers, and get AI-based fare estimates — all from a single responsive web interface.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [How to Run](#how-to-run)
- [How to Use](#how-to-use)
- [Project Structure](#project-structure)
- [API Routes](#api-routes)
- [Database](#database)
- [GitHub Push (GitHub Desktop)](#github-push-github-desktop)
- [Troubleshooting](#troubleshooting)

---

## Features

| Feature | Description |
|---------|-------------|
| **Authentication** | User registration, login, logout with session |
| **Offer Ride** | Drivers post rides with route, car type, seats, and price |
| **Book Ride** | Passengers browse and book available rides |
| **AI Fare Estimate** | Fare calculated using distance, car type, passengers, and peak hours |
| **Contact Form** | Users can send messages from the website |
| **Responsive UI** | Bootstrap 5 + custom CSS, mobile-friendly design |

---

## Tech Stack

- **Backend:** PHP 8.2, Laravel 12
- **Database:** MySQL (XAMPP)
- **Frontend:** Blade Templates, Bootstrap 5, JavaScript
- **Styling:** Custom CSS (`public/css/styles.css`)
- **Server:** Laravel Artisan (`php artisan serve`)

---

## Requirements

Install these before running the project:

| Tool | Version |
|------|---------|
| PHP | 8.2+ |
| Composer | Latest |
| MySQL | 5.7+ (XAMPP recommended) |
| Node.js | Optional (only for Vite asset changes) |

---

## Installation

### 1. Clone or download the project

```powershell
git clone <your-repo-url>
cd ride_app
```

### 2. Install PHP dependencies

```powershell
composer install
```

### 3. Setup environment file

```powershell
copy .env.example .env
php artisan key:generate
```

### 4. Configure database

Open `.env` and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ride
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create MySQL database

Start MySQL from XAMPP, then run:

```powershell
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS ride;"
```

### 6. Run migrations

```powershell
php artisan migrate
```

---

## How to Run

### Step 1 — Start MySQL

Open **XAMPP Control Panel** → click **Start** next to MySQL.

### Step 2 — Start Laravel server

```powershell
cd ride_app
php artisan serve
```

Output:

```
Server running on [http://127.0.0.1:8000]
```

### Step 3 — Open in browser

| Page | URL |
|------|-----|
| Login | http://127.0.0.1:8000/login |
| Register | http://127.0.0.1:8000/register |
| Home | http://127.0.0.1:8000/ |

> Home page requires login. Register first, then login.

### Stop server

Press `Ctrl + C` in the terminal.

---

## How to Use

1. **Register** — Go to `/register` and create an account
2. **Login** — Sign in with your email and password
3. **Home** — View dashboard and navigate pages
4. **Offer Ride** — Post a ride with pickup, drop-off, seats, and price
5. **Book Ride** — Browse available rides and book a seat
6. **AI Fare** — Enter route details to get an estimated fare
7. **Contact** — Send a message via the contact form
8. **Logout** — End your session securely

---

## Project Structure

```
ride_app/
│
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      # Login, register, logout
│   │   ├── RideController.php      # Offer & list rides
│   │   ├── BookingController.php   # Book rides
│   │   ├── AiFareController.php    # AI fare estimation
│   │   └── ContactController.php   # Contact form
│   └── Models/
│       ├── User.php
│       ├── Ride.php
│       └── Booking.php
│
├── database/migrations/            # Database schema
├── public/
│   ├── css/styles.css              # App styles
│   └── js/script.js                # Frontend logic
├── resources/views/
│   ├── index.blade.php             # Main app page
│   ├── auth/login.blade.php
│   ├── auth/register.blade.php
│   └── bookings/index.blade.php
├── routes/web.php                  # All application routes
├── .env                            # Environment config (do NOT push to GitHub)
└── README.md
```

---

## API Routes

| Method | URL | Auth | Description |
|--------|-----|------|-------------|
| GET | `/login` | No | Login page |
| POST | `/login` | No | Login submit |
| GET | `/register` | No | Register page |
| POST | `/register` | No | Register submit |
| POST | `/logout` | Yes | Logout |
| GET | `/` | Yes | Home page |
| GET | `/rides` | Yes | List all rides |
| POST | `/rides` | Yes | Create a ride |
| GET | `/bookings` | Yes | List bookings |
| POST | `/bookings` | Yes | Create a booking |
| POST | `/ai/fare-estimate` | Yes | AI fare estimate |
| POST | `/contact` | No | Contact form |
| GET | `/debug/db-check` | No | Database status (dev only) |

---

## Database

### Tables

| Table | Purpose |
|-------|---------|
| `users` | Registered users |
| `rides` | Rides offered by drivers |
| `bookings` | Ride bookings by passengers |
| `sessions` | User sessions |
| `cache` | Application cache |
| `jobs` | Queue jobs |

### Rides table fields

- Driver name, phone, car model, car type (economy/comfort/premium)
- Route (from → to), available seats, price per seat, notes

---

## GitHub Push (GitHub Desktop)

### First time push

1. Open **GitHub Desktop**
2. Go to **File → New repository**
3. Set:
   - **Name:** `ride_app`
   - **Local path:** your project folder (e.g. `Desktop`)
   - **Git ignore:** Laravel
4. Click **Create repository**
5. Write commit message: `Initial commit - RideShare app`
6. Click **Commit to main**
7. Click **Publish repository**
8. Choose **Private** if you don't want it public
9. Click **Publish**

### Push future changes

1. Open GitHub Desktop
2. Review changed files on the left
3. Write a commit message
4. Click **Commit to main**
5. Click **Push origin**

> **Warning:** Never push `.env` file to GitHub. It contains sensitive keys and passwords. Laravel `.gitignore` already excludes it.

---

## Troubleshooting

### MySQL connection error

```
SQLSTATE[HY000] [2002] No connection could be made
```

**Fix:** Start MySQL from XAMPP Control Panel.

---

### Migration table not found

```powershell
php artisan migrate
```

---

### Port 8000 already in use

```powershell
php artisan serve --port=8001
```

Open: http://127.0.0.1:8001/login

---

### Clear cache

```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

### MySQL won't start in XAMPP

- Close apps using port 3306
- Run XAMPP as Administrator
- Check log: `C:\xampp\mysql\data\mysql_error.log`

---

## Quick Commands

```powershell
# Navigate to project
cd ride_app

# Start server
php artisan serve

# Run migrations
php artisan migrate

# Check migrations
php artisan migrate:status

# Generate app key
php artisan key:generate
```

---

## Author

RideShare — Laravel Ride Booking Application

## License

MIT License — Free for educational use.
