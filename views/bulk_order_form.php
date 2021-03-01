<?php
$csrf_token = generateFormToken('bulk_order');

$bonus_data_list = get_bonus_data_list();
$upto_percentage = $bonus_data_list[0]['percentage'];

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];
?>
<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<p>'.$image_text.'</p>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
} ?>

<?php
if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h3><?=$page_title?></h3>
				</div>
			</div>
		</div>
	</section>
<?php
} ?>

<section class="pb-0">
<div class="container-fluid">
  <div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
	  <?=$active_page_data['content']?>
	  <div class="block heading page-heading text-center">
		<h3>Order details:</h3>
	  </div>
	  <div class="block order-details cart clearfix">
		<table class="table table-borderless bulk-table parent">
		  <tr>
			<th class="image"></th>
			<th class="description">Description</th>
			<th class="price">&nbsp;</th>
			<th class="action"></th>
		  </tr>
		  <tr>
			<td class="image bulk_order_form_section"><img src="images/cart/device_bulk.png" alt="bulk device"></td>
			<td class="description">
			  <!-- <h6>Bulk Sale</h6> -->
			  <form class="quantity-form form-inline">
				<label for="">Devices QTY</label>
				<input class="form-control" placeholder="Enter Qty" type="text" name="qty" id="qty" onkeyup="this.value=this.value.replace(/[^\d]/,'');">
				<a href="<?=SITE_URL?>#how-it-works">How it works?</a>
			  </form>
			  <p class="quantity-info d-none d-md-block d-lg-block">Min QTY is 10 and max is 50</p>
			</td>
			<td class="price">&nbsp;</td>
			<td class="action">
			  <!--<a href="#"><img src="images/icons/close-circle.png" alt=""></a>-->
			</td>
		  </tr>
		  <!-- <tr class="total-table-cell mobile-table-cell-none">
				<td class="total-cell"></td>
				<td class="cart-total-cell" colspan="2">
					<?php /*?><p class="bonus"><img src="images/icons/gift.png" alt=""> Bonus: 1% = $4.5</p>
					<h5 class="price-coupon">
					<form action="#">
						<input type="text" class="form-control" placeholder="Coupon: $10" required>
						<button class="btn btn-link close-icon" type="reset"><img src="images/icons/close-circle.png" alt=""></button>
						<img class="status" src="images/icons/tick.png" alt="">
						<img class="coupon-icon" src="images/cart/coupon.png" alt="">
					</form>
					</h5>
					<p class="note">*We occasionally offer promo codes in our email blasts or Facebook page</p><?php */?>
				</td>
				<!-- <td class="paid-cell d-none d-lg-block r_paid d-md-none" colspan="2">
					<button class="btn btn-primary btn-lg rounded-pill get-paid">Get Paid</button>
				</td> -->
		  </tr>
		</table>
		<!-- <table class="d-block d-md-none d-lg-none d-xl-none table table-borderless parent"> -->
		  <!-- <tr> -->
			<?php /*?><td class="total-cell"></td>
			<td class="cart-total-cell" colspan="2">
			  <h5 class="title">Expected payments:</h5>
			  <p>$330 + $330 + $250 + $350 + $70 + 220 = $1260</p>
			  <p class="bonus"><img src="images/icons/gift.png" alt=""> Bonus: 1% = $4.5</p>
			  <h5 class="price-coupon">
				<form action="#">
				  <input type="text" class="form-control" placeholder="Coupon: $10" required>
				  <button class="btn btn-link close-icon" type="reset"><img src="images/icons/close-circle.png" alt=""></button>
				  <img class="status" src="images/icons/tick.png" alt="">
				  <img class="coupon-icon" src="images/cart/coupon.png" alt="">
				</form>
			  </h5>
			  <p class="note">*We occasionally offer promo codes in our email blasts or Facebook page</p>
			</td><?php */?>
				<!-- <td class="paid-cell"> -->
					<div class="clearfix text-center d-block r_paid ">
						<button class="btn btn-primary btn-lg rounded-pill get-paid">Get Paid</button>
					</div>
				<!-- </td> -->
		  <!-- </tr> -->
		<!-- </table> -->
	  </div>
	</div>
  </div>
  <div class="row justify-content-center">
	<div class="col-md-7">
	  <div class="block heading page-heading wholesalers_customers">
		<h3>For wholesalers and regular customers</h3>
	  </div>
	  <div class="block mt-0 pt-0 page-content">
		<p>Valued customers.</p>
		<p>We are appriciate our bussiness with every our customer. We are doing our work honest. We try to be the best company in the industry of used cell phones. Our offers for used electronics is best on the market and we have for you more!</p>
		<p>If you are wholesaller or regular customer we'll pay you more. Please, check out our bonus system that works fully automated and will allow you to get up to <?=$upto_percentage?>% bonus for your orders.</p>
		<p>Thank you four your bussines!</p>
		
	  </div>
	</div>
  
  	<div class="col-md-5">
  		<div class="bonus_parsantage">
			<table class="table table-stripped table-percentage">
			  <tr>
				<th>Bonus</th>
				<th>Paid devices</th>
			  </tr>
			  <?php
			  if(!empty($bonus_data_list)) {
				foreach($bonus_data_list as $bonus_data) { ?>
					<tr>
					  <td><?=$bonus_data['percentage']?> %</td>
					  <td><?=$bonus_data['paid_device']?></td>
					</tr>
				<?php
				}
			  } ?>
			</table>
		  </div>
        </div>
  	</div>

    <div class="row pt-5">  
	  	<div class="col-md-6 bonus-up">
	  		<h4>Up your <strong>bonus to</strong> <br /> <span><?=$upto_percentage?>%</span></h4>
	  	</div>
	  	
		<div class="col-md-6">
			<div class=" bonus_detail">
				<p>We are appriciate our bussiness with every our customer. We are doing our work honest. We try to be the best company in the industry of used cell phones. Our offers for used electronics is best on the market and we have for you more!</p>
		  	</div>
		</div>  	
	</div>
