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

                <!-- ============================================================== -->
                <!-- Earnings, Sale Locations -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->


                    <div class="col-sm-12 col-md-5 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-body border-bottom">
                                    <h5 class="card-title"><?php echo $lang['dashnew01'] ?></h5>
                                    <!-- <h5 class="card-subtitle">Indicadores de usuarios</h5> -->
                                </div>

                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <div class="m-r-10"><a href="users_list.php"><span class="display-5"><i class="mdi mdi-account-settings-variant" style="color: #36bea6;"></i></span></a></div>
                                        <div>
                                            <span class="text-muted"><?php echo $lang['dashnew02'] ?></span>
                                            <h3 class="font-medium m-b-0">
                                                <?php

                                                $db->query('SELECT COUNT(*) as total FROM users WHERE userlevel=9');

                                                $db->execute();

                                                $count = $db->registro();

                                                echo $count->total;
                                                ?>
                                            </h3>
                                        </div>

                                    </div>
                                </div>

                                <!-- <div class="col-md-6 col-sm-12 col-lg-6">
                                       Employee
                                    </div> -->


                                <!-- <div class="col-md-6 col-sm-12 col-lg-6">
                                        <div class="d-flex align-items-center">
                                            Driver
                                        </div>
                                    </div> -->

                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <div class="m-r-10"><a href="customers_list.php"><span class="display-5"><i class="mdi mdi-account-check" style="color: #1f95ff;"></i></span></a></div>
                                        <div><span class="text-muted"><?php echo $lang['dashnew05'] ?></span>
                                            <h3 class="font-medium m-b-0">
                                                <?php

                                                $db->query('SELECT COUNT(*) as total FROM users WHERE userlevel=1');

                                                $db->execute();

                                                $count = $db->registro();

                                                echo $count->total;
                                                ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <!-- col -->

                            </div>
                        </div>
                    </div>


                    <!-- column -->
                    <div class="col-sm-12 col-md-7 col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- column -->
                                    <div class="col-sm-12 col-md-6 col-lg-8">
                                        <div class="card-body border-bottom">
                                            <h5 class="card-title"><?php echo $lang['dashnew06'] ?></h5>
                                            <!-- <h5 class="card-subtitle"></h5> -->
                                        </div>

                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a href="courier_list.php"><span class="text-orange display-5"><i class="mdi mdi-package-variant-closed"></i></span></a></div>
                                                    <div><span><?php echo $lang['dashnew07'] ?></span>
                                                        <h3 class="font-medium m-b-0">
                                                            <?php

                                                            $db->query('SELECT COUNT(*) as total FROM add_order WHERE is_pickup=0');

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
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a href="pickup_list.php"><span class="text-cyan display-5"><i class="mdi mdi-star-circlemdi mdi-clock-fast"></i></span> </a></div>
                                                    <div><span><?php echo $lang['dashnew08'] ?></span>
                                                        <h3 class="font-medium m-b-0">
                                                            <?php

                                                            $db->query('SELECT COUNT(*) as total FROM add_order WHERE is_pickup=1');

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
                                            <!-- <div class="col-lg-6 col-md-6">
                                                <div class="d-flex align-items-center">
                                                   consolidate
                                                </div>
                                            </div> -->
                                            <!-- col -->
                                            <!-- col -->
                                            <!-- <div class="col-lg-6 col-md-6">
                                                <div class="d-flex align-items-center">
                                                   account Recievable
                                                </div>
                                            </div> -->
                                            <!-- col -->

                                            <!-- col -->
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a href="prealert_list.php"><span class="text-warning display-5"><i class="mdi mdi-clock-alert"></i></span></a></div>
                                                    <div><span><?php echo $lang['dashnew11'] ?></span>
                                                        <h3 class="font-medium m-b-0">
                                                            <?php

                                                            $db->query('SELECT COUNT(*) as total FROM pre_alert');

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
                                            <div class="col-lg-6 col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a href="customer_packages_list.php"><span class="text-success display-5"><i class="fas fa-cube"></i></span></a></div>
                                                    <div><span><?php echo $lang['dashnew12'] ?></span>
                                                        <h3 class="font-medium m-b-0">
                                                            <?php

                                                            $db->query('SELECT COUNT(*) as total FROM customers_packages');

                                                            $db->execute();

                                                            $count = $db->registro();

                                                            echo $count->total;
                                                            ?>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col -->

                                            <!--  <div class="col-md-6 col-sm-12 col-lg-6">
                                                <div class="d-flex align-items-center">
                                                    Total Packages
                                                </div>
                                            </div> -->

                                            <!--  <div class="col-md-6 col-sm-12 col-lg-6">
                                                        <div class="d-flex align-items-center">
                                                            Accounts Recievable
                                                    </div>

                                        </div> -->





                                        </div>
                                        <!-- column -->

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>






                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-shipment" role="tab" aria-controls="pills-shipment" aria-selected="true"><?php echo $lang['dashnew19'] ?></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" href="pickup_list.php"><?php echo $lang['dashnew20'] ?></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" href="consolidate_list.php"><?php echo $lang['dashnew21'] ?></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" href="prealert_list.php"><?php echo $lang['dashnew22'] ?></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" href="customer_packages_list.php"><?php echo $lang['dashnew23'] ?></a>
                                        </li>


                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-shipment" role="tabpanel" aria-labelledby="pills-home-tab">

                                            <div class="col-md-4 mt-4 mb-4">
                                                <div class="input-group">
                                                    <input type="text" name="search_shipment" id="search_shipment" class="form-control input-sm float-right" placeholder="search tracking" onkeyup="load(1);">
                                                    <div class="input-group-append input-sm">
                                                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="results_shipments"></div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-pickup" role="tabpanel" aria-labelledby="pills-profile-tab">

                                            <div class="col-md-4 mt-4 mb-4">
                                                <div class="input-group">
                                                    <input type="text" name="search_pickup" id="search_pickup" class="form-control input-sm float-right" placeholder="search tracking" onkeyup="load(1);">
                                                    <div class="input-group-append input-sm">
                                                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="results_pickup"></div>

                                        </div>
                                        <div class="tab-pane fade" id="pills-consolidated" role="tabpanel" aria-labelledby="pills-contact-tab">
                                            <div class="col-md-4 mt-4 mb-4">
                                                <div class="input-group">
                                                    <input type="text" name="search_consolidated" id="search_consolidated" class="form-control input-sm float-right" placeholder="search tracking" onkeyup="load(1);">
                                                    <div class="input-group-append input-sm">
                                                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="results_consolidated"></div>
                                        </div>
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


            var search = $('#search_shipment').val();
            var parametros = {
                "page": page,
                "search": search
            };
            $("#loader").fadeIn('slow');
            $.ajax({
                url: './ajax/dashboard/shipments/load_shipments_ajax.php',
                data: parametros,
                beforeSend: function(objeto) {
                    // $("#loader").html("<img src='./img/ajax-loader.gif'>");
                },
                success: function(data) {
                    $(".results_shipments").html(data).fadeIn('slow');
                    // $("#loader").html("");
                }
            })
        }



        // //Cargar datos AJAX
        // function loadPickup(page){

        //     var search= $('#search_pickup').val();
        //     var parametros = {"page":page, "search":search};
        //     $.ajax({
        //         url:'./ajax/dashboard/pickup/load_pickup_ajax.php',
        //         data: parametros,
        //          beforeSend: function(objeto){
        //         // $("#loader").html("<img src='./img/ajax-loader.gif'>");
        //       },
        //         success:function(data){
        //             $(".results_pickup").html(data).fadeIn('slow');
        //             // $("#loader").html("");
        //         }
        //     })
        // }


        // function loadConsolidated(page){

        //     var search= $('#search_consolidated').val();
        //     var parametros = {"page":page, "search":search};
        //     $("#loader").fadeIn('slow');
        //     $.ajax({
        //         url:'./ajax/dashboard/consolidated/load_consolidated_ajax.php',
        //         data: parametros,
        //          beforeSend: function(objeto){
        //         // $("#loader").html("<img src='./img/ajax-loader.gif'>");
        //       },
        //         success:function(data){
        //             $(".results_consolidated").html(data).fadeIn('slow');
        //             // $("#loader").html("");
        //         }
        //     })
        // }
    </script>

    <?php include 'views/inc/footer.php'; ?>