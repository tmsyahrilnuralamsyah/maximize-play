<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/', [AdminController::class, 'index'])->name('index');
Route::post('/tambahMember', [AdminController::class, 'tambahMember'])->name('tambahMember');
Route::put('/editMember/{id}', [AdminController::class, 'editMember'])->name('editMember');
Route::delete('/hapusMember/{id}', [AdminController::class, 'hapusMember'])->name('hapusMember');