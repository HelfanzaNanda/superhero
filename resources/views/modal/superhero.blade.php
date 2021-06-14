<div class="modal fade" id="modal-superhero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-superhero">
				@csrf
				<input type="hidden" id="input-skill-id" name="skill_id">
				<div class="modal-body">
					<div class="form-group">
						<label for="">Nama</label>
						<input type="text" class="form-control" name="name" id="input-name" required>
					</div>
					<div class="form-group">
						<label for="">Jenis Kelamin</label>
						<select name="gender" id="input-gender" class="form-control">
							<option value="Laki-Laki">Laki-Laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>