</div>

		
</section>

<div class="modal fade" id="bulkOrderForm" tabindex="-1" role="dialog" aria-labelledby="bulk_order_form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body pt-3 text-center">
          <form action="controllers/bulk_order_form.php" method="post" class="sign-in needs-validation" novalidate>
            <div class="form-row">
              <div class="form-group col-md-6 with-icon">
			    <img src="images/icons/user-gray.png" alt="Name">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                <div class="invalid-feedback">
                  Name Required
                </div>
              </div>
              <div class="form-group mt-0 col-md-6 with-icon">
			    <img src="images/icons/user-gray.png" alt="Email">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                <div class="invalid-feedback">
                  Email Required
                </div>
              </div>
		    </div>
			<div class="form-row">
			  <div class="form-group col-md-6 with-icon">
			    <img src="images/icons/people.png" alt="Company name">
                <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company name">
              </div>
			  <div class="form-group mt-0 col-md-6 with-icon">
			    <img src="images/icons/state.png" alt="State">
                <input type="text" class="form-control" name="state" id="state" placeholder="State" required>
                <div class="invalid-feedback">
                  State Required
                </div>
              </div>
            </div>
            <?php /*?><div class="form-row">
              <div class="form-group mt-3 col-md-6">
                <select name="country" id="country" class="custom-select">
					<option value=""> - Country - </option>
					<?php
					foreach($countries_list as $c_k => $c_v) { ?>
						<option value="<?=$c_v?>"><?=$c_v?></option>
					<?php
					} ?>
				</select>
                <div class="invalid-feedback">
                  Country Required
                </div>
              </div>
            </div><?php */?>
            <div class="form-row">
              <div class="form-group col-md-6 with-icon">
			  	<img src="images/icons/home.png" alt="City">
                <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
                <div class="invalid-feedback">
                  City Required
                </div>
              </div>
              <div class="form-group mt-0 col-md-6 with-icon">
			    <img src="images/icons/envelop.png" alt="Zip code">
                <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zip code" required>
                <div class="invalid-feedback">
                  Zip code Required
                </div>
              </div>
            </div>
			<div class="form-row">
              <div class="form-group col-md-12">
                <textarea class="form-control" name="content" id="content" placeholder="Enter message" required></textarea>
                <div class="invalid-feedback">
                  Message Required
                </div>
              </div>
            </div>
            
			<?php
			if($bulk_order_form_captcha == '1') { ?>
			<div class="form-row">
				<div class="form-group col-md-12">
					<div id="g_form_gcaptcha"></div>
					<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
				</div>
			</div>
			<?php
			} ?>
            
            <div class="form-group double-btn pt-5 text-center">
              <button type="submit" class="btn btn-primary btn-lg rounded-pill ml-lg-3">SUBMIT</button>
			  <input type="hidden" name="submit_form" id="submit_form" />
            </div>
			<input type="hidden" class="form-control" name="quantity" id="quantity">
			<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
          </form>
        </div>
      </div>
    </div>
  </div>

<?php
if($bulk_order_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>

<script>
<?php
if($bulk_order_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};

var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

(function ($) {
	$(function () {
		$('.get-paid').click(function() {
			var qty = $("#qty").val();
			if(qty=='' || qty<10 || qty>50) {
				alert('Min QTY is 10 and max is 50');
				$("#qty").focus();
				return false;
			}
			$("#quantity").val(qty);
			$("#bulkOrderForm").modal();
		});
	});
})(jQuery);
</script>
