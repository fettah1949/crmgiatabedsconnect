<?php

namespace App\Jobs;

use App\Models\Hotel_new;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class FetchGiataHotelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $hotels = Hotel_new::where('etat', 0)->where('with_giata', 1)->get();

        foreach ($hotels as $hotel) {
            if ($hotel->giataId === null) {
                Log::warning("giataId est null pour l'hôtel: " . $hotel->hotel_code);
                continue;
            }

            $url = 'https://multicodes.giatamedia.com/webservice/rest/1.latest/properties/' . $hotel->giataId;

            try {
                $response = Http::withBasicAuth('giata|bedsconnect.com', 'keghak-qaXbed-rosne7')->get($url);

                if ($response->successful()) {
                    $xmlData = new SimpleXMLElement($response->body());
                    $jsonData = json_encode($xmlData);
                    $data = json_decode($jsonData, true);

                    if ($data !== null && isset($data['property'])) {
                        $data = $data['property'];
                        $giataId = $data['@attributes']['giataId'];
                        $hotelName = $data['name'];
                        $city = $data['city'];

                        if (isset($data['propertyCodes']['provider'])) {
                            $propertyCodes = [];

                            foreach ($data['propertyCodes']['provider'] as $provider) {
                                $providerCode = $provider['@attributes']['providerCode'] ?? null;

                                if (isset($provider['code'][0])) {
                                    foreach ($provider['code'] as $code) {
                                        $propertyCodes[] = [
                                            'provider_code' => $providerCode,
                                            'code' => $code['value'] ?? null
                                        ];
                                    }
                                } else {
                                    $propertyCodes[] = [
                                        'provider_code' => $providerCode,
                                        'code' => $provider['code']['value'] ?? null
                                    ];
                                }
                            }

                            foreach ($propertyCodes as $propertyCode) {
                                $exists = DB::table('hotel_providers')
                                ->where('hotel_code', $hotel->hotel_code)
                                ->where('provider_name', $propertyCode['provider_code'])
                                ->where('provider_code', $propertyCode['code'])
                                ->exists();
                                if (!$exists) {
                                    DB::table('hotel_providers')->insert([
                                        'hotel_code' => $hotel->hotel_code,
                                        'giataId' => $hotel->giataId,
                                        'provider_name' => $propertyCode['provider_code'],
                                        'provider_code' => $propertyCode['code'],
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                } else {
                                    Log::info("Provider déjà existant: {$propertyCode['provider_code']} - Code: {$propertyCode['code']} pour l'hôtel " . $hotel->hotel_code);
                                }
                            }
                        }

                        Log::info("Données GIATA mises à jour pour l'hôtel : " . $hotel->hotel_code);
                    }
                }
            } catch (\Exception $e) {
                Log::error("Erreur API GIATA (hôtel: {$hotel->hotel_code}) : " . $e->getMessage());
            }

            unset($data, $jsonData, $response, $xmlData);
            gc_collect_cycles();
        }
    }
}
