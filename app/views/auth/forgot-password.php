<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $lang['langs_010106'] ?> | <?php echo $core->site_name; ?></title>
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

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.js"></script>
    <script src="assets/js/jquery.wysiwyg.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/checkbox.js"></script>

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
                <a class="logo" href="../../../"><?php echo ($core->logo) ? '<img src="assets/' . $core->logo . '" alt="' . $core->site_name . '"  width="150" />' : $core->site_name; ?></a>
            </div>
            <div class="buy-button">
                <a href="sign-up.php" class="btn btn-light-outline rounded"><i class="mdi mdi-account-alert ml-3 icons"></i> <?php echo $lang['left169'] ?></a>
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
                    <li><a href="../../../"><?php echo $lang['left170'] ?></a></li>

                    <li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left171'] ?></a></li>
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
                                <img src="assets/theme_deprixa/images/user/recovery.png" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <div class="login_page bg-white shadow rounded p-4">
                                <div class="text-center">
                                    <h4 class="mb-4"><?php echo $lang['left172'] ?></h4>
                                </div>

                                <div id="resultados_ajax"></div>
                                <div id="loader" style="display:none"></div>
                                <div id="msgholder2">
                                    <?php
                                    // print Filter::$showMsg;
                                    ?>

                                </div>

                                <form class="login-form" name="forgotPassword" id="forgotPassword" method="post">
                                    <div class="row">
                                        <!--  <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left173'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left174'] ?>" id="uname" name="uname" required="">
                                                </div>
                                            </div> -->
                                        <div class="col-lg-12">
                                            <div class="form-group position-relative">
                                                <label><?php echo $lang['left175'] ?> <span class="text-danger">*</span></label>
                                                <i class="mdi mdi-mail-ru ml-3 icons"></i>
                                                <input type="email" class="form-control pl-5" placeholder="<?php echo $lang['left176'] ?>" id="email" name="email" required="">
                                            </div>
                                        </div>


                                        <div class="col-lg-12">
                                            <button type="submit" name="dosubmit" class="btn btn-primary rounded w-100"><?php echo $lang['langs_010108'] ?></button>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                // echo Core::doForm("passReset","ajax/user.php");
                                ?>
                                <br><br>
                                <p>
                                    <?php echo $lang['langs_010109'] ?> </br><?php if ($core->reg_allowed) : ?><a href="sign-up.php" class="text-primary"><?php echo $lang['langs_010110'] ?></a><?php endif; ?> | <a href="index.php" class="text-primary"><?php echo $lang['langs_010111'] ?></a>
                                </p>
                            </div>
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



    <!-- javascript -->
    <script src="assets/theme_deprixa/js/bootstrap.bundle.min.js"></script>
    <script src="assets/theme_deprixa/js/jquery.easing.min.js"></script>
    <script src="assets/theme_deprixa/js/scrollspy.min.js"></script>
    <!-- SLIDER -->
    <script src="assets/theme_deprixa/js/owl.carousel.min.js"></script>
    <script src="assets/theme_deprixa/js/owl.init.js"></script>
    <!-- Main Js -->
    <script src="assets/theme_deprixa/js/app.js"></script>



    <script>
        $("#forgotPassword").submit(function(event) {

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "./ajax/forgot-password-ajax.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
                },
                success: function(datos) {
                    $("#resultados_ajax").html(datos);

                    $("html, body").animate({
                        scrollTop: 0
                    }, 600);

                }
            });
            event.preventDefault();

        });
    </script>
</body>

</html>