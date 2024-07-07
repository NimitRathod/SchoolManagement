<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin','middleware' => ['auth']], function() {
    include "admin.php";
});

Route::redirect('/home', '/admin');
