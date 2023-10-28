@extends('layout')

@section('title', 'Buat Resep Obat')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Tambah</span> - Resep Obat</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('/reseps')}}" method="post">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Resep</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Bangsal </label>
							<div class="col-lg-10">
								<select name="bangsal_id" id="bangsal_id" class="form-control form-control-select2"
                                data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300">
                                    <option value="">-- Pilih Bangsal --</option>
                                    @foreach ($bangsals as $bangsal)
                                        <option value="{{$bangsal->id}}">{{$bangsal->nama}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Ruang </label>
							<div class="col-lg-10">
								<select name="ruang_id" id="ruang_id" class="form-control form-control-select2"
                                data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300">
                                    <option value="">-- Pilih Ruang --</option>
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Pasien <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="pasien_id" id="pasien_id" class="form-control form-control-select2"
                                data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300" required>
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{$pasien->id}}">{{$pasien->nama}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Dokter <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="dokter_id" id="dokter_id" class="form-control form-control-select2"
                                data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach ($dokters as $dokter)
                                        <option value="{{$dokter->id}}">{{$dokter->nama}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Catatan Resep <span class="text-danger">*</span> </label>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-11">
                                        <textarea id="catatan_resep" name="catatan_resep[]" rows="3"
                                        class="form-control border-teal border-1" placeholder="Catatan Resep" required></textarea>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-success btn-icon add-more2" style="display:block">
                                            <i class="icon-plus-circle2" title="Add"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="before-add-more2">
                                </div>
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
                        dokter_id: {
                            required: 'Mohon pilih salah satu.'
                        },
                        'catatan_resep[]': {
                            required: 'Mohon diisi.'
                        }
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
    let numb = 1000

    $("body").on("click", ".add-more2", function () {
		var html = `
                        <div class="row mt-3 control-group">
                            <div class="col-md-11">
                                <textarea id="catatan_resep${numb}" name="catatan_resep[]" rows="3" class="form-control border-teal border-1" placeholder="Catatan Resep" required></textarea>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-icon remove" style="display:block">
                                    <i class="icon-cancel-circle2" title="Remove"></i>
                                </button>
                            </div>
                        </div>
                    `;

		$(".before-add-more2").before(html);

		numb++

	});

    $("body").on("click", ".remove", function () {
		$(this).parents(".control-group").remove();
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
