<?php

use App\Exports\HotelProvidersExport;
use App\Http\Controllers\AirportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\GeographyController;
use App\Http\Controllers\HoteListController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ExportHotelProvidersJob;

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
Route::get('hotelListe/search',[HoteListController::class,'search'])->name('hotelListe.search');
Route::get('CountryListe',[GeographyController::class,'index']);
Route::get('AirportListe',[AirportController::class,'index']);
Route::get('ProviderListe',[ProviderController::class,'index']);
Route::get('indexproviderhotel',[ProviderController::class,'indexproviderhotel']);

Route::resource('/ProviderList', ProviderController::class);
Route::resource('/hotellist', HoteListController::class);
Route::post('/import', [HoteListController::class,'import'])->name('import');
Route::get('/export', [HoteListController::class,'export'])->name('export');


Route::get('/giata/property', [HoteListController::class, 'getProperty'])->name('giata.property');
Route::get('/giata/getProperty_giata_id', [HoteListController::class, 'getProperty_giata_id'])->name('giata.getProperty_giata_id');
Route::get('/giata/unifier_bdc', [HoteListController::class, 'unifier_bdc'])->name('giata.unifier_bdc');

Route::get('/giata/Apiprovider_hotel', [ProviderController::class, 'Apiprovider_hotel'])->name('giata.Apiprovider_hotel');

Route::get('/job-status', function () {
    $jobName = 'App\Jobs\FetchGiataHotelsJob'; // Remplace par le nom de ton job exact

    // Vérifier si le job est toujours en cours dans la table `jobs`
    $isJobPending = DB::table('jobs')->where('queue', $jobName)->exists();

    return response()->json(['pending' => $isJobPending]);
})->name('check.job.status');





Route::get('/start-export', function () {
    ExportHotelProvidersJob::dispatch();
    return response()->json(['message' => 'Export lancé, veuillez patienter...']);
})->name('start.export');

Route::get('/check-export-status', function () {
    if (Storage::disk('public')->exists('latest_export.txt')) {
        $filePath = Storage::disk('public')->get('latest_export.txt');
        return response()->json(['status' => 'done', 'file' => asset('storage/' . $filePath)]);
    }
    return response()->json(['status' => 'pending']);
})->name('check.export.status');


Route::get('/geo/property', [GeographyController::class, 'getProperty'])->name('geo.property');
Route::get('/api/countries', [GeographyController::class, 'getCountries'])->name('api.countries');
Route::get('/api/cities', [GeographyController::class, 'getCities'])->name('api.cities');
Route::get('/api/citiesid', [GeographyController::class, 'getCitiesid'])->name('api.citiesid');


Route::get('/airport/property', [AirportController::class, 'getProperty'])->name('Airport.property');

Route::get('/importstatus', [HoteListController::class, 'checkImportStatus'])->name('importstatus');

// Route::post('/export-data', [HoteListController::class, 'exportData'])->name('exportData');
Route::get('/export-hotels', [HoteListController::class, 'exportHotels'])->name('hotels.export');

Route::get('/check-update-status', [HoteListController::class, 'checkUpdateStatus'])->name('hotels.checkUpdateStatus');
Route::get('/checkUpdateStatusviagitaid', [HoteListController::class, 'checkUpdateStatusviagitaid'])->name('hotels.checkUpdateStatusviagitaid');
Route::get('/checkUpdateStatusunifiercode', [HoteListController::class, 'checkUpdateStatusunifiercode'])->name('hotels.checkUpdateStatusunifiercode');

Route::get('/check-export-status/{fileName}', function($fileName) {
    $filePath = 'public/' . $fileName;
    if (Storage::exists($filePath)) {
         $url = env('APP_URL') . '/storage/' . $fileName;
         
        return response()->json(['ready' => true, 'url' => Storage::url($filePath)]);
    } else {
        return response()->json(['ready' => false]);
    }
})->name('hotels.checkExportStatus');

Route::get('/hotels/delete-file/{filename}', [HoteListController::class, 'deleteFile'])->name('hotels.deleteFile');


Route::post('/hotel/update', [HoteListController::class, 'update'])->name('hotel.update');
Route::post('/provider/update', [ProviderController::class, 'update'])->name('provider.update');
Route::post('/hotel/destroy', [HoteListController::class, 'destroy'])->name('hotel.destroy');
// Route::resource('HoteList', HoteListController::class);
// Route::resource('hotelListe', HoteListController::class);
