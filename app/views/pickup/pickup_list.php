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
	$statusrow = $core->getStatus(); 

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
    <title><?php echo $lang['left5'] ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <link href="assets/css/style.min.css" rel="stylesheet">
	
	<link href="assets/css_log/front.css" rel="stylesheet" type="text/css">	
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.js"></script>
	<script src="assets/js/jquery.wysiwyg.js"></script>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/custom.js"></script>
	<link href="assets/customClassPagination.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <style type="text/css">
        .scrollable-menu {
            height: auto;
            max-height: 300px;
            overflow-x: hidden;
        }
    </style>


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
                        <h4 class="page-title"> <?php echo $lang['left5'];?></h4>
						 
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
								<!-- <div class="m-t-40">
									<div class="d-flex ">
										<div class="mr-auto">
											<div class="form-group">
												<a href="courier_add.php"><button type="button" class="btn btn-primary btn"><i class="ti-plus" aria-hidden="true"></i> <?php echo $lang['createnewship'] ?></button></a>
											</div>
										</div>
									</div>
								</div> -->
                                    <div class="row" >
                                        <div class=" col-sm-12 col-md-4  mt-3 offset-9">
                                        <?php if ($userData->userlevel==9 || $userData->userlevel==3) {?>
                                            <div class="form-group">
                                                <a href="pickup_add_full.php"><button type="button" class="btn btn-primary btn"><i class="ti-plus" aria-hidden="true"></i> <?php echo $lang['left77'] ?></button></a>
                                            </div> 


                                            <?php 

                                            }else{ ?>

                                             <div class="form-group">
                                                <a href="pickup_add.php"><button type="button" class="btn btn-primary btn"><i class="ti-plus" aria-hidden="true"></i> <?php echo $lang['left77'] ?></button></a>
                                            </div>
                                             <?php } ?>
 
                                        </div>
                                    </div>
                                <div class="row mb-3">

                                    <div class=" col-sm-12 col-md-3">

                                        <div class="input-group">
                                            <input type="text" name="search" id="search" class="form-control input-sm float-right" placeholder="search tracking"  onkeyup="load(1);">
                                            <div class="input-group-append input-sm">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                            </div>

                                        </div>  
                                    </div><!-- /.col -->

                                    <!-- <div class="col-sm-12 col-md-4">
                                        <div class="input-group">                                       
                                            <select onchange="load(1);" class="form-control custom-select" id="status_courier" name="status_courier" >
                                            <option value="0">--<?php echo $lang['left210'] ?>--</option>
                                            <?php foreach ($statusrow as $row):?>                                            
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->mod_style; ?></option>
                                                
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div> -->

                                                                        
                                </div>

                               
									
								<div class="outer_div"></div>




								
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

    <?php include('views/modals/modal_cancel_pickup.php'); ?>
         <?php include('views/modals/modal_send_email.php'); ?>
         <?php include('views/modals/modal_update_driver.php'); ?>

         <?php include('views/modals/modal_charges_list.php'); ?>
         <?php include('views/modals/modal_charges_add.php'); ?>
         <?php include('views/modals/modal_charges_edit.php'); ?>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->


        <script >        

        $( "#driver_update" ).submit(function( event ) {
            var parametros = $(this).serialize();

            $.ajax({
                    type: "POST",
                    url: "ajax/courier/courier_update_driver_ajax.php",
                    data: parametros,           
                     beforeSend: function(objeto){
                        $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                      },
                    success: function(datos){
                    $("#resultados_ajax").html(datos);

                    $('html, body').animate({
                        scrollTop: 0
                    }, 600);

                    $('#modalDriver').modal('hide');

                    load(1);

                                
                  }
            });
          event.preventDefault();
            
        })

    </script>

    <script>
        $('#modalDriver').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
           var id_shipment = button.data('id_shipment') // Extract info from data-* attributes
          var id_sender = button.data('id_sender') // Extract info from data-* attributes
          var modal = $(this)
            $('#id_shipment').val(id_shipment)
            $('#id_senderclient_driver_update').val(id_sender)
    


            })
    </script>  
    

   <script>
     $( "#send_email" ).submit(function( event ) {          
        
          $('#guardar_datos').attr("disabled", true);
          
         var parametros = $(this).serialize();
             $.ajax({
                    type: "GET",
                    url: "send_email_pdf.php",
                    data: parametros,
                     beforeSend: function(objeto){
                        $(".resultados_ajax_mail").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                      },
                    success: function(datos){
                    $(".resultados_ajax_mail").html(datos);
                    $('#guardar_datos').attr("disabled", false);
                    
                  }
            });
          event.preventDefault();
        
        })
     </script>
        <script>
        $('#myModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var order = button.data('order') // Extract info from data-* attributes
          var id = button.data('id') // Extract info from data-* attributes
          var email = button.data('email') // Extract info from data-* attributes
          var modal = $(this)
            $('#subject').val("Invoice # "+order)
            $('#id').val(id)
            $('#sendto').val(email)
        })
    </script>  



        <script>

             $( "#cancel_pickup_form" ).submit(function( event ) {          
                
                  $('#guardar_datos').attr("disabled", true);
                  
                 var parametros = $(this).serialize();
                     $.ajax({
                            type: "POST",
                            url: "ajax/pickup/pickup_cancel_ajax.php",
                            data: parametros,
                             beforeSend: function(objeto){
                                $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                              },
                            success: function(datos){
                            $("#resultados_ajax").html(datos);
                            $('#guardar_datos').attr("disabled", false);

                            $('#myModalCancel').modal('hide');
                            load(1);
                            
                          }
                    });
                  event.preventDefault();
                
                })

        </script>

        <script>

            $('#myModalCancel').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
             
              var id = button.data('id') // Extract info from data-* attributes
             
              var modal = $(this)
                $('#id_cancel').val(id)
            })
        </script> 




        <script>
        

