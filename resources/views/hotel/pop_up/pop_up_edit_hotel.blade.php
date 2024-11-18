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
                        <input  type="text" class="form-control" name="provider" value="{{ $provider }}" title="{{ $provider }}" placeholder="provider">
    
                 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group col-sm-auto">
                        <label>provider_id</label>
                        <input  type="text" class="form-control" name="provider_id" value="{{ $provider_id }}" title="{{ $provider_id }}" placeholder="provider_id">
    
                      
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

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success" id="copy">Enregistre</button>

            </div>
            
        </div>
    </form>
    </div>
</div>
</div>
