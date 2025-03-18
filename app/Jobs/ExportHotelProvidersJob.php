<?php
namespace App\Jobs;

use App\Exports\HotelProvidersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportHotelProvidersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $giataId;
    protected $providerName;

    public function __construct($giataId = null, $providerName = null)
    {
        $this->giataId = $giataId;
        $this->providerName = $providerName;
    }

    public function handle()
    {
        // Générer un nom de fichier unique
        $fileName = 'exports_v2/hotel_providers_' . now()->format('Ymd_His') . '.xlsx';

        // Exporter et stocker le fichier
        // Excel::store(new HotelProvidersExport, $fileName, 'public');
        Excel::store(new HotelProvidersExport($this->giataId, $this->providerName), $fileName, 'public');


        // Enregistrer le chemin du fichier pour qu'on puisse le récupérer plus tard
        Storage::disk('public')->put('latest_export.txt', $fileName);
    }
}
