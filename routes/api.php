<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
});

Route::get('/latest_books', [App\Http\Controllers\LatestBookController::class, 'latest']);
Route::get('/sections/{section}/books', [\App\Http\Controllers\Sections\SectionBookController::class, 'booksBySections']);
Route::get('/authors/{id}', [App\Http\Controllers\AuthorIdController::class, 'getId']);
Route::get('/authors', [App\Http\Controllers\AuthorApiController::class, 'Index']);
Route::get('/books/{id}', [App\Http\Controllers\BookApiController::class, 'Index']);
Route::get('/authors/{authorId}/books', [App\Http\Controllers\AuthorBooksController::class, 'getBooks']);
Route::patch('/admin/sections/{section}', [App\Http\Controllers\Sections\SectionUpdateController::class, 'update']);
Route::get('/sections', [\App\Http\Controllers\Sections\SectionApiController::class, 'index']);
Route::get('/sections/{id}', [\App\Http\Controllers\Sections\SectionApiEditController::class, 'index']);
Route::put('/sections/{id}/toggle-visibility', [App\Http\Controllers\Sections\SectionVisibilityController::class, 'toggleVisibility']);;
Route::put('/authors/{id}/toggle-visibility', [App\Http\Controllers\AuthorVisibilityController::class, 'toggleVisibility']);
Route::put('/books/{id}/toggle-visibility', [App\Http\Controllers\BookVisibilityController::class, 'toggleVisibility']);

Route::delete('/sections/{section}', [App\Http\Controllers\Sections\SectionDestroyController::class, 'destroy']);
Route::delete('/authors/{authorId}', [App\Http\Controllers\AuthorDestroyController::class, 'destroy']);
Route::delete('/books/{bookId}', [App\Http\Controllers\BookDestroyController::class, 'destroy']);

Route::get('/books', [App\Http\Controllers\BookSearchController::class, 'getBooks']);





//Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');
//Route::post('/admin/sections', [\App\Http\Controllers\Sections\SectionStoreController::class, 'store']);


Route::group(['middleware' => 'auth:sanctum'], function () {



});
