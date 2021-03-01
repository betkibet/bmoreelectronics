<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$shipping_method = $_POST['shipping_method'];
if($shipping_method == "store" || $shipping_method == "starbucks") {
	$sql_params = "";
	if($shipping_method == "store") {
		//$sql_params = "AND is_show_in_store_shipping = '1'";
		$sql_params = "AND shipping_type = 'store'";
	} elseif($shipping_method == "starbucks") {
		//$sql_params = "AND is_show_in_starbucks_shipping = '1'";
		$sql_params = "AND shipping_type = 'starbucks'";
	}

	$query=mysqli_query($db,"SELECT * FROM `locations` WHERE published='1' ".$sql_params);
	$location_list = array();
	while($location_dt = mysqli_fetch_assoc($query)) {
		$location_list[] = $location_dt;
	}

	if(count($location_list)>0) { ?>
		<div class="form-row">
			<div class="form-group col-md-12">
				<select id="location_id" name="location_id" class="form-control" onchange="getLocationList(this.value);">
				  <option value="" data-show_appt_datetime_selection_in_place_order="0"> - Select Location - </option>
				  <?php
				  foreach($location_list as $location_data) { ?>
					<option value="<?=$location_data['id']?>" data-show_appt_datetime_selection_in_place_order="<?=$location_data['show_appt_datetime_selection_in_place_order']?>" <?php if($location_data['id']==$location_id){echo 'selected="selected"';}?>><?=$location_data['name']?></option>
				  <?php
				  } ?>
				</select>
				<small id="location_id_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
			</div>
		</div>
	<?php
	} else {
		echo '<input type="hidden" id="location_id" name="location_id" value="0" />';
	}

	foreach($location_list as $location_data) { ?>
		<div class="location-adr-show-hide" id="location-adr-<?=$location_data['id']?>" style="display:none;">
			<strong><?=$company_name.($location_data['name']?' - '.$location_data['name']:'')?></strong><br />
			<?=$location_data['address']?><br />
			<?=$location_data['city'].', '.$location_data['state'].' '.$location_data['zipcode']?><br />
			<?=$location_data['country']?>

			<?php
			//START for service hours
			if($location_data['show_working_hours_in_place_order'] == '1') {
				$service_hours_data = get_service_hours_data_html($location_data['id']);
				if($service_hours_data['service_hours_info']) {
					echo '<br><br><h6><strong>Service Hours</strong></h6><div class="row service_hour">'.$service_hours_data['service_hours_info'].'</div>';
				}
			} //END for service hours ?>
		</div>
	<?php
	}
} ?>