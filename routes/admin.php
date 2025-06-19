<?php

use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin'], function () {
  Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});