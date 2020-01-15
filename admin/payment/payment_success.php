<?php
require_once("../_config/config.php");
require_once("../include/functions.php");

$item_number = $_REQUEST['item_number'];
$amt = $_REQUEST['amt'];
if($item_number && $amt>0) {
	$query=mysqli_query($db,"UPDATE `orders` SET `transaction_id`='".$_REQUEST['tx']."', is_payment_sent='1' WHERE order_id='".$item_number."'");
	header('Location: /admin/edit_order.php?order_id='.$item_number);
}
exit();
?>