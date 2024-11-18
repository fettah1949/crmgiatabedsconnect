<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class FetchGiataDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hotel;
    /**
     * Create a new job instance.
     */
    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = 'https://multicodes.giatamedia.com/webservice/rest/1.latest/properties/crs/'. $this->hotel->provider_id . '/' . ($this->hotel->provider_id == "bedsconnect" ? $this->hotel->bdc_id : $this->hotel->hotel_code);
        Log::info("Données url : " . $url);
        try {
            $response = Http::withBasicAuth('giata|bedsconnect.com', 'keghak-qaXbed-rosne7')->get($url);

            if ($response->successful()) {
                 // Parsing the XML response
                 $xmlData = new SimpleXMLElement($response->body());
                    
                  
                 // Convert to JSON if needed
                 $jsonData = json_encode($xmlData);

                         // Decode JSON into an associative array
                     $data = json_decode($jsonData, true);

                     // Check if the JSON is not null and 'property' exists
                     if ($data !== null && isset($data['property'])) 
                     {
                          
                         $data = $data['property'];
                         // Extracting the data
                         $giataId = $data['@attributes']['giataId'];
                         $hotelName = $data['name'];
                         $city = $data['city'];         

                         // Vérifie d'abord si l'attribut 'cityId' existe
                         if (isset($xmlData->property->city['cityId'])) {
                           
                             $cityId = (string) $xmlData->property->city['cityId'];  // Récupère l'attribut 'cityId'
                         } else {
                             $cityId = ' ';  // Valeur par défaut si l'attribut n'existe pas
                         }

                         $country = $data['country'];
                         $category = isset($data['category']) ? $data['category'] : "Non spécifié";                        


                         if (isset($data['addresses']['address']['addressLine'])) {
                             // Vérifier si c'est un tableau ou une chaîne
                             if (is_array($data['addresses']['address']['addressLine'])) {
                                 $addresses = implode(', ', $data['addresses']['address']['addressLine']);
                             } else {
                                 // Si ce n'est pas un tableau, utilisez directement la valeur
                                 $addresses = $data['addresses']['address']['addressLine'];
                             }
                             $postalCode = $data['addresses']['address']['postalCode'] ?? $this->hotel->zip_code;
                         } else {
                             $addresses = " ";
                             $postalCode = " ";
                         }
                         
                         // $postalCode = $data['addresses']['address']['postalCode'];
                        
                         
                         // $phonesVoice = implode(', ', $data['phones']['phone']);

                         // $phonesVoice = is_array($data['phones']['phone']) ? implode(', ', $data['phones']['phone']) : $data['phones']['phone'];
                         $phonesVoice = isset($data['phones']['phone']) ? $data['phones']['phone'] : $this->hotel->phones_voice;

                         // $email = $data['emails']['email'];
                         $email = isset($data['emails']['email']) ? $data['emails']['email'] : $this->hotel->email;
                         // $latitude = $data['geoCodes']['geoCode']['latitude'];
                         $latitude = isset($data['geoCodes']['geoCode']['latitude']) ? $data['geoCodes']['geoCode']['latitude'] : $this->hotel->email;
                         // $longitude = $data['geoCodes']['geoCode']['longitude'];
                         $longitude = isset($data['geoCodes']['geoCode']['longitude']) ? $data['geoCodes']['geoCode']['longitude'] : $this->hotel->email;
                         // $chainId = $data['chains']['chain']['@attributes']['chainId'];
                         $chainId = isset($data['chains']['chain']['@attributes']['chainId']) ? $data['chains']['chain']['@attributes']['chainId'] : $this->hotel->chainId;
                         // $chainName = $data['chains']['chain']['@attributes']['chainName'];
                         $chainName = isset($data['chains']['chain']['@attributes']['chainName']) ? $data['chains']['chain']['@attributes']['chainName'] : $this->hotel->chainName;
                         // return  $jsonData .' ----------------- '.implode(', ', $data['phones']['phone']);
                         // Update or insert the data into your database
                         DB::table('hotels')
                         ->where('id', $this->hotel->id)
                         ->update([
                                     'hotel_name' => $hotelName,
                                     'giataId' => $giataId,
                                     'city' => $city,
                                     'country' => $country,
                                     'country_code' => $country,
                                     'addresses' => $addresses,
                                     'phones_voice' => $phonesVoice,
                                     'email' => $email,
                                     'latitude' => $latitude,
                                     'longitude' => $longitude,
                                     'chainId' => $chainId,
                                     'chainName' => $chainName,
                                     'zip_code' => $postalCode,
                                     'citycode' => $cityId,
                                     'CategoryCode' => $category,
                                     'updated_at' => now(),
                                     'etat' => 1,
                                 ]
                             );

                     
                         // count for hotels
                         $propertyCount = count($xmlData->property);

                         Log::info("Données GIATA mises à jour pour l'hôtel : " . $this->hotel->hotel_code);
                     }else {
                        // Marquer l'hôtel comme non mappé
                        DB::table('hotels')
                            ->where('id', $this->hotel->id)
                            ->update(['etat' => -1, 'updated_at' => now()]); // -1 pour indiquer "non mappé"
                        
                        Log::warning("Hôtel non mappé : " . $this->hotel->hotel_code);
                    }
            } else {
                Log::error("Échec de récupération des données GIATA pour l'hôtel: " . $this->hotel->hotel_code);
            }

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'appel API GIATA : " . $e->getMessage());
        }
    }
}
