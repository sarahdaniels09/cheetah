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



require_once 'helpers/license_lb_helper.php'; // Include LicenseBox external/client api helper file
$api = new LicenseBoxExternalAPI(); // Initialize a new LicenseBoxExternalAPI object
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Verify Purchase - Deprixa Pro</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css" />
    <style type="text/css">
    body, html {
    background: #F8F8F8;
    }
    </style>
  </head>
  <body>
    <div class="container main_body"> <div class="section" >
      <div class="column is-6 is-offset-3" style="margin-top:40px;">
        <center><a class="logo" class="logo" href="index.php"><?php echo ($core->logo) ? '<img src="assets/'.$core->logo.'" alt="'.$core->site_name.'" width="190" height="45"/>': $core->site_name;?></a></center>
        <div class="box">
         <?php
          $license_code = null;
          $client_name = null;
          if(!empty($_POST['license'])&&!empty($_POST['client'])){
          $license_code = $_POST["license"];
          $client_name = $_POST["client"]; 
          /*
          Once we have the license code and client's name we can use LicenseBoxAPI's activate_license() function for activating/installing the license, if the third parameter is empty a local license file will be created which can be used for background license checks in the future using verify_license() function.
          */
          $activate_response = $api->activate_license($_POST['license'],$_POST['client']);
          if(empty($activate_response))
          {
          $msg='Server is currently unavailable, please try again later.';
          }
          else
          {
          $msg=$activate_response['message'];
          }
          if ($activate_response['status'] != 'true') {
          ?>
          <form action="verify_purchase.php" method="POST">
            <div class="notification is-danger"><?php echo ucfirst($msg); ?></div>
            <div class="field">
              <label class="label">Envato username</label>
              <div class="control">
                <input class="input" type="text" placeholder="Enter your envato username" name="client" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Purchase code <a href="https://codecanyon.net/user/jaomweb/portfolio" target="_BLANK">(?)</a></label>
              <div class="control">
                <input class="input" type="text" placeholder="Enter your purchase code" name="license" required>
              </div>
            </div>
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Activate</button>
            </div>
          </form>
          <?php
          }else{
            header("Location: index.php");
          }}else{?>
          <form action="verify_purchase.php" method="POST">
            <div class="field">
              <label class="label">Envato username</label>
              <div class="control">
                <input class="input" type="text" placeholder="Enter your envato username" name="client" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Purchase code <a href="https://codecanyon.net/user/jaomweb/portfolio" target="_BLANK">(?)</a></label>
              <div class="control">
                <input class="input" type="text" placeholder="Enter your purchase code" name="license" required>
              </div>
            </div>
            <div style='text-align: right;'>
              <button type="submit" class="button is-link">Activate</button>
            </div>
          </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="content has-text-centered">
    <p>
      &copy <?php echo date('Y');?> - Deprixa Pro, All Rights Reserved.
    </p>
    <br>
  </div>
</body>
</html>