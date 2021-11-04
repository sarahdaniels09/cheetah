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
	$office = $core->getOffices(); 

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
			
			 <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <span><?php echo $lang['tools-config61'] ?> | User List</span>
						 
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


            <div class="container-fluid">

            	<div class="row">
					<!-- Column -->

					<div class="col-lg-12 col-xl-12 col-md-12">

						<div class="card">
							<div class="card-body">


								<form class="form-horizontal form-material" id="save_user" name="save_user" method="post">
									<section>
										<header><?php echo $lang['user_manage1'] ?> <span><?php echo $lang['user_manage37'] ?></span></header>
										<br>
										<br>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="firstName1">Branch Offices</label>
													<select class="custom-select col-12" id="branch_office" name="branch_office" placeholder="Branch Offices">
													<?php foreach ($office as $row):?>
														<option value="<?php echo $row->name_off; ?>"><?php echo $row->name_off; ?></option>
													<?php endforeach;?>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="firstName1"><?php echo $lang['user_manage3'] ?></label>
													<input type="text" class="form-control"  name="username" id="username" placeholder="<?php echo $lang['user_manage3'] ?>">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="lastName1"><?php echo $lang['user_manage32'] ?></label>
													<input type="text" class="form-control" name="password" id="password" placeholder="<?php echo $lang['user_manage32'] ?>">
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage6'] ?></label>
													<input type="text" class="form-control" name="fname" id="fname" placeholder="<?php echo $lang['user_manage6'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage7'] ?></label>
													<input type="text" class="form-control" id="lname" name="lname" placeholder="<?php echo $lang['user_manage7'] ?>">
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage5'] ?></label>
													<input type="text" class="form-control" id="email" name="email" placeholder="<?php echo $lang['user_manage5'] ?>">
												</div>
											</div>
											
											<div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="phoneNumber1"><?php echo $lang['user_manage9'] ?></label>
	                                            <input type="tel" class="form-control" name="phone_custom" id="phone_custom" placeholder="<?php echo $lang['user_manage9'] ?>">

	                                            <span id="valid-msg" class="hide"></span>
	                                            <div id="error-msg" class="hide text-danger"></div>
	                                        </div>
	                                    </div>
										</div>
										
										<div class="row">
											
											<div class="col-md-6">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage11'] ?></label>
													<select class="custom-select form-control" name="gender"  id="gender" placeholder="<?php echo $lang['user_manage11'] ?>">
														<option value="" >Choose option</option>
														<option value="Male">Male</option>
														<option value="Female">Female</option>
														<option value="Other">Other</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage15'] ?></label>
													<select class="custom-select form-control" id="userlevel" name="userlevel">
														<?php echo $user->getUserLevels();?>
													</select>
												</div>
											</div>
										</div>
										
										<hr>
	                                <h4>Addresses</h4>
	                                <br>
	                                
	                                <h4><?php echo $lang['laddress'] ?> 1 </h4>
	                                
	                                <div class="row">

	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="phoneNumber1"><?php echo $lang['user_manage10'] ?></label>
	                                            <input type="text" class="form-control" name="address[]"  id="address1"placeholder="<?php echo $lang['user_manage10'] ?>">
	                                        </div>
	                                    </div>

	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="emailAddress1"><?php echo $lang['user_manage12'] ?></label>
	                                            <input type="text" class="form-control" name="country[]"  id="country1" placeholder="<?php echo $lang['user_manage12'] ?>">
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="phoneNumber1"><?php echo $lang['user_manage13'] ?></label>
	                                            <input type="text" class="form-control" id="city1" name="city[]" placeholder="<?php echo $lang['user_manage13'] ?>">
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="phoneNumber1"><?php echo $lang['user_manage14'] ?></label>
	                                            <input type="text" class="form-control" name="postal[]" id="postal1" placeholder="<?php echo $lang['user_manage14'] ?>">
	                                        </div>
	                                    </div>

	                                </div>

	                                <input type="hidden" name="total_address" id="total_address" value="1" />
	                                <input type="hidden" name="phone" id="phone" />

	                                <div id="div_address_multiple"></div>

	                                <div align="left">
	                                    <button type="button" name="add_row" id="add_row" class="btn btn-success mb-2"><span class="fa fa-plus"></span> <?php echo $lang['add_address_recepient'] ?></button>
	                                </div>
	                                
	                                <hr>

										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage20'] ?></label>
													<div class="inline-group">
														<label class="btn">
															<div class="custom-control custom-radio">
															<input type="radio" id="customRadio2" class="custom-control-input" name="active" value="1" checked="checked">
															<label class="custom-control-label" for="customRadio2"> <?php echo $lang['user_manage16'] ?></label>
															</div>
														</label>
														<label class="btn">
															<div class="custom-control custom-radio">
															<input type="radio" id="customRadio1" class="custom-control-input" name="active" value="0">
															<label class="custom-control-label" for="customRadio1"> <?php echo $lang['user_manage17'] ?></label>
															</div>
														</label>
														
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage23'] ?></label>
													<div class="btn-group" data-toggle="buttons">
														<label class="btn">
															<div class="custom-control custom-radio">
																<input type="radio" id="customRadio4" name="newsletter" value="1" checked="checked" class="custom-control-input">
																<label class="custom-control-label" for="customRadio4"> <?php echo $lang['user_manage21'] ?></label>
															</div>
														</label>
														<label class="btn">
															<div class="custom-control custom-radio">
																<input type="radio" id="customRadio5" name="newsletter" value="0" class="custom-control-input">
																<label class="custom-control-label" for="customRadio5"> <?php echo $lang['user_manage22'] ?></label>
															</div>
														</label>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="lastName1"><?php echo $lang['user_manage24'] ?></label>
													<input class="form-control" name="avatar" id="avatar" type="file" />
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" name="notify"  id="notify" value="1">
														<i></i><?php echo $lang['edit-clien34'] ?>
														<span class="custom-control-indicator"></span><br><br>
														<label><span><i class="ti-email" style="color:#6610f2"></i>&nbsp; <?php echo $lang['edit-clien35'] ?></span></label>
													</label>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage36'] ?></label>
													<textarea class="form-control" id="notes" name="notes" rows="6"  name="notes" placeholder="<?php echo $lang['user_manage36'] ?>"></textarea>
												</div>
											</div>
										</div>
										
									</section>
									<div class="form-group">
										<div class="col-sm-12">										
											<button class="btn btn-outline-primary btn-confirmation" id="save_data" name="save_data" type="submit"><?php echo $lang['user_manage37'] ?><span><i class="icon-ok"></i></span></button>
											<a href="users_list.php" class="btn btn-outline-secondary btn-confirmation"><span><i class="ti-share-alt"></i></span> <?php echo $lang['user_manage30'] ?></a> 
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- Column -->
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

                $('#phone').val(iti.getNumber());

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

    $(document).ready(function(){

        var count = 1;
                            
        $(document).on('click', '#add_row', function(){

            count++;

            $('#total_address').val(count);        

            var html_code = '';
            var parent=  $('#div_parent_'+count);



            html_code += '<div id="div_parent_'+count+'">';
            html_code +='<hr>'; 

            html_code += '<h4><?php echo $lang['laddress'] ?> '+count+'</h4>';


            html_code += '<div class="row">';

            html_code +='<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label for="phoneNumber1"><?php echo $lang['user_manage10'] ?></label>'+
                                '<input type="text" class="form-control" name="address[]"  id="address'+count+'"placeholder="<?php echo $lang['user_manage10'] ?>">'+
                            '</div>'+
                        '</div>';

             html_code += '<div class="col-md-6">'+
                            '<div class="form-group">'+
                                '<label for="emailAddress1"><?php echo $lang['user_manage12'] ?></label>'+
                                '<input type="text" class="form-control" name="country[]"  id="country'+count+'" placeholder="<?php echo $lang['user_manage12'] ?>">'+
                            '</div>'+
                        '</div>';


            html_code +='</div>';


            html_code += '<div class="row">';

            html_code +='<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label for="phoneNumber1"><?php echo $lang['user_manage13'] ?></label>'+
                        '<input type="text" class="form-control" id="city'+count+'" name="city[]" placeholder="<?php echo $lang['user_manage13'] ?>">'+
                    '</div>'+
                '</div>';

            html_code +='<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label for="phoneNumber1"><?php echo $lang['user_manage14'] ?></label>'+
                        '<input type="text" class="form-control" name="postal[]" id="postal'+count+'" placeholder="<?php echo $lang['user_manage14'] ?>">'+
                    '</div>'+
                '</div>';

            html_code +='</div>';

            html_code += '<div class="row pull-">';
            html_code += '<div align="right" class="col-md-12">'+
                '<button type="button" name="remove_row" id="'+count+'" class="btn btn-danger   remove_row mt-2 mb-3"><span class="fa fa-trash"></span> <?php echo $lang['delete_address_recepient'] ?></button>'+
            '</div>';

            html_code +='</div>';


            html_code +='</div>'; //div parent

            

            $('#div_address_multiple').append(html_code);

            


         
            
         
        });



        $(document).on('click', '.remove_row', function(){

            var row_id = $(this).attr("id");
            var parent=  $('#div_parent_'+row_id);
           
               

          count--;
          parent.fadeOut(400, function () {

          $('#div_parent_'+row_id).remove();

          });
            $('#total_address').val(count);

        });


    });


