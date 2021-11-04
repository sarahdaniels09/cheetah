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
header("Content-Disposition: attachment; filename=Report-accounts_receivable_summary_".date('d-m-Y').".xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);



$db = new Conexion;

        $range =$_REQUEST['range'];
        $agency_courier = intval($_REQUEST['agency_courier']);
        $pay_mode = intval($_REQUEST['pay_mode']);
        $customer_id = intval($_REQUEST['customer_id']);
    
        $sWhere="";
       
      
        if($agency_courier>0){

            $sWhere.=" and agency = '".$agency_courier."'";
        }


        if($customer_id>0){

            $sWhere.=" and sender_id = '".$customer_id."'";
        }

        if($pay_mode>0){

            $sWhere.=" and order_payment_method = '".$pay_mode."'";
        }
       if (!empty($range)){
         
    $fecha=  explode(" - ",$range);            
    $fecha= str_replace('/','-', $fecha);

    $fecha_inicio = date('Y-m-d', strtotime($fecha[0]));
    $fecha_fin = date('Y-m-d', strtotime($fecha[1]));


    $sWhere.=" and  order_date between '".$fecha_inicio."'  and '".$fecha_fin."'";
    
}


        $db->query("UPDATE add_order SET  status_invoice =3  WHERE due_date<now() and status_invoice !=1 and order_payment_method >1");     
                
       
        $db->execute();

    
        $sql="SELECT * FROM add_order where order_payment_method !=1  
            $sWhere
            
             order by order_id desc 
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
		Accounts receivable summary <br>

		['.$fecha[0].' - '.$fecha[1].']
		
		</h2>


		<table border=1>
		<tbody>
			<tr style="background-color: #3e5569; color: white">	

				<th class="text-center"></th>               
				<th><b>'.$lang['ltracking'].'</b></th>
                <th class="text-center"><b>Sender</b></th>
				<th><b>'.$lang['ddate'].'</b></th>
                <th class="text-center"><b>Due date</b></th>
                <th class="text-center"><b>'.$lang['lstatusinvoice'].'</b></th>                
                <th class="text-center"><b>Total amount</b></th>                
                <th class="text-center"><b>Total paid</b></th>              
                <th class="text-center"><b>balance</b></th>   			
			</tr>';

	if ($numrows>0){

		$count=1;
            $sumador_pendiente=0;
            $sumador_total=0;
            $sumador_pagado=0;

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

                $sumador_pendiente+= $pendiente;
                $sumador_total += $row->total_order;
                $sumador_pagado += $sum_payment->total;

            	$count++;

           

			$html.='<tr>';
			$html.='<td >'.$count.'</td>';	
			$html.='<td >'.$row->order_prefix.$row->order_no.'</td>';	
			$html.='<td>'.$sender_data->fname.' '.$sender_data->lname.'</td>';
			$html.='<td >'.$row->order_date.'</td>';	
			$html.='<td >'.$row->due_date.'</td>';	
			$html.='<td >'.$text_status.'</td>';	
			$html.='<td>'. number_format($row->total_order, 2,'.','').'</td>';		
			$html.='<td>'. number_format($sum_payment->total, 2,'.','').'</td>';		
			$html.='<td>'. number_format($pendiente, 2,'.','').'</td>';		
			$html.='</tr>';
		}

		$html.='<tr>';
		$html.='<td><b>TOTAL</td> </b>';				
		$html.='<td colspan="5"></td>';				
		$html.='<td><b>'. number_format($sumador_total, 2,'.','').' </b></td>';		
		$html.='<td><b>'. number_format($sumador_pagado, 2,'.','').' </b></td>';		
		$html.='<td><b>'. number_format($sumador_pendiente, 2,'.','').' </b></td>';		
		$html.='</tr>';
	}

$html.='</table></html>';
echo utf8_decode($html); 
?>
