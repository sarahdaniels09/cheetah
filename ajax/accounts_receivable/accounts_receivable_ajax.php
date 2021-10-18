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

        $range =$_REQUEST['range'];
		$search = trim($_REQUEST['search']);
		$agency_courier = intval($_REQUEST['agency_courier']);
		$customer_id = intval($_REQUEST['customer_id']);
	
		$sWhere="";

       
        if($search!=null){

			$sWhere.=" and  CONCAT(order_prefix, order_no) LIKE '%".$search."%'";
        }

        if($agency_courier>0){

			$sWhere.=" and agency = '".$agency_courier."'";
        }


        if($customer_id>0){

			$sWhere.=" and sender_id = '".$customer_id."'";
        }
       
    	if (!empty($range)){
	     
	$fecha=  explode(" - ",$range);            
    $fecha= str_replace('/','-', $fecha);

    $fecha_inicio = date('Y-m-d', strtotime($fecha[0]));
    $fecha_fin = date('Y-m-d', strtotime($fecha[1]));


	$sWhere.=" and order_date between '".$fecha_inicio."'  and '".$fecha_fin."'";
	
}

		// // pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;




        $db->query("UPDATE add_order SET  status_invoice =3  WHERE due_date<now() and status_invoice !=1 and order_payment_method >1");     
                
       
        $db->execute();

	
		$sql="SELECT * FROM add_order where order_payment_method >1
			
			$sWhere
			
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
				<th class="text-center"><b>Sender</b></th>
				<th class="text-center"><b><?php echo $lang['ddate'] ?></b></th>
				<th class="text-center"><b>Due date</b></th>
				<th class="text-center"><b><?php echo $lang['lstatusinvoice'] ?></b></th>
				
				<th class="text-center"><b>Total amount</b></th>				
				<th class="text-center"><b>Total paid</b></th>				
				<th class="text-center"><b>balance</b></th>				
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

				$db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
        		$sender_data= $db->registro();

        		$db->query("SELECT * FROM users where id= '".$row->receiver_id."'"); 
        		$receiver_data= $db->registro();

        		$db->query("SELECT * FROM users where id= '".$row->driver_id."'"); 
        		$driver_data= $db->registro();

        		
        		$db->query('SELECT  IFNULL(sum(total), 0)  as total  FROM charges_order WHERE order_id=:order_id');

		        $db->bind(':order_id', $row->order_id);

		        $db->execute();        

		        $sum_payment= $db->registro();
		        // var_dump($sum_payment->total);

				$pendiente=$row->total_order-$sum_payment->total;

				if ($row->status_invoice==1){$text_status=$lang['invoice_paid'];$label_class="label-success";}
				else if ($row->status_invoice==2){$text_status=$lang['invoice_pending'];$label_class="label-warning";}
				else if ($row->status_invoice==3){$text_status=$lang['invoice_due'];$label_class="label-danger";}



        		
			?>
						<tr class="card-hovera">
							
						<td><b><a  data-toggle="modal" data-target="#charges_list" data-id="<?php echo $row->order_id;?>"><?php echo $row->order_prefix.$row->order_no;?></a></b></td>

						<td class="text-center">
							<?php echo $sender_data->fname;?>  <?php echo $sender_data->lname;?>
						</td>

						<td class="text-center">							
							<?php echo $row->order_date;?>
						</td>
						

						<td class="text-center">							
							<?php echo $row->due_date;?>
						</td>

						<td class="text-center">							
							<span  class="label label-large <?php echo $label_class; ?>" ><?php echo $text_status;?></span>
							
						</td>

						<td class="text-center">							
							<b><?php echo $core->currency;?></b> <?php echo number_format($row->total_order, 2,'.',''); ?>
						</td>

						<td class="text-center">							
							<b><?php echo $core->currency;?></b> <?php echo number_format($sum_payment->total, 2,'.',''); ?>
						</td>

						<td class="text-center">							
							<b><?php echo $core->currency;?></b> <?php echo number_format($pendiente, 2,'.',''); ?>
						</td>

							<td align='center'>
									<div class="btn-group">
									    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" 
									    data-flip="false"
									     >Actions
									    </button>
									    <div class="dropdown-menu scrollable-menu">
									    	<a  class="dropdown-item" data-toggle="modal" data-target="#charges_list" data-id="<?php echo $row->order_id;?>"><i style="color:#343a40" class="fa fa-search"></i>&nbsp;Charges</a>       
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
                $(".resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
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


</div>
<?php }?>
