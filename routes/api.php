<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

Route::get('/', function() {
    $connection = new mysqli(
        env('DB_HOST'), 
        env('DB_USERNAME'), 
        env('DB_PASSWORD'),
        env('DB_DATABASE'),
        env('DB_PORT')
    );

    return response()->json([
        'dbStatus' => $connection->connect_error ? 'FAIL' : 'OK',
        'importCronLastRunnedAt' => Cache::get(env('IMPORT_CRON_LASTRUN_CACHE_KEY'))
    ]);
});

Route::controller(ProductsController::class)->prefix('products')
->group(function() {
    Route::get('/', 'index');
    Route::get('/{code}', 'show');
    Route::put('/{code}', 'update');
    Route::delete('/{code}', 'destroy');
});
