<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class AirportController extends Controller
{
    public function index(){
        // $hotels = Hotellist::All();
        $Airport = Airport::limit(10)->get();

        // print_r($this->getProperty()) ;die;
        $data = [
            'category_name' => 'liste',
            'page_name' => 'liste',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'hotels'=>$Airport

        ];
        return view('Airport.index')->with($data);
    }

    public function getProperty()
    {
     
        $url = 'https://multicodes.giatamedia.com/webservice/rest/1.0/airports';
        $username = 'giata|bedsconnect.com';
        $password = 'keghak-qaXbed-rosne7';

        // Send the request to the API with Basic Authentication
        $response = Http::withBasicAuth($username, $password)->get($url);

        // Check if the request was successful
        if ($response->successful()) {
    
    

            // Parsing the XML response
                $xmlData = new SimpleXMLElement($response->body());

            // Convert to JSON if needed
            //     $jsonData = json_encode($xmlData);
            //     $data = json_decode($jsonData, true);
            // print_r($jsonData);die;
      
              // Loop through each airport entry
              foreach ($xmlData->airport as $airport) {
                $attributes = $airport->attributes();

                // Insert or update airport data using Eloquent
                Airport::updateOrCreate(
                    ['iata' => (string)$attributes->iata], // Unique field to prevent duplicates
                    [
                        'airportName' => (string)$attributes->airportName,
                        'countryCode' => (string)$attributes->countryCode,
                        'regionCode' => isset($attributes->regionCode) ? (string)$attributes->regionCode : null,
                    ]
                );
            }
        
            return response()->json(['status' => 'success', 'message' => 'Airports data inserted successfully! ']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch airport data.']);
        }
    }
}
