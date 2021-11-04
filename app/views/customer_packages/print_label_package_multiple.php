
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="assets/uploads/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Packages print</title>
	 <link type='text/css' href='assets/css/label_custom.css' rel='stylesheet'/>

	 	 <style type="text/css">
	 	.app-print-data-list-unico {
		    margin-top: 1px;
		    height: 15px;
		}
		.app-print-data-list-unico>div:nth-child(1) {
		    width: 100%;
		    text-align: center;
		    font-size: 14px;
		}

		.app-print-data-list-unico>div {
		    float: left;
		    font-size: 14px;
		}
	 </style>

</head>

<body onload="window.print();">
	<div id="page-wrap">

		<?php

			$userData = $user->getUserData();

			require_once('helpers/querys.php');

			if (!isset($_GET['data'])){

			    redirect_to("customer_packages_list.php");
			}


			if (isset($_GET['data'])) {

			    $data = json_decode($_GET['data']);

			    foreach ($data as $key) {

			    	$data_key= getPackagePrintMultiple($key);			


					$row=$data_key['data'];

				
			    // var_dump($row->order_id);


					$db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
					$sender_data= $db->registro();


					$db->query("SELECT * FROM courier_com where id= '".$row->order_courier."'"); 
					$courier_com= $db->registro();

					$db->query("SELECT * FROM met_payment where id= '".$row->order_pay_mode."'"); 
					$met_payment= $db->registro();

					$db->query("SELECT * FROM shipping_mode where id= '".$row->order_service_options."'"); 
					$order_service_options= $db->registro();


        		$db->query("SELECT * FROM address_shipments where order_track='".$row->order_prefix.$row->order_no."'"); 
			    $address_order= $db->registro();

					// total shipping cost
					$total=$row->total_order;
					$total=number_format($total,2,'.','');


					$db->query("SELECT SUM(order_item_length) as total0 from customers_packages_detail where order_id='".$row->order_id."'");
					$db->execute();
					$row0 =$db->registro();

					$rw_add0= $row0->total0;


					// volumetric query of the box width

					$db->query("SELECT SUM(order_item_width) as total1 from customers_packages_detail where order_id='".$row->order_id."'");
					$db->execute();
					$row1 =$db->registro();

					$rw_add1= $row1->total1;

					// volumetric query of the box width

					$db->query("SELECT SUM(order_item_height) as total2 from customers_packages_detail where order_id='".$row->order_id."'");
					$db->execute();
					$row2 =$db->registro();

					$rw_add2= $row2->total2;

					$db->query("SELECT SUM(order_item_height) as total3 from customers_packages_detail where order_id='".$row->order_id."'");
					$db->execute();
					$row3 =$db->registro();

					$rw_add3= $row3->total3;

					$length= $rw_add0;//Length
					$width= $rw_add1;//Width
					$height= $rw_add2;//Height

					if ($row->volumetric_percentage) {
						$volumetric_percentage=$row->volumetric_percentage;
					}else{

						$volumetric_percentage =$core->meter;
					}
					$total_metric = $length * $width * $height/$volumetric_percentage;  


					$db->query("SELECT * FROM customers_packages_detail WHERE order_id='".$row->order_id."'"); 
					$order_items= $db->registros();



					$sumador_libras=0;
					$sumador_volumetric=0;
					$count=0;
					foreach ($order_items as $row_item){

					    $weight_item = $row_item->order_item_weight;
					    
					    $total_metric = $row_item->order_item_length * $row_item->order_item_width * $row_item->order_item_height/$volumetric_percentage;  

					    // calculate weight x price
					    if ($weight_item > $total_metric) {

					        $calculate_weight = $weight_item;
					        $sumador_libras+=$weight_item;//Sumador

					    } else {

					        $calculate_weight = $total_metric;                                                 
					        $sumador_volumetric+=$total_metric;//Sumador
					    }
					        
					    $count++;
					}

			?>



				<div class="container_etiqueta" style="min-height: 540px; max-height: 540px; min-width: 420px; max-width: 420px;">
					<div class="print_ticket_zebra" style="max-height: 110px; min-height: 110px;">
						<div style="width: 30%;line-height:110px;margin:0px auto;text-align:center;">
							<?php echo ($core->logo) ? '<img class="logo" style="vertical-align:middle" src="assets/'.$core->logo.'" alt="'.$core->site_name.'" width="145" height="35"/>': $core->site_name;?>		
						</div>
						<div style="width: 70%;">
							<strong><?php echo $core->site_name; ?><br></strong>
								
								<?php echo $core->c_country; ?>, <?php echo $core->c_city; ?>, <?php echo $core->c_postal; ?>.<br>
								TEL: <?php echo $core->c_phone; ?>
						</div>
					</div>
					<div class="app_print_ticket_zebra" style="margin-top: -18px; height: 100px; max-width: 420px; margin-left: 22px">
							<img style="width: 380px; min-height: 100px; max-height: 100px;" src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $row->order_prefix.$row->order_no; ?>&code=EANUCC128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0' alt=''/>
					</div>
					<div class="app_easypack_ticket_zebra" style="padding-top:50px; max-width: 420px; text-align: center">
						<div class="track_courier"><strong> <?php echo $row->order_prefix.$row->order_no; ?></strong></div>
					</div>
					<div class="app_easypack_print" style="padding-top: 5px;font-weight: bold">
						<div>Package ref: &nbsp;</div>
						<div>&nbsp;</div>
					</div>
					<div class="datas_easypack_print">
						<div>Date: &nbsp;<?php echo $row->order_date; ?> &nbsp;|&nbsp;Qnty: &nbsp;<?php echo $count; ?>&nbsp;|&nbsp;W: &nbsp;<?php if ($sumador_libras > $sumador_volumetric) { echo  round_out($sumador_libras); } else { echo round_out($sumador_volumetric); }?>&nbsp;|&nbsp;USFOB: &nbsp;<?php echo $row->total_order;?> </div>
					</div>
						<div class="app_easypack_print">
							<div>L :  <?php echo $length;?>   &nbsp;</div>
							<div>W : <?php echo $width;?> H :  <?php echo $height;?></div>
						</div>
					
					<div class="app_easypack_print">
						<div><strong>REF. SERVICE: </strong>&nbsp;</div>
						<div><?php if($order_service_options){echo $order_service_options->ship_mode;} ?> &nbsp;|&nbsp; <?php if($courier_com){echo $courier_com->name_com;} ?></div>
					</div>
					<div class="app_easypack_ticket_zebra" style="padding-top: 3px; padding-bottom: 3px; font-size: 22px; max-height: 18px; min-height: 25px;">
						<strong><?php if($met_payment!=null){ echo $met_payment->met_payment;} ?></strong>
					</div>
					<br>
					<div class="app_easypack_ticket_zebra" style="font-size: 37px; margin-top: 1px; margin-left: 0px; ">
					<strong><?php echo $address_order->sender_country." - ".$address_order->sender_city; ?></strong>
					</div>
					<div class="app_easypack_qr_code" style="max-height: 110px; min-height: 110px;">
						<div style="width: 30%;">
							<img src='https://barcode.tec-it.com/barcode.ashx?data=Tracking:+<?php echo $row->order_prefix.$row->order_no; ?>&code=QRCode&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=72&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0&eclevel=L' alt=''/>
						</div>
						<div style="width: 70%;" >
							<?php echo $sender_data->fname; ?>  <?php echo $sender_data->lname; ?> <br>
							<?php echo $address_order->sender_address." <br> ".$sender_data->phone; ?>
						</div>
					</div>
					<div class="app-print-data-list-unico">
                        <div><strong>Locker : <?php echo $sender_data->locker; ?></strong></div>
                </div>
				</div>

				<br><br><br><br><br><br><br>
				

			<?php
		}
	} ?>

</div>
</body>
</html>
