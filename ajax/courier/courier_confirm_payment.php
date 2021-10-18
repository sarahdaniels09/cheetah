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
        session_start();


           if (empty($_POST['order_id_confirm_payment']))
           $errors['order_id_confirm_payment'] = 'Please select invoice';
          
         
          $status_invoice=1;

        

          if (empty($errors)) {
              
             $data = array(
                'order_id' => trim($_POST['order_id_confirm_payment']), 
                'status_invoice'=> $status_invoice               
              );
        
            $insert= confirmPaymentCourier($data);

            if ($insert) {

                $messages[] = "payment confirmed successfully!";


                    // SAVE NOTIFICATION
                $db->query("
                    INSERT INTO notifications 
                    (
                        user_id,
                        order_id,
                        notification_description,
                        shipping_type,
                        notification_date

                    )
                    VALUES
                        (
                        :user_id,      
                        :order_id,

                        :notification_description,
                        :shipping_type,
                        :notification_date                    
                        )
                ");



                $db->bind(':user_id',  $_SESSION['userid']);
                $db->bind(':order_id', $_POST["order_id_confirm_payment"]);
                $db->bind(':notification_description','Shipment payment has been confirmed, please check it');           
                $db->bind(':shipping_type', '1');           
                $db->bind(':notification_date',  date("Y-m-d H:i:s"));        

                $db->execute();


                $notification_id = $db->dbh->lastInsertId(); 


                $users_employees = getUsersAdminEmployees();

                foreach ($users_employees as $key) {

                    insertNotificationsUsers($notification_id, $key->id);             
                      
                }

                insertNotificationsUsers($notification_id, $_POST['customer_id_confirm_payment']);
                

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