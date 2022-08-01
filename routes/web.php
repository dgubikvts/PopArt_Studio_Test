<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdController;


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
View::composer('layouts.sidebar', function ($view) {
    $view->with('categories', Category::with('getChildren')->whereNull('parent_id')->get());
});



Route::controller(GuestController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/ad/{ad_id}', 'view_ad')->name('view-ad');
    Route::get('/search', 'search')->name('search');
});

Route::controller(AdController::class)->group(function () {
    Route::get('/create-ad', 'new_ad')->name('new_ad');
    Route::get('/edit-ad/{ad_id}', 'edit_ad')->name('edit-ad');
    Route::delete('/delete-img', 'delete_img')->name('delete-img');
    Route::patch('/patch-ad/{ad}', 'patch_ad')->name('patch-ad');
    Route::delete('/delete-ad', 'delete_ad')->name('delete-ad');
    Route::post('/create-ad/{user}', 'create_ad')->name('create_ad');
});

Auth::routes();

Route::get('/{category}', [App\Http\Controllers\CategoryController::class, 'items_by_category'])->name('searchByCategory');
Route::get('/user/{id}', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::middleware('admin')->group(function () {
    Route::get('/admin/ads', [App\Http\Controllers\AdminController::class, 'index'])->name('admin-index');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin-users');
    Route::get('/admin/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin-categories');
    Route::get('/admin/conditions', [App\Http\Controllers\AdminController::class, 'conditions'])->name('admin-conditions');
    Route::delete('/delete-user', [App\Http\Controllers\AdminController::class, 'delete_user'])->name('delete-user');
    Route::post('/add-category/{parent_id}', [App\Http\Controllers\AdminController::class, 'add_category'])->name('add-category');
    Route::post('/edit-category/{id}', [App\Http\Controllers\AdminController::class, 'edit_category'])->name('edit-category');
    Route::delete('/delete-category/{category}', [App\Http\Controllers\AdminController::class, 'delete_category'])->name('delete-category');
    Route::delete('/delete-condition/{condition}', [App\Http\Controllers\AdminController::class, 'delete_condition'])->name('delete-condition');
    Route::post('/add-condition', [App\Http\Controllers\AdminController::class, 'add_condition'])->name('add-condition');
    Route::post('/edit-condition/{id}', [App\Http\Controllers\AdminController::class, 'edit_condition'])->name('edit-condition');
});
