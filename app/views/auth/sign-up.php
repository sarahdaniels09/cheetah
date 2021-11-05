<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $lang['langs_010112'] ?> | <?php echo $core->site_name; ?></title>
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
                <a class="logo" href="../../../"><?php echo ($core->logo) ? '<img src="assets/' . $core->logo . '" alt="' . $core->site_name . '" width="150" />' : $core->site_name; ?></a>
            </div>

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
                    <li><a href="../../../"><?php echo $lang['left134'] ?></a></li>

                    <li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left135'] ?></a></li>
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
                        <div class="col-lg-7 col-md-5">
                            <div class="mr-lg-6">
                                <img src="assets/theme_deprixa/images/user/signup.png" class="img-fluid" alt="">
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-7 mt-4 mt-sm-5 pt-2 pt-sm-3">
                            <?php if (!$core->reg_allowed) : ?>

                                <div class="alert alert-warning" id="success-alert">
                                    <p><span class="icon-exclamation-sign"></span><i class="close icon-remove-circle"></i>

                                        <?php echo $lang['langs_010133']; ?>
                                    </p>
                                </div>

                                <?php
                                // elseif($core->user_limit !=0 and $core->user_limit == $numusers):
                                ?>

                                <!--   <div class="alert alert-warning" id="success-alert">
                                        <p><span class="icon-exclamation-sign"></span><i class="close icon-remove-circle"></i>
                                            
                                               <?php echo $lang['langs_010134']; ?>
                                        </p>
                                    </div> -->
                            <?php else : ?>
                                <div class="login_page bg-white shadow rounded p-4">
                                    <div class="text-center">
                                        <h4 class="mb-4"><?php echo $lang['left136'] ?></h4>
                                        <p><?php echo $lang['left137'] ?></p>
                                    </div>
                                    <div id="resultados_ajax"></div>
                                    <!-- <div id="loader" style="display:none"></div> -->
                                    <br><br>
                                    <form class="login-form" id="new_register" name="new_register" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left138'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left139'] ?>" name="fname" id="fname">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left140'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left141'] ?>" name="lname" id="lname">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left142'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-mail-ru ml-3 icons"></i>
                                                    <input type="email" class="form-control pl-5" placeholder="<?php echo $lang['left143'] ?>" name="email" id="email">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['user_manage12'] ?> <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage12'] ?>" name="country" id="country" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['user_manage13'] ?> <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage13'] ?>" name="city" id="city" required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['user_manage14'] ?> <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage14'] ?>" name="postal" id="postal" required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['user_manage10'] ?> <span class="text-danger">*</span></label>

                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage10'] ?>" name="address" id="address" required>
                                                </div>
                                            </div>



                                            <div class="col-md-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left144'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left145'] ?>" name="username" id="username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left146'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-key ml-3 icons"></i>
                                                    <input type="password" class="form-control pl-5" placeholder="<?php echo $lang['left147'] ?>" name="pass" id="pass">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left148'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-key ml-3 icons"></i>
                                                    <input type="password" class="form-control pl-5" name="pass2" id="pass2" placeholder="<?php echo $lang['left149'] ?>">
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="terms" name="terms" value="yes">
                                                        <label class="custom-control-label" for="terms"><?php echo $lang['left164'] ?> <a href="#" class="text-primary"> <?php echo $lang['left165'] ?></a></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-primary rounded w-100" name="dosubmit"><?php echo $lang['left166'] ?></button>
                                                <input name="locker" type="hidden" id="locker" value="<?php echo generarCodigo(6); ?>" />

                                            </div>
                                            <div class="col-lg-12 mt-4 text-center">

                                            </div>
                                            <div class="mx-auto">
                                                <p class="mb-0 mt-3"><small class="text-dark mr-2"><?php echo $lang['left167'] ?> </small> <a href="index.php" class="text-dark font-weight-bold"><?php echo $lang['left168'] ?></a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            <?php endif; ?>
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
    <script src="assets/theme_deprixa/js/bootstrap.bundle.min.js"></script>
    <script src="assets/theme_deprixa/js/jquery.easing.min.js"></script>
    <script src="assets/theme_deprixa/js/scrollspy.min.js"></script>
    <!-- SLIDER -->
    <script src="assets/theme_deprixa/js/owl.carousel.min.js"></script>
    <script src="assets/theme_deprixa/js/owl.init.js"></script>
    <!-- Main Js -->
    <script src="assets/theme_deprixa/js/app.js"></script>


    <script>
        $("#new_register").submit(function(event) {

            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "./ajax/sign_up_ajax.php",
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

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6184414c6885f60a50ba5dbb/1fjm9u5n5';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>