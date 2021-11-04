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
    <title>Pre Alerts | <?php echo $core->site_name ?></title>
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
    <link rel="stylesheet" href="assets/bootstrap-datetimepicker.min.css">


	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	</script>

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
        <?php $courierrow = $core->getCouriercom(); ?>

        

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
			
			
            <div class="container-fluid">

            	<!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            
                            <div class="">
                                    <div class="row">
                                        <div class="col-lg-12 mx-auto text-center">
                                            <h2 class="h1 text-danger">
                                                <?php echo $lang['left56'] ?>
                                            </h2>
                                            <div class="u-h-4 u-w-50 bg-primary rounded mt-4 u-mb-40 mx-auto"></div>
                                            <p>
                                                <?php echo $lang['left57'] ?>
                                            </p>
                                        </div>
                                    </div> <!-- END row-->
                                    <div id="resultados_ajax"></div>
                                    <div class="">
                                        <div class="col-lg-12 ml-auto mt-8 mb-8">
                                            <form  method="post" accept-charset="utf-8" name="form_prealert" id="form_prealert">
                                                
                                                
                                                <div class="row">
                                                     
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ReceiptKind"><strong><?php echo $lang['add-title15'] ?></strong></label>
                                                            <div class="input-group">
                                                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                                    <div class="input-group-text">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                                <input type='text' class="form-control" name="date_prealert" id="date_prealert" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>" readonly / value="<?php echo date('Y-m-d'); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ReceiptKind"><strong><?php echo $lang['add-title18'] ?></strong></label>
                                                           
                                                            <select class="form-control custom-select" name="courier_prealert" id="courier_prealert">
                                                                <option value="">--<?php echo $lang['left204'] ?>--</option>

                                                                <?php foreach ($courierrow as $row):?>
                                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name_com; ?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 nondoc">
                                                        <div class="form-group">
                                                            <label for="sum2"><i class="fa fa-cube mr-1"></i><strong> <?php echo $lang['left63'] ?></strong></label>
                                                            <input  type="text" class="form-control add-listing_form" name="tracking_prealert" id="tracking_prealert" placeholder="Example: 009785454545554">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ReceiptKind"><strong><?php echo $lang['left64'] ?></strong></label>
                                                            <input type="text" class="form-control add-listing_form" name="provider_prealert" id="provider_prealert"  placeholder="<?php echo $lang['left65'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 nondoc">
                                                        <div class="form-group">
                                                            <label for="sum2"><strong><?php echo $core->currency;?> <?php echo $lang['left66'] ?></strong></label>
                                                            <input  type="text" onkeypress="return soloNumeros(event)"  class="form-control add-listing_form" name="price_prealert" id="price_prealert" placeholder="<?php echo $lang['left67'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12 nondoc">
                                                        <div class="form-group">
                                                            <label for="sum2"><strong><?php echo $lang['left68'] ?></strong></label>
                                                            <textarea class="form-control" rows="2" name="description_prealert" id="description_prealert" placeholder="<?php echo $lang['left69'] ?>"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">                                

                                                    <div class="col-md-12">                             

                                                       <div>
                                                            <label class="control-label" id="selectItem" > Attach invoice</label>
                                                        </div>

                                                        <input class="custom-file-input" id="filesMultiple" name="filesMultiple" type="file"  style="display: none;" onchange="validateZiseFiles();" accept="image/*,.pdf"/>
                                                         
                                                         
                                                        <button type="button" id="openMultiFile" class="btn btn-default  pull-left "> <i class='fa fa-paperclip' id="openMultiFile" style="font-size:18px; cursor:pointer;"></i> Upload invoice </button>

                                                        <div id="clean_files" class="hide">     
                                                         <button type="button" id="clean_file_button" class="btn btn-danger ml-3"> <i class='fa fa-trash' style="font-size:18px; cursor:pointer;"></i> Cancel attachments </button>
                                                        
                                                        </div>

                                                    </div>                     
                                                </div> 
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <br>
                                                            <div class="pull-right">

                                                                 <a href="prealert_list.php" class="btn btn-secondary btn-confirmation"><span><i class="ti-share-alt"></i></span> back to list</a>
                                                                <button type="submit" name="create_prealert"  id="create_prealert" class=" ml-2 btn  btn-success btn-confirmation pull-right" ><i class="mdi mdi-bell mr-1"></i> <?php echo $lang['left70'] ?></button>
                                                            </div>  
                                                    </div>
                                                </div>  
                                            </form> 
                                        </div>

                                         
                                    </div> <!-- END     row-->

                                   <hr class="u-my-60">
                            </div> <!-- END container-->
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
    <!-- <script src="assets/js/app.init.js"></script> -->
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
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>

    <script>
    $(document).ready(function() {

        $('#date_prealert').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });

    </script>


    <script>
    function validateZiseFiles(){

    var inputFile = document.getElementById('filesMultiple');
    var file = inputFile.files;

        var size =0;
        console.log(file);

        for(var i = 0; i < file.length; i ++){

            var filesSize = file[i].size;

            if(size > 5242880){               

                $('.resultados_file').html("<div class='alert alert-danger'>"+
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
                        "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>"+
                        
                    "</div>"
                );
            }else{
                $('.resultados_file').html("");
            }

            size+=filesSize;
        }

        if(size > 5242880){ 
            $('.resultados_file').html("<div class='alert alert-danger'>"+
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
                        "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>"+
                        
                    "</div>"
                );

            return true;

        }else{
                $('.resultados_file').html("");

            return false;
        }          

}
</script>

