<?php
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

$num_of_sales_pack = count($choosed_sales_pack_array);
?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<?php /*?><li><a href="#">Add Items</a></li>
			<li><a href="#">Review Order</a></li>
			<li><a href="#">Checkout</a></li>
			<li><a href="#">Confirm Order</a></li><?php */?>
			<li class="active"><a href="<?=SITE_URL?>place_order">Complete Order</a></li>
		</ul>
	</div>
</div>

<div id="main">
	<div class="your-order-page common-two-col-page">

	  <section id="head-graphics">
	  	<img src="<?=SITE_URL?>images/your-order.jpg" class="img-fluid">
		<div class="header-caption">
			<h2>Congratulation</h2>
		</div>
	  </section>

	  <!-- Select Your Model -->
	  <section class="white-bg">
		<div class="wrap">
			  <div class="content-block">
				<div class="row">
					<div class="col-sm-12">
						<div class="sectionbox">
							<div class="icon-box-tick"><img src="images/order-tick.png" class="img-fluid img-circle" alt=""></div>
							<div class="title_green">Congratulations</div>
							<div class="sub_title">Your order placed successfully.</div>
							<div class="order_number">Your order Number is: <a href="<?=SITE_URL?>view_order/<?=$order_id?>"><?=$order_id?></a></div>
							<?php
							$shipment_label_url = $order_data['shipment_label_url'];
							if($order_data['sales_pack']=="own_print_label" && $shipment_label_url!="") { ?>
								<div class="btnrow">
									<a href="<?=SITE_URL.'controllers/download.php?download_link='.$shipment_label_url?>" class="btn btn-sm btn-green-bg btn-uppercase">Download Shipment Label</a>
								</div>
							<?php
							} elseif($order_data['sales_pack']=="own_print_label" && $shipment_label_url=="") { ?>
								<div class="alert alert-success alert-dismissable" style="margin-top:20px;margin-bottom:0px;">Unable to create shipment, one or more parameters were invalid.</div>
							<?php
							} ?>
						</div>
					</div>
				</div>
			  </div>
		  
			  <div class="what_hapen_next">
				  <h3>what happens next ?</h3>
				<div class="row">
					<div class="col-md-4 col-xs-12 col-sm-12">
						<div class="boxcontent text-blue">
							<div class="imgbox"><img src="images/yourorder-ico1.png" class="img-fluid img-circle" alt=""></div>
							<h5>PACK IT!</h5>
							<p>Simply print out the provided shipping label, package the phone so it will not be damaged during shipping, also Apple ID NEEDS to be signed out!</p>
						</div>
					</div>
					<div class="col-md-4 col-xs-12 col-sm-12">
						<div class="boxcontent">
							<div class="imgbox"><img src="images/yourorder-ico2.png" class="img-fluid img-circle" alt=""></div>
							<h5>SHIP IT! </h5>
							<p>Once the phone has been packaged and the pre-paid shipping label has been placed, drop the phone off at your local USPS. </p>
						</div>
					</div>
					<div class="col-md-4 col-xs-12 col-sm-12">
						<div class="boxcontent text-blue">
							<div class="imgbox"><img src="images/yourorder-ico3.png" class="img-fluid img-circle" alt=""></div>
							<h5>GET PAID</h5>
							<p>Once we receive and inspect the phone, you will be paid out that same day via Your preferred payment method. </p>
						</div>
					</div>
				</div>
			  </div>
		</div>
	  </section>
	</div>
</div>