<?php

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


//Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);


Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/admin/sections', [\App\Http\Controllers\Sections\SectionStoreController::class, 'store']);
Route::delete('/admin/sections/{sectionId}', [\App\Http\Controllers\Sections\SectionDestroyController::class, 'delete']);
Route::put('/sections/{sectionId}/toggle', [App\Http\Controllers\Sections\SectionVisibilityController::class, 'toggleVisibility']);;
Route::patch('/admin/sections/{section}', [App\Http\Controllers\Sections\SectionUpdateController::class, 'update']);
Route::patch('/admin/authors/{author}', [App\Http\Controllers\AuthorUpdateController::class, 'update']);
Route::patch('/book/{book}/edit', [App\Http\Controllers\BookUpdateController::class, 'update']);
Route::delete('/authors/{authorId}', [App\Http\Controllers\AuthorDestroyController::class, 'destroy']);
Route::post('/book/create', [App\Http\Controllers\BookStoreController::class, 'store']);
Route::post('admin/author/create', [App\Http\Controllers\AuthorStoreController::class, 'store']);

