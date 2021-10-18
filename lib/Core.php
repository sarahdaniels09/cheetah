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



Class Core {

	
	private  $db;

	function __construct()
      {
		$this->db = new Conexion;
		$this->getSettings();
		  
		  
      }
	        
      /**
       * Core::getSettings()
       */
    private function getSettings(){

      	$this->db->query('SELECT * FROM settings');


	  $this->db->execute();
	  $settings= $this->db->registro();        
	     
	      
    $this->site_name = $settings->site_name;
	  $this->c_nit = $settings->c_nit;
    $this->c_phone = $settings->c_phone;
	  $this->cell_phone = $settings->cell_phone;
	  $this->c_address = $settings->c_address;
	  $this->locker_address = $settings->locker_address;
	  $this->c_country = $settings->c_country;
	  $this->c_city = $settings->c_city;
	  $this->c_postal = $settings->c_postal;
    $this->site_url = $settings->site_url;

    //EMAIL SMTP
	  $this->site_email = $settings->site_email;
    $this->mailer = $settings->mailer;
    $this->smtp_names = $settings->smtp_names;
    $this->email_address = $settings->email_address;
    $this->smtp_host = $settings->smtp_host;
    $this->smtp_user = $settings->smtp_user;
    $this->smtp_password = $settings->smtp_password;
    $this->smtp_port = $settings->smtp_port;
    $this->smtp_secure = $settings->smtp_secure;


	  $this->interms = $settings->interms;
	  $this->signing_customer = $settings->signing_customer;
	  $this->signing_company = $settings->signing_company;
	  $this->logo = $settings->logo;
	  $this->favicon = $settings->favicon;
	  $this->backup = $settings->backup;
	  $this->thumb_w = $settings->thumb_w;
	  $this->thumb_h = $settings->thumb_h;

    //APIS KEY
    $this->paypal_client_id = $settings->paypal_client_id;
    
    $this->public_key_stripe = $settings->public_key_stripe;
	  $this->secret_key_stripe = $settings->secret_key_stripe;


    $this->public_key_paystack = $settings->public_key_paystack;
    $this->secret_key_paystack = $settings->secret_key_paystack;


    $this->twilio_token = $settings->twilio_token;
    $this->twilio_sid = $settings->twilio_sid;
    $this->twilio_number = $settings->twilio_number;
    $this->active_whatsapp = $settings->active_whatsapp;

    $this->active_stripe = $settings->active_stripe;
    $this->active_paypal = $settings->active_paypal;
    $this->active_paystack = $settings->active_paystack;    
    $this->active_attach_proof = $settings->active_attach_proof;


    //CONFIG TAXES
	  $this->version = $settings->version;
	  $this->prefix = $settings->prefix;
	  $this->track_digit = $settings->track_digit;
	  $this->prefix_con = $settings->prefix_con;
	  $this->track_container = $settings->track_container;
	  $this->prefix_consolidate = $settings->prefix_consolidate;
	  $this->track_consolidate = $settings->track_consolidate;


    $this->track_online_shopping = $settings->track_online_shopping;
    $this->prefix_online_shopping = $settings->prefix_online_shopping;

    
	  $this->tax = $settings->tax;
	  $this->insurance = $settings->insurance;
	  $this->value_weight = $settings->value_weight;
	  $this->meter = $settings->meter;
	  $this->c_tariffs = $settings->c_tariffs;

	  $this->currency = $settings->currency;
	  $this->timezone = $settings->timezone;
    $this->language = $settings->language;
    $this->min_cost_tax = $settings->min_cost_tax;

    $this->declared_tax = $settings->declared_tax;
    $this->min_cost_declared_tax = $settings->min_cost_declared_tax;
    
    $this->notify_admin  = $settings->notify_admin;
	  $this->user_limit  = $settings->user_limit;
    $this->reg_allowed = $settings->reg_allowed;

    $this->auto_verify = $settings->auto_verify;
    $this->reg_verify = $settings->reg_verify;
    $this->user_perpage = $settings->user_perpage;



    date_default_timezone_set($this->timezone);

    }





    	/**
       * Core::getCourier_list()
       */
	public function getCourier_list()
	  {
		  
	  $sql = "SELECT a.id, a.qid, a.order_inv, a.r_name, a.r_qnty, a.r_dest, a.r_city, a.country, a.city, a.courier, a.service_options, a.payment_status, a.pay_mode, a.status_novelty, a.created, a.status_courier, a.s_name, a.level, s.mod_style, s.color  FROM add_courier a, styles s WHERE a.status_courier=s.mod_style AND a.act_status='1' AND a.con_status='0' AND a.status_novelty='0' ORDER BY a.qid DESC";


	   $this->db->query($sql);
	   $this->db->execute();

	  return $this->db->registros();
	      
	      

	}



	public function getCourier_list_online()
    {
        $sql = "SELECT * FROM add_courier WHERE status_courier = 'Pending' AND status_novelty='0' LIMIT 10 ";
        $this->db->query($sql);
	   	$this->db->execute();

	  return $this->db->registros();
    }



    public function getcosstotalcourier()
    {
		$courbudget = 0;
		$sql = "SELECT r_costtotal FROM add_courier WHERE act_status = '1' AND con_status= '0' AND payment_status='0' AND status_novelty='0'";

		$this->db->query($sql);
	   	$this->db->execute();
	   	$row =$this->db->registros();
          
        foreach ($row  as $budget){
			return   $courbudget+= $budget->r_costtotal;	
		}  
    }



    public function getcosstotalconsolidate()
    {
		$conbudget = 0;
		$sql = "SELECT r_costtotal FROM consolidate WHERE act_status = '1' AND con_status= '1' AND payment_status='0'";

		$this->db->query($sql);
	   	$this->db->execute();
	   	$row =$this->db->registros();
          
        foreach ($row  as $budget){
			return   $courbudget+= $budget->r_costtotal;	
		}   
    }


 


   	public function getcosstotalconsolidatemonth()
    {
		$month = date('m');
		$year = date('Y'); //2019
		$conbudget = 0;
		$sql = "SELECT r_costtotal FROM consolidate WHERE month(created)='$month' AND year(created)='$year' AND  con_status='1' AND payment_status='0'";

		$this->db->query($sql);
	   	$this->db->execute();
	   	$row =$this->db->registros();
          
        foreach ($row  as $budget){
			return   $courbudget+= $budget->r_costtotal;	
		}   
    }


    /**
       * Core::getZone()
       */
    public function getZone()
    {
        
        $sql = "SELECT * FROM zone ORDER BY zone_name ASC";
        $this->db->query($sql);
	   	$this->db->execute();
	   	$row =$this->db->registros();
          
          return $row;
    }




	  /**
   * Core::getOffices()
   */
	public function getOffices()
	{
	    $sql = "SELECT * FROM offices ORDER BY name_off ASC";


	    $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
          return $row;
	}



	public function getSmstwilio()
    {
    	$sql = "SELECT * FROM textsms  ORDER BY id ASC";
        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }


    public function getSmsnexmo()
    {

    	$sql = "SELECT * FROM textsmsnexmo  ORDER BY id ASC";

        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }

    public function getBranchoffices()
    {
        $sql = "SELECT * FROM branchoffices ORDER BY name_branch ASC";

        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }


    public function getCouriercom()
    {
        $sql = "SELECT * FROM courier_com ORDER BY name_com ASC";

        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }

    /**
       * Core::getStatus()
       */
      public function getStatus()
      {
        $sql = "SELECT * FROM styles ORDER BY mod_style ASC";
        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
      }


      /**
       * Core::getStatus()
       */
      public function getStatusPickup()
      {
        $sql = "SELECT * FROM styles where id !='14' ORDER BY mod_style ASC";
        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
      }


      /**
       * Core::getPack()
       */
    public function getPack()
    {
		$sql = "SELECT * FROM packaging ORDER BY name_pack ASC";
    	$this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }


    /**
       * Core::getPayment()
       */
    public function getPayment()
    {
        $sql = "SELECT * FROM met_payment ORDER BY id ASC";
    	$this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }

        /**
       * Core::getPayment()
       */
    public function getPaymentMethod()
    {
        $sql = "SELECT * FROM payment_methods ORDER BY id ASC";
      $this->db->query($sql);
        $this->db->execute();
      $row =$this->db->registros();
          
        return $row;
    }

     /**
       * Core::getItem()
       */

    public function getItem()
    {
        $sql = "SELECT * FROM category ORDER BY name_item ASC";
        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
    }


     /**
       * Core::getShipmode()
       */
      public function getShipmode()
      {
        $sql = "SELECT * FROM shipping_mode ORDER BY id ASC";

        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;

      }
	  
	  /**
       * Core::getDelitime()
       */
      public function getDelitime()
      {
        $sql = "SELECT * FROM delivery_time ORDER BY id ASC";
        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
      }


     // order_track()
	   
	public function order_track()
		{
			//Prefix tracking	
			$sql = "SELECT * FROM settings";
			
			$this->db->query($sql);
        	$this->db->execute();
	   		$trackd =$this->db->registro();

			$digits = $trackd->track_digit;		

			$this->db->query("SELECT MAX(order_no) AS order_no FROM add_order");
        	$this->db->execute();

			$invNum =$this->db->fetch_assoc();
			$max_id = $invNum['order_no'];
			$cod=$max_id;
			$sig=$cod+1;

			$Strsig = (string)$sig;		
			$formato = str_pad($Strsig, "".$digits."", "0", STR_PAD_LEFT); 

			
				
			return $formato;
		}


      public function consolidate_track()
    {
      //Prefix tracking 
      $sql = "SELECT * FROM settings";
      
      $this->db->query($sql);
          $this->db->execute();
        $trackd =$this->db->registro();

      $digits = $trackd->track_digit;   

      $this->db->query("SELECT MAX(c_no) AS c_no FROM consolidate");
          $this->db->execute();

      $invNum =$this->db->fetch_assoc();
      $max_id = $invNum['c_no'];
      $cod=$max_id;
      $sig=$cod+1;

      $Strsig = (string)$sig;   
      $formato = str_pad($Strsig, "".$digits."", "0", STR_PAD_LEFT); 

      
        
      return $formato;
    }


    public function online_shopping_track()
    {
      //Prefix tracking 
      $sql = "SELECT * FROM settings";
      
      $this->db->query($sql);
          $this->db->execute();
        $trackd =$this->db->registro();

      $digits = $trackd->track_digit;   

      $this->db->query("SELECT MAX(order_no) AS order_no FROM customers_packages");
          $this->db->execute();

      $invNum =$this->db->fetch_assoc();
      $max_id = $invNum['order_no'];
      $cod=$max_id;
      $sig=$cod+1;

      $Strsig = (string)$sig;   
      $formato = str_pad($Strsig, "".$digits."", "0", STR_PAD_LEFT); 

      
        
      return $formato;
    }


		/**
       * Core::getCategories()
       */

      public function getCategories()
      {
        $sql = "SELECT * FROM category ORDER BY id ASC";
        $this->db->query($sql);
        $this->db->execute();
	   	$row =$this->db->registros();
          
        return $row;
      }



      public function getUsersEmployeedAdmin()
      {
        $sql = "SELECT * FROM users where (userlevel=2 or userlevel=9) ORDER BY id ASC";
        $this->db->query($sql);
        $this->db->execute();
      $row =$this->db->registros();
          
        return $row;
      }

      public function getCodeCountries()
      {
        $sql = "SELECT * FROM countries ORDER BY name";
        $this->db->query($sql);
        $this->db->execute();
      $row =$this->db->registros();
          
        return $row;
      }
	  

   
}

