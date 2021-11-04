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



$id=$_GET['id'];

	if (!$user->is_Admin())
    redirect_to("login.php");
	
	require_once('helpers/querys.php');

	if (isset($_GET['id'])) {
		$data= getSmsTwilio($_GET['id']);
	}

	if (!isset($_GET['id']) or $data['rowCount']!=1){
		redirect_to("tools.php?list=config_sms.php");
	}

	$row=$data['data'];



 ?>
<!-- ============================================================== -->
<!-- Right Part contents-->
<!-- ============================================================== -->
<div class="right-part mail-list bg-white">
	<div class="p-15 b-b">
		<div class="d-flex align-items-center">
			<div>
				<span><?php echo $lang['tools-config61'] ?></span>
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
						<div id="loader" style="display:none"></div>
						<div id="resultados_ajax"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Action part -->


<div class="row justify-content-center">
	<div class="col-lg-12">
		<div class="row">
			<!-- Column -->
			<div class="col-lg-12">
				<div class="card-body">
					<div id="msgholder"></div>
					<form class="form-horizontal form-material" id="save_config" name="save_config" method="post">
						<header><?php echo $lang['tools-twilio9'] ?><span><?php echo $lang['tools-twilio10'] ?> <i class="icon-double-angle-right"></i> <?php echo $row->account_sid;?></span></header>
						<br>
						<br>
						<br>
						<section>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="firstName1"><?php echo $lang['tools-twilio11'] ?></label>
										<input type="text" class="form-control" name="account_sid" id="account_sid" value="<?php echo $row->account_sid;?>" placeholder="<?php echo $lang['tools-twilio11'] ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-twilio12'] ?></label>
										<input type="text" class="form-control" name="auth_token" id="auth_token" value="<?php echo $row->auth_token;?>" placeholder="<?php echo $lang['tools-twilio12'] ?>">
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="firstName1"><?php echo $lang['tools-twilio13'] ?></label>
										<input type="text" class="form-control" name="namesms" id="namesms" value="<?php echo $row->namesms;?>"  placeholder="<?php echo $lang['tools-twilio13'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-twilio14'] ?></label>
										<input type="text" class="form-control" name="twilio_number" id="twilio_number" value="<?php echo $row->twilio_number;?>"  placeholder="<?php echo $lang['tools-twilio14'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="active_twi" name="active_twi" value="1" <?php getChecked($row->active_twi, 1); ?> class="custom-control-input">
													<label class="custom-control-label" for="active_twi"> <?php echo $lang['tools-twilio15'] ?></label>
												</div>
											</label>
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="active_twi" name="active_twi" value="0" <?php getChecked($row->active_twi, 0); ?> class="custom-control-input">
													<label class="custom-control-label" for="active_twi"> <?php echo $lang['tools-twilio16'] ?></label>
												</div>
											</label>
										</div>
										<div class="note"><?php echo $lang['tools-twilio17'] ?></div>
									</div>
								</div>
							</div>
						</section>
						<br><br>
						<div class="form-group">
							<div class="col-sm-12">	
								<button class="btn btn-outline-primary btn-confirmation" name="dosubmit" type="submit"><?php echo $lang['tools-twilio18'] ?> <span><i class="icon-ok"></i></span></button>
								<a href="tools.php?list=config_sms" class="btn btn-outline-secondary btn-confirmation"><span><i class="ti-share-alt"></i></span> <?php echo $lang['tools-twilio19'] ?></a>
							</div>
						</div>	
						<input name="id" id="id" type="hidden" value="<?php echo $id;?>" />
					</form>
				</div>
			</div>
			<!-- Column -->
		</div>
	</div>
</div>							

<script type="text/javascript">

$("#save_config" ).submit(function(event) {
   
    var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "ajax/tools/config_sms_twilio_ajax.php",
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

