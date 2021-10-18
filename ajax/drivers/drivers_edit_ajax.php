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

        $errors= array();
        
       
        if (empty($_POST['fname']))

            $errors['fname'] = 'Please enter the name';
        if (empty($_POST['lname']))

            $errors['lname'] = 'Please enter the last name';        

        if (empty($_POST['email']))

            $errors['email'] = 'Enter a valid email address';

        if ($user->emailExists($_POST['email'], $_POST['id']))

            $errors[] = 'The email address you entered is already in use.';

        if (!$user->isValidEmail($_POST['email']))

            $errors[] = 'The email address you entered is invalid.';

        
       
        if (empty($_POST['phone']))

            $errors['phone'] = 'Please enter the phone';

       

        if (!empty($_FILES['avatar']['name'])) {                                  

            $target_dir="../../assets/uploads/";
            $image_name = time()."_".basename($_FILES["avatar"]["name"]);
            $target_file = $target_dir .$image_name ;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $imageFileZise=$_FILES["avatar"]["size"];    

            if(($imageFileType != "jpg" && $imageFileType != "png")) {

                $errors['avatar']= "<p>Illegal file type. Only jpg and png file types are allowed..</p>";

            } else if (empty(getimagesize($_FILES['avatar']['tmp_name']))) {//1048576 byte=1MB

                $errors['avatar']= "<p>Illegal file type. Only jpg and png file types are allowed.";

            }
        }
          
          if (empty($errors)) {
              
              $data = array(
                  'enrollment' => trim($_POST['enrollment']),
                  'vehiclecode' => trim($_POST['vehiclecode']),                 
                  'email' => trim($_POST['email']), 
                  'lname' => trim($_POST['lname']), 
                  'fname' => trim($_POST['fname']),
                  'newsletter' => intval($_POST['newsletter']),
                  'notes' => trim($_POST['notes']),
                  'phone' => trim($_POST['phone']),
                  'gender' => trim($_POST['gender']),
                  'active' => trim($_POST['active']),
                  'id' => trim($_POST['id'])
              );



              $userDataEdit = getUserEdit($_POST['id']);


              
              if ($_POST['password'] != "") {

                  $data['password'] =password_hash($_POST['password'], PASSWORD_DEFAULT);

              }else{

                $data['password'] =$userDataEdit['data']->password;

              }

          
                   
           
            if (!empty($_FILES['avatar']['name'])) {                                  

                    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                    $imagen=basename($_FILES["avatar"]["name"]);
                    $data['avatar'] ='uploads/'.$image_name;                 
                
            }else{

              $data['avatar'] =$userDataEdit['data']->avatar;
            }


            
          // var_dump(count($_POST));

            
            $insert= updateDrivers($data);

              $db->query("DELETE FROM  users_multiple_addresses WHERE user_id='".$_POST['id']."'");
              $db->execute();
        

            for ($count = 0; $count < $_POST["total_address"]; $count++) {                

                $db->query("
                  INSERT INTO users_multiple_addresses 
                  (
                  address,
                  country,
                  city,
                  zip_code,
                  user_id                                
                  )
                  VALUES 
                  (
                  :address,
                  :country,
                  :city, 
                  :zip_code,
                  :user_id                            
                  )
                ");

               
                $db->bind(':user_id',  $_POST['id']);
                $db->bind(':address',  trim($_POST["address"][$count]));
                $db->bind(':country',  trim($_POST["country"][$count]));
                $db->bind(':city',  trim($_POST["city"][$count]));                
                $db->bind(':zip_code',  trim($_POST["postal"][$count]));

                $insert = $db->execute();
            }

            if ($insert) {


                $messages[] = "Driver updated successfully!";

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