<script>
        
          $('#openMultiFile').click(function(){

    $("#filesMultiple").click();
  });


  $('#clean_file_button').click(function(){

    $("#filesMultiple").val('');

    $('#selectItem').html('Attach files');

    $('#clean_files').addClass('hide');


  });



  $('input[type=file]').change(function(){

    var inputFile = document.getElementById('filesMultiple');
    var file = inputFile.files;
    var contador = 0;
    for(var i=0; i<file.length; i++){

        contador ++;
    }
    if(contador>0){

        $('#clean_files').removeClass('hide');
    }else{

        $('#clean_files').addClass('hide');

    }

    $('#selectItem').html('attached files ('+contador+')');
  });
</script>



<script>
    
    //Registro de datos

$( "#form_prealert" ).submit(function( event ) {

    $('#create_prealert').attr("disabled", true);

     var filesMultiple = document.getElementById("filesMultiple");
     var date_prealert = $('#date_prealert').val();
     var tracking_prealert = $('#tracking_prealert').val();
     var provider_prealert = $('#provider_prealert').val();
     var description_prealert = $('#description_prealert').val();
     var price_prealert = $('#price_prealert').val();
     var courier_prealert = $('#courier_prealert').val();
     

    var file = filesMultiple.files[0];
    var data = new FormData();

    data.append('file_invoice',file);   
    data.append('date_prealert',date_prealert); 
    data.append('tracking_prealert',tracking_prealert); 
    data.append('provider_prealert',provider_prealert); 
    data.append('description_prealert',description_prealert); 
    data.append('price_prealert',price_prealert); 
    data.append('courier_prealert',courier_prealert); 




    $.ajax({
        type: "POST",
        url: "ajax/pre_alerts/prealert_add_ajax.php",
        data: data,
        contentType: false,
        cache: false,
        processData:false,

         beforeSend: function(objeto){
            $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
          },

        success: function(datos){

        $("#resultados_ajax").html(datos);
        $('#create_prealert').attr("disabled", false);

        $('html, body').animate({
            scrollTop: 0
        }, 600);

        // $("#form_prealert")[0].reset();

        // window.setTimeout(function() {
        // $(".alert").fadeTo(500, 0).slideUp(500, function(){
        // $(this).remove();});}, 5000);                
      }
    });

    event.preventDefault();
    
})

</script>

<script type="text/javascript">

    function soloNumeros(e){
    var key = e.charCode;
    return key >= 44 && key <= 57;
}
</script>
</body>

</html>