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

// if (!$user->is_Admin())
//    redirect_to("login.php");

$userData = $user->getUserData();

if (isset($_GET['id'])) {
    $data = getCourierPrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount'] != 1) {
    redirect_to("courier_list.php");
}

if (isset($_GET['id_notification'])) {
    # code...

    $user_log = $_SESSION['userid'];
    $id_notification = $_GET['id_notification'];

    updateNotificationRead($user_log, $id_notification);
}




$row_order = $data['data'];
$db->query("SELECT * FROM styles where id= '" . $row_order->status_courier . "'");
$status_courier = $db->registro();

$db->query("SELECT * FROM users where id= '" . $row_order->sender_id . "'");
$sender_data = $db->registro();



$db->query("SELECT * FROM users where id= '" . $row_order->receiver_id . "'");
$receiver_data = $db->registro();


$db->query("SELECT * FROM address_shipments where order_track='" . $row_order->order_prefix . $row_order->order_no . "'");
$address_order = $db->registro();


$db->query("SELECT * FROM courier_com where id= '" . $row_order->order_courier . "'");
$courier_com = $db->registro();

$db->query("SELECT * FROM met_payment where id= '" . $row_order->order_pay_mode . "'");
$met_payment = $db->registro();

$db->query("SELECT * FROM shipping_mode where id= '" . $row_order->order_service_options . "'");
$order_service_options = $db->registro();

$db->query("SELECT * FROM packaging where id= '" . $row_order->order_package . "'");
$packaging = $db->registro();


$db->query("SELECT * FROM delivery_time where id= '" . $row_order->order_deli_time . "'");
$delivery_time = $db->registro();

$db->query("SELECT * FROM branchoffices where id= '" . $row_order->agency . "'");
$branchoffices = $db->registro();

$db->query("SELECT * FROM offices where id= '" . $row_order->origin_off . "'");
$offices = $db->registro();


$db->query("SELECT * FROM add_order_item WHERE order_id='" . $_GET['id'] . "'");
$order_items = $db->registros();


$dias_ = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$meses_ = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');

// echo $dias_[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;


// $fecha=date("Y-m-d", strtotime($row_order->order_datetime));


$fecha = strtotime($row_order->order_datetime);
$anio = date("Y", $fecha);
$mes = date("m", $fecha);
$dia = date("d", $fecha);

