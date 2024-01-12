<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Surat Kesepakatan</title>
	<link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>css/bootstrap.min.css">
	<style>
		/* Add CSS styles for the table and its cells */
		table {
			width: 100%;
			border-collapse: collapse;
			margin: 0 auto;
		}

		table,
		th,
		td {
			border: 1px solid black;
		}

		th,
		td {
			padding: 8px;
			text-align: left;
		}

		h1 {
			text-align: center;
		}
	</style>
</head>

<body>
	<!-- <div class="row" align="center"> -->
	<h1>REPORT MY TICKETING</h1>


	<table class="table table-striped" id="tableorder">
		<thead>
			<tr>
				<!-- <th data-field="no" data-sortable="true" width="10px"> No</th>
					<th data-field="idd" data-sortable="true">Id Ticket</th>
					<th data-field="iddd" data-sortable="true">Tanggal Ticket</th>
					<th data-field="idddd" data-sortable="true">Nama Kategori</th>
					<th data-field="iddddd" data-sortable="true">Nama Sub Kategori</th>
					<th data-field="idxddddd" data-sortable="true">Progress (%)</th>
					<th data-field="idddddd" data-sortable="true">Status</th>
					<th data-field="iddfdddd" data-sortable="true">Feedback</th> -->
				<th>No</th>
				<th>Id Ticket</th>
				<th>Tanggal Ticket</th>
				<th>Nama Kategori</th>
				<th>Nama Sub Kategori</th>
				<th>Progress (%)</th>
				<th>Status</th>
				<th>Feedback</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			foreach ($datamyticket as $row) : $no++; ?>
				<tr>
					<td data-field="no" width="10px"><?php echo $no; ?></td>
					<!-- <td data-field="id"><a href="<?php echo base_url(); ?>myticket/myticket_detail/<?php echo $row->id_ticket; ?>"><?php echo $row->id_ticket; ?></a></td> -->
					<td data-field="id"><?php echo $row->id_ticket; ?></a></td>
					<td data-field="id"><?php echo $row->tanggal; ?></td>
					<td data-field="id"><?php echo $row->nama_kategori; ?></td>
					<td data-field="id"><?php echo $row->nama_sub_kategori; ?></td>
					<td data-field="id"><?php echo $row->progress; ?></td>
					<td data-field="id"><?php if ($row->status == 1) {
											echo "MENUNGGU DISETUJUI";
										} else if ($row->status == 2) {
											echo "DISETUJUI";
										} else if ($row->status == 0) {
											echo "TICKET DITOLAK";
										} else if ($row->status == 3) {
											echo "MENUNGGU APRROVAL TEKNISI";
										} else if ($row->status == 4) {
											echo "PROSES TEKNISI";
										} else if ($row->status == 5) {
											echo "PENDING TEKNISI";
										} else if ($row->status == 6) {
											echo "SOLVED/Menunggu Acc dari Requestor";
										} else if ($row->status == 7) {
											echo "MENUNGGU APPROVE close ticket";
										} else if ($row->status == 8) {
											echo "MENUNGGU APPROVE PENDING";
										} else if ($row->status == 9) {
											echo "SOLVED";
										} else if ($row->status == 10) {
											echo "Close Ticket/Tidak Dapat Dilanjutkan";
										}
										?></td>

					<td>
						<?php if ($row->status == 9 and $row->feedback == "") { ?>
							<a class="ubah btn btn-success btn-xs" href="<?php echo base_url(); ?>myticket/feedback_yes/<?php echo $row->id_ticket; ?>/<?php echo $row->id_teknisi; ?>"><span class="glyphicon glyphicon-thumbs-up"></span></a>
							<a title="Hapus Kontak" class="hapus btn btn-danger btn-xs" href="<?php echo base_url(); ?>myticket/feedback_no/<?php echo $row->id_ticket; ?>/<?php echo $row->id_teknisi; ?>"><span class="glyphicon glyphicon-thumbs-down"></span></a>
						<?php } else if ($row->status == 9 and  $row->feedback == 1) {
							echo "ANDA MEMBERIKAN FEEDBACK POSITIF";
						} else if ($row->status == 9 and $row->feedback == 0) {
							echo "ANDA MEMBERIKAN FEEDBACK NEGATIF";
						} else if ($row->status == 7 and $row->status == 10) {
							// echo " DETAIL";
							// $id_ticket = $row->id_ticket;
							// $link_detail1 = 'myticket_detail/' . $id_ticket;
							// echo "<a href='$link_detail1'>DETAIL</a>";

							echo "DETAIL";
						} else {
							echo "MENUNGGU STATUS SOLVED DARI TEKNISI";
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

	</div>
</body>

</html>