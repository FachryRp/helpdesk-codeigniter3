		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home">
							<use xlink:href="#stroked-home"></use>
						</svg></a></li>
				<li class="active">Dashboard <?php echo $this->session->userdata('id_jabatan'); ?></li>
				<!-- <li class="active">Dashboard <?php echo $this->session->userdata('hak_akses'); ?></li> -->

			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard </h1>
			</div>

		</div><!--/.row-->
		<?php if ($level_user === 'ADMIN') : ?>

			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-blue panel-widget ">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<svg class="glyph stroked bag">
									<use xlink:href="#stroked-bag"></use>
								</svg>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $jml_ticket; ?></div>
								<div class="text-muted">Total Tickets</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-orange panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<svg class="glyph stroked male-user">
									<use xlink:href="#stroked-male-user"></use>
								</svg>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $jml_karyawan; ?></div>
								<div class="text-muted">Total Karyawan</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-teal panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<svg class="glyph stroked male-user">
									<use xlink:href="#stroked-male-user"></use>
								</svg>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $jml_user; ?></div>
								<div class="text-muted">Total Users</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="panel panel-red panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<svg class="glyph stroked male-user">
									<use xlink:href="#stroked-male-user"></use>
								</svg>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo $jml_teknisi; ?></div>
								<div class="text-muted">Total Teknisi</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Tickets<br>Solved</h4>
							<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $jml_ticket_solved; ?>"><span class="percent"><?php echo ceil($jml_ticket_solved); ?> %</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Tickets On<br>Process</h4>
							<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $jml_ticket_process; ?>"><span class="percent"><?php echo ceil($jml_ticket_process); ?> %</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Tickets Waiting Approval Internal</h4>
							<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $jml_ticket_app_int; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_int); ?> %</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Tickets Waiting Approval Technition</h4>
							<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $jml_ticket_app_tek; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_tek); ?>%</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4>Tickets <br> Closed </h4>
							<div class="easypiechart" id="easypiechart-gray" data-percent="<?php echo $jml_ticket_close; ?>"><span class="percent"><?php echo ceil($jml_ticket_close); ?> %</span>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-6">
					<div class="panel panel-teal panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<svg class="glyph stroked star">
									<use xlink:href="#stroked-star" />
								</svg>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo ceil($jml_feedback_positiv); ?>%</div>
								<div class="text-muted">Feedback Positiv</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-6">
					<div class="panel panel-red panel-widget">
						<div class="row no-padding">
							<div class="col-sm-3 col-lg-5 widget-left">
								<svg class="glyph stroked cancel">
									<use xlink:href="#stroked-cancel" />
								</svg>
							</div>
							<div class="col-sm-9 col-lg-7 widget-right">
								<div class="large"><?php echo ceil($jml_feedback_negativ); ?>%</div>
								<div class="text-muted">Feedback Negativ</div>
							</div>
						</div>
					</div>

				</div>
				<!-- <div class="col-xs-9 col-md-10">
						<div class="panel panel-default">
							<div class="panel-body">
								<h4>Tickets close</h4>
								<div class="progress">
									<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $jml_ticket_close; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $jml_ticket_close; ?>%">
										<span><?php echo $jml_ticket_close; ?> % </span>
									</div>
								</div>
							</div>
						</div>
					</div> -->
			<?php elseif ($level_user === 'USER') : ?>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h4>Tickets<br>Solved</h4>
								<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $jml_ticket_solved_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_solved_user); ?> %</span>
									Total Ticket <?php echo $jml_ticket_user; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h4>Tickets On<br>Process</h4>
								<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $jml_ticket_process_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_process_user); ?> %</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h4>Tickets Waiting Approval Internal</h4>
								<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $jml_ticket_app_int_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_int_user); ?> %</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-3">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h4>Tickets Waiting Approval Technition</h4>
								<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $jml_ticket_app_tek_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_tek_user); ?> %</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h4>Tickets <br> Closed </h4>
								<div class="easypiechart" id="easypiechart-gray" data-percent="<?php echo $jml_ticket_close_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_close_user); ?> %</span>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-6">
						<div class="panel panel-teal panel-widget">
							<div class="row no-padding">
								<div class="col-sm-3 col-lg-5 widget-left">
									<svg class="glyph stroked star">
										<use xlink:href="#stroked-star" />
									</svg>
								</div>
								<div class="col-sm-9 col-lg-7 widget-right">
									<div class="large"><?php echo ceil($jml_feedback_positiv); ?>%</div>
									<div class="text-muted">Feedback Positiv</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-6 col-md-6">
						<div class="panel panel-red panel-widget">
							<div class="row no-padding">
								<div class="col-sm-3 col-lg-5 widget-left">
									<svg class="glyph stroked cancel">
										<use xlink:href="#stroked-cancel" />
									</svg>
								</div>
								<div class="col-sm-9 col-lg-7 widget-right">
									<div class="large"><?php echo ceil($jml_feedback_negativ); ?>%</div>
									<div class="text-muted">Feedback Negativ</div>
								</div>


							</div>
						</div>
					</div>
				<?php elseif ($hak_akses === 'Pegawai') : ?>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets<br>Solved</h4>
									<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $jml_ticket_solved_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_solved_user); ?> %</span>
										Total Ticket <?php echo $jml_ticket_user; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets On<br>Process</h4>
									<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $jml_ticket_process_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_process_user); ?> %</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets Waiting Approval Internal</h4>
									<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $jml_ticket_app_int_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_int_user); ?> %</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets Waiting Approval Technition</h4>
									<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $jml_ticket_app_tek_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_tek_user); ?> %</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets <br> Closed </h4>
									<div class="easypiechart" id="easypiechart-gray" data-percent="<?php echo $jml_ticket_close_user; ?>"><span class="percent"><?php echo ceil($jml_ticket_close_user); ?> %</span>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-6">
							<div class="panel panel-teal panel-widget">
								<div class="row no-padding">
									<div class="col-sm-3 col-lg-5 widget-left">
										<svg class="glyph stroked star">
											<use xlink:href="#stroked-star" />
										</svg>
									</div>
									<div class="col-sm-9 col-lg-7 widget-right">
										<div class="large"><?php echo ceil($jml_feedback_positiv); ?>%</div>
										<div class="text-muted">Feedback Positiv</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-6">
							<div class="panel panel-red panel-widget">
								<div class="row no-padding">
									<div class="col-sm-3 col-lg-5 widget-left">
										<svg class="glyph stroked cancel">
											<use xlink:href="#stroked-cancel" />
										</svg>
									</div>
									<div class="col-sm-9 col-lg-7 widget-right">
										<div class="large"><?php echo ceil($jml_feedback_negativ); ?>%</div>
										<div class="text-muted">Feedback Negativ</div>
									</div>


								</div>
							</div>
						</div>
						<!-- <div class="col-xs-9 col-md-10">
						<div class="panel panel-default">
							<div class="panel-body">
								<h4>Tickets Close</h4>
								<div class="progress">
									<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $jml_ticket_close_user; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $jml_ticket_close_user; ?>%">
										<span><?php echo $jml_ticket_close_user; ?> % </span>
										<span> dari </span>
										<span><?php echo $jml_ticket_close; ?> Ticket </span> 
									</div>
								</div>
							</div>
						</div>  -->


					</div>
				<?php else : ?>

					<div class="row">
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets<br>Solved</h4>
									<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $jml_ticket_solved; ?>"><span class="percent"><?php echo ceil($jml_ticket_solved); ?> %</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets On<br>Process</h4>
									<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $jml_ticket_process; ?>"><span class="percent"><?php echo ceil($jml_ticket_process); ?> %</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets Waiting Approval Internal</h4>
									<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $jml_ticket_app_int; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_int); ?> %</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets Waiting Approval Technition</h4>
									<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $jml_ticket_app_tek; ?>"><span class="percent"><?php echo ceil($jml_ticket_app_tek); ?>%</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h4>Tickets <br> Closed </h4>
									<div class="easypiechart" id="easypiechart-gray" data-percent="<?php echo $jml_ticket_close; ?>"><span class="percent"><?php echo ceil($jml_ticket_close); ?> %</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-6">
							<div class="panel panel-teal panel-widget">
								<div class="row no-padding">
									<div class="col-sm-3 col-lg-5 widget-left">
										<svg class="glyph stroked star">
											<use xlink:href="#stroked-star" />
										</svg>
									</div>
									<div class="col-sm-9 col-lg-7 widget-right">
										<div class="large"><?php echo ceil($jml_feedback_positiv); ?>%</div>
										<div class="text-muted">Feedback Positiv</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-6 col-md-6">
							<div class="panel panel-red panel-widget">
								<div class="row no-padding">
									<div class="col-sm-3 col-lg-5 widget-left">
										<svg class="glyph stroked cancel">
											<use xlink:href="#stroked-cancel" />
										</svg>
									</div>
									<div class="col-sm-9 col-lg-7 widget-right">
										<div class="large"><?php echo ceil($jml_feedback_negativ); ?>%</div>
										<div class="text-muted">Feedback Negativ</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				</div>
			</div>