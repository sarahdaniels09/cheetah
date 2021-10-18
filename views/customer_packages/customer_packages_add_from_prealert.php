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



	if (!$user->is_Admin())
    redirect_to("login.php");
	require_once ("helpers/querys.php");
    require_once 'helpers/vendor/autoload.php'; 

    use Twilio\Rest\Client; 

    require_once ("helpers/phpmailer/class.phpmailer.php");
    require_once ("helpers/phpmailer/class.smtp.php");



     if (isset($_GET['id'])) {
        $data_pre_alert= getPreAlert($_GET['id']);
    }

    if (!isset($_GET['id']) or $data_pre_alert['rowCount']!=1){
        redirect_to("prealert_list.php");
    }

    $data_pre_alert=$data_pre_alert['data'];

	$userData = $user->getUserData();


    $db->query("SELECT * FROM users where id= '".$data_pre_alert->customer_id."'"); 
    $sender_data= $db->registro();

            $db= new Conexion;

             //Prefix tracking   
            $sql = "SELECT * FROM settings";
            
            $db->query($sql);

            $db->execute();

            $settings =$db->registro();

            $order_prefix = $settings->prefix_online_shopping;
            $site_email = $settings->site_email;
            $check_mail = $settings->mailer;
            $names_info = $settings->smtp_names;
            $emailaddress = $settings->email_address;
            $mlogo          = $settings->logo;
            $msite_url      = $settings->site_url;
            $msnames        = $settings->site_name;

            //SMTP
           
            $smtphoste = $settings->smtp_host;
            $smtpuser = $settings->smtp_user;
            $smtppass = $settings->smtp_password;
            $smtpport = $settings->smtp_port;
            $smtpsecure = $settings->smtp_secure;
            $value_weight = $settings->value_weight;
            $meter = $settings->meter;            
            // $c_tariffs = $settings->c_tariffs;            
       

        if (isset($_POST["create_invoice"])) {
         
            $db->query("SELECT MAX(order_no) AS order_no FROM customers_packages");
            $db->execute();

            $invNum =$db->fetch_assoc();
            $max_id = $invNum['order_no'];
            $cod=$max_id;
            $next_order=$core->online_shopping_track(); 
            var_dump($next_order);
            $date = date('Y-m-d', strtotime(trim($_POST["order_date"]))); 
            $time= date("H:i:s");

            $date = $date.' '.$time; 

            if (isset($_POST["prefix_check"])==1) {
                

                $code_prefix = trim($_POST["code_prefix2"]);               

            }else{

                $code_prefix = trim($_POST["code_prefix"]);
            }

            $is_prealert=1;
            $status_invoice=2;
            $status_courier=2;

           
                $db->query("
                INSERT INTO customers_packages 
                (
                    user_id, 
                    order_prefix, 
                    order_no, 
                    order_date,
                    sender_id,   
                    sender_address_id,
                    tax_value,
                    tax_insurance_value,
                    tax_custom_tariffis_value,
                    value_weight,
                    volumetric_percentage, 
                    total_weight,
                    sub_total,
                    tax_discount,
                    total_tax_insurance,
                    total_tax_custom_tariffis, 
                    total_tax,
                    total_tax_discount, 
                    total_reexp,
                    total_order,       
                    order_datetime,
                    agency,
                    origin_off,
                    order_package, 
                    order_courier,
                    order_service_options, 
                    order_deli_time,  
                    status_courier,
                    driver_id, 
                    status_invoice,
                    tracking_purchase,
                    provider_purchase,
                    price_purchase,
                    is_prealert
                    )
                VALUES
                    (
                    :user_id, 
                    :order_prefix, 
                    :order_no, 
                    :order_date, 
                    :sender_id, 
                    :sender_address_id,
                    :tax_value,
                    :tax_insurance_value,
                    :tax_custom_tariffis_value, 
                    :value_weight,
                    :volumetric_percentage,
                    :total_weight, 
                    :sub_total, 
                    :tax_discount,
                    :total_tax_insurance,
                    :total_tax_custom_tariffis,
                    :total_tax, 
                    :total_tax_discount,
                    :total_reexp,
                    :total_order,       
                    :order_datetime, 
                    :agency, 
                    :origin_off, 
                    :order_package, 
                    :order_courier, 
                    :order_service_options, 
                    :order_deli_time,              
                    :status_courier, 
                    :driver_id, 
                    :status_invoice, 
                    :tracking_purchase, 
                    :provider_purchase, 
                    :price_purchase,
                    :is_prealert 
                    )
            ");



            $db->bind(':user_id',  $_SESSION['userid']);
            $db->bind(':order_prefix',  $code_prefix);
            $db->bind(':is_prealert',  $is_prealert);
            $db->bind(':order_no',  $next_order);
            $db->bind(':order_datetime',  trim($date));
            $db->bind(':sender_id',  trim($_POST["sender_id"]));        
            $db->bind(':sender_address_id',  trim($_POST["sender_address_id"]));        
            $db->bind(':tax_value', floatval($_POST["tax_value"]));
            $db->bind(':tax_insurance_value', floatval($_POST["insurance_value"]));
            $db->bind(':tax_custom_tariffis_value', floatval($_POST["tariffs_value"]));
            $db->bind(':value_weight',  floatval($_POST["price_lb"]));
            $db->bind(':total_reexp',  floatval($_POST["reexpedicion_value"]));

            $db->bind(':volumetric_percentage',  $meter);
            $db->bind(':sub_total',  floatval($_POST["subtotal_input"]));
            $db->bind(':tax_discount',  floatval($_POST["discount_value"]));
            $db->bind(':total_tax_discount',  floatval($_POST["discount_input"]));
            $db->bind(':total_tax_insurance',  floatval($_POST["insurance_input"]));
            $db->bind(':total_tax_custom_tariffis',  floatval($_POST["total_impuesto_aduanero_input"]));
            $db->bind(':total_tax',  floatval($_POST["impuesto_input"]));
            $db->bind(':total_order',  floatval($_POST["total_envio_input"]));
            $db->bind(':total_weight',  floatval($_POST["total_weight_input"]));
            
            $db->bind(':order_date',  date("Y-m-d H:i:s"));                    
            $db->bind(':agency',  trim($_POST["agency"]));
            $db->bind(':origin_off',  trim($_POST["origin_off"]));
            $db->bind(':order_package',  trim($_POST["order_package"]));
            $db->bind(':order_courier',  trim($_POST["order_courier"]));
            $db->bind(':order_service_options',  trim($_POST["order_service_options"]));
            $db->bind(':order_deli_time',  trim($_POST["order_deli_time"]));           
            $db->bind(':status_courier', $status_courier);
            $db->bind(':driver_id',  trim($_POST["driver_id"]));
            $db->bind(':status_invoice',  $status_invoice);

            $db->bind(':tracking_purchase',  trim($_POST["tracking_purchase"]));
            $db->bind(':provider_purchase',  trim($_POST["provider_purchase"]));
            $db->bind(':price_purchase',  trim($_POST["price_purchase"]));


            $db->execute();
           
            
            $order_id = $db->dbh->lastInsertId();          

            for ($count = 0; $count < $_POST["total_item"]; $count++) {                

                $db->query("
                  INSERT INTO customers_packages_detail 
                  (
                  order_id,
                  order_item_description,
                  order_item_category,
                  order_item_quantity,
                  order_item_weight,
                  order_item_length,
                  order_item_width,
                  order_item_height
                                  
                  )
                  VALUES 
                  (
                  :order_id,
                  :order_item_description,
                  :order_item_category, 
                  :order_item_quantity,
                  :order_item_weight,
                  :order_item_length,
                  :order_item_width,
                  :order_item_height                 
                  )
                ");

               
                $db->bind(':order_id',  $order_id);
                $db->bind(':order_item_description',  trim($_POST["order_item_description"][$count]));
                $db->bind(':order_item_category',  trim($_POST["order_item_category"][$count]));
                $db->bind(':order_item_quantity',  trim($_POST["order_item_quantity"][$count]));                
                $db->bind(':order_item_weight',  trim($_POST["order_item_weight"][$count]));
                $db->bind(':order_item_length',  trim($_POST["order_item_length"][$count]));
                $db->bind(':order_item_width',  trim($_POST["order_item_width"][$count]));
                $db->bind(':order_item_height',  trim($_POST["order_item_height"][$count]));               

                $db->execute();
            
            }


            //UPDATE PREALERT TO PACKAGE


             $db->query("
                UPDATE  pre_alert SET                
                    
                is_package =:is_package

                WHERE pre_alert_id=:pre_alert_id                
                
            ");



            $db->bind(':pre_alert_id',  trim($_GET['id']));        
            $db->bind(':is_package', '1');
          

            $db->execute();


            $order_track= $code_prefix.$next_order;
         
            $db->query("
                INSERT INTO courier_track 
                (
                    order_track, 
                    comments,                                  
                    t_date,
                    status_courier,
                    office_id,
                    user_id
                    )
                VALUES
                    (
                    :order_track, 
                    :comments,                                     
                    :t_date,
                    :status_courier,
                    :office,                   
                    :user_id
                    )
            ");



            $db->bind(':order_track',  $order_track);            
            $db->bind(':t_date',  date("Y-m-d H:i:s"));
            $db->bind(':status_courier', $status_courier); 
            $db->bind(':comments','Registered package'); 
            $db->bind(':office', $_POST['origin_off']); 
            $db->bind(':user_id',  $_SESSION['userid']);

            $db->execute();



             // Add a recipient
            $db->query("SELECT * FROM users where id= '".$_POST["sender_id"]."'"); 
            $sender_data= $db->registro();


            $fullshipment = $code_prefix.$next_order;
            $date_ship   = date("Y-m-d H:i:s a");
    
            $app_url = $settings->site_url.'track.php?order_track='.$fullshipment;
            $subject="a new pre alert has been registered in your locker, tracking number $fullshipment";



            $email_template =getEmailTemplates(20);

              $body = str_replace(array(
                '[NAME]',
                '[TRACKING]',
                '[DELIVERY_TIME]',
                '[URL]',
                '[URL_LINK]',
                '[SITE_NAME]',
                '[URL_SHIP]'), array(
                $sender_data->fname . ' ' . $sender_data->lname,
                $fullshipment,
                $date_ship,
                $msite_url,
                $mlogo,
                $msnames,
                $app_url),
                $email_template->body);

            
                $newbody = cleanOut($body);  

               
            
            //SENDMAIL PHP

            if ($check_mail=='PHP') {  
                
                $message = $newbody; 
                $to=$sender_data->email;
                $from= $site_email;

                $header = "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html; charset=UTF-8 \r\n";
                $header .= "From: ". $from . " \r\n";
                $headers .= "Bcc: ".$core->email_address."\r\n";
                
                mail($to, $subject, $message, $header);  
                  

         } elseif ($check_mail=='SMTP') {
                

                //PHPMAILER PHP                 
            

                $destinatario=$sender_data->email;

                
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->Port = $smtpport; 
                $mail->IsHTML(true); 
                $mail->CharSet = "utf-8";
                
                // Datos de la cuenta de correo utilizada para enviar vía SMTP
                $mail->Host = $smtphoste;       // Dominio alternativo brindado en el email de alta
                $mail->Username = $smtpuser;    // Mi cuenta de correo
                $mail->Password = $smtppass;    //Mi contraseña
                
                
                $mail->From = $site_email; // Email desde donde envío el correo.
                $mail->FromName = $names_info;
                $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario
                $mail->addReplyTo($destinatario);

                //CC Copia al remitente
                $mail->addCC($emailaddress);
                
                $mail->Subject = $subject; // Este es el titulo del email.
                $mail->Body = "
                <html> 
                
                <body> 
                
                <p>{$newbody}</p>
                
                </body> 
                
                </html>
                
                <br />"; // Texto del email en formato HTML
                
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                
                $estadoEnvio = $mail->Send(); 
                if($estadoEnvio){
                    echo "El correo fue enviado correctamente.";
                } else {
                    echo "Ocurrió un error inesperado.";
                }
            }


            

            // SAVE NOTIFICATION
            $db->query("
                INSERT INTO notifications 
                (
                    user_id,
                    order_id,
                    notification_description,
                    shipping_type,
                    notification_date

                )
                VALUES
                    (
                    :user_id,                    
                    :order_id,
                    :notification_description,
                    :shipping_type,
                    :notification_date                    
                    )
            ");



            $db->bind(':user_id',  $_SESSION['userid']);
            $db->bind(':order_id',  $order_id);       
            $db->bind(':notification_description','There is a new registered package, please check it');           
            $db->bind(':shipping_type', '4');           
            $db->bind(':notification_date',  date("Y-m-d H:i:s"));        

            $db->execute();


            $notification_id = $db->dbh->lastInsertId(); 

            //NOTIFICATION TO DRIVER

            insertNotificationsUsers($notification_id, $_POST["driver_id"]);         


            //NOTIFICATION TO ADMIN AND EMPLOYEES

            $users_employees = getUsersAdminEmployees();

            foreach ($users_employees as $key) {

                insertNotificationsUsers($notification_id, $key->id);             
                  
            }
            // //NOTIFICATION TO CUSTOMER

            insertNotificationsUsers($notification_id, $_POST['sender_id']);


             //NOTIFY WHATSAPP API

                if(isset($_POST['notify_whatsapp']) && $_POST['notify_whatsapp']==1){


                    if($core->twilio_sid !=null && $core->twilio_token !=null && $core->twilio_number !=null){                    

                        $db->query("SELECT * FROM users where id= '".$_POST["sender_id"]."'"); 
                        $sender_data= $db->registro();

                        $phone_sender= $sender_data->phone;
                      
                        $sid    = $core->twilio_sid; 
                        $token  = $core->twilio_token;

                       try {

                         $twilio = new Client($sid, $token); 

                        $message = $twilio->messages 
                                      ->create("whatsapp:".$phone_sender, // to 
                                               array( 
                                                   "from" => "whatsapp:".$core->twilio_number,       
                                                    "body" => "a new package has been registered in your locker, *Tracking #$fullshipment* Follow up on your package by entering the following link and you will have detailed information on the status of your packages $app_url"
                                               ) 
                                      );
                           
                       } catch (Exception $e) {
                           
                       }

                    }

                }


            $db->query("SELECT * FROM users_multiple_addresses where id_addresses= '".$_POST["sender_address_id"]."'");

            $sender_address_data= $db->registro();

            $sender_address =$sender_address_data->address;
            $sender_country =$sender_address_data->country;
            $sender_city =$sender_address_data->city;
            $sender_zip_code =$sender_address_data->zip_code;


            
            // SAVE ADDRESS FOR Shipments

            $db->query("
                INSERT INTO address_shipments
                (
                    order_track,
                    sender_address,
                    sender_country,
                    sender_city,
                    sender_zip_code

                )
                VALUES
                    (
                    :order_track,
                    :sender_address,
                    :sender_country,
                    :sender_city,
                    :sender_zip_code
                                   
                    )
            ");



            $db->bind(':order_track',  $order_track); 

            $db->bind(':sender_address',  $sender_address);       
            $db->bind(':sender_country',  $sender_country);       
            $db->bind(':sender_city',  $sender_city);       
            $db->bind(':sender_zip_code',  $sender_zip_code);

              

            $db->execute();



            header("location:customer_packages_view.php?id=$order_id");

            
       

       
        ?>
        
        <?php
        
    }
		
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title><?php echo $lang['add-courier'] ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/intl-tel-input/css/intlTelInput.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/select2/dist/css/select2.min.css">
    <link href="assets/css/style.min.css" rel="stylesheet"> 

    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/jquery-ui.css" type="text/css" />

	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
	
    <link rel="stylesheet" href="assets/bootstrap-datetimepicker.min.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        $(function() {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
                NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
            });
        });
    </script>
</head>

<style type="text/css">
    .bg-primary {
    background-color: #7460ee!important;
}

.dropdown-divider {
    height: 0;
    margin: .5rem 0;
    overflow: hidden;
    border-top: 1px solid #f8f9fa;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: .65rem 1rem;
    clear: both;
    color: #212529;
    text-align: inherit;
    background-color: transparent;
    border: 0;
}
</style>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
	
	
    <?php include 'views/inc/preloader.php'; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        
        <?php include 'views/inc/topbar.php'; ?>
        
        <!-- End Topbar header -->

        
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
 
        <?php include 'views/inc/left_sidebar.php'; ?>

        <?php $office = $core->getOffices(); ?>
        <?php $agencyrow = $core->getBranchoffices(); ?>
        <?php $courierrow = $core->getCouriercom(); ?>
        <?php $statusrow = $core->getStatus(); ?>
        <?php $packrow = $core->getPack(); ?>
        <?php $payrow = $core->getPayment(); ?>
        <?php $paymethodrow = $core->getPaymentMethod(); ?>
        <?php $itemrow = $core->getItem(); ?>
        <?php $moderow = $core->getShipmode();?>
        <?php $driverrow = $user->userAllDriver();?>
        <?php $delitimerow = $core->getDelitime();?>
        <?php $track = $core->online_shopping_track();?>
        <?php $categories = $core->getCategories();?>
        <?php $code_countries = $core->getCodeCountries();?>

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
			
			 <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title"><i class="ti-package" aria-hidden="true"></i> Add Create Shipments</h4>
                    </div>
                </div>
            </div>

            <form method="post" id="invoice_form" name="invoice_form" enctype="multipart/form-data">

            <div class="container-fluid">
                <?php
                if(isset($_GET['prefix_error']) && $_GET['prefix_error']==1){ ?>

                <div class="alert alert-danger" id="success-alert">
                <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
                        <span>Error! </span> There was an error processing the request
                        <br>
                        Select the country code

                   </p>
                </div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card"> 
                            <div class="card-body"> 
                                <div class="form-row">   

                                    <div class="form-group col-md-6">
                                        <label for="inputcom" class="control-label col-form-label">Shipment Prefix</label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                  
                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="checkbox" name="prefix_check" id="prefix_check" value="1">
                                                      <label class="form-check-label" for="prefix_check">Country prefix</label>
                                                    </div>
                                                </div>
                                            </div>  
                                            
                                                <input type="text" class="form-control" name="code_prefix" id="code_prefix_input" value="<?php echo $order_prefix;?>" readonly>
                                            
                                                <select class="custom-select input-sm hide" id="code_prefix_select" name="code_prefix2">
                                                <option value="">--Select country code--</option>
                                                <?php foreach ($code_countries as $row):?>
                                                    <option value="<?php echo $row->iso_3166_3; ?>"><?php echo $row->iso_3166_3.' - '.$row->name; ?></option>
                                                <?php endforeach;?>
                                                </select> 
                                            
                                        </div>

                                        
                                    </div>


                                     <div class="form-group col-md-6">
                                        <label for="inputcom" class="control-label col-form-label"><?php echo $lang['add-title24'] ?></label>
                                        <div class="input-group mb-3">                                            
                                            <input type="text" class="form-control" name="order_no" id="order_no" value="<?php echo $track;?>" readonly>
                                        </div>

                                    </div>



                                    <div class="form-group col-md-6">
                                        <label for="inputlname" class="control-label col-form-label"><?php echo $lang['left201'] ?> </label>
                                        <div class="input-group mb-3">
                                            <select class="custom-select col-12" id="agency" name="agency" required="">
                                            <option value="">--<?php echo $lang['left202'] ?>--</option>
                                            <?php foreach ($agencyrow as $row):?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name_branch; ?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>                            
                                   

                                   

                                <?php if($user->access_level='Admin'){ ?>

                                    <div class="form-group col-md-6">
                                        <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                        <div class="input-group mb-3">
                                            <select class="custom-select col-12" id="exampleFormControlSelect1" name="origin_off" required="">
                                            <option value="">--<?php echo $lang['left343'] ?>--</option>

                                            <?php foreach ($office as $row):?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name_off; ?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }else if($user->access_level='Employee'){?>

                                    <div class="form-group col-md-6">
                                        <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" name="origin_off" value="<?php echo $user->name_off; ?>" readonly>
                                        </div>
                                    </div>

                                <?php } ?>  

                                </div>
                            </div>                   
                        </div>                 
                    </div>
                </div>
                <!-- Row -->


             <!-- Row -->

             
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['langs_010']; ?></h4>
                                <hr>

                                <div class="resultados_ajax_add_user_modal_sender"></div>
                                <br>
                                <?php 
                                    if($core->active_whatsapp==1){
                                ?>
                                <label class="custom-control custom-checkbox" style="font-size: 18px; padding-left: 0px">
                                    <input type="checkbox" class="custom-control-input" name="notify_whatsapp_sender" id="notify_whatsapp_sender" value="1">
                                    <b>Notify by WhatsApp <i class="fa fa-whatsapp" style="font-size: 22px; color:#07bc4c;"></i></b>
                                    <span class="custom-control-indicator"></span>                    
                                </label>
                                <?php } ?>
                                    <div class="row"> 

                                     <div class="col-md-12 ">

                                        <label class="control-label col-form-label"><?php echo $lang['sender_search_title'] ?></label>
                                       
                                        
                                        <div class="input-group">
                                            <select class="select2 form-control custom-select"   id="sender_id" name="sender_id">
                                                <option value="<?php echo $sender_data->id;?>"><?php echo $sender_data->fname." ".$sender_data->lname;?></option>

                                                </select>


                                            <div class="input-group-append input-sm">
                                                <button  type="button" class="btn btn-info" data-type_user="user_customer"   data-toggle="modal" data-target="#myModalAddUser"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div> 
                                    </div>



                                       

                                    <div class="col-md-12 ">

                                        <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['sender_search_address_title'] ?></label>
                                        
                                        <div class="input-group">
                                            <select class="select2 form-control" id="sender_address_id" name="sender_address_id">
                                            </select>

                                            <div class="input-group-append input-sm">
                                                <button  id="add_address_sender" data-type_user="user_customer"  data-toggle="modal" data-target="#myModalAddRecipientAddresses" type="button" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div> 
                                    </div>

                                </div>
                                
                                   
                                             
                                                
                            </div>                 
                        </div>
                    </div>
                </div>

               
               


            <div class="row">
                <div class="col-lg-12">
                    <div class="card"> 
                        <div class="card-body">
                            <h4 class="card-title"><i class="mdi mdi-book-multiple" style="color:#36bea6"></i> <?php echo $lang['add-title13'] ?></h4>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sum2"><i class="fa fa-cube mr-1"></i><strong> <?php echo $lang['left63'] ?></strong></label>
                                        <input  type="text" class="form-control" name="tracking_purchase" id="tracking_purchase" placeholder="Example: 009785454545554"  required="required" value="<?php echo $data_pre_alert->tracking; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ReceiptKind"><strong><?php echo $lang['left64'] ?></strong></label>
                                        <input type="text" class="form-control" name="provider_purchase" id="provider_purchase" placeholder="<?php echo $lang['left65'] ?>" required="required" value="<?php echo $data_pre_alert->provider_shop; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sum2"><strong> <?php echo $lang['left66'] ?></strong></label>
                                        <input  onkeypress="return soloNumeros(event)"  type="text" class="form-control" name="price_purchase" id="price_purchase"  placeholder="<?php echo $lang['left67'] ?>"  required="required" value="<?php echo $data_pre_alert->purchase_price; ?>">
                                    </div>
                                </div>
                            </div>




                            <div class="row">  



                                <div class="form-group col-md-4">
                                    <label for="inputlname" class="control-label col-form-label"><?php echo $lang['add-title17'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_package" name="order_package" required="" >
                                        <option value="">--<?php echo $lang['left203'] ?>--</option>
                                        <?php foreach ($packrow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name_pack; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>                            
                                   



                                <div class="form-group col-md-4">
                                    <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title18'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_courier" name="order_courier" required="">
                                        <option value="">--<?php echo $lang['left204'] ?>--</option>
                                        <?php foreach ($courierrow as $row):?>

                                            <option value="<?php echo $row->id; ?>" <?php if($row->id==$data_pre_alert->courier_com){echo 'selected';} ?> ><?php echo $row->name_com; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 
                              



                                <div class="form-group col-md-4">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title22'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_service_options" name="order_service_options" required="" >
                                        <option value="">--<?php echo $lang['left205'] ?>--</option>
                                        <?php foreach ($moderow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->ship_mode; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title15'] ?></i></label>
                                    <div class="input-group">
                                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i style="color:#ff0000" class="fa fa-calendar"></i></div>
                                            </div>
                                        <input type='text' class="form-control" name="order_date" id="order_date" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>" readonly value="<?php echo date('Y-m-d'); ?>"/>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title20'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_deli_time" name="order_deli_time" required="">
                                        <option value="">--<?php echo $lang['left207'] ?>--</option>
                                        <?php foreach ($delitimerow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->delitime; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                        <!--/span-->

                                <?php 

                                if($userData->userlevel == 3){?>

                                    <div class="form-group col-md-4">
                                        <label for="inputname" class="control-label col-form-label"><?php echo $lang['left208'] ?></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="color:#ff0000"><i class="fas fa-car"></i></span>
                                            </div>
                                            <input type="hidden" name="driver_id" id="driver_id" value="<?php echo $_SESSION['userid']; ?>">

                                            <select class="custom-select col-12" id="driver_name" name="driver_name">     
                                                <option value="<?php echo $_SESSION['userid']; ?>"><?php echo $_SESSION['name'];  ?></option>
                                           
                                            </select>
                                        </div>
                                    </div> 

                                <?php

                                }else{ ?>

                                    <div class="form-group col-md-4">
                                        <label for="inputname" class="control-label col-form-label"><?php echo $lang['left208'] ?></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="color:#ff0000"><i class="fas fa-car"></i></span>
                                            </div>
                                            <select class="custom-select col-12" id="driver_id" name="driver_id" required="">
                                            <option value="">--<?php echo $lang['left209'] ?>--</option>
                                            <?php foreach ($driverrow as $row):?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->fname.' '.$row->lname; ?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div> 
                                <?php
                                } ?>

                            </div>
                            
                             <div class="row">                                

                                <div  class="resultados_file col-md-4 pull-right mt-4">
                                    
                                    
                                </div>

                             
                            </div> 

                        </div>                 
                                            
                    </div>                 
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card"> 
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fas fa-boxes" style="color:#36bea6"></i> <?php echo $lang['left212'] ?></h4>

                               

                            <div id="resultados_ajax"></div>  

                            <div class="card-hover">
                            <hr>

                            <div class="row">
                               
                                <div class="col-md-4">

                                    <div class="form-group">

                                    
                                        <label for="emailAddress1">Category</label>
                                            <div class="input-group">
                                                <select class="custom-select col-12 order_item_category1" id="order_item_category1" name="order_item_category[]" required>
                                                    <option value="0">--Select Category--</option>
                                                    <?php foreach ($categories as $row):?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name_item; ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                    </div>

                                </div>

                                <div class="col-md-5">

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left213'] ?></label>
                                            <div class="input-group">
                                                <input type="text" name="order_item_description[]" id="order_item_description1" class="form-control input-sm order_item_description" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left225'] ?>"  placeholder="<?php echo $lang['left224'] ?>" required value="<?php echo $data_pre_alert->package_description; ?>"/>
                                            </div>
                                    </div>
                                    
                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label for="emailAddress1">  Declared value</label>                             
                                            <div class="input-group">                                               

                                                <input type="text" onkeypress="return soloNumeros(event)"  name="order_item_declared_value[]" id="order_item_declared_value1" data-srno="1" class="form-control input-sm number_only order_item_declared_value" data-toggle="tooltip" data-placement="bottom" title="Declared value"  value="0"/>
                                                <!-- <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info "><i class="fa fa-plus"></i></button>
                                                </div> -->
                                            </div>
                                    </div>
                                </div>       



                              
                            </div>

                            <div class="row ">
                                <div class="col-md-2">

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left214'] ?></label>
                                            <div class="input-group">
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="decrementInputNumber('order_item_quantity', 1)"><i class="fa fa-minus"></i></button>
                                                </div>
                                                <input min="1" type="text" onkeypress="return soloNumeros(event)"  name="order_item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left227'] ?>"  value="1" required />
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="incrementInputNumber('order_item_quantity', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-2">

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left215']; ?></label>
                                            <div class="input-group">

                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="decrementInputNumber('order_item_weight', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)"  name="order_item_weight[]" id="order_item_weight1" data-srno="1" class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title31'] ?>"  value="0" />

                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="incrementInputNumber('order_item_weight', 1)"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="emailAddress1"><?php echo $lang['left216'] ?></label>
                                            <div class="input-group">
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="decrementInputNumber('order_item_length', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)" name="order_item_length[]" id="order_item_length1" data-srno="1" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title37'] ?>"  value="0" />
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="incrementInputNumber('order_item_length', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                </div>


                                <div class="col-md-2">                                

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left217'] ?></label>
                                            <div class="input-group">
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="decrementInputNumber('order_item_width', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)" name="order_item_width[]" id="order_item_width1" data-srno="1" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title38'] ?>"  value="0" />
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="incrementInputNumber('order_item_width', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-2">

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left218'] ?></label>                             
                                            <div class="input-group">

                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="decrementInputNumber('order_item_height', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)"  name="order_item_height[]" id="order_item_height1" data-srno="1" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title39'] ?>"  value="0"/>
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-info" onclick="incrementInputNumber('order_item_height', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                </div>


                                                         
                                         
                            </div>
                            <hr>
                        </div>

                            <div id="data_items"></div>

                            <div class="row"> 
                                <div class="col-md-12 mb-3">
                                    <div align="">
                                        <button type="button" name="add_row" id="add_row" class="btn btn-success mb-2"><span class="fa fa-plus"></span> <?php echo $lang['left231'] ?></button>
                                    </div> 

                                </div>
                            </div>                          
                                       
                                        
                                     
                                    

                                <div class="table-responsive">                                
                                    <table id="invoice-item-table" class="table">
                                    <tfoot>
                                        <tr class="card-hover">                                   
                                            <td colspan="2"></td>                                         
                                            <td  colspan="2" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
                                            <td  colspan="2"></td>
                                            <td class="text-center" id="subtotal">0.00</td>              
                                            <td ></td> 
                                        </tr>

                                        <tr class="card-hover">                
                                            <td colspan="1"><b>Price Lb:</b></td>       
                                            <td>                                                
                                                <input type="text" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->value_weight;?>" name="price_lb" id="price_lb" style="width: 160px;">
                                            </td>      
                                            
                                            <td colspan="2" class="text-right"> <b>Discount % </b></td>                                                                             
                                            <td  colspan="2" class="text-right">
                                                <input type="text" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" value="0" name="discount_value" id="discount_value" class="form-control form-control-sm">                                                
                                            </td>
                                            <td class="text-center" id="discount">0.00</td>              
                                            <td ></td>                                             
                                        </tr>

                                        <tr class="card-hover">                
                                            <td colspan="2"><b><?php echo $lang['left232'] ?>:</b> <span id="total_libras">0.00</span></td>
                                            
                                            <td colspan="2" class="text-right"> <b>Shipping insurance % </b></td>                                                                             
                                            <td  colspan="2" class="text-right">
                                                <input type="text" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->insurance; ?>" name="insurance_value" id="insurance_value">                                                
                                            </td>
                                            <td class="text-center" id="insurance">0.00</td>              
                                            <td ></td>                                             
                                        </tr>

                                        <tr class="card-hover">
                                            <td colspan="2"><b><?php echo $lang['left234'] ?>:</b> <span id="total_volumetrico">0.00</span></td>                                            
                                          
                                            <td colspan="2" class="text-right"><b>Customs tariffs  %</b></td>
                                            <td  colspan="2" class="text-right">                                                
                                                <input type="text" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->c_tariffs; ?>" name="tariffs_value" id="tariffs_value">

                                             </td>
                                            <td class="text-center" id="total_impuesto_aduanero">0.00</td>              
                                            <td ></td>                                            

                                        </tr>

                                        <tr class="card-hover">                
                                            <td colspan="2"><b><?php echo $lang['left236'] ?></b>: <span id="total_peso">0.00</span></td>                          
                                            <td></td>
                                            <td class="text-right"><b>Tax % </b></td>
                                            <td  colspan="2" >                                                
                                                <input type="text" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->tax; ?>" name="tax_value" id="tax_value">
                                            </td>
                                            <td class="text-center" id="impuesto">0.00</td> 
                                            <td ></td>                                                         
                                        </tr>  


                                        <tr class="card-hover">                
                                            <td colspan="2"><b>Total declared value:</b> <span id="total_declared">0.00</span></td>                        
                                            <td class="text-right" colspan="2"><b>Declared tax % </b></td>
                                            <td  colspan="2" >                                                
                                                <input type="text" value="<?php echo $core->declared_tax; ?>" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" class="form-control form-control-sm" value="0" name="declared_value_tax" id="declared_value_tax">
                                            </td>
                                            <td class="text-center" id="declared_value_label">0.00</td> 
                                            <td ></td>                                                         
                                        </tr>



                                        <tr class="card-hover">                
                                            <td colspan="2"></td>                          
                                            <td class="text-right" colspan="2"><b>Re expedition</b></td>
                                            <td  colspan="2" >                                                
                                                <input type="text" onkeypress="return soloNumeros(event)"  onblur="cal_final_total();" class="form-control form-control-sm" value="0" name="reexpedicion_value" id="reexpedicion_value">
                                            </td>
                                            <td class="text-center" id="reexpedicion_label"></td> 
                                            <td ></td>                                                         
                                        </tr>

 

                                        <tr class="card-hover">                                            
                                            <td colspan="2"></td>
                                            <td  colspan="2" class="text-right"><b><?php echo $lang['add-title44'] ?> &nbsp; <?php echo $core->currency;?></b></td>
                                            <td></td>                                                                                     
                                            <td></td>                                                                                     
                                            <td class="text-center" id="total_envio">0.00</td>              
                                            <td ></td>                                                      

                                        </tr>
                                    </tfoot>
                                </table>

                               
                            </div> 
                           
                            <div class="col-md-12">
                                <div class="form-actions">
                                    <div class="card-body">
                                        <div class="text-right">
                                            <input type="hidden" name="sumador_valor_declarado" id="sumador_valor_declarado"/>

                                            <input type="hidden" name="total_item" id="total_item" value="1" />
                                            <input type="hidden" name="discount_input" id="discount_input"/>
                                            <input type="hidden" name="subtotal_input" id="subtotal_input"/>
                                            <input type="hidden" name="impuesto_input" id="impuesto_input"/>
                                            
                                            <input type="hidden" name="declared_value_input" id="declared_value_input"/>

                                            <input type="hidden" name="insurance_input" id="insurance_input"/>
                                            <input type="hidden" name="total_impuesto_aduanero_input" id="total_impuesto_aduanero_input"/>

                                            <input type="hidden" name="total_weight_input" id="total_weight_input"/>

                                            <input type="hidden" name="total_envio_input" id="total_envio_input"/>

                                            <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-success" value="Create Invoice" />

                                        </div>
                                    </div>
                                </div>
                            </div>                                          
                        </div>
                    </div>         
                                            
                </div>
            </div>

       </form>                 



         <?php include('views/modals/modal_add_user_shipment.php'); ?>
         <?php include('views/modals/modal_add_addresses_user.php'); ?>



            </div>
			    

            </div>
            <footer class="footer text-center">
                &copy <?php echo date('Y').' '.$core->site_name;?> - <?php echo $lang['foot'] ?>
            </footer>
 
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <!-- <script src="assets/js/app.init.js"></script> -->
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>

    <script src=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap-datetimepicker.min.js"></script>



    <script src="assets/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/select2/dist/js/select2.min.js"></script>
    <script src="assets/intl-tel-input/js/intlTelInput.js"></script>


    <script>
    $(document).ready(function() {

        $('#order_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $('#register_customer_to_user').click(function() {

          if ($(this).is(':checked')) {

            $('#show_hide_user_inputs').removeClass('d-none');

          }else{

            $('#show_hide_user_inputs').addClass('d-none');
          }

        });
    });

    // $("#resultados_ajax" ).load( "./ajax/courier/courier_add_item_tmp.php");

    </script>

    <script>
        
        $(document).ready(function () {
            $('#code_prefix_select').hide();


    $('#prefix_check').on('change', function(event){
            // alert(1)

        if ($('#prefix_check').is(":checked")){

            $('#code_prefix_input').hide();
            $('#code_prefix_input').attr("disabled", true);

            $('#prefix_check').val(1);
            $('#code_prefix_select').show();
            $('#code_prefix_select').attr("disabled", false);

            $("#code_prefix_select").attr("required", "true");
        }
        else{

            $('#prefix_check').val(0);
            $('#code_prefix_select').hide();
            $('#code_prefix_select').attr("disabled", true);

            $('#code_prefix_input').show();
            $('#code_prefix_input').attr("disabled", false);

            $("#code_prefix_select").attr("required", "false");
        }


    });
    });
    </script>





<script>

    $(document).ready(function(){
        var count = 1;
                            
        $(document).on('click', '#add_row', function(){
          count++;
        $('#total_item').val(count);

         
        var parent=  $('#row_id_'+count);
        var html_code = '';

        html_code += '<div  class= "card-hover" id="row_id_'+count+'">';

         html_code += '<hr>';

            html_code += '<div class="row"> ';                                       

                html_code +='<div class="col-md-4">'+
                    '<div class="form-group">'+                
                        '<label for="emailAddress1">Category</label>'+
                            '<div class="input-group">'+
                                '<select class="custom-select col-12 order_item_category1" id="order_item_category'+count+'" name="order_item_category[]" required>'+
                                    '<option value="0">--Select Category--</option>'+
                                    <?php foreach ($categories as $row):?>
                                        '<option value="<?php echo $row->id; ?>"><?php echo $row->name_item; ?></option>'+
                                    <?php endforeach;?>
                                '</select>'+
                            '</div>'+
                    '</div>'+
                '</div>';




                html_code += '<div class="col-md-5">'+

                    '<div class="form-group">'+

                        '<label for="emailAddress1"><?php echo $lang['left213'] ?></label>'+
                            '<div class="input-group">'+
                                '<input type="text" name="order_item_description[]" id="order_item_description'+count+'" class="form-control input-sm order_item_description" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left225'] ?>"  placeholder="<?php echo $lang['left224'] ?>" required>'+
                            '</div>'+
                    '</div>'+                
                '</div>';


        html_code += '<div class="col-md-3">'+
            '<div class="form-group">'+
                '<label for="emailAddress1">Declared value</label> '+                            
                    '<div class="input-group">'+
                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_declared_value[]" id="order_item_declared_value'+count+'" class="form-control input-sm number_only order_item_declared_value" data-toggle="tooltip" data-placement="bottom" title="Declared value"  value="0"/>'+
                    '</div>'+
            '</div>'+
        '</div>';




    html_code +='</div>';    



   html_code += '<div class="row">';

        html_code += '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left214'] ?></label>'+
                    '<div class="input-group">'+

                    '<div class="input-group-append input-sm">'+
                        '<button type="button" class="btn btn-info" onclick="decrementInputNumber(1,  '+count+')"><i class="fa fa-minus"></i></button>'+
                    '</div>'+

                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_quantity[]" id="order_item_quantity'+count+'" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left227'] ?>"  value="1" required />'+

                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="incrementInputNumber(1,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                   '</div>'+
            '</div>'+                
        '</div>';

        html_code += '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left215']; ?></label>'+
                    '<div class="input-group">'+
                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="decrementInputNumber(2,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+

                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_weight[]" id="order_item_weight'+count+'"class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title31'] ?>"  value="0" />'+

                             '<div class="input-group-append input-sm">'+
                                '<button type="button" class="btn btn-info" onclick="incrementInputNumber(2,  '+count+')"><i class="fa fa-plus"></i></button>'+
                            '</div>'+
                    '</div>'+
            
            '</div>'+
        '</div>';

        html_code += '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left216'] ?></label>'+
                    '<div class="input-group">'+

                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="decrementInputNumber(3,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+
                        '<input type="text" onkeypress="return soloNumeros(event)" name="order_item_length[]" id="order_item_length'+count+'" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title37'] ?>"  value="0" />'+

                         '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="incrementInputNumber(3,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                    '</div>'+
            '</div>'+
        '</div>';


         html_code += '<div class="col-md-2">'+                               

            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left217'] ?></label>'+
                    '<div class="input-group">'+
                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="decrementInputNumber(4,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+
                        '<input type="text" onkeypress="return soloNumeros(event)" name="order_item_width[]" id="order_item_width'+count+'" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title38'] ?>"  value="0" />'+

                         '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="incrementInputNumber(4,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                    '</div>'+
            '</div>'+
        '</div>';


         html_code += '<div class="col-md-2">'+

            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left218'] ?></label> '+                            
                    '<div class="input-group">'+
                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="decrementInputNumber(5,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+
                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_height[]" id="order_item_height'+count+'" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title39'] ?>"  value="0"/>'+
                         '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-info" onclick="incrementInputNumber(5,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                    '</div>'+
            '</div>'+
        '</div>';


        

        html_code += '<div class="col-md-1">'+           
            '<div class="form-group  mt-4" align="right">'+
                '<button type="button" name="remove_row" id="'+count+'" class="btn btn-danger mt-2 remove_row"><i class="fa fa-trash"></i>  Delete </button>'+
            '</div>'+
        '</div>';
         
    html_code += '</div>';

 html_code += '<hr>';

 html_code += '</div>';

    
         

          $('#data_items').append(html_code);
             $('#row_id_'+count).animate({
              'backgroundColor': '#18BC9C'
          }, 400); 

        //cal_final_total(count);

            $('#add_row').attr("disabled", true);

         
             setTimeout(function(){

            $('#row_id_'+count).css({'background-color':''});
            $('#add_row').attr("disabled", false);

          }, 900);
         
        });
        





        $(document).on('click', '.remove_row', function(){

            var row_id = $(this).attr("id");
            var parent=  $('#row_id_'+row_id);

            //cal_final_total(count);

          parent.animate({
              'backgroundColor': '#FFBFBF'
          }, 400);         

          count--;
          parent.fadeOut(400, function () {
              // parent.remove();
          $('#row_id_'+row_id).remove();
            cal_final_total();
          });
            $('#total_item').val(count);

        });










        $(document).on('blur', '.order_item_weight', function(){
            

          cal_final_total();
        });

        $(document).on('blur', '.order_item_description', function(){
            

          cal_final_total();
        });

        $(document).on('blur', '.order_item_quantity', function(){
            

          cal_final_total();
        });

        $(document).on('blur', '.order_item_height', function(){
            

          cal_final_total();
        });

        $(document).on('blur', '.order_item_length', function(){
            

          cal_final_total();
        });

        $(document).on('blur', '.order_item_width', function(){
            

          cal_final_total();
        });

         $(document).on('blur', '.order_item_category', function(){
            

          cal_final_total();
        });

        $(document).on('blur', '.order_item_declared_value', function(){            

          cal_final_total();
        });





        $('#create_invoice').click(function(){

            if(validateZiseFiles()==true){

                return false;
            }
          
         if($.trim($('#sender_id').val()).length == 0)
          {
            alert("Please select sender customer");

            return false;
          }

          if($.trim($('#sender_address_id').val()).length == 0)
          {
            alert("Please select sender customer address");

            return false;
          }


          if($.trim($('#order_no').val()).length == 0)
          {
            alert("Please Select Invoice number");
            return false;
          }
          
          if($.trim($('#agency').val())== '0')
          {
            alert("Please Select Agency");
            return false;
          }



          if($.trim($('#tracking_purchase').val())== '0')
          {
            alert("Please enter tracking purchase");
            return false;
          }


          if($.trim($('#price_purchase').val())== '0')
          {
            alert("Please enter price purchase");
            return false;
          }


          if($.trim($('#provider_purchase').val())== '0')
          {
            alert("Please enter provider purchase");
            return false;
          }


          
          if($.trim($('#order_package').val())== '0')
          {
            alert("Please Select package name");
            return false;
          }
          
          if($.trim($('#order_courier').val())== '0')
          {
            alert("Please Select courier company");
            return false;
          }
          
          if($.trim($('#order_service_options').val())== '0')
          {
            alert("Please Select services options");
            return false;
          }
          
          if($.trim($('#order_deli_time').val())== '0')
          {
            alert("Please Select time delivery");
            return false;
          }          
         
          
          
           if($.trim($('#driver_id').val())== '0')
          {
            alert("Please Enter driver name");
            return false;
          }


         

          for(var no=1; no<=count; no++)
          {
            if($.trim($('#order_item_description'+no).val()).length == 0)
            {
              alert("Please Enter Description Name");
              $('#order_item_description'+no).focus();
              return false;
            }


            if($.trim($('#order_item_category'+no).val()) == 0)
            {
              alert("Please select category");
              $('#order_item_category'+no).focus();
              return false;
            }

            if($.trim($('#order_item_quantity'+no).val()).length == 0)
            {
              alert("Please Enter Quantity");
              $('#order_item_quantity'+no).focus();
              return false;
            }
            
            if($.trim($('#order_item_weight'+no).val()).length == 0)
            {
              alert("Please Enter Weight");
              $('#order_item_weight'+no).focus();
              return false;
            }

            if($.trim($('#order_item_declared_value'+no).val()).length == 0)
            {
              alert("Please enter declared value");
              $('#order_item_declared_value'+no).focus();
              return false;
            }             
           

          }

          $('#invoice_form').submit();

        });



    });

  

</script>

<script type="text/javascript">
    
        function cal_final_total(){

           
            var count = $('#total_item').val();
            console.log(count);

                        var sumador_total=0;
            var sumador_valor_declarado=0;
            var sumador_libras=0;
            var sumador_volumetric=0;

            var precio_total=0;
            var total_impuesto=0;
            var total_descuento=0;
            var total_seguro=0;
            var total_peso=0;
            var total_impuesto_aduanero =0;
            var total_valor_declarado = 0;

            var total_reexpedicion = 0;

            
            var tariffs_value = $('#tariffs_value').val();
            var declared_value_tax = $('#declared_value_tax').val();
            var insurance_value = $('#insurance_value').val();
            var tax_value = $('#tax_value').val();
            var discount_value = $('#discount_value').val();

            var reexpedicion_value = $('#reexpedicion_value').val();

            reexpedicion_value = parseFloat(reexpedicion_value);



            var price_lb = $('#price_lb').val();

            price_lb = parseFloat(price_lb);

           
           
          for(i=1; i<=count; i++)
          {
            
            quantity = $('#order_item_quantity'+i).val();
            quantity = parseFloat(quantity);

            description = $('#order_item_description'+i).val();
            category = $('#order_item_category'+i).val();

            weight = $('#order_item_weight'+i).val();
            weight = parseFloat(weight);

            length = $('#order_item_length'+i).val();
            length = parseFloat(length);

            width = $('#order_item_width'+i).val();
            width = parseFloat(width);

            height = $('#order_item_height'+i).val();
            height = parseFloat(height);

            declared_value_item = $('#order_item_declared_value'+i).val();
            declared_value_item = parseFloat(declared_value_item);


            // calculate weight columetric box size
            var total_metric = length * width * height/ <?php echo $core->meter; ?>; 

            // calculate weight x price
            if (weight > total_metric) {

              calculate_weight = weight;
              sumador_libras+=weight;//Sumador

            } else {

              calculate_weight = total_metric;
              sumador_volumetric+=total_metric;//Sumador
            }

            precio_total=calculate_weight* price_lb;
            sumador_total+=precio_total;

            sumador_valor_declarado+=declared_value_item;


            if(sumador_total><?php echo $core->min_cost_tax; ?>){

                total_impuesto= sumador_total * tax_value/100;
            }

            if(sumador_valor_declarado><?php echo $core->min_cost_declared_tax; ?>){

                total_valor_declarado = sumador_valor_declarado * declared_value_tax/100;
            }
                
            total_descuento= sumador_total * discount_value/100;

            total_peso =sumador_libras + sumador_volumetric;

            total_seguro= sumador_total * insurance_value /100;

            total_impuesto_aduanero= total_peso * tariffs_value;


         
          }

          // sumador_total= sumador_total- total_descuento;

          total_envio =(sumador_total-total_descuento) +total_seguro+ total_impuesto + total_impuesto_aduanero+ total_valor_declarado+ reexpedicion_value;



           if (total_descuento> sumador_total) {


                alert('Discount cannot be greater than the subtotal');
                 $('#discount_value').val(0);

                return false;

            }else if(discount_value<0){

                alert('Discount cannot be less than 0');
                 $('#discount_value').val(0);

                return false;

            }

          $('#subtotal').html(sumador_total.toFixed(2));
          $('#total_declared').html(sumador_valor_declarado.toFixed(2));
          $('#sumador_valor_declarado').val(sumador_valor_declarado.toFixed(2));

            $('#declared_value_label').html(total_valor_declarado.toFixed(2));
          $('#declared_value_input').val(total_valor_declarado.toFixed(2));
          $('#discount').html(total_descuento.toFixed(2));
          $('#discount_input').val(total_descuento.toFixed(2));

          $('#subtotal_input').val(sumador_total.toFixed(2));

          $('#impuesto').html(total_impuesto.toFixed(2));
          $('#impuesto_input').val(total_impuesto.toFixed(2));

          $('#insurance').html(total_seguro.toFixed(2));
          $('#insurance_input').val(total_seguro.toFixed(2));

          $('#total_libras').html(sumador_libras.toFixed(2));

          $('#total_volumetrico').html(sumador_volumetric.toFixed(2));

          $('#total_peso').html(total_peso.toFixed(2));
          $('#total_weight_input').val(total_peso.toFixed(2));

          $('#total_impuesto_aduanero').html(total_impuesto_aduanero.toFixed(2));
          $('#total_impuesto_aduanero_input').val(total_impuesto_aduanero.toFixed(2));

          $('#total_envio').html(total_envio.toFixed(2));
          $('#total_envio_input').val(total_envio.toFixed(2));
        

         
        }
</script>

<script type="text/javascript">

    function soloNumeros(e){
    var key = e.charCode;
    return key >= 44 && key <= 57;
}
</script>













<script>

 $(document).ready(function() {

   select2_init_sender();
   select2_init_sender_address();
   // select2_init_recipient_address();
   // select2_init_recipient();

            
});



function select2_init_sender(){

    $( "#sender_id" ).select2({        
    ajax: {
        url: "ajax/select2_sender.php",
        dataType: 'json',
        
        delay: 250,
        data: function (params) {
            return {
                q: params.term // search term
            };
        },
        processResults: function (data) {
            // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data
            console.log(data)
            return {
                results: data
            };
        },
        cache: true
    },
    // initSelection: function (element, callback) {
    //     callback({id: 1, text: 'initSelection test' });
    // },

    minimumInputLength: 2,
     placeholder: "Search sender customer",
    allowClear: true
    }).on('change', function (e) {

        var sender_id =$( "#sender_id" ).val();

        

            $( "#sender_address_id").attr("disabled", true);


             $( "#add_address_sender").attr("disabled", true);

             // $( "#add_recipient").attr("disabled", true);
             // $( "#add_address_recipient").attr("disabled", true);
             // $( "#recipient_address_id").attr("disabled", true);

             // $( "#recipient_id").attr("disabled", true);

             $( "#sender_address_id" ).val(null);
             // $( "#recipient_id" ).val(null);
             // $( "#recipient_address_id" ).val(null);

            if(sender_id!=null){

            
                 $( "#add_address_sender").attr("disabled", false);

                $( "#sender_address_id").attr("disabled", false);

                // $( "#recipient_id").attr("disabled", false);

                 // $( "#add_recipient").attr("disabled", false);
            }

        select2_init_sender_address();
        // select2_init_recipient_address();
        // select2_init_recipient();


    });
}



function select2_init_sender_address(){

    var sender_id =$( "#sender_id" ).val();

    $( "#sender_address_id").select2({        
    ajax: {
        url: "ajax/select2_sender_addresses.php?id="+sender_id,
        dataType: 'json',
        
        delay: 250,
        data: function (params) {
            return {
                q: params.term // search term
            };
        },
        processResults: function (data) {
            // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data
            console.log(data)
            return {
                results: data
            };
        },
        cache: true
    },


    escapeMarkup: function(markup) { return markup; }, // let our custom formatter work
    // minimumInputLength: 1,
    templateResult: formatAdress, // omitted for brevity, see the source of this page
    templateSelection: formatAdressSelection, // omitted for brevity, see the source of this page
    // minimumInputLength: 2,
     placeholder: "Search sender customer address",
    allowClear: true
    });
}


function formatAdress(item) {

    if (item.loading) return item.text;

    console.log(item)

    var markup = "<div class='select2-result-repository clearfix'>";
        

    markup += "<div class='select2-result-repository__statistics'>" +
        "<div class='select2-result-repository__forks'><i class='la la-code-fork mr-0'></i> <b> Address: </b> " + item.text + " | <b>Country: </b>" + item.country + " | <b>City: </b>" + item.city + " | <b>Zip code: </b>" + item.zip_code + " </div>" +
       
        "</div>" +
        "</div></div>";

    return markup;
}

function formatAdressSelection(repo) {
    return repo.text;
}





// function select2_init_recipient(){

//     var sender_id =$( "#sender_id" ).val();


//     $( "#recipient_id" ).select2({        
//     ajax: {
//         url: "ajax/select2_recipient.php?id="+sender_id,
//         dataType: 'json',
        
//         delay: 250,
//         data: function (params) {
//             return {
//                 q: params.term // search term
//             };
//         },
//         processResults: function (data) {
//             // parse the results into the format expected by Select2.
//             // since we are using custom formatting functions we do not need to
//             // alter the remote JSON data
//             console.log(data)
//             return {
//                 results: data
//             };
//         },
//         cache: true
//     },

//     // minimumInputLength: 2,
//      placeholder: "Search recipient customer",
//     allowClear: true
//     }).on('change', function (e) {


//         var recipient_id =$( "#recipient_id" ).val();
      
//          $( "#add_address_recipient").attr("disabled", true);
//          $( "#recipient_address_id").attr("disabled", true);
//          $( "#recipient_address_id").val(null);

//         if(recipient_id!=null){
      

//              $( "#recipient_address_id").attr("disabled", false);
//              $( "#add_address_recipient").attr("disabled", false);

           
//         }

//         select2_init_recipient_address();



//     });
// }

// function select2_init_recipient_address(){

//     var recipient_id =$( "#recipient_id" ).val();

//     $( "#recipient_address_id").select2({        
//     ajax: {
//         url: "ajax/select2_recipient_addresses.php?id="+recipient_id,
//         dataType: 'json',
        
//         delay: 250,
//         data: function (params) {
//             return {
//                 q: params.term // search term
//             };
//         },
//         processResults: function (data) {
//             // parse the results into the format expected by Select2.
//             // since we are using custom formatting functions we do not need to
//             // alter the remote JSON data
//             console.log(data)
//             return {
//                 results: data
//             };
//         },
//         cache: true
//     },

//     escapeMarkup: function(markup) { return markup; }, // let our custom formatter work
//     // minimumInputLength: 1,
//     templateResult: formatAdress, // omitted for brevity, see the source of this page
//     templateSelection: formatAdressSelection, // omitted for brevity, see the source of this page
//     // minimumInputLength: 2,
//      placeholder: "Search recipient customer address",
//     allowClear: true
//     });

// }





$('#myModalAddUser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var type_user = button.data('type_user') // Extract info from data-* attributes
    $('#type_user').val(type_user);

    if (type_user=='user_customer') {

        $('#modal_add_user_title').html('Add Sender/Customer');

    }else{

        $('#modal_add_user_title').html('Add Recipient/Customer');
    }

})


