<?php
$order_id = $_REQUEST['order_id'];
if($order_id) {
	header('Location: /admin/edit_order.php?order_id='.$order_id);
}
exit();
?>