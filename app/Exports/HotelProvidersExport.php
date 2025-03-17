<?php
namespace App\Exports;

use App\Models\Hotel_provider;
use App\Models\HotelProvider;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HotelProvidersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Hotel_provider::select('hotel_code', 'giataId', 'provider_name', 'provider_code', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['Hotel Code', 'Giata ID', 'Provider Name', 'Provider Code', 'Date d\'ajout'];
    }
}
