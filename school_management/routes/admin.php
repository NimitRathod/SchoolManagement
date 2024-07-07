<?php

use App\Http\Controllers\admin\AnnouncementsController;
use App\Http\Controllers\admin\Dashboard;
use App\Http\Controllers\admin\ParentsController;
use App\Http\Controllers\admin\spatie\PermissionController;
use App\Http\Controllers\admin\spatie\RoleController;
use App\Http\Controllers\admin\spatie\UserController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\TeacherController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

Route::resource('teachers', TeacherController::class);
Route::resource('students', StudentController::class);
Route::resource('parents', ParentsController::class);
Route::resource('announcements',  AnnouncementsController::class);

