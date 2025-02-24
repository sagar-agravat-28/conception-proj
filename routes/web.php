<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
// Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'addUpdate'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'addUpdate'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // AJAX endpoints
    Route::post('/update-order', [ProductController::class, 'updateOrder']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'addUpdate'])->name('categories.create');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'addUpdate'])->name('categories.edit');
    Route::match(['POST', 'PUT'], '/categories/store/{category?}', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/get-subcategories/{category}', [CategoryController::class, 'getSubcategories'])->name('get.subcategories');

    // Sub-Categories
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubcategoryController::class, 'addUpdate'])->name('subcategories.create');
    Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'addUpdate'])->name('subcategories.edit');
    Route::match(['POST', 'PUT'], '/subcategories/store/{subcategory?}', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');


    // Sub-Categories
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'addUpdate'])->name('orders.create');
    Route::match(['POST', 'PUT'], '/orders/store/{order?}', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/edit/{order?}', [OrderController::class, 'addUpdate'])->name('orders.edit');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/avatar', [ProfileController::class, 'avatarStore'])->name('profile.store.avatar');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});
