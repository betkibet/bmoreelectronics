<?php 
$header = array('Model_ID',
	'Category_Title',
	'Brand_Title',
	'Device_Title',
	'Model_Title',
	'Model_Image',
	'Storage_Title',
	'unlocked:great_condition',
	'unlocked:noticeable_wears_and_tears',
	'unlocked:cracked_glass_good_lcd',
	'unlocked:broken_lcd',
	'unlocked:doa',
	'att:great_condition',
	'att:noticeable_wears_and_tears',
	'att:cracked_glass_good_lcd',
	'att:broken_lcd',
	'att:doa',
	'verizon:great_condition',
	'verizon:noticeable_wears_and_tears',
	'verizon:cracked_glass_good_lcd',
	'verizon:broken_lcd',
	'verizon:doa',
	'tmobile:great_condition',
	'tmobile:noticeable_wears_and_tears',
	'tmobile:cracked_glass_good_lcd',
	'tmobile:broken_lcd',
	'tmobile:doa',
	'sprint:great_condition',
	'sprint:noticeable_wears_and_tears',
	'sprint:cracked_glass_good_lcd',
	'sprint:broken_lcd',
	'sprint:doa',
	'other:great_condition',
	'other:noticeable_wears_and_tears',
	'other:cracked_glass_good_lcd',
	'other:broken_lcd',
	'other:doa',
	'Meta_Title',
	'Meta_Description',
	'Meta_Keywords');
fputcsv($fp, $header);

