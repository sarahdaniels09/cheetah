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

    $userData = $user->getUserData();
    if ($userData->userlevel==1)
    redirect_to("login.php");
    

    if (isset($_GET['id'])) {
        $data= getConsolidatePrint($_GET['id']);
    }

    if (!isset($_GET['id']) or $data['rowCount']!=1){
        redirect_to("consolidate_list.php");
    }

    $row_order=$data['data'];


    $db->query("SELECT * FROM consolidate_detail WHERE consolidate_id='".$_GET['id']."'"); 
    $order_items= $db->registros();

    $db->query("SELECT * FROM users where id= '".$row_order->sender_id."'"); 
    $sender_data= $db->registro();

    $db->query("SELECT * FROM users where id= '".$row_order->receiver_id."'"); 
    $receiver_data= $db->registro();

                 
    $db->query("SELECT * FROM address_shipments where order_track='".$row_order->c_prefix.$row_order->c_no."'"); 
    $address_order= $db->registro();

       

        if (isset($_POST["total_item"])) {   
        // var_dump($_POST["total_item"]);        

    $db= new Conexion;
                    
                $db->query("
                UPDATE  consolidate SET                
                    
                    sender_id =:sender_id,
                    receiver_id =:receiver_id,     
                     sender_address_id= :sender_address_id,
                    receiver_address_id = :receiver_address_id,              
                    sub_total =:sub_total,
                    total_tax_insurance =:total_tax_insurance,
                    total_tax_custom_tariffis =:total_tax_custom_tariffis,                    
                    total_tax_discount=:total_tax_discount,
                    total_tax =:total_tax,
                    total_order =:total_order,                    
                    order_datetime =:order_datetime,
                    agency =:agency,
                    origin_off =:origin_off,
                    order_package =:order_package,
                    order_courier =:order_courier,
                    order_service_options =:order_service_options,
                    order_deli_time =:order_deli_time,                   
                    order_pay_mode =:order_pay_mode,
                    status_courier =:status_courier,
                    driver_id=:driver_id,
                    seals_package=:seals_package
                    total_weight=:total_weight,            

                    WHERE c_no=:order_no
                 
                
            ");



            $db->bind(':order_no',  $row_order->c_no);
            $db->bind(':order_datetime',  trim($_POST["order_date"]));
            $db->bind(':sender_id',  trim($_POST["sender_id"]));        
            $db->bind(':receiver_id',  trim($_POST["receiver_id"]));        
            $db->bind(':sender_address_id',  trim($_POST["sender_address_id"]));        
            $db->bind(':receiver_address_id',  trim($_POST["recipient_address_id"]));  

            $db->bind(':sub_total',  floatval($_POST["subtotal_input"]));
            $db->bind(':total_tax_insurance',  floatval($_POST["insurance_input"]));
            $db->bind(':total_tax_discount',  floatval($_POST["discount_input"]));
            $db->bind(':total_tax_custom_tariffis',  floatval($_POST["total_impuesto_aduanero_input"]));
            $db->bind(':total_tax',  floatval($_POST["impuesto_input"]));
            $db->bind(':total_order',  floatval($_POST["total_envio_input"]));
            $db->bind(':total_weight',  floatval($_POST["total_weight_input"]));

            $db->bind(':agency',  trim($_POST["agency"]));
            $db->bind(':origin_off',  trim($_POST["origin_off"]));
            $db->bind(':order_package',  trim($_POST["order_package"]));
            $db->bind(':order_courier',  trim($_POST["order_courier"]));
            $db->bind(':order_service_options',  trim($_POST["order_service_options"]));
            $db->bind(':order_deli_time',  trim($_POST["order_deli_time"]));           
            $db->bind(':order_pay_mode',  trim($_POST["order_pay_mode"]));
            $db->bind(':status_courier',  trim($_POST["status_courier"]));
            $db->bind(':driver_id',  trim($_POST["driver_id"]));
            $db->bind(':seals_package',  trim($_POST["seals"]));

            $db->execute();

            $order_id = $row_order->consolidate_id ;

            $db->query("DELETE FROM  consolidate_detail WHERE consolidate_id='".$order_id."'");
            $db->execute();
           
            
            
             for ($count = 0; $count < $_POST["total_item"]; $count++) {                

                $db->query("
                  INSERT INTO consolidate_detail 
                  (
                  consolidate_id,
                  order_id,
                  order_prefix,
                  order_no,
                  weight,
                  weight_vol,  
                  length,
                  width,
                  height              
                                  
                  )
                  VALUES 
                  (
                  :consolidate_id,
                  :order_id,
                  :order_prefix,
                  :order_no, 
                  :weight,
                  :weight_vol,
                  :length,
                  :width,
                  :height                               
                  )
                ");

               
                $db->bind(':consolidate_id',  $order_id);
                $db->bind(':order_prefix',  trim($_POST["prefix"][$count]));
                $db->bind(':order_no',  trim($_POST["order_no_item"][$count]));
                $db->bind(':weight',  trim($_POST["weight"][$count]));                
                $db->bind(':length',  trim($_POST["length"][$count]));                
                $db->bind(':width',  trim($_POST["width"][$count]));                
                $db->bind(':height',  trim($_POST["height"][$count]));                
                $db->bind(':weight_vol',  trim($_POST["weight_vol"][$count]));
                $db->bind(':order_id',  trim($_POST["order_id"][$count]));

                $db->execute();


            
                $is_consolidate=1;

                $db->query("
                UPDATE  add_order SET                
                    
                    is_consolidate=:is_consolidate

                    WHERE order_id=:order_id                 
                
                ");

                $db->bind(':order_id',  trim($_POST["order_id"][$count]));
                $db->bind(':is_consolidate',  $is_consolidate);
            
                $db->execute();
            }       

                        //INSERT HISTORY USER
            $date = date("Y-m-d H:i:s");
            $db->query("
                INSERT INTO order_user_history 
                (
                    user_id,
                    order_id,
                    action,
                    date_history,
                    is_consolidate                  
                    )
                VALUES
                    (
                    :user_id,
                    :order_id,
                    :action,
                    :date_history,
                    :is_consolidate
                    )
            ");



            $db->bind(':order_id',  $order_id);
            $db->bind(':is_consolidate', '1');
            $db->bind(':user_id',  $_SESSION['userid']);
            $db->bind(':action','update consolidated'); 
            $db->bind(':date_history',  trim($date));
            $db->execute();


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
                UPDATE address_shipments SET
                
                    sender_address= :sender_address,
                    sender_country= :sender_country,
                    sender_city= :sender_city,
                    sender_zip_code= :sender_zip_code,

                    recipient_address= :recipient_address,
                    recipient_country= :recipient_country,
                    recipient_city= :recipient_city,
                    recipient_zip_code=:recipient_zip_code  

                    WHERE order_track=:order_track

            ");



            $db->bind(':order_track',  $row_order->c_prefix.$row_order->c_no); 

            $db->bind(':sender_address',  $sender_address);       
            $db->bind(':sender_country',  $sender_country);       
            $db->bind(':sender_city',  $sender_city);       
            $db->bind(':sender_zip_code',  $sender_zip_code);

            $db->bind(':recipient_address',  $recipient_address);       
            $db->bind(':recipient_country',  $recipient_country);       
            $db->bind(':recipient_city',  $recipient_city);       
            $db->bind(':recipient_zip_code',  $recipient_zip_code);       

            $db->execute();      
      

       

       
        header("location:consolidate_view.php?id=$row_order->consolidate_id");   
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
    <title><?php echo $lang['langs_01'] ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/intl-tel-input/css/intlTelInput.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="assets/select2/dist/css/select2.min.css">
    <link href="assets/css_log/front.css" rel="stylesheet" type="text/css"> 

    <link href="assets/css/style.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/jquery-ui.css" type="text/css" />

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>

    <!-- <script src="assets/js/jquery.ui.touch-punch.js"></script>
    <script src="assets/js/jquery.wysiwyg.js"></script> -->
    <script src="assets/js/global.js"></script>
    <!-- <script src="assets/js/custom.js"></script> -->
    
    <link rel="stylesheet" href="assets/bootstrap-datetimepicker.min.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="assets/customClassPagination.css" rel="stylesheet">
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
                        <h4 class="page-title"><i class="ti-package" aria-hidden="true"></i> <?php echo $lang['langs_01']; ?></h4>
                    </div>
                </div>
            </div>

            <form method="post" id="invoice_form" name="invoice_form">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card"> 
                            <div class="card-body"> 
                                <div class="form-row">   

                                    <div class="form-group col-md-3">

                                        <label for="inputcom" class="control-label col-form-label"><?php echo $lang['langs_020'] ?></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><span  style="color:#ff0000"><b>Consolidate #</b></span></div>
                                            </div>  
                                            <input type="text" class="form-control" name="order_no" id="order_no" value="<?php echo $row_order->c_prefix.$row_order->c_no;?>" readonly>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputlname" class="control-label col-form-label"><?php echo $lang['left201'] ?> </label>
                                        <div class="input-group mb-3">
                                            <select class="custom-select col-12" id="agency" name="agency" >
                                            <option value="0">--<?php echo $lang['left202'] ?>--</option>
                                            <?php foreach ($agencyrow as $row):?>
                                                <option value="<?php echo $row->id; ?>" <?php if($row_order->agency==$row->id){echo 'selected';}?>><?php echo $row->name_branch; ?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>                            
                                   

                                   

                                <?php if($user->access_level='Admin'){ ?>

                                    <div class="form-group col-md-3">
                                        <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                        <div class="input-group mb-3">
                                            <select class="custom-select col-12" id="exampleFormControlSelect1" name="origin_off" >
                                            <option value="0">--<?php echo $lang['left343'] ?>--</option>

                                            <?php foreach ($office as $row):?>
                                                <option value="<?php echo $row->id; ?>" <?php if($row_order->origin_off==$row->id){echo 'selected';}?>><?php echo $row->name_off; ?></option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                <?php 
                            // }
                            //     else if($user->access_level='Employee'){
                                    ?>

                                   <!--  <div class="form-group col-md-3">
                                        <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" name="origin_off" value="<?php echo $user->name_off; ?>" readonly>
                                        </div>
                                    </div> -->

                                <?php } ?>  

                                <div class="col-md-3"> 
                                    <div class="form-group"> 
                                        <label for="field-2" class="control-label col-form-label"><?php echo $lang['langs_021'] ?></label> 
                                        <input name="seals" id="seals" value="<?php echo $row_order->seals_package;?>" class="form-control" placeholder="00-00000">                                                    
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
                                <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['langs_010']; ?></h4>
                                <hr>

                                <div class="resultados_ajax_add_user_modal_sender"></div>
                               
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
                                                <option value="<?php echo $row_order->sender_address_id;?>"><?php echo $address_order->sender_address;?></option>
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
                                            <option value="<?php echo $receiver_data->id;?>"><?php echo $receiver_data->fname." ".$receiver_data->lname;?></option>
                                            </select>

                                            <div class="input-group-append input-sm">
                                                <button  id="add_recipient" type="button"  data-type_user="user_recipient"   data-toggle="modal" data-target="#myModalAddUser"  class="btn btn-info"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div> 
                                    </div>

                                    <div class="col-md-12">

                                        <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_address_title'] ?></label>
                                      

                                        <div class="input-group">

                                            <select class="select2 form-control" id="recipient_address_id" name="recipient_address_id">
                                                <option value="<?php echo $row_order->receiver_address_id;?>"><?php echo $address_order->recipient_address;?></option>
                                            </select>

                                            <div class="input-group-append input-sm">
                                                <button   id="add_address_recipient" type="button"  data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddRecipientAddresses" class="btn btn-info"><i class="fa fa-plus"></i></button>
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

                                <div class="form-group col-md-4">
                                    <label for="inputlname" class="control-label col-form-label"><?php echo $lang['add-title17'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_package" name="order_package" >
                                        <option value="0">--<?php echo $lang['left203'] ?>--</option>
                                        <?php foreach ($packrow as $row):?>
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->order_package==$row->id){echo 'selected';}?>><?php echo $row->name_pack; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>                            
                                   



                                <div class="form-group col-md-4">
                                    <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title18'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_courier" name="order_courier" >
                                        <option value="0">--<?php echo $lang['left204'] ?>--</option>
                                        <?php foreach ($courierrow as $row):?>
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->order_courier==$row->id){echo 'selected';}?>><?php echo $row->name_com; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 
                              



                                <div class="form-group col-md-4">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title22'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_service_options" name="order_service_options" >
                                        <option value="0">--<?php echo $lang['left205'] ?>--</option>
                                        <?php foreach ($moderow as $row):?>
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->order_service_options==$row->id){echo 'selected';}?>><?php echo $row->ship_mode; ?></option>
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
                                        <input type='text' class="form-control" name="order_date" id="order_date" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>"  value="<?php echo date("Y/m/d", strtotime($row_order->order_datetime));?>" readonly/>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="form-group col-md-4">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title20'] ?></label>
                                    <div class="input-group mb-3">
                                        <select class="custom-select col-12" id="order_deli_time" name="order_deli_time" >
                                        <option value="0">--<?php echo $lang['left207'] ?>--</option>
                                        <?php foreach ($delitimerow as $row):?>
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->order_deli_time==$row->id){echo 'selected';}?>><?php echo $row->delitime; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                        <!--/span-->

                               
                                <div class="form-group col-md-4">
                                    <label for="inputname" class="control-label col-form-label"><?php echo $lang['left208'] ?></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="color:#ff0000"><i class="fas fa-car"></i></span>
                                        </div>
                                        <select class="custom-select col-12" id="driver_id" name="driver_id" >
                                        <option value="0">--<?php echo $lang['left209'] ?>--</option>
                                        <?php foreach ($driverrow as $row):?>
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->driver_id==$row->id){echo 'selected';}?>><?php echo $row->fname.' '.$row->lname; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 


                            </div>
                            <!-- <HR> -->
                            <div class="row">                                

                                <div class="form-group col-md-4">
                                    <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title23'] ?> <i style="color:#ff0000" class="fas fa-donate"></i></label>
                                    <div class="input-group mb-3">                                       
                                        <select class="custom-select col-12" id="order_pay_mode" name="order_pay_mode" >
                                        <option value="0">--<?php echo $lang['left243'] ?>--</option>
                                        <?php foreach ($payrow as $row):?>
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->order_pay_mode==$row->id){echo 'selected';}?>><?php echo $row->met_payment; ?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 
                                
                                <!--/span-->

                               
                                <!--/span-->

                                <div class="form-group col-md-4">
                                    <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['langs_039'] ?> <i style="color:#ff0000" class="fas fa-shipping-fast"></i></label>
                                    <div class="input-group mb-3">                                       
                                        <select class="custom-select col-12" id="status_courier" name="status_courier" >
                                        <option value="0">--<?php echo $lang['left210'] ?>--</option>
                                        <?php foreach ($statusrow as $row):?>
                                            
                                            <option value="<?php echo $row->id; ?>" <?php if($row_order->status_courier==$row->id){echo 'selected';}?>><?php echo $row->mod_style; ?></option>
                                            
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <!--/row-->

                        </div>                 
                                            
                    </div>                 
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card"> 
                        <div class="card-body">
                           

                            <div id="resultados_ajax"></div>
                            <script > var selected = [];</script>
                                <div class="table-responsive">
                                    <table id="invoice-item-table" class="table">
                                        <div align="right">
                                            <button type="button" data-toggle="modal" data-target="#myModalConsolidate"  class="btn btn-success mb-2"><span class="fa fa-search"></span> Search Shipments</button>
                                        </div>
                                        <thead class="bg-inverse text-white">
                                        <tr>
                                            
                                            <th colspan="3"><b><?php echo $lang['ltracking'] ?></b></th>                
                                            <th colspan="2" class="text-center"><b>Weights</b></th>
                                            <th class="text-center"></th>
                                            <th  class="text-right"><b>Weight Vol.</b></th>
                                            <th></th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody id="projects-tbl">
                                        <?php 
                                        if($order_items){

                                            $sumador_total=0;
                                            $sumador_libras=0;
                                            $sumador_volumetric=0;

                                            $precio_total=0;
                                            $total_impuesto=0;
                                            $total_seguro=0;
                                            $total_peso=0;
                                            $total_descuento=0;
                                            $total_impuesto_aduanero =0;
                                             $count_item=0;

                                            foreach ($order_items as $row_order_item){

                                                // echo '<script> selected.push("'echo $row_order_item->order_id;'"); </script>';
                                               
                                                $weight_item = $row_order_item->weight;
                                                
                                                $total_metric = $row_order_item->length * $row_order_item->width * $row_order_item->height/$row_order->volumetric_percentage;  

                                                // calculate weight x price
                                                if ($weight_item > $total_metric) {

                                                    $calculate_weight = $weight_item;
                                                    $sumador_libras+=$weight_item;//Sumador

                                                } else {

                                                    $calculate_weight = $total_metric;                                                 
                                                    $sumador_volumetric+=$total_metric;//Sumador
                                                }

                                                $precio_total=$calculate_weight* $row_order->value_weight;
                                                $precio_total=number_format($precio_total, 2,'.','');//Precio total formateado

                                                $sumador_total+=$precio_total;                                                

                                                if($sumador_total> $core->min_cost_tax){

                                                    $total_impuesto= $sumador_total *$row_order->tax_value /100;
                                                }

                                                $total_descuento= $sumador_total *$row_order->tax_discount /100;
                                                $total_peso =$sumador_libras + $sumador_volumetric;

                                                $total_seguro= $sumador_total * $row_order->tax_insurance_value /100;

                                                $total_impuesto_aduanero= $total_peso * $row_order->tax_custom_tariffis_value;

                                                $total_envio = ($sumador_total-$total_descuento)+ $total_impuesto + $total_seguro+ $total_impuesto_aduanero;

                                                $sumador_total=number_format($sumador_total, 2,'.','');
                                                $sumador_libras=number_format($sumador_libras, 2,'.','');
                                                $sumador_volumetric=number_format($sumador_volumetric, 2,'.','');
                                                $total_envio=number_format($total_envio, 2,'.','');
                                                $total_seguro=number_format($total_seguro, 2,'.','');
                                                $total_peso=number_format($total_peso, 2,'.','');
                                                $total_impuesto_aduanero=number_format($total_impuesto_aduanero, 2,'.','');
                                                $total_impuesto=number_format($total_impuesto, 2,'.','');
                                                $total_descuento=number_format($total_descuento, 2,'.','');
                                                $count_item++;
                                                ?>


                                                <tr class="card-hover" id="row_id_<?php echo $row_order_item->order_id;?>">

                                                    <td colspan="3"><b><?php echo $row_order_item->order_prefix.$row_order_item->order_no; ?> </b></td> 

                                                    <td colspan="2" class="text-center"><?php echo $weight_item; ?></td>
                                                    <td class="text-center"></td>

                                                    <td  class="text-right"><?php echo $row_order_item->weight_vol; ?></td>

                                                   <td class="text-center">
                                                    <button type="button" name="remove_row" id="<?php echo $row_order_item->order_id; ?>" class="btn btn-danger btn-xs remove_row mt-2"><i class="fa fa-trash"></i></button>
                                                </td>


                                                <script> selected.push('<?php echo $row_order_item->order_id; ?>'); </script>

                                                <input type="hidden" id="total_vol_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->weight_vol; ?>" name="weight_vol[]">

                                                <input type="hidden" id="order_prefix_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->order_prefix; ?>" name="prefix[]">

                                                <input type="hidden" id="order_no_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->order_no; ?>" name="order_no_item[]">

                                                <input type="hidden" id="weight_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $weight_item; ?>" name="weight[]">

                                                <input type="hidden" id="length_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->length; ?>"  name="length[]">

                                                <input type="hidden" id="height_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->height; ?>" name="height[]">

                                                <input type="hidden" id="width_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->width; ?>" name="width[]">

                                                <input type="hidden" id="order_id_<?php echo $row_order_item->order_id; ?>"   value="<?php echo $row_order_item->order_id; ?>" name="order_id[]">

                                                </tr>
                                            <?php

                                            }?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="card-hover">                                   
                                            <td colspan="2"></td>                                         
                                            <td  colspan="2"></td>
                                            <td  colspan="2" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
                                            <td class="text-right" id="subtotal"><?php echo $sumador_total; ?></td>              
                                            <td ></td> 
                                            <!-- <td ></td>  -->
                                        </tr>

                                        <tr class="card-hover">                                   
                                            <td class="text-left" colspan="2"><b>Price Lb:</b> <?php echo $core->value_weight;?></td>       
                                            <td  colspan="2"></td>
                                            
                                            
                                            <td  colspan="2" class="text-right"><b>Discount <?php echo $row_order->tax_discount; ?> % </b></td>
                                            <td class="text-right"><?php echo $total_descuento; ?></td>              
                                            <td ></td> 
                                        </tr>

                                        <tr>                
                                            <td colspan="2"><b><?php echo $lang['left232'] ?>:</b> <span id="total_libras"><?php echo $sumador_libras; ?></span></td>
                                            <td  colspan="2"></td>
                                                                                                                         
                                            <td  colspan="2" class="text-right"><b>Shipping insurance <?php echo $row_order->tax_insurance_value; ?> % </b></td>
                                            <td class="text-right" id="insurance"><?php echo $total_seguro; ?></td>              
                                            <td ></td>                                             
                                        </tr>

                                        <tr>
                                            <td colspan="2"><b><?php echo $lang['left234'] ?>:</b> <span id="total_volumetrico"><?php echo $sumador_volumetric; ?></span></td>                                            
                                            <td  colspan="2"></td>
                                                                                      
                                            <td  colspan="2" class="text-right"> <b>Customs tariffs <?php echo $row_order->tax_custom_tariffis_value; ?> %</b></td>
                                            <td class="text-right" id="total_impuesto_aduanero"><?php echo $total_impuesto_aduanero; ?></td>              
                                            <td ></td>                                            

                                        </tr>

                                        <tr>                
                                            <td colspan="2"><b><?php echo $lang['left236'] ?></b>: <span id="total_peso"><?php echo $total_peso; ?></span></td>                          
                                            <td  colspan="2"></td>
                                            
                                            <td  colspan="2" class="text-right"><b>Tax <?php echo $row_order->tax_value; ?> % </b></td>
                                            <td class="text-right" id="impuesto"><?php echo $total_impuesto; ?></td> 
                                            <td ></td>                                                         
                                        </tr>   

                                        <tr>                                            
                                            <td  colspan="2"></td>
                                            <td  colspan="2"></td>
                                            
                                            <td  colspan="2" class="text-right"><b><?php echo $lang['add-title44'] ?> &nbsp; <?php echo $core->currency;?></b></td>
                                            <td class="text-right" id="total_envio"><?php echo $total_envio; ?></td>              
                                            <td ></td>                                                      

                                        </tr>
                                    </tfoot>
                                    <input type="hidden" name="total_item" id="total_item" value="<?php echo $count_item;?>" />
                                    <?php 
                                        }?>
                                    </table>
                                </div>
                           
                            <div class="col-md-12">
                                <div class="form-actions">
                                    <div class="card-body">
                                        <div class="text-right">

                                            <input type="hidden" name="subtotal_input" id="subtotal_input"/>
                                            <input type="hidden" name="impuesto_input" id="impuesto_input"/>
                                            <input type="hidden" name="discount_input" id="discount_input"/>                           
                                            <input type="hidden" name="insurance_input" id="insurance_input"/>
                                            <input type="hidden" name="total_impuesto_aduanero_input" id="total_impuesto_aduanero_input"/>
                                            <input type="hidden" name="total_envio_input" id="total_envio_input"/>
                                            <input type="hidden" name="total_weight_input" id="total_weight_input"/>

                                            <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-success" value="Update consolidated " />
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
         <?php 
        include('views/modals/modal_add_ship_consolidate.php'); 
        ?>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <script src="dataJs/consolidate_add.js"></script> 

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
    // var selected = [];

    $(document).ready(function(){
        var count = $('#total_item').val();  

       $(document).on('click', '.remove_row', function(){
            var row_id = $(this).attr("id");
             var parent=  $('#row_id_'+row_id);

            new Messi('<p class="messi-warning"><i class="icon-warning-sign icon-3x pull-left"></i>Are you sure you want to delete this record?<br /><strong>This action cannot be undone!!!</strong></p>', {
              title: 'Delete shipment',
              titleClass: '',
              modal: true,
              closeButton: true,
              buttons: [{
                  id: 0,
                  label: 'Delete',
                  class: '',
                  val: 'Y'
              }],
                callback: function (val) {
                    if (val === 'Y') {
                        $.ajax({
                          type: 'post',
                          url:'./ajax/consolidate/consolidate_item_delete_ajax.php',
                          data: {                                   
                              'id': row_id,                               
                          },
                          beforeSend: function () {
                              parent.animate({
                                  'backgroundColor': '#FFBFBF'
                              }, 400);
                          },
                            success: function (data) {                                

                                var index = selected.indexOf(row_id);

                                selected.splice(index, 1);

                                parent.animate({
                                  'backgroundColor': '#FFBFBF'
                                }, 400);         

                                count--;
                                parent.fadeOut(400, function () {
                                  // parent.remove();
                                    $('#row_id_'+row_id).remove();
                                    cal_final_total();
                                });

                                $('#total_item').val(selected.length);

                                load(1);
                            }
                        });
                    }
                }
            });          

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



          if($.trim($('#total_item').val()) <= 1)
          {
            alert("You must select at least 2 packages to consolidate");
            return false;
          }

          
          if($.trim($('#order_no').val()).length == 0)
          {
            alert("Please Select Invoice number");
            return false;
          }
          
          if($.trim($('#agency').val())== 0)
          {
            alert("Please Select Agency");
            return false;
          }
          
          if($.trim($('#order_package').val())== 0)
          {
            alert("Please Select package name");
            return false;
          }
          
          if($.trim($('#order_courier').val())== 0)
          {
            alert("Please Select courier company");
            return false;
          }
          
          if($.trim($('#order_service_options').val())== 0)
          {
            alert("Please Select services options");
            return false;
          }
          
          if($.trim($('#order_deli_time').val())== 0)
          {
            alert("Please Select time delivery");
            return false;
          }          
         
          
           if($.trim($('#order_pay_mode').val())== 0)
          {
            alert("Please Enter method payment");
            return false;
          }
          
           if($.trim($('#status_courier').val())== 0)
          {
            alert("Please Enter status courier");
            return false;
          }
          
           if($.trim($('#driver_id').val())== 0)
          {
            alert("Please Enter driver name");
            return false;
          }


         


          $('#invoice_form').submit();

        });

    });

