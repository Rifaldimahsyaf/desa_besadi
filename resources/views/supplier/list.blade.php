@extends('sidebar')

@section('title')
    Supplier List
@endsection

@section('head')

    <style>
        #modal_profile .modal-body{
            word-break: break-all;
        }
    </style>

    <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
{{--    <script src="/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>--}}
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="/global_assets/js/plugins/forms/validation/validate.min.js"></script>
    <script src="/global_assets/js/plugins/forms/validation/additional_methods.min.js"></script>
    <script src="/global_assets/js/plugins/notifications/noty.min.js"></script>
    <script src="/global_assets/js/demo_pages/colors_success.js"></script>
    <script src="/global_assets/js/demo_pages/colors_danger.js"></script>

    <script type="text/javascript">
        var NotyJgrowl = function() {
            //
            // Setup module components
            //

            // Noty.js examples
            var _componentNoty = function() {
                if (typeof Noty == 'undefined') {
                    console.warn('Warning - noty.min.js is not loaded.');
                    return;
                }

                // Override Noty defaults
                Noty.overrideDefaults({
                    theme: 'limitless',
                    layout: 'topRight',
                    type: 'alert',
                    timeout: 2500
                });
            }

            return {
                init: function() {
                    _componentNoty();
                }
            }
        }();

        var DatatableCustomButtonWithSearch = function() {


            //
            // Setup module components
            //

            // Basic Datatable examples
            var _componentDatatableAPI = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend( $.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [
                        {
                            orderable: false,
                            width: 100,
                            targets: "no-sort"
                        },
                        {
                            width: 300,
                            targets: [ 0 ]
                        },
                    ],
                    dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Filter:</span> _INPUT_',
                        searchPlaceholder: 'Type to filter...',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                    }
                });

                // Individual column searching with text inputs
                $('.datatable-button-init-custom thead td').not('#ignore_search_field').each(function () {
                    var title = $('.datatable-button-init-custom thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" id="col' + $(this).index() + '_filter" class="form-control input-sm" placeholder="'+title+'" />');
                });

                var table = $('.datatable-button-init-custom').DataTable({
                    // buttons: [
                    //     {
                    //         text: 'Create Package',
                    //         className: 'btn bg-teal-400',
                    //         action: function(e, dt, node, config) {
                    //             window.location.href = "/packages/general/create";
                    //         }
                    //     }
                    // ],
                    order: [0, "asc"],
                    processing: true,
                    // serverSide: true,
                    ajax: "/supplier/list",
                    columns: [
                        {data:'name'},
                        {data:'address'},
                        {
                            data:'Actions',
                            className: 'text-center',
                            render: function(data, type, row){
                                return '<div class="list-icons">'+
                                            '<div class="dropdown">'+
                                                '<a href="#" class="list-icons-item" data-toggle="dropdown">'+
                                                    '<i class="icon-menu9"></i>'+
                                                '</a>'+
                                                '<div class="dropdown-menu dropdown-menu-right">'+
                                                    '<a href="/supplier/update/'+row['id']+'" class="dropdown-item">'+
                                                        '<i class="icon-pencil3"></i>Edit'+
                                                    '</a>'+
                                                    '<a href="#" class="dropdown-item btn-resend-creds" supplier_id="' + row['id'] + '">'+
                                                        '<i class="icon-bin2"></i>Delete'+
                                                    '</a>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'
                            }
                        },
                    ],
                });

                $('.table input').not('.toggle-frozen').on('keyup change', function (event){
                    // if(event.keyCode == 13)
                    filterColumn($(this).parents('td').attr('data-column'));
                });

                function filterColumn ( i ) {
                    table.column( i ).search($('#col'+i+'_filter').val()).draw();
                }
            };

            // Select2 for length menu styling
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                // Initialize
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    width: 'auto'
                });

                // Enable Select2 select for individual column searching
                $('.filter-select').select2();
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableAPI();
                    _componentSelect2();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            NotyJgrowl.init();
            DatatableCustomButtonWithSearch.init();
        });

        $(function(){
            $('body').delegate('.btn-img', 'click', function(e){
                $img_id = $(this).attr('img_id');
                $link = '/admin/image/' + $img_id;

                $('#modal_img .modal-body').empty();
                $('#modal_img .modal-body').append('<img src="' + $link + '" class="img-fluid mx-auto d-block" alt="Company Image">');
                $('#btn-view-img').attr('href', $link);
                $('#modal_img').modal();
            });

            $('body').delegate('.btn-resend-creds', 'click', function(e){
                $supplier_id = $(this).attr('supplier_id')
                $('#modal-resend-creds #supplier_id').val($supplier_id);
                $('#modal-resend-creds').modal();
            });

            $('#form_resend_creds').submit(function(e){
                e.preventDefault();

                var that = $(this);

                if(that.valid()) {
                    $('#modal-loading').modal();

                    var actionUrl = that.attr('action');

                    var form = new FormData(that[0]);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                        processData: false,
                        contentType: false,
                        type: "POST",
                        url: actionUrl,
                        data: form, // serializes the form's elements.
                        success: function (data) {
                            $('#modal-loading').modal('hide');

                            if (data.status == "success") {
                                $('#modal-resend-creds #company_id').val('');

                                $('#modal-resend-creds').modal('hide');
                            }

                            new Noty({
                                text: data.message,
                                type: data.status
                            }).show();
                        },
                        error: function (data) {
                            $('#modal-loading').modal('hide');
                            new Noty({
                                text: 'Error creating country, please try again.',
                                type: 'error'
                            }).show();
                        }
                    });
                }
            });

            $('body').delegate('.btn-profile', 'click', function(e){
                company_id = $(this).attr('company_id');

                that = $(this);

                $('#modal-loading').modal();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    type: "POST",
                    dataType: "json",
                    url: '/admin/company/profile',
                    data: {'company_id': company_id},
                    success: function(data){
                        $('#modal-loading').modal('hide');

                        $('#modal_profile .modal-body').html(data.profile);

                        $('#modal_profile').modal();
                    },
                    error: function(){
                        $('#modal-loading').modal('hide');
                        new Noty({
                            text: 'Error retrieving data, please try again.',
                            type: 'error'
                        }).show();
                    }
                });
            });

            $("#company_image_input").change(function(e) {
                if(e.originalEvent.srcElement.files.length > 0){
                    for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
                        var file = e.originalEvent.srcElement.files[i];
                        var reader = new FileReader();
                        var img = document.getElementById("icon_new");
                        reader.onloadend = function() {
                            img.src = reader.result;
                            $('#icon_new').show();
                            $('#icon_old').hide();
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    var img = document.getElementById("icon_new");
                    img.src = '';
                    $('#icon_new').hide();
                    $('#icon_old').show();
                }
            });
        });
    </script>
