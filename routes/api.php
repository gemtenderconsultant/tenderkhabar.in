<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DataController;
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

Route::get('/category', [DataController::class, 'category']);
Route::get('/authorities', [DataController::class, 'authorities']);
Route::get('/state', [DataController::class, 'state']);
Route::get('/live_tenders', [DataController::class, 'live_tenders']);
Route::get('/livetendercategory', [DataController::class, 'livetendercategory']);
Route::get('/tenderinfo_2017', [DataController::class, 'tenderinfo_2017']);
Route::get('/tenderinfo_items', [DataController::class, 'tenderinfo_items']);
Route::get('/tender_result_info', [DataController::class, 'tender_result_info']);
Route::get('/tender_result_category', [DataController::class, 'tender_result_category']);
Route::get('/tender_doc', [DataController::class, 'tender_doc']);