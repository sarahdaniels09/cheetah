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


		
	$userData = $user->getUserData();
    require_once ("helpers/querys.php");

    require_once ("helpers/phpmailer/class.phpmailer.php");
    require_once ("helpers/phpmailer/class.smtp.php");


   

    $db= new Conexion;

             //Prefix tracking   
            $sql = "SELECT * FROM settings";
            
            $db->query($sql);

            $db->execute();

            $settings =$db->registro();

            $order_prefix = $settings->prefix;
            $check_mail = $settings->mailer;
            $names_info = $settings->smtp_names;
            $mlogo = $settings->logo;
            $msite_url = $settings->site_url;
            $msnames = $settings->site_name;

            //SMTP
           
            $smtphoste = $settings->smtp_host;
            $smtpuser = $settings->smtp_user;
            $smtppass = $settings->smtp_password;
            $smtpport = $settings->smtp_port;
            $smtpsecure = $settings->smtp_secure;

            $tax = $settings->tax;
            $insurance = $settings->insurance;
            $value_weight = $settings->value_weight;
            $meter = $settings->meter;            
            $c_tariffs = $settings->c_tariffs;            
            $site_email = $settings->site_email;


        if (isset($_POST["create_invoice"])) {
            

            $db->query("SELECT MAX(order_no) AS order_no FROM add_order");
            $db->execute();

            $invNum =$db->fetch_assoc();
            $max_id = $invNum['order_no'];
            $cod=$max_id;
            $next_order=$core->order_track(); 
            $date = date('Y-m-d', strtotime(trim($_POST["order_date"]))); 
            $time= date("H:i:s");

            $date = $date.' '.$time; 

            $status =11;

            $order_incomplete=0;

            $days = 0;


            $days=intval($days);
            
            $sale_date   = date("Y-m-d H:i:s");

            $due_date=sumardias($sale_date, $days);

            

                $status_invoice=2;
            
           
                $db->query("
                INSERT INTO add_order 
                (
                    user_id,
                    order_prefix,
                    order_no,
                    order_date,
                    sender_id,
                    sender_address_id,
                    receiver_id,                
                    receiver_address_id,   
                    volumetric_percentage,                 
                    order_datetime,                    
                    order_package,            
                    order_pay_mode,
                    status_courier,
                    due_date,      
                    status_invoice,
                    order_incomplete
                    )
                VALUES
                    (
                    :user_id,
                    :order_prefix,
                    :order_no,
                    :order_date,
                    :sender_id,
                    :sender_address_id,
                    :receiver_id,       
                    :receiver_address_id,          
                    :volumetric_percentage,
                    :order_datetime,                    
                    :order_package,                                  
                    :order_pay_mode,
                    :status_courier,
                    :due_date,
                    :status_invoice,
                    :order_incomplete
                    )
            ");



            $db->bind(':user_id',  $_SESSION['userid']);
            $db->bind(':order_prefix',  $order_prefix);
            $db->bind(':volumetric_percentage',  $meter);
            $db->bind(':order_no',  $next_order);
            $db->bind(':order_datetime',  trim($date));

            $db->bind(':sender_id',  trim($_POST["sender_id_temp"]));        
            $db->bind(':receiver_id',  trim($_POST["recipient_id"]));        
            $db->bind(':sender_address_id',  trim($_POST["sender_address_id"]));        
            $db->bind(':receiver_address_id',  trim($_POST["recipient_address_id"]));

            
            $db->bind(':order_date',  date("Y-m-d H:i:s"));                    
            
            $db->bind(':order_package',  trim($_POST["order_package"]));
            
            $db->bind(':order_pay_mode',  trim($_POST["order_pay_mode"]));

            $db->bind(':status_courier',  trim($status));
            $db->bind(':order_incomplete',  $order_incomplete);
    
            $db->bind(':due_date',  $due_date);
            $db->bind(':status_invoice',  $status_invoice);
            $success= $db->execute();
           
            
            $order_id = $db->dbh->lastInsertId();          

            for ($count = 0; $count < $_POST["total_item"]; $count++) {                

                $db->query("
                  INSERT INTO add_order_item 
                  (
                  order_id,
                  order_item_description,
                  order_item_category,
                  order_item_quantity,
                  order_item_weight,
                  order_item_length,
                  order_item_width,
                  order_item_height,
                  order_item_declared_value

                                  
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
                  :order_item_height,
                  :order_item_declared_value               

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
                $db->bind(':order_item_declared_value',  trim($_POST["order_item_declared_value"][$count]));               

                $db->execute();
            
            }

            



            if (count($_FILES['filesMultiple']['name'])>0 && $_FILES['filesMultiple']['tmp_name'][0]!='') { 

                $target_dir="order_files/";

                // var_dump($_FILES['filesMultiple']['name']);

                foreach($_FILES["filesMultiple"]['tmp_name'] as $key => $tmp_name)
                { 

                    $image_name = time()."_".basename($_FILES["filesMultiple"]["name"][$key]);
                    $target_file = $target_dir .$image_name ;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    $imageFileZise=$_FILES["filesMultiple"]["size"][$key];                   

                    if ($imageFileZise>0){

                        move_uploaded_file($_FILES["filesMultiple"]["tmp_name"][$key], $target_file);
                        $imagen=basename($_FILES["filesMultiple"]["name"][$key]);
                        $file="image_path='img/usuarios/$image_name' ";
                    
                    }

                    insertOrdersFiles($order_id, $target_file, $image_name, date("Y-m-d H:i:s"), '1');

                 
                }

            }



             // Add a recipient
            $db->query("SELECT * FROM users where id= '".$_POST["sender_id_temp"]."'"); 
            $sender_data= $db->registro();


            $fullshipment = $order_prefix.$next_order;
            $date_ship   = date("Y-m-d H:i:s a");
    
            $app_url = $settings->site_url.'/track.php?order_track='.$fullshipment;
            $subject="a new shipment has been created, tracking number $fullshipment";



            $email_template =getEmailTemplates(16);

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



            //INSERT HISTORY USER
            $date = date("Y-m-d H:i:s");
            $db->query("
                INSERT INTO order_user_history 
                (
                    user_id,
                    order_id,
                    action,
                    date_history                   
                    )
                VALUES
                    (
                    :user_id,
                    :order_id,
                    :action,
                    :date_history
                    )
            ");



            $db->bind(':order_id',  $order_id);
            $db->bind(':user_id',  $_SESSION['userid']);
            $db->bind(':action','create shipping pickup'); 
            $db->bind(':date_history',  trim($date));
            $db->execute();
            


                        // SAVE NOTIFICATION
            $fullshipment = $order_prefix.$next_order;
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
            $db->bind(':notification_description','There is a new shipment, check it out');           
            $db->bind(':shipping_type', '1');           
            $db->bind(':notification_date',  date("Y-m-d H:i:s"));        

            $db->execute();


            $notification_id = $db->dbh->lastInsertId(); 

            //NOTIFICATION TO DRIVER

            $users_drivers = $user->userAllDriver();

            foreach ($users_drivers as $key) {

                insertNotificationsUsers($notification_id, $key->id);             
                  
            }

            //NOTIFICATION TO ADMIN AND EMPLOYEES

            $users_employees = getUsersAdminEmployees();

            foreach ($users_employees as $key) {

                insertNotificationsUsers($notification_id, $key->id);             
                  
            }
            //NOTIFICATION TO CUSTOMER

            insertNotificationsUsers($notification_id, $_POST['sender_id_temp']);  


            $db->query("SELECT * FROM users_multiple_addresses where id_addresses= '".$_POST["sender_address_id"]."'");

            $sender_address_data= $db->registro();

            $sender_address =$sender_address_data->address;
            $sender_country =$sender_address_data->country;
            $sender_city =$sender_address_data->city;
            $sender_zip_code =$sender_address_data->zip_code;


            $db->query("SELECT * FROM users_multiple_addresses where id_addresses= '".$_POST["recipient_address_id"]."'");

            $recipient_address_data= $db->registro();


            $recipient_address =$recipient_address_data->address;
            $recipient_country =$recipient_address_data->country;
            $recipient_city =$recipient_address_data->city;
            $recipient_zip_code =$recipient_address_data->zip_code;


            // SAVE ADDRESS FOR Shipments

            $db->query("
                INSERT INTO address_shipments
                (
                    order_track,
                    sender_address,
                    sender_country,
                    sender_city,
                    sender_zip_code,

                    recipient_address,
                    recipient_country,
                    recipient_city,
                    recipient_zip_code

                )
                VALUES
                    (
                    :order_track,
                    :sender_address,
                    :sender_country,
                    :sender_city,
                    :sender_zip_code,
                    
                    :recipient_address,
                    :recipient_country,
                    :recipient_city,
                    :recipient_zip_code                
                    )
            ");



            $db->bind(':order_track',  $fullshipment); 

            $db->bind(':sender_address',  $sender_address);       
            $db->bind(':sender_country',  $sender_country);       
            $db->bind(':sender_city',  $sender_city);       
            $db->bind(':sender_zip_code',  $sender_zip_code);

            $db->bind(':recipient_address',  $recipient_address);       
            $db->bind(':recipient_country',  $recipient_country);       
            $db->bind(':recipient_city',  $recipient_city);       
            $db->bind(':recipient_zip_code',  $recipient_zip_code);       

            $db->execute();    

             header("location:courier_view.php?id=$order_id");
            
       

       
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
        
        <?php $itemrow = $core->getItem(); ?>
        <?php $moderow = $core->getShipmode();?>
        <?php $driverrow = $user->userAllDriver();?>
        <?php $delitimerow = $core->getDelitime();?>
        <?php $track = $core->order_track();?>
        <?php $categories = $core->getCategories();?>

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
			
			 <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title"><i class="ti-package" aria-hidden="true"></i> <?php echo $lang['left82'] ?></h4> <br>
                    </div>
                </div>
            </div>

            <form method="post" id="invoice_form" name="invoice_form" enctype="multipart/form-data">

            <div class="container-fluid">
                <?php if(isset($_GET['success']) && $_GET['success']==1){?>

                <div class="alert alert-info" id="success-alert">
                    <p><span class="icon-info-sign"></span><i class="close icon-remove-circle"></i>
                        Your collection has been created successfully!
                   </p>
                </div>
                <?php
                }else if(isset($_GET['success']) && $_GET['success']==0){ ?>

                <div class="alert alert-danger" id="success-alert">
                <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
                        <span>Error! </span> There was an error processing the request
                   </p>
                </div>
                <?php
                }
                ?>



                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['langs_010']; ?></h4>
                                <hr>

                                <div class="resultados_ajax_add_user_modal_sender"></div>

                               
                                
                                    <div class="row"> 

                                     <div class="col-md-12 ">

                                        <label class="control-label col-form-label"><?php echo $lang['sender_search_title'] ?></label>
                                       
                                        
                                        <div class="input-group">
                                            <select class="select2 form-control custom-select" id="sender_id" name="sender_id" disabled="">
                                                <option value="<?php echo $userData->id;?>" selected> <?php echo $userData->fname.' '.$userData->lname; ?></option>

                                            </select>

                                            <input type="hidden" name="sender_id_temp" id="sender_id_temp"  value="<?php echo $userData->id;?>">


                                           <!--  <div class="input-group-append input-sm">
                                                <button  type="button" class="btn btn-info" data-type_user="user_customer"   data-toggle="modal" data-target="#myModalAddUser"><i class="fa fa-plus"></i></button>
                                            </div> -->

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
                <!-- Row -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="card">                    
                           <div class="card-body">                                        
                                <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['left334']; ?></h4>
                                <hr>
                                <div class="resultados_ajax_add_user_modal_recipient"></div>

                               
                                            
                                <div class="row">                               

                                    <div class="col-md-12">
                                        <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_title'] ?></label>                                       

                                        <div class="input-group">

                                           <select class="select2 form-control custom-select" id="recipient_id" name="recipient_id">
                                            </select>

                                            <div class="input-group-append input-sm">
                                                <button  id="add_recipient" type="button"  data-type_user="user_recipient"   data-toggle="modal" data-target="#myModalAddUser"  class="btn btn-info"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div> 
                                    </div>

                                    <div class="col-md-12">

                                        <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_address_title'] ?></label>
                                      

                                        <div class="input-group">

                                            <select class="select2 form-control" id="recipient_address_id" name="recipient_address_id" disabled="">
                                            </select>

                                            <div class="input-group-append input-sm">
                                                <button  disabled id="add_address_recipient" type="button"  data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddRecipientAddresses" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div> 
                                    </div>

                                   
                                </div> 


                            </div>                     
                        </div>                 
                    </div>
                </div>
                <!-- Row -->






            <div class="row">
                <div class="col-lg-12">
                    <div class="card"> 
                        <div class="card-body">
                            <h4 class="card-title"><i class="mdi mdi-book-multiple" style="color:#36bea6"></i> <?php echo $lang['add-title13'] ?></h4>
                            <br>
                            <div class="row"> 

                            <?php if($userData->userlevel == 9 || $userData->userlevel == 3){?>

                            <div class="form-group col-md-6">
                                <label for="inputlname" class="control-label col-form-label"><?php echo $lang['left201'] ?> </label>
                                <div class="input-group mb-3">
                                    <select class="custom-select col-12" id="agency" name="agency" >
                                    <option value="0">--<?php echo $lang['left202'] ?>--</option>
                                    <?php foreach ($agencyrow as $row):?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name_branch; ?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                            </div> 

                            <?php }else{ ?> 
                            <input type="hidden" name="agency" id="agency" value="000">
                            <?php }?>                                  

                                <div class="form-group col-md-6">
                                    <label for="inputlname" class="control-label col-form-label"><?php echo $lang['add-title17'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_package" name="order_package" >
                                        <option value="0">--<?php echo $lang['left203'] ?>--</option>
                                        <?php foreach ($packrow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name_pack; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>                            
                                   

                                <div class="col-md-6">
                                    <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title1555'] ?></i></label>
                                    <div class="input-group">
                                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i style="color:#ff0000" class="fa fa-calendar"></i></div>
                                            </div>
                                        <input type='text' class="form-control" name="order_date" id="order_date" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title1555'] ?>" readonly value="<?php echo date('Y-m-d'); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title23'] ?> <i style="color:#ff0000" class="fas fa-donate"></i></label>
                                    <div class="input-group mb-3">                                       
                                        <select class="custom-select col-12" id="order_pay_mode" name="order_pay_mode" >
                                        <option value="0">--<?php echo $lang['left243'] ?>--</option>
                                        <?php foreach ($payrow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->met_payment; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 

                               <!--  <div class="form-group col-md-4">
                                    <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title18'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_courier" name="order_courier" >
                                        <option value="0">--<?php echo $lang['left204'] ?>--</option>
                                        <?php foreach ($courierrow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name_com; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>  -->
                              



                               <!--  <div class="form-group col-md-4">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title22'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_service_options" name="order_service_options" >
                                        <option value="0">--<?php echo $lang['left205'] ?>--</option>
                                        <?php foreach ($moderow as $row):?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->ship_mode; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> -->

                            </div>

                            
                              <!--/row-->
                            <div class="row">                                

                                <div class="col-md-4">                             

                                   <div>
                                        <label class="control-label" id="selectItem" > Attach files</label>
                                    </div>

                                    <input class="custom-file-input" id="filesMultiple" name="filesMultiple[]" multiple="multiple" type="file"  style="display: none;" onchange="validateZiseFiles();"/>
                                     
                                     
                                    <button type="button" id="openMultiFile" class="btn btn-info  pull-left "> <i class='fa fa-paperclip' id="openMultiFile" style="font-size:18px; cursor:pointer;"></i> Upload files </button>

                                    <div id="clean_files" class="hide">     
                                     <button type="button" id="clean_file_button" class="btn btn-danger ml-3"> <i class='fa fa-trash' style="font-size:18px; cursor:pointer;"></i> Cancel attachments </button>
                                    
                                    </div>

                                </div>                                

                             
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
                                                <input type="text" name="order_item_description[]" id="order_item_description1" class="form-control input-sm order_item_description" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left225'] ?>"  placeholder="<?php echo $lang['left224'] ?>" required>
                                            </div>
                                    </div>
                                    
                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label for="emailAddress1">  Declared value</label>                             
                                            <div class="input-group">                                               

                                                <input type="text" onkeypress="return soloNumeros(event)"  name="order_item_declared_value[]" id="order_item_declared_value1" data-srno="1" class="form-control input-sm number_only order_item_declared_value" data-toggle="tooltip" data-placement="bottom" title="Declared value"  value="0"/>
                                                <!-- <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-secondary "><i class="fa fa-plus"></i></button>
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
                                                    <button type="button" class="btn btn-default" onclick="decrementInputNumber('order_item_quantity', 1)"><i class="fa fa-minus"></i></button>
                                                </div>
                                                <input min="1" type="text" onkeypress="return soloNumeros(event)"  name="order_item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left227'] ?>"  value="1" required />
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="incrementInputNumber('order_item_quantity', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-2">

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left215']; ?></label>
                                            <div class="input-group">

                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="decrementInputNumber('order_item_weight', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)"  name="order_item_weight[]" id="order_item_weight1" data-srno="1" class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title31'] ?>"  value="0" />

                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="incrementInputNumber('order_item_weight', 1)"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="emailAddress1"><?php echo $lang['left216'] ?></label>
                                            <div class="input-group">
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="decrementInputNumber('order_item_length', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)" name="order_item_length[]" id="order_item_length1" data-srno="1" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title37'] ?>"  value="0" />
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="incrementInputNumber('order_item_length', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                </div>


                                <div class="col-md-2">                                

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left217'] ?></label>
                                            <div class="input-group">
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="decrementInputNumber('order_item_width', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)" name="order_item_width[]" id="order_item_width1" data-srno="1" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title38'] ?>"  value="0" />
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="incrementInputNumber('order_item_width', 1)"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-2">

                                    <div class="form-group">

                                        <label for="emailAddress1"><?php echo $lang['left218'] ?></label>                             
                                            <div class="input-group">

                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="decrementInputNumber('order_item_height', 1)"><i class="fa fa-minus"></i></button>
                                                </div>

                                                <input type="text" onkeypress="return soloNumeros(event)"  name="order_item_height[]" id="order_item_height1" data-srno="1" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title39'] ?>"  value="0"/>
                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" onclick="incrementInputNumber('order_item_height', 1)"><i class="fa fa-plus"></i></button>
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
                          
                           

                            <div class="col-md-12">
                                <div class="form-actions">
                                    <div class="card-body">
                                        <div class="text-right">
                                            
                                            <input type="hidden" name="total_item" id="total_item" value="1" />

                                            
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
    function validateZiseFiles(){

    var inputFile = document.getElementById('filesMultiple');
    var file = inputFile.files;

        var size =0;
        console.log(file);

        for(var i = 0; i < file.length; i ++){

            var filesSize = file[i].size;

            if(size > 5242880){               

                $('.resultados_file').html("<div class='alert alert-danger'>"+
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
                        "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>"+
                        
                    "</div>"
                );
            }else{
                $('.resultados_file').html("");
            }

            size+=filesSize;
        }

        if(size > 5242880){ 
            $('.resultados_file').html("<div class='alert alert-danger'>"+
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
                        "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>"+
                        
                    "</div>"
                );

            return true;

        }else{
                $('.resultados_file').html("");

            return false;
        }          

}
</script>

    <script>
        
          $('#openMultiFile').click(function(){

    $("#filesMultiple").click();
  });


  $('#clean_file_button').click(function(){

    $("#filesMultiple").val('');

    $('#selectItem').html('Attach files');

    $('#clean_files').addClass('hide');


  });



  $('input[type=file]').change(function(){

    var inputFile = document.getElementById('filesMultiple');
    var file = inputFile.files;
    var contador = 0;
    for(var i=0; i<file.length; i++){

        contador ++;
    }
    if(contador>0){

        $('#clean_files').removeClass('hide');
    }else{

        $('#clean_files').addClass('hide');

    }

    $('#selectItem').html('attached files ('+contador+')');
  });
    </script>
    <script>
    $(document).ready(function() {

        $('#order_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });

    // $("#resultados_ajax" ).load( "./ajax/courier/courier_add_item_tmp.php");

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
                        '<button type="button" class="btn btn-default" onclick="decrementInputNumber(1,  '+count+')"><i class="fa fa-minus"></i></button>'+
                    '</div>'+

                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_quantity[]" id="order_item_quantity'+count+'" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left227'] ?>"  value="1" required />'+

                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="incrementInputNumber(1,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                   '</div>'+
            '</div>'+                
        '</div>';

        html_code += '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left215']; ?></label>'+
                    '<div class="input-group">'+
                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="decrementInputNumber(2,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+

                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_weight[]" id="order_item_weight'+count+'"class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title31'] ?>"  value="0" />'+

                             '<div class="input-group-append input-sm">'+
                                '<button type="button" class="btn btn-default" onclick="incrementInputNumber(2,  '+count+')"><i class="fa fa-plus"></i></button>'+
                            '</div>'+
                    '</div>'+
            
            '</div>'+
        '</div>';

        html_code += '<div class="col-md-2">'+
            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left216'] ?></label>'+
                    '<div class="input-group">'+

                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="decrementInputNumber(3,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+
                        '<input type="text" onkeypress="return soloNumeros(event)" name="order_item_length[]" id="order_item_length'+count+'" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title37'] ?>"  value="0" />'+

                         '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="incrementInputNumber(3,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                    '</div>'+
            '</div>'+
        '</div>';


         html_code += '<div class="col-md-2">'+                               

            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left217'] ?></label>'+
                    '<div class="input-group">'+
                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="decrementInputNumber(4,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+
                        '<input type="text" onkeypress="return soloNumeros(event)" name="order_item_width[]" id="order_item_width'+count+'" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title38'] ?>"  value="0" />'+

                         '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="incrementInputNumber(4,  '+count+')"><i class="fa fa-plus"></i></button>'+
                        '</div>'+
                    '</div>'+
            '</div>'+
        '</div>';


         html_code += '<div class="col-md-2">'+

            '<div class="form-group">'+
                '<label for="emailAddress1"><?php echo $lang['left218'] ?></label> '+                            
                    '<div class="input-group">'+
                        '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="decrementInputNumber(5,  '+count+')"><i class="fa fa-minus"></i></button>'+
                        '</div>'+
                        '<input type="text" onkeypress="return soloNumeros(event)"  name="order_item_height[]" id="order_item_height'+count+'" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title39'] ?>"  value="0"/>'+
                         '<div class="input-group-append input-sm">'+
                            '<button type="button" class="btn btn-default" onclick="incrementInputNumber(5,  '+count+')"><i class="fa fa-plus"></i></button>'+
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


            $('#add_row').attr("disabled", true);

         
             setTimeout(function(){

            $('#row_id_'+count).css({'background-color':''});
            $('#add_row').attr("disabled", false);

          }, 900);
         
        });





        $('#create_invoice').click(function(){

        // data receiver

          if($.trim($('#recipient_id').val()).length == 0)
          {
            alert("Please select recipient customer");
            return false;
          }


           if($.trim($('#recipient_address_id').val()).length == 0)
          {
            alert("Please select recipient customer address");
            return false;
          }


          //data sender

          if($.trim($('#sender_id_temp').val()).length == 0)
          {
            alert("Please select sender customer");

            return false;
          }

          if($.trim($('#sender_address_id').val()).length == 0)
          {
            alert("Please select sender customer address");

            return false;
          }

          
          
          if($.trim($('#order_package').val())== 0)
          {
            alert("Please Select package name");
            return false;
          }
          
         
         
          
           if($.trim($('#order_pay_mode').val())== 0)
          {
            alert("Please Enter method payment");
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


               if($.trim($('#order_item_length'+no).val()).length == 0)
            {
              alert("Please Enter length");
              $('#order_item_length'+no).focus();
              return false;
            }

            if($.trim($('#order_item_width'+no).val()).length == 0)
            {
              alert("Please Enter width");
              $('#order_item_width'+no).focus();
              return false;
            }

            if($.trim($('#order_item_height'+no).val()).length == 0)
            {
              alert("Please Enter height");
              $('#order_item_height'+no).focus();
              return false;
            }  

            if($.trim($('#order_item_declared_value'+no).val()).length == 0)
            {
              alert("Please enter Declared value");
              $('#order_item_declared_value'+no).focus();
              return false;
            }             
           

          }

          $('#invoice_form').submit();

        });

    });

</script>













<script>

 $(document).ready(function() {

   select2_init_sender();
   select2_init_sender_address();
   select2_init_recipient_address();
   select2_init_recipient();

            
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

        var sender_id =$( "#sender_id_temp" ).val();

        

            $( "#sender_address_id").attr("disabled", true);

             $( "#recipient_id").attr("disabled", true);

             $( "#recipient_address_id").attr("disabled", true);
             $( "#add_address_sender").attr("disabled", true);
             $( "#add_recipient").attr("disabled", true);

             $( "#add_address_recipient").attr("disabled", true);


             $( "#recipient_id" ).val(null).trigger('change');
             $( "#sender_address_id" ).val(null).trigger('change');
             $( "#recipient_address_id" ).val(null).trigger('change');

            if(sender_id!=null){

            
                 $( "#add_address_sender").attr("disabled", false);

                $( "#sender_address_id").attr("disabled", false);

                $( "#recipient_id").attr("disabled", false);

                 $( "#add_recipient").attr("disabled", false);
            }

        select2_init_sender_address();
        select2_init_recipient_address();
        select2_init_recipient();


    });
}



function select2_init_sender_address(){

    var sender_id =$( "#sender_id_temp" ).val();

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





function select2_init_recipient(){

    var sender_id =$( "#sender_id_temp" ).val();


    $( "#recipient_id" ).select2({        
    ajax: {
        url: "ajax/select2_recipient.php?id="+sender_id,
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

    // minimumInputLength: 2,
     placeholder: "Search recipient customer",
    allowClear: true
    }).on('change', function (e) {


        var recipient_id =$( "#recipient_id" ).val();
      
         $( "#add_address_recipient").attr("disabled", true);
         $( "#recipient_address_id").attr("disabled", true);
         $( "#recipient_address_id").val(null).trigger('change');

        if(recipient_id!=null){
      

             $( "#recipient_address_id").attr("disabled", false);
             $( "#add_address_recipient").attr("disabled", false);

           
        }

        select2_init_recipient_address();



    });
}

function select2_init_recipient_address(){

    var recipient_id =$( "#recipient_id" ).val();

    $( "#recipient_address_id").select2({        
    ajax: {
        url: "ajax/select2_recipient_addresses.php?id="+recipient_id,
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
     placeholder: "Search recipient customer address",
    allowClear: true
    });

}





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

        var sender_id = $('#sender_id_temp').val();

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



<script>


    function incrementInputNumber(input, count){

             switch(input){

                case 1:
                    input = 'order_item_quantity';

                break;

                case 2:

                    input = 'order_item_weight';
                
                break

                case 3:

                    input = 'order_item_length';
                
                break

                case 4:

                    input = 'order_item_width';
                
                break

                case 5:

                    input = 'order_item_height';
                
                break

            }

        var quantity = parseInt($('#'+input+count).val());

        $('#'+input+count).val(quantity +1 );

        

    }


        function decrementInputNumber(input, count){



            switch(input){

                case 1:
                    input = 'order_item_quantity';

                break;

                case 2:

                    input = 'order_item_weight';
                
                break

                case 3:

                    input = 'order_item_length';
                
                break

                case 4:

                    input = 'order_item_width';
                
                break

                case 5:

                    input = 'order_item_height';
                
                break

            }
        var quantity = parseInt($('#'+input+count).val());

        if(quantity>0){

            $('#'+input+count).val(quantity -1 );
        }

       

    }    

</script>

<script type="text/javascript">

    function soloNumeros(e){
    var key = e.charCode;
    return key >= 44 && key <= 57;
}
</script>

   
</body>

</html>