if ($row_order->status_invoice == 1) {

    $text_status = $lang['invoice_paid'];
    $label_class = "label-success";
} else if ($row_order->status_invoice == 2) {

    $text_status = $lang['invoice_pending'];
    $label_class = "label-warning";
} else if ($row_order->status_invoice == 3) {
    $text_status = $lang['verify_payment'];
    $label_class = "label-info";
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
    <title> View Shipment #<?php echo $row_order->order_prefix . $row_order->order_no; ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/css/style.min.css" rel="stylesheet">

    <link href="assets/css_log/front.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.js"></script>
    <script src="assets/js/jquery.wysiwyg.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/custom.js"></script>
    <link href="assets/customClassPagination.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <link rel="stylesheet" href="assets/bootstrap-datetimepicker.min.css">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/jquery-ui.css" type="text/css" />

    <style type="text/css">
        .scrollable-menu {
            height: auto;
            max-height: 300px;
            overflow-x: hidden;
        }
    </style>
    <!--  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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


        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">



            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style=" padding-bottom: 40px">
                            <div class="card-body">

                                <div class="mb-3" id="resultados_ajax_cancel"></div>
                                <div class="mb-3" id="resultados_ajax"></div>


                                <div class="row">


                                    <div class="col-md-6">
                                        <h3 class=" pull-left"><b class="text-danger">INVOICE</b> <span>#<?php echo $row_order->order_prefix . $row_order->order_no; ?></span></h3>

                                    </div>

                                    <?php if ($row_order->status_courier != 14) { ?>

                                        <div class="col-md-6  pull-right">
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" data-flip="false">
                                                    Invoice Actions
                                                </button>
                                                <div class="dropdown-menu scrollable-menu">

                                                    <?php if ($row_order->status_invoice == 2) { ?>
                                                        <?php if ($userData->userlevel == 1) { ?>

                                                            <a class="dropdown-item" href="add_payment_gateways_courier.php?id_order=<?php echo $row_order->order_id; ?>">
                                                                <i style="color:#343a40" class="fas fa-dollar-sign"></i>&nbsp;Add invoice payment</a>



                                                        <?php } ?>
                                                    <?php } ?>


                                                    <?php if ($row_order->status_invoice == 3) { ?>
                                                        <?php if ($userData->userlevel != 1) { ?>


                                                            <a class="dropdown-item" data-toggle="modal" data-target="#detail_payment_packages" data-id="<?php echo $row_order->order_id; ?>" data-customer="<?php echo $row_order->sender_id; ?>"><i style="color:#343a40" class="fas fa-dollar-sign"></i>&nbsp; Verify payment</a>


                                                        <?php } ?>

                                                    <?php } ?>


                                                    <?php if ($row_order->order_incomplete == 0) { ?>
                                                        <?php if ($row_order->is_pickup == 0) { ?>

                                                            <?php if ($userData->userlevel != 1) { ?>

                                                                <a class="dropdown-item" href="courier_accept.php?id=<?php echo $row_order->order_id; ?>" title="<?php echo $lang['tooledit'] ?>"><i style="color:#343a40" class="ti-pencil"></i>&nbsp; Complete shipment</a>
                                                            <?php } ?>

                                                            <a class="dropdown-item" href="print_label_ship.php?id=<?php echo $row_order->order_id; ?>" target="_blank"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toollabel'] ?> </a>
                                                        <?php } ?>
                                                    <?php } ?>


                                                    <?php if ($row_order->order_incomplete == 1) { ?>

                                                        <?php if ($row_order->is_consolidate == 0) { ?>

                                                            <?php if ($row_order->status_courier != 8) { ?>

                                                                <?php if ($userData->userlevel == 9 || $userData->userlevel == 2) { ?>

                                                                    <a class="dropdown-item" href="courier_edit.php?id=<?php echo $_GET['id']; ?>" title="<?php echo $lang['tooledit'] ?>"><i style="color:#343a40" class="ti-pencil"></i>&nbsp;<?php echo $lang['tooledit'] ?></a>

                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>


                                                        <?php if ($userData->userlevel == 9 || $userData->userlevel == 2) { ?>

                                                            <?php if ($row_order->status_courier != 21 || $row_order->status_courier != 12) { ?>

                                                                <?php if ($row_order->status_invoice != 1) { ?>


                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#charges_list" data-id="<?php echo $row_order->order_id; ?>"><i style="color:#343a40" class="fas fa-dollar-sign"></i>&nbsp;Charges</a>


                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>


                                                        <?php if ($userData->userlevel == 9 || $userData->userlevel == 3 || $userData->userlevel == 2) { ?>

                                                            <?php if ($row_order->status_courier != 8) { ?>
                                                                <?php if ($row_order->status_courier != 21) { ?>
                                                                    <?php if ($row_order->status_courier != 12) { ?>

                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#modalDriver" data-id_shipment="<?php echo $row_order->order_id; ?>"><i style="color:#ff0000" class="fas fa-car"></i>&nbsp; <?php echo $lang['left208'] ?></a>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>



                                                        <?php if ($row_order->status_courier != 21) { ?>
                                                            <?php if ($row_order->status_courier != 12) { ?>



                                                                <a class="dropdown-item" target="blank" href="print_inv_ship.php?id=<?php echo $_GET['id']; ?>"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toolprint'] ?></a>

                                                                <a class="dropdown-item" href="print_label_ship.php?id=<?php echo $_GET['id']; ?>" target="_blank"> <i style="color:#343a40" class="ti-printer"></i>&nbsp;<?php echo $lang['toollabel'] ?> </a>


                                                                <?php if ($userData->userlevel == 9 || $userData->userlevel == 3 || $userData->userlevel == 2) { ?>

                                                                    <?php if ($row_order->is_consolidate == 0) { ?>

                                                                        <?php if ($row_order->status_courier != 8) { ?>
                                                                            <?php if ($row_order->status_courier != 21) { ?>
                                                                                <?php if ($row_order->status_courier != 12) { ?>


                                                                                    <a class="dropdown-item" href="courier_shipment_tracking.php?id=<?php echo $_GET['id']; ?>" title="<?php echo $lang['toolupdate'] ?>"><i style="color:#20c997" class="ti-reload">&nbsp;</i><?php echo $lang['toolupdate'] ?></a>

                                                                                    <a class="dropdown-item" href="courier_deliver_shipment.php?id=<?php echo $row_order->order_id; ?>" title="<?php echo $lang['tooldeliver'] ?>"><i style="color:#2962FF" class="ti-package"></i>&nbsp;<?php echo $lang['tooldeliver'] ?></a>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>


                                                                <?php if ($userData->userlevel == 9 || $userData->userlevel == 3 || $userData->userlevel == 2) { ?>

                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-id="<?php echo $row_order->order_id; ?>" data-email="<?php echo $sender_data->email; ?>" data-order="<?php echo $row_order->order_prefix . $row_order->order_no; ?>" data-target="#myModal"><i class="fas fa-envelope"></i>&nbsp;Send email</a>

                                                                <?php } ?>

                                                            <?php } ?>

                                                        <?php } ?>

                                                    <?php } ?>

                                                </div>
                                            </div>

                                        </div>
                                    <?php } else { ?>

                                        <div class="col-md-6  pull-right">
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Invoice Actions
                                                </button>
                                                <div class="dropdown-menu">


                                                    <?php if ($userData->userlevel == 9 || $userData->userlevel == 3 || $userData->userlevel == 2) { ?>




                                                        <?php if ($row_order->status_courier == 14) { ?>

                                                            <a class="dropdown-item" href="pickup_accept.php?id=<?php echo $row_order->order_id; ?>"> <i style="color:#36bea6" class="fas fa-check-circle"></i>&nbsp;Acecpt pickup</a>

                                                        <?php
                                                        }
                                                        ?>

                                                        <a class="dropdown-item" data-id="<?php echo $row_order->order_id; ?>" href="#" data-toggle="modal" data-target="#myModalCancel"><i style="color:#f62d51" class="fas fa-times-circle"></i>&nbsp;Cancel pickup</a>

                                                    <?php
                                                    }
                                                    ?>



                                                </div>
                                            </div>

                                        </div>

                                    <?php

                                    } ?>

                                </div>

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class=" col-md-4 pull-left">
                                            <b class="">Package status</b>
                                            <span class="label" style="background-color: <?php echo $status_courier->color; ?>"><?php echo $status_courier->mod_style; ?>
                                            </span>
                                        </div>

                                        <div class=" col-md-4 pull-left">
                                            <b class="">Invoice Status</b>
                                            <span class="label <?php echo $label_class; ?>"><?php echo $text_status; ?>
                                            </span>
                                        </div>

                                        <!-- <br>
                                        <br>

                                        <h6> &nbsp;<b>Order date</b></h6>
                                        <p class="text-muted  m-l-5">E 104, Dharti-2</p>    -->

                                    </div>


                                </div>
                                <br>


                                <!-- <hr> -->
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Agency</b></h5>
                                            <p class="text-muted  m-l-5"><?php if ($branchoffices != null) {
                                                                                echo $branchoffices->name_branch;
                                                                            } ?></p>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Office</b></h5>
                                            <p class="text-muted  m-l-5"><?php if ($offices != null) {
                                                                                echo $offices->name_off;
                                                                            } ?></p>
                                        </div>

                                    </div>

                                </div>


                                <!-- <hr> -->
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Estimated delivery date </b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $meses_[$mes] . ' ' . $dia . ', ' . $anio; ?></p>

                                            <h5> &nbsp;<b>Delivery time</b></h5>
                                            <p class="text-muted  m-l-5"><?php if ($delivery_time != null) {
                                                                                echo $delivery_time->delitime;
                                                                            } ?></p>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Packing type</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $packaging->name_pack; ?></p>

                                            <h5> &nbsp;<b>Payment method</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo  $met_payment->met_payment; ?></p>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Courier company</b></h5>
                                            <p class="text-muted  m-l-5"><?php if ($courier_com != null) {
                                                                                echo $courier_com->name_com;
                                                                            } ?></p>

                                            <h5> &nbsp;<b>Shipping mode</b></h5>
                                            <p class="text-muted  m-l-5"><?php if ($order_service_options != null) {
                                                                                echo $order_service_options->ship_mode;
                                                                            } ?></p>
                                        </div>

                                    </div>

                                    <?php if ($row_order->status_courier == 21) { ?>
                                        <?php if ($row_order->reason_cancel != null) { ?>

                                            <div class="col-md-12 pt-4">
                                                <div class="pull-left">
                                                    <h5> &nbsp;<b>Reason for cancellation</b></h5>
                                                    <b class="text-danger  m-l-5"><?php if ($row_order->reason_cancel != null) {
                                                                                        echo $row_order->reason_cancel;
                                                                                    } ?></b>


                                                </div>

                                            </div>

                                    <?php

                                        }
                                    }

                                    ?>


                                </div>

                                <?php
                                $track_c = $row_order->order_prefix . $row_order->order_no;


                                $db->query("SELECT * FROM payments_gateway  where order_track ='" . $track_c . "'");

                                $order_ = $db->registro();

                                if ($order_) {

                                    if ($order_->status === 'COMPLETED' || $order_->status === 'succeeded' || $order_->status === 'success') {
                                        $text_status_payment = 'Completed';
                                        $label_class_payment = "label-success";
                                    } else {

                                        $text_status_payment = $order_->status;
                                        $label_class_payment = "label-warning";
                                    }




                                ?>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <br>
                                            <br>

                                            <h4 class=" pull-left"><span><b>Payment details</b></span></h4>
                                            <br>
                                            <br>
                                        </div>



                                        <div class="col-md-4">

                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Payment date</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo date('Y-m-d h:i A', strtotime($order_->date_payment)); ?></p>
                                            </div>

                                        </div>



                                        <div class="col-md-4">

                                            <div class="pull-left">

                                                <h5> &nbsp;<b>Gateway</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo $order_->gateway; ?></p>
                                            </div>

                                        </div>




                                        <div class="col-md-4">

                                            <div class="pull-left">
                                                <h5> &nbsp;<b># Transaction </b></h5>
                                                <b class="text-muted  m-l-5"><?php echo $order_->payment_transaction; ?></b>


                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Amount </b></h5>
                                                <b class="text-muted  m-l-5"><?php echo $order_->amount; ?></b>


                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Currency </b></h5>
                                                <b class="text-muted  m-l-5"><?php echo $order_->currency; ?></b>


                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Status </b></h5>

                                                <span class="label <?php echo $label_class_payment; ?>"><?php echo $text_status_payment; ?>
                                                </span>


                                            </div>

                                        </div>
                                    </div>

                                <?php

                                }

                                ?>




                                <?php

                                if ($row_order->url_payment_attach != null || $row_order->status_invoice == 3) { ?>



                                    <div class="row">

                                        <div class="col-md-12">
                                            <br>
                                            <br>

                                            <h5 class=" pull-left"><span>Attached proof of payment</span></h5>



                                        </div>

                                        <div class="col-md-12">
                                            <a href="assets/<?php echo $row_order->url_payment_attach; ?>" target="blank" class="btn btn-info text- btn-sm">
                                                see attached file
                                            </a>
                                        </div>


                                        <div class="col-md-4">
                                            <br>
                                            <br>
                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Payment date</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo date('Y-m-d h:i A', strtotime($row_order->payment_date)); ?></p>
                                            </div>

                                        </div>



                                        <div class="col-md-4">
                                            <br>
                                            <br>
                                            <div class="pull-left">

                                                <h5> &nbsp;<b>Payment method</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo $met_payment->met_payment; ?></p>
                                            </div>

                                        </div>




                                        <div class="col-md-4">
                                            <br>
                                            <br>

                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Notes</b></h5>
                                                <b class="text-muted  m-l-5"><?php if ($row_order->notes != null) {
                                                                                    echo $row_order->notes;
                                                                                } ?></b>


                                            </div>

                                        </div>
                                    </div>

                                <?php

                                }
                                ?>





                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <?php
                if ($row_order->status_courier == 8) {


                    $db->query("SELECT * FROM courier_track where order_track='" . $row_order->order_prefix . $row_order->order_no . "' and status_courier=8");
                    $courier_track = $db->registro();

                    $fecha_delivered = strtotime($courier_track->t_date);
                    $anio_delivered = date("Y", $fecha_delivered);
                    $mes_delivered = date("m", $fecha_delivered);
                    $dia_delivered = date("d", $fecha_delivered);
                    $time_delivered = date("h:i A", $fecha_delivered);

                    $db->query("SELECT * FROM users where id='" . $courier_track->user_id . "'");
                    $user_delivered = $db->registro();

                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">shipping delivered</h5>
                                    <hr>



                                    <!-- <hr> -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Delivered date</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo $meses_[$mes_delivered] . ' ' . $dia_delivered . ', ' . $anio_delivered . ' ' . $time_delivered; ?></p>

                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Delivered By</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo $user_delivered->fname . ' ' . $user_delivered->lname; ?></p>

                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="pull-left">
                                                <h5> &nbsp;<b>Received By</b></h5>
                                                <p class="text-muted  m-l-5"><?php echo $row_order->person_receives; ?></p>
                                            </div>

                                        </div>

                                    </div>



                                    <?php
                                    $dir = 'doc_signs/' . $row_order->order_id . '.png';

                                    ?>


                                    <div class="row">

                                        <?php
                                        // if (file_exists($dir)) {
                                        ?>

                                        <div class="col-md-6">
                                            <h5> &nbsp;<b>Receiver Signature</b></h5>

                                            <img src="doc_signs/<?php echo $row_order->order_id; ?>.png" width="400" height="250">
                                        </div>
                                        <?php
                                        // }

                                        if (!empty($row_order->photo_delivered)) { ?>

                                            <div class="col-md-6">
                                                <h5> &nbsp;<b>Photo delivered</b></h5>

                                                <img src="<?php echo $row_order->photo_delivered; ?>" width="400" height="250">
                                            </div>
                                        <?php
                                        } ?>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-map-marker"></i> Input Location</h5>
                                <hr>

                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped">
                                        <thead class="bg-inverse text-white">
                                            <tr>

                                                <th>From >></th>
                                                <th>To >></th>
                                                <th>Action >></th>
                                            </tr>
                                        </thead>
                                        <tbody id="projects-tbl">


                                            <?php
                                            $testing = "";

                                            if (isset($_POST['submit'])) {
                                                $testing = "Button Working";
                                            }
                                            ?>
                                            <tr class="card-hover">
                                                <?php echo $testing; ?>

                                                <form action="" method="POST">

                                                    <div class="input-group-prepend">
                                                        <td><input type="text" value="<?php echo $address_order->froom; ?>" placeholder="Current Location"></td>
                                                    </div>

                                                    <div class="input-group-prepend">
                                                        <td><input type="text" value="<?php echo $address_order->too; ?>" placeholder="Destination"></td>
                                                    </div>

                                                    <div class="input-group-prepend">
                                                        <td><button type="submit" class="btn btn-primary">Update</button></td>
                                                    </div>

                                                </form>

                                            </tr>



                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php

                $db->query("SELECT * FROM order_files where order_id='" . $_GET['id'] . "' ORDER BY date_file");
                $files_order = $db->registros();
                $numrows = $db->rowCount();


                if ($numrows > 0) {
                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-paperclip"></i> Attached files</h5>
                                    <hr>

                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped">
                                            <thead class="bg-inverse text-white">
                                                <tr>
                                                    <th>Nº</th>
                                                    <th>File</th>
                                                    <th>Added</th>
                                                </tr>
                                            </thead>
                                            <tbody id="projects-tbl">

                                                <?php
                                                $count = 0;
                                                foreach ($files_order as $file) {

                                                    $date_add = date("Y-m-d h:i A", strtotime($file->date_file));



                                                    $count++;
                                                ?>

                                                    <tr class="card-hover">
                                                        <td><?php echo $count; ?></td>
                                                        <td> <a style="color:#7460ee;" target="_blank" href="<?php echo $file->url; ?>" class=""><?php echo $file->name; ?> </a></td>
                                                        <td><?php echo $date_add; ?></td>

                                                    </tr>
                                                <?php
                                                } ?>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } ?>


                <?php

                $db->query("SELECT * FROM courier_track where order_track='" . $row_order->order_prefix . $row_order->order_no . "' ORDER BY t_date");
                $courier_track_items = $db->registros();
                $numrows = $db->rowCount();


                if ($numrows > 0) {
                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="icon-direction"></i> <?php echo $lang['left502'] ?></h5>
                                    <hr>

                                    <div class="table-responsive">
                                        <table id="zero_config" class="table table-striped">
                                            <thead class="bg-inverse text-white">
                                                <tr>
                                                    <th><?php echo $lang['left503'] ?></th>
                                                    <th><?php echo $lang['left504'] ?></th>
                                                    <th><?php echo $lang['left505'] ?></th>
                                                    <th><?php echo $lang['left506'] ?></th>
                                                    <th><?php echo $lang['left507'] ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="projects-tbl">

                                                <?php
                                                foreach ($courier_track_items as $track_item) {

                                                    $date_update = date("Y-m-d", strtotime($track_item->t_date));
                                                    $time_update = date("h:i A", strtotime($track_item->t_date));

                                                    $db->query("SELECT * FROM styles where id= '" . $track_item->status_courier . "'");
                                                    $status_courier_item = $db->registro();





                                                ?>

                                                    <tr class="card-hover">
                                                        <td><?php echo $date_update; ?></td>
                                                        <td><?php echo $time_update; ?></td>
                                                        <td><?php echo $track_item->t_dest; ?> /<br>
                                                            <?php echo $track_item->t_city; ?></td>
                                                        <td>
                                                            <span class="label" style="background-color: <?php echo $status_courier_item->color; ?>"><?php echo $status_courier_item->mod_style; ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo $track_item->comments; ?></td>

                                                    </tr>
                                                <?php
                                                } ?>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } ?>





                <?php
                if ($user->is_Admin()) {

                    $db->query("SELECT * FROM order_user_history where order_id='" . $_GET['id'] . "' ORDER BY history_id");
                    $order_user_history = $db->registros();
                    $numrows = $db->rowCount();


                    if ($numrows > 0) {
                ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="icon-direction"></i> History of user actions</h5>
                                        <hr>

                                        <div class="table-responsive">
                                            <table id="zero_config" class="table table-striped">
                                                <thead class="bg-inverse text-white">
                                                    <tr>
                                                        <th><?php echo $lang['left503'] ?></th>
                                                        <th><?php echo $lang['left504'] ?></th>
                                                        <th>User</th>
                                                        <th>Role</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="projects-tbl">

                                                    <?php
                                                    foreach ($order_user_history as $track_item) {

                                                        $date_update = date("Y-m-d", strtotime($track_item->date_history));
                                                        $time_update = date("h:i A", strtotime($track_item->date_history));


                                                        $db->query("SELECT * FROM users where id= '" . $track_item->user_id . "'");
                                                        $sender_data2 = $db->registro();


                                                        $role = '';

                                                        switch ($sender_data2->userlevel) {
                                                            case '1':
                                                                $role = 'Client';
                                                                break;

                                                            case '2':

                                                                $role = 'Employee';

                                                                break;

                                                            case '3':

                                                                $role = 'Driver';

                                                                break;

                                                            case '9':

                                                                $role = 'System Administration';

                                                                break;

                                                            default:
                                                                # code...
                                                                break;
                                                        }




                                                    ?>

                                                        <tr class="card-hover">
                                                            <td><?php echo $date_update; ?></td>
                                                            <td><?php echo $time_update; ?></td>
                                                            <td><?php echo $sender_data2->fname . ' ' . $sender_data2->lname; ?></td>
                                                            <td><?php echo $role; ?></td>
                                                            <td><?php echo $track_item->action; ?></td>

                                                        </tr>
                                                    <?php
                                                    } ?>


                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } ?>









                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Payment & Items Details</h5>
                                <hr>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="tabla">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                <th><b><?php echo $lang['left214'] ?></b></th>
                                                <th><b><?php echo $lang['left213'] ?></b></th>
                                                <th><b>Category</b></th>
                                                <th><b><?php echo $lang['left215'] ?></b></th>
                                                <th><b><?php echo $lang['left216'] ?></b></th>
                                                <th><b><?php echo $lang['left217'] ?></b></th>
                                                <th><b><?php echo $lang['left218'] ?></b></th>
                                                <th><b>Weight vol. (lb)</b></th>
                                                <th><b>Declared value</b></th>

                                            </tr>
                                        </thead>
                                        <tbody id="projects-tbl">
                                            <?php
                                            if ($order_items) {

                                                $sumador_total = 0;
                                                $sumador_valor_declarado = 0;
                                                $sumador_libras = 0;
                                                $sumador_volumetric = 0;
                                                $precio_total = 0;
                                                $total_impuesto = 0;
                                                $total_seguro = 0;
                                                $total_peso = 0;
                                                $total_descuento = 0;
                                                $total_impuesto_aduanero = 0;
                                                $count_item = 0;

                                                $total_valor_declarado = 0;

                                                foreach ($order_items as $row_order_item) {

                                                    $db->query("SELECT * FROM category where id= '" . $row_order_item->order_item_category . "'");
                                                    $category = $db->registro();


                                                    $description_item = $row_order_item->order_item_description;
                                                    $category_item = $category->name_item;
                                                    $weight_item = $row_order_item->order_item_weight;

                                                    $total_metric = $row_order_item->order_item_length * $row_order_item->order_item_width * $row_order_item->order_item_height / $row_order->volumetric_percentage;

                                                    // calculate weight x price
                                                    if ($weight_item > $total_metric) {

                                                        $calculate_weight = $weight_item;
                                                        $sumador_libras += $weight_item; //Sumador

                                                    } else {

                                                        $calculate_weight = $total_metric;
                                                        $sumador_volumetric += $total_metric; //Sumador
                                                    }

                                                    $precio_total = $calculate_weight * $row_order->value_weight;
                                                    $precio_total = number_format($precio_total, 2, '.', ''); //Precio total formateado

                                                    $sumador_total += $precio_total;
                                                    $sumador_valor_declarado += $row_order_item->order_item_declared_value;

                                                    if ($sumador_total > $core->min_cost_tax) {

                                                        $total_impuesto = $sumador_total * $row_order->tax_value / 100;
                                                    }

                                                    if ($sumador_valor_declarado > $core->min_cost_declared_tax) {

                                                        $total_valor_declarado = $sumador_valor_declarado * $row_order->declared_value / 100;
                                                    }

                                                    $total_descuento = $sumador_total * $row_order->tax_discount / 100;
                                                    $total_peso = $sumador_libras + $sumador_volumetric;

                                                    $total_seguro = $sumador_total * $row_order->tax_insurance_value / 100;

                                                    $total_impuesto_aduanero = $total_peso * $row_order->tax_custom_tariffis_value;

                                                    $total_envio = ($sumador_total - $total_descuento) + $total_impuesto + $total_seguro + $total_impuesto_aduanero + $total_valor_declarado + $row_order->total_reexp;

                                                    $sumador_total = number_format($sumador_total, 2, '.', '');
                                                    $sumador_libras = number_format($sumador_libras, 2, '.', '');
                                                    $sumador_volumetric = number_format($sumador_volumetric, 2, '.', '');
                                                    $total_envio = number_format($total_envio, 2, '.', '');
                                                    $total_seguro = number_format($total_seguro, 2, '.', '');
                                                    $total_peso = number_format($total_peso, 2, '.', '');
                                                    $total_impuesto_aduanero = number_format($total_impuesto_aduanero, 2, '.', '');
                                                    $total_impuesto = number_format($total_impuesto, 2, '.', '');
                                                    $total_descuento = number_format($total_descuento, 2, '.', '');
                                                    $sumador_valor_declarado = number_format($sumador_valor_declarado, 2, '.', '');
                                                    $total_valor_declarado = number_format($total_valor_declarado, 2, '.', '');



                                            ?>

                                                    <tr class="card-hover">
                                                        <td><?php echo $row_order_item->order_item_quantity; ?></td>
                                                        <td><?php echo $description_item; ?></td>
                                                        <td><?php echo $category_item; ?></td>
                                                        <td><?php echo $weight_item; ?></td>
                                                        <td><?php echo $row_order_item->order_item_length; ?></td>
                                                        <td><?php echo $row_order_item->order_item_width; ?></td>
                                                        <td><?php echo $row_order_item->order_item_height; ?></td>
                                                        <td><?php echo $total_metric; ?></td>
                                                        <td class="text-center"><?php echo $row_order_item->order_item_declared_value; ?></td>

                                                    </tr>
                                                <?php

                                                }


                                                ?>
                                        </tbody>

                                        <?php if ($row_order->order_incomplete == 1) { ?>
                                            <tfoot>
                                                <tr class="card-hover">
                                                    <td colspan="3"></td>

                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="2" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
                                                    <td class="text-center"><?php echo $sumador_total; ?></td>
                                                    <td></td>
                                                </tr>

                                                <tr class="card-hover">
                                                    <td colspan="3"><b>Price Lb:</b> <?php echo $row_order->value_weight; ?></td>

                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="2" class="text-right"><b>Discount <?php echo $row_order->tax_discount; ?> % </b></td>
                                                    <td class="text-center"><?php echo $total_descuento; ?></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3"><b><?php echo $lang['left232'] ?>:</b> <span id="total_libras"><?php echo $sumador_libras; ?></span></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="3" class="text-right"><b>Shipping insurance <?php echo $row_order->tax_insurance_value; ?> % </b></td>
                                                    <td class="text-center" id="insurance"><?php echo $total_seguro; ?></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3"><b><?php echo $lang['left234'] ?>:</b> <span id="total_volumetrico"><?php echo $sumador_volumetric; ?></span></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="3" class="text-right"> <b>Customs tariffs <?php echo $row_order->tax_custom_tariffis_value; ?> %</b></td>
                                                    <td class="text-center" id="total_impuesto_aduanero"><?php echo $total_impuesto_aduanero; ?></td>
                                                    <td></td>

                                                </tr>

                                                <tr>
                                                    <td colspan="3"><b><?php echo $lang['left236'] ?></b>: <span id="total_peso"><?php echo $total_peso; ?></span></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="2" class="text-right"><b>Tax <?php echo $row_order->tax_value; ?> % </b></td>
                                                    <td class="text-center" id="impuesto"><?php echo $total_impuesto; ?></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3"><b>Total declared value:</b> <span><?php echo $sumador_valor_declarado; ?></span></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="2" class="text-right"><b>Declared tax <?php echo $row_order->declared_value; ?> % </b></td>
                                                    <td class="text-center" id="impuesto"><?php echo $total_valor_declarado; ?></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="2" class="text-right"><b>Re expedition </b></td>
                                                    <td class="text-center" id="reexp"><?php echo $row_order->total_reexp; ?></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td colspan="3" class="text-right"><b><?php echo $lang['add-title44'] ?> &nbsp; <?php echo $core->currency; ?></b></td>
                                                    <td class="text-center" id="total_envio"><?php echo $total_envio; ?></td>
                                                    <td></td>

                                                </tr>
                                            </tfoot>
                                        <?php
                                                } ?> <?php
                                                    } ?>
                                    </table>
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
                                <h5 class="card-title">Sender Details</h5>
                                <hr>



                                <!-- <hr> -->
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Name</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $sender_data->fname . ' ' . $sender_data->lname; ?></p>


                                        </div>

                                    </div>


                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Email</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $sender_data->email; ?></p>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Phone</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $sender_data->phone; ?></p>


                                        </div>

                                    </div>



                                </div>


                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Address</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $address_order->sender_address; ?></p>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Country</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $address_order->sender_country; ?></p>


                                        </div>

                                    </div>


                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>City</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $address_order->sender_city; ?></p>


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
                                <h5 class="card-title">Receiver Details</h5>
                                <hr>



                                <!-- <hr> -->
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Name</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $receiver_data->fname . ' ' . $receiver_data->lname; ?></p>


                                        </div>

                                    </div>


                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Email</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $receiver_data->email; ?></p>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Phone</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $receiver_data->phone; ?></p>


                                        </div>

                                    </div>



                                </div>


                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Address</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $address_order->recipient_address; ?></p>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>Country</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $address_order->recipient_country; ?></p>


                                        </div>

                                    </div>


                                    <div class="col-md-4">
                                        <div class="pull-left">
                                            <h5> &nbsp;<b>City</b></h5>
                                            <p class="text-muted  m-l-5"><?php echo $address_order->recipient_city; ?></p>


                                        </div>

                                    </div>


                                </div>



                            </div>
                        </div>



                    </div>
                </div>
                <!-- Row -->


            </div>
            <?php include('views/modals/modal_send_email.php'); ?>
            <?php include('views/modals/modal_update_driver.php'); ?>
            <?php include('views/modals/modal_verify_payment_packages.php'); ?>


        </div>
        <footer class="footer text-center">
            &copy <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot'] ?>
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <?php include('views/modals/modal_cancel_pickup.php'); ?>

    <?php include('views/modals/modal_charges_list.php'); ?>
    <?php include('views/modals/modal_charges_add.php'); ?>
    <?php include('views/modals/modal_charges_edit.php'); ?>

    <script>
        $("#cancel_pickup_form").submit(function(event) {

            $('#guardar_datos').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "ajax/pickup/pickup_cancel_ajax.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html("load...");
                },
                success: function(datos) {
                    $("#resultados_ajax_cancel").html(datos);

                    setTimeout('document.location.reload()', 5000);

                    $('#guardar_datos').attr("disabled", false);

                    $('#myModalCancel').modal('hide');
                    load(1);

                }
            });
            event.preventDefault();

        })
    </script>


    <script>
        $('#myModalCancel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            var id = button.data('id') // Extract info from data-* attributes

            var modal = $(this)
            $('#id_cancel').val(id)
        })
    </script>


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.js"></script>
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




    <script>
        $("#driver_update").submit(function(event) {
            var parametros = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "ajax/courier/courier_update_driver_ajax.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                },
                success: function(datos) {
                    $("#resultados_ajax").html(datos);

                    $('html, body').animate({
                        scrollTop: 0
                    }, 600);

                    $('#modalDriver').modal('hide');

                    load(1);


                }
            });
            event.preventDefault();

        })
    </script>

    <script>
        $('#modalDriver').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_shipment = button.data('id_shipment') // Extract info from data-* attributes
            var id_sender = button.data('id_sender') // Extract info from data-* attributes
            var modal = $(this)
            $('#id_shipment').val(id_shipment)
            $('#id_senderclient_driver_update').val(id_sender)
        })
    </script>



    <script>
        $("#send_email").submit(function(event) {

            $('#guardar_datos').attr("disabled", true);

            var parametros = $(this).serialize();

            $.ajax({
                type: "GET",
                url: "send_email_pdf.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $(".resultados_ajax_mail").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");

                },
                success: function(datos) {
                    $(".resultados_ajax_mail").html(datos);
                    $('#guardar_datos').attr("disabled", false);

                }
            });
            event.preventDefault();

        })
    </script>

    <script>
        $('#myModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var order = button.data('order') // Extract info from data-* attributes
            var id = button.data('id') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var modal = $(this)
            $('#subject').val("Invoice # " + order)
            $('#id').val(id)
            $('#sendto').val(email)
        })
    </script>

    <script>
        $('#charges_list').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            $('#order_id').val(id);

            $(".resultados_ajax_charges_add_results").html('');

            load_charges(order_id); //Cargas los pagos 

        })

        function load_charges() {

            var id = $('#order_id').val();
            var parametros = {
                "id": id
            };
            $.ajax({

                url: 'ajax/accounts_receivable/charges_list_ajax.php',
                data: parametros,
                success: function(data) {
                    $(".resultados_ajax_charges_list").html(data).fadeIn('slow');
                }
            });
        }


        $('#charges_add').on('show.bs.modal', function(event) {

            var id = $('#order_id').val();
            var parametros = {
                "id": id
            };

            $.ajax({
                url: 'ajax/accounts_receivable/modal_add_charges.php',
                data: parametros,
                success: function(data) {
                    $(".resultados_ajax_add_modal").html(data).fadeIn('slow');
                }
            });
        })





        $("#add_charges").submit(function(event) {
            var parametros = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "ajax/accounts_receivable/add_charges_ajax.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $(".resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                },
                success: function(datos) {
                    $(".resultados_ajax_charges_add_results").html(datos);

                    $('#charges_add').modal('hide');
                    load_charges();
                    load(1);


                }
            });
            event.preventDefault();

        })



        $('#charges_edit').on('show.bs.modal', function(event) {

            var id = $('#order_id').val();

            var button = $(event.relatedTarget) // Button that triggered the modal
            var id_charge = button.data('id_charge')

            var parametros = {
                "id": id,
                'id_charge': id_charge
            };

            $.ajax({
                url: 'ajax/accounts_receivable/modal_edit_charges.php',
                data: parametros,
                success: function(data) {
                    $(".resultados_ajax_add_modal_edit").html(data).fadeIn('slow');
                }
            });
        })


        $("#edit_charges").submit(function(event) {
            var parametros = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "ajax/accounts_receivable/update_charges_ajax.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $(".resultados_ajax_charges_add_results").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                },
                success: function(datos) {
                    $(".resultados_ajax_charges_add_results").html(datos);

                    $('#charges_edit').modal('hide');
                    load_charges();
                    load(1);


                }
            });
            event.preventDefault();

        })



        //Eliminar
        function delete_charge(id) {

            // $('body').on('click',id, function () {
            // var id = $(this).attr('id').replace('item_', '')
            var parent = $('#item_' + id).parent().parent();
            var name = $(this).attr('data-rel');
            new Messi('<p class="messi-warning"><i class="icon-warning-sign icon-3x pull-left"></i>Are you sure you want to delete this record?<br /><strong>This action cannot be undone!!!</strong></p>', {
                title: 'Delete charge',
                titleClass: '',
                modal: true,
                closeButton: true,
                buttons: [{
                    id: 0,
                    label: 'Delete',
                    class: '',
                    val: 'Y'
                }],
                callback: function(val) {
                    if (val === 'Y') {
                        $.ajax({
                            type: 'post',
                            url: './ajax/accounts_receivable/charge_delete_ajax.php',
                            data: {
                                'id': id,
                            },
                            beforeSend: function() {
                                parent.animate({
                                    'backgroundColor': '#FFBFBF'
                                }, 400);
                            },
                            success: function(data) {
                                // parent.fadeOut(400, function () {
                                //     parent.remove();
                                // });
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 600);
                                $('.resultados_ajax_charges_add_results').html(data);
                                // console.log(data);
                                load_charges();

                                load(1);
                            }
                        });
                    }
                }

                // });
            });
        }
    </script>












    <script>
        function validateZiseFiles() {

            var inputFile = document.getElementById('filesMultiple');
            var file = inputFile.files;

            var size = 0;
            console.log(file);

            for (var i = 0; i < file.length; i++) {

                var filesSize = file[i].size;

                if (size > 5242880) {

                    $('.resultados_file').html("<div class='alert alert-danger'>" +
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
                        "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>" +

                        "</div>"
                    );
                } else {
                    $('.resultados_file').html("");
                }

                size += filesSize;
            }

            if (size > 5242880) {
                $('.resultados_file').html("<div class='alert alert-danger'>" +
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
                    "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>" +

                    "</div>"
                );

                return true;

            } else {
                $('.resultados_file').html("");

                return false;
            }

        }
    </script>

    <script>
        $('#openMultiFile').click(function() {

            $("#filesMultiple").click();
        });


        $('#clean_file_button').click(function() {

            $("#filesMultiple").val('');

            $('#selectItem').html('Attach files');

            $('#clean_files').addClass('hide');


        });



        $('input[type=file]').change(function() {

            var inputFile = document.getElementById('filesMultiple');
            var file = inputFile.files;
            var contador = 0;
            for (var i = 0; i < file.length; i++) {

                contador++;
            }
            if (contador > 0) {

                $('#clean_files').removeClass('hide');
            } else {

                $('#clean_files').addClass('hide');

            }

            $('#selectItem').html('attached files (' + contador + ')');
        });
    </script>



    <script>
        $('#detail_payment_packages').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            var customer = button.data('customer') // Extract info from data-* attributes

            $('#order_id_confirm_payment').val(id);
            $('#customer_id_confirm_payment').val(customer);

            $(".resultados_ajax_payment_data").html('');

            load_payment_detail(id); //Cargas los pagos 

        })

        function load_payment_detail(id) {

            var parametros = {
                "id": id
            };
            $.ajax({

                url: 'ajax/courier/courier_payment_detail_ajax.php',
                data: parametros,
                success: function(data) {
                    $(".resultados_ajax_payment_data").html(data).fadeIn('slow');
                }
            });
        }






        $("#send_payment").submit(function(event) {

            $('#save_payment').attr("disabled", true);

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "ajax/courier/courier_confirm_payment.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html("load...");
                },
                success: function(datos) {

                    $('#detail_payment_packages').modal('hide');

                    $("#resultados_ajax").html(datos);
                    $('#save_payment').attr("disabled", false);

                    setTimeout('document.location.reload()', 3000);


                    load(1);

                }
            });
            event.preventDefault();

        })
    </script>


</body>

</html>