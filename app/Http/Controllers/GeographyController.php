<?php

namespace App\Http\Controllers;

use App\Models\Geography;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class GeographyController extends Controller
{

    public function index(){
        // $hotels = Hotellist::All();
        $Geography = Geography::limit(10)->get();

        // print_r($this->getProperty()) ;die;
        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'hotels'=>$Geography

        ];
        return view('geo.index')->with($data);
    }
    public function getCountries(Request $request)
    {
        // die("fettah ");
        $search = $request->input('q'); // Récupérer le paramètre de recherche envoyé par AJAX
        
        // Requête pour trouver les pays correspondant à la recherche
        $countries = DB::table('geographies')
                        ->distinct()
                        ->select('countryName') // Assurez-vous que ces champs existent dans votre table
                        ->where('countryName', 'like', '%' . $search . '%')
                        ->get();

        // Retourner les pays sous forme de JSON pour Select2
        return response()->json($countries);
    }
    public function create()
    {
        return view('geo.create') ;  
    }


    public function getProperty()
    {
     
        $url = 'https://multicodes.giatamedia.com/webservice/rest/1.0/geography';
        $username = 'giata|bedsconnect.com';
        $password = 'keghak-qaXbed-rosne7';

        // Send the request to the API with Basic Authentication
        $response = Http::withBasicAuth($username, $password)->get($url);

        // Check if the request was successful
        if ($response->successful()) {
    
    

            // Parsing the XML response
                $xmlData = new SimpleXMLElement($response->body());

            // Convert to JSON if needed
                $jsonData = json_encode($xmlData);
                $data = json_decode($jsonData, true);
            // print_r($jsonData);die;
            // Loop through the countries
            foreach ($data['countries']['country'] as $country) {
                $countryCode = $country['@attributes']['countryCode'];
                $countryName = $country['@attributes']['countryName'];
                
                // Loop through the destinations
                if (isset($country['destinations']['destination'])) {
                    $destinations = isset($country['destinations']['destination'][0]) ? $country['destinations']['destination'] : [$country['destinations']['destination']];
                    
                    foreach ($destinations as $destination) {
                        $destinationId = $destination['@attributes']['destinationId'];
                        $destinationName = $destination['@attributes']['destinationName'];

                        // Loop through the cities
                        if (isset($destination['cities']['city'])) {
                            $cities = isset($destination['cities']['city'][0]) ? $destination['cities']['city'] : [$destination['cities']['city']];
                            
                            foreach ($cities as $city) {
                                $cityId = $city['@attributes']['cityId'];
                                $cityName = $city['@attributes']['cityName'];

                                // Insert data into the geographies table using the Geography model
                                Geography::create([
                                    'countryCode'      => $countryCode,
                                    'countryName'      => $countryName,
                                    'destinationId'    => $destinationId,
                                    'destinationName'  => $destinationName,
                                    'cityId'           => $cityId,
                                    'cityName'         => $cityName,
                                ]);
                            }
                        }
                    }
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Geographies imported successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch data from API.']);
        }
    }
}


