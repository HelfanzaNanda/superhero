@extends('layouts.app')
@section('content')
<div class="alert alert-primary" role="alert">
	Meng-klik "View Detail" di atas akan membawamu ke halaman detail di bawah ini. Ini jika kamu mengklik data milik Wolverine.
</div>
<hr>

<div class="d-flex justify-content-between">
	<div>
		<h4>Detail Superhero : {{ $superhero->name }}</h4>
	</div>
	<div>
		<button class="btn btn-primary mr-2" id="edit-superhero">Edit</button>
		<button class="btn btn-danger" id="delete-superhero">Delete</button>
	</div>
</div>

<div class="py-3">
	<table id="datatable" class="table table-bordered" style="width:100%">
		<tr>
			<td>ID</td>
			<td>{{ $superhero->id }}</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>
				<input type="text" name="name" id="name" class="form-control" value="{{ $superhero->name }}">
			</td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>
				<select name="gender" id="gender" class="form-control">
					<option value="Laki-Laki" {{ $superhero->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
					<option value="Perempuan" {{ $superhero->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
				</select>
			</td>
		</tr>
	</table>
</div>


<div class="py-3">
	<table id="skill-datatable" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Skill</th>
				<th scope="col">
					<button class="btn btn-primary btn-add-skill">Tambah Skill</button>
				</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

@include('modal.skill')

@endsection

@push('scripts')
	<script>

		$(document).on('click', '#delete-superhero', async function (e) {  
			e.preventDefault()
			const id ="{{ $superhero->id }}"
			const url = "{{ route('superheroes.delete', '') }}"+"/"+id
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

		$(document).on('click', '#edit-superhero', async function (e) {  
			e.preventDefault()
			const id ="{{ $superhero->id }}"
			const url = "{{ route('superheroes.update', '') }}"+"/"+id
			const form = {
				'name' : $('#name').val(),
				'gender' : $('#gender').val()
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

		$(document).on('click', '.btn-add-skill', function (e) {  
			e.preventDefault()
			$('#modal-title').text('Tambah SKill')
			$('#input-superhero-id').val("{{ $superhero->id }}")
			$('#modal-skill').modal('show')
		})


		$(document).on('submit', '#form-skill', async function (e) {  
			e.preventDefault()
			const form = new FormData(this)
			const url = "{{ route('skills.attach') }}"
			const response = await axios.post(url, form)
			if(response.status === 200){
				$('#modal-skill').modal('hide')
				alertSuccess(response.data.message)
				$('#input-skill').val('')
			}
		})

		$(document).on('click', '.btn-delete', function (e) {  
			e.preventDefault()
			const id =$(this).data('id')
			const url = "{{ route('skills.delete', '') }}"+"/"+id
			swalDelete(url, true)
		})

		const alertSuccess = (message) => {
			Swal.fire('Success', message, 'success')
			$("#skill-datatable").DataTable().ajax.reload();
		}

		const alertSuccessWithButton = (message) => {
			Swal.fire({
				title: 'Success',
				text: message,
				icon: 'success',
				confirmButtonText: 'Ok',
			}).then(result => {
				if (result.isConfirmed) {
					window.location.href = "{{ route('superheroes.index') }}"
				}
			})
		}


		$("#skill-datatable").DataTable({
			"pageLength": 10,
			"processing": true,
			"serverSide": true,
			"orderable": true,
			"searching": false,
			"ajax":{
				"url": "{{ route('skills.superhero.datatables') }}",
				"dataType": "json",
				"type": "POST",
				"data":function(d) {
					d._token = "{{csrf_token()}}"
					d.superhero_id = "{{ $superhero->id }}"
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