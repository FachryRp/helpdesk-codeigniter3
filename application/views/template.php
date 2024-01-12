<!DOCTYPE html>
<html lang="en">

<head>
	<!--load view header -->
	<?php
	$this->load->view($header);
	?>
	<!--/header-->
</head>

<body>

	<?php

	$this->load->view($navbar);

	?>

	<?php

	$this->load->view($sidebar);

	?>


	<!--mainbar-->
	<style>
		@media only screen and (max-width: 600px) {
			.main21 {
				margin-top: 90px;
			}
		}
	</style>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main21">


		<?php

		$this->load->view($body);

		?>

	</div>


	<!--/mainbar-->


</body>

</html>