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
              
                    </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-4">
                    <button id="fetchDataButton" class="btn btn-success" >Récupérer les données GIATA</button>

                    <!-- Indicateur de chargement -->
                    <div id="loadingSpinner" style="display:none;">
                        <img src="{{asset('assets\img\Fading balls.gif')}}" alt="Chargement..." />
                        <p>Chargement des données...</p>
                    </div>

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

                <form  id="fs" action="{{ route('hotelListe.search') }}" method="PUT">
                    <div class="row">

                                    
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label  for="start_date" class="control-label col-sm-auto" >Code Hotel</label>
                                <input id="code_hotel"  name="code_hotel" @if(isset($filter['code_hotel']) ) value="{{ $filter['code_hotel'] }}" @endif class="form-control" type="text" placeholder="Code Hotel">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label  for="county" class="control-label col-sm-auto" >country:</label>
                                <select class="form-control tagging" id="country"  name="country[]"   multiple="multiple">

                                </select>
                            @error('Type_code') <p class="text-danger">{{ $message }}</p> @enderror
                        
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        {{-- {{ $filter['hotel']}} --}}

                        
                        <div class="form-group">
                            <label for="service_category" class="control-label col-sm-auto">Provider Name: </label>
                                <div class="col-sm-auto">
                                    <select  class="form-control basic" id="provider_name" name="provider_name"  >
                                        <option  value="">Select Provider Name</option>
                                        
                                        <option  @if($filter['provider_name']=="Dida Travel") selected @endif  value="Dida Travel">Dida Travel </option>       
                                        <option  @if($filter['provider_name']=="Smyrooms") selected @endif  value="Smyrooms">Smyrooms</option>
                                        <option  @if($filter['provider_name']=="HotelRunner CM") selected @endif value="HotelRunner CM"> HotelRunner CM</option>
                                        <option  @if($filter['provider_name']=="Bedsconnect-Direct") selected @endif value="Bedsconnect-Direct"> Bedsconnect-Direct</option>
                                        <option  @if($filter['provider_name']=="Spring Travel Services") selected @endif value="Spring Travel Services"> Spring Travel Services</option>
                                        <option  @if($filter['provider_name']=="My Morocco") selected @endif value="My Morocco"> My Morocco</option>
                                        <option  @if($filter['provider_name']=="Roibos") selected @endif value="Roibos"> Roibos</option>
                                        
                                    </select>
                                @error('Code') <p class="text-danger">{{ $message }}</p> @enderror

                                </div>
                                </div>
                        
                        </div>
                    

                    
                        <div class="col-md-6">
                        {{-- {{ $filter['hotel']}} --}}
                        <div class="form-group">
                            <label for="service_category" class="control-label col-sm-auto">Provider ID</label>
                                <div class="col-sm-auto">
                                    <select  class="form-control basic" id="provider_id" name="provider_id"  >
                                        <option  value="">Select Provider ID</option>
                                        
                                        <option  @if($filter['provider_id']=="roibos") selected @endif value="roibos">roibos </option>       
                                        <option  @if($filter['provider_id']=="Illusion_iol") selected @endif value="Illusion_iol">Illusion_iol</option>
                                        <option  @if($filter['provider_id']=="didatravel") selected @endif value="didatravel"> didatravel</option>
                                        <option  @if($filter['provider_id']=="logitravel_dr") selected @endif value="logitravel_dr"> logitravel_dr</option>
                                        <option  @if($filter['provider_id']=="bedsconnect") selected @endif value="bedsconnect"> bedsconnect</option>
                                    
                                        
                                        
                                    </select>
                                @error('Type_code') <p class="text-danger">{{ $message }}</p> @enderror

                            </div>
                            </div>
                        </div>
                    
                    </div>

                    <button type="submit"  class="btn btn-outline-success mb-2">Apply</button>
                    <button type="button" onclick="vide();" class="btn btn-outline-secondary mb-2">Clear</button>
                </form>
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
                                      
                                        <th>Hotel name</th>
                                        <th>Hotel code</th>
                                        <th>BDC ID </th>
                                        <th>GiataId</th>
                                        <th>Provider</th>
                                        <th>City</th>
                                        <th>Country</th>
                                        <th>Addresses</th>
                                        <th>Phones</th>
                                      
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                    
                                        <th>ChainName</th>
                                        <th class=" dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($hotels as $value)
                                    <tr>
                                       
                                        <td>{{ $value->hotel_name }}</td>
                                        <td>{{ $value->hotel_code }}</td>
                                        <td>{{ $value->bdc_id }}</td>
                                                                                
                                        <td>{{ $value->giataId }}</td>   
                                        <td>{{ $value->provider }}</td>   
                                        <td>{{ $value->city }}</td>                                                                   
                                        <td>{{ $value->country }}</td>
                                        
                                        <td>{{ $value->addresses }}</td>
                                        <td>{{ $value->phones_voice }}</td>
                                        
                                        <td>{{ $value->latitude }}</td>
                                        <td>{{ $value->longitude }}</td>
                                       
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