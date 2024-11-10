<?php

namespace App\Jobs;

use App\Exports\HotelsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $this->country = $country;
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
