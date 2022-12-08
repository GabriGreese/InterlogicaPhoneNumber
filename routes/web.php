<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumbersController;

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

Route::get('/', [NumbersController::class, 'index'])->name('number.index');
Route::post('/', [NumbersController::class, 'indexAjax'])->name('number.indexAjax');
Route::post('/number/{id}/edit/', [NumbersController::class, 'edit'])->name('number.edit');
Route::post('/number/{id}/update/', [NumbersController::class, 'update'])->name('number.update');
Route::post('/number/check_correctness', [NumbersController::class, 'checkCorrectness'])->name('number.checkCorrectness');
