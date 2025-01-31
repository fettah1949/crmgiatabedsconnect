<?php

namespace App\Http\Controllers;

use App\Exports\HotelsExport;
use App\Jobs\FetchGiataDataJob;
use App\Models\Hotel;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Provider;
use SimpleXMLElement;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;

use App\Jobs\ImportHotelDataJob;
use App\Models\ImportStatus;
use Illuminate\Support\Facades\Log;
use App\Jobs\ExportHotelsJob;
use App\Jobs\FetchHotleViaGiataIdDataJob;
use App\Jobs\UnifyBdcJob;
use App\Models\Hotel_new;

class HoteListController extends Controller
{
    public function index(){
    // $hotels = Hotellist::All();
    $hotels = Hotel_new::limit(100)->get();
    $hotels_count = Hotel_new::count();

    $code_hotel = "";
    $country = "";
    $provider_name = "";
    $provider_id = "";
    $bdc_id = "";
    $Name_hotel = "";
    $giata_id = "";


    
    $filter = [
        'code_hotel' => $code_hotel,
        'country' => $country,
        'provider_name' => $provider_name,
        'provider_id' => $provider_id,
        'bdc_id' => $bdc_id,
        'Name_hotel' => $Name_hotel,
        'giata_id' => $giata_id,

    ];


        // print_r($this->getProperty()) ;die;
        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'hotels'=>$hotels,
            'filter' => $filter,
            'hotels_count' => $hotels_count,

        ];
        return view('hotel.index')->with($data);
    }
    public function create()
    {
        return view('hotel.create') ;  
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'hotel_name' => 'nullable|string|max:255',
        'hotel_code' => 'nullable|string|max:50',
        'bdc_id' => 'nullable|string|max:50',
        'giataId' => 'nullable|string|max:50',
        'provider' => 'nullable|string|max:255',
        'provider_id' => 'nullable|string|max:50',
        'CategoryCode' => 'nullable|string|max:50',
        'CategoryName' => 'nullable|string|max:255',
        'Longitude' => 'nullable|numeric',
        'Latitude' => 'nullable|numeric',
        'City' => 'nullable|string|max:255',
        'CityCode' => 'nullable|string|max:50',
        'addresses' => 'nullable|string|max:255',
        'Zip_Code' => 'nullable|string|max:20',
        'Email' => 'nullable|email|max:255',
        'phones_voice' => 'nullable|string|max:50',
        'phones_fax' => 'nullable|string|max:50',
        'chainId' => 'nullable|string|max:50',
        'chainName' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:50', // Un seul pays
        'with_giata' => 'nullable|string|numeric', 
        'etat' => 'nullable|string|numeric', 
    ]);
    $bdc_id = $validatedData['bdc_id'];
    while (DB::table('hotel_news')->where('bdc_id', $bdc_id)->exists()) {
        $bdc_id = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
    }
    // Création d'un nouvel hôtel
    $hotel = new Hotel_new();
    $hotel->hotel_name = $validatedData['hotel_name'];
    $hotel->hotel_code = $validatedData['hotel_code'];
    $hotel->bdc_id = $bdc_id;
    $hotel->giataId = $validatedData['giataId'] ?? null;
    $hotel->provider = $validatedData['provider'] ?? null;
    $hotel->provider_id = $validatedData['provider_id'] ?? null;
    $hotel->CategoryCode = $validatedData['CategoryCode'] ?? null;
    $hotel->CategoryName = $validatedData['CategoryName'] ?? null;
    $hotel->Longitude = $validatedData['Longitude'] ?? null;
    $hotel->Latitude = $validatedData['Latitude'] ?? null;
    $hotel->City = $validatedData['City'] ?? null;
    $hotel->CityCode = $validatedData['CityCode'] ?? null;
    $hotel->addresses = $validatedData['addresses'] ?? null;
    $hotel->Zip_Code = $validatedData['Zip_Code'] ?? null;
    $hotel->Email = $validatedData['Email'] ?? null;
    $hotel->phones_voice = $validatedData['phones_voice'] ?? null;
    $hotel->phones_fax = $validatedData['phones_fax'] ?? null;
    $hotel->chainId = $validatedData['chainId'] ?? null;
    $hotel->chainName = $validatedData['chainName'] ?? null;
    $hotel->country_code = $validatedData['country'] ?? null;
    $hotel->country = $validatedData['country'] ?? null;
    $hotel->with_giata = $validatedData['with_giata'] ?? null;
    $hotel->etat = $validatedData['etat'] ?? 0;

    // Sauvegarde dans la base de données
    $hotel->save();

    // Redirection avec message de succès
    return redirect()->route('hotellist.index')
        ->with('success', 'Hotel added successfully.');
}



    // public function import(Request $request)
    // {
    //     //   return 'dddd';
    //     // Validation du fichier d'import
    //     try {
    //         // Validation du fichier pour accepter les fichiers CSV et XLSX
    //         $request->validate([
    //             'csv_file' => 'required|mimes:csv,txt,xlsx'
    //         ]);
        
    //         // Récupérer le fichier à partir de la demande
    //         $file = $request->file('csv_file');
    //         $extension = $file->getClientOriginalExtension();
        
    //         if ($extension == 'csv' || $extension == 'txt') {
    //             // Ouvrir le fichier CSV
    //             $handle = fopen($file, "r");
    //             $i = 0;
    //             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //                 if ($i != 0) {

    //                     $Hote = new Hotel;
                       
    //                     $Hote->hotel_code = $data[0];
    //                     if($data[1] != ""){
    //                         $Hote->bdc_id = $data[1];
    //                     }else{
    //                         $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
    //                             while (DB::table('hotels')->where('bdc_id', $chiffre)->exists()) {
    //                                 $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
    //                             }
    //                         $Hote->bdc_id = $chiffre;
    //                     }

    //                     $Hote->provider = $data[2];
    //                     $Hote->provider_id = $data[3];
    //                     $Hote->hotel_name = $data[4];
    //                     $Hote->latitude = $data[5];
    //                     $Hote->longitude = $data[6];
    //                     $Hote->addresses = $data[7];
    //                     $Hote->city = $data[8];
    //                     $Hote->zip_code = $data[9];
    //                     $Hote->country = $data[10];
    //                     $Hote->country_code = $data[11];
    //                     $Hote->CategoryCode = $data[12];
    //                     $Hote->CategoryName = $data[13];
    //                     $Hote->CityCode = $data[14];
    //                     $Hote->chainId = $data[15];
    //                     $Hote->chainName = $data[16];
    //                     $Hote->etat = 0;
                        
    //                     $Hote->save(); 
    //                 }
    //                 $i++;
    //             }
    //             fclose($handle);
    //         } elseif ($extension == 'xlsx') {
    //             // Lire le fichier XLSX
    //             $spreadsheet = IOFactory::load($file->getPathname());
    //             $worksheet = $spreadsheet->getActiveSheet();
    //             $rows = $worksheet->toArray();
        
    //             foreach ($rows as $index => $row) {
    //                 if ($index != 0) {
    //                     // return $row[0];
    //                     $Hote = new Hotel;
                       
    //                       $Hote->hotel_code = $row[0];
    //                     if($row[1] != ""){
    //                         $Hote->bdc_id = $row[1];
    //                     }else{
    //                         $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
    //                             while (DB::table('hotels')->where('bdc_id', $chiffre)->exists()) {
    //                                 $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
    //                             }
    //                         $Hote->bdc_id = $chiffre;
    //                     }

    //                     $Hote->provider = $row[2];
    //                     $Hote->provider_id = $row[3];
    //                     $Hote->hotel_name = $row[4];
    //                     $Hote->latitude = $row[5];
    //                     $Hote->longitude = $row[6];
    //                     $Hote->addresses = $row[7];
    //                     $Hote->city = $row[8];
    //                     $Hote->zip_code = $row[9];
    //                     $Hote->country = $row[10];
    //                     $Hote->country_code = $row[11];
    //                     $Hote->CategoryCode = $row[12];
    //                     $Hote->CategoryName = $row[13];
    //                     $Hote->CityCode = $row[14];
    //                     $Hote->chainId = $row[15];
    //                     $Hote->chainName = $row[16];
    //                     $Hote->etat = 0;

                       
                        

                        
                        
    //                     $Hote->save();
    //                 }
    //             }
    //         }
        
    //         // Rediriger l'utilisateur vers une page de confirmation
    //         return redirect()->back()
    //             ->with('status', 'success')
    //             ->withErrors('Le fichier a été importé avec succès.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->with('status', 'error')
    //             ->withErrors('Importation du fichier échouée : '.$e->getMessage());
    //     }
    //     //...
    
    //     // try {
    //     //     // Import the CSV file
    //     //     $request->validate([
    //     //         'csv_file' => 'required|mimes:csv,txt,xlsx'
    //     //     ]);
        
    //     //     // Récupérer le fichier CSV à partir de la demande
    //     //     $file = $request->file('csv_file');
            
            
    //     //     // Ouvrir le fichier CSV
    //     //     $handle = fopen($file, "r");
    //     // // return  fgetcsv($handle, 1000, ",");
    //     //     // Parcourir chaque ligne du fichier CSV
    //     //     $i=0;
    //     //     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //     //         // Ajouter la logique nécessaire pour importer les données à partir du fichier CSV et les enregistrer dans votre base de données
    //     //         // Exemple:Hotelmapping
                  
    //     //         if($i!=0)
    //     //         {
    //     //             return $data[0];
    //     //          $Hote = new Hotel;
    //     //         $Hote->hotel_name = $data[0];
    //     //         $Hote->hotel_code = $data[1];
    //     //         $Hote->giataId = $data[2];
    //     //         $Hote->city = $data[3];
    //     //         $Hote->country = $data[4];
    //     //         $Hote->addresses = $data[5];
    //     //         $Hote->phones_voice = $data[6];
    //     //         $Hote->phones_fax = $data[7];
    //     //         $Hote->email = $data[8];
    //     //         $Hote->latitude = $data[9];
    //     //         $Hote->longitude = $data[10];
    //     //         $Hote->chainId = $data[11];
    //     //         $Hote->chainName = $data[12];
    //     //         $Hote->zip_code = $data[13];

                
    //     //         $Hote->save(); 

              
    //     //         }
        
    //     //         $i=$i+1;
    //     //     }
        
    //     //     // Fermer le fichier CSV
    //     //     fclose($handle);
        
    //     //     // Rediriger l'utilisateur vers une page de confirmation
    //     //     return redirect()->back()
    //     //     ->with('status', 'success')
    //     //         ->withErrors('Le fichier CSV a été importé avec succès.');
    //     // } catch (\Exception $e) {
    //     //     return redirect()->back()
    //     //         ->with('status', 'error')
    //     //         ->withErrors('Importation du fichier CSV échouée : '.$e->getMessage());
    //     // }
    //     //...
    // }

        // public function import(Request $request)
        // {
        //     set_time_limit(0);
        //     // Validation du fichier d'import
        //     try {
        //         // $request->validate([
        //         //     'csv_file' => 'required|mimes:csv,txt,xlsx'
        //         // ]);
        //         // die($request->file('csv_file'));
        //         // Récupérer le fichier à partir de la demande
        //         $file = $request->file('csv_file');
        //         $extension = $file->getClientOriginalExtension();
                
        //         if ($extension == 'csv' || $extension == 'txt') {
        //             // Ouvrir le fichier CSV
        //             $handle = fopen($file, "r");
        //             $i = 0;

        //             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        //                 if ($i != 0) {
        //                     $this->saveHotelData($data);
        //                 }
        //                 $i++;
        //             }

        //             fclose($handle);
        //         } elseif ($extension == 'xlsx') {
        //             // Lire le fichier XLSX
        //             $spreadsheet = IOFactory::load($file->getPathname());
        //             $worksheet = $spreadsheet->getActiveSheet();
        //             $rows = $worksheet->toArray();

        //             foreach ($rows as $index => $row) {
        //                 if ($index != 0) {
        //                     $this->saveHotelData($row);
        //                 }
        //             }
        //         }

        //         // Rediriger l'utilisateur vers une page de confirmation
        //         return redirect()->back()
        //             ->with('status', 'success')
        //             ->withErrors('Le fichier a été importé avec succès.');

        //     } catch (\Exception $e) {
        //         return redirect()->back()
        //             ->with('status', 'error')
        //             ->withErrors('Importation du fichier échouée : ' . $e->getMessage());
        //     }
        // }

        // Fonction pour sauvegarder les données de l'hôtel
        // private function saveHotelData(array $data)
        // {
        //     $Hote = new Hotel;

        //     $Hote->hotel_code = $data[0];
        //     $Hote->bdc_id = $data[1] ?: $this->generateUniqueBdcId();
        //     $Hote->provider = $data[2];
        //     $Hote->provider_id = $data[3];
        //     $Hote->hotel_name = $data[4];
        //     $Hote->latitude = $data[5];
        //     $Hote->longitude = $data[6];
        //     $Hote->addresses = $data[7];
        //     $Hote->city = $data[8];
        //     $Hote->zip_code = $data[9];
        //     $Hote->country = $data[10];
        //     $Hote->country_code = $data[11];
        //     $Hote->CategoryCode = $data[12];
        //     $Hote->CategoryName = $data[13];
        //     $Hote->CityCode = $data[14];
        //     $Hote->chainId = $data[15];
        //     $Hote->chainName = $data[16];
        //     $Hote->etat = 0;

        //     $Hote->save();
        // }

        // Fonction pour générer un ID BDC unique
        // private function generateUniqueBdcId()
        // {
        //     $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
        //     while (DB::table('hotels')->where('bdc_id', $chiffre)->exists()) {
        //         $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
        //     }
        //     return $chiffre;
        // }


        // public function import(Request $request)
        // {
            
        //     // Validation du fichier
        //     $request->validate([
        //         'csv_file' => 'required|mimes:csv,txt,xlsx',
        //     ]);
    
        //     // Récupérer le fichier et le stocker
        //     $file = $request->file('csv_file');
        //     $filePath = $file->storeAs('imports', $file->getClientOriginalName());
    
        //     // Récupérer l'extension
        //     $extension = $file->getClientOriginalExtension();
    
        //     // Ajouter le traitement dans la file d'attente
        //     ImportHotelDataJob::dispatch($filePath, $extension);
        //     // ->with('status', 'success')
        //     //             ->withErrors('Le fichier a été importé avec succès.');
        //     return redirect()->back()->with('status', 'Fichier ajouté en attente d\'importation. Le traitement est en cours.')->withErrors('Le fichier a été importé avec succès.');
        // }.

        public function import(Request $request)
        {
            ini_set('memory_limit', '4096M'); // 4 Go
            set_time_limit(0);
            // Validation du fichier d'import
            try {
                $request->validate([
                    'csv_file' => 'required|mimes:csv,txt,xlsx'
                ]);
        
                // Récupérer le fichier à partir de la demande
                $file = $request->file('csv_file');
                $extension = $file->getClientOriginalExtension();
                $fileName = $file->getClientOriginalName();
                
                // Enregistrer le fichier sur le disque temporairement
                 $filePath = $file->store('uploads');
                 
                //  die($filePath_1);
                $filePath = storage_path('app/uploads/' . basename($filePath));
                if (!file_exists($filePath)) {
                    Log::error("Le fichier n'existe pas : " . $filePath);
                    return; // Gérer l'erreur comme souhaité
                }

                       // Créer un statut d'importation
                        $importStatus = ImportStatus::create([
                            'file_name' => $fileName,
                            'status' => 'pending',
                        ]);
        
                // Dispatchez le job
                ImportHotelDataJob::dispatch($filePath, $extension, $importStatus->id);
        
                // Rediriger l'utilisateur vers une page de confirmation
                // return redirect()->back()
                //     ->with('status', 'success')
                //     ->withErrors('Le fichier est en cours d\'importation.');
                        // Rediriger l'utilisateur avec une réponse JSON
                    return response()->json([
                        'status' => 'success',
                        'file_name' => $importStatus->id,
                        'message' => 'Le fichier est en cours d\'importation.'
                    ]);
        
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('status', 'error')
                    ->withErrors('Importation du fichier échouée : ' . $e->getMessage());
            }
        }
        public function checkImportStatus(Request $request)
        {
            $fileName = $request->query('fileName'); // Récupère le nom de fichier depuis la requête
         
            $importStatus = ImportStatus::where('id', $fileName)->first();
        
            if (!$importStatus) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Statut non disponible pour ce fichier.'
                ]);
            }
        
            return response()->json([
                'file_name' => $importStatus->file_name,
                'status' => $importStatus->status
            ]);
        }
        
        public function exportHotels(Request $request)
        {
            ini_set('memory_limit', '4096M'); // 4 Go

            $fileName = 'hotels_export' .'.xlsx';

            $codeHotel = $request->input('codeHotel');
            $country = $request->input('country');
            $providerName = $request->input('providerName');
            $providerID = $request->input('providerID');
            $bdc_id = $request->input('bdc_id');
            $Name_hotel = $request->input('Name_hotel');

            ExportHotelsJob::dispatch($fileName, $codeHotel, $country, $providerName, $providerID, $bdc_id, $Name_hotel);

            return response()->json(['message' => 'L’exportation a été lancée avec succès !', 'file' => $fileName]);

        }
        public function deleteFile($filename)
        {
            if (Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);
                return response()->json(['message' => 'Fichier supprimé avec succès.']);
            }
        
            return response()->json(['message' => 'Fichier introuvable.'], 404);
        }

        public function checkExportStatus($fileName)
        {
            // $filePath = storage_path('storage/exports/' . $fileName);
            $filePath = storage_path('app/exports/' . $fileName);

            if (file_exists($filePath)) {
                return response()->json(['ready' => true, 'download_url' => asset('storage/exports/' . $fileName)]);
            }

            return response()->json(['ready' => false, 'message' => 'Le fichier est en cours de création.']);
        }

        

    public function export()
    {
        // Récupérez les données que vous souhaitez exporter depuis votre modèle ou votre source de données
        // SELECT COUNT(*) AS nbr_doublon, bdc_id FROM hotellists GROUP BY bdc_id HAVING COUNT(*) > 1;
        // $data = DB::table('hotels')
        // // ->where('id','>=',532182)
        // ->select(DB::raw('COUNT(*) AS nbr_doublon , bdc_id'))
        
        //  ->groupBy('bdc_id')
        // ->having('nbr_doublon', '>', 1)
        // ->get();
        $data  =  Hotel_new::All();
        //   return $data ;
        // $data = new Hotellist;
    
        // Convertissez les données en tableau ou en format souhaité pour l'exportation (par exemple, CSV, Excel, etc.)
        $exportData = [];
    
        foreach ($data as $row) {
            $exportData[] = [


   
            'Hotel Code' => $row->hotel_name,
            'Hotel Name' => $row->hotel_code,
            'GiataId' => $row->giataId,
            'City' => $row->city,
            'Country' => $row->country,     
            'Address' => $row->addresses,
            'Phones voice' => $row->phones_voice,
            'Phones fax' => $row->phones_fax,
            'Email' => $row->email,
            'Latitude' => $row->latitude,
            'Longitude' => $row->longitude,
            'ChainId' => $row->chainId,
            'ChainName' => $row->chainName,
            'Zip_Code' => $row->zip_code,

           
                // Ajoutez d'autres colonnes si nécessaire
            ];
        }
    
        // Convertissez les données en format CSV en utilisant la fonction de Laravel
        $csvData = $this->convertToCsv($exportData);
    
        // Définissez les en-têtes de la réponse pour indiquer qu'il s'agit d'un fichier CSV à télécharger
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export.csv"',
        ];
    
        // Retournez la réponse avec les données CSV et les en-têtes
        return Response::make($csvData, 200, $headers);
    }
    private function convertToCsv(array $data)
    {
        $delimiter = ',';
        $enclosure = '"';
        $handle = fopen('php://temp', 'w');
    
        // En-têtes du fichier CSV
        fputcsv($handle, array_keys($data[0]), $delimiter, $enclosure);
    
        // Données du fichier CSV
        foreach ($data as $row) {
            fputcsv($handle, $row, $delimiter, $enclosure);
        }
    
        rewind($handle);
        $csvData = stream_get_contents($handle);
        fclose($handle);
    
        return $csvData;
    }


    // public function getProperty(Request $request)
    // {
    //     $Provider = $request['provider'];
    //     $return = 0 ;
    //     $hotels = Hotel::where('etat',0);
        
    //    $hotels_count = $hotels->count();

    //    $hotels =  $hotels->get();
    //    foreach ($hotels as $hotel) 
    //    {
        
    //          if($hotel->provider_id == "bedsconnect"){
               
    //             $url = 'https://multicodes.giatamedia.com/webservice/rest/1.0/properties/crs/'.$hotel->provider_id.'/'.$hotel->bdc_id;
    //          }else{
    //             $url = 'https://multicodes.giatamedia.com/webservice/rest/1.0/properties/crs/'.$hotel->provider_id.'/'.$hotel->hotel_code;
    //             // return  $url;
    //          }
             

          

    //             // Fetching credentials from .env file or hardcoding as necessary
    //             $username = 'giata|bedsconnect.com';
    //             $password = 'keghak-qaXbed-rosne7';

    //             // Making the GET request to the GIATA API with Basic Authentication
    //             $response = Http::withBasicAuth($username, $password)
    //                             ->get($url);

    //             // Check if the request was successful
    //             if ($response->successful()) {
                
    //                 // Parsing the XML response
    //                 $xmlData = new SimpleXMLElement($response->body());
                    
                  
    //                 // Convert to JSON if needed
    //                 $jsonData = json_encode($xmlData);

    //                         // Decode JSON into an associative array
    //                     $data = json_decode($jsonData, true);

    //                     // Check if the JSON is not null and 'property' exists
    //                     if ($data !== null && isset($data['property'])) {
                             
    //                         $data = $data['property'];
    //                         // Extracting the data
    //                         $giataId = $data['@attributes']['giataId'];
    //                         $hotelName = $data['name'];
    //                         $city = $data['city'];         

    //                         // Vérifie d'abord si l'attribut 'cityId' existe
    //                         if (isset($xmlData->property->city['cityId'])) {
                              
    //                             $cityId = (string) $xmlData->property->city['cityId'];  // Récupère l'attribut 'cityId'
    //                         } else {
    //                             $cityId = ' ';  // Valeur par défaut si l'attribut n'existe pas
    //                         }

    //                         $country = $data['country'];
    //                         // if (isset($data['addresses'])) {
    //                         //     $addresses = implode(', ', $data['addresses']['address']['addressLine'] ?? []);
    //                         //     $postalCode = $data['addresses']['address']['postalCode'] ?? $hotel->zip_code;
    //                         // } else {
    //                         //     $addresses = " ";
    //                         //     $postalCode = " ";
    //                         // }

    //                         if (isset($data['addresses']['address']['addressLine'])) {
    //                             // Vérifier si c'est un tableau ou une chaîne
    //                             if (is_array($data['addresses']['address']['addressLine'])) {
    //                                 $addresses = implode(', ', $data['addresses']['address']['addressLine']);
    //                             } else {
    //                                 // Si ce n'est pas un tableau, utilisez directement la valeur
    //                                 $addresses = $data['addresses']['address']['addressLine'];
    //                             }
    //                             $postalCode = $data['addresses']['address']['postalCode'] ?? $hotel->zip_code;
    //                         } else {
    //                             $addresses = " ";
    //                             $postalCode = " ";
    //                         }
                            
    //                         // $postalCode = $data['addresses']['address']['postalCode'];
                           
                            
    //                         // $phonesVoice = implode(', ', $data['phones']['phone']);

    //                         // $phonesVoice = is_array($data['phones']['phone']) ? implode(', ', $data['phones']['phone']) : $data['phones']['phone'];
    //                         $phonesVoice = isset($data['phones']['phone']) ? $data['phones']['phone'] : $hotel->phones_voice;

    //                         // $email = $data['emails']['email'];
    //                         $email = isset($data['emails']['email']) ? $data['emails']['email'] : $hotel->email;
    //                         // $latitude = $data['geoCodes']['geoCode']['latitude'];
    //                         $latitude = isset($data['geoCodes']['geoCode']['latitude']) ? $data['geoCodes']['geoCode']['latitude'] : $hotel->email;
    //                         // $longitude = $data['geoCodes']['geoCode']['longitude'];
    //                         $longitude = isset($data['geoCodes']['geoCode']['longitude']) ? $data['geoCodes']['geoCode']['longitude'] : $hotel->email;
    //                         // $chainId = $data['chains']['chain']['@attributes']['chainId'];
    //                         $chainId = isset($data['chains']['chain']['@attributes']['chainId']) ? $data['chains']['chain']['@attributes']['chainId'] : $hotel->chainId;
    //                         // $chainName = $data['chains']['chain']['@attributes']['chainName'];
    //                         $chainName = isset($data['chains']['chain']['@attributes']['chainName']) ? $data['chains']['chain']['@attributes']['chainName'] : $hotel->chainName;
    //                         // return  $jsonData .' ----------------- '.implode(', ', $data['phones']['phone']);
    //                         // Update or insert the data into your database
    //                         DB::table('hotels')
    //                         ->where('id', $hotel->id)
    //                         ->update([
    //                                     'hotel_name' => $hotelName,
    //                                     'giataId' => $giataId,
    //                                     'city' => $city,
    //                                     'country' => $country,
    //                                     'country_code' => $country,
    //                                     'addresses' => $addresses,
    //                                     'phones_voice' => $phonesVoice,
    //                                     'email' => $email,
    //                                     'latitude' => $latitude,
    //                                     'longitude' => $longitude,
    //                                     'chainId' => $chainId,
    //                                     'chainName' => $chainName,
    //                                     'zip_code' => $postalCode,
    //                                     'citycode' => $cityId,
    //                                     'updated_at' => now(),
    //                                     'etat' => 1,
    //                                 ]
    //                             );

                        
    //                         // count for hotels
    //                         $propertyCount = count($xmlData->property);

    //                     // Handle the data (e.g., return it as a view, JSON, etc.)
    //                    // return response()->json(json_decode($jsonData));
                 
    //                 }
    //                 $return =    response()->json(['count' => $hotels_count, 'data' => json_decode($jsonData)]);

    //             } else {
    //                 // Handle the error
    //                 $return =   response()->json(['error' => 'Unable to fetch data from GIATA API'], 500);
    //             }
    //         }
    //         return  $return ;


        
    // }

    public function update(Request $request)
    {
        // Valider les données envoyées
        $request->validate([
            'id' => 'required|exists:hotels,id',
            'hotel_name' => 'nullable|string|max:255',
            'hotel_code' => 'nullable|string|max:255',
            'provider_id' => 'nullable|string|max:255',
            'provider' => 'nullable|string|max:255',
            'bdc_id' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'giataId' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|max:255',
            'CityCode' => 'nullable|string|max:255',
            'addresses' => 'nullable|string|max:255',
            'phones_voice' => 'nullable|string|max:255',
            'phones_fax' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'chainId' => 'nullable|string|max:255',
            'chainName' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'CategoryCode' => 'nullable|string|max:255',
            'CategoryName' => 'nullable|string|max:255',
        ]);
    
        // Récupérer l'hôtel et mettre à jour les champs
        $hotel = Hotel_new::findOrFail($request->id);
        // die($request->id);
        $hotel->update($request->except(['_token', 'id']));
    
        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Hôtel mis à jour avec succès !');
    }
     



    public function getProperty(Request $request)
    {
        // Récupérer le fournisseur depuis la requête
        $provider = $request->input('provider');
        
        // Récupérer les hôtels qui n'ont pas été traités
        $hotels = Hotel_new::where('etat', 0)->where('with_giata', 0)->get();
        $hotels_count = $hotels->count();

        // Si aucun hôtel n'est trouvé, retourner une réponse
        if ($hotels_count != 0) {
            // return Response::json(['count' => $hotels_count,'message' => 'Aucun hôtel trouvé.'], 404);
                    // Lancer le job pour chaque hôtel
        foreach ($hotels as $hotel) {
            // Log::info("Données  l'hôtel : " . $hotel->hotel_code);
            FetchGiataDataJob::dispatch($hotel);
        
        }

}

        return Response::json(['count' => $hotels_count, 'message' => 'Les données GIATA sont en cours de récupération.'], 200);
    }
    public function getProperty_giata_id(Request $request)
    {
        // Récupérer le fournisseur depuis la requête
        // $provider = $request->input('provider');
        
        // Récupérer les hôtels qui n'ont pas été traités
        $hotels = Hotel_new::where('etat', 0)->where('with_giata', 1)->get();
        $hotels_count = $hotels->count();

        // Si aucun hôtel n'est trouvé, retourner une réponse
        if ($hotels_count != 0) {
           // Lancer le job pour chaque hôtel
            foreach ($hotels as $hotel) {
                // Log::info("Données  l'hôtel : " . $hotel->hotel_code);
                FetchHotleViaGiataIdDataJob::dispatch($hotel);
            }
        }

       

        return Response::json(['count' => $hotels_count, 'message' => 'Les données GIATA sont en cours de récupération.'], 200);
    }

    public function checkUpdateStatus()
    {
        // Comptez le nombre d'hôtels mappés et non mappés
        $mappedCount = Hotel_new::where('etat', 1)->where('with_giata', 0)->count();
        // $mappedCount = Hotel::whereNotNull('categoryCode')->where('with_giata', 0)->where('etat', 0)->count();
        // $nonMappedCount = Hotel::whereNull('categoryCode')->where('with_giata', 0)->where('etat', 0)->count();
        $nonMappedCount = Hotel_new::where('etat', 0)->where('with_giata', 0)->count();
        $nonMappedCountingiata = Hotel_new::where('etat', -1)->where('with_giata', 0)->count();

        // Déterminer si la mise à jour est terminée
        $completed = ($nonMappedCount === 0);

        return response()->json([
            'completed' => $completed,
            'mappedCount' => $mappedCount,
            'nonMappedCount' => $nonMappedCount,
            'nonMappedCountingiata' => $nonMappedCountingiata,
        ]);
    }
    public function checkUpdateStatusunifiercode()
    {
        // Comptez le nombre d'hôtels mappés et non mappés
        $hotelsGroupedByGiataId = DB::table('hotel_news')
        ->select('giataid')
        ->groupBy('giataid')
        ->havingRaw('COUNT(DISTINCT bdc_id) > 1')
        ->where('giataid', '!=', '')
        ->count();

        // Déterminer si la mise à jour est terminée
        $completed = ($hotelsGroupedByGiataId === 0);

        return response()->json([
            'hotelsGroupedByGiataId' => $hotelsGroupedByGiataId,
          
        ]);
    }
    public function checkUpdateStatusviagitaid()
    {
        // Comptez le nombre d'hôtels mappés et non mappés
        $mappedCount = Hotel_new::where('etat', 1)->where('with_giata', 1)->count();
        $nonMappedCount = Hotel_new::where('etat', 0)->where('with_giata', 1)->count();
        $nonMappedCountingiata = Hotel_new::where('etat', -1)->where('with_giata', 1)->count();

        // Déterminer si la mise à jour est terminée
        $completed = ($nonMappedCount === 0);

        return response()->json([
            'completed' => $completed,
            'mappedCount' => $mappedCount,
            'nonMappedCount' => $nonMappedCount,
            'nonMappedCountingiata' => $nonMappedCountingiata,
        ]);
    }

    public function search(Request $request)
    {

        $code_hotel = $request->input('code_hotel');
        $countries = $request->input('country');  // Récupère les pays sous forme de tableau
        $provider_name = $request->input('provider_name');
        $provider_id = $request->input('provider_id');
        $bdc_id = $request->input('bdc_id');
        $Name_hotel = $request->input('Name_hotel');
        $giata_id = $request->input('giata_id');
    
        $hotels_count = Hotel_new::count();

        $query = Hotel_new::query();
    
        if($code_hotel != ""){
            $query->where('hotel_code', $code_hotel);
        }
    
        if(!empty($countries)){  // Vérifie si des pays ont été sélectionnés
            $query->whereIn('country_code', $countries);
        }
    
        if($provider_name != ""){
            $query->where('provider', $provider_name);
        }
    
        if($provider_id != ""){
            $query->where('provider_id', $provider_id);
        }
        if($bdc_id != ""){
            $query->where('bdc_id', $bdc_id );
        }
        if($Name_hotel != ""){
            $query->where('hotel_name', 'like', '%' . $Name_hotel. '%');
        }
        if($giata_id != ""){
            $query->where('with_giata',  $giata_id);
        }
         
        // Exécuter la requête et récupérer les résultats
        $hotels = $query->limit(100)->get();

        $filter = [
            'code_hotel' => $code_hotel,
            'country' => $countries,
            'provider_name' => $provider_name,
            'provider_id' => $provider_id,
            'bdc_id' => $bdc_id,
            'Name_hotel' => $Name_hotel,
            'giata_id' => $giata_id,
        ];


        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'hotels'=>$hotels,
            'filter' => $filter,
            'hotels_count' => $hotels_count,

    
        ];
        
        return view('hotel.index',$data) ;   
        

    }

    public function unifier_bdc(Request $request)
    {
        UnifyBdcJob::dispatch();
        return "Le job d'unification des bdc_id a été lancé avec succès.";
    }
    


}
