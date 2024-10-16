@extends('layouts.app')

@section('content')
    {{-- <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER --> --}}
    <div class="pull-right widget-content widget-content-area br-6 ">

        <div class="row">
            <button id="fetchDataButton_geo" class="btn btn-success" disabled >Récupérer les données Géo</button>

            {{-- <div id="dataContainer" style="margin-top: 20px;">
                <!-- Les données API seront affichées ici -->
            </div> --}}
            <div id="message" style="margin-top: 20px;">
                <!-- Le message sera affiché ici -->
            </div>
        </div>

    </div>

    @if (session('status') == 'success')
    <div class="alert alert-success">
    {{ session() ->get('status') }}
    </div>
@endif

@if (session('status') == 'error')
    <div class="alert alert-danger">
        {{ session('errors')->first() }}
    </div>
@endif

    <hr>
    <div class="widget-content widget-content-area br-6 text-center">
        <div class="panel-body"     display:inline-block > 
            <div class="row">

                            
                <div class="col-md-6">
                    <div class="form-group" >
                        <label  for="start_date" class="control-label col-sm-auto" >Start Date:</label>
                        <input id="rangeCalendarFlatpickr"  name="rangeCalendarFlatpickr" @if(isset($filter['rangeCalendarFlatpickr '] )) value="{{ $filter['rangeCalendarFlatpickr '] }}" @endif class="form-control flatpickr flatpickr-input" type="text" placeholder="Select Date..">
                        {{-- <label  for="start_date" class="control-label col-sm-auto" >Start Date: </label>
                        <div class="col-sm-auto" >
                            <input type="date" class="form-control" id="start_date" name="start_date" />
                            @error('start_date') <p class="text-danger">{{ $message }}</p> @enderror
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                {{-- {{ $filter['hotel']}} --}}

                
                <div class="form-group">
                    <label for="service_category" class="control-label col-sm-auto">Code: <span style="color: red" id="code_message"></span></label>
                        <div class="col-sm-auto">
                            <input onchange="check_code();" class="form-control basic" 
                            value=""  id="Code" name="Code"  />
                                
                                
                            </select>
                        @error('Code') <p class="text-danger">{{ $message }}</p> @enderror

                    </div>
                    </div>
                </div>
            

            
                <div class="col-md-6">
                {{-- {{ $filter['hotel']}} --}}
                <div class="form-group">
                    <label for="service_category" class="control-label col-sm-auto">Type Code: <span style="color: red" id="Type_message"></span></label>
                        <div class="col-sm-auto">
                            <select onchange="check_code();" class="form-control basic" id="Type_code" name="Type_code"  >
                                <option  value="">Select Type</option>
                                
                    <option   value="tgx">BOOKING_ID</option>
                    
                    <option    value="provider">BDC_ID</option>
                
                    <option   value="client"> Agency_ID</option>
                                
                            </select>
                        @error('Type_code') <p class="text-danger">{{ $message }}</p> @enderror

                    </div>
                    </div>
                </div>
            
            </div>

            <button type="submit"  class="btn btn-outline-success mb-2">Apply</button>
            <button type="button" onclick="vide();" class="btn btn-outline-secondary mb-2">Clear</button>
        </div>
    </div>
   


        <!--  BEGIN CONTENT AREA  -->
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3>Country LIST</h3>
                    </div>
                </div>
                @if (session()->has('success'))
                <div style="    background: transparent;" class="alert alert-light-success border-0 mb-4" role="alert"> 
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert">
                     <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                 </button>  {{ session() ->get('success') }} 
                 </div>
 
             @endif
                
                <div class="row" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                      
                                        <th>Country Code</th>
                                        <th>Country Name</th>
                                        <th>Destination Id</th>
                                        <th>Destination Name</th>
                                        <th>City Id</th>
                                        <th>City Name</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($hotels as $value)
                                    <tr>
                                       
                                        <td>{{ $value->countryCode }}</td>
                                        <td>{{ $value->countryName }}</td>
                                                                                
                                        <td>{{ $value->destinationId }}</td>   
                                        <td>{{ $value->destinationName }}</td>   

                                        <td>{{ $value->cityId }}</td>                                     
                                        <td>{{ $value->cityName }}</td>
        
                                        
                                      
                            
                                     
                                     
                                         
                                    </tr>
                                    @endforeach
         
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
     
        <!--  END CONTENT AREA  -->
 
    
    



@endsection