@extends('layouts.app')
@section('content')
<div class="alert alert-primary" role="alert">
	Nah, ini adalah simulasi jika Wolverine & Storm menikah. Maka anak-anak mereka kemungkinan akan mewarisi Skill dari Ayah dan Ibunya. Kamu bisa mengganti-ganti Suami / Istri untuk melihat Skill yang akan dimiliki oleh anak-anaknya.
	<br> Tentunya Laki-laki hanya bisa menikah dengan Perempuan ya, awas jangan sampai jenis kelaminnya sama! Jeruk makan jeruk dong :D
</div>
<hr>

<div class="d-flex justify-content-between">
	<h4>Simulasi Jika Superhero Menikah</h4>
</div>
<table class="table table-bordered" style="width:100%">
	<tr>
		<td>Suami</td>
		<td>
			<select name="husband" id="husband" class="form-control">
				<option value="" disabled selected>Pilih Suami</option>
				@foreach ($males as $male)
					<option value="{{ $male->id }}">{{ $male->name }}</option>
				@endforeach
			</select>
		</td>
	</tr>
	<tr>
		<td>Istri</td>
		<td>
			<select name="wife" id="wife" class="form-control">
				<option value="" disabled selected>Pilih Istri</option>
				@foreach ($females as $female)
					<option value="{{ $female->id }}">{{ $female->name }}</option>
				@endforeach
			</select>
		</td>
	</tr>
</table>

<div class="pt-2 mb-4 children-skills" style="display: none">
	<h4>Maka Anaknya Kemungkinan Akan Memiliki Skill Berikut:</h4>
	<table id="children" class="table table-striped table-bordered mb-5" style="width:100%;">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Skill</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>

	<div class="d-flex">
		<form action="{{ route('married.excell') }}" method="POST" class="d-inline mr-2" target="_blank">
			@csrf
			<input type="hidden" name="wife_id" id="input-wife-id-excell">
			<input type="hidden" name="husband_id" id="input-husband-id-excell">
			<button class="btn btn-primary" type="submit">Excell</button>
		</form>
		<form action="{{ route('married.pdf') }}" method="POST" class="d-inline" target="_blank">
			@csrf
			<input type="hidden" name="wife_id" id="input-wife-id-pdf">
			<input type="hidden" name="husband_id" id="input-husband-id-pdf">
			<button class="btn btn-primary" type="submit">PDF</button>
		</form>
	</div>
	<hr>
	<div class="alert alert-primary" role="alert">
		Kamu juga bisa meng-export data hasil simulasi ini ke EXCEL / PDF. Ingat, data ini rahasia. Jangan sampai jatuh ke tangan musuh ya! Berbahaya!
	</div>
</div>

@endsection

@push('scripts')
	<script>
		let husband_id = null
		let wife_id = null

		$(document).on('change', '#husband', function (e) {  
			e.preventDefault()
			husband_id = $(this).val()
			$('#input-husband-id-excell').val(husband_id)
			$('#input-husband-id-pdf').val(husband_id)
			if(husband_id != null && wife_id != null){
				searchSkills()
			}
		})

		$(document).on('change', '#wife', function (e) {  
			e.preventDefault()
			wife_id = $(this).val()
			$('#input-wife-id-excell').val(wife_id)
			$('#input-wife-id-pdf').val(wife_id)
			if(husband_id != null && wife_id != null){
				searchSkills()
			}
		})

		const searchSkills = async () => {
			try{
				const url = "{{ route('married.search.skills') }}"
				const record = {
					'wife_id': wife_id,
					'husband_id': husband_id
				}
				const response = await axios.post(url, record)
				$('#children tbody').html(showSkills(response.data))
				$('.children-skills').css('display', '')
			}catch(error){
				console.log(error);
			}
		}

		const showSkills = (skills) => {
			let tbody = ''
			for (let index = 0; index < skills.length; index++) {
				tbody += '<tr>'
				tbody += '	<td>'+(index+1)+'</td>'
				tbody += '	<td>'+skills[index]+'</td>'
				tbody += '</tr>'
			}
			return tbody
		}

		const alertError = () => {
			Swal.fire('Oops...', 'please fill out all the forms', 'error')
		}
	</script>
@endpush