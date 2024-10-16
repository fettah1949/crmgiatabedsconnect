<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Provider;
use SimpleXMLElement;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HoteListController extends Controller
{
    public function index(){
                // $hotels = Hotellist::All();
    $hotels = Hotel::limit(10)->get();

        // print_r($this->getProperty()) ;die;
        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'hotels'=>$hotels

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
        $request->validate([

            'Hotel_Code' => 'required',
            'giataId' => 'nullable',
            'Hotel_Name' => 'required',
            'Latitude' => 'nullable',
            'Longitude' => 'nullable',
            'addresses' => 'nullable',
            'City' => 'nullable',
            'Zip_Code' => 'nullable',
            'Email' => 'nullable',
            'Country' => 'nullable',
            'phones_voice' => 'nullable',
            'phones_fax' => 'nullable',
            'chainId' => 'nullable',
            'chainName' => 'nullable',
  
        ]);
    
        Hotel::create($request->all());
     
        return redirect()->route('hotellist.index')
                        ->with('success','Hotel created successfully.');  
    }


    public function import(Request $request)
    {
        //   return 'dddd';
        // Validation du fichier d'import
        try {
            // Validation du fichier pour accepter les fichiers CSV et XLSX
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt,xlsx'
            ]);
        
            // Récupérer le fichier à partir de la demande
            $file = $request->file('csv_file');
            $extension = $file->getClientOriginalExtension();
        
            if ($extension == 'csv' || $extension == 'txt') {
                // Ouvrir le fichier CSV
                $handle = fopen($file, "r");
                $i = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($i != 0) {

                        $Hote = new Hotel;
                       
                        $Hote->hotel_code = $data[0];
                        $Hote->bdc_id = $data[1];
                        // $Hote->provider_id = $data[2];
                        $Hote->hotel_name = $data[3];
                        $Hote->latitude = $data[4];
                        $Hote->longitude = $data[5];
                        $Hote->addresses = $data[6];
                        $Hote->city = $data[7];
                        $Hote->zip_code = $data[8];
                        $Hote->country = $data[9];
                        $Hote->country_code = $data[10];
                        $Hote->chainId = $data[14];
                        $Hote->chainName = $data[15];
                        $Hote->etat = 0;
                        
                        $Hote->save(); 
                    }
                    $i++;
                }
                fclose($handle);
            } elseif ($extension == 'xlsx') {
                // Lire le fichier XLSX
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
        
                foreach ($rows as $index => $row) {
                    if ($index != 0) {
                        // return $row[0];
                        $Hote = new Hotel;
                       
                        $Hote->hotel_code = $row[0];
                        $Hote->bdc_id = $row[1];
                        // $Hote->provider_id = $row[2];
                        $Hote->hotel_name = $row[3];
                        $Hote->latitude = $row[4];
                        $Hote->longitude = $row[5];
                        $Hote->addresses = $row[6];
                        $Hote->city = $row[7];
                        $Hote->zip_code = $row[8];
                        $Hote->country = $row[9];
                        $Hote->country_code = $row[10];
                        $Hote->chainId = $row[14];
                        $Hote->chainName = $row[15];
                        $Hote->etat = 0;
     
                        

                       
                        

                        
                        
                        $Hote->save();
                    }
                }
            }
        
            // Rediriger l'utilisateur vers une page de confirmation
            return redirect()->back()
                ->with('status', 'success')
                ->withErrors('Le fichier a été importé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->withErrors('Importation du fichier échouée : '.$e->getMessage());
        }
        //...
    
        // try {
        //     // Import the CSV file
        //     $request->validate([
        //         'csv_file' => 'required|mimes:csv,txt,xlsx'
        //     ]);
        
        //     // Récupérer le fichier CSV à partir de la demande
        //     $file = $request->file('csv_file');
            
            
        //     // Ouvrir le fichier CSV
        //     $handle = fopen($file, "r");
        // // return  fgetcsv($handle, 1000, ",");
        //     // Parcourir chaque ligne du fichier CSV
        //     $i=0;
        //     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        //         // Ajouter la logique nécessaire pour importer les données à partir du fichier CSV et les enregistrer dans votre base de données
        //         // Exemple:Hotelmapping
                  
        //         if($i!=0)
        //         {
        //             return $data[0];
        //          $Hote = new Hotel;
        //         $Hote->hotel_name = $data[0];
        //         $Hote->hotel_code = $data[1];
        //         $Hote->giataId = $data[2];
        //         $Hote->city = $data[3];
        //         $Hote->country = $data[4];
        //         $Hote->addresses = $data[5];
        //         $Hote->phones_voice = $data[6];
        //         $Hote->phones_fax = $data[7];
        //         $Hote->email = $data[8];
        //         $Hote->latitude = $data[9];
        //         $Hote->longitude = $data[10];
        //         $Hote->chainId = $data[11];
        //         $Hote->chainName = $data[12];
        //         $Hote->zip_code = $data[13];

                
        //         $Hote->save(); 

              
        //         }
        
        //         $i=$i+1;
        //     }
        
        //     // Fermer le fichier CSV
        //     fclose($handle);
        
        //     // Rediriger l'utilisateur vers une page de confirmation
        //     return redirect()->back()
        //     ->with('status', 'success')
        //         ->withErrors('Le fichier CSV a été importé avec succès.');
        // } catch (\Exception $e) {
        //     return redirect()->back()
        //         ->with('status', 'error')
        //         ->withErrors('Importation du fichier CSV échouée : '.$e->getMessage());
        // }
        //...
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
        $data  =  Hotel::All();
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


    public function getProperty(Request $request)
    {
        $Provider = $request['provider'];
        $return = 0 ;
        $hotels = Hotel::where('etat',0);
        
       $hotels_count = $hotels->count();

       $hotels =  $hotels->get();
       foreach ($hotels as $hotel) {

             if($hotel->provider_id = "bedsconnect")
             $url = 'https://multicodes.giatamedia.com/webservice/rest/1.0/properties/crs/'.$hotel->provider_id.'/'.$hotel->bdc_id;

             else
             $url = 'https://multicodes.giatamedia.com/webservice/rest/1.0/properties/crs/'.$hotel->provider_id.'/'.$hotel->hotel_code;

        //   return  $url;

                // Fetching credentials from .env file or hardcoding as necessary
                $username = 'giata|bedsconnect.com';
                $password = 'keghak-qaXbed-rosne7';

                // Making the GET request to the GIATA API with Basic Authentication
                $response = Http::withBasicAuth($username, $password)
                                ->get($url);

                // Check if the request was successful
                if ($response->successful()) {
                
                    // Parsing the XML response
                    $xmlData = new SimpleXMLElement($response->body());

                    // Convert to JSON if needed
                    $jsonData = json_encode($xmlData);
                    //  return $jsonData;
                    $data = json_decode($jsonData, true)['property'];
                    //  return $data['@attributes'];
                    // Extracting the data
                    $giataId = $data['@attributes']['giataId'];
                    $hotelName = $data['name'];
                    $city = $data['city'];
                    $country = $data['country'];
                    $addresses = implode(', ', $data['addresses']['address']['addressLine']);
                    // $postalCode = $data['addresses']['address']['postalCode'];
                    $postalCode = isset($data['addresses']['address']['postalCode']) ? $data['addresses']['address']['postalCode'] : $hotel->zip_code;

                    // $phonesVoice = implode(', ', $data['phones']['phone']);

                    // $phonesVoice = is_array($data['phones']['phone']) ? implode(', ', $data['phones']['phone']) : $data['phones']['phone'];
                    $phonesVoice = isset($data['phones']['phone']) ? $data['phones']['phone'] : $hotel->phones_voice;

                    // $email = $data['emails']['email'];
                    $email = isset($data['emails']['email']) ? $data['emails']['email'] : $hotel->email;
                    // $latitude = $data['geoCodes']['geoCode']['latitude'];
                    $latitude = isset($data['geoCodes']['geoCode']['latitude']) ? $data['geoCodes']['geoCode']['latitude'] : $hotel->email;
                    // $longitude = $data['geoCodes']['geoCode']['longitude'];
                    $longitude = isset($data['geoCodes']['geoCode']['longitude']) ? $data['geoCodes']['geoCode']['longitude'] : $hotel->email;
                    // $chainId = $data['chains']['chain']['@attributes']['chainId'];
                    $chainId = isset($data['chains']['chain']['@attributes']['chainId']) ? $data['chains']['chain']['@attributes']['chainId'] : $hotel->chainId;
                    // $chainName = $data['chains']['chain']['@attributes']['chainName'];
                    $chainName = isset($data['chains']['chain']['@attributes']['chainName']) ? $data['chains']['chain']['@attributes']['chainName'] : $hotel->chainName;
                    // return  $jsonData .' ----------------- '.implode(', ', $data['phones']['phone']);
                    // Update or insert the data into your database
                    DB::table('hotels')
                    ->where('hotel_code', $hotel->hotel_code)
                    ->update([
                                'hotel_name' => $hotelName,
                                'giataId' => $giataId,
                                'city' => $city,
                                'country' => $country,
                                'addresses' => $addresses,
                                'phones_voice' => $phonesVoice,
                                'email' => $email,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                                'chainId' => $chainId,
                                'chainName' => $chainName,
                                'zip_code' => $postalCode,
                                'updated_at' => now(),
                                'etat' => 1,
                            ]
                        );

                
                    // count for hotels
                    $propertyCount = count($xmlData->property);

                    // Handle the data (e.g., return it as a view, JSON, etc.)
                    // return response()->json(json_decode($jsonData));
                  $return =    response()->json(['count' => $hotels_count, 'data' => json_decode($jsonData)]);
                } else {
                    // Handle the error
                    $return =   response()->json(['error' => 'Unable to fetch data from GIATA API'], 500);
                }
            }
            return  $return ;


        
    }
}
