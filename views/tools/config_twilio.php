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



	if (!$user->is_Admin())
    redirect_to("login.php");
	
	$userData = $user->getUserData();

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title><?php echo $lang['tools-config61'] ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/intl-tel-input/css/intlTelInput.css">

    <link href="assets/css/style.min.css" rel="stylesheet">
	
	<link href="assets/css_log/front.css" rel="stylesheet" type="text/css">	
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.js"></script>
	<script src="assets/js/jquery.wysiwyg.js"></script>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/custom.js"></script>
	<link href="assets/customClassPagination.css" rel="stylesheet">


	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	</script>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
	
	
    <?php include 'views/inc/preloader.php'; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        
        <?php include 'views/inc/topbar.php'; ?>
        
        <!-- End Topbar header -->

        
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
 
        <?php include 'views/inc/left_sidebar.php'; ?>
        

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
			
			<!-- ============================================================== -->
			<!-- Start Page Content -->
			<!-- ============================================================== -->
			<div class="email-app">
			<!-- ============================================================== -->
			<!-- Left Part menu -->
			<!-- ============================================================== -->

                <?php include 'views/inc/left_part_menu.php'; ?>         

					<!-- ============================================================== -->
						<!-- Right Part contents-->
						<!-- ============================================================== -->
						<div class="right-part mail-list bg-white">
							<div class="p-15 b-b">
								<div class="d-flex align-items-center">
									<div>
										<span>Messaging with WhatsApp | Twilio</span>
									</div>
									
								</div>
							</div>
							<!-- Action part -->
							<!-- Button group part -->
							<div class="bg-light p-15">
								<div class="row justify-content-center">
									<div class="col-md-12">
										<div class="row">
											<div class="col-12">
												<!-- <div id="loader" style="display:none"></div> -->
												<div id="resultados_ajax"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Action part -->

							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="row">
										<!-- Column -->
										<div class="col-12">
											<div class="card-body">
												<!-- <div id="loader" style="display:none"></div> -->
												<!-- <div id="msgholder"></div> -->
												<form class="form-horizontal form-material" id="save_data" name="save_data" method="post">
													<header><b>Settings Twilio</b></header> <br><br>
													<section>
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="firstName1">Account SID</label>
																	<input type="text" class="form-control" name="twilio_sid" id="twilio_sid" placeholder="Account SID Twilio" value="<?php echo $core->twilio_sid;?>">
																</div>
															</div>
															
														</div>

														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="firstName1">Auth token</label>
																	<input type="text" class="form-control" name="twilio_token" id="twilio_token" placeholder="Auth token Twilio" value="<?php echo $core->twilio_token;?>">
																</div>
															</div>
															
														</div>

														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="firstName1">WhatsApp number</label>
																	<input type="text" class="form-control" name="phone_custom" id="phone_custom" placeholder="Example +14155238886" value="<?php echo $core->twilio_number;?>">
																	<span id="valid-msg" class="hide"></span>
                                                            <div id="error-msg" class="hide text-danger"></div>
																</div>
															</div>

                                                			<input type="hidden" name="twilio_number" id="twilio_number" value="<?php echo $core->twilio_number;?>"/>

															
														</div>
													</section>	
												
													<div class="form-group">
														<div class="col-sm-12">	
															<button class="btn btn-primary btn-confirmation" name="dosubmit" type="submit">Save settings <span><i class="icon-ok"></i></span></button>
															
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- Column -->
									</div>
								</div>
							</div>
			</div>	
 
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>
   

    <script src="assets/intl-tel-input/js/intlTelInput.js"></script>


    <script>


        errorMsg = document.querySelector("#error-msg");
        validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];


        var input = document.querySelector("#phone_custom");
        var iti = window.intlTelInput(input, {
          // allowDropdown: false,
          // autoHideDialCode: false,
          // autoPlaceholder: "off",
          // dropdownContainer: document.body,
          // excludeCountries: ["us"],
          // formatOnDisplay: true,
          geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
            });
          },
          // hiddenInput: "full_number",
          initialCountry: "auto",
          // localizedCountries: { 'de': 'Deutschland' },
          nationalMode: true,
          // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
          // placeholderNumberType: "MOBILE",
          // preferredCountries: ['cn', 'jp'],
          separateDialCode: true,
          utilsScript: "assets/intl-tel-input/js/utils.js",
        });




        var reset = function() {
          input.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
          reset();
          if (input.value.trim()) {

            if (iti.isValidNumber()) {

                $('#twilio_number').val(iti.getNumber());

              validMsg.classList.remove("hide");

            } else {

              input.classList.add("error");
              var errorCode = iti.getValidationError();
              errorMsg.innerHTML = errorMap[errorCode];
              errorMsg.classList.remove("hide");

            }
          }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);

    </script>

    <script>  	


		$( "#save_data" ).submit(function( event ) {
			var parametros = $(this).serialize();


			if (iti.isValidNumber()) {

				$.ajax({
						type: "POST",
						url: "ajax/tools/twilio_config_ajax.php",
						data: parametros,			
						 beforeSend: function(objeto){
							$("#resultados_ajax").html("send...");
						  },
						success: function(datos){
						$("#resultados_ajax").html(datos);

						$('html, body').animate({
				            scrollTop: 0
				        }, 600);

									
					  }
				});

			}else {

		      input.classList.add("error");
		      var errorCode = iti.getValidationError();
		      errorMsg.innerHTML = errorMap[errorCode];
		      errorMsg.classList.remove("hide");
		          $('#phone_custom').focus();


		    }
		  event.preventDefault();
			
		})

    </script>

</body>

</html>