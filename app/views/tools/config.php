<!-- ============================================================== -->
<!-- Right Part contents-->
<!-- ============================================================== -->
<div class="right-part mail-list bg-white">
	<div class="p-15 b-b">
		<div class="d-flex align-items-center">
			<div>
				<span><?php echo $lang['tools-config61'] ?> | <?php echo $lang['left800'] ?></span>
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
	<?php $zonerow = $core->getZone(); ?>
	<div class="row justify-content-center">
		<div class="col-lg-12">
			<div class="row">
				<!-- Column -->
				<div class="col-12">
					<div class="card-body">				
						<form class="form-horizontal form-material" id="save_user" name="save_user" method="post">
						
						<h4 class="card-title"><b><?php echo $lang['tools-config57'] ?></b></h4> <br><br>
						<section>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="firstName1"><?php echo $lang['tools-config1'] ?></label>
										<input type="text" class="form-control" name="site_name"  id="site_name" title="<?php echo $lang['tools-config2'] ?>" data-toggle="tooltip"  value="<?php echo $core->site_name;?>" placeholder="<?php echo $lang['tools-config1'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config3'] ?></label>
										<input type="text" class="form-control" name="site_url" id="site_url" title="<?php echo $lang['tools-config4'] ?>" data-toggle="tooltip" value="<?php echo $core->site_url;?>" placeholder="<?php echo $lang['tools-config3'] ?>" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config5'] ?></label>
										<input type="text" class="form-control" name="site_email" id="site_email" title="<?php echo $lang['tools-config6'] ?>" data-toggle="tooltip" value="<?php echo $core->site_email;?>" placeholder="Website Email">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="firstName1"><?php echo $lang['tools-config7'] ?></label>
										<input type="text" class="form-control" name="c_nit" id="c_nit" value="<?php echo $core->c_nit;?>" placeholder="<?php echo $lang['tools-config7'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config8'] ?></label>
										<input type="number"class="form-control"  name="c_phone" id="c_phone" value="<?php echo $core->c_phone;?>" placeholder="<?php echo $lang['tools-config8'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['user_manage9'] ?></label>
										<input type="number" class="form-control" name="cell_phone" id="cell_phone" value="<?php echo $core->cell_phone;?>" placeholder="<?php echo $lang['tools-config9'] ?>">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['left801'] ?></label>
										<textarea class="form-control" name="c_address" id="c_address" placeholder="<?php echo $lang['tools-config9'] ?>"><?php echo $core->c_address;?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['left802'] ?></label>
										<textarea class="form-control" name="locker_address" id="locker_address" placeholder="Addres virtual locker"><?php echo $core->locker_address;?></textarea>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="firstName1"><?php echo $lang['tools-config11'] ?></label>
										<input type="text" class="form-control" name="c_country" id="c_country" value="<?php echo $core->c_country;?>" placeholder="<?php echo $lang['tools-config11'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config12'] ?></label>
										<input type="text"class="form-control"  name="c_city" id="c_city" value="<?php echo $core->c_city;?>" placeholder="<?php echo $lang['tools-config12'] ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config13'] ?></label>
										<input type="text" class="form-control" name="c_postal" id="c_postal" value="<?php echo $core->c_postal;?>" placeholder="<?php echo $lang['tools-config13'] ?>">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-4" style="display:none">
									<div class="form-group">
										<label for="firstName1">Items Per Page</label>
										<input type="text" title="Default number of items used for pagination" data-toggle="tooltip" class="form-control" name="user_perpage"  id="user_perpage" value="<?php echo $core->user_perpage;?>" placeholder="Items Per Page">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1">Avatar Thumbnail Width</label>
										<input type="text" title="Default thumbnail width, in px used for resizing avatars" data-toggle="tooltip" class="form-control"  name="thumb_w" id="thumb_w" value="<?php echo $core->thumb_w;?>" placeholder="Thumbnail Width">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1">Avatar Thumbnail Height</label>
										<input type="text" title="Default thumbnail height, in px used for resizing avatars" data-toggle="tooltip" class="form-control" name="thumb_h" id="thumb_h" value="<?php echo $core->thumb_h;?>" placeholder="Thumbnail Height">
									</div>
								</div>
							</div>
							<hr />
							<h4 class="card-title"><b><?php echo $lang['left803'] ?></b></h4>
							
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio4" name="reg_verify" value="1" <?php getChecked($core->reg_verify, 1); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio4"> <?php echo $lang['tools-config14'] ?></label>
												</div>
											</label>
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio5" name="reg_verify" value="0" <?php getChecked($core->reg_verify, 0); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio5"> <?php echo $lang['tools-config15'] ?></label>
												</div>
											</label>
										</div>
										<div class="note"><?php echo $lang['tools-config16'] ?> <i class="icon-exclamation-sign  tooltip" data-title="<?php echo $lang['tools-config17'] ?>"></i> </div>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio4" name="auto_verify" value="1" <?php getChecked($core->auto_verify, 1); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio4"> <?php echo $lang['tools-config14'] ?></label>
												</div>
											</label>
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio5" name="auto_verify" value="0" <?php getChecked($core->auto_verify, 0); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio5"> <?php echo $lang['tools-config15'] ?></label>
												</div>
											</label>
										</div>
										<div class="note"><?php echo $lang['tools-config18'] ?> <i class="icon-exclamation-sign  tooltip" data-title="<?php echo $lang['tools-config19'] ?>"></i></div>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio4" name="reg_allowed" value="1" <?php getChecked($core->reg_allowed, 1); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio4"> <?php echo $lang['tools-config14'] ?></label>
												</div>
											</label>
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio5" name="reg_allowed" value="0" <?php getChecked($core->reg_allowed, 0); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio5"> <?php echo $lang['tools-config15'] ?></label>
												</div>
											</label>
										</div>
										<div class="note"><?php echo $lang['tools-config20'] ?> <i class="icon-exclamation-sign  tooltip" data-title="<?php echo $lang['tools-config21'] ?>"></i></div>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio4" name="notify_admin" value="1" <?php getChecked($core->notify_admin, 1); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio4"> <?php echo $lang['tools-config14'] ?></label>
												</div>
											</label>
											<label class="btn">
												<div class="custom-control custom-radio">
													<input type="radio" id="customRadio5" name="notify_admin" value="0" <?php getChecked($core->notify_admin, 0); ?> class="custom-control-input">
													<label class="custom-control-label" for="customRadio5"> <?php echo $lang['tools-config15'] ?></label>
												</div>
											</label>
										</div>
										<div class="note"><?php echo $lang['tools-config22'] ?> <i class="icon-exclamation-sign  tooltip" data-title="<?php echo $lang['tools-config23'] ?>"></i></div>
									</div>
								</div>
							</div>
							<hr />
							<h4 class="card-title"><b><?php echo $lang['left804'] ?></b></h4>
							
							<div class="row">
								<div class="col-md-4" style="display:none">
									<label class="input"><i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo $lang['tools-config25'] ?>"></i>
										<input type="text" name="user_limit" value="<?php echo $core->user_limit;?>" placeholder="<?php echo $lang['tools-config24'] ?>">
									</label>
									<div class="note"><?php echo $lang['tools-config24'] ?></div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config26'] ?>, <?php echo $lang['left805'] ?> 45 x 45</label>
										<input class="form-control" name="favicon" id="favicon" type="file" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="lastName1"><?php echo $lang['tools-config27'] ?>, <?php echo $lang['left805'] ?> 190 x 45</label>
										<input class="form-control" name="logo" id="logo" type="file" />
									</div>
								</div>
							</div>
							<hr />
						</section>
						<div class="form-group">
							<div class="col-sm-12">										
								<button type="submit" class="btn btn-primary btn-confirmation" name="save_data" id="save_data" ><?php echo $lang['tools-config56'] ?> <span><i class="icon-ok"></i></span></button>								
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



