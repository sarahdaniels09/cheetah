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

    require_once('helpers/querys.php');

    $userData = $user->getUserData();

    if (isset($_GET['id_order'])) {
        $data= getCustomerPackagePrint($_GET['id_order']);
    }


    if (!isset($_GET['id_order']) or $data['rowCount']!=1){
        redirect_to("customer_packages_list.php");
    }
       
    $row_order=$data['data'];

    $userData = $user->getUserData();

    $track_order = $row_order->order_prefix.$row_order->order_no;


    $payrow = $core->getPayment();

?>



<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Courier DEPRIXA-Integral Web System" />
    <meta name="author" content="Jaomweb">
    <title>Pay shipping | <?php echo $core->site_name ?></title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <title></title>
    <!-- Custom CSS -->

    <link href="assets/css/style.min.css" rel="stylesheet">
    <link href="assets/stripe_styles.css" rel="stylesheet">
    
    <link href="assets/css_log/front.css" rel="stylesheet" type="text/css"> 
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.js"></script>
    <script src="assets/js/jquery.wysiwyg.js"></script>
    <script src="assets/js/global.js"></script>
    <script src="assets/js/custom.js"></script>
    <link href="assets/customClassPagination.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>

    <script>
        $(function() {
            "use strict";
            $("#main-wrapper").AdminSettings({
                Theme: false, // this can be true or false ( true means dark and false means light ),
                Layout: 'vertical',
                LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
                NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
                SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
                SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
                BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
            });
        });
    </script>

   
   <style>
       
   </style>
</head>

