# Inventory Management System

## Requirements
- PHP 8.x
- Laravel 10.x
- MySQL

## Setup Instructions
```bash
git clone https://github.com/akash9804/axievererp.git
cd axievererp
composer install
php artisan key:generate // if missing or not working
php artisan migrate --seed
npm install 
npm run dev
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


for reference Database file added to root folder DB File: axiever_erp.sql

I have also attcahed demo of Assigment just for quick review of task,
Please Watch the video here : https://drive.google.com/file/d/1Mi6pmiWndlYfFdCtMmRdBZjwV4hz3XyI/view?usp=sharing

