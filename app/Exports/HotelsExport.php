<?php

namespace App\Exports;

use App\Models\Hotel;
use App\Models\Hotel_new;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Exportable;

class HotelsExport implements FromQuery, WithHeadings, WithChunkReading
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $codeHotel;
    protected $country;
    protected $providerName;
    protected $providerID;
    protected $bdc_id;
    protected $Name_hotel;

    public function __construct($codeHotel, $country, $providerName, $providerID, $bdc_id, $Name_hotel)
    {
        $this->codeHotel = $codeHotel;
        $this->country = $country;
        $this->providerName = $providerName;
        $this->providerID = $providerID;
        $this->bdc_id = $bdc_id;
        $this->Name_hotel = $Name_hotel;
    }
    // public function collection()
    // {
    //     return $this->query();
    // }
    


    public function query()
    {
        ini_set('memory_limit', '4096M'); // 4 Go

        // $query = Hotel::query();
        $query = Hotel_new::select( 'hotel_name', 'hotel_code', 'bdc_id', 'giataid', 'provider', 'provider_id', 
                      'city', 'CityCode', 'CategoryCode' , 'country_code', 'addresses', 'zip_code', 'phones_voice', 
                      'latitude', 'longitude', 'chainName', 'status');


        if ($this->codeHotel) {
         
            $query->where('hotel_code',  $this->codeHotel );
        }
        if ($this->country) {
            $query->whereIn('country_code',  $this->country );
        }
        if ($this->providerName) {
            $query->where('provider', $this->providerName );
        }
        if ($this->providerID) {
            $query->where('provider_id', $this->providerID);
        }
        if ($this->bdc_id) {
            $query->where('bdc_id', $this->bdc_id);
        }
        if ($this->Name_hotel) {
            $query->where('hotel_name', 'like', '%' . $this->Name_hotel . '%');
        }
        

        return $query;
    }

    public function headings(): array       
    {
        return [
            'Hotel name', 'Code Hotel', 'BDC ID', 'GiataId', 'Provider', 'Provider_id', 'City', 'City_ID', 'Category' ,'Country_code', 'Addresses', 'Zip_code', 'Phones', 'Latitude', 'Longitude', 'ChainName', 'Statut'
        ];
    }

    public function chunkSize(): int
    {
        return 1000; // Vous pouvez ajuster cette taille en fonction de la mémoire disponible
    }
}
