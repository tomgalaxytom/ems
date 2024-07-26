# ems
Employeement Management System

## Node Version
v20.16.0
## NPM Version
10.8.1
## Laravel Version
11.17.0
## PHP Version
php 8.3.9
## Laravel TALL Preset
Tailwindcss,
Alphine.js,
Laravel,
Livewire
## TALL Stack INSTALL with AUTH
composer require livewire/livewire laravel-frontend-presets/tall
php artisan ui tall --auth
npm install
npm run dev
## API
## API Response message
app/traits/ApiResponse.php (using traits)
using trait in this Employee API class
  use ApiResponse;
## Get Employees
http://127.0.0.1:8000/api/employees

http://127.0.0.1:8000/api/employee-by-email?email=tom@gmail.com