<script>
	//Registro de datos

$( "#save_user" ).submit(function( event ) {
	$('#save_data').attr("disabled", true);
	 var logo = document.getElementById("logo");
	 var favicon = document.getElementById("favicon");

	 var site_name = $('#site_name').val();
	 var site_url = $('#site_url').val();
	 var site_email = $('#site_email').val();
	 var c_nit = $('#c_nit').val();
	 var c_phone = $('#c_phone').val();
	 var cell_phone = $('#cell_phone').val();
	 var c_address = $('#c_address').val();
	 var locker_address = $('#locker_address').val();
	 var c_country = $('#c_country').val();
	 var c_city = $('#c_city').val();
	 var c_postal = $('#c_postal').val();
	 var thumb_w = $('#thumb_w').val();
	 var thumb_h = $('#thumb_h').val();
	 
	 var reg_verify = $('input:radio[name=reg_verify]:checked').val();
	 var auto_verify = $('input:radio[name=auto_verify]:checked').val();
	 var reg_allowed = $('input:radio[name=reg_allowed]:checked').val();
	 var notify_admin = $('input:radio[name=notify_admin]:checked').val();
	 

	var file_logo= logo.files[0];
	var file_favicon= favicon.files[0];

	var data = new FormData();

	data.append('logo',file_logo);	
	data.append('favicon',file_favicon);	
	data.append('site_name',site_name);	
	data.append('site_url',site_url);	
	data.append('site_email',site_email);	
	data.append('c_nit',c_nit);	
	data.append('c_phone',c_phone);	
	data.append('cell_phone',cell_phone);	
	data.append('c_address',c_address);	
	data.append('locker_address',locker_address);	
	data.append('c_city',c_city);	
	data.append('c_country',c_country);	
	data.append('c_postal',c_postal);	
	data.append('thumb_w',thumb_w);	
	data.append('thumb_h',thumb_h);	
	data.append('reg_verify',reg_verify);	
	data.append('auto_verify',auto_verify);	
	data.append('reg_allowed',reg_allowed);	
	data.append('notify_admin',notify_admin);	//19
	$.ajax({
			type: "POST",
			url: "ajax/tools/config_system_ajax.php",
			data: data,
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Enviando...");
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
  event.preventDefault();
	
})
</script>