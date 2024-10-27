<?php

namespace App\Exports;

use App\Models\Hotel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HotelsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */


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
    public function collection()
    {
        return $this->query();
    }
    


    public function query()
    {
        // $query = Hotel::query();
        $query = Hotel::select( 'hotel_name', 'hotel_code', 'bdc_id', 'giataid', 'provider', 'provider_id', 
                      'city', 'CityCode', 'country_code', 'addresses', 'zip_code', 'phones_voice', 
                      'latitude', 'longitude', 'chainName', 'status');


        if ($this->codeHotel) {
         
            $query->where('hotel_code',  $this->codeHotel );
        }
        if ($this->country) {
            $query->where('country_code', 'like', '%' . $this->country . '%');
        }
        if ($this->providerName) {
            $query->where('provider', 'like', '%' . $this->providerName . '%');
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
        

        return $query->get();
    }

    public function headings(): array       
    {
        return [
            'Hotel name', 'Code Hotel', 'BDC ID', 'GiataId', 'Provider', 'Provider_id', 'City', 'City_ID', 'Country_code', 'Addresses', 'Zip_code', 'Phones', 'Latitude', 'Longitude', 'ChainName', 'Statut'
        ];
    }
}
