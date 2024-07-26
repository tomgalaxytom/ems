<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\Livewire\EmployeeForm;
use App\Livewire\EmployeeGrid;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\EmployeeAPI;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/home', 'welcome')->name('home');


Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');

});


Route::prefix('api')->group(function(){
    // fetch all employees with query string
    Route::get('employees', [EmployeeAPI::class, "getEmployees"])->name('get.employees');
    // fetch specific employee with search query using email, reg_no, mobile or combination of those 
    Route::get('employee', [EmployeeAPI::class, "getEmployee"])->name('get.employee');
    // specific api for employee retrieval based on email
    Route::any('employee-by-email', [EmployeeAPI::class, "getEmployeeByEmail"])->name('get.employee.by.email');
    // specific api for employee retrieval based on reg_no
    Route::get('employee-by-reg_no', [EmployeeAPI::class, "getEmployeeByRegisterNumber"])->name('get.employee.by.reg_no');
    // specific api for employee retrieval based on mobile
    Route::get('employee-by-mobile', [EmployeeAPI::class, "getEmployeeByContactNumber"])->name('get.employee.by.mobile');
});