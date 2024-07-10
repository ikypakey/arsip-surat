<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/kategori', KategoriController::class);

Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
Route::resource('/archive', ArchiveController::class);
Route::get('/archive/{archive}/download', [ArchiveController::class, 'download'])->name('archive.download');
