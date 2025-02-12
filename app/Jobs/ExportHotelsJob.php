<?php

namespace App\Jobs;

use App\Exports\HotelsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExportHotelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;
    protected $codeHotel;
    protected $country;
    protected $providerName;
    protected $providerID;
    protected $bdc_id;
    protected $Name_hotel;

    public function __construct($fileName, $codeHotel, $country, $providerName, $providerID, $bdc_id, $Name_hotel)
    {
        $this->fileName = $fileName;
        $this->codeHotel = $codeHotel;
        // $this->country = array_map('strval', $this->country);
        $this->country = $country; // Correction ici
        Log::info("Valeur du tableau country dans export 2  : ", ['country' => $this->country]);
        $this->providerName = $providerName;
        $this->providerID = $providerID;
        $this->bdc_id = $bdc_id;
        $this->Name_hotel = $Name_hotel;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ini_set('max_execution_time', 0); // Pas de limite de temps
        ini_set('memory_limit', '4096M'); // Augmenter la mémoire

        if (!is_array($this->country)) {
            Log::error("Problème avec \$this->country, ce n'est pas un tableau", ['country' => $this->country]);
            $this->country = (array) $this->country; // Conversion en tableau au cas où
        }
      
        Log::info("Valeur après conversion de country:  1 ", ['country' => $this->country]);

        Excel::store(new HotelsExport(
            $this->codeHotel,
            $this->country,
            $this->providerName,
            $this->providerID,
            $this->bdc_id,
            $this->Name_hotel
        ), $this->fileName, 'public');
    }
}
