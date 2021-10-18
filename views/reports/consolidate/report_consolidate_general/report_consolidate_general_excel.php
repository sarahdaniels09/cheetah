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



header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Report_consolidated_general_".date('d-m-Y').".xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);



$db = new Conexion;
$user = new User;
	$core = new Core;
	$userData = $user->getUserData();

$status_courier = intval($_REQUEST['status_courier']);
$agency = intval($_REQUEST['agency']);
$range =$_REQUEST['range'];
$customer_id = intval($_REQUEST['customer_id']);


$sWhere="";


if($status_courier>0){

	$sWhere.=" and  a.status_courier = '".$status_courier."'";
}

if($customer_id>0){

	$sWhere.=" and a.sender_id = '".$customer_id."'";
}


if($agency>0){

    $db->query("SELECT * FROM branchoffices where id= '".$agency."'"); 
    $agencys= $db->registro();

    $agencyFilter=$agencys->name_branch;

    $sWhere.=" and a.agency = '".$agency."'";

}else{

    $agencyFilter= 'All';
}



if($userData->userlevel==3){

            $sWhere.=" and  a.driver_id = '".$_SESSION['userid']."'";

        }


if (!empty($range)){
         
    $fecha=  explode(" - ",$range);            
    $fecha= str_replace('/','-', $fecha);

    $fecha_inicio = date('Y-m-d', strtotime($fecha[0]));
    $fecha_fin = date('Y-m-d', strtotime($fecha[1]));


    $sWhere.=" and  a.c_date between '".$fecha_inicio."'  and '".$fecha_fin."'";
    
}

$sql="SELECT a.total_weight, a.total_tax_discount, a.sub_total, a.total_tax_insurance, a.total_tax_custom_tariffis, a.total_tax,   a.total_order, a.consolidate_id, a.c_prefix, a.c_no, a.c_date, a.sender_id, a.order_courier,a.status_courier,  b.mod_style, b.color FROM
			 consolidate as a
			 INNER JOIN styles as b ON a.status_courier = b.id
			 $sWhere
			  and a.status_courier!=14

			 order by consolidate_id desc 
			 ";


$query_count=$db->query($sql);   		
	$db->execute();
$numrows= $db->rowCount();    


$db->query($sql); 
$data= $db->registros();		

$fecha= str_replace('-','/', $fecha);

$html='
	<html>
		<body>
		
		<h2>'.$core->site_name.'<br>
		Consolidated report general <br>

		['.$fecha[0].' - '.$fecha[1].']
		<br>
		agency: '.$agencyFilter.'

		</h2>


		<table border=1>
		<tbody>
			<tr style="background-color: #3e5569; color: white">				
				<th><b></b></th>
				<th><b>'.$lang['ltracking'].'</b></th>
				<th><b>'.$lang['ddate'].'</b></th>
				<th><b>Sender</b></th>
				<th><b>'.$lang['lorigin'].'</b></th>
				<th><b>'.$lang['lstatusshipment'].'</b></th>
				<th><b>Weight</b></th>
				<th><b>Subtotal</b></th>
				<th><b>Discount</b></th>
				<th><b>Insurance</b></th>
				<th><b>Customs tariffs</b></th>
				<th><b>Tax</b></th>
				<th><b>Total</b></th>
			</tr>';

	if ($numrows>0){

		$count=0;
		$sumador_weight=0;
		$sumador_subtotal=0;
		$sumador_discount=0;
		$sumador_insurance=0;
		$sumador_c_tariff=0;
		$sumador_tax=0;
		$sumador_total=0;

		foreach ($data as $row){

			$db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
    		$sender_data= $db->registro();

    		
    		$db->query("SELECT * FROM courier_com where id= '".$row->order_courier."'"); 
    		$courier_com= $db->registro();
				$db->query("SELECT * FROM address_shipments where order_track='".$row->c_prefix.$row->c_no."'"); 
			    $address_order= $db->registro();
    		

			$weight= number_format($row->total_weight, 2,'.','');
			$sub_total= number_format($row->sub_total, 2,'.','');		
			$discount= number_format($row->total_tax_discount, 2,'.','');			
			$insurance= number_format($row->total_tax_insurance, 2,'.','');			
			$custom_c= number_format($row->total_tax_custom_tariffis, 2,'.','');					
			$tax= number_format($row->total_tax, 2,'.','');
			$total= number_format($row->total_order, 2,'.','');

			$sumador_weight+=$weight;
			$sumador_subtotal+=$sub_total;
			$sumador_discount+=$discount;
			$sumador_insurance+=$insurance;
			$sumador_c_tariff+=$custom_c;
			$sumador_tax+=$tax;
			$sumador_total+=$total;
			$count++;


			$html.='<tr>';
			$html.='<td ><b>'.$count.'</b></td>';
			$html.='<td>'.$row->c_prefix.$row->c_no.'</td>';
			$html.='<td>'.$row->c_date.'</td>';
			$html.='<td>'.$sender_data->fname.' '.$sender_data->lname.'</td>';
			$html.='<td>'.$address_order->sender_country.'-'.$address_order->sender_city.'</td>';
			$html.='<td>'.$row->mod_style.'</td>';			
			$html.='<td>'. number_format($row->total_weight, 2,'.','').'</td>';
			$html.='<td>'. number_format($row->sub_total, 2,'.','').'</td>';
			$html.='<td>'. number_format($row->total_tax_discount, 2,'.','').'</td>';
			$html.='<td>'. number_format($row->total_tax_insurance, 2,'.','').'</td>';
			$html.='<td>'. number_format($row->total_tax_custom_tariffis, 2,'.','').'</td>';
			$html.='<td>'. number_format($row->total_tax, 2,'.','').'</td>';
			$html.='<td>'. number_format($row->total_order, 2,'.','').'</td>';
			$html.='</tr>';
		}

		$html.='<tr>';
		$html.='<td><b>TOTAL</td> </b>';				
		$html.='<td  colspan="5"></td>';				
		$html.='<td><b>'. number_format($sumador_weight, 2,'.','').' </b></td>';
		$html.='<td><b>'. number_format($sumador_subtotal, 2,'.','').' </b></td>';
		$html.='<td><b>'. number_format($sumador_discount, 2,'.','').' </b></td>';
		$html.='<td><b>'. number_format($sumador_insurance, 2,'.','').' </b></td>';
		$html.='<td><b>'. number_format($sumador_c_tariff, 2,'.','').' </b></td>';
		$html.='<td><b>'. number_format($sumador_tax, 2,'.','').' </b></td>';
		$html.='<td><b>'. number_format($sumador_total, 2,'.','').' </b></td>';
		$html.='</tr>';
	}

$html.='</table></html>';
echo utf8_decode($html); 
?>
