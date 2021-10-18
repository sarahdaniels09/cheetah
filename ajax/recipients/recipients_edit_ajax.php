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
          
        if (empty($_POST['fname']))

            $errors['fname'] = 'Please enter the name';
        if (empty($_POST['lname']))

            $errors['lname'] = 'Please enter the last name';

       
        if (empty($_POST['email']))

            $errors['email'] = 'Enter a valid email address';

        if ($user->emailExists($_POST['email'], $_POST['recipient_id']))

            $errors[] = 'The email address you entered is already in use.';

        if (!$user->isValidEmail($_POST['email']))

            $errors[] = 'The email address you entered is invalid.';

 

        if (empty($_POST['phone_custom']))

            $errors['phone_custom'] = 'Please enter the phone';

        if (empty($_POST['address']))

            $errors['address'] = 'Please enter the address';       

         
          
          if (empty($errors)) {
              
              $data = array(
                  'lname' => trim($_POST['lname']), 
                  'fname' => trim($_POST['fname']),                    
                  'phone' => trim($_POST['phone']),
                  'email' => trim($_POST['email']),
                  'id_recipient' => $_POST['recipient_id'],
              );


              $db->query("
                UPDATE  users SET                
                    
                  fname=:fname,
                  lname=:lname,           
                  phone=:phone,
                  email=:email                  

                    WHERE id=:id_recipient                
                
              ");
                          
              $db->bind(':email', $data['email']); 
              $db->bind(':fname', $data['fname']); 
              $db->bind(':lname', $data['lname']);          
              $db->bind(':phone', $data['phone']);       
              $db->bind(':id_recipient', $_POST['recipient_id']);       

              $db->execute();  


              $db->query("DELETE FROM  users_multiple_addresses WHERE user_id='".$_POST['recipient_id']."'");
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

               
                $db->bind(':user_id',  $_POST['recipient_id']);
                $db->bind(':address',  trim($_POST["address"][$count]));
                $db->bind(':country',  trim($_POST["country"][$count]));
                $db->bind(':city',  trim($_POST["city"][$count]));                
                $db->bind(':zip_code',  trim($_POST["postal"][$count]));

                $insert = $db->execute();
            
            }             

            if ($insert) {

                $messages[] = "Recipient updated successfully!";

            }else {

                $errors['critical_error'] = "the registration was not completed";
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