$data_to_csv_array = array();
while($model_data=mysqli_fetch_assoc($query)) {
	
	$data_to_csv['Model_ID'] = $model_data['id'];
	$data_to_csv['Category_Title'] = $model_data['cat_title'];
	$data_to_csv['Brand_Title'] = $model_data['brand_title'];
	$data_to_csv['Device_Title'] = $model_data['device_title'];
	$data_to_csv['Model_Title'] = $model_data['title'];
	$data_to_csv['Meta_Title'] = $model_data['meta_title'];
	$data_to_csv['Meta_Description'] = $model_data['meta_desc'];
	$data_to_csv['Meta_Keywords'] = $model_data['meta_keywords'];
	$data_to_csv['Model_Image'] = $model_data['model_img'];

	$storage_items_array = get_models_storage_data($model_data['id']);
	if(!empty($storage_items_array)) {
		foreach($storage_items_array as $s_key=>$storage_item) {
			
			$great_condition_key_nm = 'great condition';
			$noticeable_wears_and_tears_key_nm = 'noticeable wears and tears';
			$cracked_glass_good_lcd_key_nm = 'cracked glass, good LCD';
			$broken_lcd_key_nm = 'Broken lcd';
			$doa_key_nm = 'DOA';

			$s_storage_size = $storage_item['storage_size'].$storage_item['storage_size_postfix'];
			$data_to_csv['Storage_Title'] = $s_storage_size;

			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_data['id']."' AND storage='".$s_storage_size."' AND network IN('Unlocked','ATT','Verizon','Tmobile','Sprint','Other')");
			$num_of_catalog_data=mysqli_num_rows($mc_query);
			if($num_of_catalog_data>0) {
				while($model_catalog_data=mysqli_fetch_assoc($mc_query)) {
					$saved_network_name = strtolower($model_catalog_data['network']);
					$condition_items_array = json_decode($model_catalog_data['conditions'],true);

					if($saved_network_name == "unlocked") {
						$data_to_csv['unlocked:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['unlocked:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['unlocked:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['unlocked:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['unlocked:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_network_name == "att") {
						$data_to_csv['att:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['att:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['att:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['att:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['att:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_network_name == "verizon") {
						$data_to_csv['verizon:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['verizon:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['verizon:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['verizon:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['verizon:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_network_name == "tmobile") {
						$data_to_csv['tmobile:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['tmobile:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['tmobile:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['tmobile:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['tmobile:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_network_name == "sprint") {
						$data_to_csv['sprint:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['sprint:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['sprint:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['sprint:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['sprint:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_network_name == "other") {
						$data_to_csv['other:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['other:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['other:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['other:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['other:doa'] = $condition_items_array[$doa_key_nm];
					}
				}
			} else {
				$data_to_csv['unlocked:great_condition'] = '';
				$data_to_csv['unlocked:noticeable_wears_and_tears'] = '';
				$data_to_csv['unlocked:cracked_glass_good_lcd'] = '';
				$data_to_csv['unlocked:broken_lcd'] = '';
				$data_to_csv['unlocked:doa'] = '';
				$data_to_csv['att:great_condition'] = '';
				$data_to_csv['att:noticeable_wears_and_tears'] = '';
				$data_to_csv['att:cracked_glass_good_lcd'] = '';
				$data_to_csv['att:broken_lcd'] = '';
				$data_to_csv['att:doa'] = '';
				$data_to_csv['verizon:great_condition'] = '';
				$data_to_csv['verizon:noticeable_wears_and_tears'] = '';
				$data_to_csv['verizon:cracked_glass_good_lcd'] = '';
				$data_to_csv['verizon:broken_lcd'] = '';
				$data_to_csv['verizon:doa'] = '';
				$data_to_csv['tmobile:great_condition'] = '';
				$data_to_csv['tmobile:noticeable_wears_and_tears'] = '';
				$data_to_csv['tmobile:cracked_glass_good_lcd'] = '';
				$data_to_csv['tmobile:broken_lcd'] = '';
				$data_to_csv['tmobile:doa'] = '';
				$data_to_csv['sprint:great_condition'] = '';
				$data_to_csv['sprint:noticeable_wears_and_tears'] = '';
				$data_to_csv['sprint:cracked_glass_good_lcd'] = '';
				$data_to_csv['sprint:broken_lcd'] = '';
				$data_to_csv['sprint:doa'] = '';
				$data_to_csv['other:great_condition'] = '';
				$data_to_csv['other:noticeable_wears_and_tears'] = '';
				$data_to_csv['other:cracked_glass_good_lcd'] = '';
				$data_to_csv['other:broken_lcd'] = '';
				$data_to_csv['other:doa'] = '';
			}														
			$data_to_csv_array[] = $data_to_csv;
		}
	} else {
		$data_to_csv['Storage_Title'] = '';
		$data_to_csv['unlocked:great_condition'] = '';
		$data_to_csv['unlocked:noticeable_wears_and_tears'] = '';
		$data_to_csv['unlocked:cracked_glass_good_lcd'] = '';
		$data_to_csv['unlocked:broken_lcd'] = '';
		$data_to_csv['unlocked:doa'] = '';
		$data_to_csv['att:great_condition'] = '';
		$data_to_csv['att:noticeable_wears_and_tears'] = '';
		$data_to_csv['att:cracked_glass_good_lcd'] = '';
		$data_to_csv['att:broken_lcd'] = '';
		$data_to_csv['att:doa'] = '';
		$data_to_csv['verizon:great_condition'] = '';
		$data_to_csv['verizon:noticeable_wears_and_tears'] = '';
		$data_to_csv['verizon:cracked_glass_good_lcd'] = '';
		$data_to_csv['verizon:broken_lcd'] = '';
		$data_to_csv['verizon:doa'] = '';
		$data_to_csv['tmobile:great_condition'] = '';
		$data_to_csv['tmobile:noticeable_wears_and_tears'] = '';
		$data_to_csv['tmobile:cracked_glass_good_lcd'] = '';
		$data_to_csv['tmobile:broken_lcd'] = '';
		$data_to_csv['tmobile:doa'] = '';
		$data_to_csv['sprint:great_condition'] = '';
		$data_to_csv['sprint:noticeable_wears_and_tears'] = '';
		$data_to_csv['sprint:cracked_glass_good_lcd'] = '';
		$data_to_csv['sprint:broken_lcd'] = '';
		$data_to_csv['sprint:doa'] = '';
		$data_to_csv['other:great_condition'] = '';
		$data_to_csv['other:noticeable_wears_and_tears'] = '';
		$data_to_csv['other:cracked_glass_good_lcd'] = '';
		$data_to_csv['other:broken_lcd'] = '';
		$data_to_csv['other:doa'] = '';
		$data_to_csv_array[] = $data_to_csv;
	}
}

if(!empty($data_to_csv_array)) {
	foreach($data_to_csv_array as $data_to_csv_data) {
		$f_data_to_csv = array();
		$f_data_to_csv[] = $data_to_csv_data['Model_ID'];
		$f_data_to_csv[] = $data_to_csv_data['Category_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Brand_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Device_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Model_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Model_Image'];
		$f_data_to_csv[] = $data_to_csv_data['Storage_Title'];
		
		$f_data_to_csv[] = $data_to_csv_data['unlocked:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['unlocked:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['unlocked:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['unlocked:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['unlocked:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['att:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['att:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['att:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['att:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['att:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['verizon:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['verizon:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['verizon:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['verizon:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['verizon:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['tmobile:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['tmobile:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['tmobile:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['tmobile:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['tmobile:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['sprint:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['sprint:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['sprint:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['sprint:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['sprint:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['other:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['other:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['other:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['other:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['other:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['Meta_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Meta_Description'];
		$f_data_to_csv[] = $data_to_csv_data['Meta_Keywords'];

		fputcsv($fp, $f_data_to_csv);
	}
}
?>