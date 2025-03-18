<?php
namespace App\Exports;

use App\Models\Hotel_provider;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HotelProvidersExport implements FromCollection, WithHeadings
{
    protected $giataId;
    protected $providerName;

    public function __construct($giataId = null, $providerName = null)
    {
        $this->giataId = $giataId;
        $this->providerName = $providerName;
    }

    public function collection()
    {
        $query = Hotel_provider::query();

        if ($this->giataId) {
            $query->where('giataId', $this->giataId);
        }

        if ($this->providerName) {
            $query->where('provider_name', $this->providerName);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Hotel Code',
            'Giata ID',
            'Provider Name',
            'Provider Code',
            
        ];
    }
}

