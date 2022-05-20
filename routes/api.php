<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;

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

Route::get('/cidade/listagem', CityController::class)->name('city.all');

Route::group([
    'prefix' => 'endereco'
], function() {
    Route::get('/listagem', [AddressController::class, 'all'])->name('address.all');
    Route::post('/criar', [AddressController::class, 'store'])->name('address.store');
    Route::post('/{id}/atualizar', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/{id}/deletar', [AddressController::class, 'destroy'])->name('address.destroy');
});