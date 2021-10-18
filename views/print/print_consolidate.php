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

if (isset($_GET['id'])) {
    $data= getConsolidatePrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount']!=1){
    redirect_to("consolidate_list.php");
}



$row=$data['data'];

$db->query("SELECT * FROM consolidate_detail WHERE consolidate_id='".$_GET['id']."'"); 
$order_items= $db->registros();

$db->query("SELECT * FROM met_payment where id= '".$row->order_pay_mode."'"); 
$met_payment= $db->registro();


$db->query("SELECT * FROM courier_com where id= '".$row->order_courier."'"); 
$courier_com= $db->registro();

$fecha=date("Y-m-d :h:i A", strtotime($row->order_datetime));

$db->query("SELECT * FROM users where id= '".$row->receiver_id."'"); 
$receiver_data= $db->registro();



$db->query("SELECT * FROM address_shipments where order_track='".$row->c_prefix.$row->c_no."'"); 
$address_order= $db->registro();

$db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
$sender_data= $db->registro();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/uploads/favicon.png">
	
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Tracking - <?php echo $row->c_prefix.$row->c_no; ?></title>

    <style>

        * { margin: 0; padding: 0; }
        body {
            font: 14px/1.4 Helvetica, Arial, sans-serif;
        }
        #page-wrap { width: 800px; margin: 0 auto; }

        textarea { border: 0; font: 14px Helvetica, Arial, sans-serif; overflow: hidden; resize: none; }
        table { border-collapse: collapse; }
        table td, table th { border: 1px solid black; padding: 5px; }
		tr.noBorder td {
		  border: 0;
		}
		
		td.Border td {
		  border: 1px;
		}

        #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

        #address { width: 250px; height: 150px; float: left; }
        #customer { overflow: hidden; }

        #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; overflow: hidden; }
        #customer-title { font-size: 20px; font-weight: bold; float: left; }

        #meta { margin-top: 1px; width: 100%; float: right; }
        #meta td { text-align: right;  }
        #meta td.meta-head { text-align: left; background: #6c757d; }
        #meta td textarea { width: 100%; height: 20px; text-align: right; }
		
		#signing { margin-top: 0px; width: 100%; float: center; }
        #signing td { text-align: center;  }
        #signing td.signing-head { text-align: center; background: #eee; }
        #signing td textarea { width: 100%; height: 20px; text-align: center; }

        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th { background: #6c757d; }
        #items textarea { width: 80px; height: 50px; }
        #items tr.item-row td {  vertical-align: top; }
        #items td.description { width: 300px; }
        #items td.item-name { width: 175px; }
        #items td.description textarea, #items td.item-name textarea { width: 100%; }
        #items td.total-line { border-right: 0; text-align: right; }
        #items td.total-value { border-left: 0; padding: 10px; }
        #items td.total-value textarea { height: 20px; background: none; }
        #items td.balance { background: #6c757d; }
        #items td.blank { border: 0; }

        #terms { text-align: center; margin: 20px 0 0 0; }
        #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
        #terms textarea { width: 100%; text-align: center;}



        .delete-wpr { position: relative; }
        .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }

        /* Extra CSS for Print Button*/
        .button {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
            margin-top: 20px;
            padding: 12px 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -webkit-transition: all 60ms ease-in-out;
            transition: all 60ms ease-in-out;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            text-align: center;
            white-space: nowrap;
            text-decoration: none !important;

            color: #fff;
            border: 0 none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.3;
            -webkit-appearance: none;
            -moz-appearance: none;

            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 160px;
            -ms-flex: 0 0 160px;
            flex: 0 0 160px;
        }
        .button:hover {
            -webkit-transition: all 60ms ease;
            transition: all 60ms ease;
            opacity: .85;
        }
        .button:active {
            -webkit-transition: all 60ms ease;
            transition: all 60ms ease;
            opacity: .75;
        }
        .button:focus {
            outline: 1px dotted #959595;
            outline-offset: -4px;
        }

        .button.-regular {
            color: #202129;
            background-color: #edeeee;
        }
        .button.-regular:hover {
            color: #202129;
            background-color: #e1e2e2;
            opacity: 1;
        }
        .button.-regular:active {
            background-color: #d5d6d6;
            opacity: 1;
        }

        .button.-dark {
            color: #FFFFFF;
            background: #333030;
        }
        .button.-dark:focus {
            outline: 1px dotted white;
            outline-offset: -4px;
        }

        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
		h4 {
			border-bottom: 1px solid black;
		}

    </style>
