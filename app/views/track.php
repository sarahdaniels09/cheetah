<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA PRO -  Integrated Web Shipping System                         *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************



require_once('helpers/querys.php');




if (isset($_GET['order_track'])) {

	$results = getCourierTrack($_GET['order_track']);

	$track = $results['data'];

	// var_dump($results['data']);

} else {

	redirect_to("tracking.php");
}



$db->query("

	SELECT a.id, a.order_track, a.t_dest, a.t_date, a.t_city, a.comments, a.status_courier, b.mod_style FROM courier_track as a

	INNER JOIN styles as b ON a.status_courier = b.id 

	where a.order_track='" . $_GET['order_track'] . "' ORDER BY a.t_date");

$courier_track = $db->registros();
if ($track != null) {




	$db->query("SELECT * FROM users where id= '" . $track->sender_id . "'");
	$sender_data = $db->registro();

	/* $db->query("SELECT * FROM users_multiple_addresses where id_addresses= '" . $_POST["sender_address_id"] . "'");

	$sender_address_data = $db->registro(); */

	$db->query("SELECT * FROM users where id= '" . $track->receiver_id . "'");
	$receiver_data = $db->registro();

	$db->query("SELECT * FROM delivery_time where id= '" . $track->order_deli_time . "'");
	$delivery_time = $db->registro();


	$db->query("SELECT * FROM address_shipments where order_track='" . $track->order_prefix . $track->order_no . "'");
	$address_order = $db->registro();


	$db->query("SELECT SUM(order_item_length) as total0 from add_order_item where order_id='" . $track->order_id . "'");
	$db->execute();
	$row0 = $db->registro();

	$rw_add0 = $row0->total0;


	// volumetric query of the box width

	$db->query("SELECT SUM(order_item_width) as total1 from add_order_item where order_id='" . $track->order_id . "'");
	$db->execute();
	$row1 = $db->registro();

	$rw_add1 = $row1->total1;

	// volumetric query of the box width

	$db->query("SELECT SUM(order_item_height) as total2 from add_order_item where order_id='" . $track->order_id . "'");
	$db->execute();
	$row2 = $db->registro();

	$rw_add2 = $row2->total2;

	$length = $rw_add0; //Length
	$width = $rw_add1; //Width
	$height = $rw_add2; //Height


	$total_metric = $length * $width * $height / $track->volumetric_percentage;


	$db->query("SELECT * FROM add_order_item WHERE order_id='" . $track->order_id . "'");
	$order_items = $db->registros();



	$sumador_libras = 0;
	$sumador_volumetric = 0;
	$count = 0;
	foreach ($order_items as $row_item) {

		$weight_item = $row_item->order_item_weight;

		$total_metric = $row_item->order_item_length * $row_item->order_item_width * $row_item->order_item_height / $track->volumetric_percentage;

		// calculate weight x price
		if ($weight_item > $total_metric) {

			$calculate_weight = $weight_item;
			$sumador_libras += $weight_item; //Sumador

		} else {

			$calculate_weight = $total_metric;
			$sumador_volumetric += $total_metric; //Sumador
		}

		$count++;
	}
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="Courier DEPRIXA-Integral Web System">
	<meta name="author" content="Jaomweb">
	<meta name="description" content="">
	<!-- For IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- For Resposive Device -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- For Window Tab Color -->
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#fff">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#fff">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#fff">
	<title>Track Shipment Result | <?php echo $core->site_name; ?></title>
	<!-- favicon -->
	<link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon; ?>">
	<!-- Bootstrap -->
	<link href="assets/theme_deprixa/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- Icons -->
	<link href="assets/theme_deprixa/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
	<!-- Slider -->
	<link rel="stylesheet" href="assets/theme_deprixa/css/owl.carousel.min.css" />
	<link rel="stylesheet" href="assets/theme_deprixa/css/owl.theme.css" />
	<link rel="stylesheet" href="assets/theme_deprixa/css/owl.transitions.css" />
	<!-- Main css -->
	<link href="assets/theme_deprixa/css/style.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="assets/assets-theme/css/bundle.css">
	<link rel="stylesheet" href="assets/assets-theme/css/style.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/assets-theme/main.css">
	<link rel="stylesheet" href="assets/assets-theme/themify-icons.css">
	<!--[if lt IE 8]><!-->
	<link rel="stylesheet" href="assets/assets-theme/ie7/ie7.css">


	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<style>
		ul.a {
			list-style-type: none;
		}


		/*.timeline {
			    position: relative;
			    padding: 1em 3em;
			    border-left: 3px solid #2eca8b;
			    border-top: none;
			}
*/

		/* Contenedor del popup */
		.popup {
			position: relative;
			display: inline-block;
			cursor: pointer;
		}

		/* pop-up actual */
		.popup .popuptext {
			visibility: hidden;
			width: 260px;
			background-color: #555;
			color: #fff;
			text-align: center;
			border-radius: 4px;
			padding: 8px 0;
			position: absolute;
			z-index: 1;
			bottom: 125%;
			left: 50%;
			margin-left: -130px;
		}

		.button4 {
			background-color: white;
			color: black;
			border: 2px solid #e7e7e7;
		}

		.button4:hover {
			background-color: #e7e7e7;
		}

		/* Muestra del Pop-up*/
		.popup .popuptext::after {
			content: "";
			position: absolute;
			top: 100%;
			left: 50%;
			margin-left: -5px;
			border-width: 5px;
			border-style: solid;
			border-color: #555 transparent transparent transparent;
		}

		/* Cambio para mostrar/ocultar el contenedor del pop-up */
		.popup .show {
			visibility: visible;
			-webkit-animation: fadeIn 1s;
			animation: fadeIn 1s
		}

		/* AnimaciĂ³n del pop-up */
		@-webkit-keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}
	</style>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<script>
		function mostrarMensaje(id) {
			var popup = document.getElementById("myPopup_" + id);
			popup.classList.toggle("show");
		}
	</script>
	<style>
		#map-canvas {
			width: 100%;
			height: 250px;
		}
	</style>

	<style>
		.center {
			margin: auto;
			width: 60%;
			padding: 10px;
		}
	</style>
