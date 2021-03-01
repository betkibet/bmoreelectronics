<?php
$meta_title = "Affiliate Complete Order";
$meta_keywords = "Affiliate Complete Order";
$meta_desc = "Affiliate Complete Order"; ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="IE=edge" >

<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_desc?>" />
<title><?=$meta_title?></title>

<!-- Jquery Data Table -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?=SITE_URL?>css/style.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/constant.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/color.css"> 
  
<link rel="stylesheet" href="<?=SITE_URL?>css/intlTelInput.css">

<link rel="stylesheet" href="<?=SITE_URL?>css/bootstrapValidator.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">

<style>
.d-none{display:none;}
.hide{display:none;}
</style>

<script src="<?=SITE_URL?>js/jquery.min.js"></script>
<script src="<?=SITE_URL?>js/jquery.scrollTo.min.js"></script>

<?=$custom_js_code?>
</head>
<body class="inner">

<?php
//Get order id
$order_id = $_SESSION['affiliate_tmp_order_id'];

if(!$order_id) {
	setRedirect(SITE_URL);
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);
$access_token = $order_data['access_token'];

$num_of_sales_pack = count($choosed_sales_pack_array);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

$total_of_order = $sum_of_orders;
if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
	$total_of_order = $total_of_order+$order_data['promocode_amt'];
}

$express_service = !empty($order_data['express_service'])?$order_data['express_service']:0;
$express_service_price = !empty($order_data['express_service_price'])?$order_data['express_service_price']:0;
$shipping_insurance = !empty($order_data['shipping_insurance'])?$order_data['shipping_insurance']:0;
$shipping_insurance_per = !empty($order_data['shipping_insurance_per'])?$order_data['shipping_insurance_per']:0;

