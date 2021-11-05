<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Track Shipment | <?php echo $core->site_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Courier DEPRIXA-Integral Web System">
    <meta name="author" content="Jaomweb">
    <meta name="description" content="">
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <!-- Bootstrap -->
    <link href="assets/theme_deprixa/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="assets/theme_deprixa/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="assets/theme_deprixa/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/theme_deprixa/css/owl.theme.css" />
    <link rel="stylesheet" href="assets/theme_deprixa/css/owl.transitions.css" />
    <!-- Main css -->
    <link href="assets/theme_deprixa/css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div>
    <!-- Loader -->

    <!-- Navbar STart -->
    <header id="topnav" class="defaultscroll sticky">
        <div class="container">
            <!-- Logo container-->
            <div>
                <a class="logo" class="logo" href="../../"><?php echo ($core->logo) ? '<img src="assets/' . $core->logo . '" alt="' . $core->site_name . '" width="150" />' : $core->site_name; ?></a>
            </div>
            <div class="buy-button">
                <a href="sign-up.php" class="btn btn-light-outline rounded"><i class="mdi mdi-account-alert ml-3 icons"></i> <?php echo $lang['left124'] ?></a>
            </div>
            <!--end login button-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li><a href="../../"><?php echo $lang['left125'] ?></a></li>

                    <li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left126'] ?></a></li>
                </ul>
            </div>
        </div>
    </header>
    <!-- Navbar End -->

    <!-- Hero Start -->
    <section class="bg-home">
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-6">
                            <div class="mr-lg-5">
                                <img src="assets/theme_deprixa/images/user/track.svg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <div class="login-page bg-white shadow rounded p-4">
                                <div class="text-center">
                                    <h4 class="mb-4"><span><?php echo $lang['left127'] ?> </span> <br> <?php echo $lang['left128'] ?><span class="text-primary">.</span></h4>
                                </div>
                                <form class="login-form" method="POST" name="ib_form" id="ib_form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group position-relative">

                                                <label><?php echo $lang['left129'] ?> <?php echo $core->site_name ?><span class="text-primary">.</span></label>
                                                <br>

                                                <div class="col-md-12">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="trackingType" id="trackingType" value="1" checked>
                                                        <label class="form-check-label" for="trackingType">Shipments</label>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group position-relative">

                                                <i class="mdi mdi-cube-send ml-3 icons"></i>
                                                <textarea name="order_track" placeholder="<?php echo $lang['left130'] ?>" id="order_track" rows="4" class="form-control pl-5" required></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" name="submit" class="btn btn-primary rounded w-100"><i class="mdi mdi-cube-outline ml-3 icons"></i> <?php echo $lang['left131'] ?></button>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                </form>
                            </div>
                            <!---->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end container-->
            </div>
        </div>
    </section>
    <!--end section-->
    <!-- Hero End -->

    <!-- Back to top -->
    <a href="#" class="back-to-top rounded text-center" id="back-to-top">
        <i class="mdi mdi-chevron-up d-block"> </i>
    </a>
    <!-- Back to top -->

    <script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=light&autoMode=true" type="text/javascript"></script>


    <!-- javascript -->
    <script src="assets/theme_deprixa/js/jquery.min.js"></script>
    <script src="assets/theme_deprixa/js/bootstrap.bundle.min.js"></script>
    <script src="assets/theme_deprixa/js/jquery.easing.min.js"></script>
    <script src="assets/theme_deprixa/js/scrollspy.min.js"></script>
    <!-- SLIDER -->
    <script src="assets/theme_deprixa/js/owl.carousel.min.js"></script>
    <script src="assets/theme_deprixa/js/owl.init.js"></script>
    <!-- Main Js -->
    <script src="assets/theme_deprixa/js/app.js"></script>


    <script>
        $("#ib_form").submit(function(event) {

            var order_track = $('#order_track').val();

            var trackingType = $('input:radio[name=trackingType]:checked').val();

            if (trackingType == 1) {

                window.location = 'track.php?order_track=' + order_track;
            } else {
                window.location = 'track_online_shopping.php?order_track=' + order_track;

            }

            event.preventDefault();



        });
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/61850fd76885f60a50ba7519/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>