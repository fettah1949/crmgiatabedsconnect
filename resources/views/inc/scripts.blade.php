    <script src="{{asset('assets/js/loader.js')}}"></script>
    
 <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

 


 <script src="{{asset('plugins/highlight/highlight.pack.js')}}"></script>

 <!-- END GLOBAL MANDATORY SCRIPTS -->   


    <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="{{asset('assets/js/scrollspyNav.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('assets/js/ie11fix/fn.fix-padStart.js')}}"></script>
    <script src="{{asset('plugins/editors/quill/quill.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
    <script src="{{asset('assets/js/apps/custom-mailbox.js')}}"></script>
    {{-- <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
--}}
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/dashboard/dash_1.js')}}"></script>
    <script src="{{asset('assets/js/dashboard/dash_2.js')}}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 



    
        <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
        <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
        <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
        <script src="{{asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/button-ext/jszip.min.js')}}"></script>    
        <script src="{{asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
        <script>
            $('#html5-extension').DataTable( {
                "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn btn-sm' },
                        { extend: 'csv', className: 'btn btn-sm' },
                        { extend: 'excel', className: 'btn btn-sm' },
                        { extend: 'print', className: 'btn btn-sm' }
                    ]
                },
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                   "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 50
            } );
        </script>
                <script>
                    $(document).ready(function() {
                        $('#fetchDataButton').on('click', function() {
                   
                            var provider = $('#provider').val();

                            // Afficher le spinner avant d'envoyer la requête
                             $('#loadingSpinner').show();

                            $.ajax({
                                url: "{{ route('giata.property') }}",
                                type: 'GET',
                                data: {
                                    _token: '{{ csrf_token() }}',  // Include the CSRF token
                                     // Include the CSRF token
                                },
                                success: function(response) {
                                    // console.log(response);
                                    $('#loadingSpinner').hide();
                                    // $('#dataContainer').html('<pre>' + JSON.stringify(response.data, null, 4) + '</pre>');
                                    var countMessage = '  Nombre d\'hôtels trouvés : ' + response.count;
                                    // var countMessage = '  Nombre d\'hôtels trouvés : ' + response;
                                    // alert(response.count);
                                    $('#message').text(countMessage);
                                },
                                error: function(xhr, status, error) {
                                    $('#loadingSpinner').hide();
                                    $('#dataContainer').html('<p>Erreur lors de la récupération des données : ' + error + '</p>');
                                }
                            });
                        });
                    });

                    $(document).ready(function() {
                        $('#unifierbdcDataButton').on('click', function() {
                   
                          

                            // Afficher le spinner avant d'envoyer la requête
                             $('#loadingSpinner_bdc').show();

                            $.ajax({
                                url: "{{ route('giata.unifier_bdc') }}",
                                type: 'GET',
                                data: {
                                    _token: '{{ csrf_token() }}',  // Include the CSRF token
                                     // Include the CSRF token
                                },
                                success: function(response) {
                                    // console.log(response);
                                    $('#loadingSpinner_bdc').hide();
                                    // $('#dataContainer').html('<pre>' + JSON.stringify(response.data, null, 4) + '</pre>');
                                    // var countMessage = '  Nombre d\'hôtels trouvés : ' + response.count;
                                     var countMessage =  response;
                                    // alert(response.count);
                                     $('#message_unifier').text(countMessage);
                                },
                                error: function(xhr, status, error) {
                                    $('#loadingSpinner_bdc').hide();
                                    $('#dataContainer').html('<p>Erreur lors de la récupération des données : ' + error + '</p>');
                                }
                            });
                        });
                    });

                    $(document).ready(function() {
                        $('#fetchDataButton_geo').on('click', function() {
                           
                            $.ajax({
                                url: "{{ route('geo.property') }}",
                                type: 'GET',
                                success: function(response) {
                                    // console.log('2');
                                    // console.log(response);
    
                                },
                                error: function(xhr, status, error) {
                                    $('#dataContainer').html('<p>Erreur lors de la récupération des données : ' + error + '</p>');
                                }
                            });
                        });
                    });
                    $(document).ready(function() {
                        $('#fetchDataButton_airport').on('click', function() {
                            console.log('1');
                            $.ajax({
                                url: "{{ route('Airport.property') }}",
                                type: 'GET',
                                success: function(response) {
                                    // console.log('2');
                                    // console.log(response);
    
                                },
                                error: function(xhr, status, error) {
                                    $('#dataContainer').html('<p>Erreur lors de la récupération des données : ' + error + '</p>');
                                }
                            });
                        });
                    });

                    // $(".tagging").select2({
                    //     tags: true
                    // });


                  
                    // $(document).ready(function() {
                        
                    //         $('.tagging').select2({
                    //             tags: true
                    //         });
                        
                    // });

                    
                    $(document).ready(function() {

                        var selectedCountries = @json($filter['country'] ?? []);

                        
                        $('.tagging').select2({
                            tags: true,
                            ajax: {
                                url: "{{ route('api.countries') }}", // Appelle l'URL Laravel
                                dataType: 'json',
                                delay: 250, // Délai avant de déclencher la requête pour éviter trop de requêtes
                                data: function(params) {
                                    return {
                                        q: params.term // Le terme tapé par l'utilisateur
                                    };
                                },
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return {
                                                id: item.countryCode, // ID du pays
                                                text: item.countryCode // Nom du pays
                                            };
                                        })
                                    };
                                },
                                cache: true
                            },
                            minimumInputLength: 1 // La requête AJAX démarre après avoir tapé au moins 1 lettre
                        });


                            // Pré-remplir les pays sélectionnés lors du chargement
                            if (selectedCountries.length > 0) {
                                var select2Data = [];
                                
                                selectedCountries.forEach(function(country) {
                                    select2Data.push({
                                        id: country,  // Code du pays (ou ID)
                                        text: country // Nom du pays affiché dans le select
                                    });
                                });

                                // Ajouter les valeurs sélectionnées dans Select2
                                var $countrySelect = $('#country');
                                select2Data.forEach(function(country) {
                                    // Créer une option pour chaque pays sélectionné
                                    var option = new Option(country.text, country.id, true, true);
                                    $countrySelect.append(option).trigger('change');
                                });

                                // Activer le composant Select2 après avoir ajouté les options
                                $countrySelect.trigger({
                                    type: 'select2:select',
                                    params: {
                                        data: select2Data
                                    }
                                });
                            }
                    });


                   
                        // document.addEventListener('DOMContentLoaded', function() {
                        //     @if(session('status'))
                        //         $('#statusModal').modal('show');
                        //     @endif
                        // });
          
                        
                        $(document).ready(function() {
                            $('#importForm').on('submit', function(e) {
                                e.preventDefault(); // Prevent the page from refreshing
                                $('#statusModal').modal('show'); // Show the status modal

                                // Prepare form data
                                var formData = new FormData(this);

                                $.ajax({
                                    url: $(this).attr('action'),
                                    type: 'POST',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        $('#statusMessage').text('Importation en cours...');
                                        checkImportStatus(response.file_name);
                                        $('#csv_file').val('');
                                    },
                                    error: function(xhr) {
                                        $('#statusMessage').text('Échec de l\'importation : ' + xhr.responseJSON.message);
                                    }
                                });

                                return false; // Ensure form submission is fully blocked
                            });
                        });

                    function checkImportStatus(fileName) {
                    console.log("Nom du fichier:", fileName);
                    const intervalId = setInterval(() => {
                        $.ajax({
                            url: "{{ route('importstatus') }}", 
                            data : {fileName : fileName  },
                            dataType: 'json', 
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                                $('#statusMessage').text(`Le statut d'importation pour le fichier ${response.file_name} est : ${response.status}`);

                                // Ajoutez l'animation si le statut est "pending"
                                if (response.status === 'pending') {
                                    $('#statusMessage').addClass('loading-animation'); // Ajoute l'animation
                                } else {
                                    $('#statusMessage').removeClass('loading-animation'); // Enlève l'animation
                                }

                                // Vérifiez si l'importation est terminée
                                if (response.status === 'completed' || response.status === 'failed') {
                                    clearInterval(intervalId); // Arrêter l'interrogation
                                    $('#statusMessage').removeClass('loading-animation'); // Assurez-vous de retirer l'animation
                                }
                            },
                            error: function(xhr) {
                                $('#statusMessage').text('Erreur lors de la récupération du statut.');
                                clearInterval(intervalId);
                            }
                        });
                    }, 5000);
                }

                function exportHotels() {
                      // Afficher l'animation de chargement
                    document.getElementById('loader').style.display = 'block';
                    // Récupérer les valeurs des champs
                    const codeHotel = document.getElementById('code_hotel').value || '';
                    const country = document.getElementById('country').value || '';
                    const providerName = document.getElementById('provider_name').value || '';
                    const providerID = document.getElementById('provider_id').value || '';
                    const bdc_id = document.getElementById('bdc_id').value || '';
                    const Name_hotel = document.getElementById('Name_hotel').value || '';
                    
                    // Construire l'URL avec les paramètres de recherche
                    const url = `{{ route('hotels.export') }}?codeHotel=${encodeURIComponent(codeHotel)}&country=${encodeURIComponent(country)}&providerName=${encodeURIComponent(providerName)}&providerID=${encodeURIComponent(providerID)}&bdc_id=${encodeURIComponent(bdc_id)}&Name_hotel=${encodeURIComponent(Name_hotel)}`;

                    // Effectuer la requête AJAX avec fetch
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.blob(); // Récupérer la réponse en tant que Blob
                        } else {
                            throw new Error('Erreur lors de l\'exportation.');
                        }
                    })
                    .then(blob => {
                        // Créer un lien de téléchargement pour le fichier
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'hotels_export.xlsx'; // Nom par défaut du fichier
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    })
                    .catch(error => {
                        console.error(error);
                        alert("Erreur lors de l'exportation des données.");
                    })
                    .finally(() => {
                    // Masquer l'animation de chargement
                    document.getElementById('loader').style.display = 'none';
                    });
                }

                </script>
        <!-- END PAGE LEVEL CUSTOM SCRIPTS -->