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



	require_once ("../../loader.php");

	$db = new Conexion;
	$user = new User;
	$core = new Core;
	$userData = $user->getUserData();

		$search = trim($_REQUEST['search']);
		$status_courier = intval($_REQUEST['status_courier']);
		
		$sWhere="";

        if($userData->userlevel==3){

			$sWhere.=" and  a.driver_id = '".$_SESSION['userid']."'";

        }else if($userData->userlevel==1){

			$sWhere.=" and  a.sender_id = '".$_SESSION['userid']."'";

        }else{
			$sWhere.="";

        } 
        if($search!=null){

			$sWhere.=" and  CONCAT(a.order_prefix,a.order_no) LIKE '%".$search."%'";
        }
        if($status_courier>0){

			$sWhere.=" and  a.status_courier = '".$status_courier."'";
        }

        

 			$filterby = intval($_REQUEST['filterby']);

	        if($filterby>0){

	        	if ($filterby==1) {$is_pickup_filter=1;}else{$is_pickup_filter=0;}
				
				$sWhere.=" and  a.is_pickup = '".$is_pickup_filter."'";
	        }

	        if($filterby==3){
				
				$sWhere.=" and  a.is_consolidate = '1'";
	        }
	    
        
		// // pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;

		$db->query("UPDATE add_order SET  status_invoice =3  WHERE due_date<now() and status_invoice !=1 and order_payment_method >1");     
                
       
        $db->execute();

	
		$sql="SELECT a.order_incomplete,  a.status_invoice,  a.is_consolidate, a.is_pickup,  a.total_order, a.order_id, a.order_prefix, a.order_no, a.order_date, a.sender_id, a.receiver_id, a.order_courier, a.order_pay_mode, a.status_courier, a.driver_id, a.order_service_options,  b.mod_style, b.color FROM
			 add_order as a
			 INNER JOIN styles as b ON a.status_courier = b.id
			 $sWhere
			  and a.status_courier!=14

			 order by order_id desc 
			 ";


        $query_count=$db->query($sql);   		
      	$db->execute();
    	$numrows= $db->rowCount();    


        $db->query($sql." limit $offset, $per_page"); 
        $data= $db->registros();
		
		$total_pages = ceil($numrows/$per_page);
		

