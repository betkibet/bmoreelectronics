<?php 
$file_name="mobile_bulk_upload";

//Header section
require_once("include/header.php");

$id = $post['id'];

/*if($id<=0 && $prms_model_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_model_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}*/

$step_track = $_SESSION['step_track'];

//Fetch signle editable model data
$m_q = mysqli_query($db,"SELECT b.id, a.title, b.carrier_title, b.storage_capacity, b.offer_new, b.offer_mint, b.offer_fair, b.offer_broken, b.offer_damaged
FROM mobile a, reference_prices b WHERE a.id = b.mobile_id and  b.id = '".$id."'");
$row_pro = mysqli_fetch_assoc($m_q);
//$rrr = explode(",",$row_pro['cstm_group_id']);

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand ORDER BY id ASC');
?>

<link href="plugins/nestable/jquery.nestable.css" rel="stylesheet" />
<style type="text/css">
.ui-state-default{
	background: inherit;
    list-style: none;
    border: none;
}
#sortable_1 {
	margin:0px;
	padding:0px;
}
.nav.nav-pills .nav-item {
	margin-left:0px !important;
}
</style>

<?php
//Template file
require_once("views/bulk_add_product.php");

//Footer section
unset($_SESSION['step_track']);
require_once("include/footer.php"); ?>
