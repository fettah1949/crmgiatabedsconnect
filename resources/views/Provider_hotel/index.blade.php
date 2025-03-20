@extends('layouts.app')

@section('content')
    {{-- <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER --> --}}


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

   


        <!--  BEGIN CONTENT AREA  -->
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3>Hotel Provider LIST : {{$Provider_counts}}</h3>
                    </div>
                </div>

                <div class="row"  style="margin-bottom: 3%;">
                    <div class="col-md-2">
                        <button id="fetchDataButton_provider_code" class="btn btn-success" >Récupérer les données Provider Code</button>
                        <span id="statusMessage" style="margin-left: 10px; font-weight: bold;"></span>
                    

                        <div id="loadingSpinner" class="spinner-border ms-2" role="status" style="width: 24px; height: 24px; display: none;">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>

                  
                  
                    <div class="col-md-2">

                        <button id="checkJobStatusButton" class="btn btn-success" style="margin-left: 15px;">Vérifier le statut</button>
                        <span id="jobStatusMessage" style="margin-left: 10px; font-weight: bold;"></span>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 3%;">
                    <div class="col-md-3">

                            <input type="text"  class="form-control basic" id="giataIdInput" placeholder="Filtrer par Giata ID">

                    </div>
                    <div class="col-md-3">

                        <select  class="form-control basic" id="providerNameInput" name="providerNameInput"  >

                            <option  value="">Select Provider Name</option>
                            @foreach ($provider_lists as $provider_list)
                            <option value="{{$provider_list->provider_name}}">{{ $provider_list->provider_name }} </option>       

                            @endforeach
                            
                        
                        </select>
                    
                    </div>
                    <div class="col-md-2">

                        <button id="startExportButton" class="btn btn-success">Lancer l'exportation</button>
                        <span id="exportMessage" style="margin-left: 10px; font-weight: bold;"></span>
        
                        
        
                    </div>
                    <div class="col-md-3">

                      
                        <button id="checkExportButton" class="btn btn-success" style="margin-left: 15px;">Vérifier l'export</button>
                        <a id="downloadLink" style="display: none; margin-left: 10px;" download>Télécharger le fichier</a>
        
        
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
                                      
                                        <th>Hotel code</th>
                                        <th>GiataId</th>
                                        <th>Provider Name</th>
                                        <th>Provider Code</th>
                                        <th>Action</th>

                                       
                                       
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($Provider as $value)
                                    <tr>
                                       
                                        <td>{{ $value->hotel_code }}</td>
                                        <td>{{ $value->giataId }}</td>
                                        <td>{{ $value->provider_name }}</td>
                                        <td>{{ $value->provider_code }}</td>
                                                                                
                                

                                        
        
                                        
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" data-toggle="modal" data-target="#edit_provider-{{$value->id}}" target="_blank" class="btn btn-dark btn-sm">Update</button>
                                                <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                </button>
                                               
                                                </div>
                                    </td>
                            
                                     
                                     
                                         
                                    </tr>


                                    
             @include('Provider_hotel.pop_up.pop_up_edit_provider',['id'=>$value->id,'provider_name'=>$value->provider_name,'provider_code'=>$value->provider_code])
                                    @endforeach
         
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
     

    
    



@endsection