//Registro de datos

$( "#add_user_from_modal_shipments" ).submit(function( event ) {

                    
    var count = $('#total_address').val();
    var validate= 0;


        if($.trim($('#address_modal_user').val()).length == 0)
        {
          alert("Please enter address");
          $('#address').focus();
            
            return false;
        }


        if($.trim($('#country_modal_user').val()).length == 0)
        {
          alert("Please enter country");
          $('#country').focus();
            
            return false;
        }

        if($.trim($('#city_modal_user').val()).length == 0)
        {
          alert("Please enter city");
          $('#city').focus();
            
            return false;
        }

        if($.trim($('#postal_modal_user').val()).length == 0)
        {
          alert("Please enter zip code");
          $('#postal').focus();
            
            return false;
        }            

    


    // if(validate==0){
    if (iti.isValidNumber()) {

        var sender_id = $('#sender_id').val();

        var type= $('#type_user').val();

        $('#save_data_user').attr("disabled", true);

        var parametros = $(this).serialize();
      
        $.ajax({
            type: "POST",
            url: "ajax/courier/add_users_ajax.php?sender="+sender_id,
            data: parametros,  
             
            success: function(datos){

                  select2_init_sender(); 

                if (type==='user_customer') {

                    $(".resultados_ajax_add_user_modal_sender").html(datos);

                }else{

                    $(".resultados_ajax_add_user_modal_recipient").html(datos);

                }


                $('#save_data_user').attr("disabled", false);


                $("#myModalAddUser").modal('hide');

                window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();});}, 5000);

            } 
        });

    }else {

      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");

    }
          


  event.preventDefault();
    
})






















