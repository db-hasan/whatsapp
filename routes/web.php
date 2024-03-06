<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', [WhatsappController::class, 'whatsApp'])->name('whatsApp');
Route::post('/', [WhatsappController::class, 'import'])->name('import');

Route::get('/whatsApp', [App\Http\Controllers\CustomerController::class, 'indexPackage']);
Route::post('/whatsApp', [App\Http\Controllers\CustomerController::class, 'importPackage'])->name('dataimport');




    