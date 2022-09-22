<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Relatorios;
use App\Http\Controllers\Workshop;

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

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group( function () {
    //Inscritos
    Route::get('workshops', [Workshop::class, 'index']);
    Route::get('workshops/{id}', [Workshop::class, 'show']);
    Route::put('workshops/{id}', [Workshop::class, 'update']);
    Route::delete('workshops/{id}', [Workshop::class, 'destroy']);

    //Constantes Grupos
    Route::get('grupos', [Workshop::class, 'grupos']);
    Route::get('estados-civis', [Workshop::class, 'estadosCivis']);

    //Relatorios
    Route::get('relatorios', [Relatorios::class, 'index']);
});
Route::post('cadastrar-workshop', [Workshop::class, 'store']);
Route::get('dispara', [Workshop::class, 'dispara']);
Route::get('exporta/{id}', [Relatorios::class, 'pdf']);

