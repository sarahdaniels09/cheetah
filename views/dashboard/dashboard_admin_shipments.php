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
        <title>Dashboard shipments | <?php echo $core->site_name ?></title>

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

    <script src="assets/libs/chart.js-2.8/Chart.min.js"></script>

    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>

    <style type="text/css">
        .alert{
            margin-top:20px;
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
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Sales summary</h4>
                                    <h5 class="card-subtitle">Overview of Latest Month</h5>

                                    </div>
                                   
                                </div>


                                <div class="row">
                                    <!-- column -->
                                    <div class="col-lg-4 col-md-12">
                                        <div class="">
                                    <!-- col -->
                                    <div class="col-md-4 col-lg-12">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a href="courier_list.php"><span class="text-orange display-5"><i class="mdi mdi-package-variant-closed"></i></span></a></div>
                                            <div><span>shipments</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php 
                                                    $month = date('m');
                                                    $year = date('Y');

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE month(order_date)='$month' AND year(order_date)='$year'and  is_pickup=0");

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
                                    <div class="col-md-4 col-lg-12">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a href="courier_list.php"><span class="text-cyan display-5"><i class="mdi mdi-star-circlemdi mdi-clock-fast"></i></span></a></div>
                                            <div><span> Shipments pick up</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php 
                                                    $month = date('m');
                                                    $year = date('Y');

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE month(order_date)='$month' AND year(order_date)='$year' and  is_pickup=1");

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
                                    <div class="col-md-4 col-lg-12">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a href="courier_list.php"><span class="text-danger display-5"><i class="mdi mdi-gift"></i></span></a></div>
                                            <div><span>Shipments consolidated</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php 

                                                    $month = date('m');
                                                    $year = date('Y');

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE month(order_date)='$month' AND year(order_date)='$year'and  is_consolidate=1");

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
                                    <div class="col-md-4 col-lg-12">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a href="courier_list.php"><span class="text-success display-5"><i class="mdi mdi-package-down"></i></span></a></div>
                                            <div><span>Shipments Delivered</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php 
                                                        $month = date('m');
                                                        $year = date('Y');

                                                    $db->query("SELECT COUNT(*) as total FROM add_order WHERE month(order_date)='$month' AND year(order_date)='$year'and is_pickup=0  and  status_courier=8");

                                                    $db->execute();

                                                    $count = $db->registro();

                                                    echo $count->total;
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-lg-12">
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><span class="text-info display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                                            <div><span>Current month's income</span>
                                                <h3 class="font-medium m-b-0">
                                                    <?php 
                                                        $month = date('m');
                                                        $year = date('Y');                                                       

                                                    $db->query("SELECT IFNULL(SUM(total_order), 0) as total FROM add_order WHERE status_courier!=21 and is_pickup=0 and month(order_date)='$month' AND year(order_date)='$year'");

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
                                    <!-- column -->
                                   
                                    <div class="col-lg-8 col-md-12">
                                    <div class="card-body">
                                        <canvas  id="myChart"                                         
                                         style="height: 320px;" >
                                        </canvas>
                                    </div>
                                </div>
                                    <!-- column -->
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- Info Box -->
                            <!-- ============================================================== -->
                            <div class="card-body border-top">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Shipments list</h4>
                                        <h5 class="card-subtitle">Overview of Latest Month</h5>
                                    </div>
                                    
                                </div>
                                <div class="outer_div">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
      
            </div>
        </div>
    </div>
















<script>

$(document).ready(function() {

    $.ajax({
        url:'./ajax/dashboard/shipments/load_graphics_shipments_ajax.php',
        type: "POST",
        dataType: "json",
        success: function(data) {

            console.log(data);

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr','May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Shipments',
                        backgroundColor: '#7460ee',
                        borderColor: '#7460ee',
                        data:data

                    }]
                },

                // Configuration options go here
                options: {

                  title: {
                    display: true,
                    // text: 'Chart.js Bar Chart - Stacked'
                  },

                  tooltips: {
                    mode: 'index',
                    intersect: false
                  },

                  responsive: true,      

                }
            })

        },
      error: function(data) {

      },
    });

    load(1);

});


//Cargar datos AJAX
function load(page){
    
    var parametros = {"page":page};
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/dashboard/shipments/load_shipments_ajax.php',
        data: parametros,
         beforeSend: function(objeto){
        // $("#loader").html("<img src='./img/ajax-loader.gif'>");
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            // $("#loader").html("");
        }
    })
}


   
</script>
		
       
 <?php include 'views/inc/footer.php'; ?>
          