<?php
$file_name="mobile";

//Header section
require_once("include/header.php");

$id = $post['id'];
$pricing_tb = isset($post['pricing'])?$post['pricing']:'';

//Fetch signle editable mobile(model) data
$mobile_data_q=mysqli_query($db,'SELECT m.*, c.fields_type, c.accessories_title, c.band_included_title, c.processor_title, c.ram_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.id="'.$id.'"');
$mobile_data=mysqli_fetch_assoc($mobile_data_q);
$mobile_data = _dt_parse_array($mobile_data);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand ORDER BY id ASC');

//Fetch category list
$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

$storage_items_array = get_models_storage_data($id);
$condition_items_array = get_models_condition_data($id);
$network_items_array = get_models_networks_data($id);
$connectivity_items_array = get_models_connectivity_data($id);
$watchtype_items_array = get_models_watchtype_data($id);
$case_material_items_array = get_models_case_material_data($id);
$case_size_items_array = get_models_case_size_data($id);
$accessories_items_array = get_models_accessories_data($id);
$band_included_items_array = get_models_band_included_data($id);
$processor_items_array = get_models_processor_data($id);
$ram_items_array = get_models_ram_data($id);
$model_items_array = get_models_model_data($id);
$graphics_card_items_array = get_models_graphics_card_data($id);

//$colors_items_array = get_models_color_data($id);
//$accessories_items_array = get_models_accessories_data($id);
//$miscellaneous_items_array = get_models_miscellaneous_data($id);

//Template file
require_once("views/mobile/edit_mobile.php"); ?>
