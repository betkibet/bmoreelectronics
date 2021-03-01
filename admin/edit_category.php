<?php
$file_name="device_categories";

//Header section
require_once("include/header.php");

$id = $post['id'];
if($id<=0 && $prms_category_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_category_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable category data
$q=mysqli_query($db,'SELECT * FROM categories WHERE id="'.$id.'"');
$category_data=mysqli_fetch_assoc($q);
$category_data = _dt_parse_array($category_data);

$storage_items_array = get_category_storage_data($id);
$condition_items_array = get_category_condition_data($id);
$network_items_array = get_category_networks_data($id);
$connectivity_items_array = get_category_connectivity_data($id);
$watchtype_items_array = get_category_watchtype_data($id);
$case_material_items_array = get_category_case_material_data($id);
$case_size_items_array = get_category_case_size_data($id);
$accessories_items_array = get_category_accessories_data($id);
$band_included_items_array = get_category_band_included_data($id);
$processor_items_array = get_category_processor_data($id);
$ram_items_array = get_category_ram_data($id);
$model_items_array = get_category_model_data($id);
$graphics_card_items_array = get_category_graphics_card_data($id);

//Template file
require_once("views/categories/edit_category.php"); ?>