$('#charges_list').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
    $('#order_id').val(id);
   
$(".resultados_ajax_charges_add_results").html('');

  load_charges(order_id);//Cargas los pagos 
    
})

function load_charges(){

     var id = $('#order_id').val();
     var parametros = {"id":id};
    $.ajax({

        url:'ajax/accounts_receivable/charges_list_ajax.php',
        data: parametros,       
        success:function(data){
            $(".resultados_ajax_charges_list").html(data).fadeIn('slow');           
        }
    });
}


$('#charges_add').on('show.bs.modal', function (event) {

  var id = $('#order_id').val();
  var parametros = {"id":id};

    $.ajax({
        url:'ajax/accounts_receivable/modal_add_charges.php',
        data: parametros,       
        success:function(data){
            $(".resultados_ajax_add_modal").html(data).fadeIn('slow');
        }
    });
})





$( "#add_charges" ).submit(function( event ) {
    var parametros = $(this).serialize();

    $.ajax({
            type: "POST",
            url: "ajax/accounts_receivable/add_charges_ajax.php",
            data: parametros,           
             beforeSend: function(objeto){
                $(".resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
              },
            success: function(datos){
            $(".resultados_ajax_charges_add_results").html(datos);

            $('#charges_add').modal('hide');
            load_charges();
            load(1);

                        
          }
    });
  event.preventDefault();
    
})



$('#charges_edit').on('show.bs.modal', function (event) {

  var id = $('#order_id').val();

  var button = $(event.relatedTarget) // Button that triggered the modal
  var id_charge = button.data('id_charge') 

  var parametros = {"id":id, 'id_charge':id_charge};

    $.ajax({
        url:'ajax/accounts_receivable/modal_edit_charges.php',
        data: parametros,       
        success:function(data){
            $(".resultados_ajax_add_modal_edit").html(data).fadeIn('slow');
        }
    });
})


$( "#edit_charges" ).submit(function( event ) {
    var parametros = $(this).serialize();

    $.ajax({
            type: "POST",
            url: "ajax/accounts_receivable/update_charges_ajax.php",
            data: parametros,           
             beforeSend: function(objeto){
                $(".resultados_ajax_charges_add_results").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
              },
            success: function(datos){
            $(".resultados_ajax_charges_add_results").html(datos);

            $('#charges_edit').modal('hide');
            load_charges();
            load(1);

                        
          }
    });
  event.preventDefault();
    
})



//Eliminar
    function delete_charge(id){

      // $('body').on('click',id, function () {
          // var id = $(this).attr('id').replace('item_', '')
          var parent = $('#item_'+id).parent().parent();
          var name = $(this).attr('data-rel');
          new Messi('<p class="messi-warning"><i class="icon-warning-sign icon-3x pull-left"></i>Are you sure you want to delete this record?<br /><strong>This action cannot be undone!!!</strong></p>', {
              title: 'Delete charge',
              titleClass: '',
              modal: true,
              closeButton: true,
              buttons: [{
                  id: 0,
                  label: 'Delete',
                  class: '',
                  val: 'Y'
              }],
                callback: function (val) {
                    if (val === 'Y') {
                        $.ajax({
                          type: 'post',
                          url:'./ajax/accounts_receivable/charge_delete_ajax.php',
                          data: {                                   
                              'id': id,                               
                          },
                          beforeSend: function () {
                              parent.animate({
                                  'backgroundColor': '#FFBFBF'
                              }, 400);
                          },
                          success: function (data) {
                              // parent.fadeOut(400, function () {
                              //     parent.remove();
                              // });
                              $('html, body').animate({
                                  scrollTop: 0
                              }, 600);
                              $('.resultados_ajax_charges_add_results').html(data);
                              // console.log(data);
                              load_charges();

                              load(1);
                          }
                        });
                    }
                }

          // });
      });       
    }

</script>
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
   
	<script src="dataJs/pickup.js"></script> 

</body>

</html>