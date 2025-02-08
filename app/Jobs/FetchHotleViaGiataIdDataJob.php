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
    public function handle(): void
    {
        ini_set('memory_limit', '2G'); // Augmenter temporairement la mémoire si nécessaire
        $apiUrl = 'https://multicodes.giatamedia.com/webservice/rest/1.latest/properties/';
        $auth = ['giata|bedsconnect.com', 'keghak-qaXbed-rosne7'];
    
        $hotels = Hotel_new::where('etat', 0)->where('with_giata', 1)->cursor();
        foreach ($hotels as $hotel) {
            $url = $apiUrl . $hotel->giataId;
            Log::info("Fetching GIATA data for hotel ID: {$hotel->id}");
    
            try {
                $response = Http::withBasicAuth($auth[0], $auth[1])->retry(3, 1000)->get($url);
    
                if ($response->failed()) {
                    Log::error("Failed to fetch GIATA data for hotel ID: {$hotel->id}");
                    continue;
                }
    
                $xmlData = new SimpleXMLElement($response->body());
                $jsonData = json_encode($xmlData);
                $data = json_decode($jsonData, true);
                unset($xmlData); // Libérer la mémoire immédiatement
                gc_collect_cycles();
    
                if (!isset($data['property'])) {
                    $this->markAsUnmapped($hotel);
                    continue;
                }
    
                $data = $data['property'];
    
                $updateData = [
                    'hotel_name'   => $data['name'] ?? $hotel->hotel_name,
                    'giataId'      => $data['@attributes']['giataId'] ?? $hotel->giataId,
                    'city'         => $data['city'] ?? $hotel->city,
                    'citycode'     => isset($data['city']['@attributes']['cityId']) ? $data['city']['@attributes']['cityId'] : $hotel->citycode,
                    'country'      => $data['country'] ?? $hotel->country,
                    'country_code' => $data['country'] ?? $hotel->country_code,
                    'CategoryCode' => $data['category'] ?? 'Non spécifié',
                    'addresses'    => $this->getAddress($data),
                    'zip_code'     => $data['addresses']['address']['postalCode'] ?? $hotel->zip_code,
                    'phones_voice' => $this->getPhones($data, $hotel),
                    'email'        => $this->getEmails($data, $hotel),
                    'latitude'     => $data['geoCodes']['geoCode']['latitude'] ?? $hotel->latitude,
                    'longitude'    => $data['geoCodes']['geoCode']['longitude'] ?? $hotel->longitude,
                    'chainId'      => $data['chains']['chain']['@attributes']['chainId'] ?? $hotel->chainId,
                    'chainName'    => $data['chains']['chain']['@attributes']['chainName'] ?? $hotel->chainName,
                    'updated_at'   => now(),
                    'etat'         => 1,
                ];
    
                DB::table('hotel_news')->where('id', $hotel->id)->update($updateData);
                Log::info("GIATA data updated for hotel ID: {$hotel->id}");
    
                // Libérer la mémoire après chaque hôtel
                unset($data, $jsonData, $response);
                gc_collect_cycles(); // Nettoyage forcé de la mémoire
    
            } catch (\Exception $e) {
                Log::error("Error processing hotel ID {$hotel->id}: " . $e->getMessage());
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