<body>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $core->paypal_client_id;?>&currency=USD&disable-funding=credit,card"></script>

    <script src="https://js.paystack.co/v1/inline.js"></script> 


    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        
        <?php include 'views/inc/preloader.php'; ?>
        
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        
        <?php include 'views/inc/topbar.php'; ?>
        
        <!-- End Topbar header -->

        
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
 
        <?php include 'views/inc/left_sidebar.php'; ?>
        

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->

        <div class="page-wrapper">

           <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
             <div class="container-fluid">         

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                
                                    <!-- For demo purpose -->
                                    <div class="row mb-4">
                                        <div class="col-lg-12 mx-auto text-center">
                                            <h3 class="display-7"><b class="text-danger">INVOICE</b> <span>#<?php echo $row_order->order_prefix.$row_order->order_no;?></span></h3>
                                        </div>

                                       <div class="col-lg-12 mx-auto text-center mt-4">                                  
                                           
                                            <h3 ><span>total amount to pay: <b><?php echo  number_format($row_order->total_order, 2,'.','');?> <?php echo $core->currency;?> </b></span></h3>

                                       </div>
                                    </div> <!-- End -->

                                    <div class="row">
                                        <div class="col-lg-12 mx-auto">
                                            <div id="resultados_ajax"></div>
                                            <div class="card ">
                                                <div class="card-header">
                                                    <div class="shadow-sm pt-3 pl-3 pr-3 pb-1"  style="background-color: #3e5569 !important;">

                                                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">

                                                            <?php 
                                                            if($core->active_stripe==1){
                                                            ?>
                                                            <li class="nav-item">
                                                                <a data-toggle="pill" href="#stripe" class="nav-link active" >
                                                                    <i class="fa fa-cc-stripe mr-2"></i>
                                                                    Stripe
                                                                </a>
                                                            </li>

                                                            <?php                                                              
                                                            }
                                                            ?>

                                                            <?php 
                                                            if($core->active_paypal==1){
                                                            ?>
                                                            <li class="nav-item">
                                                                <a data-toggle="pill" href="#paypal" class="nav-link">
                                                                     <i class="fab fa-paypal mr-2"></i>
                                                                     PayPal
                                                                </a>
                                                            </li>

                                                            <?php                                                              
                                                            }
                                                            ?>


                                                            <?php 
                                                            if($core->active_paystack==1){
                                                            ?>

                                                            <li class="nav-item">
                                                                <a data-toggle="pill" href="#paystack" class="nav-link">
                                                                     <i class="fas fa-credit-card mr-2"></i>
                                                                     Paystack
                                                                </a>
                                                            </li> 

                                                            <?php                                                              
                                                            }
                                                            ?>


                                                            <?php 
                                                            if($core->active_attach_proof==1){
                                                            ?>  

                                                            <li class="nav-item">
                                                                <a data-toggle="pill" href="#attach" class="nav-link">
                                                                    <i class="fa fa-paperclip mr-2"></i>
                                                                    Attach proof of payment
                                                                </a>
                                                            </li>

                                                            <?php                                                              
                                                            }
                                                            ?>                                  
                                                        </ul>
                                                    </div> <!-- End -->
                                                    <!-- Credit card form content -->
                                                    <div class="tab-content bg-white">



                                                             <!-- STRIPE TAB-PANE -->
                                                        <?php 
                                                        if($core->active_stripe==1){
                                                        ?>
                                                        <div id="stripe" class="tab-pane fade show active  pt-3">

                                                            <form id="payment-form" style="padding: 40px">
                                                                  <div>
                                                                    <label>Card Owner</label>
                                                                    <input class="form-control" type="text" name="name_property_card_stripe" id="name_property_card_stripe" required>
                                                                </div>

                                                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $_GET['id_order']; ?>">

                                                                <input type="hidden" name="track_order" id="track_order" value="<?php echo $track_order; ?>">
                                                               
                                                                <div>
                                                                    <label>Email</label>
                                                                    <input class="form-control" type="email" name="email_property_card_stripe" id="email_property_card_stripe" required>
                                                                </div>
                                                                  <div id="card-element" style="margin-top: 20px; margin-bottom: 30px"><!--Stripe.js injects the Card Element--></div>

                                                                  <button id="submit">
                                                                    <div class="spinner hidden" id="spinner"></div>
                                                                    <span id="button-text">Pay now</span>
                                                                  </button>
                                                                  <p id="card-error-custom" class="text-danger" role="alert"></p>
                                                                 
                                                            </form>

                                                            
                                                        </div>
                                                        <!-- END STRIPE TAB-PANE -->
                                                        <?php                                                              
                                                        }
                                                        ?>

                                                        <?php 
                                                        if($core->active_paypal==1){
                                                        ?>

                                                        <!-- PAYPAL TAB-PANE -->
                                                        <div id="paypal" class="tab-pane fade  pt-3">
                                                            
                                                            <p class="text-center text-info"> <b>To complete the transaction, we will send you to PayPal's secure servers.</b></p>
                                                            <div id="paypal-button-container" class=" text-center col-md-12"></div>
                                                            
                                                        </div> <!-- END  PAYPAL TAB-PANE -->

                                                        <?php                                                              
                                                         }
                                                        ?>

                                                        <?php 
                                                        if($core->active_paystack==1){
                                                        ?>

                                                               <!-- PAYSTACK TAB-PANE -->
                                                        <div id="paystack" class="tab-pane fade pt-3">

                                                            <form id="paymentForm" style="padding: 40px">
                                                                  <div class="form-group">
                                                                    <label for="email">Email Address</label>
                                                                    <input type="email" id="email-address" required/>
                                                                  </div>
                                                                  
                                                                  <div class="form-group">
                                                                    <label for="first-name">First Name</label>
                                                                    <input type="text" id="first-name" required />
                                                                  </div>
                                                                  <div class="form-group">
                                                                    <label for="last-name">Last Name</label>
                                                                    <input type="text" id="last-name" required/>
                                                                  </div>
                                                                  <div class="form-submit">
                                                                    <button type="submit">Pay now</button>
                                                                  </div>
                                                            </form>                              

                                                            
                                                        </div>
                                                        <!-- END PAYSTACK TAB-PANE -->

                                                         <?php                                                              
                                                         }
                                                        ?>


                                                        <?php 
                                                        if($core->active_attach_proof==1){
                                                        ?>

                                                        <!-- ATTACH TAB-PANE -->
                                                        <div id="attach" class="tab-pane fade  pt-3">

                                                            <form style="padding: 40px" class="form-horizontal" method="post" id="add_charges" name="add_charges"> 

                                                            <p class=""> <b>Note: If you use this payment method, you must wait for confirmation of payment from our administration team, once confirmed, a notification will be sent to you.</b></p>                
                                                              <div class="row">

                                                                   <div class="form-group col-md-12">
                                                                        <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['left243'] ?></label>
                                                                        <div class="input-group mb-3">                                       
                                                                            <select class="custom-select col-12" id="mode_pay" name="mode_pay" required="" >
                                                                             <option value=""><?php echo $lang['left243'] ?></option>
                                                                            <?php foreach ($payrow as $row):?>
                                                                                <option value="<?php echo $row->id; ?>"><?php echo $row->met_payment; ?></option>
                                                                            <?php endforeach;?>
                                                                            </select>
                                                                        </div>
                                                                    </div> 

                                                                </div> 

                                                                <div class="row mb-3">                                

                                                                    <div class="col-md-3">                             

                                                                       <div>
                                                                            <label class="control-label" id="selectItem" > Attach files</label>
                                                                        </div>

                                                                        <input class="custom-file-input" id="filesMultiple" name="filesMultiple"  type="file"  style="display: none;" onchange="validateZiseFiles();"/>
                                                                         
                                                                         
                                                                        <button type="button" id="openMultiFile" class="btn btn-info  pull-left "> <i class='fa fa-paperclip' id="openMultiFile" style="font-size:18px; cursor:pointer;"></i> Attach proof of payment</button>

                                                                        <div id="clean_files" class="row hide">     
                                                                         <button type="button" id="clean_file_button" class="  mt-3 btn btn-danger ml-3"> <i class='fa fa-trash' style="font-size:18px; cursor:pointer;"></i> Cancel attachments </button>
                                                                        
                                                                        </div>

                                                                    </div>                                

                                                                 
                                                                </div> 


                                                              <div class="row">
                                                                <div class="form-group col-sm-12">
                                                                    <label for="notes" class="control-label">notes</label>
                                                                
                                                                    <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                                                                </div>
                                                              </div>                                                     
                                                        
                                                          <div class="modal-footer">
                                                            
                                                            <button type="submit" class="btn btn-success" id="save_form2">Save</button>
                                                          </div>
                                                          </form>

                                                            
                                                        </div> <!-- END  ATTACH TAB-PANE -->
                                                        <?php                                                              
                                                         }
                                                        ?>
                                                            
                                                       
                                                    </div> <!-- End -->
                                                   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                   
                            </div>
                        </div>


                    </div>
                </div>


                   
                </div>


               
            </div>
        </div>
    </div>




        

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>



    <?php 
    if($core->active_paypal==1){
    ?>

   <!-- ================================================================ -->
                        <!-- PAYPAL METHOD PAYMENT -->
   <!-- ================================================================ -->
     <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value:  <?php echo  number_format($row_order->total_order, 2,'.','');?>
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
               
                return actions.order.capture().then(function(details){

                   addPaymentPayPalSuccess(details);   

                    
                });
            }


        }).render('#paypal-button-container');
    </script>

    <?php                                                              
     }
    ?>

     <script type="text/javascript">
        

        function addPaymentPayPalSuccess(details){

            $.ajax({

                url:'./ajax/customers_packages/add_payment_paypal_method_ajax.php?order_id=<?php echo $_GET['id_order'];?>&track_order=<?php echo $track_order; ?>&customer=<?php echo $row_order->sender_id; ?>',
                method:'post',
                data: details,                       
                success:function(data){
                    
                    $('html, body').animate({
                          scrollTop: 0
                    }, 600);

                    $('#resultados_ajax').html(data);

                }
            })
        }
    </script>



   <!-- ================================================================ -->
                        <!-- END PAYPAL METHOD PAYMENT -->
   <!-- ================================================================ -->





   <!-- ================================================================ -->
                        <!-- STRIPE METHOD PAYMENT -->
   <!-- ================================================================ -->
    <?php 
    if($core->active_stripe==1){
    ?>
<script>

// A reference to Stripe.js initialized with your real test publishable API key.
var stripe = Stripe("<?php echo $core->public_key_stripe;?>");

var elements = stripe.elements();

var style = {
  base: {
    color: "#32325d",
    fontFamily: 'Arial, sans-serif',
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#32325d"
    }
  },
  invalid: {
    fontFamily: 'Arial, sans-serif',
    color: "#fa755a",
    iconColor: "#fa755a"
  }
};

