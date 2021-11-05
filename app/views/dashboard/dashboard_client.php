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

$db = new Conexion;


$sql = "SELECT * FROM add_order where status_courier!=21 and order_payment_method >1  and sender_id='" . $_SESSION['userid'] . "' ";



$db->query($sql);
$data = $db->registros();




$count = 0;
$sumador_pendiente = 0;
$sumador_total = 0;
$sumador_pagado = 0;

foreach ($data as $row) {



    $db->query('SELECT  IFNULL(sum(total), 0)  as total  FROM charges_order WHERE order_id=:order_id');

    $db->bind(':order_id', $row->order_id);

    $db->execute();

    $sum_payment = $db->registro();
    // var_dump($sum_payment->total);

    $pendiente = $row->total_order - $sum_payment->total;

    $sumador_pendiente += $pendiente;
    $sumador_total += $row->total_order;
    $sumador_pagado += $sum_payment->total;


    $count++;
}


?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
    <meta name="author" content="Jaomweb">
    <title>Dashboard | <?php echo $core->site_name ?></title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <title></title>
    <!-- Custom CSS -->

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

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <style type="text/css">
        .alert {
            margin-top: 20px;
        }

        * {
            box-sizing: border-box;
        }
    </style>

</head>

<body>

    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/preloader.php'; ?>

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/topbar.php'; ?>

        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <?php include 'views/inc/left_sidebar.php'; ?>


        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->

        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm-12 col-lg-8">
                        <!--  <div class="card">
                            <div class="card-body">
                              -->
                        <!-- <h4 class="card-title">Sales summary</h4> -->

                        <!-- <div class="row m-b-0 m-t-20 text-center"> -->

                        <!--  <div class="col-sm-12 col-md-4 m-b-10">
                                        <span>Total shipments</span>
                                        <h3 class="m-b-0">
                                            <?php

                                            $db->query("SELECT IFNULL(SUM(total_order),0) as total FROM add_order where is_pickup=0 and sender_id='" . $_SESSION['userid'] . "'");

                                            $db->execute();

                                            $count = $db->registro();

                                            echo number_format($count->total, 2, '.', '');

                                            ?>
                                        </h3>
                                    </div>
                                    <div class="col-sm-12 col-md-4 m-b-10">
                                        <span>Total Pick up</span>
                                        <h3 class="m-b-0">
                                            <?php

                                            $db->query("SELECT IFNULL(SUM(total_order),0) as total FROM add_order where is_pickup=1 and sender_id='" . $_SESSION['userid'] . "'");

                                            $db->execute();

                                            $count = $db->registro();

                                            echo number_format($count->total, 2, '.', '');

                                            ?>
                                        </h3>
                                    </div>
                                    <div class="col-sm-12 col-md-4 m-b-10">
                                        <span>Total conslidated</span>
                                        <h3 class="m-b-0">
                                            <?php

                                            $db->query("SELECT IFNULL(SUM(total_order),0) as total FROM consolidate where sender_id='" . $_SESSION['userid'] . "'");

                                            $db->execute();

                                            $count = $db->registro();

                                            echo number_format($count->total, 2, '.', '');

                                            ?>
                                        </h3>
                                    </div>
 -->

                        <!-- </div>                                -->

                        <!--     </div>
                        </div>
                         -->

                        <div class="card">


                            <div class="card-body border-bottom">
                                <h4 class="card-title">Shipments summary</h4>


                            </div>
                            <div class="card-body">
                                <div class="row m-t-10">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a href="prealert_list.php"><span class="text-warning display-5"><i class="mdi mdi-clock-alert"></i></span></a></div>
                                            <div><span>Pre Alerts</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php

                                                    $db->query("SELECT COUNT(*) as total FROM pre_alert where customer_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a href="customer_packages_list.php"><span class="text-primary display-5"><i class="fas fa-cube"></i></span></a></div>
                                            <div><span>Packages Registered</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php

                                                    $db->query("SELECT COUNT(*) as total FROM customers_packages where sender_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- col -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-orange display-5">

                                                    <a href="courier_list.php" class="text-orange display-5"> <i class="mdi mdi-package-variant-closed"></i> </a></span></div>
                                            <div><span>shipments</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE is_pickup=0 and sender_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-success display-5">
                                                    <a href="courier_list.php" class="text-success display-5"> <i class="mdi mdi-package-down"></i> </a></span></div>
                                            <div><span>Shipments Delivered</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE status_courier=8 and sender_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- col -->
                                    <!-- col -->


                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-body border-bottom">
                                <h4 class="card-title">Pickup summary</h4>


                            </div>
                            <div class="card-body">
                                <div class="row m-t-10">




                                    <div class="col-md-4 col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-cyan display-5">
                                                    <a href="pickup_list.php" class="text-cyan display-5"> <i class="mdi mdi-star-circlemdi mdi-clock-fast"></i></a></span></div>
                                            <div><span> Pickup</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE is_pickup=1 and sender_id='" . $_SESSION['userid'] . "' ");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>

                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <!-- col -->
                                    <div class="col-md-4 col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-orange display-5">
                                                    <a href="pickup_list.php" class="text-orange display-5"> <i class="mdi mdi-backspace"></i> </a></span></div>
                                            <div><span>Pickup rejected</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php


                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE is_pickup=1 and status_courier=12 and sender_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-danger display-5">
                                                    <a href="pickup_list.php" class="text-danger display-5"><i class="mdi mdi-close-circle"></i> </a></span></div>
                                            <div><span>Pickup cancelled</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php



                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE is_pickup=1 and status_courier=21 and sender_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-success display-5">
                                                    <a href="pickup_list.php" class="text-success display-5"> <i class="mdi mdi-package-down"></i> </a></span></div>
                                            <div><span>Pickup Delivered</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php



                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE status_courier=8 and  is_pickup=1 and sender_id='" . $_SESSION['userid'] . "'");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>



                    </div>


                    <div class="col-sm-12 col-md-7 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Accounts receivable summary</h4>

                                <div class="row">

                                    <!-- column -->
                                    <div class="col-sm-12 col-md-12 col-lg-12">


                                        <ul class="list-style-none">

                                            <li class="m-t-30">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted">Total Accounts receivable</span>
                                                        <h4 class="m-b-0">
                                                            <span class="font-16">
                                                                <?php echo $core->currency; ?> <?php

                                                                                                echo number_format($sumador_total, 2, '.', '');
                                                                                                ?>
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="progress m-t-10">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $count->total / 100; ?>%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </li>

                                            <li class="m-t-30">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted">Total accounts paid</span>
                                                        <h4 class="m-b-0">
                                                            <span class="font-16">


                                                                <?php echo $core->currency; ?> <?php
                                                                                                echo number_format($sumador_pagado, 2, '.', '');
                                                                                                ?>
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="progress m-t-10">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $count->total / 100; ?>%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </li>
                                            <li class="m-t-30 m-b-40">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted">Total pending accounts</span>
                                                        <h4 class="m-b-0">
                                                            <span class="font-16">

                                                                <?php echo $core->currency; ?> <?php


                                                                                                echo number_format($sumador_pendiente, 2, '.', '');

                                                                                                ?>
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="progress m-t-10">
                                                    <div class="progress-bar bg-orange" role="progressbar" style="width: <?php echo $count->total / 100; ?>%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </li>

                                            <li class="m-t-30">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted">Total pending packages registered</span>
                                                        <h4 class="m-b-0">
                                                            <span class="font-16">


                                                                <?php echo $core->currency; ?> <?php


                                                                                                $db->query("SELECT IFNULL(SUM(total_order),0) as total FROM customers_packages where status_invoice=2 and sender_id='" . $_SESSION['userid'] . "'");

                                                                                                $db->execute();

                                                                                                $count = $db->registro();

                                                                                                echo number_format($count->total, 2, '.', '');
                                                                                                ?>
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="progress m-t-10">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $count->total / 100; ?>%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Virtual address for online shopping</h4>

                                <div class="row">

                                    <!-- column -->
                                    <div class="col-sm-12 col-md-12 col-lg-12">

                                        <ul class="list-style-none">

                                            <li class="m-t-30 m-b-40">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-danger"><?php echo $core->locker_address; ?> </span>

                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
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
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Shipments list</h4>
                                        <input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['userid']; ?>">
                                    </div>

                                </div>
                                <div class="outer_div">

                                </div>
                            </div>
                        </div>


                    </div>
                </div>



            </div>



        </div>
    </div>
    </div>



    <script>
        $(document).ready(function() {
            load(1);
        });


        //Cargar datos AJAX
        function load(page) {

            var parametros = {
                "page": page
            };
            $("#loader").fadeIn('slow');
            var user = $('#userid').val();
            $.ajax({
                url: './ajax/dashboard/shipments/load_shipments_ajax.php',
                data: parametros,
                beforeSend: function(objeto) {
                    // $("#loader").html("<img src='./img/ajax-loader.gif'>");
                },
                success: function(data) {
                    $(".outer_div").html(data).fadeIn('slow');
                    // $("#loader").html("");
                }
            })
        }
    </script>


    <?php include 'views/inc/footer.php'; ?>