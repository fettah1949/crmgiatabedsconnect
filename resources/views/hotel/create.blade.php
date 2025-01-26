@php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  

    $category_name = 'production';
    $page_name = 'hotel_list';
    $has_scrollspy = 0;
    $scrollspy_offset = '';
 
            $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
            while (DB::table('hotels')->where('bdc_id', $chiffre)->exists()) {
                $chiffre = 'BDCX' . str_pad(random_int(1, 99999999999), 11, '0', STR_PAD_LEFT);
            }
            
        

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
            <label for="hotel_name" class="form-label">Hotel Name</label>
            <input type="text" class="form-control" id="hotel_name" placeholder="Enter Hotel Name" name="hotel_name">
            @error('hotel_name') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="hotel_code" class="form-label">Hotel Code</label>
            <input type="text" class="form-control" id="hotel_code" placeholder="Enter Hotel Code" name="hotel_code">
            @error('Hotel_Code') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        
        <div class="col-md-6">
            <label for="bdcId" class="form-label">BDC ID</label>
            <input type="text" disabled class="form-control" id="bdc_id" placeholder="Enter BDC ID" name="bdc_id" value="{{$chiffre}}">
            <input type="hidden" name="bdc_id" value="{{ $chiffre }}">
            @error('bdc_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="giataId" class="form-label">Giata ID</label>
            <input type="text" class="form-control" id="giataId" placeholder="Enter Giata ID" name="giataId">
            @error('Giata_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="provider" class="form-label">provider</label>
            <input type="text" class="form-control" id="provider" placeholder="Enter provider" name="provider">
            @error('provider') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6">
            <label for="provider_id" class="form-label">provider_id</label>
            <input type="text" class="form-control" id="provider_id" placeholder="Enter provider_id" name="provider_id">
            @error('provider_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6">
            <label for="CategoryCode" class="form-label">CategoryCode</label>
            <input type="text" class="form-control" id="CategoryCode" placeholder="Enter CategoryCode" name="CategoryCode">
            @error('CategoryCode') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6">
            <label for="CategoryName" class="form-label">CategoryName</label>
            <input type="text" class="form-control" id="CategoryName" placeholder="Enter CategoryName" name="CategoryName">
            @error('CategoryName') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    

  
    <hr class="my-4">

    <!-- Section 2: Location Information -->
    <h4 class="mb-3">Location Information</h4>


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
        <div class="col-md-6">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" placeholder="Enter Latitude" name="Latitude">
            @error('Latitude') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="city" class="form-label">City</label>
            {{-- <input type="text" class="form-control" id="city" placeholder="Enter City" name="City"> --}}
            <select id="city" class="form-control">
                <option value="">Sélectionnez une ville</option>
            </select>
            
            @error('City') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="CityCode" class="form-label">CityCode</label>
            {{-- <input type="text" class="form-control" id="CityCode" placeholder="Enter CityCode" name="CityCode"> --}}
            <select  id="CityCode" placeholder="Enter CityCode" name="CityCode" class="form-control">
                <option value="">Sélectionnez une ville</option>
            </select>

            @error('CityCode') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label  for="county_code" class="control-label col-sm-auto" >county_code:</label>
            <select class="form-control tagging" id="country"  name="country"   >

            </select>
        @error('county_code') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    </div>

    <hr class="my-4">

    <!-- Section 3: Contact Information -->
    <h4 class="mb-3">Contact Information</h4>
    <div class="row mb-3">

  
        <div class="col-md-6">
            <label for="zipCode" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zipCode" placeholder="Enter Zip Code" name="Zip_Code">
            @error('Zip_Code') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="Email">
            @error('Email') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="row mb-3">


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
        <div class="col-md-6">
            <label for="chainName" class="form-label">With Giata Id</label>
            <select  class="form-control basic" id="with_giata" name="with_giata"  >
                <option  value="">Select with Gita Id</option>
                
                <option    value="0">mapping with provider id </option>       
                <option    value="1">mapping with giata id </option>

                
            </select>
        </div>      
        <div class="col-md-6">
            <label for="chainName" class="form-label">Etat mapping</label>
            <select  class="form-control basic" id="etat" name="etat"  >
                <option  value="">Select Etat</option>
                
                <option    value="0">not mapped </option>       
                <option    value="1">already mapped </option>

                
            </select>
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

