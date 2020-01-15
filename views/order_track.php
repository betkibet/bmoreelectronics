<?php
$csrf_token = generateFormToken('order_track');

$order_id = $_SESSION['track_order_id'];
$order_data = get_order_data($order_id);
if($order_id!="") {
	unset($_SESSION['track_order_id']);
}

$error_message = $_SESSION['error_message'];
if($error_message!="") {
	unset($_SESSION['error_message']);
} ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$active_page_data['menu_name']?></a></li>
		</ul>
	</div>
</div>

<div id="main">
	<div class="bulkorder-page">
		<?php
		//Header Image
		if($active_page_data['image'] != "") { ?>
			<section id="head-graphics">
				<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" class="img-fluid">
				<div class="header-caption">
					<h2><?=$active_page_data['title']?></h2>
				</div>
			</section>
	  	<?php
		}
		
	    if($error_message!="") { ?>
		<div class="row">
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?=$error_message?>
			</div>
		</div>
	    <?php
	    } ?>
		  
	  	<!-- Select Your Model -->
		<section class="white-bg">
		<div class="wrap">
		  <div class="content-block">
			<div class="row">
			  <?php
			  if(!empty($order_data)) { ?>
				<div class="form-group">
					<h4><strong>Email:</strong> <?=$order_data['email']?></h4>
					<h4><strong>Order ID:</strong> <?=$order_data['order_id']?></h4>
					<h4><strong>Your Order Status Is:</strong> <?=ucwords(str_replace("_"," ",$order_data['status']))?></h4>
					<a href="<?=SITE_URL?>order-track" class="btn btn-primary btn-lg">Retry</a>
				</div>
			  <?php
			  } else { ?>
				<form action="controllers/order_track.php" method="post" id="contact_form">
					<div class="col-sm-12">
						<div class="sectionbox">
							<div class="row">
								<div class="col-sm-12">
									<div class="form_group form-group">
										<input type="text" name="email" id="email" placeholder="Enter email" class="form-control" value="<?=$user_email?>"/>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form_group form-group">
										<input type="text" name="order_id" id="order_id" placeholder="Enter order number" class="form-control" />
									</div>
								</div>
								
								<?php
								if($order_track_form_captcha == '1') { ?>
									<div class="col-sm-12">
										<div class="form-group">
											<div id="g_form_gcaptcha"></div>
											<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
										</div>
									</div>
								<?php
								} ?>
				
								<div class="col-sm-12 btn_row">
									<button type="submit" class="btn btn-blue-bg">SUBMIT</button>
									<input type="hidden" name="submit_form" id="submit_form" />
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				</form>
				<?php
		  } ?>
				
			</div>
		  </div>
		</div>
		</section>
	</div>
</div>

<?php
if($order_track_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($order_track_form_captcha == '1') { ?>
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
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

(function( $ ) {
	$(function() {
		$('#contact_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				},
				order_id: {
					validators: {
						notEmpty: {
							message: 'Please enter order id'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>