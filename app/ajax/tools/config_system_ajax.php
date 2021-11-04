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
    $user = new User;
    $core = new Core;
        $errors= array();

                 
      if (empty($_POST['site_name']))

            $errors['site_name'] = 'Please enter Website Name!';

        if (empty($_POST['site_url']))

            $errors['site_url'] = 'Please enter Website Url!';

        if (empty($_POST['thumb_w']))

            $errors['thumb_w'] = 'Please enter Thumbnail Width!';

        if (empty($_POST['thumb_h']))

            $errors['thumb_h'] = 'Please enter Thumbnail height!';

          $data = array(
              'site_name' => trim($_POST['site_name']), 
              'site_url' => trim($_POST['site_url']),
              'c_nit' => trim($_POST['c_nit']),
              'c_phone' => trim($_POST['c_phone']),
              'cell_phone' => trim($_POST['cell_phone']),
              'c_address' => trim($_POST['c_address']),
              'locker_address' => trim($_POST['locker_address']),
              'c_country' => trim($_POST['c_country']),
              'c_city' => trim($_POST['c_city']),
              'c_postal' => trim($_POST['c_postal']),
              'site_email' => trim($_POST['site_email']),
              'reg_allowed' => intval($_POST['reg_allowed']),
              // 'user_limit' => intval($_POST['user_limit']),
              'reg_verify' => intval($_POST['reg_verify']),
              'notify_admin' => intval($_POST['notify_admin']),
              'auto_verify' => intval($_POST['auto_verify']),
              // 'user_perpage' => intval($_POST['user_perpage']),
              'thumb_w' => intval($_POST['thumb_w']),
              'thumb_h' => intval($_POST['thumb_h'])
            );  

       

        if (!empty($_FILES['favicon']['name'])) {                                  

            $target_dir="../../assets/uploads/";
            $image_name = time()."_".basename($_FILES["favicon"]["name"]);
            $target_file = $target_dir .$image_name ;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imageFileZise=$_FILES["favicon"]["size"];    

            if(($imageFileType != "jpg" && $imageFileType != "png")) {

                $errors['favicon']= "<p>Illegal file type. Only jpg and png file types are allowed..</p>";

            } else if (empty(getimagesize($_FILES['favicon']['tmp_name']))) {//1048576 byte=1MB

                $errors['favicon']= "<p>Illegal file type. Only jpg and png file types are allowed.";

            }else{

                      move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file);
                    $imagen=basename($_FILES["favicon"]["name"]);
                    $data['favicon'] ='uploads/'.$image_name;     

            }


        }else{

              $data['favicon'] = $core->favicon;

        }


        if (!empty($_FILES['logo']['name'])) {                                  

            $target_dir="../../assets/uploads/";
            $image_name = time()."_".basename($_FILES["logo"]["name"]);
            $target_file = $target_dir .$image_name ;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imageFileZise=$_FILES["logo"]["size"];    

            if(($imageFileType != "jpg" && $imageFileType != "png")) {

                $errors['logo']= "<p>Illegal file type. Only jpg and png file types are allowed..</p>";

            } else if (empty(getimagesize($_FILES['logo']['tmp_name']))) {//1048576 byte=1MB

                $errors['logo']= "<p>Illegal file type. Only jpg and png file types are allowed.";

            }else{

                  move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
                  $imagen=basename($_FILES["logo"]["name"]);
                  $data['logo'] ='uploads/'.$image_name;
            }


        }else{

          $data['logo'] = $core->logo;
        }
          
          if (empty($errors)) {
              
                      
           
            // if (!empty($_FILES['logo']['name'])) {                                  

            //         move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            //         $imagen=basename($_FILES["logo"]["name"]);
            //         $data['logo'] ='uploads/'.$image_name;                 
                
            // }


            // if (!empty($_FILES['favicon']['name'])) {                                  

            //         move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file);
            //         $imagen=basename($_FILES["favicon"]["name"]);
            //         $data['favicon'] ='uploads/'.$image_name;                 
                
            // }

            $insert= updateConfigSystem($data);

      
            if ($insert) {

                $messages[] = "System Configuration updated successfully!";

            }else {

                $errors['critical_error'] = "the updated was not completed";
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