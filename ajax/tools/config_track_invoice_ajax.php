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



   require_once ("../../loader.php");
   require_once ("../../helpers/querys.php");

        $errors= array();  

        if (empty($_POST['interms']))

        $errors['interms'] = "Please enter Terms!";

      if (empty($_POST['prefix']))

        $errors['prefix'] = "Please enter prefix!";

      if (empty($_POST['track_digit']))

        $errors['track_digit'] = "Please enter track Digit!";

      if (intval($_POST['track_digit'])>10 ||intval($_POST['track_digit'])<1 )

        $errors['track_digit_length'] = "digits to track shipments requires a number between 1 and 10";
     
      if (empty($_POST['prefix_consolidate']))

        $errors['prefix_consolidate'] = "Please enter prefix Consolidate!";

      if (empty($_POST['track_consolidate']))

        $errors['track_consolidate'] = "Please enter tracking Consolidate!";

      if (intval($_POST['track_consolidate'])>10 ||intval($_POST['track_consolidate'])<1 )

        $errors['track_digit_length_consolidate'] = "digits to track consolidated requires a number between 1 and 10";
       
          
          if (empty($errors)) {
              
            $data = array(
              'interms' => trim($_POST['interms']),
              'signing_customer' => trim($_POST['signing_customer']),
              'signing_company' => trim($_POST['signing_company']),
              'prefix' => trim($_POST['prefix']),
              'track_digit' => trim($_POST['track_digit']),
              // 'prefix_con' => trim($_POST['prefix_con']),
              // 'track_container' => trim($_POST['track_container']),
              'prefix_consolidate' => trim($_POST['prefix_consolidate']),
              'track_consolidate' => trim($_POST['track_consolidate'])
            );            
           
            
            $insert= updateConfigTrackInvoice($data);

            if ($insert) {

                $messages[] = "Configuration updated successfully!";

            }else {

                $errors['critical_error'] = "the update was not completed";
            }

          }
	

            if (!empty($errors)){
			  // var_dump($errors);
			?>
            <div class="alert alert-danger" id="success-alert">
                <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
                    <span>Error! </span> There was an error processing the request
                    <ul class="error">
                         <?php
                            foreach ($errors as $error) {?>
                        <li>
                            <i class="icon-double-angle-right"></i>
                            <?php
                             echo $error;
                            
                            ?>

                        </li>
                        <?php
                             
                        }
                        ?>


                    </ul>
                </p>
            </div>


			
			<?php
			}

			if (isset($messages)){
				
				?>
               <div class="alert alert-info" id="success-alert">
                    <p><span class="icon-info-sign"></span><i class="close icon-remove-circle"></i>
                        <?php
                        foreach ($messages as $message) {
                                echo $message;
                            }
                        ?>
                   </p>
                </div>
				
			<?php
			}
?>			