<?php
//Url param
$order_id=$url_second_param;

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_detail = get_order_data($order_id);
if($user_id!=$order_detail['user_id']) {
	setRedirect(SITE_URL);
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);

if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_detail['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_detail['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_detail['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
} ?>

<!-- Main -->
<div id="main">
	<section id="printorder_page" class="sectionbox white-bg">
	  <div class="wrap clearfix">
			<div id="sidebar_profile">
				<div class="profile_pic clearfix">
					<div class="inner">
						<?php
						if($user_data['image']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/avatar/'.$user_data['image'].'&w=157&h=157';
							echo '<img src="'.$md_img_path.'">';
						} else {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/placeholder_avatar.jpg&w=157&h=157';
							echo '<img src="'.$md_img_path.'">';
						} ?>
					</div>
				</div>
				<div class="profile_nav ecolumn">
					<ul>
						<li class="active"><a href="<?=SITE_URL?>account">My Orders</a></li>
						<li><a href="<?=SITE_URL?>profile">Profile</a></li>
						<li><a href="<?=SITE_URL?>change-password">Change Password</a></li>
					</ul>
					<div class="logout">
						<a href="<?=SITE_URL?>controllers/logout.php">Logout</a>
					</div>
				</div>
			</div><!--#sidebar_profile-->
			
			<div id="container_profile">
				<div class="inner ecolumn">
					<div class="clearfix text-right">
						<a href="<?=SITE_URL?>account<?=($post['p']>0?'?p='.$post['p']:'')?>" class="btn btn-blue">Back</a>
						<button class="btn btn-green-bg btn-print" onClick="javascript:printDiv('printablediv')">Print Order</button>
					</div>
					<hr>
					<h4>Print Order</h4>
					<div id="printablediv">
						<div class="printsection">
							<table>
								<tr>
									<td>
										<table class="tabletop">
											<tr>
												<td width="230">
													<div class="orderno">order no:<span> <?=$order_id?></span> </div>
												</td>
												<td width="230">
													<div class="username"><?=$order_detail['first_name'].' '.$order_detail['last_name']?></div>
													<div class="useraddress">
													  <?=$order_detail['address']?><br />
													  <?=$order_detail['address2']?><br />
													  <?=$order_detail['city'].' '.$order_detail['state'].' '.$order_detail['postcode']?><br />
													  <?=($order_detail['country']?'<br />'.$order_detail['country']:'')?>
													</div>
													<div class="userphonenumber"><?=$order_detail['phone']?></div>
												</td>
												<td>
													<div class="companybrand"><img src="<?=SITE_URL?>images/<?=$general_setting_data['logo']?>" width="89"></div>
													<div class="companyname"><?=$general_setting_data['company_name']?></div>
													<div class="companyaddress">
														<?=$general_setting_data['company_address']?><br />
														<?=$general_setting_data['company_city'].' '.$general_setting_data['company_state'].' '.$general_setting_data['company_zipcode']?><br />
														<?=$general_setting_data['company_country']?><br />
														<?=$general_setting_data['company_phone']?>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td bgcolor="#53a3ff" style="background-color:#53a3ff; ">
										<div class="bluebg">
											<div>order status: <?=replace_us_to_space($order_detail['status'])?></div>
											<div>order date: <?=date("m-d-Y",strtotime($order_detail['date']))?></div>
											<div>approved date: <?=($order_detail['approved_date']=="0000-00-00 00:00:00"?'--':date("m-d-Y",strtotime($order_detail['approved_date'])))?></div>
											<div>expires date: <?=($order_detail['approved_date']=="0000-00-00 00:00:00"?'--':date("m-d-Y",strtotime($order_detail['approved_date'])))?></div>
											<div>payment: <?=replace_us_to_space($order_detail['payment_method'])?></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<table class="tablebottom">
											<tr>
												<td>Handset/Device Type</td>
												<td width="200" align="center">Quantity</td>
												<td width="200" align="center">Price</td>
											</tr>
											<?php
											foreach($order_item_list as $order_item_list_data) {
											$order_item_data = get_order_item($order_item_list_data['id'],'print'); ?>
											<tr>
												<td>
													<div class="order">
														<p><?=($order_item_list_data['device_title']?$order_item_list_data['device_title'].' - ':'').$order_item_data['device_type']?></p>
													</div>
												</td>
												<td align="center"><?=$order_item_list_data['quantity']?></td>
												<td align="center"><?=amount_fomat($order_item_list_data['price'])?></td>
											</tr>
											<?php
											} ?>
										</table>
									</td>
								</tr>
								<tr>
									<td class="tfooter">
										<div class="totalsell">Sell Order Total: <?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></div>
									</td>
								</tr>
								<?php
								if($promocode_amt>0) { ?>
								<tr>
									<td class="tfooter">
										<div class="totalsell"><?=$discount_amt_label?> <?=amount_fomat($promocode_amt)?></div>
									</td>
								</tr>
								<tr>
									<td class="tfooter">
										<div class="totalsell">Total: <?=amount_fomat($total_of_order)?></div>
									</td>
								</tr>
								<?php
								} ?>
							</table>
						</div>
					</div>
				 </div><!--.inner-->
			</div><!--#container_profile-->
	  </div>
	</section>
</div>
<!-- /.main -->

<script language="javascript" type="text/javascript">
function printDiv(divID) {
	var divElements = document.getElementById(divID).innerHTML;
	var oldPage = document.body.innerHTML;

	document.body.innerHTML = divElements;

	//Print Page
	window.print();

	//Restore orignal HTML
	document.body.innerHTML = oldPage;
}
</script>