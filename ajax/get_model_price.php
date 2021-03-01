<?php

require_once("../admin/_config/config.php");

require_once("../admin/include/functions.php");

require_once('../models/model.php');
require_once("common.php");


$req_data = $_REQUEST;

$req_model_id = ($req_data['req_model_id']?$req_data['req_model_id']:$req_data['model_id']);

$fields_cat_type = $req_data['fields_cat_type'];

$step_type = $req_data['step_type'];

$condition = $req_data['condition'];

$quantity = $req_data['quantity'];



$device_nm = '';

if($fields_cat_type == "mobile") {

	$storage = ($req_data['storage']?$req_data['storage']:"N/A");

	$network = ($req_data['network']?$req_data['network']:"N/A");

	if($req_model_id && $condition && $storage && $network) {

		$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND network='".$network."' AND storage='".$storage."'");

		$model_catalog_data=mysqli_fetch_assoc($mc_query);

	}

}

elseif($fields_cat_type == "tablet") {

	$storage = ($req_data['storage']?$req_data['storage']:"N/A");

	$connectivity = ($req_data['connectivity']?$req_data['connectivity']:"N/A");

	if($req_model_id && $condition && $storage && $connectivity) {

		$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND connectivity='".$connectivity."' AND storage='".$storage."'");

		$model_catalog_data=mysqli_fetch_assoc($mc_query);

	}

}

elseif($fields_cat_type == "watch") {

	$connectivity = ($req_data['connectivity']?$req_data['connectivity']:"N/A");

	$case_size = ($req_data['case_size']?$req_data['case_size']:"N/A");

	$model = ($req_data['model']?$req_data['model']:"N/A");

	if($req_model_id && $condition && $connectivity && $case_size && $model) {

		$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND model='".$model."' AND connectivity='".$connectivity."' AND case_size='".$case_size."'");

		$model_catalog_data=mysqli_fetch_assoc($mc_query);

	}

}

elseif($fields_cat_type == "laptop") {

	$storage = ($req_data['storage']?$req_data['storage']:"N/A");

	$processor = ($req_data['processor']?$req_data['processor']:"N/A");

	$model = ($req_data['model']?$req_data['model']:"N/A");

	$ram = ($req_data['ram']?$req_data['ram']:"N/A");

	$graphics_card = ($req_data['graphics_card']?$req_data['graphics_card']:"N/A");

	if($req_model_id && $condition && $storage && $processor && $model && $ram && $graphics_card) {

		$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND processor='".$processor."' AND storage='".$storage."' AND model='".$model."' AND ram='".$ram."' AND graphics_card='".$graphics_card."'");

		$model_catalog_data=mysqli_fetch_assoc($mc_query);

	}

}

elseif($fields_cat_type == "other") {

	$model = ($req_data['model']?$req_data['model']:"N/A");

	if($req_model_id && $condition && $model) {

		$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$req_model_id."' AND model='".$model."'");

		$model_catalog_data=mysqli_fetch_assoc($mc_query);

	}

}



$final_model_amt = 0;

if($model_catalog_data['conditions']) {

	$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true);

	if($ps_condition_items_array[$condition]) {

		$final_model_amt = $ps_condition_items_array[$condition];

	}

}



$chk_device_nm = '';



$accessories_ids_arr = array();

$accessories_ids = $req_data['accessories'];

if(!empty($accessories_ids)) {

	foreach($accessories_ids as $acc_k=>$acc_v) {

		$exp_acc_v = explode(":",$acc_v);

		$accessories_ids_arr[] = $exp_acc_v[1];

	}

	if(!empty($accessories_ids_arr)) {

		$accessories_list = get_models_accessories_data($req_model_id,$accessories_ids_arr);

	}

	foreach($accessories_list as $accessories_data) {

		$chk_device_nm .= '<span class="badge badge-secondary mr-1">'.$accessories_data['accessories_name'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

		$accessories_price = $accessories_data['accessories_price'];

		if($accessories_price) {

			$final_model_amt += $accessories_price;

		}

	}

}



$band_included_ids_arr = array();

$band_included_ids = $req_data['band_included'];

if(!empty($band_included_ids)) {

	foreach($band_included_ids as $bin_k=>$bin_v) {

		$exp_bin_v = explode(":",$bin_v);

		$band_included_ids_arr[] = $exp_bin_v[1];

	}

	if(!empty($band_included_ids_arr)) {

		$band_included_list = get_models_band_included_data($req_model_id,$band_included_ids_arr);

	}

	foreach($band_included_list as $band_included_data) {

		$chk_device_nm .= '<span class="badge badge-secondary mr-1">'.$band_included_data['band_included_name'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

		$band_included_price = $band_included_data['band_included_price'];

		if($band_included_price) {

			$final_model_amt += $band_included_price;

		}

	}

}



if($req_data['network']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['network'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['connectivity']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['connectivity'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['case_size']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['case_size'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['model']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['model'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['processor']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['processor'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['ram']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['ram'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}



if($req_data['storage']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['storage'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['graphics_card']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['graphics_card'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

if($req_data['condition']) {

	$device_nm .= '<span class="badge badge-secondary mr-1">'.$req_data['condition'].' <i class="ion ion-md-checkmark text-success"></i></span> / ';

}

$f_device_nm = $device_nm.$chk_device_nm;
$f_device_nm = strip_tags($f_device_nm);
$f_device_nm = rtrim($f_device_nm,' / ');

if($final_model_amt>0) {

	$final_model_amt = ($final_model_amt*$quantity);

	$whole_p = (int) $final_model_amt;
	$fraction_p  = str_replace('0.','.',$final_model_amt - (int) $final_model_amt);

	$response_array = array();

	$response_array['payment_amt'] = $final_model_amt;

	$response_array['payment_amt_html'] = $amount_sign_with_prefix.$whole_p.$amount_sign_with_postfix.($fraction_p?'<span>'.$fraction_p.'</span>':'');

	$_final_model_amt=amount_fomat($final_model_amt);

	$response_array['show_final_amt'] = $_final_model_amt;

	

	$response_array['device_nm'] = $f_device_nm;

} else {
	$whole_p = 0;
	$fraction_p  = 0;
	
	$response_array['payment_amt'] = '0';
	$response_array['payment_amt_html'] = $amount_sign_with_prefix.$whole_p.$amount_sign_with_postfix.($fraction_p?'<span>'.$fraction_p.'</span>':'');
	
	$_final_model_amt=amount_fomat('0');

	$response_array['show_final_amt'] = 0;//$_final_model_amt;

	

	$response_array['device_nm'] = $f_device_nm;

}



echo json_encode($response_array);

exit;