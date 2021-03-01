<?php
$meta_title = "Complete Order";

//Header section
include("include/header.php");

//Get order id
$order_id = $_SESSION['tmp_order_id'];
if(!$order_id) {
	setRedirect(SITE_URL);
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);
$access_token = $order_data['access_token'];

if(empty($choosed_sales_pack_array)) {
	$choosed_sales_pack_array = array();
}

$num_of_sales_pack = count($choosed_sales_pack_array);

$promocode_sys_msg = "";
if(isset($_SESSION['promocode_sys_msg'])) {
	$promocode_sys_msg = $_SESSION['promocode_sys_msg'];
	unset($_SESSION['promocode_sys_msg']);
}

$o_page_type = "";
if($order_data['sales_pack'] == "post_me_a_prepaid_label" || $order_data['sales_pack'] == "print_a_prepaid_label" || $order_data['sales_pack'] == "use_my_own_courier") {
	$o_page_type = "mail_in";
} elseif($order_data['sales_pack'] == "store") {
	$o_page_type = "drop_by";
} elseif($order_data['sales_pack'] == "starbucks" || $order_data['sales_pack'] == "we_come_for_you") {
	$o_page_type = "meet_up";
}
$order_complete_page_data = get_order_complete_page_data($o_page_type);

$success_page_content = json_decode($order_complete_page_data['content_fields'],true);
//$success_page_content = json_decode($general_setting_data['success_page_content'],true);
if(empty($success_page_content['heading'])) {
	$success_page_content['heading'] = '';
}
if(empty($success_page_content['sub_heading'])) {
	$success_page_content['sub_heading'] = '';
}
if(empty($success_page_content['intro_text'])) {
	$success_page_content['intro_text'] = '';
}
if(empty($success_page_content['step_heading'])) {
	$success_page_content['step_heading'] = '';
}
if(empty($success_page_content['step_sub_heading'])) {
	$success_page_content['step_sub_heading'] = '';
}
if(empty($success_page_content['step1_title'])) {
	$success_page_content['step1_title'] = '';
}
if(empty($success_page_content['step1_instruction'])) {
	$success_page_content['step1_instruction'] = '';
}
if(empty($success_page_content['step2_title'])) {
	$success_page_content['step2_title'] = '';
}
if(empty($success_page_content['step2_instruction'])) {
	$success_page_content['step2_instruction'] = '';
}
if(empty($success_page_content['step3_title'])) {
	$success_page_content['step3_title'] = '';
}
if(empty($success_page_content['step3_instruction'])) {
	$success_page_content['step3_instruction'] = '';
}

$heading_text = $success_page_content['heading'];
$sub_heading_text = $success_page_content['sub_heading'];
$intro_text = $success_page_content['intro_text'];
$step_heading_text = $success_page_content['step_heading'];
$step_sub_heading_text = $success_page_content['step_sub_heading'];
$step1_title_text = $success_page_content['step1_title'];
$step1_instruction_text = $success_page_content['step1_instruction'];
$step2_title_text = $success_page_content['step2_title'];
$step2_instruction_text = $success_page_content['step2_instruction'];
$step3_title_text = $success_page_content['step3_title'];
$step3_instruction_text = $success_page_content['step3_instruction'];
?>

