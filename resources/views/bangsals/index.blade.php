@extends('layout')

@section('title', 'Bangsal')

@section('css')
<style type="text/css">
	.datatable-column-width{
		overflow: hidden; text-overflow: ellipsis; max-width: 200px;
	}
</style>
@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Indeks</span> - Bangsal</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

    <!-- Content area -->
	<div class="content">

		<div class="row">
            <div class="col-md-7">
                <!-- Hover rows -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                    </div>

                    <table class="table datatable-basic table-hover" id="tabledata">
                        <thead>
                            <tr>
                                <th style="width:5%;">No</th>
                                <th style="width: 65%">Nama</th>
                                <th style="text-align: center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /hover rows -->
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header header-elements-inline">
                    </div>
                    <div class="card-body">
                        <form class="form-validate-jquery" action="{{route('bangsals.store')}}" method="post" id="myform">
                            @csrf

                            <input type="hidden" name="_method" id="method" value="post">

                            <fieldset class="mb-3">
                                <legend class="text-uppercase font-size-sm font-weight-bold" id="formtitle">Tambah Bangsal
                                </legend>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Nama Bangsal</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="nama" name="nama" class="form-control border-teal border-1" placeholder="Nama Bangsal" value="{{ old('nama') }}" required>
                                    </div>
                                </div>

                            </fieldset>
                            <div class="text-right">
                                <a type="button" class="btn btn-light resetbutton">Reset <i class="icon-undo"></i></a>
                                <button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

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
						<h2> Hapus Data? </h2>
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
    <script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>

    <script>
		//modal delete
		$(document).on("click", ".delbutton", function () {
		     var url = $(this).data('uri');
		     $("#delform").attr("action", url);
		});

		var DatatableBasic = function() {

		    // Basic Datatable examples
		    var _componentDatatableBasic = function() {
		        if (!$().DataTable) {
		            console.warn('Warning - datatables.min.js is not loaded.');
		            return;
		        }

		        // Setting datatable defaults
		        $.extend( $.fn.dataTable.defaults, {
		            autoWidth: false,
		            columnDefs: [{
		                orderable: false,
		                width: 100,
		                targets: [ 2 ]
		            }],
		            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
		            language: {
		                search: '<span>Search:</span> _INPUT_',
		                searchPlaceholder: 'Type to search...',
		                lengthMenu: '<span>Show:</span> _MENU_',
		                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
		            }
		        });

                let datas = [
                    {data:'DT_RowIndex', name:'no'},
                    {data: 'nama'},
                    {data: null, render: function(data, type, row) {
                        console.log(data);
						let html = '';
						html += `
						<div style="text-align:center">
                            <button type="button" class="btn btn-primary btn-icon editbutton" title="Ubah"
								data-nama="${data.nama}"
                                data-telepon="${data.telepon}"
								data-uri="bangsals/${data.id}">
								<i class="icon-pencil7"></i>
							</button>
							<a class="delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="bangsals/${data.id}">
                                <button type="button" class="btn btn-danger btn-icon" title="Hapus"><i class="icon-x"></i></button>
                            </a>
                        </div>
						`;
						return html;
					}}
                ];

		        // Basic datatable
		        $('.datatable-basic').DataTable({
					processing: true,
					serverSide: true,
					ajax: {
                            url: "{{url('/bangsals-datatable')}}",
                            type: "GET",
                        },
					columns: datas,
					"order": [[ 0, "desc" ]],
				});

		        // Alternative pagination
		        $('.datatable-pagination').DataTable({
		            pagingType: "simple",
		            language: {
		                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
		            }
		        });

		        // Datatable with saving state
		        $('.datatable-save-state').DataTable({
		            stateSave: true
		        });

		        // Scrollable datatable
		        var table = $('.datatable-scroll-y').DataTable({
		            autoWidth: true,
		            scrollY: 300
		        });

		        // Resize scrollable table when sidebar width changes
		        $('.sidebar-control').on('click', function() {
		            table.columns.adjust().draw();
		        });
		    };


		    //
		    // Return objects assigned to module
		    //

		    return {
		        init: function() {
		            _componentDatatableBasic();
		        }
		    }
		}();

		// Initialize module
		// ------------------------------

		document.addEventListener('DOMContentLoaded', function() {
		    DatatableBasic.init();
		});
	</script>
    <script type="text/javascript">
        $('#tabledata').on('click','.editbutton', function(){
            var nama = $(this).data('nama');
            var uri = $(this).data('uri');

            $('#myform').attr("action", "");
            $('#myform').attr("action", uri);
            $('#method').val("patch");
            $('#nama').val(nama);
            $('#formtitle').html('Edit Bangsal');

        });

        $('.resetbutton').on('click', function(){
            $('#myform').attr("action", "{{route('bangsals.store')}}");
            $('#method').val("post");
            $('#nama').val("");
            $('#formtitle').html('Tambah Bangsal');
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
