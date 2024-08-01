<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MediaBuyerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;

// Authentication Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Client Routes
Route::resource('clients', ClientController::class);

// Lead Routes
Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
Route::post('/leads/{id}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
Route::post('/leads/{id}/comment', [LeadController::class, 'updateComment'])->name('leads.updateComment');
Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
Route::get('/leads/import', [LeadController::class, 'importForm'])->name('leads.importForm');
Route::post('/leads/import', [LeadController::class, 'import'])->name('leads.import');
Route::get('/leads/importCSV', [LeadController::class, 'importCSVForm'])->name('leads.importCSVForm');
Route::post('/leads/importCSV', [LeadController::class, 'importCSV'])->name('leads.importCSV');
Route::post('/leads/assign', [LeadController::class, 'assign'])->name('leads.assign');


// Resource Routes
Route::resource('products', ProductController::class);
Route::resource('mediaBuyers', MediaBuyerController::class);

// Sales Route
Route::get('/sales-data', [SalesController::class, 'getSalesData']);

// Profile Route
Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Agent Routes
Route::resource('agents', AgentController::class);
Route::get('/agent-stats', [DashboardController::class, 'showAgentSelectionForm'])->name('agents.stats.form');
Route::post('/agent-stats', [DashboardController::class, 'agentStats'])->name('agents.stats');
Route::get('/home', [AgentController::class, 'home'])->name('home');

Route::put('/leads/{id}/updateshow', [LeadController::class, 'updateshow'])->name('leads.updateshow');

Route::get('/clients/assigned', [ClientController::class, 'clientsAss'])->name('clients.assigned');