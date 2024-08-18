    <script src="{{asset('assets/js/loader.js')}}"></script>
    
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
                "pageLength": 7 
            } );
        </script>
                <script>
                    $(document).ready(function() {
                        $('#fetchDataButton').on('click', function() {
                            console.log('1');
                            $.ajax({
                                url: "{{ route('giata.property') }}",
                                type: 'GET',
                                success: function(response) {
                                    // $('#dataContainer').html('<pre>' + JSON.stringify(response.data, null, 4) + '</pre>');
                                    var countMessage = '  Nombre d\'hôtels trouvés : ' + response.count;
                                    $('#message').text(countMessage);
                                },
                                error: function(xhr, status, error) {
                                    $('#dataContainer').html('<p>Erreur lors de la récupération des données : ' + error + '</p>');
                                }
                            });
                        });
                    });
                </script>
        <!-- END PAGE LEVEL CUSTOM SCRIPTS -->