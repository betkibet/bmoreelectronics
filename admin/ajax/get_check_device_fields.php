<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth("ajax");

$item_id = $post['item_id'];
$order_id = $post['order_id'];
$order_mode = $post['order_mode'];
$is_opn_check_device_pop = $post['is_opn_check_device_pop'];
$mode = $post['mode'];

$query = mysqli_query($db,"SELECT oit.*, a.username, c.name AS contractor_name FROM order_item_testing AS oit LEFT JOIN admin AS a ON a.id=oit.staff_id LEFT JOIN contractors AS c ON c.id=oit.contractor_id WHERE oit.item_id='".$item_id."'");
$order_item_testing_data = mysqli_fetch_assoc($query);

$order_item_testing_id = $order_item_testing_data['id'];
$prepare_for_testing = json_decode($order_item_testing_data['prepare_for_testing'],true);
$detailed_testing = json_decode($order_item_testing_data['detailed_testing'],true);

$dflt_image_arr = array('Front Picture','Back Picture','Top Of Phone','Bottom Of Phone','Left Side Of Phone','Right Side Of Phone');

if($mode == "checked") {
	if(!empty($prepare_for_testing) || !empty($detailed_testing)) { ?>
	<div class="row">
		<div class="col-xl-12 m--margin-left-25">
			<div class="row">
				<?php
				if(!empty($prepare_for_testing)) { ?>
				<div class="col-4">
					<h4>Prepare for testing</h4>
					<div class="m-form__group form-group">
						<?php
						foreach($prepare_for_testing as $pft_k=>$pft_v) { ?>
						<label><?=$pft_k?>: <strong><?=$pft_v?></strong></label>
						<br />
						<?php
						} ?>
					</div>
				</div>
				<?php
				}
				if(!empty($detailed_testing)) { ?>
				<div class="col-4">
					<h4>Detailed testing</h4>
					<div class="m-form__group form-group">
						<?php
						foreach($detailed_testing as $dt_k=>$dt_v) {
							if($dt_v) { ?>
							<label><?=$dt_k?>: <strong><?=$dt_v?></strong></label>
							<br />
							<?php
							}
						} ?>
					</div>
				</div>
				<?php
				} ?>
				<div class="col-4">
					<h4>Notes & Media</h4>
					<div class="form-group m-form__group">
						<?=$order_item_testing_data['note']?>
					</div>
					
					<!--<div class="form-group m-form__group">
						<?php
						$item_images_array = json_decode($order_item_testing_data['images'],true);
						if(!empty($item_images_array)) {
							echo '<div class="form-group m-form__group">';
							foreach($item_images_array as $ii_k=>$ii_v) {
								if($ii_v) {
								$ii_n = $ii_n+1; ?>
								<?php /*?><img src="<?=SITE_URL?>images/order/items/<?=$ii_v?>" width="40" class="my-md-2"><?php */?>
								<a class="btn btn-info btn-sm" href="<?=SITE_URL?>images/order/items/<?=$ii_v?>" target="_blank" style="margin-top:5px;"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-<?=$ii_n?>"> Photo-<?=$ii_n?></a><?php /*?>&nbsp;<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_chk_d_img=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$ii_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><?php */?><br />			
								<?php
								}
							}
							echo '</div>';
						} ?>
					</div>-->
					<div class="form-group m-form__group">
						<?php
						$item_videos_array = json_decode($order_item_testing_data['videos'],true);
						if(!empty($item_videos_array)) {
							echo '<div class="form-group m-form__group">';
							foreach($item_videos_array as $iv_k=>$iv_v) {
								if($iv_v) { ?>
								<a class="btn btn-success btn-sm" target="_blank" href="<?=$iv_v?>" style="margin-top:5px;">Video <?=$iv_k_n=$iv_k_n+1?></a><?php /*?>&nbsp;<a class="btn btn-danger btn-sm" href="controllers/order/order.php?d_chk_d_video=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$iv_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><?php */?><br />
								<?php
								}
							}
							echo '</div>';
						} ?>
						</div>
						
				</div>
			</div>
			
			<div class="row">
				<?php
				$item_images_array = json_decode($order_item_testing_data['images'],true);
				/*foreach($dflt_image_arr as $di_k=>$di_v) {
					if(isset($item_images_array[$di_v])) {
						$item_images_array[$di_v] = $item_images_array[$di_v];
					}
				}*/
				if(!empty($item_images_array)) {
					foreach($item_images_array as $ii_k=>$ii_v) {
						if($ii_v) {
							echo '<div class="col-4"><div class="form-group m-form__group">';
							$ii_n = $ii_n+1; ?>
							<small><?=(in_array($ii_k,$dflt_image_arr)&&$ii_k!='0'?$ii_k:'')?></small><br />
							<a href="<?=SITE_URL?>images/order/items/<?=$ii_v?>" target="_blank"><img src="<?=SITE_URL?>images/order/items/<?=$ii_v?>" width="80" class="my-md-2"></a>
							&nbsp;<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_chk_d_img=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$ii_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a>			
							<?php
							echo '</div></div>';
						}
					}
					
				} ?>
			</div>
			
		</div>
	</div>
	<?php
	}/*
	if(!empty($detailed_testing)) { ?>
	<div class="row">
		<div class="col-xl-8 offset-xl-2">
			<h4>Detailed testing</h4>
			<div class="m-form__group form-group">
				<?php
				foreach($detailed_testing as $dt_k=>$dt_v) {
					if($dt_v) { ?>
					<label><?=$dt_k?>: <strong><?=$dt_v?></strong></label>
					<br />
					<?php
					}
				} ?>
			</div>
		</div>
	</div>
	<?php
	}*/ ?>
	
	<div class="row">
		<div class="col-xl-12">
			<?php /*?><h4>Notes & Media</h4>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group m-form__group">
						<?=$order_item_testing_data['note']?>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
				<?php
				$item_images_array = json_decode($order_item_testing_data['images'],true);
				if(!empty($item_images_array)) {
					echo '<div class="form-group m-form__group">';
					foreach($item_images_array as $ii_k=>$ii_v) {
						if($ii_v) {
						$ii_n = $ii_n+1; ?>
						<a class="btn btn-info btn-sm" href="<?=SITE_URL?>images/order/items/<?=$ii_v?>" target="_blank" style="margin-top:5px;"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-<?=$ii_n?>"> Photo-<?=$ii_n?></a>&nbsp;<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_chk_d_img=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$ii_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><br />			
						<?php
						}
					}
					echo '</div>';
				} ?>
				</div>
				<div class="col-md-6">
				<?php
				$item_videos_array = json_decode($order_item_testing_data['videos'],true);
				if(!empty($item_videos_array)) {
					echo '<div class="form-group m-form__group">';
					foreach($item_videos_array as $iv_k=>$iv_v) {
						if($iv_v) { ?>
						<a class="btn btn-success btn-sm" target="_blank" href="<?=$iv_v?>" style="margin-top:5px;">Video <?=$iv_k_n=$iv_k_n+1?></a>&nbsp;<a class="btn btn-danger btn-sm" href="controllers/order/order.php?d_chk_d_video=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$iv_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><br />
						<?php
						}
					}
					echo '</div>';
				} ?>
				</div>
			</div><?php */?>
			
			<?php
			if(!empty($order_item_testing_data) && ($order_item_testing_data['username'] || $order_item_testing_data['contractor_name'])) {
				echo '<div class="row" style="margin-top:15px;"><div class="col-md-6">Checked by: <strong>';
				if($order_item_testing_data['username']) {
					echo $order_item_testing_data['username'].' (Admin)';
				}
				if($order_item_testing_data['contractor_name']) {
					echo $order_item_testing_data['contractor_name'].' (Contractor)';
				}
				echo '</strong></div></div>';
			} ?>
										
		</div>
	</div>

<?php
} else { ?>

<script>
jQuery(document).ready(function($) {
	var maxField = 10;
	
	var addButton = $('.add_item__image_chk_d');
    var wrapper = $('.item_image__wrapper_chk_d');
    var x = 1;

	<?php /*?>var saved_image_arr = <?=$order_item_testing_data['images']?>;<?php */?>
	var demo_image_arr = {"Front Picture":"front_view.png","Back Picture":"back_view.png","Top Of Phone":"top_view.png","Bottom Of Phone":"bottom_view.png","Left Side Of Phone":"leftside_view.png","Right Side Of Phone":"rightside_view.png"};
	var dflt_image_arr = ['Front Picture','Back Picture','Top Of Phone','Bottom Of Phone','Left Side Of Phone','Right Side Of Phone'];
	for(i=0; i<dflt_image_arr.length; i++) {
		var dflt_image_nm = dflt_image_arr[i];

		var fieldHTML = '<div class="form-group m-form__group row">';
		fieldHTML += '<div class="col-lg-12">';
			fieldHTML += '<div class="row">';

				fieldHTML += '<div class="col-md-8">';
					fieldHTML += '<div class="m-form__control">';
						fieldHTML += '<small>'+dflt_image_nm+'</small>';
						fieldHTML += '<div class="custom-file">';
							fieldHTML += '<input type="file" id="item_image" class="custom-file-input" name="item_image['+dflt_image_nm+']" onChange="checkFile(this);" accept="image/*">';
							fieldHTML += '<label class="custom-file-label" for="image">Choose file</label>';
						fieldHTML += '</div>';
					fieldHTML += '</div>';
				fieldHTML += '</div>';

				//if(saved_image_arr[dflt_image_nm]) {
				if(demo_image_arr[dflt_image_nm]) {
					fieldHTML += '<div class="col-md-4">';
						fieldHTML += '<div class="m-form__control">';
							//fieldHTML += '<img src="<?=SITE_URL?>images/order/items/'+saved_image_arr[dflt_image_nm]+'" width="40" class="my-md-2">';
							fieldHTML += '<img src="<?=SITE_URL?>images/check_device/'+demo_image_arr[dflt_image_nm]+'" width="40" class="my-md-2">';
						fieldHTML += '</div>';
					fieldHTML += '</div>';
				}
				
				/*fieldHTML += '<div class="col-md-4">';
					fieldHTML += '<div class="m-form__control">';
						fieldHTML += '<div class="remove_item__image_chk_d btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
							fieldHTML += '<span><i class="la la-trash-o"></i><span>Delete</span>';
							fieldHTML += '</span>';
						fieldHTML += '</div>';
					fieldHTML += '</div>';
				fieldHTML += '</div>';*/
				
			fieldHTML += '</div>';
		fieldHTML += '</div>';
		fieldHTML += '</div>';
				
		$(wrapper).append(fieldHTML); //Add field html
	}

    //Once add button is clicked
	//$(document).on('click', addButton, function() {
    $(addButton).click(function() {
        //Check maximum number of input fields
        if(x < maxField) { 
            x++; //Increment field counter
			
			var fieldHTML = '<div class="form-group m-form__group row">';
			fieldHTML += '<div class="col-lg-12">';
				fieldHTML += '<div class="row">';
					
					fieldHTML += '<div class="col-md-8">';
						fieldHTML += '<div class="m-form__control">';
							fieldHTML += '<div class="custom-file">';
								fieldHTML += '<input type="file" id="item_image" class="custom-file-input" name="item_image['+x+']" onChange="checkFile(this);" accept="image/*">';
								fieldHTML += '<label class="custom-file-label" for="image">Choose file</label>';
							fieldHTML += '</div>';
						fieldHTML += '</div>';
					fieldHTML += '</div>';

					fieldHTML += '<div class="col-md-4">';
						fieldHTML += '<div class="m-form__control">';
							fieldHTML += '<div class="remove_item__image_chk_d btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
								fieldHTML += '<span><i class="la la-trash-o"></i><span>Delete</span>';
								fieldHTML += '</span>';
							fieldHTML += '</div>';
						fieldHTML += '</div>';
					fieldHTML += '</div>';
					
				fieldHTML += '</div>';
			fieldHTML += '</div>';
			fieldHTML += '</div>';
										
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
	
	$(wrapper).on('click', '.remove_item__image_chk_d', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent().parent('div').remove();
        x--;
    });

	var addButton_2 = $('.add_item__image2_chk_d');
    var wrapper_2 = $('.item_image__wrapper2_chk_d');
    var x_2 = 1;
 
    //Once add button is clicked
	//$(document).on('click', addButton_2, function() {
    $(addButton_2).click(function() {
        //Check maximum number of input fields
        if(x_2 < maxField) { 
            x_2++; //Increment field counter
			
			var fieldHTML_2 = '<div class="form-group m-form__group row">';
			fieldHTML_2 += '<div class="col-lg-12">';
				fieldHTML_2 += '<div class="row">';
					
					fieldHTML_2 += '<div class="col-md-8">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="url" class="form-control m-input" name="item_video['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';

					fieldHTML_2 += '<div class="col-md-4">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<div class="remove_item__image2_chk_d btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
								fieldHTML_2 += '<span><i class="la la-trash-o"></i><span>Delete</span>';
								fieldHTML_2 += '</span>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					
				fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
										
            $(wrapper_2).append(fieldHTML_2); //Add field html
        }
    });
	
	$(wrapper_2).on('click', '.remove_item__image2_chk_d', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent().parent('div').remove();
        x_2--;
    });
	
});
</script>

<!--begin: Form Wizard Step 1-->
<div class="m-wizard__form-step <?=($is_opn_check_device_pop=="yes"?'':'m-wizard__form-step--current')?> " id="m_wizard_form_step_1">
	<div class="row">
		<div class="col-xl-8 offset-xl-2">
			<h4>1. Prepare for testing</h4>
			<div class="m-form__group form-group">
				<label>Give the device a physical examination of the body what is the overall appearance ?</label>
				<div class="m-radio-inline">
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="New" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "New"){echo 'checked="checked"';}?>> New <span></span>
					</label>
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="Flawless" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "Flawless"){echo 'checked="checked"';}?>> Flawless <span></span>
					</label>
					
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="Mint" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "Mint"){echo 'checked="checked"';}?>> Mint <span></span>
					</label>
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="Good" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "Good"){echo 'checked="checked"';}?>> Good <span></span>
					</label>
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="Fair" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "Fair"){echo 'checked="checked"';}?>> Fair <span></span>
					</label>
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="Broken" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "Broken"){echo 'checked="checked"';}?>> Broken <span></span>
					</label>
					<label class="m-radio">
						<input type="radio" name="prepare_for_testing[Give the device a physical examination of the body what is the overall appearance]" value="Damaged" <?php if($prepare_for_testing['Give the device a physical examination of the body what is the overall appearance'] == "Damaged"){echo 'checked="checked"';}?>> Damaged <span></span>
					</label>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!--end: Form Wizard Step 1-->