var card = elements.create("card", { style: style });
// Stripe injects an iframe into the DOM
card.mount("#card-element");

// Disable the button until we have Stripe set up on the page
document.querySelector("button").disabled = true;

card.on("change", function (event) {
  // Disable the Pay button if there are no card details in the Element
  document.querySelector("button").disabled = event.empty;
  document.querySelector("#card-error-custom").textContent = event.error ? event.error.message : "";
});



    

var form = document.getElementById("payment-form");

form.addEventListener("submit", function(event) {
  event.preventDefault();
  // Complete payment when the submit button is clicked

// Disable the button until we have Stripe set up on the page
document.querySelector("button").disabled = true;

    fetch("./ajax/customers_packages/add_payment_stripe_method_ajax.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        email_property_card_stripe: document.getElementById('email_property_card_stripe').value,
        name_property_card_stripe: document.getElementById('name_property_card_stripe').value,
        order_id: document.getElementById('order_id').value,
        track_order: document.getElementById('track_order').value,
      })
    })
    .then(function(result) {
      return result.json();
    })
    .then(function(data) { 
      payWithCard(stripe, card, data.clientSecret);
    });
});

// Calls stripe.confirmCardPayment
// If the card requires authentication Stripe shows a pop-up modal to
// prompt the user to enter authentication details without leaving your page.
var payWithCard = function(stripe, card, clientSecret) {
  loading(true);
  stripe
    .confirmCardPayment(clientSecret, {
      payment_method: {
        card: card
      }
    })
    .then(function(result) {
      if (result.error) {
        // Show error to your customer
        showError(result.error.message);
      } else {
        // The payment succeeded!
        loading(false);
        document.querySelector("button").disabled = true;

        console.log(result.paymentIntent)

        if(result.paymentIntent.status ==='succeeded'){

            addPaymentStripeSuccess(result.paymentIntent);
        }

       
      }
    });
};


