<?php 
$header = array('Model_ID',
	'Category_Title',
	'Brand_Title',
	'Device_Title',
	'Model_Title',
	'Model_Image',
	'Storage_Title',
	'wi_fi_cellular:great_condition',
	'wi_fi_cellular:noticeable_wears_and_tears',
	'wi_fi_cellular:cracked_glass_good_lcd',
	'wi_fi_cellular:broken_lcd',
	'wi_fi_cellular:doa',
	'wi_fi_only:great_condition',
	'wi_fi_only:noticeable_wears_and_tears',
	'wi_fi_only:cracked_glass_good_lcd',
	'wi_fi_only:broken_lcd',
	'wi_fi_only:doa',
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

			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_data['id']."' AND storage='".$s_storage_size."' AND connectivity IN('Wi-Fi Cellular','Wi-Fi Only')");
			$num_of_catalog_data=mysqli_num_rows($mc_query);
			if($num_of_catalog_data>0) {
				while($model_catalog_data=mysqli_fetch_assoc($mc_query)) {
					$saved_connectivity_name = strtolower($model_catalog_data['connectivity']);
					$condition_items_array = json_decode($model_catalog_data['conditions'],true);

					if($saved_connectivity_name == "wi-fi cellular") {
						$data_to_csv['wi_fi_cellular:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['wi_fi_cellular:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['wi_fi_cellular:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['wi_fi_cellular:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['wi_fi_cellular:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_connectivity_name == "wi-fi only") {
						$data_to_csv['wi_fi_only:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['wi_fi_only:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['wi_fi_only:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['wi_fi_only:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['wi_fi_only:doa'] = $condition_items_array[$doa_key_nm];
					}
				}
			} else {
				$data_to_csv['wi_fi_cellular:great_condition'] = '';
				$data_to_csv['wi_fi_cellular:noticeable_wears_and_tears'] = '';
				$data_to_csv['wi_fi_cellular:cracked_glass_good_lcd'] = '';
				$data_to_csv['wi_fi_cellular:broken_lcd'] = '';
				$data_to_csv['wi_fi_cellular:doa'] = '';
				$data_to_csv['wi_fi_only:great_condition'] = '';
				$data_to_csv['wi_fi_only:noticeable_wears_and_tears'] = '';
				$data_to_csv['wi_fi_only:cracked_glass_good_lcd'] = '';
				$data_to_csv['wi_fi_only:broken_lcd'] = '';
				$data_to_csv['wi_fi_only:doa'] = '';
			}														
			$data_to_csv_array[] = $data_to_csv;
		}
	} else {
		$data_to_csv['Storage_Title'] = '';
		$data_to_csv['wi_fi_cellular:great_condition'] = '';
		$data_to_csv['wi_fi_cellular:noticeable_wears_and_tears'] = '';
		$data_to_csv['wi_fi_cellular:cracked_glass_good_lcd'] = '';
		$data_to_csv['wi_fi_cellular:broken_lcd'] = '';
		$data_to_csv['wi_fi_cellular:doa'] = '';
		$data_to_csv['wi_fi_only:great_condition'] = '';
		$data_to_csv['wi_fi_only:noticeable_wears_and_tears'] = '';
		$data_to_csv['wi_fi_only:cracked_glass_good_lcd'] = '';
		$data_to_csv['wi_fi_only:broken_lcd'] = '';
		$data_to_csv['wi_fi_only:doa'] = '';
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
		
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_cellular:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_cellular:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_cellular:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_cellular:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_cellular:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_only:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_only:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_only:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_only:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['wi_fi_only:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['Meta_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Meta_Description'];
		$f_data_to_csv[] = $data_to_csv_data['Meta_Keywords'];

		fputcsv($fp, $f_data_to_csv);
	}
}
?>