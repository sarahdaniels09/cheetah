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



   require_once ("../../../loader.php");
   require_once ("../../../helpers/querys.php");

        $errors= array();  

           if (empty($_POST['mod_style']))

            $errors['mod_style'] = 'Please Enter New Status';
          
            if (statusCourierExists($_POST['mod_style'], $_POST['id']))

              $errors['mod_style'] = 'The new Status is already in use.. <b>"'.$_POST['mod_style'].'"</b>';
          

          if (empty($_POST['detail']))

            $errors['detail'] = 'Please Enter New Observations';
                  
          if (empty($_POST['color']))

            $errors['color'] = 'Please Enter New Color';
          
            if (colorStatusCourierExists($_POST['color'], $_POST['id']))

              $errors['color'] = 'The new Color is already in use.. <b>"'.$_POST['color'].'"</b>';
          
          if (empty($errors)) {
              
               $data = array(

                  'mod_style' => trim($_POST['mod_style']), 
                  'detail' => trim($_POST['detail']), 
                  'color' => trim($_POST['color']),
                  'id' => trim($_POST['id'])

                );
            
            $insert= updateStatusCourier($data);

            if ($insert) {

                $messages[] = "New Status updated successfully!";

            }else {

                $errors['critical_error'] = "the insert was not completed";
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