// Show the customer the error from Stripe if their card fails to charge
var showError = function(errorMsgText) {
  loading(false);
  var errorMsg = document.querySelector("#card-error-custom");
  errorMsg.textContent = errorMsgText;
  setTimeout(function() {
    errorMsg.textContent = "";
  }, 4000);
};

// Show a spinner on payment submission
var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("button").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};


 function addPaymentStripeSuccess(details){

    $.ajax({

        url:'./ajax/customers_packages/add_payment_stripe_method_success_ajax.php?order_id=<?php echo $_GET['id_order'];?>&track_order=<?php echo $track_order; ?>&customer=<?php echo $row_order->sender_id; ?>',
        method:'post',
        data: details,                       
        success:function(data){

            $('html, body').animate({
                  scrollTop: 0
            }, 600);

            $('#resultados_ajax').html(data);
        }
    })
}


function redirect() {
    window.location = "customer_packages_view.php?id=<?php echo $_GET['id_order']; ?>";
}


</script>   

<?php                                                              
     }
    ?>







<script>


$( "#add_charges" ).submit(function( event ) {
    $('#save_form2').attr("disabled", true);

    if(validateZiseFiles()==true){

        return false;
    }

     var inputFileImage = document.getElementById("filesMultiple");    
     var notes = $('#notes').val();
     var mode_pay = $('#mode_pay').val();

    var file = inputFileImage.files[0];
    var data = new FormData();

    data.append('file_invoice',file);    
    data.append('notes',notes); 
    data.append('mode_pay',mode_pay); 
    $.ajax({
        type: "POST",
        url: "./ajax/customers_packages/customers_packages_add_ajax.php?order_id=<?php echo $_GET['id_order']; ?>",
        data: data,
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,
         beforeSend: function(objeto){
            $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
          },
        success: function(datos){
        $("#resultados_ajax").html(datos);
        $('#save_form2').attr("disabled", false);

        $('html, body').animate({
            scrollTop: 0
        }, 600);

                 
      }
    });
  event.preventDefault();
    
})