</script>

<script type="text/javascript">
    
        function cal_final_total(){

           
            var count = $('#total_item').val();

            var sumador_total=0;
            // var sumador_valor_declarado=0;
            var sumador_libras=0;
            var sumador_volumetric=0;

            var precio_total=0;
            var total_impuesto=0;
            var total_descuento=0;
            var total_seguro=0;
            var total_peso=0;
            var total_impuesto_aduanero =0;

            
            // var tariffs_value = $('#tariffs_value').val();
            // var insurance_value = $('#insurance_value').val();
            // var tax_value = $('#tax_value').val();
            // var discount_value = $('#discount_value').val();

            console.log(selected)
           
           
          selected.forEach( function(valor, indice, array) {

            console.log("En el índice " + indice + " hay este valor: " + valor);
               

            var weight=$('#weight_'+valor).val();
            weight = parseFloat(weight);

            console.log(weight+' weight');

            var height=$('#height_'+valor).val();
            height = parseFloat(height);

            console.log(height+' height');

            var length=$('#length_'+valor).val();
            length = parseFloat(length);

            console.log(length+' length');


            var width=$('#width_'+valor).val();
            width = parseFloat(width);

            console.log(width+' width');



            var total_vol=$('#total_vol_'+valor).val();
            total_vol = parseFloat(total_vol);
           
            // calculate weight columetric box size
            var total_metric = length * width * height/ <?php echo $row_order->volumetric_percentage; ?>; 

            // calculate weight x price
            if (weight > total_metric) {

              calculate_weight = weight;
              sumador_libras+=weight;//Sumador

            } else {

              calculate_weight = total_metric;
              sumador_volumetric+=total_metric;//Sumador
            }

            precio_total=calculate_weight* <?php echo $row_order->value_weight; ?>;
            sumador_total+=precio_total;

            if(sumador_total><?php echo $core->min_cost_tax; ?>){

                total_impuesto= sumador_total * <?php echo $row_order->tax_value /100; ?>;
            }
                
            total_descuento= sumador_total * <?php echo $row_order->tax_discount /100; ?>;
            total_peso =sumador_libras + sumador_volumetric;
            total_seguro= sumador_total * <?php echo $row_order->tax_insurance_value /100; ?>;

            total_impuesto_aduanero= total_peso * <?php echo $row_order->tax_custom_tariffis_value; ?>;


         
        });
          // sumador_total= sumador_total- total_descuento;

          total_envio =(sumador_total-total_descuento) +total_seguro+total_impuesto + total_impuesto_aduanero;



           // if (total_descuento> sumador_total) {


           //      alert('Discount cannot be greater than the subtotal');
           //       $('#discount_value').val(0);

           //      return false;

           //  }else if(discount_value<0){

           //      alert('Discount cannot be less than 0');
           //       $('#discount_value').val(0);

           //      return false;

           //  }

          $('#subtotal').html(sumador_total.toFixed(2));

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


<script >
    
    function add_item(id, total_vol, weight, length, width, height, tracking, order_no, order_prefix){

           

             if(selected.includes(id)){

               $('#modal_consolidate').html(
                '<div class="alert alert-danger" id="success-alert">'+
                '<p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>'+
                  '  <span>Error! </span> This package is already selected in the list.'+
                  '</p>'+
                '</div>');

             }else{

                count++;

                $('#modal_consolidate').html('');
                console.log(selected+" antes");
                selected.push(id);

                console.log(selected+ " despues");
                $('#total_item').val(selected.length);

                // var weight=$('#weight_'+id).val();
                // var tracking=$('#tracking_'+id).val();
                // var total_vol=$('#total_vol_'+id).val();
                // var order_prefix=$('#order_prefix_'+id).val();
                // var order_no=$('#order_no_'+id).val();
                // var order_id=$('#order_id_'+id).val();

                // var length=$('#length_'+id).val();
                // var height=$('#height_'+id).val();
                // var width=$('#width_'+id).val();


                var parent=  $('#row_id_'+id);

                  var html_code = '';
                  html_code += '<tr class="card-hover " id="row_id_'+id+'">';
                  
                    html_code+='<td class="" colspan="3"> <b>'+ tracking+' </b></td>';
                    html_code+='<td class="text-center"  colspan="2">'+ weight+'</td>';
                    html_code+='<td class="text-center"></td>';
                    html_code+='<td class="text-right">'+ total_vol+'</td>';

                    html_code+='<input type="hidden"  id="total_vol_'+id+'"  value="'+total_vol+'" name="weight_vol[]">';
                    html_code+='<input type="hidden"   value="'+order_prefix+'" name="prefix[]">';
                    html_code+='<input type="hidden"   value="'+order_no+'" name="order_no_item[]">';
                    html_code+='<input type="hidden" id="weight_'+id+'"   value="'+weight+'" name="weight[]">';

                    html_code+='<input type="hidden" id="length_'+id+'"   value="'+length+'" name="length[]">';
                    html_code+='<input type="hidden" id="height_'+id+'"   value="'+height+'" name="height[]">';
                    html_code+='<input type="hidden" id="width_'+id+'"   value="'+width+'" name="width[]">';
                    html_code+='<input type="hidden" id="order_id_'+id+'"   value="'+id+'" name="order_id[]">';
                  

                    html_code += '<td class="text-center"><button type="button" name="remove_row" id="'+id+'" class="btn btn-danger btn-xs remove_row mt-2"><i class="fa fa-trash"></i></button></td>';                

                 
                    html_code += '</tr>';

                    $('#invoice-item-table').append(html_code);

                    $('#row_id_'+id).animate({
                      'backgroundColor': '#18BC9C'
                    }, 400); 

                    cal_final_total();

                    $('#add_row').attr("disabled", true);

                 
                     setTimeout(function(){

                    $('#row_id_'+id).css({'background-color':''});
                    $('#add_row').attr("disabled", false);

                  }, 900);

             

               
             }




         
        }
        
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

        var sender_id =$( "#sender_id" ).val();

        

            $( "#sender_address_id").attr("disabled", true);

             $( "#recipient_id").attr("disabled", true);

             $( "#recipient_address_id").attr("disabled", true);
             $( "#add_address_sender").attr("disabled", true);
             $( "#add_recipient").attr("disabled", true);

             $( "#add_address_recipient").attr("disabled", true);


             $( "#recipient_id" ).val(null);
             $( "#sender_address_id" ).val(null);
             $( "#recipient_address_id" ).val(null);

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





function select2_init_recipient(){

    var sender_id =$( "#sender_id" ).val();


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
         $( "#recipient_address_id").val(null);

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