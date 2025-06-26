# Inventory Management System (Laravel 10 + Breeze)

A web-based Inventory Management System built using **Laravel 10** and **Breeze** for simple authentication and scaffolding. This system helps businesses efficiently manage their product inventory, stock levels, and sales history from a clean and responsive interface.

---

## Features

- 🔐 Breeze-powered authentication (login, registration, password reset)
- 📦 Product management (Add, Edit, Delete, View)
- 🧾 Stock and quantity tracking
- 🛒 Sales management
- 📊 Dashboard with key inventory metrics
- 📤 Export data (PDF) *(optional)*
- 🧑 Role-based access *(optional for Admin/User)*

---

## Tech Stack

| Layer     | Technology         |
|-----------|--------------------|
| Backend   | Laravel 10         |
| Frontend  | Blade, Tailwind CSS|
| Auth      | Laravel Breeze     |
| Database  | MySQL              |
| Export    | Laravel DOMPDF (optional)

---

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/akash9804/inventory-management.git
cd inventory-management

## Install Dependencies
composer install
npm install
npm run dev

Set up .env and Database Credentials

# Run Migrations and Seeders
php artisan migrate --seed

and 

## run the Application using
php artisan serve


#RUN API using CURL

#Login to get Bearer Token
curl --location 'http://127.0.0.1:8000/api/login' \
--form 'email="admin@example.com"' \
--form 'password="password"'

#Get Product Details
curl --location --request GET 'http://127.0.0.1:8000/api/products' \
--header 'Authorization: Bearer 1|QNEn9WM3JZvCbvxAsdozBpy1F4S1YgnLVP6iq9AE65f41473' \
--form 'email="admin@example.com"' \
--form 'password="password"'

#Get Sales Order Details
curl --location --request GET 'http://127.0.0.1:8000/api/sales-orders/11' \
--header 'Authorization: Bearer 1|QNEn9WM3JZvCbvxAsdozBpy1F4S1YgnLVP6iq9AE65f41473' \
--form 'email="admin@example.com"' \
--form 'password="password"'
