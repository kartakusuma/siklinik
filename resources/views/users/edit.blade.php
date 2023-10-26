@extends('layout')

@section('title', 'User')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Edit</span> - User</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('users/'.$user->id)}}" method="post">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data User</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="nama" value="{{$user->nama}}" class="form-control border-teal-300 border-1 @error('nama') is-invalid @enderror" placeholder="Nama" required autofocus autocomplete="off" value="{{ old('nama') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Username <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="username" value="{{$user->username}}" class="form-control border-teal-300 border-1 @error('username') is-invalid @enderror" placeholder="Username" required autocomplete="off" value="{{ old('username') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Password </label>
							<div class="col-lg-10">
								<input type="password" name="password" class="form-control border-teal-300 border-1 @error('password') is-invalid @enderror" placeholder="Password minimal 8 karakter" autocomplete="off" value="{{ old('password') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Jenis Kelamin <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="gender_id" id="gender_id" class="form-control form-control-select2" data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300" required>
                                    @if ($roles->count() < 1)
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                    @endif
                                    @foreach ($genders as $gender)
                                        <option value="{{$gender->id}}" {{$user->gender_id == $gender->id ? 'selected' : ''}}>{{$gender->nama}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email </label>
							<div class="col-lg-10">
								<input type="email" name="email" value="{{$user->email}}" class="form-control border-teal-300 border-1 @error('email') is-invalid @enderror" placeholder="Email" autocomplete="off" value="{{ old('email') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Telepon </label>
							<div class="col-lg-10">
								<input type="string" name="telepon" value="{{$user->telepon}}" class="form-control border-teal-300 border-1 @error('telepon') is-invalid @enderror" placeholder="Telepon" autocomplete="off" value="{{ old('telepon') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat </label>
							<div class="col-lg-10">
                                <textarea name="alamat" class="form-control border-teal-300 border-1" cols="30" rows="5">{{$user->alamat}}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Role <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="role_id" id="role_id" class="form-control form-control-select2" data-container-css-class="border-teal-300" data-dropdown-css-class="border-teal-300" required>
                                    @if ($roles->count() < 1)
                                        <option value="">-- Pilih Role --</option>
                                    @endif
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}" {{$user->role_id == $role->id ? 'selected' : ''}}>{{$role->nama}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Spesialisasi </label>
							<div class="col-lg-10">
								<input type="string" name="spesialisasi" value="{{$user->spesialisasi}}" class="form-control border-teal-300 border-1 @error('spesialisasi') is-invalid @enderror" placeholder="Spesialisasi" autocomplete="off" value="{{ old('spesialisasi') }}">
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/users')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
						<button type="submit" class="btn btn-primary submitBtn">Simpan <i class="icon-paperplane ml-2"></i></button>
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
                    rules: {
                        password: {
                            minlength: 8
                        }
                    },
                    messages: {
                        nama: {
                            required: 'Mohon diisi.'
                        },
                        username: {
                            required: 'Mohon diisi.'
                        },
                        gender_id: {
                            required: 'Mohon diisi.'
                        },
                        role_id: {
                            required: 'Mohon diisi.'
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
