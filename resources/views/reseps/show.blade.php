@extends('layout')

@section('title', 'Resep Obat')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Detail</span> - Resep Obat</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

    <!-- Content area -->
	<div class="content">

		<!-- Hover rows -->
		<div class="card">
			<div class="card-header header-elements-inline">
			</div>
			<div class="card-body">
				<form id="submit-form" class="form-validate-jquery" action="{{url('reseps/'.$resep->id.'/status')}}" method="post">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Resep</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Bangsal </label>
                            <label class="col-form-label col-lg-10">{{$resep->ruang_id ? $resep->ruang->bangsal->nama : '-'}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ruang </label>
                            <label class="col-form-label col-lg-10">{{$resep->ruang_id ? $resep->ruang->nomor : '-'}}</label>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Pasien </label>
                            <label class="col-form-label col-lg-10">{{$resep->pasien->nama}}</label>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal </label>
                            <label class="col-form-label col-lg-10">{{$resep->tanggal}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Dokter </label>
                            <label class="col-form-label col-lg-10">{{$resep->dokter->nama}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Catatan Resep </label>
                            <label class="col-form-label col-lg-10">{!!$resep->catatan_resep!!}</label>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Status <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="status_id" id="status_id" class="form-control form-control-select2" data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{$status->id}}" {{$resep->status_id == $status->id ? 'selected' : ''}}>{{$status->nama}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
					</fieldset>
					<div class="text-right">
						<a href="{{ url('/reseps')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
						<button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
					</div>
				</form>
			</div>

		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->

    <!-- Danger modal -->
	<div id="modal_theme_danger" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="" method="post" id="delform">
				    @csrf
				    @method('DELETE')
					<div class="modal-body" align="center">
						<h2> are you sure you want to permanently delete this file? </h2>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn bg-danger">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /default modal -->
@endsection

@section('js')
    <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>
    <script>
        var Summernote = function() {

            //
            // Setup module components
            //

            // Summernote
            var _componentSummernote = function() {
                if (!$().summernote) {
                    console.warn('Warning - summernote.min.js is not loaded.');
                    return;
                }

                // Basic examples
                // ------------------------------

                // Default initialization
                $('.summernote').summernote();

                // Control editor height
                $('.summernote-height').summernote({
                    height: 400
                });

                // Air mode
                $('.summernote-airmode').summernote({
                    airMode: true
                });


                // Click to edit
                // ------------------------------

                // Edit
                $('#edit').on('click', function() {
                    $('.click2edit').summernote({focus: true});
                })

                // Save
                $('#save').on('click', function() {
                    var aHTML = $('.click2edit').summernote('code');
                    $('.click2edit').summernote('destroy');
                });
            };

            // Uniform
            var _componentUniform = function() {
                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }

                // Styled file input
                $('.note-image-input').uniform({
                    fileButtonClass: 'action btn bg-warning-400'
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentSummernote();
                    _componentUniform();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            Summernote.init();
        });
    </script>
    <script type="text/javascript">
        var FormValidation = function() {

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
                    //successClass: 'validation-valid-label',
                    validClass: 'validation-valid-label',
                    highlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    unhighlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    // success: function(label) {
                    //    label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
                    //},

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
                        password: {
                            minlength: 8
                        }
                    },
                    messages: {
                        bangsal_id: {
                            required: 'Mohon pilih salah satu.'
                        },
                        ruang_id: {
                            required: 'Mohon pilih salah satu.'
                        },
                        pasien_id: {
                            required: 'Mohon pilih salah satu.'
                        },
                        tanggal: {
                            required: 'Mohon diisi.'
                        },
                        dokter_id: {
                            required: 'Mohon pilih salah satu.'
                        },
                        status_id: {
                            required: 'Mohon pilih salah satu.'
                        },
                    },
                });

                // Reset form
                $('#reset').on('click', function() {
                    validator.resetForm();
                });
            };

            // Return objects assigned to module
            return {
                init: function() {
                    _componentValidation();
                }
            }
        }();

        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            FormValidation.init();
        });
    </script>
    <script type="text/javascript">
    $('#bangsal_id').on('change', function () {
        $.ajax({
            url: "{{url('ruangs-options')}}?bangsal_id=" + $(this).val(),
            method: "GET",
            success: function (res) {
                $('#ruang_id').html(res);
            }
        });
    });
    </script>
	<script type="text/javascript">
		$( document ).ready(function() {
            // Select2
            var $select = $('.form-control-select2').select2();

	        // Default style
	        @if(session('error'))
	            new PNotify({
	                title: 'Error',
	                text: '{{ session('error') }}.',
	                icon: 'icon-blocked',
	                type: 'error'
	            });
            @endif
            @if ( session('success'))
	            new PNotify({
	                title: 'Success',
	                text: '{{ session('success') }}.',
	                icon: 'icon-checkmark3',
	                type: 'success'
	            });
            @endif

		});
	</script>
@endsection
