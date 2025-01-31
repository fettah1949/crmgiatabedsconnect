@extends('layouts.app')
@php
    $category_name = 'production';
    $page_name = 'hotel_list';
    $has_scrollspy = 0;
    $scrollspy_offset = '';
@endphp 
@section('content')
    {{-- <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER --> --}}
    <div class="pull-right widget-content widget-content-area br-6 ">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-outline-primary btn-rounded mb-2" href="{{ route('hotellist.create') }}">New Hotel</a>
                <h3>Nombre Hotel Total: {{ $hotels_count }} </h3>
            </div>
            <div class="col-md-6">
                <form method="post" action="{{ route('import') }}" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="form-group">
                        <label for="file">Fichier d'import</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control-file btn btn-outline-primary btn-rounded mb-2" required>
                        <button type="submit" class="btn btn-success">Importer CSV</button>
                    </div>
                </form>
            
                <!-- Status Modal -->
                <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusModalLabel">Statut de l'importation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="statusMessage">En attente de l'importation...</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            
        </div>
        
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <button id="fetchDataButton" class="btn btn-success" >Récupérer les données GIATA</button>
                        <button id="fetchDataButton_check" class="btn  mb-2 mr-2 rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></button>

        

                        <!-- Indicateur de chargement -->
                        <div id="loadingSpinner" style="display:none;">
                            <img src="{{asset('assets\img\Fading balls.gif')}}" alt="Chargement..." />
                            <p>Chargement des données...</p>
                        </div>

                    </div>



                    

                    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel">Statut de Mise à Jour des Hôtels</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="statusMessage_giata">Mise à jour des données en cours...</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="update_Uinifer_StatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel">Statut de Mise à Jour des Hôtels</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="statusMessage_unifier">Mise à jour des données en cours...</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    
                    <div class="col-md-2">
                        <button id="unifierbdcDataButton" class="btn btn-success" >Unifier les codes BDC</button>
                        <button id="unifierbdcCheckDataButton" class="btn  mb-2 mr-2 rounded-circle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></button>


                        <!-- Indicateur de chargement -->
                        <div id="loadingSpinner_bdc" style="display:none;">
                            <img src="{{asset('assets\img\Fading balls.gif')}}" alt="Chargement..." />
                            <p>Chargement des données...</p>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <button id="giata_idDataButton" class="btn btn-success" >Récupérer les données GIATA Via GIATA ID</button>

                    </div> 
              </div>
            </div>
            <div class="col-md-1">
            </div>
            {{-- <div id="dataContainer" style="margin-top: 20px;">
                <!-- Les données API seront affichées ici -->
            </div> --}}
 
        </div>

        <div class="row">

            <div id="message" style="margin-top: 20px;">
                <div id="message_unifier" style="margin-top: 20px;">
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

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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
                                        <option  @if($filter['provider_name']=="Smyrooms_RET") selected @endif value="Smyrooms_RET"> Smyrooms_RET</option>
                                        <option  @if($filter['provider_name']=="CGE-Bedsconnect") selected @endif value="CGE-Bedsconnect"> CGE-Bedsconnect</option>
                                        
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
                    <div class="row">
                       
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label  for="start_date" class="control-label col-sm-auto" >Bdc id</label>
                                <input id="bdc_id"  name="bdc_id" @if(isset($filter['bdc_id']) ) value="{{ $filter['bdc_id'] }}" @endif class="form-control" type="text" placeholder="bdc id">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" >
                                <label  for="start_date" class="control-label col-sm-auto" >Code Hotel</label>
                                <input id="Name_hotel"  name="Name_hotel" @if(isset($filter['Name_hotel']) ) value="{{ $filter['Name_hotel'] }}" @endif class="form-control" type="text" placeholder="Name Hotel">

                            </div>
                        </div>

                    
                        
                    
                    </div>
                    <div class="row">
                       
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label  for="start_date" class="control-label col-sm-auto" >with Giata</label>
                                <select  class="form-control basic" id="giata_id" name="giata_id"  >
                                    <option  value="">All </option>
                                    
                                    <option  @if($filter['giata_id']==1) selected @endif value="1">Yes </option>       
                                    <option  @if($filter['giata_id']==0) selected @endif value="0">No</option>
                                    
                                    
                                    
                                </select>
                            </div>
                        </div>

                       

                    
                        
                    
                    </div>
                    

                    <button type="submit"  class="btn btn-outline-success mb-2">Apply</button>
                    <button type="button" onclick="vide();" class="btn btn-outline-secondary mb-2">Clear</button>


                    <!-- Bouton d'exportation -->
                    <button type="button" class="btn btn-outline-primary mb-2" onclick="exportHotels()">
                        Exporter
                    <!-- Animation de chargement (spinner) -->
                    <div id="loader" style="display: none;" class="d-flex align-items-center">
                        <p id="loadingMessage" class="mb-0 ms-2" style="display: none;">Exportation en cours...</p>
                        <div id="loadingSpinner" class="spinner-border ms-2" role="status" style="width: 24px; height: 24px; display: none;">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>

                    <!-- Bouton de téléchargement (affiché après exportation) -->
                    <a id="downloadButton" href="#" style="display: none;" class="btn btn-success mt-2">
                        Télécharger le fichier exporté
                    </a>



                    
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
                                        <th>email</th>
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
                                        <td>{{ $value->email }}</td>   
                                        <td>{{ $value->city }}</td>                                                                   
                                        <td>{{ $value->country_code }}</td>
                                        
                                        <td>{{ $value->addresses }}</td>
                                        <td>{{ $value->phones_voice }}</td>
                                        
                                        <td>{{ $value->latitude }}</td>
                                        <td>{{ $value->longitude }}</td>
                                       
                                        <td>{{ $value->chainName }}</td>
                                        
                                      
                            
                                        <td>
                                                <div class="btn-group">
                                                    <button type="button" data-toggle="modal" data-target="#edit_hotel-{{$value->id}}" target="_blank" class="btn btn-dark btn-sm">Update</button>
                                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                    </button>
                                                    {{-- <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div> --}}
                                                    </div>
                                        </td>
                                     
                                         
                                    </tr>



                                    @include('hotel.pop_up.pop_up_edit_hotel',[
                                                                                        'id'=>$value->id,
                                                                                        'hotel_name'=>$value->hotel_name,
                                                                                        'hotel_code'=>$value->hotel_code,
                                                                                        'bdc_id'=>$value->bdc_id,
                                                                                        'provider_id'=>$value->provider_id,
                                                                                        'giataId'=>$value->giataId,
                                                                                        
                                                                                        'provider'=>$value->provider,
                                                                                        'city'=>$value->city,
                                                                                        'country_code'=>$value->country_code,
                                                                                    
                                                                                        'addresses'=>$value->addresses,
                                                                                        'phones_voice'=>$value->phones_voice,
                                                                                        'latitude'=>$value->latitude,
                                                                                        'longitude'=>$value->longitude,
                                                                                        'chainName'=>$value->chainName,
                                                                                        'phones_fax'=>$value->phones_fax,
                                                                                        'email'=>$value->email,
                                                                                        'chainId'=>$value->chainId,
                                                                                        'zip_code'=>$value->zip_code,
                                                                                        'CategoryCode'=>$value->CategoryCode,
                                                                                        'CategoryName'=>$value->CategoryName,
                                                                                        'CityCode'=>$value->CityCode,
                                                                                        'country'=>$value->country,
                                                                                        'with_giata'=>$value->with_giata,
                                                                                        'etat'=>$value->etat,
                                                                                        
                                                                                        ])
                                    @endforeach
         
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
     
        <!--  END CONTENT AREA  -->
 
    
    



@endsection