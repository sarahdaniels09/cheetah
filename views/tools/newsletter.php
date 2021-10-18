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
	$userData = $user->getUserData();

	if (isset($_GET['email'])) {
		
		$email_template= getEmailTemplates(12);
	}else{

		$email_template= getEmailTemplates(4);
	}
	



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
    <link href="assets/css/style.min.css" rel="stylesheet">
	
	<link href="assets/css_log/front.css" rel="stylesheet" type="text/css">	
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.js"></script>
	<script src="assets/js/jquery.wysiwyg.js"></script>
	<script src="assets/js/global.js"></script>
	<script src="assets/js/custom.js"></script>
	<link href="assets/customClassPagination.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>

    <script src="assets/js/pages/email/email.js"></script>
	<script src="assets/libs/summernote/dist/summernote-bs4.min.js"></script>


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
                    <?php echo $lang['send-news1'] ?> <span><?php echo $lang['send-news2'] ?></span>
					 
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
							<form class="xform" id="send_email" name="send_email" method="post">						
								<div class="row">
									<section class="col col-6">
										<label class="input state-disabled">
											<input name="title" type="text" disabled="disabled" value="<?php echo $core->site_email;?>" placeholder="<?php echo $lang['send-news3'] ?>" readonly="readonly">
										</label>
										<div class="note"><?php echo $lang['send-news3'] ?></div>
									</section>
									<section class="col col-6">
										<?php 
										if(isset($_GET['email'])):
											?>

											
										<label class="input">
											<input name="recipient" type="text" value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>" placeholder="<?php echo $lang['send-news4'] ?>" readonly >
										</label>
										<?php
										 else:

										 	?>
										<select name="recipient"  class="form-control custom-select">
											<option value="all"><?php echo $lang['send-news5'] ?></option>
											<option value="newsletter"><?php echo $lang['send-news6'] ?></option>
										</select>
										<?php
										 endif;
										 ?>
										<div class="note"><?php echo $lang['send-news4'] ?></div>
									</section>
								</div>
								<div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-append icon-asterisk"></i>
											<input type="text" name="subject"  value="<?php echo $email_template->subject;?>" placeholder="<?php echo $lang['send-news7'] ?>">
										</label>
										<div class="note note-error"><?php echo $lang['send-news7'] ?></div>
									</section>
								</div>
								<hr />
								 <div class="row">
									<section class="col col-12">
										<div id="editor">
											<textarea name="body" id="summernote" style="margin-top: 30px;" placeholder="Type some text">
												<?php echo $email_template->body;?>
											</textarea>
										</div>
										<div class="label2 label-important"><?php echo $lang['send-news8'] ?> [ ]</div>
									</section>
								</div> 
								<footer>
									<button class="button" name="dosubmit" type="submit"><?php echo $lang['send-news9'] ?><span><i class="far fa-envelope"></i></span></button>								 				
								</footer>
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
   
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>


<script>

$("#send_email" ).submit(function(event) {
   
    var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "ajax/users/send_email_ajax.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#resultados_ajax").html("Enviando...");
              },
            success: function(datos){
            $("#resultados_ajax").html(datos);

            $("html, body").animate({
                scrollTop: 0
            }, 600);
            
          }
        });
  event.preventDefault();   
  
});
</script>




</body>

</html>


