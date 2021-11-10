<?php
	ob_start();
	$conn = mysqli_connect("localhost","xckatgkxwn","Rr3PsE2DuD","xckatgkxwn");

	// Check connection
	if(mysqli_connect_errno($conn)){
	  	echo "Failed to connect to MySQL: " . mysqli_connect_error($con);
	}
	
	// $requests = $_GET;
	// $hmac = $_GET['hmac'];
	// $serializeArray = serialize($requests);
	// $requests = array_diff_key($requests, array('hmac' => ''));
	// ksort($requests);

	$shop_details = mysqli_query($conn,"SELECT * FROM `shopify_profile`") or die(mysqli_error($conn));
	$shop_details = mysqli_fetch_assoc($shop_details);

	$token = $shop_details['token'];
	$shop = $shop_details['shop'];
?>