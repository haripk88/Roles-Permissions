<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //categories routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    //permission routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    //roles routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');

    //articles routes
    Route::get('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [\App\Http\Controllers\Api\ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles/store', [\App\Http\Controllers\Api\ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [\App\Http\Controllers\Api\ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/articles/{id}/update', [\App\Http\Controllers\Api\ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'destroy'])->name('articles.destroy');

    //users routes
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Api\UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [\App\Http\Controllers\Api\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [\App\Http\Controllers\Api\UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [\App\Http\Controllers\Api\UserController::class, 'destroy'])->name('users.destroy');

    //payment routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/purchase-order', [PaymentController::class, 'purchase']);
    Route::post('/verify-payment', [PaymentController::class, 'verify']);
});

require __DIR__ . '/auth.php';
