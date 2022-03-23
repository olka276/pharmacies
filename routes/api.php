<?php

use App\Http\Controllers\{JsonImporterController, PharmaciesController, ExportController, DownloadController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/', [JsonImporterController::class, '__invoke'])->name('uploader');
Route::get('/pharmacies', [PharmaciesController::class, 'index']);
Route::post('/export', [ExportController::class, '__invoke']);
Route::get('/download', [DownloadController::class, '__invoke']);
