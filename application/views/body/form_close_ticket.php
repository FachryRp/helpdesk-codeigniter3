			<div class="row">
				<ol class="breadcrumb">
					<li><a href="#"><svg class="glyph stroked home">
								<use xlink:href="#stroked-home"></use>
							</svg></a></li>
					<li class="active">Form Close Ticket</li>
				</ol>
			</div><!--/.row-->

			<br>


			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"><svg class="glyph stroked hourglass">
								<use xlink:href="#stroked-hourglass" />

							</svg>
							<a href="#" style="text-decoration:none">Form Close Ticket</a>

						</div>
						<div class="panel-body">

							<div class="col-md-6">
								<form method="post" action="<?php echo base_url(); ?>approval/approval_keterangan_save">
									<input name="id_ticket" type="hidden" value="<?php echo $id_ticket; ?>">
									<div class="form-group">
										<label>Keterangan Pending Ticket</label> <?php echo $id_ticket; ?>

										<textarea name="keterangan_pending" class="form-control" rows="10" required><?php echo $keterangan_pending; ?></textarea>
									</div>

									<button type="submit" class="btn btn-primary">Simpan</button>

									<a href="<?php echo base_url(); ?>myassignment/myassignment_list" class="btn btn-default">Batal</a>
							</div>

							</form>


						</div>
					</div>
				</div>
			</div><!--/.row-->