$('#myModalAddRecipientAddresses').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var type_user = button.data('type_user') // Extract info from data-* attributes
    $('#type_user_address').val(type_user);

    if (type_user=='user_customer') {

        $('#modal_add_address_title').html('Add Sender/Customer  address');

    }else{

        $('#modal_add_address_title').html('Add Recipient/Customer address');
    }

})


//Registro de datos

$( "#add_address_from_modal_shipments" ).submit(function( event ) {

                    
        if($.trim($('#address').val()).length == 0)
        {
          alert("Please enter address");
          $('#address').focus();
            
            return false;
        }


        if($.trim($('#country').val()).length == 0)
        {
          alert("Please enter country");
          $('#country').focus();
            
            return false;
        }

        if($.trim($('#city').val()).length == 0)
        {
          alert("Please enter city");
          $('#city').focus();
            
            return false;
        }

        if($.trim($('#postal').val()).length == 0)
        {
          alert("Please enter zip code");
          $('#postal').focus();
            
            return false;
        }            

    

        var sender_id = $('#sender_id').val();
        var recipient_id = $('#recipient_id').val();

        $('#save_data_address').attr("disabled", true);
        var parametros = $(this).serialize();
        var type= $('#type_user_address').val();
      
        $.ajax({

            type: "POST",
            url: "ajax/courier/add_address_users_ajax.php?sender="+sender_id+'&recipient='+recipient_id,
            data: parametros, 

            success: function(datos){

                $('#save_data_address').attr("disabled", false);

                // window.setTimeout(function() {


                    if (type==='user_customer') {

                        $(".resultados_ajax_add_user_modal_sender").html(datos);

                    }else{

                        $(".resultados_ajax_add_user_modal_recipient").html(datos);

                    }
                     $("#myModalAddRecipientAddresses").modal('hide');

                    window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove();});}, 5000);




                // }, 3000);                
            } 
        });     


  event.preventDefault();
    
})



</script>



<script>


        errorMsg = document.querySelector("#error-msg");
        validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];


        var input = document.querySelector("#phone_custom");
        var iti = window.intlTelInput(input, {
          // allowDropdown: false,
          // autoHideDialCode: false,
          // autoPlaceholder: "off",
          // dropdownContainer: document.body,
          // excludeCountries: ["us"],
          // formatOnDisplay: true,
          geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
            });
          },
          // hiddenInput: "full_number",
          initialCountry: "auto",
          // localizedCountries: { 'de': 'Deutschland' },
          nationalMode: true,
          // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
          // placeholderNumberType: "MOBILE",
          // preferredCountries: ['cn', 'jp'],
          separateDialCode: true,
          utilsScript: "assets/intl-tel-input/js/utils.js",
        });




        var reset = function() {
          input.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
          reset();
          if (input.value.trim()) {

            if (iti.isValidNumber()) {

                $('#phone').val(iti.getNumber());

              validMsg.classList.remove("hide");

            } else {

              input.classList.add("error");
              var errorCode = iti.getValidationError();
              errorMsg.innerHTML = errorMap[errorCode];
              errorMsg.classList.remove("hide");

            }
          }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);

    </script>

   
</body>

</html>