<section>
<div class="container-fluid">
  <div class="row">
   <div class="col-md-12">
	  <div class="block setting-page py-0 clearfix">
		<div class="row">
		   <div class="col-md-6 order-md-2">
			 <div class="block heading shipping-heading page-heading">
			   <?php
			   if($heading_text) {
			   	   echo '<h3>'.nl2br($heading_text).'</h3>';
			   } ?>
			 </div>
			 <div class="block shipping-info">
				<?php
				if($sub_heading_text) {
					echo '<p>'.str_replace('${order_id}','<span>'.$order_id.'</span>',nl2br($sub_heading_text)).'</p>';
				}

				$shipment_label_d_url = '';
				$shipment_label_url = $order_data['shipment_label_url'];
				if($order_data['sales_pack']=="print_a_prepaid_label" && $shipment_label_url!="") {
					$shipment_label_d_url = SITE_URL.'controllers/download.php?download_link='.$shipment_label_url; ?>
					<p>USPS <span># <?=$order_data['shipment_tracking_code']?></span></p>
				<?php
				} elseif($order_data['sales_pack']=="print_a_prepaid_label" && $shipment_label_url=="" && $shipping_option['print_a_prepaid_label'] == "print_a_prepaid_label") { ?>
					<p><div class="alert alert-info alert-dismissable">Unable to create shipment, one or more parameters were invalid.</div></p>
				<?php
				}
				if($promocode_sys_msg) { ?>
					<p><div class="alert alert-info alert-dismissable"><?=$promocode_sys_msg?></div></p>
				<?php
				}
				if($intro_text) {
			   	   echo '<p>'.nl2br($intro_text).'</p>';
			    }
				if($show_cust_delivery_note == '1') { ?>
					<a class="btn btn-primary btn-lg rounded-pill mb-3" href="javascript:open_window('<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id.'&access_token='.$access_token?>')">Delivery Note <i class="ion ion-md-download"></i></a>
				<?php
				}
				if($show_cust_order_form == '1') { ?>
					<a class="btn btn-primary btn-lg rounded-pill mb-3" href="<?=SITE_URL?>pdf/order-<?=$order_id?>.pdf" target="_blank">Packing Slip <i class="ion ion-md-download"></i></a>
				<?php
				}
				if($show_cust_sales_confirmation == '1') { ?>
					<a class="btn btn-primary btn-lg rounded-pill mb-3" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank">Receipt <i class="ion ion-md-download"></i></a>
				<?php
				} ?>
			 </div>
			 <div class="text-center pb-5 pt-5 d-md-none">
			   <a href="<?=SITE_URL?>#category-section" class="btn btn-primary btn-lg rounded-pill">Place another order</a>
			 </div>
		   </div>
		   <div class="col-md-6 order-md-1">
			 <div class="block shipping-head-img text-center">
			   <img src="<?=SITE_URL?>images/icons/success.png" alt="">
			 </div>
		   </div>
		</div>
		<div class="row d-none d-md-block">
		  <div class="col-md-12 pt-5 text-center">
			<a href="<?=SITE_URL?>#category-section" class="btn btn-primary btn-lg rounded-pill">Place another order</a>
		  </div>
		</div>
		<div class="row">
		  <div class="col-md-12">
			<div class="block heading page-heading shipping-step-heading text-center">
				<?php
				if($step_heading_text) {
					echo '<h3>'.nl2br($step_heading_text).'</h3>';
				}
				if($step_sub_heading_text) {
					echo '<h4>'.nl2br($step_sub_heading_text).'</h4>';
				} ?>
			</div>
		  </div>
		</div>
		<div class="row justify-content-center">
		  <div class="col-md-12">
			<div class="block shipping-step">
			  <div class="row">
				<div class="col-md-3 d-none d-lg-block text-center">
				  <img src="<?=SITE_URL?>images/icons/prepare_device.png" alt="">
				</div>
				<div class="col-md-12 col-lg-9 text-content">
				  <div class="step-number d-lg-none">
					<div>
					  <span class="text">1</span>
					</div>
				  </div>
				  <h4 class="clearfix">
				  	<img class="d-lg-none" src="<?=SITE_URL?>images/icons/prepare_device.png" alt="">
					<?php
					if($step1_title_text) {
						echo '<span>'.nl2br($step1_title_text).'</span>';
					} ?>
				  </h4>
				  <?php
				  if($step1_instruction_text) {
					echo '<p>'.nl2br($step1_instruction_text).'</p>';
				  } ?>
				</div>
			  </div>
			  <div class="row">
				<div class="col-md-12 col-lg-9 text-content">
				   <div class="step-number d-lg-none">
					 <div>
					   <span class="text">2</span>
					 </div>
				   </div>
				  <h4 class="clearfix">
				  	<img class="d-lg-none" src="images/icons/success_package.png" alt="">
					<?php
					if($step2_title_text) {
						echo '<span>'.nl2br($step2_title_text).'</span>';
					} ?>
				  </h4>
				  <?php
				  if($step2_instruction_text) {
					echo '<p>'.nl2br($step2_instruction_text).'</p>';
				  } ?>
				</div>
				<div class="col-md-3 text-center d-none d-lg-block">
				  <img src="<?=SITE_URL?>images/icons/success_package.png" alt="">
				</div>
			  </div>
			  <div class="row">
				<div class="col-md-3  d-none d-lg-block text-center">
				  <img src="<?=SITE_URL?>images/icons/print_label.png" alt="">
				</div>
				<div class="col-md-12 col-lg-9 text-content">
				  <div class="step-number d-lg-none">
					<div>
					  <span class="text">3</span>
					</div>
				  </div>
				  <h4 class="clearfix">
				  	<img class="d-lg-none" src="<?=SITE_URL?>images/icons/print_label.png" alt="">
					<?php
					if($step3_title_text) {
						echo '<span>'.nl2br($step3_title_text).'</span>';
					} ?>
				  </h4>
				  <?php
				  if($step3_instruction_text) {
					echo '<p>'.str_replace('${download_pdf_lebal_link}',$shipment_label_d_url,nl2br($step3_instruction_text)).'</p>';
				  } ?>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
   </div>
  </div>
</div>
</section>

<script language="javascript" type="text/javascript">
function open_window(url) {
	window.open(url,"Loading",'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=1000, height=800');
}
</script>