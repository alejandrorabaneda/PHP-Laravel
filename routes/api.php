<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Models\Country;
use App\Models\City;

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

Route::post('countries', [CountryController::class, 'store'])->middleware('validate.country.fields');
Route::put('countries/{code}', [CountryController::class, 'update'])->middleware('validate.country.fields');
Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{code}', [CountryController::class, 'show']);
Route::delete('countries/{code}', [CountryController::class, 'destroy']);
Route::get('/countries/name/{name}', 'CountryController@getByName');

Route::get('/test/countries', function () {
    // Obtén todos los países con ciudades (relación)
    $countries = Country::with('cities')->get();
    return response()->json(['countries' => $countries]);
});

Route::get('/test/cities', function () {
    // Obtén todas las ciudades con el país al que pertenecen (relación)
    $cities = City::with('country')->get();
    return response()->json(['cities' => $cities]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
