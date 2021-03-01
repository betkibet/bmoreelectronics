<?php 
$header = array('Model_ID',
	'Category_Title',
	'Brand_Title',
	'Device_Title',
	'Model_Title',
	//'Model_Image',
	'Model',
	'Processor_Title',
	'Ram_Title',
	'Storage_Title',
	'Graphics_Card',
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
	
	$p_model_items_array = $model_items_array;
	if(empty($p_model_items_array)) {
		$p_model_items_array[] = array("model_name"=>"N/A");
	}
	if(!empty($p_model_items_array)) {
		foreach($p_model_items_array as $p_n_key=>$p_model_data) {
			
			$p_processor_items_array = $processor_items_array;
			if(empty($p_processor_items_array)) {
				$p_processor_items_array[] = array("processor_name"=>"N/A");
			}
			if(!empty($p_processor_items_array)) {
				foreach($p_processor_items_array as $p_n_key=>$p_processor_data) {
				
					$p_ram_items_array = $ram_items_array;
					if(empty($p_ram_items_array)) {
						$p_ram_items_array[] = array("ram_name"=>"N/A");
					}
					if(!empty($p_ram_items_array)) {
						foreach($p_ram_items_array as $p_n_key=>$p_ram_data) {
							$p_ram_size = $p_ram_data['ram_size'].$p_ram_data['ram_size_postfix'];
							$p_storage_items_array = $storage_items_array;
							if(empty($p_storage_items_array)) {
								$p_storage_items_array[] = array("storage_size"=>"N/A");
							}
							if(!empty($p_storage_items_array)) {
								foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
									$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix'];
									
									$p_graphics_card_items_array = $graphics_card_items_array;
									if(empty($p_graphics_card_items_array)) {
										$p_graphics_card_items_array[] = array("graphics_card_name"=>"N/A");
									}
									if(!empty($p_graphics_card_items_array)) {
										foreach($p_graphics_card_items_array as $p_n_key=>$p_graphics_card_data) {
					
											$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND model='".$p_model_data['model_name']."' AND ram='".$p_ram_size."' AND processor='".$p_processor_data['processor_name']."' AND graphics_card='".$p_graphics_card_data['graphics_card_name']."' AND storage='".$p_storage_size."'");
											$num_of_catalog_data=mysqli_num_rows($mc_query);
											if($num_of_catalog_data>0) {
												while($model_catalog_data=mysqli_fetch_assoc($mc_query)) {
													$condition_items_array = json_decode($model_catalog_data['conditions'],true);
													
													$data_to_csv['Model'] = $p_model_data['model_name'];
													$data_to_csv['Processor_Title'] = $p_processor_data['processor_name'];
													$data_to_csv['Ram_Title'] = $p_ram_size;
													$data_to_csv['Storage_Title'] = $p_storage_size;
													$data_to_csv['Graphics_Card'] = $p_graphics_card_data['graphics_card_name'];
													$data_to_csv['Offer_New'] = $condition_items_array['New'];
													$data_to_csv['Offer_Mint'] = $condition_items_array['Mint'];
													$data_to_csv['Offer_Good'] = $condition_items_array['Good'];
													$data_to_csv['Offer_Fair'] = $condition_items_array['Fair'];
													$data_to_csv['Offer_Broken'] = $condition_items_array['Broken'];
													$data_to_csv['Offer_Damaged'] = $condition_items_array['Damaged'];
													$data_to_csv_array[] = $data_to_csv;
												}
											} else {
												$data_to_csv['Model'] = $p_model_data['model_name'];
												$data_to_csv['Processor_Title'] = $p_processor_data['processor_name'];
												$data_to_csv['Ram_Title'] = $p_ram_size;
												$data_to_csv['Storage_Title'] = $p_storage_size;
												$data_to_csv['Graphics_Card'] = $p_graphics_card_data['graphics_card_name'];
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
		$f_data_to_csv[] = $data_to_csv_data['Model'];
		$f_data_to_csv[] = $data_to_csv_data['Processor_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Ram_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Graphics_Card'];
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