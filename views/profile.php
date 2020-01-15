<?php
$csrf_token = generateFormToken('profile');

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} ?>

  <!-- Main -->
  <div id="main" class="profile_page">
    <section id="user_profile_sec" class="sectionbox white-bg">
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
                    	<li><a href="account">My Orders</a></li>
                        <li class="active"><a href="profile">Profile</a></li>
                        <li><a href="change-password">Change Password</a></li>
                    </ul>
                    <div class="logout">
                        <a href="controllers/logout.php">Logout</a>
                    </div>
                </div>
            </div><!--#sidebar_profile-->

            <form action="controllers/user/profile.php" class="phone-sell-form" method="post" id="profile_form" enctype="multipart/form-data">
            <div id="container_profile">
            	<div class="inner ecolumn">
                	<div class="profile_bio">
                    	<h4>Edit Your Details</h4>
                        <p>It is important to ensure that we have your correct address and contact details on the system. Your current details are displayed below. If necessary, make any changes and click the 'Update' button.</p>
                    </div>
                    <hr>
                    <div class="upload_avtar clearfix">
                    	<div class="dis_table">
                        	<div class="dis_table_row">
                            	<div class="col dis_table_cell">Avatar</div>
                                <div class="col dis_table_cell fileuploadbox">
                                <input type="file" class="uploadfile_hidden" name="image" id="image" onchange="changefile(this);">
								<input type="hidden" name="old_image" id="old_image" value="<?=$user_data['image']?>" />
                                <button class="btn btn_md btn_dotted">Choose File</button>
                                </div>
                                <div class="col dis_table_cell"><div id="upload_filename" class="upload_filename">No file Choosen</div></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form_box clearfix">
                        <div class="row">
                            <div class="form_group col-sm-4">
                                <label>First Name</label>
                                <input type="text" class="textbox" name="first_name" id="first_name" placeholder="First Name" value="<?=$user_data['first_name']?>" required autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>Last Name</label>
                                <input type="text" class="textbox" name="last_name" id="last_name" placeholder="Last Name" value="<?=$user_data['last_name']?>" required autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>Email</label>
                                <input type="text" class="textbox" name="email" id="email" placeholder="Your email address" value="<?=$user_data['email']?>" required autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>Phone</label>
                                <input type="tel" id="cell_phone" name="cell_phone" class="textbox">
                  				<input type="hidden" name="phone" id="phone" />
                            </div>
                        </div>
                     </div>
                     
                     <div class="form_box shipping_box clearfix">
                     <h4>Shipping Address</h4>
                     <hr>
                        <div class="row clearfix">
                            <div class="form_group col-sm-4">
                                <label>Address</label>
                                <input type="text" class="textbox" name="address" id="address" placeholder="Address Line1" value="<?=$user_data['address']?>" required autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>Address2</label>
                                <input type="text" class="textbox" name="address2" id="address2" placeholder="Address Line2" value="<?=$user_data['address2']?>" autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>City</label>
                                <input type="text" class="textbox" name="city" id="city" placeholder="City" value="<?=$user_data['city']?>" required autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>State</label>
                                <input type="text" class="textbox" name="state" id="state" placeholder="State" value="<?=$user_data['state']?>" required autocomplete="nope">
                            </div>
                            <div class="form_group col-sm-4">
                                <label>Postcode</label>
                                <input type="text" class="textbox" name="postcode" id="postcode" placeholder="Post code" value="<?=$user_data['postcode']?>" required autocomplete="nope">
                            </div>
                        </div>
                     </div>
                     
                     <div class="btn_box">
                     	<button type="submit" class="btn btn_md btn-green">update</button>
						<input type="hidden" name="submit_form" id="submit_form" />
                     </div>
                 </div><!--.inner-->
            </div><!--#container_profile-->
			<input type="hidden" name="id" id="id" value="<?=$user_data['id']?>"/>
			<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
			</form>
      </div>
    </section>
  </div>
  <!-- /.main -->

<script>
function changefile(obj){
	var str  = obj.value;
	$(".upload_filename").html(str);
}
	
(function( $ ) {
	$(function() {
		var telInput = $("#cell_phone");
		telInput.intlTelInput({
		  initialCountry: "auto",
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});
		
		$("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['phone']:'')?>");
		
		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {
		$('#profile_form').bootstrapValidator({
			fields: {
				first_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter first name'
						}
					}
				},
				 last_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter last name'
						}
					}
				},
				cell_phone: {
					validators: {
						callback: {
							message: 'Please enter valid phone number',
							callback: function(value, validator, $field) {
								var telInput = $("#cell_phone");
								$("#phone").val(telInput.intlTelInput("getNumber"));
								if(!telInput.intlTelInput("isValidNumber")) {
									return false;
								} else if(telInput.intlTelInput("isValidNumber")) {
									return true;
								}
							}
						}
					}
				},
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
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						}
					}
				},
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter address.'
						}
					}
				}/*,
				address2: {
					validators: {
						notEmpty: {
							message: 'Please enter address2.'
						}
					}
				}*/,
				city: {
					validators: {
						notEmpty: {
							message: 'Please enter city.'
						}
					}
				},
				state: {
					validators: {
						notEmpty: {
							message: 'Please enter state.'
						}
					}
				},
				postcode: {
					validators: {
						notEmpty: {
							message: 'Please enter post code.'
						}
					}
				},
				terms_conditions: {
					validators: {
						callback: {
							message: 'You must agree to terms & conditions to sign-up.',
							callback: function(value, validator, $field) {
								var terms = document.getElementById("terms_conditions").checked;
								if(terms==false) {
									return false;
								} else {
									return true;
								}
							}
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#profile_form').data('bootstrapValidator').resetForm();

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