</head>

<body>

	<!-- Loader -->
	<div id="preloader">
		<div id="status">
			<div class="spinner">
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			</div>
		</div>
	</div>
	<!-- Loader -->

	<!-- Navbar STart -->
	<header id="topnav" class="defaultscroll sticky">
		<div class="container">
			<!-- Logo container-->
			<div>
				<a class="logo" href="index.php"><?php echo ($core->logo) ? '<img src="assets/' . $core->logo . '" alt="' . $core->site_name . '"  width="150" ' : $core->site_name; ?></a>
			</div>
			<div class="buy-button">
				<a href="sign-up.php" class="btn btn-info	 rounded"><i class="mdi mdi-account-alert ml-3 icons"></i> <?php echo $lang['left185'] ?></a>
			</div>
			<!--end login button-->
			<div class="menu-extras">
				<div class="menu-item">
					<!-- Mobile menu toggle-->
					<a class="navbar-toggle">
						<div class="lines">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</a>
					<!-- End mobile menu toggle-->
				</div>
			</div>
			<div id="navigation">
				<!-- Navigation Menu-->
				<ul class="navigation-menu">
					<li><a href="../../"><?php echo $lang['left180'] ?></a></li>

					<li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left181'] ?></a></li>
				</ul>
			</div>
		</div>
	</header>
	<!-- Navbar End -->


	<!-- ERROR PAGE -->
	<section class="bg-home">
		<div class="home-center">
			<div class="home-desc-center">
				<div class="container">
					<div class="checkout-form">
						<div class="row">
							<?php if (!$track) : ?>

								<!--============================= TRACKING NOT FOUND =============================-->
								<div class="col-lg-12">
									<div class="user-profile-data">
										<div class="row justify-content-center">
											<?php echo "
									<div class='col-lg-8 col-md-12 text-center'>
										<img src='assets/images/alert/ohh_shipment_rate.png' class='img-fluid' alt=''/>
										<div class='text-uppercase mt-4 display-4'>Oh ! no</div>
										<div class='text-capitalize text-dark mb-4 display-6'>" . $lang['track-shipment1'] . " <strong style='color:#FF0000;'>" . $_GET['order_track'] . " </strong></div>
										<p class='text-muted para-desc mx-auto'><span class='text-primary font-weight-bold'>" . $lang['track-shipment2'] . "</span></p>
									</div>
								", false; ?>
										</div>

										<div class="row">
											<div class="col-md-12 text-center">
												<a href="tracking.php" class="btn btn-light-outline rounded mt-4"><?php echo $lang['left182'] ?></a>
												<a href="index.php" class="btn btn-light rounded mt-4 ml-2"><?php echo $lang['left183'] ?></a>
											</div>
										</div>
									</div>
								</div>
								<!--//END TRACKING NOT FOUND -->
							<?php else : ?>

								<div class="col-lg-12">
									<div class="user-profile-data">

										<br><br><br>
										<div class="row">
											<div class="col-md-3">
												<div class="trackstatus-title">

													<a class="btn btn-success btn-sm  rounded" target="blank" href="print_inv_ship_track.php?id=<?php echo $track->order_id; ?>"><i style="color:white" class="ti-printer"></i>&nbsp;<?php echo $lang['toolprint'] ?></a>

												</div>
											</div>
										</div>
										<div class="row">


											<div class="col-md-4">
												<div class="trackstatus-title">
													<p><span class="ti-package align-top" style="font-size: 30px;"></span>Shipping Status: <b><?php echo $track->mod_style; ?></b></p>
													<label> </label>
												</div>
											</div>

											<div class="col-md-3">
												<div class="trackstatus-title">
													<label>Tracking ID: <b><?php echo $track->order_prefix . $track->order_no; ?></b></label>
												</div>
											</div>

											<div class="col-md-3">
												<div class="trackstatus-title">
													<label>Destination: <b><?php echo $address_order->too; ?></b></label>
												</div>
											</div>

										</div>
										<!-- General Information -->
										<div class="payment-wrap">
											<div class="row">
												<div class="col-md-12">
													<div class="track-title">
														<h5 class="form_sub" style="background-color: #2eca8b; color:white">Location</h5>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="track-title">
														<span class="ti-location-pin align-top" style="font-size: 30px;"></span> <label>From: </br> <b><?php echo $address_order->froom; ?></b></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="track-title">
														<span class="ti-location-pin align-top" style="font-size: 30px;"></span> <label>To: </br> <b><?php echo $address_order->too; ?></b></label>
													</div>
												</div>
											</div>

										</div>

									</div>


									<?php

									$db->query("SELECT * FROM order_files where order_id='" . $track->order_id . "' ORDER BY date_file");
									$files_order = $db->registros();
									$numrows = $db->rowCount();


									if ($numrows > 0) {
									?>

										<div class="payment-wrap">
											<div class="row">
												<div class="col-md-12">
													<div class="track-title">
														<h5 class="form_sub" style="background-color: #2eca8b; color:white">Attached files</h5>
													</div>
												</div>

												<div class="table-responsive">
													<table id="zero_config" class="table table-sm">
														<thead>
															<tr>
																<th class="text-left"> <b> Nº </b></th>
																<th class="text-left"> <b> File </b></th>

															</tr>
														</thead>
														<tbody id="projects-tbl">

															<?php
															$count = 0;
															foreach ($files_order as $file) {

																$date_add = date("Y-m-d h:i A", strtotime($file->date_file));



																$count++;
															?>

																<tr class="">
																	<td><b><?php echo $count; ?></b></td>
																	<td> <b><a style="color:#7460ee;" target="_blank" href="<?php echo $file->url; ?>" class=""><?php echo $file->name; ?> </a> </b></td>

																</tr>
															<?php
															} ?>


														</tbody>
													</table>
												</div>
											</div>


										</div>

									<?php
									} ?>


									<!-- General Information -->
									<div class="payment-wrap">
										<div class="row">
											<div class="col-md-12">
												<div class="track-title">
													<h5 class="form_sub" style="background-color: #2eca8b; color:white">Sender / Reciever Information</h5>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="track-title">
													<label>Sender Name: <b><?php echo $sender_data->fname . " " . $sender_data->lname; ?></b></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="track-title">
													<label>Receiver Name: <b><?php echo $receiver_data->fname . " " . $receiver_data->lname; ?></b></label>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="track-title">
													<!-- <span class="ti-location-pin align-top" style="font-size: 30px;"></span> --> <label>Sender Address: <b><?php echo $address_order->sender_address; ?></b></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="track-title">
													<!-- <span class="ti-location-pin align-top" style="font-size: 30px;"></span> --> <label>Receiver Address: <b><?php echo $address_order->recipient_address; ?></b></label>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="track-title">
													<label>Sender Phone: <b><?php echo $sender_data->phone ?></b></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="track-title">
													<label>Receiver Phone: <b><?php echo $receiver_data->phone ?></b></label>
												</div>
											</div>
										</div>

									</div>
									<!--// General Information -->

									<!-- track shipment -->
									<div class="payment-wrap">
										<div class="row">
											<div class="col-md-12">
												<div class="track-title">
													<h5 class="form_sub" style="background-color: #2eca8b; color:white">Shipment Information</h5>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="track-title">
													<!-- <span class="ti-location-pin align-top" style="font-size: 30px;"></span>  --><label><?php echo $lang['track-shipment16'] ?>: <b><?php echo $address_order->recipient_city; ?></b></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="track-title">
													<!-- <span class="ti-location-pin align-top" style="font-size: 30px;"></span> <label> --><?php echo $lang['track-shipment17'] ?>: <b><?php echo $address_order->recipient_city; ?></b></label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="track-title">
													<!-- <span class="ti-calendar align-top" style="font-size: 30px;"></span> --> <label><?php echo $lang['track-shipment8'] ?>: <b><?php echo $track->order_date; ?></b></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="track-title">
														<!-- <span class="ti-timer align-top" style="font-size: 30px;"></span>  --><label><?php echo $lang['track-shipment9'] ?>: <b><?php if ($delivery_time != null) {
																																															echo $delivery_time->delitime;
																																														} ?></b></label>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="track-title">
													<label><?php echo $lang['track-shipment11'] ?>: <b><?php echo $row_item->order_item_quantity; ?></b></label>
												</div>
											</div>
											<!-- <div class="col-md-4">
												<div class="form-group">
													<div class="track-title">
														<label><//?php echo $lang['track-shipment12'] ?></br> <b><//?php echo $row->package; ?></b></label>
													</div>
												</div>
											</div> -->
											<div class="col-md-6">
												<div class="form-group">
													<div class="track-title">
														<label><?php echo $lang['track-shipment13'] ?>: <b><?php if ($sumador_libras > $sumador_volumetric) {
																												echo  round_out($sumador_libras);
																											} else {
																												echo round_out($sumador_volumetric);
																											} ?></b></label>
													</div>
												</div>
											</div>
										</div>


									</div>

								</div> <!-- /.user-profile-data -->
						</div> <!-- /.col- -->

					<?php endif; ?>


					</div> <!-- /.row -->

					<div class="row">

						<?php if (!$courier_track) : ?>
						<?php else : ?>
							<div class="col-lg-12">
								<br><br><br>
								<div class="booking-summary_block">
									<div class="booking-summary-box">
										<h5><?php echo $lang['track-shipment22'] ?></h5>
										<?php foreach ($courier_track  as $rows) : ?>
											<div class="track-cost track-title">
												<ul class="timeline a">
													<li class="event">
														<div class="row">

															<div class="col-md-2">
																<label for=""><b>Tracking ID:</b></label>
																<p class="text-left"><?php echo $track->order_prefix . $track->order_no; ?></p>
																<h4></h4>
															</div>
															<div class="col-md-2">
																<label for=""><b>Current Location:</b> </label>
																<?php

																if ($rows->t_dest != null) {
																	echo $rows->t_dest;
																} elseif ($rows->t_city != null) {
																	echo ', ' . $rows->t_city;
																} else {
																	echo $address_order->sender_country;
																}

																?>
																<h4></h4>
															</div>

															<!-- <div class="col-md-3">

															<button class="popup button4" onclick="mostrarMensaje('<?php echo $rows->id; ?>')">+ <?php echo $lang['left184'] ?>
																	<span class="popuptext" id="myPopup_<?php echo $rows->id; ?>"><?php echo $rows->comments; ?></span>
																</button>
															</div> -->

															<div class="col-md-3">
																<label for=""><b>Status:</b></label>
																<p class="text-left"><?php echo $rows->mod_style; ?></p>
																<h4></h4>
															</div>

															<div class="col-md-2">
																<label for=""><b>Time and Date:</b></label>
																<p class="text-left"><?php echo date('h:i:s a', strtotime($rows->t_date)); ?>/
																<p class="text-left"><?php echo date('Y/m/d', strtotime($rows->t_date)); ?></p>
																</p>
																<h4></h4>
															</div>

															<div class="col-md-3">
																<label for=""><b>Remarks:</b></label>
																<p class="text-left"><?php echo $rows->comments; ?></p>
																<h4></h4>
															</div>

														</div>
													</li>
													<!--event schedule 1 end-->
												</ul>
											</div>
										<?php endforeach; ?>
										<?php unset($row); ?>
									<?php endif; ?>
									</div>
								</div>
							</div>
					</div>

				</div> <!-- /.checkout-form -->
			</div> <!-- /.container -->
		</div>
		</div>
	</section>
	<!-- ERROR PAGE -->

	<!-- Back to top -->
	<a href="#" class="back-to-top rounded text-center" id="back-to-top">
		<i class="mdi mdi-chevron-up d-block"> </i>
	</a>
	<!-- Back to top -->

	<script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=light&autoMode=true" type="text/javascript"></script>


	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<!-- jQuery -->
	<script src="assets/vendor/jquery.2.2.3.min.js"></script>
	<!-- Popper js -->
	<script src="assets/vendor/popper.js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!-- menu  -->
	<script src="assets/vendor/mega-menu/assets/js/custom.js"></script>
	<!-- AOS js -->
	<script src="assets/vendor/aos-next/dist/aos.js"></script>
	<!-- WOW js -->
	<script src="assets/vendor/WOW-master/dist/wow.min.js"></script>
	<!-- js ui -->
	<script src="assets/vendor/jquery-ui/jquery-ui.min.js"></script>
	<!-- Select js -->
	<script src="assets/vendor/selectize.js/selectize.min.js"></script>
	<!-- owl.carousel -->
	<script src="assets/vendor/owl-carousel/owl.carousel.min.js"></script>


	<!-- javascript -->
	<script src="assets/theme_deprixa/js/bootstrap.bundle.min.js"></script>
	<script src="assets/theme_deprixa/js/jquery.easing.min.js"></script>
	<script src="assets/theme_deprixa/js/scrollspy.min.js"></script>
	<!-- SLIDER -->
	<script src="assets/theme_deprixa/js/owl.carousel.min.js"></script>
	<script src="assets/theme_deprixa/js/owl.init.js"></script>
	<!-- Main Js -->
	<script src="assets/theme_deprixa/js/app.js"></script>


	<!-- Theme js -->
	<script src="assets/js/theme.js"></script>
	</div> <!-- /.main-page-wrapper -->

	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
		var Tawk_API = Tawk_API || {},
			Tawk_LoadStart = new Date();
		(function() {
			var s1 = document.createElement("script"),
				s0 = document.getElementsByTagName("script")[0];
			s1.async = true;
			s1.src = 'https://embed.tawk.to/61850fd76885f60a50ba7519/default';
			s1.charset = 'UTF-8';
			s1.setAttribute('crossorigin', '*');
			s0.parentNode.insertBefore(s1, s0);
		})();
	</script>
	<!--End of Tawk.to Script-->
</body>

</html>