//Registro de datos

$( "#save_user" ).submit(function( event ) {

                    
    var count = $('#total_address').val();
    var validate= 0;

    for(var no=1; no<=count; no++){

        if($.trim($('#address'+no).val()).length == 0)
        {
          alert("Please enter address");
          $('#address'+no).focus();
            
            return false;
        }


        if($.trim($('#country'+no).val()).length == 0)
        {
          alert("Please enter country");
          $('#country'+no).focus();
            
            return false;
        }

        if($.trim($('#city'+no).val()).length == 0)
        {
          alert("Please enter city");
          $('#city'+no).focus();
            
            return false;
        }

        if($.trim($('#postal'+no).val()).length == 0)
        {
          alert("Please enter zip code");
          $('#postal'+no).focus();
            
            return false;
        }            

    }


    // if(validate==0){
    if (iti.isValidNumber()) {


    	$('#save_data').attr("disabled", true);
		 var inputFileImage = document.getElementById("avatar");
		 var username = $('#username').val();
		 var branch_office = $('#branch_office').val();
		 var email = $('#email').val();
		 var fname = $('#fname').val();
		 var lname = $('#lname').val();
		 // var newsletter = $('#newsletter').val();
		 var notes = $('#notes').val();
		 var phone = $('#phone').val();
		 var gender = $('#gender').val();
		 var userlevel = $('#userlevel').val();
		 // var active = $('#active').val();
		 var password = $('#password').val();
		 var notify = $('#notify:checked').val();
		 var active = $('input:radio[name=active]:checked').val();
		 var newsletter = $('input:radio[name=newsletter]:checked').val();
	     var total_address = $('#total_address').val();

	      var address = document.getElementsByName('address[]');
         var country = document.getElementsByName('country[]');
         var city = document.getElementsByName('city[]');
         var postal = document.getElementsByName('postal[]');

		var file = inputFileImage.files[0];
		var data = new FormData();

		data.append('avatar',file);	
		data.append('branch_office',branch_office);	
		data.append('username',username);	
		data.append('password',password);	
		data.append('fname',fname);	
		data.append('lname',lname);	
		data.append('email',email);	
		data.append('phone',phone);	
		data.append('gender',gender);	
		data.append('userlevel',userlevel);	
		data.append('active',active);	
		data.append('newsletter',newsletter);	
		data.append('notes',notes);	
		data.append('notify',notify);	
	    data.append('total_address',total_address);
	 

        

      for (var a of address) { data.append('address[]', a.value); }
      for (var c of country) { data.append('country[]', c.value); }
      for (var ci of city) { data.append('city[]', ci.value); }
      for (var p of postal) { data.append('postal[]', p.value); }
      
        $.ajax({

           type: "POST",
            url: "ajax/users/users_add_ajax.php",
            data: data,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,           
             beforeSend: function(objeto){
                $("#resultados_ajax").html("Send...");
              },
            success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#save_data').attr("disabled", false);

            $('html, body').animate({
                scrollTop: 0
            }, 600);

            // window.setTimeout(function() {
            // $(".alert").fadeTo(500, 0).slideUp(500, function(){
            // $(this).remove();});}, 5000);                
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