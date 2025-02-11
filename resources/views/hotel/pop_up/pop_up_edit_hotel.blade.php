<div class="modal fade" id="edit_hotel-{{$id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel2">Hotel Code {{$hotel_code}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>

      
        <form action="{{ route('hotel.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" />
        <div class="modal-body">
           
            <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group col-sm-auto">
                            <label>Hotel Name</label>
                            <input  type="text" class="form-control" name="hotel_name" value="{{ $hotel_name }}" title="{{ $hotel_name }}" placeholder="hotelName">
                            
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <label>Hotel code</label>
                        <input  type="text" class="form-control" name="hotel_code" value="{{ $hotel_code }}" title="{{ $hotel_code }}" placeholder="hotel code">
    
                 
                    </div>
                   
            </div> 
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group col-sm-auto">
                        <label>provider</label>
                        {{-- <input  type="text" class="form-control" name="provider" value="{{ $provider }}" title="{{ $provider }}" placeholder="provider"> --}}
                        <select  class="form-control " id="provider_update" name="provider"  >
                            <option  value="">Select Provider Name</option>
                            
                            <option  @if($provider=="Dida Travel") selected @endif  value="Dida Travel">Dida Travel </option>       
                            <option  @if($provider=="Smyrooms") selected @endif value="Smyrooms">Smyrooms</option>
                            <option   @if($provider=="HotelRunner CM") selected @endif value="HotelRunner CM"> HotelRunner CM</option>
                            <option   @if($provider=="Bedsconnect-Direct") selected @endif value="Bedsconnect-Direct"> Bedsconnect-Direct</option>
                            <option   @if($provider=="Spring Travel Services") selected @endif value="Spring Travel Services"> Spring Travel Services</option>
                            <option  @if($provider=="My Morocco") selected @endif  value="My Morocco"> My Morocco</option>
                            <option   @if($provider=="Roibos") selected @endif value="Roibos"> Roibos</option>
                            <option  @if($provider=="Smyrooms_RET") selected @endif value="Smyrooms_RET"> Smyrooms_RET</option>
                            <option  @if($provider=="CGE-Bedsconnect") selected @endif value="CGE-Bedsconnect"> CGE-Bedsconnect</option>
                            <option  @if($provider=="Illusions Online - ils") selected @endif value="Illusions Online - ils"> Illusions Online - ils</option>
                                        
                            
                        </select>
                 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group col-sm-auto">
                        <label>provider_id</label>
                        {{-- <input  type="text" class="form-control" name="provider_id" value="{{ $provider_id }}" title="{{ $provider_id }}" placeholder="provider_id"> --}}
                        <select  class="form-control " id="provider_id_update" name="provider_id"  >
                            <option  value="">Select Provider ID</option>
                            
                            <option  @if($provider_id=="roibos") selected @endif value="roibos">roibos </option>       
                            <option  @if($provider_id=="iol_iwtx") selected @endif value="iol_iwtx">iol_iwtx</option>
                            <option  @if($provider_id=="didatravel") selected @endif value="didatravel"> didatravel</option>
                            <option  @if($provider_id=="logitravel_dr") selected @endif value="logitravel_dr"> logitravel_dr</option>
                            <option  @if($provider_id=="bedsconnect") selected @endif value="bedsconnect"> bedsconnect</option>
                            <option  @if($provider_id=="iol_x3") selected @endif value="iol_x3"> iol_x3</option>
                        
                            
                            
                        </select>
                      
                    </div>
                </div>
            <div id="notif"></div>
            </div>
            <hr> 
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group col-sm-auto">
                        <label>bdc_id</label>
                        <input  type="text" class="form-control" name="bdc_id" value="{{ $bdc_id }}" title="{{ $bdc_id }}" placeholder="bdc_id">
    
                    </div>
                    <div class="form-group col-sm-auto">
                        <label>country</label>
                        <input  type="text" class="form-control" name="country" value="{{ $country }}" title="{{ $country }}" placeholder="country">
    
                    </div>

                    <div class="form-group col-sm-auto">
                        <label>city</label>
                        <input  type="text" class="form-control" name="city" value="{{ $city }}" title="{{ $city }}" placeholder="city">
    
                    </div>
                </div>
                <div class="col-sm-6">

                    <div class="form-group col-sm-auto">
                        <label>Giata Id</label>
                        <input  type="text" class="form-control" name="giataId" value="{{ $giataId }}" title="{{ $giataId }}" placeholder="giataId">
    
                    </div>
                    <div class="form-group col-sm-auto">
                        <label>country_code</label>
                        <input  type="text" class="form-control" name="country_code" value="{{ $country_code }}" title="{{ $country_code }}" placeholder="country_code">
    
                    </div>

                    <div class="form-group col-sm-auto">
                        <label>CityCode</label>
                        <input  type="text" class="form-control" name="CityCode" value="{{ $CityCode }}" title="{{ $CityCode }}" placeholder="CityCode">
            
                    </div>
                </div>
              <div id="notif"></div>
           </div>
           <hr>

           <div class="row">
            <div class="col-sm-6">
                <div class="form-group col-sm-auto">
                    <label>addresses</label>
                    <input  type="text" class="form-control" name="addresses" value="{{ $addresses }}" title="{{ $addresses }}" placeholder="addresses">

                </div>
                <div class="form-group col-sm-auto">
                    <label>phones_voice</label>
                    <input  type="text" class="form-control" name="phones_voice" value="{{ $phones_voice }}" title="{{ $phones_voice }}" placeholder="phones_voice">

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group col-sm-auto">
                    <label>phones_fax</label>
                    <input  type="text" class="form-control" name="phones_fax" value="{{ $phones_fax }}" title="{{ $phones_fax }}" placeholder="phones_fax">

                </div>
                <div class="form-group col-sm-auto">
                    <label>email</label>
                    <input  type="text" class="form-control" name="email" value="{{ $email }}" title="{{ $email }}" placeholder="email">

                </div>
            </div>
          <div id="notif"></div>
       </div>
       <hr>

       <div class="row">
        <div class="col-sm-6">
            <div class="form-group col-sm-auto">
                <label>latitude</label>
                <input  type="text" class="form-control" name="latitude" value="{{ $latitude }}" title="{{ $latitude }}" placeholder="latitude">

            </div>
            <div class="form-group col-sm-auto">
                <label>longitude</label>_
                <input  type="text" class="form-control" name="longitude" value="{{ $longitude }}" title="{{ $longitude }}" placeholder="longitude">

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group col-sm-auto">
                <label>chainId</label>
                <input  type="text" class="form-control" name="chainId" value="{{ $chainId }}" title="{{ $chainId }}" placeholder="chainId">

            </div>
            <div class="form-group col-sm-auto">
                <label>chainName</label>
                <input  type="text" class="form-control" name="chainName" value="{{ $chainName }}" title="{{ $chainName }}" placeholder="chainName">

            </div>
        </div>
      <div id="notif"></div>
   </div>
   <hr>

   <div class="row">
    <div class="col-sm-6">
        <div class="form-group col-sm-auto">
            <label>zip_code</label>
            <input  type="text" class="form-control" name="zip_code" value="{{ $zip_code }}" title="{{ $zip_code }}" placeholder="zip_code">

        </div>
        <div class="form-group col-sm-auto">
            <label>CategoryCode</label>
            <input  type="text" class="form-control" name="CategoryCode" value="{{ $CategoryCode }}" title="{{ $CategoryCode }}" placeholder="CategoryCode">

        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group col-sm-auto">
            <label>CategoryName</label>
            <input  type="text" class="form-control" name="CategoryName" value="{{ $CategoryName }}" title="{{ $CategoryName }}" placeholder="CategoryName">

        </div>

    </div>

  <div id="notif"></div>
</div>
<hr>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group col-sm-auto">
            <label>With Giata ID</label>
            <select  class="form-control " id="with_giata" name="with_giata"  >
                <option  value="">Select with_giata</option>
                
                <option  @if($with_giata==0) selected @endif  value="0">mapping with provider id</option>       
                <option  @if($with_giata==1) selected @endif  value="1">mapping with giata id</option>

            </select>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="form-group col-sm-auto">
            <label>Etat</label>
            <select  class="form-control " id="etat" name="etat"  >
                <option  value="">Select Etat</option>
                
                <option  @if($etat==0) selected @endif  value="0">not mapped </option>       
                <option  @if($etat==1) selected @endif  value="1"> already mapped</option>
                <option  @if($etat==-1) selected @endif  value="-1">not exsiste for mapped</option>

            </select>

        </div>

    </div>
</div>

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success" id="copy">Enregistre</button>

            </div>
            
        </div>
    </form>
    </div>
</div>
</div>
