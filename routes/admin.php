<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin'], function () {
  Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
  Route::get('/index',[AdminController::class, 'index'])->name('index');
});