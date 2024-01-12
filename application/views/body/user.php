<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home">
					<use xlink:href="#stroked-home"></use>
				</svg></a></li>
		<li class="active">Pegawai</li>
	</ol>
</div><!--/.row-->

<br>


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><svg class="glyph stroked male user ">
					<use xlink:href="#stroked-male-user" />
				</svg>
				<a href="<?php echo base_url(); ?>user/add" style="text-decoration:none">Tambah Data Pegawai</a>
			</div>
			<div class="panel-body">
				<table data-toggle="table" data-show-refresh="false" data-show-toggle="true" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="asc">
					<!-- <thead>
						<tr>
							<th data-field="no" data-sortable="true" width="10px">No</th>
							<th data-field="id" data-sortable="true">Username</th>
							<th data-field="iddd" data-sortable="true">Nama</th>
							<th data-field="divisi" data-sortable="true">Divisi</th>
							<th data-field="jenis_kelamin" data-sortable="true">Departemen</th>
							<th data-field="departemen" data-sortable="true">Level</th>
							<th>Aksi</th>
						</tr>
					</thead> -->
					<thead>
						<tr>
							<th data-field="no" data-sortable="true" width="10px">No</th>
							<th data-field="id" data-sortable="true">Nik</th>
							<th data-field="iddd" data-sortable="true">Nama</th>
							<th data-field="divisi" data-sortable="true">Nama Divisi</th>
							<th data-field="posisi" data-sortable="true">Posisi</th>
							<th data-field="hk" data-sortable="true">Hak akses</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<!-- <?php $no = 0;
								foreach ($datauser as $row) : $no++; ?>
							<tr>
								<td data-field="no" width="10px"><?php echo $no; ?></td>
								<td data-field="nik"><?php echo $row->username; ?></td>
								<td data-field="nsik"><?php echo $row->nama; ?></td>
								<td data-field="jk"><?php echo $row->nama_divisi; ?></td>
								<td data-field="jk"><?php echo $row->nama_dept; ?></td>
								<td data-field="jk"><?php echo $row->level; ?></td>
								<td>
									<a class="ubah btn btn-primary btn-xs" href="<?php echo base_url(); ?>user/edit/<?php echo $row->id_user; ?>"><span class="glyphicon glyphicon-edit"></span></a>
									<a data-toggle="modal" title="Hapus Kontak" class="hapus btn btn-danger btn-xs" href="#modKonfirmasi" data-id="<?php echo $row->id_user; ?>"><span class="glyphicon glyphicon-trash"></span></a>
								</td>
							</tr>
						<?php endforeach; ?> -->
						<?php $no = 0;
						foreach ($datauser2 as $row) : $no++; ?>
							<tr>
								<td data-field="no" width="10px"><?php echo $no; ?></td>
								<td data-field="id"><?php echo $row->nik; ?></td>
								<td data-field="iddd"><?php echo $row->nama; ?></td>
								<td data-field="divisi">
									<?php
									$sql_pegawai = "SELECT * FROM tb_pegawai WHERE nik='$row->nik'";
									$row_pegawai = $this->db->query($sql_pegawai)->row();

									$sql_divisi = "SELECT * FROM tb_unit WHERE id_unit='$row_pegawai->unit_kerja '";
									$row_divisi = $this->db->query($sql_divisi)->row();

									echo $row_divisi->nama;
									?>
								</td>
								<td data-field="posisi">
									<?php
									$sql_pegawai = "SELECT * FROM tb_pegawai WHERE id_peg='$row->id_peg'";
									$row_pegawai = $this->db->query($sql_pegawai)->row();

									// $query_posisi = "SELECT * FROM tb_jabatan where id_jab='$row_pegawai->jabatan'";
									// $row_posisi = $this->db->query($query_posisi)->row();
									$query_posisi = "SELECT * FROM tb_jabatan where id_peg='$row_pegawai->id_peg'";
									$row_posisi = $this->db->query($query_posisi)->row();

									echo $row_posisi->posisi;
									?>
									<!-- $tampilPeg = mysql_query("SELECT * FROM tb_pegawai where status_karyawan=0 ORDER BY unit_kerja ='12' desc,unit_kerja ='4' desc,unit_kerja='7' desc"); -->

								</td>
								<td data-field="hk"><?php echo $row->hak_akses; ?></td>
								<td>
									<a class="ubah btn btn-primary btn-xs" href="<?php echo base_url(); ?>user/edit/<?php echo $row->id_user; ?>"><span class="glyphicon glyphicon-edit"></span></a>
									<a data-toggle="modal" title="Hapus Kontak" class="hapus btn btn-danger btn-xs" href="#modKonfirmasi" data-id="<?php echo $row->id_user; ?>"><span class="glyphicon glyphicon-trash"></span></a>
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

		// $(".hapus").click(function() {
		// 	var id = $(this).data('id');

		// 	$(".modal-body #mod").text(id);

		// });
		$(document).on('click', '.hapus', function(e) {
			e.preventDefault();
			$('#hapus').modal('show');
			var id = $(this).data('id');
			$(".modal-body #mod").text(id);
			getRow(id);
		});

	});
</script>



</div>
</div>
</div>
</div><!--/.row-->