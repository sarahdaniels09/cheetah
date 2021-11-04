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


	
	$userData = $user->getUserData();
	$office = $core->getOffices();

	if (!$user->is_Admin()){

		if ($_SESSION['userid']!=$_GET['user']){

	    	redirect_to("login.php"); 
		}	 
    }


	require_once('helpers/querys.php');

	if (isset($_GET['user'])) {
		$data= getUserEdit($_GET['user']);
	}

	if (!isset($_GET['user']) or $data['rowCount']!=1){
		redirect_to("users_list.php");
	}

	$row_user=$data['data'];


    $db->query("SELECT * FROM users_multiple_addresses WHERE user_id='".$_GET['user']."'"); 
    $user_addreses= $db->registros();

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

                <?php 
				if ($userData->userlevel == 9){

                	include 'views/inc/left_part_menu.php'; 

                	$right_part="right-part";
            	}else{
                	$right_part="";
            	}
                ?>         

					<!-- ============================================================== -->
						<!-- Right Part contents-->
						<!-- ============================================================== -->
						<div class="<?php echo $right_part; ?>  mail-list bg-white">
							<div class="p-15 b-b">
								<div class="d-flex align-items-center">
									<div>
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
						
<div class="row justify-content-center">
	<div class="col-lg-12">
		<!-- Row -->
		<div class="row">
			<!-- Column -->
			<div class="col-lg-4 col-xlg-3 col-md-5">
				<div class="card">
					<div class="card-body">
						<center class="m-t-30"> <img src="assets/<?php echo ($row_user->avatar) ? $row_user->avatar : "uploads/blank.png";?>" class="rounded-circle" width="150" />
							<h4 class="card-title m-t-10"><?php echo $row_user->fname;?> <?php echo $row_user->lname;?></h4>
							<h6 class="card-subtitle"><span><?php echo $lang['user_manage2'] ?> <i class="icon-double-angle-right"></i></span>  <div class="badge badge-pill badge-light font-16"><span class="ti-user text-warning"></span>	<?php echo $row_user->username;?></div></h6>
							<?php if ($userData->userlevel==9) {?>
								
							<h6 class="card-subtitle"><span>Sucursal <i class="icon-double-angle-right"></i></span>  <div class="badge badge-pill badge-light font-16">	<?php echo $row_user->name_off;?></div></h6>
						<?php }?>
						</center>
					</div>
					<div><hr> </div>
					<div class="card-body"> <small class="text-muted">Email </small>
						<h6><?php echo $row_user->email;?></h6> <small class="text-muted p-t-30 db">Phone</small>
						<h6><?php echo $row_user->phone;?></h6>
					</div>
					<div class="card-body row text-center">
						<div class="col-6 border-right">
							<h6><?php echo $row_user->created;?></h6>
							<span><?php echo $lang['user-account18'] ?></span>
						</div>
						<div class="col-6">
							<h6><?php echo $row_user->lastlogin;?></h6>
							<span><?php echo $lang['user-account19'] ?></span>
						</div>
					</div>
				</div>
			</div>
			<!-- Column -->
			<!-- Column -->
			<div class="col-lg-8 col-xlg-9 col-md-7">
				<div class="card">
					<!-- Tabs -->
					<ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Setting profile</a>
						</li>
					</ul>
					<!-- Tabs -->
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
							<div class="card-body">
							<div id="msgholder"></div>
								<form class="form-horizontal form-material" id="edit_user" name="edit_user" method="post">
									<section>
										<div class="row">
											<?php if($userData->userlevel == 9){?>
											<div class="col-md-12">
												<div class="form-group">
													<label for="firstName1">Office group</label>
													<input class="custom-select col-12"  name="branch_office" id="branch_office" list="browsers1" autocomplete="off" value="<?php echo $row_user->name_off; ?>" >
													<datalist id="browsers1">
														<?php foreach ($office as $off):?>
															<option value="<?php echo $off->name_off; ?>"><?php echo $off->name_off; ?></option>
														<?php endforeach;?>
													</datalist>
												</div>
											</div>
											<?php }else if($userData->userlevel == 2){?>
											<div class="col-md-12">
												<div class="form-group">
													<label for="firstName1">Office group</label>
													<input class="form-control"id="branch_office" name="branch_office" value="<?php echo $user->name_off; ?>" readonly>
												</div>
											</div>
											<?php } ?>	
											
											<div class="col-md-6">
												<div class="form-group">
													<label for="firstName1"><?php echo $lang['user_manage3'] ?></label>
													<input type="text" class="form-control" disabled="disabled" id="username"  name="username" readonly="readonly" value="<?php echo $row_user->username;?>" placeholder="<?php echo $lang['user_manage3'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="lastName1"><?php echo $lang['user_manage4'] ?></label>
													<input type="text" class="form-control" id="password" name="password" placeholder="<?php echo $lang['user_manage32'] ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage6'] ?></label>
													<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row_user->fname;?>" placeholder="<?php echo $lang['user_manage6'] ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage7'] ?></label>
													<input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row_user->lname;?>" placeholder="<?php echo $lang['user_manage7'] ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage5'] ?></label>
													<input type="text" class="form-control" id="email" name="email" value="<?php echo $row_user->email;?>" placeholder="<?php echo $lang['user_manage5'] ?>">
												</div>
											</div>
											<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phoneNumber1"><?php echo $lang['user_manage9'] ?></label>
                                                <input type="text" class="form-control" id="phone_custom" name="phone_custom" value="<?php echo $row_user->phone;?>" placeholder="<?php echo $lang['user_manage9'] ?>">
                                                <span id="valid-msg" class="hide"></span>
                                                            <div id="error-msg" class="hide text-danger"></div>
                                            </div>
                                        </div>
											
										</div>
										<div class="row">
											
											<div class="col-md-6">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage11'] ?></label>
													<select class="custom-select form-control" id="gender" name="gender" value="<?php echo $row_user->gender;?>" placeholder="<?php echo $lang['user_manage11'] ?>">
														<option value="Male"<?php if($row_user->gender =='Male'){echo 'selected';}?>>Male</option>
														<option value="Female" <?php if($row_user->gender =='Female'){echo 'selected';}?>>Female</option>
														<option value="Other" <?php if($row_user->gender =='Other'){echo 'selected';}?>>Others</option>
													</select>
												</div>
											</div>
                							<?php if($row_user->userlevel == 9 || $row_user->userlevel == 2){?>               

											<div class="col-md-6">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage15'] ?></label>
													<select class="custom-select form-control"  id="userlevel" name="userlevel">
														<?php echo $user->getUserLevels($row_user->userlevel);?>
													</select>
												</div>
											</div>

											<?php
							                }
							                ?>

							                <div class="col-md-6">
															<div class="form-group">
																<label for="lastName1"><?php echo $lang['user_manage24'] ?></label>
																<input class="form-control" name="avatar" id="avatar" type="file" />
															</div>
														</div>


										</div>
										<hr>
                                    <h4>Addresses</h4>
                                    <br>


                                    <?php

                                    $count=0;

                                    foreach ($user_addreses as $row_for){

                                    $count++;

                                    ?>
                                    <div id="div_parent_<?php echo $count; ?>">

                                    <?php if($count>1){echo '<hr>'; } ?>

                                    <h4><?php echo $lang['laddress'];  if($count>0){echo ' '.$count;} ?> </h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phoneNumber1"><?php echo $lang['user_manage10'] ?></label>
                                                <input type="text" class="form-control" name="address[]"  id="address<?php echo $count;?>"placeholder="<?php echo $lang['user_manage10'] ?>" value="<?php echo $row_for->address;?>">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="emailAddress1"><?php echo $lang['user_manage12'] ?></label>
                                                <input type="text" class="form-control" name="country[]"  id="country<?php echo $count;?>" placeholder="<?php echo $lang['user_manage12'] ?>" value="<?php echo $row_for->country;?>" >
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phoneNumber1"><?php echo $lang['user_manage13'] ?></label>
                                                <input type="text" class="form-control" id="city<?php echo $count;?>" name="city[]" placeholder="<?php echo $lang['user_manage13'] ?>" value="<?php echo $row_for->city;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phoneNumber1"><?php echo $lang['user_manage14'] ?></label>
                                                <input type="text" class="form-control" name="postal[]" id="postal<?php echo $count;?>" placeholder="<?php echo $lang['user_manage14'] ?>" value="<?php echo $row_for->zip_code;?>">
                                            </div>
                                        </div>
                                    </div>

                                    <?php 

                                    if($count>1){ ?>

                                    <div align="right" class="col-md-12">
                                        <button type="button" name="remove_row" id="<?php echo $count;?>" class="btn btn-danger   remove_row mt-2 mb-3"><span class="fa fa-trash"></span> <?php echo $lang['delete_address_recepient'] ?></button>
                                    </div>
                                    </div>
                                    <?php
                                     }

                                     }

                                    ?>

                                    <input type="hidden" name="total_address" id="total_address" value="<?php echo $count;?>" />
                                    <input type="hidden" name="phone" id="phone" value="<?php echo $row_user->phone;?>" />

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
															<input type="radio" id="customRadio4" class="custom-control-input" name="active" value="1" <?php getChecked($row_user->active, "1"); ?>>
															<label class="custom-control-label" for="customRadio4"> <?php echo $lang['user_manage16'] ?></label>
															</div>
														</label>
														<label class="btn">
															<div class="custom-control custom-radio">
															<input type="radio" id="customRadio3" class="custom-control-input" name="active" value="0" <?php getChecked($row_user->active, "0"); ?>>
															<label class="custom-control-label" for="customRadio3"> <?php echo $lang['user_manage17'] ?></label>
															</div>
														</label>
														
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="phoneNumber1"><?php echo $lang['user_manage23'] ?></label>
													<div class="btn-group" data-toggle="buttons">
														<label class="btn">
															<div class="custom-control custom-radio">
																<input type="radio" id="customRadio4" name="newsletter" value="1" <?php getChecked($row_user->newsletter, 1); ?> class="custom-control-input">
																<label class="custom-control-label" for="customRadio4"> <?php echo $lang['tools-config14'] ?></label>
															</div>
														</label>
														<label class="btn">
															<div class="custom-control custom-radio">
																<input type="radio" id="customRadio5" name="newsletter" value="0" <?php getChecked($row_user->newsletter, 0); ?> class="custom-control-input">
																<label class="custom-control-label" for="customRadio5"> <?php echo $lang['tools-config15'] ?></label>
															</div>
														</label>
													</div>
												</div>
											</div>
										</div>
										
										
										
										<hr />
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="emailAddress1"><?php echo $lang['user_manage28'] ?></label>
													<textarea class="form-control" id="notes" name="notes" rows="6"  name="notes" placeholder="<?php echo $lang['user_manage31'] ?>"><?php echo $row_user->notes;?></textarea>
												</div>
											</div>
										</div>

									</section>
									<div class="form-group">
										<div class="col-sm-12">	
											<button class="btn btn-outline-primary btn-confirmation" name="dosubmit" type="submit"><?php echo $lang['user-account20'] ?><span><i class="icon-ok"></i></span></button>
											<a href="users_list.php" class="btn btn-outline-secondary btn-confirmation"><span><i class="ti-share-alt"></i></span> <?php echo $lang['user_manage30'] ?></a>
										</div>
										<!-- <input name="username" type="hidden" value="<?php echo $row_user->username;?>" /> -->
										<input id="id" name="id" type="hidden" value="<?php echo $row_user->id;?>" />
									</div>
								</form>
							</div>
						</div>
					</div>
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

        var count = <?php echo $count;?> ;
                            
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

$( "#edit_user" ).submit(function( event ) {

                    
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
		<?php if($row_user->userlevel == 9 || $row_user->userlevel == 2){?>               

		 var userlevel = $('#userlevel').val();
		<?php
        }
        ?>
		 // var active = $('#active').val();
		 var password = $('#password').val();
		 var notify = $('#notify:checked').val();
		 var active = $('input:radio[name=active]:checked').val();
		 var newsletter = $('input:radio[name=newsletter]:checked').val();
	     var total_address = $('#total_address').val();
		 var id = $('#id').val();

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

        <?php if($row_user->userlevel == 9 || $row_user->userlevel == 2){?>               

		data.append('userlevel',userlevel);	

		<?php
        }
        ?>
		data.append('active',active);	
		data.append('newsletter',newsletter);	
		data.append('notes',notes);	
		data.append('notify',notify);	
	    data.append('total_address',total_address);
		data.append('id',id);	
	 

        

      for (var a of address) { data.append('address[]', a.value); }
      for (var c of country) { data.append('country[]', c.value); }
      for (var ci of city) { data.append('city[]', ci.value); }
      for (var p of postal) { data.append('postal[]', p.value); }
      
        $.ajax({

           type: "POST",
            url: "ajax/users/users_edit_ajax.php",
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