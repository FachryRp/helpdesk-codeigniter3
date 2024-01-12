			<style>
				@media only screen and (max-width: 600px) {
					.panel-heading {
						/* font-size: 0.98em; */
						position: relative;
						font-size: 1.6rem;
						font-style: bold;
					}
				}
			</style>

			<div class="row">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>home"><svg class="glyph stroked home">
								<use xlink:href="#stroked-home"></use>
							</svg></a></li>
					<li class="active">Update Progress</li>
				</ol>
			</div><!--/.row-->

			<br>


			<div class="row">

				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"><svg class="glyph stroked male user ">
								<use xlink:href="#stroked-male-user" />
							</svg>
							<!-- <a href="<?php echo base_url(); ?>departemen/add" style="text-decoration:none">Update Progress</a> -->
							<!-- <a href="<?php echo base_url(); ?>myassignment/myassignment_list" style="text-decoration:none">Update Progress</a> -->
							<a href="#" style="text-decoration:none">Update Progress</a>
						</div>
						<div class="panel-body">

							<div class="list-group">
								<a href="#" class="list-group-item active">
									<?php echo $id_ticket; ?>
								</a>
								<a href="#" class="list-group-item"><span class="glyphicon glyphicon-calendar"></span> &nbsp;<?php echo $tanggal; ?></a>
								<a href="#" class="list-group-item"><span class="glyphicon glyphicon-briefcase"></span> &nbsp;<?php echo $nama_kategori; ?></a>
								<a href="#" class="list-group-item"><span class="glyphicon glyphicon-briefcase"></span> &nbsp;<?php echo $nama_sub_kategori; ?></a>
								<a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> &nbsp;<?php echo $reported; ?></a>
								<a href="#" class="list-group-item">Subject Request : </br></br> &nbsp;<?php echo $problem_summary; ?></a>
								<a href="#" class="list-group-item">Request Detail :</br></br> &nbsp;<?php echo $problem_detail; ?></a>
								<a href="#" class="list-group-item">
									<?php if ($status == 4) { ?>
										KETERANGAN : </br></br> Dalam Pengerjaan teknisi</b>
									<?php } else if ($status == 5) { ?>
										KETERANGAN : </br></br> Pending
									<?php } else if ($status == 6) { ?>
										KETERANGAN : </br></br> Menunggu Approve Solved
									<?php } else if ($status == 7) { ?>
										KETERANGAN : </br></br> Tidak dapat dilanjutkan
									<?php } else if ($status == 8) { ?>
										KETERANGAN : </br></br> Menunggu approve Pending
									<?php } else if ($status == 9) { ?>
										KETERANGAN : </br></br> Solved
									<?php } else if ($status == 10) { ?>
										KETERANGAN : </br></br> Tidak Dapat dilanjutkan
									<?php } ?>
								</a>
								<p></p>
								<a href="<?php echo base_url(); ?>livechat/get/<?php echo $id_ticket; ?>">

									<!-- <p> -->
									<button type="button" class="btn btn-default btn-sm">
										<span class="glyphicon glyphicon-envelope"></span> Livechat
									</button>
									<!-- </p> -->
								</a>
								<!-- <a href="#" class="list-group-item">Keterangan :</br></br> &nbsp;<?php echo $problem_detail; ?></a> -->
								<!-- <a href="<?php echo base_url(); ?>livechat/get<?php echo $row->id_ticket; ?>" class=" list-group-item"> -->
								<!-- <p>
									<button type="button" class="btn btn-default btn-sm">
										<span class="glyphicon glyphicon-envelope"></span> Livechat
									</button>
								</p> -->
								</a>
							</div>

							<div class="row">

								<div class="col-lg-6">

									<form method="post" action="<?php echo base_url(); ?><?php echo $url; ?>">

										<input type="hidden" class="form-control" name="id_ticket" value="<?php echo $id_ticket; ?>">

										<div class="form-group">
											<label>Up Progress</label>
											<select name="progress" class="form-control" id="progress">
												<?php $progress = (int)$progress;
												$startValue = ($progress <= 10) ? 10 : $progress;
												for ($i = $startValue; $i <= 100; $i += 10) {  ?>
													<!-- if ($i = 100) {} -->
													<option value="<?php echo $i; ?>">PROGRESS <?php echo $i; ?> %</option>
												<?php } ?>
												<option value="">-------------------</option>
											</select>
										</div>

										<div id="tambahan" style="display: none;">
											<div class="form-group">
												<label>Kategori</label>
												<select name="tambahan" class="form-control">
													<option value="selesai">Solved</option>
													<option value="tidak dapat dilanjutkan">tidak dapat dilanjutkan</option>
												</select>
											</div>
										</div>
										<div class="progress">
											<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%">
												<span class="sr-only"><?php echo $progress; ?> % Complete (Progress)</span>
											</div>
										</div>

										<div class="form-group">
											<label>Deskripsi Progress</label>
											<textarea name="deskripsi_progress" class="form-control" rows="10" required oninvalid="this.setCustomValidity('Harap Isi Deskripsi Progress')"></textarea>
										</div>


										<button type="submit" class="btn btn-primary">Simpan</button>

								</div>

								<div class="col-lg-9">

									<div id="div-order">



									</div>


								</div>

							</div>
							<div class="panel panel-danger">
								<div class="table-responsive">
									<div class="panel-heading">SYSTEM TRACKING TICKET</div>
									<div class="panel-body">

										<table class="table table-condensed">
											<tr>
												<th>NO</th>
												<th>TANGGAL</th>
												<th>STATUS</th>
												<th>DESKRIPSI</th>
												<th>BY</th>
											</tr>

											<?php $no = 0;
											foreach ($data_trackingticket as $row) : $no++; ?>
												<tr>
													<td><?php echo $no; ?></td>
													<td><?php echo $row->tanggal; ?></td>
													<td><?php echo $row->status; ?></td>
													<td><?php echo $row->deskripsi; ?></td>
													<td><?php echo $row->nama; ?></td>
												</tr>
											<?php endforeach; ?>
										</table>

									</div>
								</div>
							</div>
							</form>


						</div>
					</div>
				</div>

			</div>
			<script>
				const progress = document.getElementById('progress');
				const tambahan = document.getElementById('tambahan');

				progress.addEventListener('change', function() {
					const selectedValue = parseInt(progress.value);
					if (selectedValue === 100) {
						tambahan.style.display = 'block';
					} else {
						tambahan.style.display = 'none';
					}
				});
			</script>