@endsection

@section('page_header')
    Package
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">List Supplier</h5>
        </div>

        <div class="card-body">
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add-ulasan"><i class="fas fa-plus mr-2"></i>Add Supplier</button>
        </div>

        <table class="table datatable-button-init-custom">
            <thead>
            <tr>
                @php
                    $index = 0;
                    foreach ($column_names as $key => $value){
                        if($value == 'Icon'){
                            echo "<td id='ignore_search_field'></td>";
                        } else {
                            echo "<td data-column='$index'>$value</td>";
                        }
                        $index++;
                    }
                @endphp
                <td id="ignore_search_field"></td>
            </tr>
            <tr>
                @php
                    foreach ($column_names as $key => $value){
                        if($value == 'Icon'){
                            echo "<th class='no-sort'>$value</th>";
                        } else {
                            echo "<th>$value</th>";
                        }
                    }
                @endphp
                <th class="text-center no-sort">Actions</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- MODALS -->

    <!-- Modal Add Supplier -->
    <div id='modal-add-ulasan' class='modal fade' tabindex='-1'>
        <div class='modal-dialog modal-small'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Add Supplier</h5>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                </div>

                <div class='modal-body'>
                    <form action="supplier" method="POST" class="form-validate-jquery" enctype="multipart/form-data">
                        @csrf
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3"> Name <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" name="name" class="form-control" value="" required placeholder="Name">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3"> Address <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" name="address" class="form-control" value="" required placeholder="Work">
                            </div>
                        </div>
        
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Supplier -->
    <div id='modal-resend-creds' class='modal fade' tabindex='-1'>
        <div class='modal-dialog modal-xs'>
            <div class='modal-content'>
                <div class='modal-header'>
                </div>

                <div class='modal-body'>
                    <h3 class="d-flex justify-content-center" style="margin: auto">Delete this Supplier ?</h3>
                    <br>
                    <div class="text-right">
                        <form action="supplier-delete" method="POST">
                            @csrf

                            <input type="hidden" name="supplier_id" id="supplier_id">

                            <div class="text-right">
                                <button type='button' class='btn btn-link' data-dismiss='modal'>No</button>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
