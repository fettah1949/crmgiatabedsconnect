<?php

use App\Http\Controllers\AirportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\GeographyController;
use App\Http\Controllers\HoteListController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class,'login']);
Route::post('/',[AuthController::class,'auth_login']);


Route::get('panel/dashbord',[DashbordController::class,'index']);
// Route::get('/dashbordanalyse', 'DashbordController@index');
Route::get('dashbordanalyse',[DashbordController::class,'index']);
Route::get('hotelListe',[HoteListController::class,'index']);
Route::get('CountryListe',[GeographyController::class,'index']);
Route::get('AirportListe',[AirportController::class,'index']);

Route::resource('/hotellist', HoteListController::class);
Route::post('/import', [HoteListController::class,'import'])->name('import');
Route::get('/export', [HoteListController::class,'export'])->name('export');


Route::get('/giata/property', [HoteListController::class, 'getProperty'])->name('giata.property');
Route::get('/geo/property', [GeographyController::class, 'getProperty'])->name('geo.property');
Route::get('/airport/property', [AirportController::class, 'getProperty'])->name('Airport.property');

// Route::resource('hotelListe', HoteListController::class);
