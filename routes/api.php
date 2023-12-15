<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\LanguageController;
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
Route::get('countries/{id}', 'CountryController@show');
Route::get('/country/orderbysize', [CountryController::class, 'getCountriesOrderedBySize']);
Route::get('/country/withzerocities', [CountryController::class, 'getCountriesWithoutCities']);
Route::get('/country/independencenull', [CountryController::class, 'getCountriesWithNullIndependence']);
Route::get('/country/independence/{year1}/{year2}', [CountryController::class, 'getCountriesByIndependenceYearRange']);
Route::get('/country/letter/{letter}', [CountryController::class, 'getCountriesByLetter']);
Route::get('/city/orderbyname', [CityController::class, 'getCitiesOrderedByName']);
Route::get('/city/top/{numTop}', [CityController::class, 'getTopCities']);
Route::get('/country/stats/{Code}', [CountryController::class, 'getCountryStats']);
Route::get('/country/officialang', [LanguageController::class, 'getOfficialLanguages']);


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
