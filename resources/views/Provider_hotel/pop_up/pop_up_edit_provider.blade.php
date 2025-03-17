<div class="modal fade" id="edit_provider-{{$id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel2">provider name {{$provider_code}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>

      
        <form action="{{ route('provider.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" />
        <div class="modal-body">
           
            <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group col-sm-auto">
                            <label>Provider Name</label>
                            <input  type="text" class="form-control" name="provider_name" value="{{ $provider_name }}" title="{{ $provider_name }}" placeholder="providerName">
                            
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <label>provider code</label>
                        <input  type="text" class="form-control" name="provider_code" value="{{ $provider_code }}" title="{{ $provider_code }}" placeholder="provider code">
    
                 
                    </div>
                   
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
