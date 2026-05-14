# Inventory Management System (IMS)

A premium, Laravel-based Inventory Management System designed to centralize stock control, automate department supply requests, and provide deep analytical reporting for organizational efficiency.

## Features

### 📦 Stock & Inventory Management
- Centralized tracking of all physical stock items, including SKUs, descriptions, and real-time quantities.
- Automated low-stock monitoring and out-of-stock prevention.
- Premium, modern, and responsive UI built with Tailwind CSS.

### 🔄 Department Request Workflow
- Department Users can seamlessly browse available stock and submit requests for items.
- Built-in approval pipeline: Requests are logged as `pending` until reviewed.
- Admin and Inventory Managers can `approve` or `reject` requests with a single click.
- Automatic stock deduction upon request approval.

### 📊 Advanced Reporting Module
- **System Overview:** High-level dashboard of total volume, pending approvals, and rejected requests.
- **Low Stock Analysis:** Instantly identify items that require reordering.
- **Department Requests:** Track which departments are consuming the most resources.
- **Stock Movement History:** Granular tracking of exactly *who* took *what* and *when*.
- **Data Export:** Built-in "Export to CSV" functionality for all tabular data.
- **Print-Ready Mode:** Clean, distraction-free print styling for physical record-keeping.

### 🔐 User Roles & Secure Access
- **Roles:** Admin, Inventory Manager, and Department User.
- **Conditional Workflows:** Users only see data and actions relevant to their department and role.
- **API Security:** Fully featured REST API protected by Laravel Sanctum authentication.

---

## Requirements
- **PHP** >= 8.1
- **Laravel** 11.x
- **MySQL** (or compatible database)
- **Composer** (PHP dependency manager)
- **Node.js & NPM** (for compiling Tailwind CSS via Vite)

---

## Installation

**1. Clone the repository**
```bash
git clone https://github.com/yourusername/inventory.git
cd inventory
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install NPM dependencies & compile frontend assets**
```bash
npm install
npm run build
```

**4. Environment setup**
```bash
cp .env.example .env
```
*Update your `.env` file with your local database credentials, and ensure `APP_TIMEZONE` is set to your local time (e.g., `Asia/Colombo`).*

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Run database migrations**
```bash
php artisan migrate
```

**7. Seed initial roles & admin accounts (if applicable)**
```bash
php artisan db:seed
```

**8. Serve the application**
```bash
php artisan serve
```

Access the web application at [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Usage Guide

- **Dashboard:** Instantly view your relevant metrics. Admins see system-wide stats, while Department Users see their specific request statuses.
- **Stocks Panel:** Manage the master inventory list. Create, edit, and monitor available quantities.
- **Stock Requests:** Department users submit forms here. Managers use this panel to approve or reject pending requests.
- **Reports:** Generate, filter (by date/department), print, and export CSV data for audits and supply chain management.
- **API Endpoints:** Use `/api/login` to obtain a Sanctum Bearer token, which grants programmatic access to manage `/api/stocks` and `/api/stock-requests`.

---

## Code Structure Overview

- **`Controllers/Web`**: Handles all browser-based routing, form validation, and Blade view compilation.
- **`Controllers/Api`**: Handles pure JSON REST API requests, strictly returning data arrays and status codes.
- **`Models`**: Eloquent models representing `User`, `Role`, `Department`, `Stock`, and `StockRequest` with strict relationship mapping.
- **`Views`**: Premium UI Blade templates (`resources/views/`) heavily styled with dynamic Tailwind CSS classes and custom print media queries.
- **`Routes`**: Web routes are defined in `web.php` (protected by `RoleMiddleware`), and API endpoints are mapped in `api.php` (protected by `auth:sanctum`).

Happy Coding!! ✨
