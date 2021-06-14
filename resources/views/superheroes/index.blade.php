@extends('layouts.app')
@section('content')
<div class="alert alert-primary" role="alert">
	Di bawah ini adalah Daftar orang-orang yang super hebat itu.
	Kamu bisa mencari nama mereka melalui fasilitas pencarian di sebelah kanan.
	Kita beruntung memiliki data-data mereka. Jangan sampai jatuh ke tangan musuh, ini akan mengubah dunia..
</div>

<div class="d-flex justify-content-between">
	<div class="col-md-1">
		<h6>Daftar Superhero</h6>
	</div>
	<div class="col-md-3">
		<div class="input-group mb-3 ">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">
					<i class="fas fa-search"></i>
				</span>
			</div>
			<input type="text" class="form-control" name="key" id="key" placeholder="Cari Superharo">
			<div class="input-group-prepend ">
				<button class="btn btn-outline-secondary rounded-right btn-search" type="button">Cari</button>
			</div>
		</div>
	</div>
</div>

<div class="py-3">
	<table id="datatable" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Gender</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

@endsection

@push('scripts')
<script>
		$("#datatable").DataTable({
			"pageLength": 10,
			"processing": true,
			"serverSide": true,
			"orderable": true,
			"searching": false,
			"ajax":{
				"url": "{{ route('superheroes.datatables') }}",
				"dataType": "json",
				"type": "POST",
				"data":function(d) {
					d._token = "{{csrf_token()}}"
					d.key = $('#key').val()
				}
			},
			"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'gender', name: 'gender'},
				{data: 'action', name: 'action', className: 'text-right'},
			],
		});

		$(document).on('click', '.btn-search', function (e) {  
			e.preventDefault()
			$("#datatable").DataTable().ajax.reload();
		})

		$(document).on('click', '.btn-delete', function (e) {
			const id = $(this).data('id')
			e.preventDefault()
			Swal.fire({
                title: 'Are you sure ?',
                text: "You won't be able to revert this !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
				if(result.isConfirmed){
					deleteSuperhero(id)
				}
			})
		})

		const deleteSuperhero = async (id) => {
			const url = "{{ route('superheroes.delete', '') }}"+'/'+id
			const response = await axios.delete(url)
			if(response.status === 200){
				//console.log(response.data);
				alertSuccess(response.data.message)
			}
		}

		const alertSuccess = (message) => {
			Swal.fire('Success', message, 'success')
			$("#datatable").DataTable().ajax.reload();
		}	
</script>
@endpush