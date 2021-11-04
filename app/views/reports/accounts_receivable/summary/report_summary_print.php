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

    
        $sql="SELECT * FROM add_order where order_payment_method >1  
           
            $sWhere
            
             order by order_id desc 
             ";


        $query_count=$db->query($sql);          
        $db->execute();
        $numrows= $db->rowCount();    


        $db->query($sql); 
        $data= $db->registros(); 

$fecha= str_replace('-','/', $fecha);

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
    <title>Accounts receivable summary</title>

    <style>

         { margin: 0; padding: 0; }
        body {
            font: 14px/1.4 Helvetica, Arial, sans-serif;
        }
         @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }

        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;

        }

        th, td {
          padding:8px;
        }

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

    </style>
</head>
<body>
<div id="page-wrap">

    <h2><?php echo $core->site_name;?><br>
    Accounts receivable summary <br>

    [<?php echo $fecha[0].' - '.$fecha[1];?>] <br>

    
    </h2>


    <table>
        <tr>
                
                <th class="text-center"></th>               
                <th><b><?php echo $lang['ltracking'] ?></b></th>
                <th class="text-center"><b>Sender</b></th>
                <th class="text-center"><b><?php echo $lang['ddate'] ?></b></th>
                <th class="text-center"><b>Due date</b></th>
                <th class="text-center"><b><?php echo $lang['lstatusinvoice'] ?></b></th>
                
                <th class="text-center"><b>Total amount</b></th>                
                <th class="text-center"><b>Total paid</b></th>              
                <th class="text-center"><b>balance</b></th>      
                
                
        </tr>

    <?php

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

                
            ?>
                        <tr class="card-hovera">
                            <td><?php echo $count; ?></td>
                            
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

                            
                            
                    </tr>
        <?php 

        $count++;
        }
        ?>

       <tr>
       <td class="text-left"><b>TOTAL</b></td>                            

        <td colspan="5"></td>
        <td class="text-center  ">                          
            <b ><?php echo number_format($sumador_total, 2,'.',''); ?> </b>
        </td>

        <td class="text-center  ">                          
            <b ><?php echo number_format($sumador_pagado, 2,'.',''); ?> </b>
        </td>

        <td class="text-center  ">                          
            <b ><?php echo number_format($sumador_pendiente, 2,'.',''); ?> </b>
        </td>
       </tr>
    <?php 
    }
    ?>


    </table>

    <button class='button -dark center no-print'  onClick="window.print();" style="font-size:16px; margin-top: 20px;">Print &nbsp;&nbsp; <i class="fa fa-print"></i></button>
</div>

</body>

</html>
