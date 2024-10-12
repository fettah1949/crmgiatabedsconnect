@php

use App\Models\Country;
$countries = Country::all();


use App\Models\Agencycontact;
$sellers = Agencycontact::where('Contact_Type','SELLER')->get();

    $category_name = 'production';
    $page_name = 'hotel_list';
    $has_scrollspy = 0;
    $scrollspy_offset = '';

@endphp

@extends('layouts.app')
   
@section('content')

<br>

<nav class="breadcrumb-two" aria-label="breadcrumb">
    <ol style="background: none" class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('hotellist.index') }}">Hotel List</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Edit Hotel: {{ $hotellist->Hotel_Name }}</a></li>
    </ol>
</nav>
 
<hr>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 
        
    <form action="{{ route('hotellist.update',$hotellist->id) }}" method="POST" >
        @csrf
        @method('PUT')
        
        <div class="row">

        <div class="form-group col-sm-auto">
            <label>Hotel Code</label>
            <input disabled type="text" class="form-control"  placeholder="Hotel Code" name="Hotel_Code" value="{{ $hotellist->Hotel_Code }}">
            @error('Hotel_Code') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        
            <div class="form-group col-sm-auto">
                <label>bdc_id</label>
                <input type="text" class="form-control"  name="bdc_id" value="{{ $hotellist->bdc_id }}" placeholder="bdc_id">
                @error('bdc_id') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        
    
        <div class="form-group col-sm-auto">
            <label>Giata id</label>
            <input type="text" class="form-control"  name="Giata_id" value="{{ $hotellist->Giata_id }}" placeholder="Giata id">
            @error('Giata_id') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group col-sm-auto">
            <label>Seller id</label>
            <input type="text" class="form-control"  name="provider_id" value="{{ $hotellist->provider_id }}" placeholder="Seller id">
            @error('provider_id') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>

    </div>
    {{-- end row --}}
    <hr>


    <div class="row">
        <div class="form-group col-sm-auto">
            <label>Hotel Name</label>
            <input type="text" class="form-control"  name="Hotel_Name" value="{{ $hotellist->Hotel_Name }}" placeholder="Hotel Name">
            @error('Hotel_Name') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    
        <div class="form-group col-sm-auto">
            <label>Latitude</label>
            <input type="text" class="form-control"  name="Latitude" value="{{ $hotellist->Latitude }}" placeholder="Latitude">
            @error('Latitude') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    
        <div class="form-group col-sm-auto">
            <label>Longitude</label>
            <input type="text" class="form-control"  name="Longitude" value="{{ $hotellist->Longitude }}" placeholder="Longitude">
            @error('Longitude') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    
        <div class="form-group col-sm-auto">
            <label>Address</label>
            <input type="text" class="form-control"  name="Address" value="{{ $hotellist->Address }}" placeholder="Address">
            @error('Address') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    </div>
    {{-- end row --}}
    <hr>


    <div class="row">
        <div class="form-group col-sm-auto">
            <label>City</label>
            <input type="text" class="form-control"  name="City" value="{{ $hotellist->City }}" placeholder="City">
            @error('City') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    
        <div class="form-group col-sm-auto">
            <label>Zip Code</label>
            <input type="text" class="form-control"  name="Zip_Code" value="{{ $hotellist->Zip_Code }}" placeholder="Zip Code">
            @error('Zip_Code') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    
        <div class="form-group col-sm-auto">
            <label>Email</label>
            <input type="text" class="form-control"  name="Email" value="{{ $hotellist->Email }}" placeholder="Email">
            @error('Email') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    
        <div class="form-group col-sm-auto">
            <label>Country</label>
                <input class="form-control" id="Country" placeholder="Select Country"  value="{{ $hotellist->Country }}" name="Country" type="text" list="select-contry" onchange='setCountryCode();'>
                <datalist id="select-contry">
                <option value="">Select Country</option>
                 @foreach ($countries as $country)
                     <input type=hidden  id="{{ $country->nom_en_gb }}" value="{{ $country->alpha2 }}" />
                     <option value="{{ $country->nom_en_gb }}">{{ $country->nom_en_gb }}</option>
                 @endforeach
                </datalist>
            @error('Country') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    </div>
    {{-- end row --}}
    <hr>


    <div class="row">
        
                <div class="form-group col-sm-auto">
                    <label>Country Code</label>
                    <input type="text" class="form-control" id="Country_Code"  value="{{ $hotellist->Country_Code }}"  name="Country_Code" placeholder="Country Code">
                    @error('Country_Code') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
        
                <div class="form-group col-sm-auto">
                    <label>Seller</label>
                        <input class="form-control" placeholder="Select Seller" name="provider" type="text" list="select-seller"  value="{{ $hotellist->provider }}" >
                        <datalist id="select-seller">
                        <option value="">Select Seller</option>
                         @foreach ($sellers as $seller)
                             <option value="{{ $seller->Agency_Name }}">{{ $seller->Agency_Name }}</option>
                         @endforeach
                        </datalist>
                    @error('provider') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
    
    </div>    
    {{-- end row --}}
    <hr>

    

        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-outline-success mb-2">Update</button>
            <a style="margin-left: 10px" href="{{ route('hotellist.index') }}" class="btn btn-outline-dark mb-2">Cancel</a>
          </div>
 
      </form>
      <hr>
<script>
     
        function setCountryCode(){
            var c_code = document.getElementById("Country").value;
        document.getElementById("Country_Code").value = document.getElementById(c_code).value ;      
        }
</script>
@endsection


{{-- mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm --}}