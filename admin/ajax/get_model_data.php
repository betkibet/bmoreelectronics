<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

$item_id = $post['item_id'];

$query=mysqli_query($db,"SELECT * FROM order_items WHERE id='".$item_id."'");
$order_items_data=mysqli_fetch_assoc($query);

$b_query=mysqli_query($db,"SELECT * FROM brand WHERE published=1 ORDER BY id DESC");

$em_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.id='".$order_items_data['model_id']."' ORDER BY m.id DESC");
$exist_model_data=mysqli_fetch_assoc($em_query);

$d_query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.brand_id='".$exist_model_data['brand_id']."' AND b.id='".$exist_model_data['brand_id']."' GROUP BY m.device_id ORDER BY d.ordering ASC");

$m_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.device_id='".$exist_model_data['device_id']."' ORDER BY m.id DESC");
?>

<div class="form-group m-form__group row">
	<div class="col-lg-4">
		<label>Brand </label>
		<select class="form-control m-input" name="oe_brand_id" id="oe_brand_id" onchange="getOEDevice(this.value);" required="required">
			<option value="">Choose Brand</option>
			<?php
			while($brand_list=mysqli_fetch_assoc($b_query)) { ?>
				<option value="<?=$brand_list['id']?>" <?php if($brand_list['id'] == $exist_model_data['brand_id']){echo 'selected="selected"';}?>><?=$brand_list['title']?></option>
			<?php
			} ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>Device </label>
		<select class="add-quote-device2 form-control m-input" name="oe_device_id" id="oe_device_id" onchange="getOEModel(this.value);" required="required">
			<option value="">Choose Device</option>
			<?php
			while($device_list=mysqli_fetch_assoc($d_query)) { ?>
				<option value="<?=$device_list['id']?>" <?php if($device_list['id'] == $exist_model_data['device_id']){echo 'selected="selected"';}?>><?=$device_list['title']?></option>
			<?php
			} ?>
		</select>
	</div>
	<div class="col-lg-4">
		<label>Model </label>
		<select class="add-quote-model2 form-control m-input" name="oe_model_id" id="oe_model_id" required="required" onchange="getModelDetails(this.value,'');">
			<option value="">Choose Model</option>
			<?php
			while($model_data=mysqli_fetch_assoc($m_query)) { ?>
				<option value="<?=$model_data['id']?>" <?php if($model_data['id'] == $exist_model_data['id']){echo 'selected="selected"';}?>><?=$model_data['title']?></option>
			<?php
			} ?>
		</select>
	</div>
</div>

<div id="oe_model_details" style="margin-top:15px;"></div>

<script>
function getOEDevice(val)
{
	var brand_id = val.trim();
	if(brand_id) {
		post_data = "brand_id="+brand_id+"&token=<?=unique_id()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_oe_device.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#oe_device_id').html(data);
						$('#oe_model_id').html('<option value="">Choose Model</option>');
						$('#oe_model_details').html('');
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

function getOEModel(val)
{
	var device_id = val.trim();
	if(device_id) {
		var brand_id = $('#oe_brand_id').val();
		post_data = "device_id="+device_id+"&brand_id="+brand_id+"&token=<?=unique_id()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_oe_model.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#oe_model_id').html(data);
						$('#oe_model_details').html('');
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

function getModelDetails(val,mode)
{
	var model_id = val.trim();
	if(model_id) {
		post_data = "model_id="+model_id+"&item_id=<?=$item_id?>&token=<?=unique_id()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_oe_model_details.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('#oe_model_details').html(data);
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

getModelDetails('<?=$exist_model_data['id']?>','onload');
</script>