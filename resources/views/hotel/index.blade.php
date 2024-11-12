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
                <a class="btn btn-outline-primary btn-rounded mb-2" href="{{ route('hotellist.create') }}">New Hotel</a>
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
                    <div class="col-md-2">
                        <button id="fetchDataButton" class="btn btn-success" >Récupérer les données GIATA</button>
        

                        <!-- Indicateur de chargement -->
                        <div id="loadingSpinner" style="display:none;">
                            <img src="{{asset('assets\img\Fading balls.gif')}}" alt="Chargement..." />
                            <p>Chargement des données...</p>
                        </div>

                    </div>

                    <div class="col-md-2">
                        
                        <button id="fetchDataButton_check" class="btn btn-success" >check les données GIATA</button>


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
                                        <td>{{ $value->country_code }}</td>
                                        
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