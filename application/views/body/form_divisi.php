			<div class="row">
				<ol class="breadcrumb">
					<li><a href="#"><svg class="glyph stroked home">
								<use xlink:href="#stroked-home"></use>
							</svg></a></li>
					<li class="active">Divisi</li>
				</ol>
			</div><!--/.row-->

			<br>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"><svg class="glyph stroked male user ">
								<use xlink:href="#stroked-male-user" />
							</svg>
							<a href="#" style="text-decoration:none">Tambah Data Divisi</a>
						</div>
						<div class="panel-body">

							<div class="col-md-6">
								<form method="post" action="<?php echo base_url(); ?><?php echo $url; ?>">

									<input type="hidden" class="form-control" name="id_divisi" value="<?php echo $id_divisi; ?>">

									<div class="form-group">
										<label>Nama Divisi</label>
										<input class="form-control" name="nama_divisi" placeholder="Nama Divisi" value="<?php echo $nama_divisi; ?>" required>
									</div>

									<button type="submit" class="btn btn-primary">Simpan</button>
									<a href="<?php echo base_url(); ?>divisi/divisi_list" class="btn btn-default">Batal</a>
							</div>

							</form>


						</div>
					</div>
				</div>
			</div><!--/.row-->