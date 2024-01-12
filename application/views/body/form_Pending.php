			<style>
				@media only screen and (max-width: 320px) {

					.panel-heading {
						font-size: 1.2em;
					}

				}
			</style>
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>home"><svg class="glyph stroked home">
								<use xlink:href="#stroked-home"></use>
							</svg></a></li>
					<li class="active">Form Keterangan Pending</li>
				</ol>
			</div><!--/.row-->

			<br>


			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"><svg class="glyph stroked hourglass">
								<use xlink:href="#stroked-hourglass" />

							</svg>
							<a href="#" style="text-decoration:none">Form Keterangan Pending</a>

						</div>
						<div class="panel-body">

							<div class="col-md-6">
								<form method="post" action="<?php echo base_url(); ?>approval/approval_keterangan_save">
									<input name="id_ticket" type="hidden" value="<?php echo $id_ticket; ?>">
									<div class="form-group">
										<label>Keterangan Pending Ticket</label> <?php echo $id_ticket; ?>

										<textarea name="deskripsi" class="form-control" rows="10" required><?php echo $deskripsi; ?></textarea>
									</div>

									<button type="submit" class="btn btn-primary">Simpan</button>

									<a href="<?php echo base_url(); ?>myassignment/myassignment_list" class="btn btn-default">Batal</a>
							</div>

							</form>


						</div>
					</div>
				</div>
			</div><!--/.row-->