<!--begin: Form Wizard Step 2-->
<div class="m-wizard__form-step" id="m_wizard_form_step_2">
	<div class="row">
		<div class="col-xl-8 offset-xl-2">
			<h4>2. Detailed testing</h4>
			<div class="row">
				<div class="col-md-8">
					<div class="m-form__group form-group">
						<label>Wifi signal strength</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Wifi signal strength]" value="Pass" <?php if($detailed_testing['Wifi signal strength'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Wifi signal strength]" value="Fail" <?php if($detailed_testing['Wifi signal strength'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Wifi signal strength]" value="NA" <?php if($detailed_testing['Wifi signal strength'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Bluetooth signal strength and pairing capabilities</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Bluetooth signal strength and pairing capabilities]" value="Pass" <?php if($detailed_testing['Bluetooth signal strength and pairing capabilities'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Bluetooth signal strength and pairing capabilities]" value="Fail" <?php if($detailed_testing['Bluetooth signal strength and pairing capabilities'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Bluetooth signal strength and pairing capabilities]" value="NA" <?php if($detailed_testing['Bluetooth signal strength and pairing capabilities'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>GPS and location functionality</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[GPS and location functionality]" value="Pass" <?php if($detailed_testing['GPS and location functionality'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[GPS and location functionality]" value="Fail" <?php if($detailed_testing['GPS and location functionality'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[GPS and location functionality]" value="NA" <?php if($detailed_testing['GPS and location functionality'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Charge port</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Charge port]" value="Pass" <?php if($detailed_testing['Charge port'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Charge port]" value="Fail" <?php if($detailed_testing['Charge port'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Charge port]" value="NA" <?php if($detailed_testing['Charge port'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Battery health and battery life</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Battery health and battery life]" value="Pass" <?php if($detailed_testing['Battery health and battery life'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Battery health and battery life]" value="Fail" <?php if($detailed_testing['Battery health and battery life'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Battery health and battery life]" value="NA" <?php if($detailed_testing['Battery health and battery life'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Front and Back Cameras</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Front and Back Cameras]" value="Pass" <?php if($detailed_testing['Front and Back Cameras'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Front and Back Cameras]" value="Fail" <?php if($detailed_testing['Front and Back Cameras'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Front and Back Cameras]" value="NA" <?php if($detailed_testing['Front and Back Cameras'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Flash</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Flash]" value="Pass" <?php if($detailed_testing['Flash'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Flash]" value="Fail" <?php if($detailed_testing['Flash'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Flash]" value="NA" <?php if($detailed_testing['Flash'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Video Recorder</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Video Recorder]" value="Pass" <?php if($detailed_testing['Video Recorder'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Video Recorder]" value="Fail" <?php if($detailed_testing['Video Recorder'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Video Recorder]" value="NA" <?php if($detailed_testing['Video Recorder'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Ear Speaker</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Ear Speaker]" value="Pass" <?php if($detailed_testing['Ear Speaker'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Ear Speaker]" value="Fail" <?php if($detailed_testing['Ear Speaker'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Ear Speaker]" value="NA" <?php if($detailed_testing['Ear Speaker'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Loud Speaker</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Loud Speaker]" value="Pass" <?php if($detailed_testing['Loud Speaker'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Loud Speaker]" value="Fail" <?php if($detailed_testing['Loud Speaker'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Loud Speaker]" value="NA" <?php if($detailed_testing['Loud Speaker'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Microphone</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Microphone]" value="Pass" <?php if($detailed_testing['Microphone'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Microphone]" value="Fail" <?php if($detailed_testing['Microphone'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Microphone]" value="NA" <?php if($detailed_testing['Microphone'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Headset</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Headset]" value="Pass" <?php if($detailed_testing['Headset'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Headset]" value="Fail" <?php if($detailed_testing['Headset'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Headset]" value="NA" <?php if($detailed_testing['Headset'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Digitizer and response time to touch</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Digitizer and response time to touch]" value="Pass" <?php if($detailed_testing['Digitizer and response time to touch'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Digitizer and response time to touch]" value="Fail" <?php if($detailed_testing['Digitizer and response time to touch'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Digitizer and response time to touch]" value="NA" <?php if($detailed_testing['Digitizer and response time to touch'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>LCD</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[LCD]" value="Pass" <?php if($detailed_testing['LCD'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[LCD]" value="Fail" <?php if($detailed_testing['LCD'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[LCD]" value="NA" <?php if($detailed_testing['LCD'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Memory and SD card slot</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Memory and SD card slot]" value="Pass" <?php if($detailed_testing['Memory and SD card slot'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Memory and SD card slot]" value="Fail" <?php if($detailed_testing['Memory and SD card slot'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Memory and SD card slot]" value="NA" <?php if($detailed_testing['Memory and SD card slot'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Proximity to face</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Proximity to face]" value="Pass" <?php if($detailed_testing['Proximity to face'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Proximity to face]" value="Fail" <?php if($detailed_testing['Proximity to face'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Proximity to face]" value="NA" <?php if($detailed_testing['Proximity to face'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Accelerometer speed</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Accelerometer speed]" value="Pass" <?php if($detailed_testing['Accelerometer speed'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Accelerometer speed]" value="Fail" <?php if($detailed_testing['Accelerometer speed'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Accelerometer speed]" value="NA" <?php if($detailed_testing['Accelerometer speed'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>Test Call</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Test Call]" value="Pass" <?php if($detailed_testing['Test Call'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Test Call]" value="Fail" <?php if($detailed_testing['Test Call'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[Test Call]" value="NA" <?php if($detailed_testing['Test Call'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
					<div class="m-form__group form-group">
						<label>IOS – FingerPrint Sensor and iCloud Status</label>
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="detailed_testing[IOS – FingerPrint Sensor and iCloud Status]" value="Pass" <?php if($detailed_testing['IOS – FingerPrint Sensor and iCloud Status'] == "Pass"){echo 'checked="checked"';}?>> Pass <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[IOS – FingerPrint Sensor and iCloud Status]" value="Fail" <?php if($detailed_testing['IOS – FingerPrint Sensor and iCloud Status'] == "Fail"){echo 'checked="checked"';}?>> Fail <span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="detailed_testing[IOS – FingerPrint Sensor and iCloud Status]" value="NA" <?php if($detailed_testing['IOS – FingerPrint Sensor and iCloud Status'] == "NA"){echo 'checked="checked"';}?>> NA <span></span>
							</label>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!--end: Form Wizard Step 2-->
 
<!--begin: Form Wizard Step 3-->
<div class="m-wizard__form-step <?=($is_opn_check_device_pop=="yes"?'m-wizard__form-step--current':'')?>" id="m_wizard_form_step_3">
	<div class="row">
		<div class="col-xl-8 offset-xl-2">
			<h4>3. Finish. Add notes</h4>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group m-form__group">
						<textarea class="form-control m-input" name="note" rows="5"><?=$order_item_testing_data['note']?></textarea>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:20px;">
				<div class="col-md-6">
					<div class="item_image__wrapper_chk_d">
						<div class="form-group m-form__group row" style="padding-bottom:0px;">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-8">
										<div class="m-form__control">
											<label for="input"><strong>Image</strong></label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="m-form__control">
											<label for="input"><strong><!--Action--></strong></label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-form__group form-group row">
						<div class="col-lg-4">
							<button type="button" class="add_item__image_chk_d btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
								<span>
									<i class="la la-plus"></i>
									<span>Add</span>
								</span>
							</button>
						</div>
					</div>
				</div>
			
				<div class="col-md-6">
					<div class="item_image__wrapper2_chk_d">
						<div class="form-group m-form__group row" style="padding-bottom:0px;">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-8">
										<div class="m-form__control">
											<label for="input"><strong>Video</strong></label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="m-form__control">
											<label for="input"><strong>Action</strong></label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-form__group form-group row">
						<div class="col-lg-4">
							<button type="button" class="add_item__image2_chk_d btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
								<span>
									<i class="la la-plus"></i>
									<span>Add</span>
								</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-md-6">
				<?php
				$item_images_array = json_decode($order_item_testing_data['images'],true);
				if(!empty($item_images_array)) {
					echo '<div class="form-group m-form__group">';
					foreach($item_images_array as $ii_k=>$ii_v) {
						if($ii_v) {
						$ii_n = $ii_n+1; ?>
						<?php /*?><img src="<?=SITE_URL?>images/order/items/<?=$ii_v?>" width="40" class="my-md-2"><?php */?>
						<a class="btn btn-info btn-sm" href="<?=SITE_URL?>images/order/items/<?=$ii_v?>" target="_blank" style="margin-top:5px;"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-<?=$ii_n?>"> Photo-<?=$ii_n?></a>&nbsp;<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_chk_d_img=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$ii_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><br />			
						<?php
						}
					}
					echo '</div>';
				} ?>
				</div>
				<div class="col-md-6">
				<?php
				$item_videos_array = json_decode($order_item_testing_data['videos'],true);
				if(!empty($item_videos_array)) {
					echo '<div class="form-group m-form__group">';
					foreach($item_videos_array as $iv_k=>$iv_v) {
						if($iv_v) { ?>
						<a class="btn btn-success btn-sm" target="_blank" href="<?=$iv_v?>" style="margin-top:5px;">Video <?=$iv_k_n=$iv_k_n+1?></a>&nbsp;<a class="btn btn-danger btn-sm" href="controllers/order/order.php?d_chk_d_video=<?=$order_item_testing_id?>&order_id=<?=$order_id?>&img=<?=$iv_v?>&order_mode=<?=$order_mode?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><br />
						<?php
						}
					}
					echo '</div>';
				} ?>
				</div>
			</div>-->

			<?php
			if(!empty($order_item_testing_data) && ($order_item_testing_data['username'] || $order_item_testing_data['contractor_name'])) {
				echo '<div class="row" style="margin-top:15px;"><div class="col-md-6">Checked by: <strong>';
				if($order_item_testing_data['username']) {
					echo $order_item_testing_data['username'].' (Admin)';
				}
				if($order_item_testing_data['contractor_name']) {
					echo $order_item_testing_data['contractor_name'].' (Contractor)';
				}
				echo '</strong></div></div>';
			} ?>
										
		</div>
	</div>
</div>
<!--end: Form Wizard Step 3-->
<?php
} ?>