<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialPlanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ExpenseCategoryController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::get('/', function () {
  return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
  // Login
  Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('login', [LoginController::class, 'login']);

  // Register
  Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
  Route::post('register', [RegisterController::class, 'register']);
});

// Logout (for authenticated users)
Route::post('logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
  // Dashboard
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Financial Plans
  Route::resource('financial-plans', FinancialPlanController::class);
  Route::patch('financial-plans/{financial_plan}/activate', [FinancialPlanController::class, 'activate'])
    ->name('financial-plans.activate');

  // Transactions
  Route::resource('transactions', TransactionController::class);

  // Savings Goals
  Route::resource('savings-goals', SavingsGoalController::class);
  Route::patch('savings-goals/{savings_goal}/add-funds', [SavingsGoalController::class, 'addFunds'])
    ->name('savings-goals.add-funds');

  // Expense Categories
  Route::resource('expense-categories', ExpenseCategoryController::class);

  // Reports
  Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
});
