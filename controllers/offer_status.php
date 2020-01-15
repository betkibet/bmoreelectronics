<?php
if($url_second_param && $url_third_param) {
	$query = mysqli_query($db,"UPDATE `orders` SET `offer_status`='".$url_third_param."' WHERE order_id='".$url_second_param."'");
	if($query=='1' && $url_third_param=="offer_accepted") {
		$msg = "Successfully accepted your offer.";
		setRedirectWithMsg(SITE_URL.'account',$msg,'success');
	} elseif($query=='1' && $url_third_param=="offer_rejected") {
		$msg = "Your offer rejected.";
		setRedirectWithMsg(SITE_URL.'account',$msg,'success');
	} else {
		$msg = "Sorry, something went wrong";
		setRedirectWithMsg(SITE_URL,$msg,'error');
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
}
exit();
?>