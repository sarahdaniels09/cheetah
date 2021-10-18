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




	require_once ("../loader.php");

	$db = new Conexion;

	$search = trim($_REQUEST['track']);


	$sql = "SELECT order_no FROM customers_packages WHERE order_no = '".$search."'";
	
    $db->query($sql);   		
  	$db->execute();
	
    $data= $db->registro();

    if($data){

    	echo json_encode(true);
    }else{

    	echo json_encode(false);
    }