			<div class="row">
				<ol class="breadcrumb">
					<li><a href="#"><svg class="glyph stroked home">
								<use xlink:href="#stroked-home"></use>
							</svg></a></li>
					<li class="active">Approval Pending</li>
				</ol>
			</div><!--/.row-->

			<br>


			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading"><svg class="glyph stroked hourglass">
								<use xlink:href="#stroked-hourglass" />

							</svg>
							<a href="#" style="text-decoration:none">Approval Pending</a>
						</div>
						<div class="panel-body">
							<table data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc">
								<thead>
									<tr>
										<th data-field="no" data-sortable="true" width="10px"> No</th>
										<th data-field="idd" data-sortable="true">Id Ticket</th>
										<th data-field="iddd" data-sortable="true">Tanggal</th>
										<th data-field="idddd" data-sortable="true">Nama Kategori</th>
										<th data-field="iddddd" data-sortable="true">Nama Sub Kategori</th>
										<th data-field="idddddC" data-sortable="true">Keterangan</th>
										<th data-field="idddddd" data-sortable="true">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 0;
									foreach ($dataapproval_requestor_adm as $row) : $no++; ?>
										<tr>
											<td data-field="no" width="10px"><?php echo $no; ?></td>
											<td data-field="id">
												<?php if ($row->status == 8 || $row->status == 6  || $row->status == 7) { ?>
													<a href="<?php echo base_url(); ?>myticket/myticket_detail/<?php echo $row->id_ticket; ?>"><?php echo $row->id_ticket; ?></a>
												<?php } else {
													echo $row->id_ticket;
												}
												?>
											</td>
											<!-- <td data-field="id"><?php echo $row->tanggal; ?></td> -->
											<td data-field="iddd">
												<?php if ($row->status == 8) { ?>
													<?php echo $row->tanggal; ?>
												<?php } else if ($row->status == 6) { ?>
													<?php echo $row->tanggal_solved; ?>
												<?php } else if ($row->status == 7) { ?>
													<?php echo $row->tanggal_proses; ?>
												<?php } ?>
											</td>
											<td data-field="idddd"><?php echo $row->nama_kategori; ?></td>
											<td data-field="iddddd"><?php echo $row->nama_sub_kategori; ?></td>
											<!-- <td data-field="idddddC"><?php echo $row->keterangan_pending; ?></td> -->
											<!-- <td data-field="idddddC"><?php echo $row->deskripsi ?></td> -->
											<td data-field="idddddC">
												<?php if ($row->status == 8) { ?>
													<?php echo   '(pending) ' . $row->deskripsi; ?>
												<?php } else if ($row->status == 6) { ?>
													<?php echo '(solved) ' . $row->deskripsi; ?>
												<?php } else if ($row->status == 7) { ?>
													<?php echo '(tidak dapat dilanjutkan) ' . $row->deskripsi; ?>
												<?php } ?>
											</td>
											<td data-field="idddddd">


												<?php if ($row->status == 8) { ?>
													<a class="ubah btn btn-success btn-xs" href="<?php echo base_url(); ?>myassignment/pending_adm/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-ok"></span></a>
													<!-- <a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>myassignment/pending/<?php echo $row->id_ticket; ?>"> <span class="glyphicon glyphicon-remove"></span></a> -->
													<a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>myassignment/terima_adm/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-remove"></span></a>
													<!-- <a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>>myassignment/terima/<?php echo $row->id_ticket; ?>?status=3">
														<span class="glyphicon glyphicon-remove"></span> -->
													</a>
												<?php } else if ($row->status == 6) { ?>
													<a class="ubah btn btn-success btn-xs" href="<?php echo base_url(); ?>approval/terima_selesai_adm/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-ok"></span></a>
													<!-- <a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>myassignment/pending/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-minus-sign"></span></a> -->
													<a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>approval/proses_adm/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-remove"></span></a>
													<!-- <a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>myassignment/terima/<?php echo $row->id_ticket; ?>?status=3">
														<span class="glyphicon glyphicon-remove"></span>
													</a> -->

												<?php } else if ($row->status == 7) { ?>
													<a class="ubah btn btn-success btn-xs" href="<?php echo base_url(); ?>approval/close_selesai_adm/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-ok"></span></a>
													<!-- <a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>myassignment/pending/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-minus-sign"></span></a> -->
													<a class="ubah btn btn-danger btn-xs" href="<?php echo base_url(); ?>approval/proses_adm/<?php echo $row->id_ticket; ?>"><span class="glyphicon glyphicon-remove"></span></a>

												<?php } ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div><!--/.row-->


			<?php echo $this->session->flashdata("msg"); ?>


			<script>
				$(function() {
					$('#hover, #striped, #condensed').click(function() {
						var classes = 'table';

						if ($('#hover').prop('checked')) {
							classes += ' table-hover';
						}
						if ($('#condensed').prop('checked')) {
							classes += ' table-condensed';
						}
						$('#table-style').bootstrapTable('destroy')
							.bootstrapTable({
								classes: classes,
								striped: $('#striped').prop('checked')
							});
					});
				});

				function rowStyle(row, index) {
					var classes = ['active', 'success', 'info', 'warning', 'danger'];

					if (index % 2 === 0 && index / 2 < classes.length) {
						return {
							classes: classes[index / 2]
						};
					}
					return {};
				}
			</script>


			<?php $this->load->view('konfirmasi'); ?>

			<script type="text/javascript">
				$(document).ready(function() {

					$(".hapus").click(function() {
						var id = $(this).data('id');

						$(".modal-body #mod").text(id);

					});

				});
			</script>







			</div>
			</div>
			</div>
			</div><!--/.row-->