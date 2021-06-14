@extends('layouts.app')
@section('content')
<div class="alert alert-primary" role="alert">
	Ini adalah skill Bisa Tidur Tanpa Merem. Skill yang berbahaya. Musuh akan terkejut melihat skill ini.
</div>
<hr>

<div class="d-flex justify-content-between">
	<div>
		<h4>Detail Skill : {{ $skill->name }}</h4>
	</div>
	<div>
		<button class="btn btn-primary mr-2" id="edit-skill">Edit</button>
		<button class="btn btn-danger" id="delete-skill">Delete</button>
	</div>
</div>

<div class="py-3">
	<table id="datatable" class="table table-bordered" style="width:100%">
		<tr>
			<td>ID</td>
			<td>{{ $skill->id }}</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>
				<input type="text" name="name" id="name" class="form-control" value="{{ $skill->name }}">
			</td>
		</tr>
	</table>
</div>


<div class="py-3">
	<table id="superhero-datatable" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Superhero</th>
				<th scope="col">
					<button class="btn btn-primary btn-add-superhero">Tambah Superhero</button>
				</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

@include('modal.superhero')

@endsection

@push('scripts')
	<script>

		$(document).on('click', '#delete-skill', async function (e) {  
			e.preventDefault()
			const id ="{{ $skill->id }}"
			const url = "{{ route('skills.delete', '') }}"+"/"+id
			swalDelete(url)
		})

		const swalDelete = async (url, datatable = false) => {
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
					deleteData(url, datatable)
				}
			})
		}

		const deleteData = async(url, datatable) => {
			try {	
				const response = await axios.delete(url)
				if(response.status === 200){
					if(datatable){
						alertSuccess(response.data.message)
					}else{
						alertSuccessWithButton(response.data.message)
					}
				}
			} catch (error) {
				console.log(error);
			}
		}

		$(document).on('click', '#edit-skill', async function (e) {  
			e.preventDefault()
			const id ="{{ $skill->id }}"
			const url = "{{ route('skills.update', '') }}"+"/"+id
			const form = {
				'name' : $('#name').val()
			}
			try {	
				const response = await axios.put(url, form)
				if(response.status === 200){
					alertSuccess(response.data.message)
				}
			} catch (error) {
				console.log(error);
			}
		})

		$(document).on('click', '.btn-add-superhero', function (e) {  
			e.preventDefault()
			$('#modal-title').text('Tambah Superhero')
			$('#input-skill-id').val("{{ $skill->id }}")
			$('#modal-superhero').modal('show')
		})


		$(document).on('submit', '#form-superhero', async function (e) {  
			e.preventDefault()
			const form = new FormData(this)
			const url = "{{ route('superheroes.attach') }}"
			const response = await axios.post(url, form)
			if(response.status === 200){
				$('#modal-superhero').modal('hide')
				alertSuccess(response.data.message)
				$('#input-superhero').val('')
				$('#input-gender').val('')
			}
		})

		$(document).on('click', '.btn-delete', function (e) {  
			e.preventDefault()
			const id =$(this).data('id')
			const url = "{{ route('superheroes.delete', '') }}"+"/"+id
			swalDelete(url, true)
		})

		const alertSuccess = (message) => {
			Swal.fire('Success', message, 'success')
			$("#superhero-datatable").DataTable().ajax.reload();
		}

		const alertSuccessWithButton = (message) => {
			Swal.fire({
				title: 'Success',
				text: message,
				icon: 'success',
				confirmButtonText: 'Ok',
			}).then(result => {
				if (result.isConfirmed) {
					window.location.href = "{{ route('skills.index') }}"
				}
			})
		}


		$("#superhero-datatable").DataTable({
			"pageLength": 10,
			"processing": true,
			"serverSide": true,
			"orderable": true,
			"searching": false,
			"ajax":{
				"url": "{{ route('superheroes.skill.datatables') }}",
				"dataType": "json",
				"type": "POST",
				"data":function(d) {
					d._token = "{{csrf_token()}}"
					d.skill_id = "{{ $skill->id }}"
				}
			},
			"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'action', name: 'action', className: 'text-right'},
			],
		});
	</script>
@endpush