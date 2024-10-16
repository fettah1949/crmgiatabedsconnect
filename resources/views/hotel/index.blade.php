@extends('layouts.app')

@section('content')
    {{-- <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER --> --}}
    <div class="pull-right widget-content widget-content-area br-6 ">
        <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-outline-primary btn-rounded mb-2" href="{{ route('hotellist.create') }}"> New Hotel</a>
                     </div>
                     <div class="col-md-6">
                        <form method="post" action="{{ route('import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Fichier d'import</label>
                                <input type="file" name="csv_file" id="csv_file" class="form-control-file btn btn-outline-primary btn-rounded mb-2">
                                <button type="submit" class="btn btn-success">Importer CSV</button>
                            </div>
                            
                        </form>
                         <a href="{{ route('export') }}" class="btn btn-primary">Exporter CSV</a>
                    </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-4">
                    <button id="fetchDataButton" class="btn btn-success" >Récupérer les données GIATA</button>
                    </div>
                    {{-- <div class="col-md-3">
                        <select name="provider" id="provider" class="form-control" required>
                        <option value="">select provider</option>
                        <option value="didatravel">Dida Travel</option>
                        <option value="roibos">Roibos</option>
                        <option value="logitravel_dr">Smyrooms</option>
                        <option value="iol_iwtx">Illusions</option>
                        <option value="Bedsconnect">Bedsconnect</option>
                        </select>
                    </div> --}}
              </div>
            </div>
             <div class="col-md-5">
           
        </div>
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
                <div class="col-md-6">
                    <div class="form-group" >
                        <label  for="county" class="control-label col-sm-auto" >country:</label>
                        <select class="selectpicker" multiple>
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>
                    @error('Type_code') <p class="text-danger">{{ $message }}</p> @enderror
                 
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
                        <h3>HOTEL LIST</h3>
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
                                      
                                        <th>hotel_name</th>
                                        <th>hotel_code</th>
                                        <th>giataId</th>
                                        <th>city</th>
                                        <th>country</th>
                                        <th>addresses</th>
                                        <th>phones</th>
                                        <th>fax</th>
                                        <th>latitude</th>
                                        <th>longitude</th>
                                        <th>chainId</th>
                                        <th>chainName</th>
                                        <th class=" dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($hotels as $value)
                                    <tr>
                                       
                                        <td>{{ $value->hotel_name }}</td>
                                        <td>{{ $value->hotel_code }}</td>
                                                                                
                                        <td>{{ $value->giataId }}</td>   
                                        <td>{{ $value->city }}</td>                                                                   
                                        <td>{{ $value->country }}</td>
                                        
                                        <td>{{ $value->addresses }}</td>
                                        <td>{{ $value->phones_voice }}</td>
                                        <td>{{ $value->phones_fax }}</td>
                                        <td>{{ $value->latitude }}</td>
                                        <td>{{ $value->longitude }}</td>
                                        <td>{{ $value->chainId }}</td>
                                        <td>{{ $value->chainName }}</td>
                                        
                                      
                            
                                        <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-sm">Open</button>
                                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                    </div>
                                        </td>
                                     
                                         
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