function validateZiseFiles(){

var inputFile = document.getElementById('filesMultiple');
var file = inputFile.files;

    var size =0;
    console.log(file);

    for(var i = 0; i < file.length; i ++){

        var filesSize = file[i].size;

        if(size > 5242880){               

            $('.resultados_file').html("<div class='alert alert-danger'>"+
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
                    "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>"+
                    
                "</div>"
            );
        }else{
            $('.resultados_file').html("");
        }

        size+=filesSize;
    }

    if(size > 5242880){ 
        $('.resultados_file').html("<div class='alert alert-danger'>"+
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
                    "<strong>Error! Sorry, but the file size is too large. Select files smaller than 5MB. </strong>"+
                    
                "</div>"
            );

        return true;

    }else{
            $('.resultados_file').html("");

        return false;
    }          

}
</script>

<script>
        
 $('#openMultiFile').click(function(){

    $("#filesMultiple").click();
  });


  $('#clean_file_button').click(function(){

    $("#filesMultiple").val('');

    $('#selectItem').html('Attach files');

    $('#clean_files').addClass('hide');


  });



  $('input[type=file]').change(function(){

    var inputFile = document.getElementById('filesMultiple');
    var file = inputFile.files;
    var contador = 0;
    for(var i=0; i<file.length; i++){

        contador ++;
    }
    if(contador>0){

        $('#clean_files').removeClass('hide');
    }else{

        $('#clean_files').addClass('hide');

    }

    $('#selectItem').html('attached files ('+contador+')');
  });
</script>


    <?php 
    if($core->active_paystack==1){
    ?>

   <!-- ================================================================ -->
                        <!-- PAYSTACK METHOD PAYMENT -->
   <!-- ================================================================ -->

<script>

    const paymentForm = document.getElementById('paymentForm');

    paymentForm.addEventListener("submit", function(event) {

        event.preventDefault();

        let handler = PaystackPop.setup({
        key: '<?php echo $core->public_key_paystack;?>', // Replace with your public key
        email: document.getElementById("email-address").value,
        amount: <?php echo  number_format(($row_order->total_order * 100), 2,'.','');?>,
        firstname: document.getElementById("first-name").value,
        lastname: document.getElementById("last-name").value,
        // currency:'ZAR',
        // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
        // label: "Optional string that replaces customer email"
        onClose: function(){
          // alert('Window closed.');
        },
        callback: function(response){
          addPaymentPaystackSuccess(response);
        }
      });
      handler.openIframe();

    });

</script>


<script type="text/javascript">
    

    function addPaymentPaystackSuccess(details){

        var firstname = document.getElementById("first-name").value;
        var lastname = document.getElementById("last-name").value;

        $.ajax({

            url:'./ajax/customers_packages/add_payment_paystack_method_success_ajax.php?order_id=<?php echo $_GET['id_order'];?>&track_order=<?php echo $track_order; ?>&customer=<?php echo $row_order->sender_id; ?>&firstname='+firstname+'&lastname='+lastname,
            method:'post',
            data: details,                       
            success:function(data){
                
                $('html, body').animate({
                      scrollTop: 0
                }, 600);

                $('#resultados_ajax').html(data);

            }
        })
    }
</script>

<?php                                                              
     }
    ?>

<script type="text/javascript">

    function soloNumeros(e){
    var key = e.charCode;
    return key >= 44 && key <= 57;
}
</script>
   

      <!-- ================================================================ -->
                        <!--END  PAYSTACK METHOD PAYMENT -->
   <!-- ================================================================ -->