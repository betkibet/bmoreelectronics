<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

// PayPal settings
$return_url = ADMIN_URL.'payment/payment_success.php';
$cancel_url = ADMIN_URL.'payment/payment_cancel.php?order_id='.$_REQUEST['item_number'];
$notify_url = ADMIN_URL.'payment/payments.php';

// Include Functions
include("functions.php");

// Check if paypal request or response
if(!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
	$item_name = 'Mobile Models';
	
    $querystring = '';
    $querystring .= "?item_name=".urlencode($item_name)."&";
 
    //loop for posted values and append to querystring
    foreach($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $querystring .= "$key=$value&";
    }
 
    // Append paypal return addresses
    $querystring .= "return=".urlencode(stripslashes($return_url))."&";
    $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
    $querystring .= "notify_url=".urlencode($notify_url)."&";
	//$querystring .= "image_url=".urlencode($image);
 
    // Append querystring with custom field
    //$querystring .= "&custom=".USERID;
 
    // Redirect to paypal IPN
    header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
    exit();
} else {
   // Response from PayPal
}
?>