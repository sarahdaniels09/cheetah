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

        
		$order_id = intval($_REQUEST['id']);
	
		$sWhere="";

        if($order_id>0){

			$sWhere.=" where order_id = '".$order_id."'";
        }

      
	
		$sql="SELECT * FROM charges_order 
			$sWhere
			
			 order by id_charge desc 
			 ";


        $query_count=$db->query($sql);   		
      	$db->execute();
    	$numrows= $db->rowCount();    


        $db->query($sql); 
        $data= $db->registros();


        $sql_order="SELECT * FROM add_order where order_id= '".$order_id."' "; 


        $db->query($sql_order); 
        $order_data= $db->registro();
		
		
?>
<div class="table-responsive">


	<table id="zero_config" class="table table-sm table-condensed table-hover table-striped custom-table-checkbox">
		<thead>
			<tr>
				<th class="text-center"><b>Payment number</b></th>
				<th class="text-center"><b><?php echo $lang['ddate'] ?></b></th>			
				<th class="text-center"><b><?php echo $lang['paymode'] ?></b></th>
				<th class="text-center"><b>Total paid</b></th>				
				<th class="text-center"></th>				
				
				
			</tr>
		</thead>
		<tbody id="projects-tbl">

		
			<!--  -->
			<?php

			$count=0;
			$sumador_total =0;
			 foreach ($data as $row){

				$db->query("SELECT * FROM met_payment where id= '".$row->payment_type."'"); 
        		$payment_type= $db->registro();        		
			?>
						<tr class="card-hover" id="item_<?php echo $row->id_charge;?>">						
						
						<td class="text-center">							
							<?php echo $row->id_charge;?>
						</td>
						<td class="text-center">							
							<?php echo $row->charge_date;?>
						</td>

						<td class="text-center">							
							<?php echo $payment_type->met_payment;?>
						</td>						

						<td class="text-center">							
							<b><?php echo $core->currency;?></b> <?php echo number_format($row->total, 2,'.',''); ?>
						</td>
						<td class="text-right">
							<a target="blank" href="print_charge.php?id=<?php echo $row->id_charge;?>" class="btn btn-secondary btn-xs"><i class="fa fa-print"></i></a>

							<button type="button" data-toggle="modal" data-target="#charges_edit" data-id_charge="<?php echo $row->id_charge;?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>


							<button type="button" onclick="delete_charge('<?php echo $row->id_charge;?>')" name="remove_row" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
						</td>

							
							
					</tr>
			<?php
				 $count++;
				  $sumador_total+=$row->total;
			   }

			  $total_pendiente = $order_data->total_order- $sumador_total;

			$due_date=date('Ymd',strtotime($order_data->due_date));
			$fecha_hoy=date('Ymd');

			  if($total_pendiente==0){

			  	 $db->query("UPDATE add_order SET  status_invoice =1  WHERE order_payment_method >1 and order_id='".$order_id."'");   
       
        		$db->execute();

			  } else if ($fecha_hoy>$due_date){

			  	$db->query("UPDATE add_order SET  status_invoice =3  WHERE  order_payment_method >1 andorder_id='".$order_id."' and order_payment_method >1");   
       
        		$db->execute();
			  }else{

			  	 $db->query("UPDATE add_order SET  status_invoice =2  WHERE order_payment_method >1 and order_id='".$order_id."'");   
       
        		$db->execute();
			  }
			  ?>
					<tr class="card-hover">
						<td colspan="1"></td>
						<td colspan="1"></td>
						<td class="text-right"><b>Amount:</b> </td>
						<td  class="text-center"><?php echo number_format($order_data->total_order, 2,'.',''); ?> </td>						
						<td colspan="1"></td>
					</tr>

					<tr class="card-hover">
						<td colspan="1"></td>
						<td colspan="1"></td>
						<td class="text-right"><b>Total Paid:</b> </td>
						<td  class="text-center"> <?php echo number_format($sumador_total, 2,'.',''); ?> </td>						
						<td colspan="1"></td>
					</tr>

					<tr class="card-hover">
						<td colspan="1"></td>
						<td colspan="1"></td>
						<td class="text-right"><b>Balance:</b> </td>
						<td  class="text-center"> <?php echo number_format($total_pendiente, 2,'.',''); ?> </td>						
						<td colspan="1"></td>
					</tr>

			
		</tbody>
		
	</table>


</div>

