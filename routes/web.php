<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

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

//    users routes
    Route::get('/user/list', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/user/edit{encryptedId}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('users.update');
    Route::get('/user/delete/{encrypteddelete}', [UserController::class, 'destroy'])->name('users.destroy');

    //    Article routes
    Route::get('/article/list', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/article/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/article/store', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/article/edit{encryptedId}', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/article/update', [ArticleController::class, 'update'])->name('articles.update');
    Route::get('/article/delete/{encrypteddelete}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    //permission routes
    Route::get('/permission/list', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/edit{encryptedId}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::get('/permission/delete/{encrypteddelete}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    //roles routes
    Route::get('/role/list', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/edit{encryptedId}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/role/update', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/role/delete/{encrypteddelete}', [RoleController::class, 'destroy'])->name('roles.destroy');



});

require __DIR__.'/auth.php';
