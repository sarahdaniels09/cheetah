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
	$statusrow = $core->getStatus(); 
    $paymethodrow = $core->getPaymentMethod();


    // var_dump($_POST);

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
    <title>List of accounts receivable</title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <link href="assets/css/style.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="assets/select2/select2.min.css"> -->
      <link rel="stylesheet" type="text/css" href="assets/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="assets/jquery-ui.css" type="text/css" />

	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
	
	<link href="assets/css_log/front.css" rel="stylesheet" type="text/css">	
	<script src="assets/js/jquery.ui.touch-punch.js"></script>
	<script src="assets/js/jquery.wysiwyg.js"></script>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/custom.js"></script>
	<link href="assets/customClassPagination.css" rel="stylesheet">
    <!--    daterangerpicker-master 
 --> 
  <link rel="stylesheet" href="assets/daterangepicker-master/daterangepicker.css">
  <script src="assets/daterangepicker-master/moment.min.js"></script>
  <script src="assets/daterangepicker-master/daterangepicker.js"></script>


    <style type="text/css">
        .scrollable-menu {
            height: auto;
            max-height: 300px;
            overflow-x: hidden;
        }
    </style>

<!-- 
	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	</script> -->
    <script>
        $(function() {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
                NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
            });
        });
    </script>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
	<?php $agencyrow = $core->getBranchoffices(); ?>

	
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
                        <h4 class="page-title"> List of accounts receivable</h4>
						 
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
							<div class="card-body" >
								
                                    <div class="row mb-5">
                                        <div class="col-md-3 col-sm-12">
                                            <!-- <div class="form-group"> -->
                                                <div class="btn-group mt-2 hide" id="div-actions-checked">
									               <span class="mt-2 mr-4"><strong id="countChecked"> Selected: 0</strong></span>
                                                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Selected actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a  class="dropdown-item"  href="#" data-toggle="modal" data-target="#modalCheckboxStatus"><i style="color:#20c997" class="ti-reload"></i>&nbsp;Edit Status</a>

                                                        <a class="dropdown-item" onclick="printMultipleLabel();" target="_blank"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toollabel'] ?> </a>

                                                     
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                                
                                        </div>

                                       

                                    </div>
                                            <!-- <span id="countChecked">0</span> -->

                                <div class="row mb-3 ml-2">

                                    <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                                <input type="text" name="daterange" id="daterange" class="form-control float-right" >                                      
                                            </div>  
                                        
                                    </div>    

                                    <div class=" col-sm-12 col-md-3">

                                        <div class="input-group">
                                            <input type="text" name="search" id="search" class="form-control input-sm float-right" placeholder="search tracking"  onkeyup="load(1);">
                                            <div class="input-group-append input-sm">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                            </div>

                                        </div>  
                                    </div><!-- /.col -->

                                   


                                    <div class="col-md-3">
                                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;"  id="customer_id" name="customer_id"  onchange="load(1);">
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-3">
                                        <div class="input-group"> 
                                            <select onchange="load(1);" class="form-control custom-select" id="agency_courier"   name="agency_courier" >
                                      
                                           <option value="0">--<?php echo $lang['left202'] ?>--</option>
                                            <?php foreach ($agencyrow as $row):?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name_branch; ?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>


                                    

                                                                        
                                </div>

    								<div class="outer_div"></div>                            

								
							</div>
						</div>
					</div>
					<!-- Column -->
				</div>
            </div>

        <?php 
        include('views/modals/modal_update_status_checked.php'); 
        ?>
         <?php include('views/modals/modal_charges_list.php'); ?>
         <?php include('views/modals/modal_charges_add.php'); ?>
         <?php include('views/modals/modal_charges_edit.php'); ?>
        
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

    <!-- <script src="assets/select2/select2.full.min.js"></script> -->

	<script src="dataJs/accounts_receivable.js"></script> 

    <script src="assets/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/select2/dist/js/select2.min.js"></script>

    <script type="text/javascript">

        function soloNumeros(e){
        var key = e.charCode;
        return key >= 44 && key <= 57;
    }
</script>
    
</body>

</html>