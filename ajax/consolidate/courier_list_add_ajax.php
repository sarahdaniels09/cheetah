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

        
        if($search!=null){

			$sWhere.=" and  CONCAT(a.order_prefix,a.order_no) LIKE '%".$search."%'";
        }
        if($status_courier>0){

			$sWhere.=" and  a.status_courier = '".$status_courier."'";
        }

         
		// // pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;

	
		$sql="SELECT a.volumetric_percentage, a.is_pickup,  a.total_order, a.order_id, a.order_prefix, a.order_no, a.order_date, a.sender_id, a.receiver_id, a.order_courier, a.order_pay_mode, a.status_courier, a.driver_id, a.order_service_options,  b.mod_style, b.color FROM
			 add_order as a
			 INNER JOIN styles as b ON a.status_courier = b.id
			 $sWhere
			  and a.status_courier!=14  and a.status_courier!=8 and a.status_courier!=21 and a.is_consolidate=0
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
				
				<th><b><?php echo $lang['ltracking'] ?></b></th>				
				<th class="text-center"><b>Weights</b></th>
				<th class="text-center"><b>Weight Vol.</b></th>
				<th class="text-center"><b><?php echo $lang['lstatusshipment'] ?></b></th>
				<th class="text-center"><b><?php echo $lang['ship-all5'] ?></b></th>				
				<th class="text-center"></th>
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

				// $db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
    //     		$sender_data= $db->registro();

    //     		$db->query("SELECT * FROM users where id= '".$row->receiver_id."'"); 
    //     		$receiver_data= $db->registro();

    //     		$db->query("SELECT * FROM users where id= '".$row->driver_id."'"); 
    //     		$driver_data= $db->registro();

    //     		$db->query("SELECT * FROM courier_com where id= '".$row->order_courier."'"); 
    //     		$courier_com= $db->registro();

    //     		$db->query("SELECT * FROM met_payment where id= '".$row->order_pay_mode."'"); 
    //     		$met_payment= $db->registro();

    //     		$db->query("SELECT * FROM shipping_mode where id= '".$row->order_service_options."'"); 
    //     		$order_service_options= $db->registro();

	        	$db->query("SELECT IFNULL(sum(order_item_weight), 0) as weight FROM add_order_item where order_id= '".$row->order_id."'"); 
        		$order_weight= $db->registro();

        		$weight= $order_weight->weight;


        		$db->query("SELECT IFNULL(sum(order_item_length), 0) as length from  add_order_item where order_id= '".$row->order_id."'"); 
        		$order_length= $db->registro();

				$db->query("SELECT IFNULL(sum(order_item_height), 0) as height from add_order_item where order_id= '".$row->order_id."'"); 
        		$order_height= $db->registro();

        		$db->query("SELECT IFNULL(sum(order_item_width), 0) as width from add_order_item where order_id= '".$row->order_id."'"); 
        		$order_width= $db->registro();


        		$length= $order_length->length;
        		$width= $order_width->width;
        		$height= $order_height->height;

            	$total_metric = $length * $width * $height/$row->volumetric_percentage; 

            	// var_dump($total_metric);
        		$db->query("SELECT * FROM styles where id= '14'"); 
        		$status_style_pickup= $db->registro();

        		$tracking = $row->order_prefix.$row->order_no;

			?>
					<tr class="card-hover">

						<td><b><?php echo $row->order_prefix.$row->order_no;?></b></td>

						<td class="text-center">							
							<?php echo $weight; ?>
						</td>

						<td class="text-center">							
							<?php echo $total_metric; ?>
						</td>
						<!-- <input type="hidden" id="order_prefix_<?php echo $row->order_id; ?>"  value="<?php echo $row->order_prefix;?>">

						<input type="hidden" id="order_no_<?php echo $row->order_id; ?>"  value="<?php echo $row->order_no;?>">	
						<input type="hidden" id="order_id_<?php echo $row->order_id; ?>"  value="<?php echo $row->order_id;?>">	
 -->
						<!-- <input type="hidden" id="tracking_<?php echo $row->order_id; ?>"  value="<?php echo $row->order_prefix.$row->order_no;?>"> -->

						<!-- <input type="hidden" id="weight_<?php echo $row->order_id; ?>"  value="<?php echo $weight;?>"> -->

						<!-- <input type="hidden" id="total_vol_<?php echo $row->order_id; ?>"  value="<?php echo $total_metric;?>"> -->

					<!-- 	<input type="hidden" id="length_<?php echo $row->order_id; ?>"  value="<?php echo $length;?>" >
						<input type="hidden" id="height_<?php echo $row->order_id; ?>"  value="<?php echo $height;?>" >
						<input type="hidden" id="width_<?php echo $row->order_id; ?>"  value="<?php echo $width;?>" >
						 -->

						<input type="hidden" id="total_ship_<?php echo $row->order_id; ?>"  value="<?php echo number_format($row->total_order, 2,'.',''); ?>">

						<td class="text-center">
							
							<span style="background: <?php echo $row->color; ?>;"  class="label label-large" ><?php echo $row->mod_style;?></span>
							<br>
							
							<?php
							if($row->is_pickup==true){?>

							<span style="background: <?php echo $status_style_pickup->color; ?>;"  class="label label-large" ><?php echo $status_style_pickup->mod_style;?></span>
							<?php
							}
							?>
						</td>
						
						<td class="text-center">							
							<b><?php echo $core->currency;?></b> <?php echo number_format($row->total_order, 2,'.',''); ?>
						</td>

						<td class="text-right">
							<button type="button" name="add_row" id="add_row"
							 onclick="add_item('<?php echo $row->order_id;?>','<?php echo $total_metric;?>', '<?php echo $weight;?>', '<?php echo $length;?>', '<?php echo $width;?>', '<?php echo $height;?>', '<?php echo $tracking;?>', '<?php echo $row->order_no;?>',' <?php echo $row->order_prefix;?>');
							 "
							  class="btn btn-success btn-sm add_row"><i class="fa fa-plus"></i></button>
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

</div>
<?php }?>
