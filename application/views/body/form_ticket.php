<script language="javascript" type="text/javascript">
	$(document).ready(function() {

		$("#id_kategori").change(function() {
			// Put an animated GIF image insight of content

			var data = {
				id_kategori: $("#id_kategori").val()
			};
			$.ajax({
				type: "POST",
				url: "<?php echo base_url() . 'select/select_sub_kategori' ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
			});
		});

	});
</script>

<div class="row">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url(); ?>home"><svg class="glyph stroked home">
					<use xlink:href="#stroked-home"></use>
				</svg></a></li>
		<li class="active">New Ticket</li>
	</ol>
</div><!--/.row-->

<br>


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><svg class="glyph stroked male user ">
					<use xlink:href="#stroked-male-user" />
				</svg>
				<a href="#" style="text-decoration:none; color:white">Ticket</a>
			</div>
			<div class="panel-body">

				<div class="col-md-12">
					<form method="post" action="<?php echo base_url(); ?><?php echo $url; ?>">

						<input type="hidden" class="form-control" name="id_ticket" value="<?php echo $id_ticket; ?>">
						<input type="hidden" class="form-control" name="id_user" value="<?php echo $id_user; ?>">

						<div class="panel panel-danger">
							<div class="panel-heading">
								Requester
							</div>
							<div class="panel-body">

								<div class="col-md-6">

									<div class="form-group">
										<label>NIK</label>
										<input class="form-control" name="nama" placeholder="Nama" value="<?php echo $id_user; ?>" disabled>
									</div>

									<!-- <div class="form-group">
										<label>Departemen</label>
										<input class="form-control" name="departemen" placeholder="Departemen" value="<?php echo $departemen; ?>" disabled>
									</div> -->
									<div class="form-group">
										<label>Divisi</label>
										<input class="form-control" name="unit_kerja" placeholder="Divisi" value="<?php echo $unit_kerja; ?>" disabled>
									</div>

								</div>

								<div class="col-md-6">

									<!-- <div class="form-group">
										<label>Nama</label>
										<input class="form-control" name="nama" placeholder="Nama" value="<?php echo $nama; ?>" disabled>
									</div> -->
									<div class="form-group">
										<label>Nama</label>
										<input class="form-control" name="nama_user" placeholder="Nama" value="<?php echo $nama_user; ?>" disabled>
									</div>

									<!-- <div class="form-group">
										<label>Divisi</label>
										<input class="form-control" name="divisi" placeholder="Divisi" value="<?php echo $divisi; ?>" disabled>
									</div> -->
									<!-- <div class="form-group">
										<label>Nama Divisi</label>
										<input class="form-control" name="divisi" placeholder="Divisi" value="<?php echo $divisi; ?>" disabled>
									</div> -->

								</div>

							</div>
						</div>

						<div class="panel panel-danger">
							<div class="panel-heading">
								Form Request
							</div>
							<div class="panel-body">

								<div class="col-md-6">

									<div class="form-group">
										<label>Kategori</label>
										<?php echo form_dropdown('id_kategori', $dd_kategori, $id_kategori, ' id="id_kategori" required class="form-control"'); ?>
									</div>

									<div id="div-order">

										<?php if ($flag == "edit") {

											echo form_dropdown('id_sub_kategori', $dd_sub_kategori, $id_sub_kategori, 'required class="form-control"');
										} else {
										}
										?>

									</div>

									<div class="form-group">
										<label>Ugently / Kondisi</label>
										<?php echo form_dropdown('id_kondisi', $dd_kondisi, $id_kondisi, ' id="id_kondisi" required class="form-control"'); ?>
									</div>



								</div>

								<div class="col-md-6">

									<div class="form-group">
										<label>Subject Request</label>
										<input class="form-control" name="problem_summary" placeholder="Subject Request" value="<?php echo $problem_summary; ?>" required>
									</div>

									<div class="form-group">
										<label>Request Detail</label>
										<textarea name="problem_detail" class="form-control" rows="10"><?php echo $problem_detail; ?></textarea>
									</div>



								</div>

							</div>
						</div>






						<button type="submit" class="btn btn-primary">Simpan</button>
						<a href="<?php echo base_url(); ?>myticket/myticket_list" class="btn btn-default">Batal</a>
				</div>

				</form>


			</div>
		</div>
	</div>
</div><!--/.row-->