$f_express_service_price = 0;
$f_shipping_insurance_price = 0;
if($express_service == '1') {
	$total_of_order = $total_of_order-$express_service_price;
}
if($shipping_insurance == '1') {
	$total_of_order = $total_of_order-($sum_of_orders*$shipping_insurance_per/100);
}
?>

   <section class="bg-primary py-4 nav-top-space">
      <div class="container">
         <div class="row">
            <div class="col-md-12 text-center text-white order-complate_section">
               <h1 class="mb-2">Thanks for selling your stuff, ! Guest</h1>
               <p class="mb-0">We'll send your Pack & Send Guide containing everything you need to send us your stuff.</p>
            </div>
         </div>
      </div>
   </section>

   <section class="bg-white order-complate_section">
      <div class="container">
         <div class="row row-bordered border border-left-0 border-right-0 text-center">
            <div class="col-md-6">
               <h3 class="mb-0 py-1"><span class="text-muted">Order No:</span> <?=$order_id?></h3>
            </div>
            <div class="col-md-6">
               <h3 class="mb-0 py-1"><span class="text-muted">Total Value:</span> <span class="text-primary"><?=amount_fomat($total_of_order)?></span></h3>
            </div>
         </div>
	   <div class="row">
         <div class="col-md-12 pt-5 pb-3 text-center affiliate_order_complete_section"> 
            <p class="pb-2">
              <?php
              if($show_cust_delivery_note == '1') { ?>
              <a class="btn btn-primary rounded-pill mr-1" href="javascript:open_window('<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id.'&access_token='.$access_token?>')">Delivery Note <i class="ion ion-md-download"></i></a>
              <?php
              } 
              if($show_cust_order_form == '1') { ?>
              <a class="btn btn-primary rounded-pill mr-1" href="<?=SITE_URL?>pdf/order-<?=$order_id?>.pdf" target="_blank">Order Form <i class="ion ion-md-download"></i></a>
              <?php
              }
              if($show_cust_sales_confirmation == '1') { ?>
              <a class="btn btn-primary rounded-pill" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank">Sales Confirmation <i class="ion ion-md-download"></i></a>
              <?php
              }
			  
				$shipment_label_d_url = '';
				$shipment_label_url = $order_data['shipment_label_url'];
				if($order_data['sales_pack']=="print_a_prepaid_label" && $shipment_label_url!="") {
					$shipment_label_d_url = SITE_URL.'controllers/download.php?download_link='.$shipment_label_url; ?>
					<a class="btn btn-primary rounded-pill" href="<?=$shipment_label_d_url?>">Address Label <i class="ion ion-md-download"></i></a>
					<p>USPS <span># <?=$order_data['shipment_tracking_code']?></span></p>
				<?php
				} elseif($order_data['sales_pack']=="print_a_prepaid_label" && $shipment_label_url=="" && $shipping_option['print_a_prepaid_label'] == "print_a_prepaid_label") { ?>
					<div class="alert alert-danger alert-dismissable mt-2">
					  Unable to create shipment, one or more parameters were invalid so please <a href="<?=$contact_link?>">contact</a> to our support team.
					</div>
				<?php
				} ?> 
            </p>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 text-center affiliate_order_complete_section">
            <p class="mb-0">You can track your order status by email address & order no.</p>
            <p>Email Address: <strong><?=$order_data['email']?></strong></p>
            <a class="landing-btn btn btn-primary btn-lg" href="<?=SITE_URL?>order-track">Track Order</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <h3 class="display-4 font-secondary text-center font-weight-semibold mb-3 pt-3">
               What you need to do next...
            </h3>
            <hr class="landing-separator border-primary mx-auto"> 
         </div>
      </div>
      <div class="row text-center affiliate_order_complete ">
         <div class="col-md-3 mb-2 mt-3">
            <div class="card ">
               <div class="card-body">
                  <img src="images/order-complete/1-print.png" alt="">
                  <p class="text-muted">We'll send Freepost label via Email or Post</p>
               </div>
            </div>
         </div>
        <div class="col-md-3 mb-2 mt-3">
          <div class="card">
            <div class="card-body">
          <img src="images/order-complete/2-box.png" alt="">
          <p class="text-muted">Pack your items into ANY box</p>
        </div>
        </div>
        </div>
        <div class="col-md-3 mb-2 mt-3">
          <div class="card">
            <div class="card-body">
          <img src="images/order-complete/3-ship.png" alt="">
          <p class="text-muted">Attach your label to your box</p>  
        </div>
        </div>
        </div>
        <div class="col-md-3 mb-2 mt-3">
          <div class="card">
            <div class="card-body">
          <img src="images/order-complete/4-van.png" alt="">
          <p class="text-muted">Send your items for FREE</p>
        </div>
        </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 bg-white main_affiliate_order_section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-center"><a href="#" class="text-primary">Click here</a> to view your Pack &amp; Send Guide, which includes packing tips.</h5>
        </div>
      </div>
      <div class="row justify-content-center bg-light">
        <div class="col-md-9 py-4">
          <div class="row">
            <div class="col-md-2 text-center">
              <img src="images/order-complete/unlock-your-device.png" alt="" width="100">
            </div>
            <div class="col-md-10 text-center affiliate_order_complete_section">
              <h3>Please remove your iCloud or Samsung account before sending your device!</h3>
              <button type="button" class="landing-btn btn btn-primary btn-lg mr-2"><i class="ion ion-logo-apple"></i> Remove Apple ICloud</button>
              <button type="button" class="landing-btn btn btn-primary btn-lg"><i class="ion ion-logo-android"></i> Remove My Samsung</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="pb-5 bg-white main_affiliate_order_section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 border border-primary text-center py-4">
          <h4>The sooner you send your stuff, the sooner you'll get paid <?=amount_fomat($total_of_order)?>!</h4>
          <p class="mb-0">Remember, we pay on the same day we receive your items.</p>
        </div>
      </div>
    </div>
  </section>
  
<script language="javascript" type="text/javascript">
function open_window(url) {
	window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=1000,height=800');
}
</script>

<script src="<?=SITE_URL?>js/popper.min.js"></script>
<script src="<?=SITE_URL?>js/bootstrap_4.3.1.min.js"></script>
<script src="<?=SITE_URL?>js/slick.min.js"></script>
<script src="<?=SITE_URL?>js/jquery.autocomplete.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=SITE_URL?>js/intlTelInput.js"></script>
<script src="<?=SITE_URL?>js/bootstrapvalidator.min.js"></script>

</body>
</html>