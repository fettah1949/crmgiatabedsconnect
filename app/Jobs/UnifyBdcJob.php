<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnifyBdcJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Récupérer tous les giataid ayant des doublons de bdc_id
        $hotelsGroupedByGiataId = DB::table('hotels')
            ->select('giataid')
            ->groupBy('giataid')
            ->havingRaw('COUNT(DISTINCT bdc_id) > 1')
            ->where('giataid', '!=', '')
            ->get();
            Log::info("unifier bdc_id via giataId : ");
        if ($hotelsGroupedByGiataId->isEmpty()) {
            return "Aucun doublon trouvé.";
        }

        foreach ($hotelsGroupedByGiataId as $group) {
            // Récupérer tous les bdc_id pour le giataid actuel
            $bdcIds = DB::table('hotels')
                ->where('giataid', $group->giataid)
                ->pluck('bdc_id');

            // Trouver un bdc_id qui commence par "BDC"
            $bdcIdPrincipal = null;
            foreach ($bdcIds as $bdcId) {
                if (str_starts_with($bdcId, 'BDCX')) {
                    continue;
                } else {
                    $bdcIdPrincipal = $bdcId;
                    break;
                }
            }

            // Si aucun bdc_id commençant par "BDC" n'est trouvé, utiliser le premier ou générer un nouveau
            if (!$bdcIdPrincipal) {
                $bdcIdPrincipal = $bdcIds->first() ?: 'BDC' . rand(10000000, 99999999);
            }

            // Mettre à jour tous les hôtels avec le bdc_id principal
            DB::table('hotels')
                ->where('giataid', $group->giataid)
                ->update(['bdc_id' => $bdcIdPrincipal]);
        }

        return "Unification des bdc_id pour les hôtels en doublon terminée.";
    }
}
