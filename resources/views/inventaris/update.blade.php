@extends('sidebar')

@section('title')
    Edit Inventaris
@endsection

@section('head')
    <style>
        .company_image{
            max-height: -webkit-fill-available;
            max-width: 300px;
        }
    </style>

    <script src="/global_assets/js/plugins/notifications/noty.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="/global_assets/js/demo_pages/form_inputs.js"></script>
    <script src="/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
    <script src="/global_assets/js/demo_pages/form_validation.js"></script>
    <script src="/global_assets/js/plugins/forms/validation/validate.min.js"></script>
    <script src="/global_assets/js/plugins/forms/validation/additional_methods.min.js"></script>
    <script src="/global_assets/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/switch.min.js"></script>
    <script src="/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="/global_assets/js/plugins/pickers/color/spectrum.js"></script>
    <script src="/global_assets/js/demo_pages/picker_color.js"></script>
    <script src="/global_assets/js/plugins/editors/ckeditor/ckeditor.js"></script>

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

        /* ------------------------------------------------------------------------------
	 *
	 *  # CKEditor editor
	 *
	 *  Demo JS code for editor_ckeditor.html page
	 *
	 * ---------------------------------------------------------------------------- */


        // Setup module
        // ------------------------------

        var CKEditor = function() {


            //
            // Setup module components
            //

            // CKEditor
            var _componentCKEditor = function() {
                if (typeof CKEDITOR == 'undefined') {
                    console.warn('Warning - ckeditor.js is not loaded.');
                    return;
                }

                // Use specific config file
                CKEDITOR.config.customConfig = 'config_dark.js';


                // Full featured editor
                // ------------------------------

                // Setup
                CKEDITOR.replace('editor-full', {
                    height: 400
                });
                CKEDITOR.replace('editor-full-1', {
                    height: 400
                });


                // Readonly editor
                // ------------------------------

                // Setup
                var editorReadOnly = CKEDITOR.replace('editor-readonly', {
                    height: 400
                });

                // The instanceReady event is fired when an instance of CKEditor has finished
                // its initialization.
                editorReadOnly.on('instanceReady', function (ev) {
                    editorReadOnly = ev.editor;

                    // Show this "on" button.
                    // document.getElementById('readOnlyOn').style.display = '';
                    readOnly = document.getElementsByClassName('readOnlyOn');
                    for(var i = 0; i < readOnly.length; i++)
                        readOnly[i].style.display = '';

                    // Event fired when the readOnly property changes.
                    editorReadOnly.on('readOnly', function () {
                        // document.getElementById('readOnlyOn').style.display = this.readOnly ? 'none' : '';
                        // document.getElementById('readOnlyOff').style.display = this.readOnly ? '' : 'none';

                        readOnlyOn = document.getElementsByClassName('readOnlyOn');
                        readOnlyOff = document.getElementsByClassName('readOnlyOff');

                        for(var i = 0; i < readOnlyOn.length; i++)
                            readOnlyOn[i].style.display = this.readOnly ? 'none' : '';
                        for(var i = 0; i < readOnlyOff.length; i++)
                            readOnlyOff[i].style.display = this.readOnly ? '' : 'none';
                    });
                });
            };

            // Select2
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                // Default initialization
                $('.form-control-select2').select2({
                    minimumResultsForSearch: Infinity
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentCKEditor();
                    _componentSelect2();
                }
            }
        }();
        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            CKEditor.init();
        });

        /* ------------------------------------------------------------------------------
         *
         *  # Select2 selects
         *
         *  Specific JS code additions for form_select2.html page
         *
         * ---------------------------------------------------------------------------- */


        // Setup module
        // ------------------------------

        var Select2Selects = function() {


            //
            // Setup module components
            //

            // Select2 examples
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                //
                // Loading remote data
                //

                // Format displayed data
                function formatRepo (data) {
                    console.log(data);
                    if (data.loading) return data.text;

                    var markup = '<div class="select2-result-repository clearfix">' +
                        '<div class="select2-result-repository__title">' + data.email + '</div>' +
                        '</div>';

                    return markup;
                }

                // Format selection
                function formatRepoSelection (data) {
                    console.log(data);
                    return data.email || data.text;
                }

                // Initialize
                $('.select-remote-data').select2({
                    ajax: {
                        url: '/ajax/user-list',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {

                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;

                            return {
                                results: data.data,
                                pagination: {
                                    more: (params.page * 30) < data.total
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    minimumInputLength: 1,
                    templateResult: formatRepo, // omitted for brevity, see the source of this page
                    templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentSelect2();
                }
            }
        }();
        /* ------------------------------------------------------------------------------
         *
         *  # Form validation
         *
         *
         * ---------------------------------------------------------------------------- */


        // Setup module
        // ------------------------------

        var FormValidation = function() {

            // Uniform
            var _componentUniform = function() {
                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }

                // Initialize
                $('.form-input-styled').uniform({
                    fileButtonClass: 'action btn bg-blue'
                });
            };

            // Validation config
            var _componentValidation = function() {
                if (!$().validate) {
                    console.warn('Warning - validate.min.js is not loaded.');
                    return;
                }

                // Initialize
                var validator = $('.form-validate-jquery').validate({
                    ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                    errorClass: 'validation-invalid-label',
                    successClass: 'validation-valid-label',
                    validClass: 'validation-valid-label',
                    highlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    unhighlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    success: function(label) {
                        label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
                    },

                    // Different components require proper error label placement
                    errorPlacement: function(error, element) {

                        // Unstyled checkboxes, radios
                        if (element.parents().hasClass('form-check')) {
                            error.appendTo( element.parents('.form-check').parent() );
                        }

                        // Input with icons and Select2
                        else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                            error.appendTo( element.parent() );
                        }

                        // Input group, styled file input
                        else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                            error.appendTo( element.parent().parent() );
                        }

                        // Other elements
                        else {
                            error.insertAfter(element);
                        }
                    },
                    rules: {
                        title: {
                            minlength: 4
                        },
                        price_value: {
                            number: true
                        },
                        limit_project: {
                            digits: true
                        },
                        limit_schedule: {
                            digits: true
                        },
                    },
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentUniform();
                    _componentValidation();
                }
            }
        }();

        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            NotyJgrowl.init();
            Select2Selects.init();
        });

        $(function(){
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
    Inventaris
@endsection

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit</h5>
        </div>
        <hr>
        <div class="card-body">
            <form action="/inventaris-update" method="POST" class="form-validate-jquery" enctype="multipart/form-data">
                @csrf
                <input type="text" id="inventaris_id" name="inventaris_id" value="{{ $model['id']}}" hidden>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3"> Jenis Barang <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="jenis_barang" class="form-control" value="{{ $model['jenis_barang']}}" required placeholder="jenis barang">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Asal Barang <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select class="form-control" name="asal_barang" required>
                            <option value="" disabled selected>Pilih Asal Barang</option>
                            <option value="dibeli sendiri" {{ $model['asal_barang'] == 'dibeli sendiri' ? 'selected' : '' }}>Dibeli Sendiri</option>
                            <option value="bantuan pemerintah" {{ $model['asal_barang'] == 'bantuan pemerintah' ? 'selected' : '' }}>Bantuan Pemerintah</option>
                            <option value="bantuan provinsi" {{ $model['asal_barang'] == 'bantuan provinsi' ? 'selected' : '' }}>Bantuan Provinsi</option>
                            <option value="bantuan Kabupaten" {{ $model['asal_barang'] == 'bantuan kabupaten' ? 'selected' : '' }}>Bantuan kabupaten</option>
                            <option value="sumbangan" {{ $model['asal_barang'] == 'bantuan sumbangan' ? 'selected' : '' }}>Sumbangan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Keadaan Barang <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select class="form-control" name="keadaan_barang" required>
                            <option value="" disabled selected>Pilih Keadaan Barang</option>
                            <option value="baik" {{ $model['keadaan_barang'] == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak" {{ $model['keadaan_barang'] == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Penghapusan Barang <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select class="form-control" name="penghapusan_barang" required>
                            <option value="" disabled selected>Pilih Penghapusan Barang</option>
                            <option value="dipakai" {{ $model['penghapusan_barang'] == 'dipakai' ? 'selected' : '' }}>Dipakai</option>
                            <option value="rusak" {{ $model['penghapusan_barang'] == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="dijual" {{ $model['penghapusan_barang'] == 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="disumbangan" {{ $model['penghapusan_barang'] == 'disumbangan' ? 'selected' : '' }}>Disumbangan</option>
                        </select>
                    </div>
                </div>

               

                <div class="form-group row">
                    <label class="col-form-label col-lg-3"> Keterangan <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="keterangan" class="form-control" value="{{ $model['keterangan'] }}" required placeholder="keterangan">
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
