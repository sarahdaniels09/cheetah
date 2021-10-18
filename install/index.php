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



require_once '../helpers/license_lb_helper.php'; // Include LicenseBox external/client api helper file

$installFile = "install.deprixapro";

if (is_file($installFile)) {

  $api = new LicenseBoxExternalAPI(); // Initialize a new LicenseBoxAPI object
  $filename = 'deprixa_database.sql'; //SQL file to be imported

  ?>
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8"/>
      <title>Deprixa Pro - Installer</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="robots" content="noindex, nofollow">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.2/css/bulma.min.css" crossorigin="anonymous"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" crossorigin="anonymous" />
      <style type="text/css">
        body, html {
          background: #F4F5F7;
        }
      </style>
    </head>
    <body>
      <?php
        $errors = false;
        $step = isset($_GET['step']) ? $_GET['step'] : '';
      ?>
      <div class="container" style="padding-top: 20px;"> 
        <div class="section">
          <div class="columns is-centered">
            <div class="column is-two-fifths">
              <center>
                 <img class="p-t-lg m-t-sm" src="../assets/uploads/logo.png" width="190" alt="LicenseBox">
                  <h4 class="title is-4 p-t-md p-b-md" style="margin-right: -5px;margin-left: -5px; margin-bottom:40px;">
                  Welcome to the installation wizard!
                </h4>
              </center>
              <div class="box">
                <?php
                switch ($step) {
                  default: ?>
                    <div class="tabs is-fullwidth">
                      <ul>
                        <li class="is-active">
                          <a>
                            <span><b>Requirements</b></span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span>Verify</span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span>Database</span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span>Finish</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <?php  
                    // Add or remove your script's requirements below
                    if(version_compare(PHP_VERSION, '5.6.0')<0){
                    $errors = true;
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> Current PHP version is ".phpversion()."! minimum PHP 5.6 or higher required.</div>";
                    }else{
                      echo "<div class='notification is-success is-light' style='padding:12px;'><i class='fa fa-check'></i> You are running PHP version ".phpversion()."</div>";
                    }
                    if(!extension_loaded('pdo')){
                      $errors = true; 
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> PDO PHP extension is missing!</div>";
                    }else{
                      echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check p-r-xs'></i> PDO PHP extension is available.</div>";
                    }

                    if(!extension_loaded('curl')){
                      $errors = true; 
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> CURL extension is missing!</div>";
                    }else{
                      echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check p-r-xs'></i> CURL extension is available.</div>";
                    }


                    if(!extension_loaded('json')){
                      $errors = true; 
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> JSON extension is missing!</div>";
                    }else{
                      echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check p-r-xs'></i> JSON extension is available.</div>";
                    }

                    if(!extension_loaded('openssl')){
                      $errors = true; 
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> OpenSSL extension is missing!</div>";
                    }else{
                      echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check p-r-xs'></i> OpenSSL extension is available.</div>";
                    }

                    if(!extension_loaded('pdo')){
                      $errors = true; 
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> PDO extension is missing!</div>";
                    }else{
                      echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check p-r-xs'></i> PDO extension is available.</div>";
                    }

                    if(!extension_loaded('xml')){
                      $errors = true; 
                      echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times p-r-xs'></i> XML extension is missing!</div>";
                    }else{
                      echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check p-r-xs'></i> XML extension is available.</div>";
                    }



                     ?>
                    <div style='text-align: right;'>
                      <?php if($errors==true){ ?>
                      <a href="#" class="button is-link is-rounded" disabled>Next</a>
                      <?php }else{ ?>
                      <a href="index.php?step=0" class="button is-link is-rounded">Next</a>
                      <?php } ?>
                    </div><?php
                    break;
                  case "0": ?>
                    <div class="tabs is-fullwidth">
                      <ul>
                        <li>
                          <a>
                            <span><i class="fa fa-check-circle"></i> Requirements</span>
                          </a>
                        </li>
                        <li class="is-active">
                          <a>
                            <span><b>Verify</b></span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span>Database</span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span>Finish</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <?php
                      $license_code = null;
                      $client_name = null;
                      if(!empty($_POST['license'])&&!empty($_POST['client'])){
                        $license_code = strip_tags(trim($_POST["license"]));
                        $client_name = strip_tags(trim($_POST["client"]));
                        /* Once we have the license code and client's name we can use LicenseBoxAPI's activate_license() function for activating/installing the license, if the third parameter is empty a local license file will be created which can be used for background license checks. */
                        $activate_response = $api->activate_license($license_code,$client_name);
                        if(empty($activate_response)){
                          $msg='Server is unavailable.';
                        }else{
                          $msg=$activate_response['message'];
                        }
                        if($activate_response['status'] != true){ ?>
                          <form action="index.php?step=0" method="POST">
                            <div class="notification is-danger is-light"><?php echo ucfirst($msg); ?></div>
                            <div class="field">
                                  <label class="label">Purchase code <small class="has-text-weight-normal has-text-grey"> (<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">Where is my purchase code?</a>)</small></label>
                              <div class="control">
                                <input class="input" type="text" placeholder="Enter your purchase/license code" name="license" required>
                              </div>
                            </div>
                            <div class="field">
                              <label class="label">Your name</label>
                              <div class="control">
                                <input class="input" type="text" placeholder="Enter your name/envato username" name="client" required>
                              </div>
                            </div>
                            <div style='text-align: right;'>
                              <button type="submit" class="button is-link is-rounded">Verify</button>
                            </div>
                          </form><?php
                        }else{ ?>
                          <form action="index.php?step=1" method="POST">
                            <div class="notification is-success is-light"><?php echo ucfirst($msg); ?></div>
                            <input type="hidden" name="lcscs" id="lcscs" value="<?php echo ucfirst($activate_response['status']); ?>">
                            <div style='text-align: right;'>
                              <button type="submit" class="button is-link">Next</button>
                            </div>
                          </form><?php
                        }
                      }else{ ?>
                        <form action="index.php?step=0" method="POST">
                          <div class="field">
                           <label class="label">Purchase code <small class="has-text-weight-normal has-text-grey"> (<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-">Where is my purchase code?</a>)</small></label>
                            <div class="control">
                              <input class="input" type="text" placeholder="Enter your purchase/license code" name="license" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Your name</label>
                            <div class="control">
                              <input class="input" type="text" placeholder="Enter your name/envato username" name="client" required>
                            </div>
                          </div>
                          <div style='text-align: right;'>
                            <button type="submit" class="button is-link is-rounded">Verify</button>
                          </div>
                        </form>
                      <?php } 
                    break;
                  case "1": ?>
                    <div class="tabs is-fullwidth">
                      <ul>
                        <li>
                          <a>
                            <span><i class="fa fa-check-circle"></i> Requirements</span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span><i class="fa fa-check-circle"></i> Verify</span>
                          </a>
                        </li>
                        <li class="is-active">
                          <a>
                            <span><b>Database</b></span>
                          </a>
                        </li>
                        <li>
                          <a>
                            <span>Finish</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <?php
                      if($_POST && isset($_POST["lcscs"])){
                        $valid = strip_tags(trim($_POST["lcscs"]));
                        $db_host = strip_tags(trim($_POST["host"]));
                        $db_user = strip_tags(trim($_POST["user"]));
                        $db_pass = strip_tags(trim($_POST["pass"]));
                        $db_name = strip_tags(trim($_POST["name"]));
                        // Let's import the sql file into the given database
                        if(!empty($db_host)){
                            try {

                              $pdof = new PDO("mysql:host=$db_host;", $db_user, $db_pass);
                              $pdof->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                              
                              $mysql_ver = $pdof->query('select version()')->fetchColumn();
                              if(version_compare($mysql_ver, '5.6.0') < 0){ ?>
                                <div class='notification is-danger'>You are running MySQL <?php echo $mysql_ver; ?>, minimum requirement is MySQL 5.6 or higher. Please upgrade and re-run the installation or contact support.</div>
                              <?php
                              die();
                              }


                              //create config file
                             $input  = '<?php' . "\n";
                             $input .='define("DB_HOST", "'.$db_host.'");'. "\n";
                             $input .='define("DB_NAME", "'.$db_name.'");'. "\n";
                             $input .='define("DB_USER", "'.$db_user.'");'. "\n";
                             $input .='define("DB_PASS", "'.$db_pass.'");'. "\n";
                             $input .='define(\'APP_URL\', \'' . $appurl . '\');'. "\n";
                             $input .= '?>';                   


                              $wConfig = "../config/config.php";

                              if(file_exists($wConfig)){
                                  unlink($wConfig);   
                              }

                              $fh = fopen($wConfig, 'w') or die($f_msg);
                              fwrite($fh, $input);
                              fclose($fh);

                              $ip_server= $_SERVER['REMOTE_ADDR'];

                              $http = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                              $cururl = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                              $appurl = str_replace('/install/index.php?step=1', '/', $cururl);


                              $dates= date("Y-m-d H:i:s");
                                                                  
                              $subject="Nueva instalación de Courier Deprixa Pro versión 6.3";
                              $message="<p>
                                          Fecha de instalación: $dates <br>
                                          Dominio de Internet :$appurl <br>
                                          Dirección IP: $ip_server
                                      </p>
                              ";    
                              
                              $from= 'support@jaom.info';

                              $to= 'osorio2380@gmail.com';

                              $header = "MIME-Version: 1.0\r\n";
                              $header .= "Content-type: text/html; charset=UTF-8 \r\n";
                              $header .= "From: ". $from . " \r\n";
                              
                              mail($to, $subject, $message, $header);



                              $pdof->query("use $db_name");

                               $templine = '';
                              $lines = file($filename);
                              foreach ($lines as $line) {
                                if (substr($line, 0, 2) == '--' || $line == '')
                                  continue;
                                  $templine .= $line;
                                  $query = false;
                                if (substr(trim($line), -1, 1) == ';') {
                                  $query = $pdof->query($templine);
                                  $templine = '';
                                }
                              }

                              $pdof->query("UPDATE settings SET site_url='".$appurl."'");
                            }catch (PDOException $err) { ?>

                             <form action="index.php?step=1" method="POST">
                               <div class='notification is-danger is-light'><?php echo 'Connection failed: ' . $err->getMessage(); ?></div>
                               <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
                               <div class="field">
                                 <label class="label">Database Host</label>
                                 <div class="control">
                                   <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
                                 </div>
                               </div>
                               <div class="field">
                                 <label class="label">Database Username</label>
                                 <div class="control">
                                   <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
                                 </div>
                               </div>
                               <div class="field">
                                 <label class="label">Database Password</label>
                                 <div class="control">
                                   <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
                                 </div>
                               </div>
                               <div class="field">
                                 <label class="label">Database Name</label>
                                 <div class="control">
                                   <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
                                 </div>
                               </div>
                               <div style='text-align: right;'>
                                 <button type="submit" class="button is-link is-rounded">Import</button>
                               </div>
                             </form>
                             <?php
                             exit;
                           }

                         
                           ?>
                        <form action="index.php?step=2" method="POST">
                          <div class='notification is-success is-light'>Database was successfully imported.</div>
                          <input type="hidden" name="dbscs" id="dbscs" value="true">
                          <div style='text-align: right;'>
                            <button type="submit" class="button is-link">Next</button>
                          </div>
                        </form><?php
                      }else{ ?>
                        <form action="index.php?step=1" method="POST">
                          <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
                          <div class="field">
                            <label class="label">Database Host</label>
                            <div class="control">
                              <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Username</label>
                            <div class="control">
                              <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Password</label>
                            <div class="control">
                              <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Name</label>
                            <div class="control">
                              <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
                            </div>
                          </div>
                          <div style='text-align: right;'>
                            <button type="submit" class="button is-link is-rounded">Import</button>
                          </div>
                        </form><?php
                    } 
                  }else{ ?>
                    <div class='notification is-danger is-light'>Sorry, something went wrong.</div><?php
                  }
                  break;
                case "2": ?>
                  <div class="tabs is-fullwidth">
                    <ul>
                      <li>
                        <a>
                          <span><i class="fa fa-check-circle"></i> Requirements</span>
                        </a>
                      </li>
                      <li>
                        <a>
                          <span><i class="fa fa-check-circle"></i> Verify</span>
                        </a>
                      </li>
                      <li>
                        <a>
                          <span><i class="fa fa-check-circle"></i> Database</span>
                        </a>
                      </li>
                      <li class="is-active">
                        <a>
                          <span><b>Finish</b></span>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <?php
                  if($_POST && isset($_POST["dbscs"])){
                    $valid = $_POST["dbscs"];

                  $http = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                  $cururl = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                  $appurl = str_replace('/install/index.php?step=2', '/', $cururl);

                    if(is_writeable($installFile))
                    {
                      unlink($installFile);
                    }

                    ?>
                    <center><p><strong>Deprixa Pro is successfully installed.</strong></p><br>
                    <p>You can now login using your email or username: <strong>admin</strong> and default password: <strong>09731</strong></p><br><strong>
                    <p><a class='button is-link' href='../index.php'>Login</a></p></strong>
                    <br>
                    <p class='help has-text-grey'>The first thing you should do is change your account details.</p>
                    </center>

                    <?php
                  }else{ ?>
                    <div class='notification is-danger is-light'>Sorry, something went wrong.</div><?php
                  } 
                break;
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content has-text-centered">
      <p>Copyright <?php echo date('Y'); ?> Deprixa Pro, All rights reserved.</p><br>
    </div>
  </body>
  </html>

<?php

  }else{

    header('Location: ../index.php');
    exit();
  }