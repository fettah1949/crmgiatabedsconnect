<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Hotel;
use App\Models\Hotel_new;
use App\Models\ImportStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportHotelDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $filePath;
    protected $extension;
    protected $importStatusId;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $extension, $importStatusId)
    {
        $this->filePath = $filePath;
        $this->extension = $extension;
        $this->importStatusId = $importStatusId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Début du traitement du fichier : " . $this->filePath);
        $importStatus = ImportStatus::find($this->importStatusId);
        try {
            // Définir la taille du lot
            $batch = [];
            $batchSize = 1000; // Par exemple, 1000 lignes par batch
    
            if ($this->extension == 'csv' || $this->extension == 'txt') {
                // Ouvrir le fichier CSV
                $handle = fopen($this->filePath, "r");
                $i = 0;
    
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($i != 0) {
                        $batch[] = $this->mapHotelData($data); // Mappe les données
                    }
    
                    // Insertion par lot
                    if (count($batch) >= $batchSize) {
                        Hotel_new::insert($batch); // Insérer le batch
                        $batch = []; // Réinitialiser le batch
                    }
                    $i++;
                }
    
                fclose($handle);
    
                // Insérer les données restantes
                if (!empty($batch)) {
                    Hotel_new::insert($batch);
                }
            } elseif ($this->extension == 'xlsx') {
                // Lire le fichier XLSX
                $spreadsheet = IOFactory::load($this->filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                $batch = [];
    
                foreach ($rows as $index => $row) {
                    if ($index != 0) {
                        $batch[] = $this->mapHotelData($row); // Mappe les données
                    }
    
                    // Insertion par lot
                    if (count($batch) >= $batchSize) {
                        Hotel_new::insert($batch); // Insérer le batch
                        $batch = []; // Réinitialiser le batch
                    }
                }
    
                // Insérer les données restantes
                if (!empty($batch)) {
                    Hotel_new::insert($batch);
                }
            }
    
            // Archiver le fichier après importation
            // $archivePath = storage_path('app/imports/archived/');
            // if (!file_exists($archivePath)) {
            //     mkdir($archivePath, 0755, true); // Créer le répertoire s'il n'existe pas
            // }
            // rename($this->filePath, $archivePath . basename($this->filePath));
        // Mise à jour du statut après succès
                $importStatus->update(['status' => 'completed']);
                Log::info("Fichier importé avec succès : " . $this->filePath);
                    // Supprimer le fichier après importation
            if (file_exists($this->filePath)) {
                unlink($this->filePath); // Supprimer le fichier
                Log::info("Fichier supprimé : " . $this->filePath);
            }

        } catch (\Exception $e) {
            // Gérer les erreurs
            $importStatus->update(['status' => 'failed']);
            logger()->error('Erreur d\'importation: ' . $e->getMessage());
        }
    }
    
    // Fonction pour mapper les données de l'hôtel
    private function mapHotelData(array $data): array
    {
        return [
            'hotel_name' => $data[0],
            'hotel_code' => $data[1],
            'bdc_id' => $data[2] ?: $this->generateUniqueBdcId(),
            'giataId' => $data[3],           
            'provider' => $data[4],
            'provider_id' => $data[5],
            'city' => $data[6],
            'CityCode' => $data[7],
            'country_code' => $data[8],
            'addresses' => $data[9],
            'zip_code' => $data[10],
            'phones_voice' => $data[11],
            'latitude' => $data[12],
            'longitude' => $data[13],
            'chainName' => $data[14],
            'status' => $data[15],
            'with_giata' => $data[16],
            'etat' => 0,
        ];
    }
    
    
        // Fonction pour générer un ID BDC unique
        private function generateUniqueBdcId()
        {
            $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
            while (DB::table('hotel_news')->where('bdc_id', $chiffre)->exists()) {
                $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
            }
            return $chiffre;
        }
}
