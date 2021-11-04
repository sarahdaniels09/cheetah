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



  class User
  {
	  
	  public $logged_in = null;
	  public $uid = 0;
	  public $userid = 0;
    public $username;
	  public $email;
	  public $name;
    public $userlevel;
	  public $last;

    private $db; 
    private $result; 
    public $sWhere; 
    public $sql;
    public $errors   = array();

    
      function __construct()
      {
		    $this->db = new Conexion;
        $this->startSession();

      }
 

      /**
       * Users::startSession()
       */
      private function startSession()
      {
          if (strlen(session_id()) < 1)
              session_start();

          $this->logged_in = $this->loginCheck();

          if (!$this->logged_in) {
              $this->username = $_SESSION['username'] = "Guest";              
              $this->userlevel = 0;
          }
      }

	  /**
	   * Users::loginCheck()
	   */
      public function loginCheck()
      {
          if (isset($_SESSION['username']) && $_SESSION['username'] != "Guest") {
			  
            $row = $this->getUserInfo($_SESSION['username']);
            $this->uid = $row->id;
            $this->username = $row->username;
		        $this->locker = $row->locker;
		        $this->name_off = $row->name_off;
            $this->email = $row->email;
            $this->name = $row->fname . ' ' . $row->lname;
            $this->userlevel = $row->userlevel;
		        $this->last = $row->lastlogin;
            return true;

          } else {
              return false;
          }
      }

	  /**
	   * Users::is_Admin()
	   */
	  public function is_Admin()
	  {
  		if ($this->userlevel == 9) {	 
  			return($this->userlevel == 9);

  		}else if ($this->userlevel == 2) { 

      			return($this->userlevel == 2);
  		}else {  
        return($this->userlevel == 3);
      }
	  }

	  /**
	   * Users::login()
	   */
	  public function login($username, $pass)
	  {

		  if ($username == "" && $pass == "") {

          $this->errors[] = "Enter a valid username and password.";

		  } else {

			  $status = $this->checkStatus($username, $pass);
			  
        if($status==0) {
            
            $this->errors[] = 'The login and / or password do not match the database.';
               
        }else if($status==2){

            $this->errors[] = 'Your account is not activated.';                 
        }

		  }


      if ($status == 1) {

        $user = $this->getUserInfo($username);

        $this->uid = $_SESSION['userid'] = $user->id;
        $this->username = $_SESSION['username'] = $user->username;
        $this->email = $_SESSION['email'] = $user->email;
        $this->name_off = $_SESSION['name_off'] = $user->name_off;
        $this->name = $_SESSION['name'] = $user->fname . ' ' . $user->lname;
        $this->userlevel = $_SESSION['userlevel'] = $user->userlevel;
        $this->last = $_SESSION['last'] = $user->lastlogin;

			 $this->db->query('UPDATE users SET  lastlogin=:lastlogin, lastip=:lastip where username=:user');

                        $this->db->bind(':lastlogin', date("Y-m-d H:i:s"));
                        $this->db->bind(':lastip', trim($_SERVER['REMOTE_ADDR']));
                        $this->db->bind(':user', $username);

                        $this->db->execute();
			  return true;
		  }
	  }


        /**
     * Users::checkStatus()
     */
      public function checkStatus($username, $password)
      {

          $username = trim($username);         
          $password = trim($password);

          $this->db->query('SELECT * FROM users WHERE username=:user OR email=:user');

          $this->db->bind(':user', $username);

          $this->db->execute();
          $user= $this->db->registro();
          $numrows= $this->db->rowCount();

          if ($numrows== 1) {
                   
            if (password_verify($password, $user->password)) {

                if ($user->active==1) {                  
                      return 1;                    

                }else{
                      return 2;
                }  
                                      
            }else{

              return 0;
            }         

          }else{

            return 0;
          }       
      }

      /**
       * Users::logout()
       */
      public function logout()
      {
          unset($_SESSION['username']);
		  unset($_SESSION['email']);
		  unset($_SESSION['name']);
          unset($_SESSION['userid']);
          session_destroy();
          
          $this->logged_in = false;
          $this->username = "Guest";
          $this->userlevel = 0;
      }

	  /**
	   * Users::getUserInfo()
	   */
      private function getUserInfo($username)
      {
          $username = trim($username);

          $this->db->query('SELECT * FROM users WHERE username=:user OR email=:user');

          $this->db->bind(':user', $username);

          $this->db->execute();
          return $user= $this->db->registro();          
      }
	  
	  
	  /**
       * Core::getCourier Online Booking()
       */
      public function getCourier_list_booking()
      {
		  $sql = "SELECT a.id, a.order_inv, a.r_name, a.c_driver, a.r_address, a.r_dest, a.r_city, a.r_curren, a.r_costtotal, a.r_description,  a.total_insurance, a.total_tax, a.payment_status, a.pay_mode, a.created, a.r_hour, a.status_courier, a.act_status, a.status_prealert, a.con_status, s.mod_style, s.color  FROM add_courier a, styles s  WHERE a.status_courier=s.mod_style AND a.username = '".$this->username."'   AND a.status_courier!='Delivered' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getCourier Online Booking delivered()
       */
      public function getCourier_list_booking_delivered()
      {
		  $sql = "SELECT a.id, a.order_inv, a.r_name, a.c_driver, a.r_address, a.r_dest, a.r_city, a.r_curren, a.r_costtotal, a.r_description,  a.total_insurance, a.total_tax, a.payment_status, a.pay_mode, a.created, a.r_hour, a.status_courier, a.act_status, a.con_status, s.mod_style, s.color  FROM add_courier a, styles s  WHERE a.status_courier=s.mod_style AND a.username = '".$this->username."'   AND a.status_courier='Delivered' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
       * Core::getCourier Online Booking()
       */
      public function getCourier_list_bookingpre()
      {
		  $sql = "SELECT a.id, a.order_inv, a.r_name, a.c_driver, a.r_address, a.r_dest, a.r_city, a.r_description, a.r_curren, a.r_costtotal, a.total_insurance, a.total_tax, a.payment_status, a.pay_mode, a.created, a.r_hour, a.status_courier, a.status_prealert, a.act_status, a.con_status, s.mod_style, s.color  FROM add_courier a, styles s  WHERE a.status_prealert=s.mod_style AND a.username = '".$this->username."' AND a.act_status=0   ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
       * Core::getCourier Online Deliveries list()
       */
      public function getCourier_deliveries_list()
      {
          $sql = "SELECT a.id, a.order_inv, a.c_driver, a.r_address, a.created, a.r_hour, a.status_courier, a.act_status, s.mod_style, s.color  FROM consolidate a, styles s  WHERE a.status_courier=s.mod_style AND a.c_driver = '".$this->username."' AND a.act_status=1  ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getDeliver Package list()
       */
      public function getPickupspackage_list()
      {
          $sql = "SELECT a.id, a.order_inv, a.c_driver, a.r_addresspickup, a.created, a.r_hour, a.status_courier, a.id_pickup, a.status_pickup, s.mod_style, s.color  FROM add_courier a, styles s  WHERE a.status_courier=s.mod_style AND a.c_driver = '".$this->username."' AND a.id_pickup=1 AND a.status_pickup=1 ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	 
	  /**
       * Core::getDeliver Package list()
       */
      public function getDeliverpackage_list()
      {
          $sql = "SELECT a.id, a.qid, a.order_inv, a.r_qnty, a.c_driver, a.r_address, a.r_name, a.rc_phone, a.r_costtotal, a.created, a.r_hour, a.status_courier, a.act_status, a.con_status, a.id_pickup, b.id_add, b.detail_description, s.mod_style, s.color  FROM add_courier a, detail_addcourier b, styles s  WHERE a.qid=b.id_add AND a.status_courier=s.mod_style AND a.c_driver = '".$this->username."' AND a.act_status=1 AND a.con_status=0  ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getQuote_list()
       */
      public function getQuotes_list()
      {
		  
	  $sql = "SELECT a.id, a.order_quote, a.idquote, a.locker, a.s_name, a.phone, a.r_dest, a.r_city, a.created, a.status_quote, a.url_product, a.price_product, a.your_purchase, a.your_quote, a.r_costotal, s.mod_style, s.color, a.username FROM quote a, styles s WHERE a.username = '".$this->username."' AND a.status_quote=s.mod_style AND (a.idquote='1' OR a.idquote='2' OR a.idquote='3')  ORDER BY a.id DESC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;

      }
	  
	  
	  /**
       * Core::getQuoteapproved_history()
       */
      public function getQuoteapproved_history()
      {
		  
	  $sql = "SELECT a.id, a.order_quote, a.idquote, a.locker, a.s_name, a.phone, a.r_dest, a.r_city, a.created, a.status_quote, a.url_product, a.your_purchase, a.your_quote, a.r_costotal, a.price_product, s.mod_style, s.color, a.username FROM quote a, styles s WHERE a.username = '".$this->username."' AND a.status_quote=s.mod_style AND (a.idquote='3' OR a.idquote='4') ORDER BY a.id DESC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;

      }
	  
	  
	  	  /**
       * Core::getCourieremployee_list()
       */
      public function getCourieremployee_list()
      {
		  
	       $sql = "SELECT a.id, a.qid, a.order_inv, a.r_name, a.r_qnty, a.r_dest, a.r_city, a.country, a.city, a.courier, a.service_options, a.payment_status, a.pay_mode, a.created, a.status_courier, a.s_name, a.level, a.origin_off, s.mod_style, s.color  FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style AND a.act_status='1' AND a.con_status='0'  ORDER BY a.qid DESC";
         
          $this->db->query($sql);
          $this->db->execute();

          return $this->db->registros();

      }
	  
	  /**
       * Core::getPickupemployee_list()
       */
      public function getPickupemployee_list()
      {
		  
	  $sql = "SELECT a.id, a.order_inv, a.r_qnty, a.country, a.city, a.r_addresspickup,  a.created, a.status_courier, a.s_name, a.id_pickup, a.c_driver, a.collection_courier, a.level, s.mod_style, s.color, a.username, a.c_driver, a.origin_off  FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style AND a.id_pickup='1' ORDER BY a.id DESC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;

      }
	  
	  /**
       * Core::getPrealertemployee_list()
       */
      public function getPrealertemployee_list()
      {
		  
	  $sql = "SELECT a.id, a.order_inv, a.order_purchase, a.r_qnty, a.country, a.city, a.courier,  a.created, a.status_courier, a.s_name, a.r_description, a.c_driver, a.supplier, a.package_invoice, a.level, a.origin_off, s.mod_style, s.color, a.username, a.c_driver  FROM add_courier a, styles s WHERE  a.status_courier=s.mod_style AND a.act_status='0' ORDER BY a.id DESC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;

      }
	  
	  
	   /**
       * Core::getContainerlineemployee()
       */
      public function getContainerlineemployee()
      {
          $sql = "SELECT a.id, a.idcon, a.order_inv, a.r_name, a.origin_port, a.status_courier, a.created, a.r_hour, a.destination_port, a.courier, a.payment_status, a.username, a.level, a.origin_off, s.mod_style, s.color FROM add_container a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style AND a.act_status='3'  ORDER BY a.id DESC";
          $row = self::$db->fetch_all($sql);
          return ($row) ? $row : 0;
      }
	  
	   /**
       * Core::getConsolidateemployee_list()
       */
      public function getConsolidateemployee_list()
      {
		  
	  $sql = "SELECT a.id, a.order_inv, a.r_name, a.r_dest, a.r_address, a.r_qnty, a.r_weight, a.c_driver, a.created, a.status_courier, a.code_off, a.act_status, a.consol_tid, a.level, s.mod_style, s.color, b.order_inv, b.n_trackc, b.consol_tid  
			  FROM consolidate a, styles s, add_courier b WHERE a.code_off='".$this->name_off."' AND  a.status_courier=s.mod_style AND a.consol_tid=b.consol_tid AND a.act_status='1' AND a.con_status='1' ORDER BY a.id DESC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0; 

      }
	  
	  /**
       * Core::getAllshipemployee()
       */
      public function getAllshipemployee()
      {
          $sql = "SELECT a.id, a.order_inv, a.s_name, a.email, a.status_courier, a.created, a.r_hour, a.r_costtotal, a.total_tax, a.total_insurance, a.level, a.origin_off, s.mod_style, s.color FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style  AND a.act_status='1' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
       * Core::getPendingshipemployee()
       */
      public function getPendingshipemployee()
      {
          $sql = "SELECT a.id, a.order_inv, a.s_name, a.email, a.status_courier, a.r_costtotal, a.total_tax, a.total_insurance, a.level, a.origin_off, s.mod_style, s.color FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style  AND a.status_courier='Pending' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	   /**
       * Core::getRejectedshipemployee()
       */
      public function getRejectedshipemployee()
      {
          $sql = "SELECT a.id, a.order_inv, a.s_name, a.email, a.status_courier, a.reasons, a.level, a.origin_off, s.mod_style, s.color FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style  AND a.status_courier='Rejected' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getPREALERTshipemployee()
       */
      public function getPREALERTshipemployee()
      {
          $sql = "SELECT a.id, a.order_inv, a.order_purchase, a.s_name, a.email, a.supplier, a.r_description, a.r_custom, a.courier, a.status_courier, a.created, a.r_hour, a.r_costtotal, a.total_tax, a.total_insurance, a.level, a.origin_off, s.mod_style, s.color FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style  AND a.status_prealert='Pre Alert' AND act_status=1 ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getDeliveredshipemployee()
       */
      public function getDeliveredshipemployee()
      {
          $sql = "SELECT a.id, a.order_inv, a.s_name, a.email, a.deliver_date, a.delivery_hour, a.name_employee, a.status_courier, a.r_costtotal, a.total_tax, a.total_insurance, a.level, a.origin_off, s.mod_style, s.color FROM add_courier a, styles s WHERE a.origin_off='".$this->name_off."' AND a.status_courier=s.mod_style  AND a.status_courier='Delivered' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getDeliveredshipdriver()
       */
      public function getDeliveredshipdriver()
      {
          $sql = "SELECT a.id, a.order_inv, a.s_name, a.email, a.deliver_date, a.delivery_hour, a.name_employee, a.c_driver, a.status_courier, a.r_costtotal, a.total_tax, a.total_insurance, a.level, a.origin_off, a.person_receives, s.mod_style, s.color FROM add_courier a, styles s WHERE a.c_driver = '".$this->username."' AND a.status_courier=s.mod_style  AND a.status_courier='Delivered' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getDeliveredconsolemployee()
       */
      public function getDeliveredconsolemployee()
      {
          $sql = "SELECT a.id, a.order_inv, a.r_name, a.r_email, a.comments, a.deliver_date, a.delivery_hour, a.name_employee, a.status_courier, a.r_costtotal, a.level, a.code_off, s.mod_style, s.color FROM consolidate a, styles s WHERE a.code_off='".$this->name_off."' AND a.status_courier=s.mod_style  AND a.status_courier='Delivered' ORDER BY a.id ASC";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  
	   /**
       * Core::getConsolidateonline_liste()
       */
      public function getConsolidateonline_list()
      {
		  
	  $sql = "SELECT a.id, a.order_inv, a.consol_tid,a.r_name, a.r_dest, a.username,a.r_address, a.r_qnty, a.pay_mode, a.payment_status, a.r_costtotal, a.r_weight, a.c_driver,a.created, a.status_courier, a.code_off, a.act_status, a.comments, s.mod_style, s.color, b.consol_tid 
			  FROM consolidate a, styles s, add_courier b WHERE a.status_courier=s.mod_style AND a.consol_tid=b.consol_tid AND a.username='" .  $this->username  . "' GROUP BY a.tracking";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;

      }
	  
	  	/**
       * Core::cost total client dashboard()
       */
      public function getcosstotalcourier()
      {
		 $courbudget = 0;
		$sql = "SELECT r_costtotal,total_insurance,total_tax FROM " . self::cTable . " WHERE act_status = '1' AND con_status= '0' AND payment_status='0' AND username='" .  $this->username  . "'";
		$row = self::$db->fetch_all($sql);
          
         foreach ($row  as $budget){
			return   $courbudget+= $budget->r_costtotal;	
			}  
      }
	  
	  public function getcosstotalconsolidate()
      {
		 $conbudget = 0;
		$sql = "SELECT r_costtotal FROM " . self::consolTable . " WHERE act_status = '1' AND con_status= '1' AND payment_status='0' AND username='" .  $this->username  . "'";
		$row = self::$db->fetch_all($sql);
          
         foreach ($row  as $budgets){
			return   $conbudget+= $budgets->r_costtotal;	
			}  
      }
	  
	  
	  public function getcosstotalcourierpay()
      {
		 $courbudgets = 0;
		$sql = "SELECT r_costtotal FROM " . self::cTable . " WHERE act_status = '1' AND con_status= '1' AND payment_status='1' AND username='" .  $this->username  . "'";
		$row = self::$db->fetch_all($sql);
          
         foreach ($row  as $budgett){
			return   $courbudgets+= $budgett->r_costtotal;	
			}  
      }
	  
	  public function getcosstotalconsolidatepay()
      {
		 $conbudgetx = 0;
		$sql = "SELECT r_costtotal FROM " . self::consolTable . " WHERE act_status = '1' AND con_status= '1' AND payment_status='1' AND username='" .  $this->username  . "'";
		$row = self::$db->fetch_all($sql);
          
         foreach ($row  as $budgetx){
			return   $conbudgetx+= $budgetx->r_costtotal;	
			}  
      }


	  
	  /**
       * Core::getCount()
       */
      public function getCounton()
      {
		  $pager->items_total = countEntries(self::cTable);
          $sql = "SELECT COUNT(id) as total FROM add_courier WHERE username = '" . $username . "'";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Core::getCourierlist_user()
       */
      public function getCourierlist_user()
      {
		  
	  $sql = "SELECT a.id, a.order_inv, a.r_name, a.username, a.r_qnty, a.itemcat, a.r_description, a.total_insurance, a.total_tax, a.created, a.status_courier, a.v_weight, a.r_weight, a.pay_mode, a.r_costtotal, u.username, u.id, u.fname, u.lname 
			 FROM add_courier a, users u WHERE a.username=u.username AND u.id= ".Filter::$id."  ORDER BY s_name ASC";
        $row = self::$db->fetch_all($sql);
          
        return ($row) ? $row : 0;

      }
	  

	  
	  /**
	   * Users::getUserData()
	   */
	  public function getUserData()
	  {

      $this->db->query("SELECT *,
                       DATE_FORMAT(created, '%a. %d, %M %Y') as cdate,
                        DATE_FORMAT(lastlogin, '%a. %d, %M %Y') as ldate
                       FROM users WHERE id=:uid");

          $this->db->bind(':uid', $this->uid);

          $this->db->execute();
          return $user= $this->db->registro();        
	  }
	  	  	  	  
	  /**
	   * Users::usernameExists()
	   */
	  public function usernameExists($username)
	  {
          $username = trim($username);
          if (strlen($username) < 4)
              return 1;

          //Username should contain only alphabets, numbers, underscores or hyphens.Should be between 4 to 15 characters long
		  $valid_uname = "/^[a-z0-9_-]{4,55}$/"; 
          if (!preg_match($valid_uname, $username))
              return 2;

          $this->db->query("SELECT username from users where username = :user LIMIT 1");

          $this->db->bind(':user', $username);

          $this->db->execute();

          return $numrows= $this->db->rowCount();        
	  }  	
	  
	  /**
	   * User::emailExists()
	   */
	  public function emailExists($email, $id=null)
	  {
		  
      $where='';
      if($id!=null){

        $where="and id!='$id'";
      }

      $this->db->query("SELECT email from users where email = :email $where LIMIT 1");

      $this->db->bind(':email', trim($email));

      $this->db->execute();
        

      if ($this->db->rowCount() == 1) {
          return true;
      } else{

          return false;
      }
	  }


    public function emailExistsRecipients($email, $id=null)
    {
      
      $where='';
      if($id!=null){

        $where="and id!='$id'";
      }

      $this->db->query("SELECT email from recipients where email = :email $where LIMIT 1");

      $this->db->bind(':email', trim($email));

      $this->db->execute();
        

      if ($this->db->rowCount() == 1) {
          return true;
      } else{

          return false;
      }
    }
	  
	  
	  /**
	   * User::enrollmentExists()
	   */
	  private function enrollmentExists($enrollment)
	  {
		  
          $sql = self::$db->query("SELECT enrollment" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE enrollment = '" . sanitize($enrollment) . "'" 
		  . "\n LIMIT 1");

          if (self::$db->numrows($sql) == 1) {
              return true;
          } else
              return false;
	  }
	  
	  /**
	   * User::vehiclecodeExists()
	   */
	  private function vehiclecodeExists($vehiclecode)
	  {
		  
          $sql = self::$db->query("SELECT vehiclecode" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE vehiclecode = '" . sanitize($vehiclecode) . "'" 
		  . "\n LIMIT 1");

          if (self::$db->numrows($sql) == 1) {
              return true;
          } else
              return false;
	  }
	  
	  /**
	   * User::isValidEmail()
	   */
	  public function isValidEmail($email)
	  {
		  if (function_exists('filter_var')) {
			  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  return true;
			  } else
				  return false;
		  } else
			  return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
	  } 	

      /**
       * User::validateToken()
       */
     private function validateToken($token)
      {
          $token = sanitize($token, 40);
          $sql = "SELECT token" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE token ='" . self::$db->escape($token) . "'" 
		  . "\n LIMIT 1";
          $result = self::$db->query($sql);

          if (self::$db->numrows($result))
              return true;
      }
	  
	  /**
	   * Users::getUniqueCode()
	   */
	  private function getUniqueCode($length = "")
	  {
		  $code = md5(uniqid(rand(), true));
		  if ($length != "") {
			  return substr($code, 0, $length);
		  } else
			  return $code;
	  }

	  /**
	   * Users::generateRandID()
	   */
	  private function generateRandID()
	  {
		  return md5($this->getUniqueCode(24));
	  }

	  /**
	   * Users::levelCheck()
	   */
	  public function levelCheck($levels)
	  {
		  $m_arr = explode(",", $levels);
		  reset($m_arr);
		  
		  if ($this->logged_in and in_array($this->userlevel, $m_arr))
		  return true;
	  }
	  
      /**
       * Users::getUserLevels()
       * 
       * @return
       */
      public function getUserLevels($level = false)
	  {
		  $arr = array(
				 9 => 'Super Admin',
				 2 => 'Registered Manager'
		  );
		  
		  $list = '';
		  foreach ($arr as $key => $val) {
				  if ($key == $level) {
					  $list .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $list .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $list;
	  } 
	  
	  public function getCustomerLevels($level = false)
	  {
		  $arr = array(
				 1 => 'Registered Customer'
		  );
		  
		  $list = '';
		  foreach ($arr as $key => $val) {
				  if ($key == $level) {
					  $list .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $list .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $list;
	  } 
	  
	   public function getDriverLevels($level = false)
	  {
		  $arr = array(
				 3 => 'Registered Driver'
		  );
		  
		  $list = '';
		  foreach ($arr as $key => $val) {
				  if ($key == $level) {
					  $list .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $list .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $list;
	  } 
	  	  	  
	  	  	  
      /**
       * Users::getUserFilter()
       */
      public static function getUserFilter()
	  {
		  $arr = array(
				 'username-ASC' => 'Username &uarr;',
				 'username-DESC' => 'Username &darr;',
				 'fname-ASC' => 'First Name &uarr;',
				 'fname-DESC' => 'First Name &darr;',
				 'lname-ASC' => 'Last Name &uarr;',
				 'lname-DESC' => 'Last Name &darr;',
				 'email-ASC' => 'Email Address &uarr;',
				 'email-DESC' => 'Email Address &darr;',
				 'created-ASC' => 'Registered &uarr;',
				 'created-DESC' => 'Registered &darr;',
		  );
		  
		  $filter = '';
		  foreach ($arr as $key => $val) {
				  if ($key == get('sort')) {
					  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $filter .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $filter;
	  } 	  	  	  	   
  // used All Drivers
  public function userAllDriver(){

      // query to select all user records
      $sql = "SELECT * FROM users WHERE userlevel='3' AND active='1'";

      $this->db->query($sql);
      $this->db->execute();
      $row =$this->db->registros();
          
      return $row;
  }
}


?>