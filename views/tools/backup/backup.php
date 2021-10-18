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
										<span><?php echo $lang['tools-config61'] ?> | Backups</span>
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
												<?php												 
												  
												  if (isset($_GET['backupok']) && $_GET['backupok'] == "1"){
												  	?>

												  	<div class="alert alert-info" id="success-alert">
									                    <p><span class="icon-info-sign"></span><i class="close icon-remove-circle"></i>
									                        Backup created successfully!
									                   </p>
									                </div>
									                <?php	
									                }										 

												 
												  if (isset($_GET['create']) && $_GET['create'] == "1")
													  doBackup();
												  
												?>
												<!-- <div id="loader" style="display:none"></div> -->
												<div id="resultados_ajax"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						
						<div class="row justify-content-center">
							<div class="col-lg-12">
								<div class="row">
									<!-- Column -->
									<div class="col-lg-12">
										<div class="card-body">
											<div class="d-flex no-block align-items-center m-b-30">
												<h4 class="card-title"></h4>
												<div class="ml-auto">
													<div class="btn-group">
														<a href="backup.php?do=backup&amp;create=1"><button type="button" class="btn btn-dark" >
															<?php echo $lang['tools-database1'] ?>
														<span class="icon-hdd"></span></button></a>
													</div>
												</div>
											</div>
											<p class="bluetip"><i class="icon-lightbulb icon-3x pull-left"></i><?php echo $lang['tools-database2'] ?><br />
												  <?php echo $lang['tools-database3'] ?> [<strong>backups</strong>] <?php echo $lang['tools-database4'] ?> <br />
												  <?php echo $lang['tools-database5'] ?>
											</p>
											<div class="table-responsive">
												<?php
												$dir = 'backups/';
												if (is_dir($dir)):
													$getDir = dir($dir);
													while (false !== ($file = $getDir->read())):
														if ($file != "." && $file != ".." && $file != "user.php"):
															  $sql =  ($file == $core->backup)? " db-latest" : "";
															  echo '<div class="db-backup' . $sql . '" id="item_' . $file . '"><i class="icon-hdd pull-left icon-3x icon-white"></i>';
															  echo '<span>' . getSize(filesize('backups/' . $file)) . '</span>';
															  
															  echo '<a class="delete">
															  <small class="sdelet btn btn-light" data-toggle="tooltip" title="'.$lang['tools-database6'].'" '. $file . 'p"><i class="icon-trash icon-white"></i></small></a>';
															  
															  echo '<a href="download.php?file=' . $file . '">
															  <small class="sdown btn btn-light" data-toggle="tooltip" title="'.$lang['tools-database7'].'"><i class="icon-download-alt icon-white"></i></small></a>';
															  
															  echo '<a class="restore">
															  <small class="srestore btn btn-light" data-toggle="tooltip" title="'.$lang['tools-database8'].'"'. $file . '"><i class="icon-refresh icon-white"></i></small></a>';
															  echo '<p>' . str_replace(".sql", "", $file) . '</p>';
															  
															  echo '</div>';
														endif;
													endwhile;
													$getDir->close();
												endif;
											  ?>
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
   
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('a.delete').on('click', function () {
        var parent = $(this).closest('div');
        var id = parent.attr('id').replace('item_', '')
        var title = $(this).attr('data-rel');
        var text = "<div><i class=\"icon-warning-sign icon-2x pull-left\"></i>Are you sure you want to delete this record?<br /><strong>This action cannot be undone!!!</strong></div>";
        new Messi(text, {
            title: "Delete Database Backup",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "Delete",
                val: 'Y'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						url: "./ajax/tools/backup/backup_delete_ajax.php",
						data: 'deleteBackup=' + id,
						beforeSend: function () {
							parent.animate({
								'backgroundColor': '#FFBFBF'
							}, 400);
						},
						success: function (msg) {
							parent.fadeOut(400, function () {
								parent.remove();
							});
							$("html, body").animate({
								scrollTop: 0
							}, 600);
							$("#resultados_ajax").html(msg);
						}
					});
                }
            }
        })
    });
	
    $('a.restore').on('click', function () {
        var parent = $(this).closest('div');
        var id = parent.attr('id').replace('item_', '')
        var title = $(this).attr('data-rel');
        var text = "<div><i class=\"icon-warning-sign icon-2x pull-left\"></i>Are you sure you want to restore databse?<br /><strong>This action cannot be undone!!!</strong></div>";
        new Messi(text, {
            title: "Restore Database",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "Restore Database",
                val: 'Y'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						url: "./ajax/tools/backup/backup_restore_ajax.php",
						data: 'restoreBackup=' + id,

						beforeSend: function () {
							$("#resultados_ajax").html("<div class='alert alert-warning' id='success-alert'>"+
            												"<p>"+
                												"processing database restore, please wait ..."+
          													 "</p>"+
        												"</div>");
						},
						success: function (msg) {
							parent.effect('highlight', 1500);
							$("html, body").animate({
								scrollTop: 0
							}, 600);
							$("#resultados_ajax").html(msg);
						}
					});
                }
            }
        })
    });
});
// ]]>
</script>
</body>

</html>