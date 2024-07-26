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
## Migration 

php artisan migrate

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
## Api EndPoints

## Api file endpoint file is located by 

ems/api_endpoints/EMS.postman_collection.json
## Import Excel Upload

composer require maatwebsite/excel
composer update

## Sample Excel File Location
ems/api_endpoints/ems_sample.xlsx

##  Export PDF

composer require barryvdh/laravel-dompdf
composer update

## Sample export pdf file location
ems/api_endpoints/filename.pdf






