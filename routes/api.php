<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AllTablesController;

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

Route::get('/tendersearch', [ApiController::class, 'search']);

Route::get('/all-tables', [AllTablesController::class, 'fulldataccess']);
Route::get('/state-tender-summary', [AllTablesController::class, 'stateTenderSummary']);
Route::post('/gettendersdata', [AllTablesController::class, 'actionGettendersdata']);
Route::post('/gettendersdatas', [AllTablesController::class, 'tendersearch']);