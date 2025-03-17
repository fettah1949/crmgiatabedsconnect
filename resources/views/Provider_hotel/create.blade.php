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
        <li class="breadcrumb-item active"><a href="{{ route('ProviderList.index') }}">PRovider List</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Add New Provider</a></li>
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
   
<form action="{{ route('ProviderList.store') }}" method="POST" class="p-4 bg-light shadow rounded">
    @csrf
  
    <!-- Section 1: Hotel Details -->
    <h4 class="mb-3">Provider Details</h4>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="providername" class="form-label">Provider Name</label>
            <input type="text" class="form-control" id="providername" placeholder="Enter Provider name" name="providername">
            @error('providername') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6">
            <label for="providercode" class="form-label">Provider Code</label>
            <input type="text" class="form-control" id="providercode" placeholder="Enter Provider code" name="providercode">
            @error('Giata_id') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
    

  
    <hr class="my-4">



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