</head>
<body>
<div id="page-wrap">
    <table width="100%">
        <tr>
            <td style="border: 0;  text-align: left" width="18%">
			<div id="logo">
					<?php echo ($core->logo) ? '<img src="assets/'.$core->logo.'" alt="'.$core->site_name.'" width="190" height="39"/>': $core->site_name;?>
            </td>
			<td style="border: 0;  text-align: center" width="56%">
				<?php echo $lang['inv-shipping1'] ?>: <?php echo $core->c_nit; ?> </br> 				 
				<?php echo $lang['inv-shipping2'] ?>: <?php echo $core->c_phone; ?></br>
				<?php echo $lang['inv-shipping3'] ?>: <?php echo $core->site_email; ?></br>
				<?php echo $lang['inv-shipping4'] ?>: <?php echo $core->c_address; ?> - <?php echo $core->c_country; ?>-<?php echo $core->c_city; ?>
			</td>
            <td style="border: 0;  text-align: center" width="48%">
				</br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $row->c_prefix.$row->c_no; ?>&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=72&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0&modulewidth=50' alt=''/>
			</td>
			</div>
        </tr>
    </table>
    <hr>
    </br>
    <div id="customer">

        <table id="meta">
            <tr>
                <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="62%">
                <strong><?php echo $lang['inv-shipping5'] ?></strong> </br>
				<table id="items">
					<b><?php echo $sender_data->fname." ".$sender_data->lname; ?></b></br> </br>
					<?php echo $address_order->sender_address; ?> </br>
					<?php echo $address_order->sender_country." | ".$address_order->sender_city; ?> </br>
					<?php echo $sender_data->phone; ?> </br>
					<?php echo $sender_data->email; ?> 
				</table>	
				</td>
				<td class="meta-head"><p style="color:white;"><?php echo $lang['inv-shipping6'] ?></p></td>
                <td>
					<?php echo $met_payment->met_payment; ?>
				</td>	
            </tr>
            <tr>
				<td class="meta-head"><p style="color:white;"><?php echo $lang['inv-shipping7'] ?></p></td>
                <td><?php echo $courier_com->name_com; ?></td>
            </tr>
            <tr>
                <td class="meta-head"><p style="color:white;"><?php echo $lang['inv-shipping8'] ?></p></td>
                <td><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <td class="meta-head"><p style="color:white;"><?php echo $lang['inv-shipping9'] ?>.</p></td>
                <td><b><?php echo $row->c_prefix.$row->c_no; ?></b></td>
            </tr>
        </table>
    </div>
    <table id="items">
        <tr>
            <th colspan="3" style="color:white;"><b><?php echo $lang['ltracking'] ?></b></th>                
            <th colspan="3" style="color:white;" class="text-right"><b>Weights</b></th>
            <th colspan="2" style="color:white;" class="text-right"><b>Weight Vol.</b></th>
        </tr>

        <?php 
            $sumador_total=0;
            $sumador_libras=0;
            $sumador_volumetric=0;

            $precio_total=0;
            $total_impuesto=0;
            $total_seguro=0;
            $total_peso=0;
            $total_descuento=0;
            $total_impuesto_aduanero =0;

            foreach ($order_items as $row_order_item){
               
                $weight_item = $row_order_item->weight;
                
                $total_metric = $row_order_item->length * $row_order_item->width * $row_order_item->height/$row->volumetric_percentage;  

                // calculate weight x price
                if ($weight_item > $total_metric) {

                    $calculate_weight = $weight_item;
                    $sumador_libras+=$weight_item;//Sumador

                } else {

                    $calculate_weight = $total_metric;                                                 
                    $sumador_volumetric+=$total_metric;//Sumador
                }

                $precio_total=$calculate_weight* $row->value_weight;
                $precio_total=number_format($precio_total, 2,'.','');//Precio total formateado

                $sumador_total+=$precio_total;

                if($sumador_total>200){

                    $total_impuesto= $sumador_total *$row->tax_value /100;
                }

                $total_descuento= $sumador_total *$row->tax_discount /100;
                $total_peso =$sumador_libras + $sumador_volumetric;

                $total_seguro= $sumador_total * $row->tax_insurance_value /100;

                $total_impuesto_aduanero= $total_peso * $row->tax_custom_tariffis_value;

                $total_envio = ($sumador_total-$total_descuento)+ $total_impuesto + $total_seguro+ $total_impuesto_aduanero+$row->total_reexp;

                $sumador_total=number_format($sumador_total, 2,'.','');
                $sumador_libras=number_format($sumador_libras, 2,'.','');
                $sumador_volumetric=number_format($sumador_volumetric, 2,'.','');
                $total_envio=number_format($total_envio, 2,'.','');
                $total_seguro=number_format($total_seguro, 2,'.','');
                $total_peso=number_format($total_peso, 2,'.','');
                $total_impuesto_aduanero=number_format($total_impuesto_aduanero, 2,'.','');
                $total_impuesto=number_format($total_impuesto, 2,'.','');
                $total_descuento=number_format($total_descuento, 2,'.','');

                ?>

                <tr class="card-hover">
                    <td colspan="3"><b><?php echo $row_order_item->order_prefix.$row_order_item->order_no; ?> </b></td>                          
                    <td colspan="3" class="text-right"><?php echo $weight_item; ?></td>
                    <td colspan="2" class="text-right"><?php echo $row_order_item->weight_vol; ?></td>
                    
                   
                </tr>
            <?php

            }?>
    
            <tr class="card-hover">                                   
                <td colspan="3"></td>                                         
                <!-- <td  colspan="2"></td> -->
                <td  colspan="3" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
                <td  colspan="2" class="text-right"><?php echo $sumador_total; ?></td>              
                
                <!--  -->
            </tr>

            <tr class="">                                   
                <td colspan="3"><b>Price Lb:</b> <?php echo $row->value_weight;?></td>       
                <!-- <td  colspan="2"></td> -->
                
                
                <td  colspan="3" class="text-right"><b>Discount <?php echo $row->tax_discount; ?> % </b></td>
                <td class="text-right" colspan="2"><?php echo $total_descuento; ?></td>              
                
            </tr>

            <tr>                
                <td colspan="3"><b><?php echo $lang['left232'] ?>:</b> <span id="total_libras"><?php echo $sumador_libras; ?></span></td>
                <!-- <td  colspan="2"></td> -->
                                                                                             
                <td  colspan="3" class="text-right"><b>Shipping insurance <?php echo $row->tax_insurance_value; ?> % </b></td>
                <td class="text-right" colspan="2"  id="insurance"><?php echo $total_seguro; ?></td>              
                                                            
            </tr>

            <tr>
                <td colspan="3"><b><?php echo $lang['left234'] ?>:</b> <span id="total_volumetrico"><?php echo $sumador_volumetric; ?></span></td>                                            
                <!-- <td  colspan="2"></td> -->
                                                          
                <td  colspan="3" class="text-right"> <b>Customs tariffs <?php echo $row->tax_custom_tariffis_value; ?> %</b></td>
                <td class="text-right" id="total_impuesto_aduanero" colspan="2"><?php echo $total_impuesto_aduanero; ?></td>              
                                                           

            </tr>

            <tr>                
                <td colspan="3"><b><?php echo $lang['left236'] ?></b>: <span id="total_peso"><?php echo $total_peso; ?></span></td>                          
                <!-- <td  colspan="2"></td> -->
                
                <td  colspan="3"  class="text-right"><b>Tax <?php echo $row->tax_value; ?> % </b></td>
                <td class="text-right" colspan="2" id="impuesto"><?php echo $total_impuesto; ?></td> 
                                                                        
            </tr>


            <tr>                
                <td colspan="3"></td>                          
                <!-- <td  colspan="2"></td> -->
                
                <td  colspan="3"  class="text-right"><b>Re expedition</b></td>
                <td class="text-right" colspan="2" id="impuesto"><?php echo $row->total_reexp; ?></td> 
                                                                        
            </tr>   

            <tr>                                            
                <td  colspan="3"></td>
                <!-- <td  colspan="2"></td> -->
                
                <td  colspan="3" class="text-right"><b><?php echo $lang['add-title44'] ?> &nbsp; <?php echo $core->currency;?></b></td>
                <td class="text-right" colspan="2" id="total_envio"><?php echo $total_envio; ?></td>              
                                                                     

            </tr>
       </table>

<!--    end related transactions -->

        <div id="terms">
            <h5><?php echo $lang['inv-shipping18'] ?></h5>
			 <table id="related_transactions" style="width: 100%">
				<p align="justify"><?php echo cleanOut($core->interms);?></p>				
			</table>
			</br></br></br></br>
			<table id="signing">
				<tr class="noBorder">
					<td align="center"><h4></h4></td>
					<td align="center"><h4></h4></td>
				</tr>
				<tr class="noBorder">
					<td align="center"><?php echo $core->signing_company;?></td>
					<td align="center"><?php echo $core->signing_customer;?></td>
				</tr>
			</table>
        </div>
    <button class='button -dark center no-print'  onClick="window.print();" style="font-size:16px"><?php echo $lang['inv-shipping19'] ?>&nbsp;&nbsp; <i class="fa fa-print"></i></button>
</div>

</body>

</html>
