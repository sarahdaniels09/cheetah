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
    $data= getChargePrint($_GET['id']);
}

// if (!isset($_GET['id']) or $data['rowCount']!=1){
//     redirect_to("courier_list.php");
// }



$row=$data['data'];

$db->query("SELECT * FROM add_order WHERE order_id='".$row->order_id."'"); 
$row_order= $db->registro();


$db->query("SELECT * FROM users where id= '".$row_order->sender_id."'"); 
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
    <title>Charge - #<?php echo $row->id_charge; ?></title>

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

        #meta { margin-top: 1px; width: 100%; float: right;  }
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
				</br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $row->id_charge; ?>&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=72&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0&modulewidth=50' alt=''/>
			</td>
			</div>
        </tr>
    </table>
    <hr>
    </br>
    <div id="customer">

        <table id="meta">
            <tr>
                <td rowspan="5" style="border: 1px solid black;   text-align: left" width="62%">

                    <strong>DATE:</strong>				
					<?php echo $row->charge_date; ?></br> </br>

                    <strong>RECEIVED FROM:</strong>             
                    <?php echo $sender_data->fname." ".$sender_data->lname; ?></br> </br>

                    <strong>THE SUM OF:</strong>
					<?php echo number_format($row->total, 2,'.',''); ?> </br></br>

					<strong>IN CONCEPT OF:</strong> payment to shipping <b><?php echo $row_order->order_prefix.$row_order->order_no; ?></b>
                    
                    <?php if ($row->note!=null){?>

                    
                    <br>
                    <br>
                    <br>
                   

                     <strong>Note:</strong>             
                    <?php echo $row->note; ?></br> </br>

                <?php } ?>
				</td>
				
            </tr>
            
        </table>
    </div>
    

<!--    end related transactions -->

        <div id="terms" style="">
			 <table style="width: 100%;border: 1px solid black; border-radius: 30px">
                <tr>
                    <td><p align="justify">This voucher is valid without amendments or erasures and must have the signature and stamp of the authorized person.</p></td>
                </tr>
								
			</table>
			</br></br></br>
			<table id="signing">
				<tr class="noBorder">
					<td align="center"><h4></h4></td>
                    <td align="center"><h4></h4></td>
					<td align="center"><h4></h4></td>
				</tr>
				<tr class="noBorder">
                    <td align="center">Made by</td>
					<td align="center">Received</td>
					<td align="center">Authorized</td>
				</tr>


			</table>
        </div>
    <button class='button -dark center no-print'  onClick="window.print();" style="font-size:16px">Print receipt of payment &nbsp;&nbsp; <i class="fa fa-print"></i></button>
</div>

</body>

</html>
