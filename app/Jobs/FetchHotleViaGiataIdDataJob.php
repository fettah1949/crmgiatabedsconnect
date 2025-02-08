<?php

namespace App\Jobs;

use App\Models\Hotel_new;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class FetchHotleViaGiataIdDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {
    //     ini_set('memory_limit', '2G'); // Augmenter temporairement la mémoire si nécessaire
    //     $apiUrl = 'https://multicodes.giatamedia.com/webservice/rest/1.latest/properties/';
    //     $auth = ['giata|bedsconnect.com', 'keghak-qaXbed-rosne7'];
    
    //     $hotels = Hotel_new::where('etat', 0)->where('with_giata', 1)->cursor();
    //     foreach ($hotels as $hotel) {
    //         $url = $apiUrl . $hotel->giataId;
    //         Log::info("Fetching GIATA data for hotel ID: {$hotel->id}");
    
    //         try {
    //             $response = Http::withBasicAuth($auth[0], $auth[1])->retry(3, 1000)->get($url);


    //             if ($response->status() == 404) {
    //                 Log::warning("Hotel ID {$hotel->id} not found in GIATA (404). Marking as unmapped.");
    //                 $this->markAsUnmapped($hotel);
    //                 continue;
    //             }
    
    //             if ($response->failed()) {
    //                 Log::error("Failed to fetch GIATA data for hotel ID: {$hotel->id}");
    //                 continue;
    //             }
    
    //             $xmlData = new SimpleXMLElement($response->body());
    //             $jsonData = json_encode($xmlData);
    //             $data = json_decode($jsonData, true);
    //             unset($xmlData); // Libérer la mémoire immédiatement
    //             gc_collect_cycles();
    
    //             if (!isset($data['property'])) {
    //                 $this->markAsUnmapped($hotel);
    //                 continue;
    //             }
    
    //             $data = $data['property'];
    
    //             $updateData = [
    //                 'hotel_name'   => $data['name'] ?? $hotel->hotel_name,
    //                 'giataId'      => $data['@attributes']['giataId'] ?? $hotel->giataId,
    //                 'city'         => $data['city'] ?? $hotel->city,
    //                 'citycode'     => isset($data['city']['@attributes']['cityId']) ? $data['city']['@attributes']['cityId'] : $hotel->citycode,
    //                 'country'      => $data['country'] ?? $hotel->country,
    //                 'country_code' => $data['country'] ?? $hotel->country_code,
    //                 'CategoryCode' => $data['category'] ?? 'Non spécifié',
    //                 'addresses'    => $this->getAddress($data),
    //                 'zip_code'     => $data['addresses']['address']['postalCode'] ?? $hotel->zip_code,
    //                 'phones_voice' => $this->getPhones($data, $hotel),
    //                 'email'        => $this->getEmails($data, $hotel),
    //                 'latitude'     => $data['geoCodes']['geoCode']['latitude'] ?? $hotel->latitude,
    //                 'longitude'    => $data['geoCodes']['geoCode']['longitude'] ?? $hotel->longitude,
    //                 'chainId'      => $data['chains']['chain']['@attributes']['chainId'] ?? $hotel->chainId,
    //                 'chainName'    => $data['chains']['chain']['@attributes']['chainName'] ?? $hotel->chainName,
    //                 'updated_at'   => now(),
    //                 'etat'         => 1,
    //             ];
    
    //             DB::table('hotel_news')->where('id', $hotel->id)->update($updateData);
    //             Log::info("GIATA data updated for hotel ID: {$hotel->id}");
    
    //             // Libérer la mémoire après chaque hôtel
    //             unset($data, $jsonData, $response);
    //             gc_collect_cycles(); // Nettoyage forcé de la mémoire
    
    //         } catch (\Exception $e) {
    //             Log::error("Error processing hotel ID {$hotel->id}: " . $e->getMessage());
    //         }
    //     }
    // }


    public function handle(): void
    {
        ini_set('memory_limit', '2G');
        $hotels = Hotel_new::where('etat', 0)->where('with_giata', 1)->get();
        foreach ($hotels as $hotel) {
            $url = 'https://multicodes.giatamedia.com/webservice/rest/1.latest/properties/'. $hotel->giataId;
            // Log::info("Données url via giataId : " . $url);
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
                                $postalCode = $data['addresses']['address']['postalCode'] ?? $hotel->zip_code;
                            } else {
                                $addresses = " ";
                                $postalCode = " ";
                            }
                            
                            // $postalCode = $data['addresses']['address']['postalCode'];
                            
                            
                            // $phonesVoice = implode(', ', $data['phones']['phone']);

                            // $phonesVoice = is_array($data['phones']['phone']) ? implode(', ', $data['phones']['phone']) : $data['phones']['phone'];
                            $phonesVoice = isset($data['phones']['phone']) ? $data['phones']['phone'] : $hotel->phones_voice;

                            // $email = $data['emails']['email'];
                            // $email = isset($data['emails']['email']) ? $data['emails']['email'] : $hotel->email;
                            $email = isset($data['emails']['email']) ? (is_array($data['emails']['email']) ? json_encode($data['emails']['email']) : json_encode([$data['emails']['email']])) : $hotel->email;

                            // $latitude = $data['geoCodes']['geoCode']['latitude'];
                            $latitude = isset($data['geoCodes']['geoCode']['latitude']) ? $data['geoCodes']['geoCode']['latitude'] : $hotel->latitude;
                            // $longitude = $data['geoCodes']['geoCode']['longitude'];
                            $longitude = isset($data['geoCodes']['geoCode']['longitude']) ? $data['geoCodes']['geoCode']['longitude'] : $hotel->longitude;
                            // $chainId = $data['chains']['chain']['@attributes']['chainId'];
                            $chainId = isset($data['chains']['chain']['@attributes']['chainId']) ? $data['chains']['chain']['@attributes']['chainId'] : $hotel->chainId;
                            // $chainName = $data['chains']['chain']['@attributes']['chainName'];
                            $chainName = isset($data['chains']['chain']['@attributes']['chainName']) ? $data['chains']['chain']['@attributes']['chainName'] : $hotel->chainName;
                            // return  $jsonData .' ----------------- '.implode(', ', $data['phones']['phone']);
                            // Update or insert the data into your database
                            DB::table('hotel_news')
                            ->where('id', $hotel->id)
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

                            // Libérer la mémoire après chaque hôtel
                                unset($data, $jsonData, $response);
                                gc_collect_cycles(); // Nettoyage forcé de la mémoire
                            // count for hotels
                            $propertyCount = count($xmlData->property);

                            Log::info("Données GIATA mises à jour pour l'hôtel : " . $hotel->hotel_code);
                        }else {
                            // Marquer l'hôtel comme non mappé
                            DB::table('hotel_news')
                                ->where('id', $hotel->id)
                                ->update(['etat' => -1, 'updated_at' => now()]); // -1 pour indiquer "non mappé"
                            
                            Log::warning("Hôtel non mappé : " . $hotel->hotel_code);
                        }
                } else {
                    Log::error("Échec de récupération des données GIATA pour l'hôtel: " . $hotel->hotel_code);
                }

            } catch (\Exception $e) {
                Log::error("Erreur lors de l'appel API GIATA : " . $e->getMessage());
            }
        }
    }
    

    private function markAsUnmapped($hotel)
    {
        DB::table('hotel_news')->where('id', $hotel->id)->update([
            'etat'       => -1,
            'updated_at' => now(),
        ]);
        Log::warning("Hotel ID {$hotel->id} marked as unmapped.");
    }

    private function getAddress($data)
    {
        if (!isset($data['addresses']['address']['addressLine'])) {
            return " ";
        }
        return is_array($data['addresses']['address']['addressLine'])
            ? implode(', ', $data['addresses']['address']['addressLine'])
            : $data['addresses']['address']['addressLine'];
    }

    private function getPhones($data, $hotel)
    {
        return isset($data['phones']['phone']) ? $data['phones']['phone'] : $hotel->phones_voice;
    }

    private function getEmails($data, $hotel)
    {
        return isset($data['emails']['email'])
            ? (is_array($data['emails']['email']) ? json_encode($data['emails']['email']) : json_encode([$data['emails']['email']]))
            : $hotel->email;
    }



}
