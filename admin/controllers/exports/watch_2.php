<?php 
$header = array('Model_ID',
	'Category_Title',
	'Brand_Title',
	'Device_Title',
	'Model_Title',
	//'Model_Image',
	'Connectivity_Title',
	'Case_Size',
	'Model',
	'Offer_New',
	'Offer_Mint',
	'Offer_Good',
	'Offer_Fair',
	'Offer_Broken',
	'Offer_Damaged',
	//'Meta_Title',
	//'Meta_Description',
	//'Meta_Keywords'
	);
fputcsv($fp, $header);

$data_to_csv_array = array();
while($model_data=mysqli_fetch_assoc($query)) {
	$model_id = $model_data['id'];
	$data_to_csv['Model_ID'] = $model_id;
	$data_to_csv['Category_Title'] = $model_data['cat_title'];
	$data_to_csv['Brand_Title'] = $model_data['brand_title'];
	$data_to_csv['Device_Title'] = $model_data['device_title'];
	$data_to_csv['Model_Title'] = $model_data['title'];
	$data_to_csv['Meta_Title'] = $model_data['meta_title'];
	$data_to_csv['Meta_Description'] = $model_data['meta_desc'];
	$data_to_csv['Meta_Keywords'] = $model_data['meta_keywords'];
	//$data_to_csv['Model_Image'] = $model_data['model_img'];
	
	$storage_items_array = get_models_storage_data($model_id);
	$condition_items_array = get_models_condition_data($model_id);
	$network_items_array = get_models_networks_data($model_id);
	$connectivity_items_array = get_models_connectivity_data($model_id);
	$watchtype_items_array = get_models_watchtype_data($model_id);
	$case_material_items_array = get_models_case_material_data($model_id);
	$case_size_items_array = get_models_case_size_data($model_id);
	$accessories_items_array = get_models_accessories_data($model_id);
	$processor_items_array = get_models_processor_data($model_id);
	$ram_items_array = get_models_ram_data($model_id);
	$model_items_array = get_models_model_data($model_id);
	$graphics_card_items_array = get_models_graphics_card_data($model_id);

	$p_connectivity_items_array = $connectivity_items_array;
	if(empty($p_connectivity_items_array)) {
		$p_connectivity_items_array[] = array("connectivity_name"=>"N/A");
	}
	if(!empty($p_connectivity_items_array)) {
		foreach($p_connectivity_items_array as $p_n_key=>$p_connectivity_data) {
			$p_case_size_items_array = $case_size_items_array;
			if(empty($p_case_size_items_array)) {
				$p_case_size_items_array[] = array("case_size"=>"N/A");
			}
			if(!empty($p_case_size_items_array)) {
				foreach($p_case_size_items_array as $p_s_key=>$p_case_size_item) {
					$pn_p = ($pn_p+1);
					$p_case_size = $p_case_size_item['case_size'];
					
					$p_model_items_array = $model_items_array;
					if(empty($p_model_items_array)) {
						$p_model_items_array[] = array("model_name"=>"N/A");
					}
					if(!empty($p_model_items_array)) {
						foreach($p_model_items_array as $p_s_key=>$p_model_item) {
							$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND connectivity='".$p_connectivity_data['connectivity_name']."' AND case_size='".$p_case_size."' AND model='".$p_model_item['model_name']."'");
							$num_of_catalog_data=mysqli_num_rows($mc_query);
							if($num_of_catalog_data>0) {
								while($model_catalog_data=mysqli_fetch_assoc($mc_query)) {
									$condition_items_array = json_decode($model_catalog_data['conditions'],true);
		
									$data_to_csv['Connectivity_Title'] = $p_connectivity_data['connectivity_name'];
									$data_to_csv['Case_Size'] = $p_case_size;
									$data_to_csv['Model'] = $p_model_item['model_name'];
									$data_to_csv['Offer_New'] = $condition_items_array['New'];
									$data_to_csv['Offer_Mint'] = $condition_items_array['Mint'];
									$data_to_csv['Offer_Good'] = $condition_items_array['Good'];
									$data_to_csv['Offer_Fair'] = $condition_items_array['Fair'];
									$data_to_csv['Offer_Broken'] = $condition_items_array['Broken'];
									$data_to_csv['Offer_Damaged'] = $condition_items_array['Damaged'];
									$data_to_csv_array[] = $data_to_csv;
								}
							} else {
								$data_to_csv['Connectivity_Title'] = $p_connectivity_data['connectivity_name'];
								$data_to_csv['Case_Size'] = $p_case_size;
								$data_to_csv['Model'] = $p_model_item['model_name'];
								$data_to_csv['Offer_New'] = '';
								$data_to_csv['Offer_Mint'] = '';
								$data_to_csv['Offer_Good'] = '';
								$data_to_csv['Offer_Fair'] = '';
								$data_to_csv['Offer_Broken'] = '';
								$data_to_csv['Offer_Damaged'] = '';
								$data_to_csv_array[] = $data_to_csv;
							}
						}
					}
				}
			}
		}
	}														
	//$data_to_csv_array[] = $data_to_csv;	
}

/*echo '<pre>';
print_r($data_to_csv_array);
exit;*/

if(!empty($data_to_csv_array)) {
	foreach($data_to_csv_array as $data_to_csv_data) {
		$f_data_to_csv = array();
		$f_data_to_csv[] = $data_to_csv_data['Model_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Category_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Brand_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Device_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Model_Title'];
		//$f_data_to_csv[] = $data_to_csv_data['Model_Image'];
		$f_data_to_csv[] = $data_to_csv_data['Connectivity_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Case_Size'];
		$f_data_to_csv[] = $data_to_csv_data['Model'];
		$f_data_to_csv[] = $data_to_csv_data['Offer_New'];
		$f_data_to_csv[] = $data_to_csv_data['Offer_Mint'];
		$f_data_to_csv[] = $data_to_csv_data['Offer_Good'];
		$f_data_to_csv[] = $data_to_csv_data['Offer_Fair'];
		$f_data_to_csv[] = $data_to_csv_data['Offer_Broken'];
		$f_data_to_csv[] = $data_to_csv_data['Offer_Damaged'];
		//$f_data_to_csv[] = $data_to_csv_data['Meta_Title'];
		//$f_data_to_csv[] = $data_to_csv_data['Meta_Description'];
		//$f_data_to_csv[] = $data_to_csv_data['Meta_Keywords'];

		fputcsv($fp, $f_data_to_csv);
	}
}
?>