if ($numrows>0){?>
				<div class="table-responsive">


	<table id="zero_config" class="table table-condensed table-hover table-striped custom-table-checkbox">
		<thead>
			<tr>
				<?php 
        		if($userData->userlevel==9){?>

				<th>
					<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input sl-all" id="cstall">
                        <label class="custom-control-label" for="cstall"></label>
                    </div>
                </th>
                <?php 
                }
                ?>
				<th><b><?php echo $lang['ltracking'] ?></b></th>
				<th class="text-center"><b><?php echo $lang['ddate'] ?></b></th>
				<th class="text-center"><b>Sender</b></th>
				<th class="text-center"><b>Receiver</b></th>
				<th class="text-center"><b><?php echo $lang['lorigin'] ?></b></th>
				<th class="text-center"><b><?php echo $lang['ldestination'] ?></b></th>
				<!-- <th class="text-center"><b><?php echo $lang['lshipline'] ?></b></th> -->
				<th class="text-center"><b><?php echo $lang['lpayment'] ?></b></th>
				<th class="text-center"><b><?php echo $lang['lstatusshipment'] ?></b></th>
				<th><b>Driver</b></th>
				<th class=""><b><?php echo $lang['ship-all5'] ?></b></th>
				<th class="text-center"><b>Invoice Status</b></th>
				
				<th class="text-center"><b><?php
				 //echo $lang['aaction']
				  ?></b></th>
			</tr>
		</thead>
		<tbody id="projects-tbl">

		
			<?php if(!$data){?>
			<tr>
				<td colspan="6">
				<?php echo "
				<i align='center' class='display-3 text-warning d-block'><img src='assets/images/alert/ohh_shipment.png' width='150' /></i>								
				",false;?>
				</td>
			</tr>
			<?php }else{ ?>

			<?php

			$count=0;
			 foreach ($data as $row){

				$db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
        		$sender_data= $db->registro();

        		$db->query("SELECT * FROM users where id= '".$row->receiver_id."'"); 
        		$receiver_data= $db->registro();

        		$db->query("SELECT * FROM users where id= '".$row->driver_id."'"); 
        		$driver_data= $db->registro();

        		$db->query("SELECT * FROM courier_com where id= '".$row->order_courier."'"); 
        		$courier_com= $db->registro();

        		$db->query("SELECT * FROM met_payment where id= '".$row->order_pay_mode."'"); 
        		$met_payment= $db->registro();

        		$db->query("SELECT * FROM shipping_mode where id= '".$row->order_service_options."'"); 
        		$order_service_options= $db->registro();

        		$db->query("SELECT * FROM styles where id= '14'"); 
        		$status_style_pickup= $db->registro();

        		$db->query("SELECT * FROM styles where id= '13'"); 
        		$status_style_consolidate= $db->registro();


        		if ($row->status_invoice==1){

			        $text_status=$lang['invoice_paid'];$label_class="label-success";

			    }else if ($row->status_invoice==2){

			        $text_status=$lang['invoice_pending']; $label_class="label-warning";

			    }else if ($row->status_invoice==3){
			        $text_status=$lang['verify_payment'];$label_class="label-info";
			    }   



			    $db->query("SELECT * FROM address_shipments where order_track='".$row->order_prefix.$row->order_no."'"); 
			    $address_order= $db->registro();



			?>
						<tr class="card-hovera">
							<?php 
        					if($userData->userlevel==9){?>
							<td class="chb">
								 <?php if ($row->status_courier!=8 ) {?>
								 <?php if ($row->status_courier!=21) {?>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="<?php echo $row->order_no;?>" name="checkbox[]" id="cst_<?php echo $count;?>">
                                    <label class="custom-control-label" for="cst_<?php echo $count;?>">&nbsp;</label>
                                </div>

                            	<?php } ?>
                            	<?php } ?>

                            </td>
                            	<?php } ?>
						<td><b><a  href="courier_view.php?id=<?php echo $row->order_id;?>"><?php echo $row->order_prefix.$row->order_no;?></a></b></td>
						<td class="text-center">							
							<?php echo $row->order_date;?>
						</td>

						<td class="text-center">
							<?php echo $sender_data->fname;?>  <?php echo $sender_data->lname;?>
						</td>

						<td class="text-center">							
						 <?php echo $receiver_data->fname;?> <?php echo $receiver_data->lname;?>
						</td>

						<td class="text-center"><?php echo $address_order->sender_country;?>-<?php echo $address_order->sender_city;?></td>
						<td class="text-center"><?php echo $address_order->recipient_country;?>-<?php echo $address_order->recipient_city;?></td>
					
						<td class="text-center"><?php echo $met_payment->met_payment;?></td>

						<td class="">
							
							<span style="background: <?php echo $row->color; ?>;"  class="label label-large" ><?php echo $row->mod_style;?></span>
							<br>
							
							<?php
							if($row->is_pickup==true){?>

							<span style="background: <?php echo $status_style_pickup->color; ?>;"  class="label label-large" ><?php echo $status_style_pickup->mod_style;?></span>
							<?php
							}
							?>

							<?php
							if($row->is_consolidate==true){?>

							<span style="background: <?php echo $status_style_consolidate->color; ?>;"  class="label label-large" ><?php echo $status_style_consolidate->mod_style;?></span>
							<?php
							}
							?>
						</td>

						<td>
						<?php

						if($driver_data!=null){ echo $driver_data->fname;?> <?php echo $driver_data->lname;}?>
							
						</td>


						<td class="text-center">							
							<b><?php echo $core->currency;?></b> <?php echo number_format($row->total_order, 2,'.',''); ?>
						</td>

						<td>
						<span  class="label label-large <?php echo $label_class; ?>" ><?php echo $text_status;?></span>
							
						</td>
							<td align='center'>
									<div class="btn-group">
									    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" 
									    data-flip="false"
									     >Actions
									    </button>
									    <div class="dropdown-menu scrollable-menu">
									    	<a  class="dropdown-item" href="courier_view.php?id=<?php echo $row->order_id;?>" title="<?php echo $lang['tooledit'] ?>"><i style="color:#343a40" class="fa fa-search"></i>&nbsp;Show details</a>


									    	<?php if ($row->status_invoice ==2) {?>
											<?php if ($userData->userlevel ==1) {?>


												
												<a 
												class="dropdown-item" 
												href="add_payment_gateways_courier.php?id_order=<?php echo $row->order_id;?>">
												<i style="color:#343a40" class="fas fa-dollar-sign"></i>&nbsp;Add invoice payment</a>


	                                        <?php } ?>
											
	                                        <?php } ?>

	                                        <?php if ($row->status_invoice ==3) {?>
											<?php if ($userData->userlevel !=1) {?>


												<a
												class="dropdown-item" 
												data-toggle="modal"
												data-target="#detail_payment_packages"
												data-id="<?php echo $row->order_id;?>"
												data-customer="<?php echo $row->sender_id;?>"
												
												><i style="color:#343a40" class="fas fa-dollar-sign"></i>&nbsp; Verify payment</a>


	                                        <?php } ?>
											
	                                        <?php } ?>
	                                        

											<?php if ($row->order_incomplete ==0) {?>
											<?php if ($row->is_pickup==0) {?>
											<?php if ($userData->userlevel !=1) {?>


												<a  class="dropdown-item" href="courier_accept.php?id=<?php echo $row->order_id;?>" title="<?php echo $lang['tooledit'] ?>"><i style="color:#343a40" class="ti-pencil"></i>&nbsp; Complete shipment</a>


	                                        <?php } ?>
												<a class="dropdown-item" href="print_label_ship.php?id=<?php echo $row->order_id;?>" target="_blank"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toollabel'] ?> </a>
	                                        <?php } ?>
	                                        <?php } ?>



											<?php if ($row->order_incomplete ==1) {?>


												<?php if ($userData->userlevel !=1) {?>

	                                                <?php if ($row->is_consolidate==0) {?>
	                                                <?php if ($userData->userlevel==9 || $userData->userlevel==2) {?>
	                                                <?php if ($row->status_courier!=8) {?>

	                                                <a  class="dropdown-item" href="courier_edit.php?id=<?php echo $row->order_id;?>" title="<?php echo $lang['tooledit'] ?>"><i style="color:#343a40" class="ti-pencil"></i>&nbsp;<?php echo $lang['tooledit'] ?></a>
	                                                <?php } ?>
	                                                <?php } ?>
	                                                <?php } ?>

												<?php } ?>

	                                                
                                                	<?php if ($userData->userlevel==9 || $userData->userlevel==2) {?>

	                                                <?php if ($row->status_courier!=21 || $row->status_courier!=12) {?>

                                                    <?php if($row->status_invoice!=1){?>

	                                                <a  class="dropdown-item" data-toggle="modal" data-target="#charges_list" data-id="<?php echo $row->order_id;?>"><i style="color:#343a40" class="fas fa-dollar-sign"></i>&nbsp;Charges</a>
	                                                <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>




                                                    <?php if ($userData->userlevel==9 || $userData->userlevel==3 || $userData->userlevel==2 ) {?>

                                                    <?php if ($row->status_courier!=8) {?>
                                                    <?php if ($row->status_courier!=21) {?>
                                                    <?php if ($row->status_courier!=12) {?>

                                                         <a  class="dropdown-item" data-toggle="modal" data-target="#modalDriver" data-id_shipment="<?php echo $row->order_id;?>"><i style="color:#ff0000" class="fas fa-car"></i>&nbsp; <?php echo $lang['left208'] ?></a>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>


                                                   <?php if ($row->status_courier!=21) {?>
		                                           <?php if ($row->status_courier!=12) {?>


                                                    <a class="dropdown-item" target="blank" href="print_inv_ship.php?id=<?php echo $row->order_id;?>"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toolprint'] ?></a>

                                                    <a class="dropdown-item" href="print_label_ship.php?id=<?php echo $row->order_id;?>" target="_blank"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toollabel'] ?> </a> 


                                                    



                                                    <?php if ($userData->userlevel==9 || $userData->userlevel==3 || $userData->userlevel==2 ) {?>

                                                    <?php if ($row->is_consolidate==0) {?>
                                                    
                                                    <?php if ($row->status_courier!=8) {?>
                                                    <?php if ($row->status_courier!=21) {?>
                                                    <?php if ($row->status_courier!=12) {?>


                                                    <a   class="dropdown-item" href="courier_shipment_tracking.php?id=<?php echo$row->order_id;?>"  title="<?php echo $lang['toolupdate'] ?>"><i style="color:#20c997" class="ti-reload">&nbsp;</i><?php echo $lang['toolupdate'] ?></a>

                                                    <a class="dropdown-item" href="courier_deliver_shipment.php?id=<?php echo $row->order_id;?>"  title="<?php echo $lang['tooldeliver'] ?>"><i style="color:#2962FF" class="ti-package"></i>&nbsp;<?php echo $lang['tooldeliver'] ?></a>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>




	                                            <?php if ($userData->userlevel==9 || $userData->userlevel==2) {?>

	                                            	<?php if ($row->status_courier!=8) {?>
                                                    <?php if ($row->status_courier!=21) {?>
                                                    <?php if ($row->status_courier!=12) {?>

		                                            <a  class="dropdown-item"
	                                                data-id="<?php echo $row->order_id;?>"
	                                                href="#" 
	                                                data-toggle="modal"
	                                                data-target="#myModalCancel"> <i style="color:#f62d51" class="fas fa-times-circle"></i>&nbsp;Cancel</a> 

	                                                <?php } ?>
                                                    <?php } ?>
                                                    <?php } ?>
	                                                
	                                            <?php } ?>




	                                            <?php if ($userData->userlevel==9 || $userData->userlevel==2 || $userData->userlevel==3) {?>

	                                                <a  class="dropdown-item"  href="#" data-toggle="modal" 
													data-id="<?php echo $row->order_id;?>"
													data-email="<?php echo $sender_data->email;?>"
													data-order="<?php echo $row->order_prefix.$row->order_no;?>"
	                                                data-target="#myModal"><i class="fas fa-envelope"></i>&nbsp;Send email</a>

	                                            <?php } ?>
	                                    <?php } ?>

	                                    <?php } ?>
                                                    <?php } ?>

	                                           
	                                                
                                            </div>
									</div>
								</td>						
								
							
					</tr>
			<?php $count++; }?>
			
			<?php }?>
		</tbody>
		
	</table>


	<div class="pull-right">
					<?php  echo paginate($page, $total_pages, $adjacents);	?>
				</div>

<script>

	var count =0;

	$(".sl-all").on('click', function() {

		$('.custom-table-checkbox input:checkbox').not(this).prop('checked', this.checked);

		if ($('.custom-table-checkbox input:checkbox').is(':checked')) {

			$('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]').parents('tr').css('background','#fff8e1');
			// $('.custom-table-checkbox input:checkbox').parents('tr').css('background','#fff8e1');

		} else {

			$('.custom-table-checkbox input:checkbox').parents('tr').css('background','');

		}

	    var $checkboxes = 	$('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]');

		 count = $checkboxes.filter(':checked').length;

		if(count>0){

		 	$('#div-actions-checked').removeClass('hide');
			$('#countChecked').removeClass('hide');

		 }else{

		 	$('#div-actions-checked').addClass('hide');
			$('#countChecked').addClass('hide');
		 }

        $('#countChecked').html("Selected: "+count);

		
	});



	$('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]').on('change', function() {

		if ($(this).is(':checked')) {

			$(this).parents('tr').css('background','#fff8e1');

		} else {

			$(this).parents('tr').css('background','');
		}

		       
	});




	$(document).ready(function(){

    	var $checkboxes = 	$('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]');

    	$checkboxes.change(function(){

        	count = $checkboxes.filter(':checked').length;

        	if(count>0){

			 	$('#div-actions-checked').removeClass('hide');
				$('#countChecked').removeClass('hide');

			 }else{

			 	$('#div-actions-checked').addClass('hide');
				$('#countChecked').addClass('hide');
			 }


       		$('#countChecked').html("Selected: "+count);
        
    	});

	});
</script>



<script>

     $( "#send_checkbox_status" ).submit(function( event ) {          
        
        $('#guardar_datos').attr("disabled", true);
          
        var parametros = $(this).serialize();
        var checked_data = new Array();
        $('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]:checked').each(function() {
    	// $('.custom-table-checkbox input:checkbox:checked').each(function() {
         checked_data.push($(this).val());
      	});

      	var status = $('#status_courier_modal').val();

         $.ajax({
            type: "GET",
			url:'./ajax/courier/courier_update_multiple_ajax.php?status='+status,

            data: {'checked_data': JSON.stringify(checked_data)},
             beforeSend: function(objeto){
                $(".resultados_ajax").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            $('#modalCheckboxStatus').modal('hide');


            load(1);

		 	$('#div-actions-checked').addClass('hide');
			$('#countChecked').addClass('hide');
			$('html, body').animate({
	              scrollTop: 0
	          }, 600);
			
            
          }
        });
      event.preventDefault();
    
    })
</script>

<script>
	//Eliminar
	function printMultipleLabel(){

		var checked_data = new Array();
        $('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]:checked').each(function() {
    	// $('.custom-table-checkbox input:checkbox:checked').each(function() {
         checked_data.push($(this).val());
      	});

          var name = $(this).attr('data-rel');
          new Messi('<b></i>Are you sure to print '+count+' selected records ?</b>', {
              title: 'Print Shipments Label',
              titleClass: '',
              modal: true,
              closeButton: true,
              buttons: [{
                  id: 0,
                  label: 'Print',
                  class: '',
                  val: 'Y'
              }],
              	callback: function (val) {

                  	if (val === 'Y') {
                      	
                        window.open('print_label_ship_multiple.php?data='+JSON.stringify(checked_data), "_blank");
                         
                  	}
              	}

          // });
      });		
	}
</script>
<!-- <script type="text/javascript">
	   	$(document).on('show.bs.dropdown', function(e) {
       		$('#test').css('padding-top', '160px');     
   		});

</script> -->



<script>

     $( "#driver_update_multiple" ).submit(function( event ) {          
        
        $('#update_driver2').attr("disabled", true);
          
        var parametros = $(this).serialize();
        var checked_data = new Array();
        $('.custom-table-checkbox').find('tr > td:first-child').find('input[type=checkbox]:checked').each(function() {
    	// $('.custom-table-checkbox input:checkbox:checked').each(function() {
         checked_data.push($(this).val());
      	});

      	var driver = $('#driver_id_multiple').val();

         $.ajax({
            type: "GET",
			url:'./ajax/courier/courier_update_driver_multiple_ajax.php?driver='+driver,

            data: {'checked_data': JSON.stringify(checked_data)},
             beforeSend: function(objeto){
                $(".resultados_ajax").html("Mensaje: send...");
              },
            success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#update_driver2').attr("disabled", false);
            $('#modalDriverCheckbox').modal('hide');


            load(1);

		 	$('#div-actions-checked').addClass('hide');
			$('#countChecked').addClass('hide');
			$('html, body').animate({
	              scrollTop: 0
	          }, 600);
			
            
          }
        });
      event.preventDefault();
    
    })
</script>


</div>
<?php }?>
