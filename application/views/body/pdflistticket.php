<!-- pdflistticket_view.php -->

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Report List Ticketing</title>
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap.min.css'; ?>">
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
	<h1>REPORT LIST TICKETING</h1>
	<table class="table table-striped" id="tableorder">
		<thead>
			<tr>
				<th>No</th>
				<th>Id Ticket</th>
				<th>Reported</th>
				<th>Dept</th>
				<th>Tanggal</th>
				<th>Nama Kategori</th>
				<th>Nama Sub Kategori</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;
			foreach ($datalist_ticket as $row) : $no++; ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $row->id_ticket; ?></td>
					<td><?php echo $row->nama; ?></td>
					<td><?php echo $row->nama_dept; ?></td>
					<td><?php echo $row->tanggal; ?></td>
					<td><?php echo $row->nama_kategori; ?></td>
					<td><?php echo $row->nama_sub_kategori; ?></td>
					<td>
						<?php
						if ($row->status == 2) {
							echo "APPROVAL INTERNAL";
						} elseif ($row->status == 3) {
							echo "MENUNGGU APPROVAL TEKNISI";
						} elseif ($row->status == 4) {
							echo "PROSES TEKNISI";
						} elseif ($row->status == 5) {
							echo "PENDING TEKNISI";
						} elseif ($row->status == 6) {
							echo "SOLVED";
						} else if ($row->status == 7) {
							echo "CLOSE TICKET";
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>

</html>