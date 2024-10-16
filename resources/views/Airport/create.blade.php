@php
use App\Models\Country;
$countries = Country::all();

// use App\Models\Agencycontact;
// $sellers = Agencycontact::where('Contact_Type','SELLER')->get();
//dd($sellers);

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
        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Add New Hotel</a></li>
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
   
<form action="{{ route('hotellist.store') }}" method="POST" class="p-4 bg-light shadow rounded">
    @csrf
  
    <!-- Section 1: Hotel Details -->
    <h4 class="mb-3">Hotel Details</h4>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="hotelCode" class="form-label">Hotel Code</label>
            <input type="text" class="form-control" id="hotelCode" placeholder="Enter Hotel Code" name="Hotel_Code">
            @error('Hotel_Code') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        {{-- <div class="col-md-6">
            <label for="bdcId" class="form-label">BDC ID</label>
            <input type="text" class="form-control" id="bdcId" placeholder="Enter BDC ID" name="bdc_id">
            @error('bdc_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div> --}}
        <div class="col-md-6">
            <label for="giataId" class="form-label">Giata ID</label>
            <input type="text" class="form-control" id="giataId" placeholder="Enter Giata ID" name="giataId">
            @error('Giata_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    

  
    <hr class="my-4">

    <!-- Section 2: Location Information -->
    <h4 class="mb-3">Location Information</h4>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="hotelName" class="form-label">Hotel Name</label>
            <input type="text" class="form-control" id="hotelName" placeholder="Enter Hotel Name" name="Hotel_Name">
            @error('Hotel_Name') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" placeholder="Enter Latitude" name="Latitude">
            @error('Latitude') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" placeholder="Enter Longitude" name="Longitude">
            @error('Longitude') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="addresses" placeholder="Enter Address" name="addresses">
            @error('Address') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <hr class="my-4">

    <!-- Section 3: Contact Information -->
    <h4 class="mb-3">Contact Information</h4>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" placeholder="Enter City" name="City">
            @error('City') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="zipCode" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zipCode" placeholder="Enter Zip Code" name="Zip_Code">
            @error('Zip_Code') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="Email">
            @error('Email') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="country" class="form-label">Country</label>
            <input class="form-control" type="text" list="select-country" id="country" name="Country" placeholder="Select Country" onkeyup='setCountryCode();'>
            <datalist id="select-country">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <input type="hidden" id="{{ $country->nom_en_gb }}" value="{{ $country->alpha2 }}" />
                    <option value="{{ $country->nom_en_gb }}">{{ $country->nom_en_gb }}</option>
                @endforeach
            </datalist>
            @error('Country') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phones_voice" class="form-label">Phones Voice</label>
            <input type="text" class="form-control" id="phones_voice" placeholder="Enter Phones Voice" name="phones_voice">
            @error('Phones_voice') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="phones_fax" class="form-label">phones fax</label>
            <input type="text" class="form-control" id="phones_fax" placeholder="Enter Phones Fax" name="phones_fax">
            @error('Phones_fax') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="chainId" class="form-label">Chain Id</label>
            <input type="text" class="form-control" id="chainId" placeholder="Enter Chain Id" name="chainId">
            @error('ChainId') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="chainName" class="form-label">Chain Name</label>
            <input type="text" class="form-control" id="chainName" placeholder="Enter Chain Name" name="chainName">
            @error('ChainName') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

    <!-- Form Buttons -->
    <div class="text-center mt-4">
        <button type="submit" class="btn btn-success me-2">Save</button>
        <button type="reset" class="btn btn-danger">Clear</button>
    </div>
</form>

<script>
      function setCountryCode(){
            var c_code = document.getElementById("Country").value;
        document.getElementById("Country_Code").value = document.getElementById(c_code).value ;      
        }
</script>
@endsection

{{-- mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm --}}
