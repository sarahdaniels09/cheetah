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



	require_once("loader.php");
	require_once("helpers/querys.php");
	require_once ("helpers/phpmailer/class.phpmailer.php");
    require_once ("helpers/phpmailer/class.smtp.php");



	session_start();
	// get the HTML
     ob_start();
	 if (!isset($_SESSION['userid'])){

		 header("location: login.php");
		 exit;
	 }
	
    if (isset($_GET['id'])) {
        $data= getCustomerPackagePrint($_GET['id']);
    }

    


    $row=$data['data'];

    $core= new Core;
    $db= new Conexion;

    $db->query("SELECT * FROM styles where id= '".$row->status_courier."'"); 
    $status_courier= $db->registro();

    $db->query("SELECT * FROM users where id= '".$row->sender_id."'"); 
    $sender_data= $db->registro();


    $db->query("SELECT * FROM courier_com where id= '".$row->order_courier."'"); 
    $courier_com= $db->registro();

    $db->query("SELECT * FROM met_payment where id= '".$row->order_pay_mode."'"); 
    $met_payment= $db->registro();

    $db->query("SELECT * FROM shipping_mode where id= '".$row->order_service_options."'"); 
    $order_service_options= $db->registro();

    $db->query("SELECT * FROM packaging where id= '".$row->order_package."'"); 
    $packaging= $db->registro();


    $db->query("SELECT * FROM delivery_time where id= '".$row->order_deli_time."'"); 
    $delivery_time= $db->registro();

    $db->query("SELECT * FROM branchoffices where id= '".$row->agency."'"); 
    $branchoffices= $db->registro();

    $db->query("SELECT * FROM offices where id= '".$row->origin_off."'"); 
    $offices= $db->registro();

   


$db->query("SELECT * FROM address_shipments where order_track='".$row->order_prefix.$row->order_no."'"); 
$address_order= $db->registro();


    $db->query("SELECT * FROM customers_packages_detail WHERE order_id='".$_GET['id']."'"); 
    $order_items= $db->registros();

     $dias_ = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    $meses_=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
                                 
    // echo $dias_[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
                            
$fecha=date("Y-m-d :h:i A", strtotime($row->order_datetime));
    
   //SENDMAIL PHP

    if ($core->mailer=='PHP') {	 
		

		require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
			

	    
	     include(dirname('__FILE__').'/pdf/documentos/html/package_print.php');
		$content = ob_get_clean();

	    try
	    {
	        // init HTML2PDF
	        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
	        // display the full page
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

	    	$to = strip_tags($_REQUEST['sendto']);
			$from = $core->site_email;
			$subject = strip_tags($_REQUEST['subject']);
			$message = strip_tags($_REQUEST['message']);
			$separator = md5(time());
			$eol = PHP_EOL;
			$filename = $row->order_prefix.$row->order_no.'.pdf';
			$pdfdoc = $html2pdf->Output('', 'S');
			$attachment = chunk_split(base64_encode($pdfdoc));
			
			$headers = "From: ".$from.$eol;
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;

		
			$body="";
			$body .= "Content-Transfer-Encoding: 7bit".$eol;
			$body .= "This is a MIME encoded message.".$eol; //had one more .$eol


			$body .= "--".$separator.$eol;
			$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$body .= $message.$eol; 


			$body .= "--".$separator.$eol;
			$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$body .= "Content-Transfer-Encoding: base64".$eol;
			$body .= "Content-Disposition: attachment".$eol.$eol;
			$body .= $attachment.$eol;
			$body .= "--".$separator."--";


			if (mail($to, $subject, $body, $headers)){
			echo "<div class='alert alert-success'>Message has been sent successfully!</div>";	
			} else {
				echo "<div class='alert alert-warning'>Mensaje no enviado!!!</div>";
			}
	        // send the PDF
	        // $html2pdf->Output($row->order_prefix.$row->order_no.'.pdf');

	    }catch(HTML2PDF_exception $e) {
	        echo $e;
	        exit;
	    }

    } elseif ($core->mailer=='SMTP') {
                

    //PHPMAILER PHP

	require_once(dirname(__FILE__).'/pdf/html2pdf.class.php');
		

    
     include(dirname('__FILE__').'/pdf/documentos/html/package_print.php');
	$content = ob_get_clean();

	try
		{

        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

		$filename = $row->order_prefix.$row->order_no.'.pdf';
		$emailAttachment = $html2pdf->Output('','S');
        // send the PDF

        $destinatario=strip_tags($_REQUEST['sendto']);

        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = $core->smtp_port; 
        $mail->IsHTML(true); 
        $mail->CharSet = "utf-8";
        
        // Datos de la cuenta de correo utilizada para enviar vía SMTP
        $mail->Host = $core->smtp_host;       // Dominio alternativo brindado en el email de alta
        $mail->Username = $core->smtp_user;    // Mi cuenta de correo
        $mail->Password = $core->smtp_password;    //Mi contraseña


        $mail->From = $core->site_email; // Email desde donde envío el correo.
        $mail->FromName = $core->smtp_names;
        $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario
		$menssage = strip_tags($_REQUEST['message']);

        $mail->Subject = strip_tags($_REQUEST['subject']);   // Este es el titulo del email.
		$mail->Body = $menssage;
		$mail->AltBody = $menssage;
		$mail->AddStringAttachment($emailAttachment, ''.$filename.'', 'base64', 'application/pdf');// attachment
		if(!$mail->send()) 
		{
		    echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
		    echo "<div class='alert alert-success'>Message has been sent successfully!</div>";
		}
   	 // send the PDF
		      

    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

  }
