<?php
$csrf_token = generateFormToken('review'); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$active_page_data['menu_name']?></a></li>
		</ul>
	</div>
</div>

<div id="main">
	<div class="writereview-page common-two-col-page">
	
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
		} ?>
	  
	  <!-- Select Your Model -->
	  <section class="white-bg">
		<div class="wrap">
		  <div class="content-block">
			<div class="row">
				<form action="controllers/review_form.php" method="post" id="review_form" enctype="multipart/form-data">
				<div class="col-sm-8">
					<div class="sectionbox">
						<div class="row">
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="name" id="name" placeholder="Enter name">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="email" id="email" placeholder="Enter email">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_group form-group">
									<select name="country" id="country" class="textbox">
										<option value=""> - Country - </option>
										<?php
										foreach($countries_list as $c_k => $c_v) { ?>
											<option value="<?=$c_v?>"><?=$c_v?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="state" id="state" placeholder="Enter state">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="city" id="city" placeholder="Enter city">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form_group form-group">
									<div class="dis_table">
										<div class="dis_table_row">
											<div class="col dis_table_cell text-blue">Upload Avatar</div>
											<div class="col dis_table_cell fileuploadbox">
												<input type="file" name="image" id="image" class="uploadfile_hidden" onchange="changefile(this);">
												<button class="btn btn_md btn_dotted">Choose File</button>
											</div>
											<div class="col dis_table_cell"><div id="upload_filename" class="upload_filename">No file Choosen</div></div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-sm-12">
								<div class="form_group form-group">
									<label>How would you rate this business overall?</label>
									<select name="rating" id="rating" class="textbox">
										<option value=""> - Rating Star - </option>
										<?php
										for($si = 0.5; $si<= 5.0; $si=$si+0.5) { ?>
											<option value="<?=$si?>" <?php if($si == '4.5'){echo 'selected="selected"';}?>><?=$si?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>
							
							<div class="col-sm-12">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="title" id="title" placeholder="Enter title">
								</div>
							</div>
	
							<div class="col-sm-12">
								<div class="form_group form-group mb0">
									<textarea class="textbox" name="content" id="content" placeholder="Enter content"></textarea>
								</div>
							</div>
							
							<?php
							if($write_review_form_captcha == '1') { ?>
								<div class="col-md-12">
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
				
				<div class="col-sm-4 sidebar">
					<div class="sectionbox">
						<?=$active_page_data['content']?>
						<div class="address_box">
							<h5>Contact Us</h5>
							<div class="inner">
								<p class="location">
								  <?php
								  if($company_name) {
									 echo '<strong>'.$company_name.'</strong>';
								  }
								  if($company_address) {
									 echo '<br />'.$company_address;
								  }
								  if($company_city) {
									 echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode;
								  }
								  if($company_country) {
									 echo '<br />'.$company_country;
								  } ?>
								</p>
								<?php
								if($site_phone) {
									echo '<p class="phone"><a href="tel:'.$site_phone.'">Phone: '.$site_phone.'</a></p>';
								}
								if($site_email) {
									echo '<p class="email"><a href="mailto:'.$site_email.'">Email: '.$site_email.'</a></p>';
								}
								if($website) {
									echo '<p class="website"><a href="'.$website.'">'.$website.'</a></p>';
								} ?>
						  </div>  
						</div>
					</div>
				</div>
				
			</div>
		  </div>
		</div>
	  </section>
	</div>
</div>

<?php
if($write_review_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($write_review_form_captcha == '1') { ?>
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

function changefile(obj) {
	var str  = obj.value;
	$(".upload_filename").html(str);
}

(function( $ ) {
	$(function() {
		$('#review_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your name'
						}
					}
				},
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter your email address'
						},
						emailAddress: {
							message: 'Please enter your valid email address'
						}
					}
				},
				state: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your state'
						}
					}
				},
				city: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter your city'
						}
					}
				},
				rating: {
					validators: {
						notEmpty: {
							message: 'Please select rating star'
						}
					}
				},
				title: {
					validators: {
						notEmpty: {
							message: 'Please enter your title'
						}
					}
				},
				content: {
					validators: {
						notEmpty: {
							message: 'Please enter your content'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#review_form').data('bootstrapValidator').resetForm();

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