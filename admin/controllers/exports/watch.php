<?php
$header = array('Model_ID',
	'Category_Title',
	'Brand_Title',
	'Device_Title',
	'Model_Title',
	'Model_Image',
	'Case_Size',
	'original_1st_gen:great_condition',
	'original_1st_gen:noticeable_wears_and_tears',
	'original_1st_gen:cracked_glass_good_lcd',
	'original_1st_gen:broken_lcd',
	'original_1st_gen:doa',
	'watch_series_1:great_condition',
	'watch_series_1:noticeable_wears_and_tears',
	'watch_series_1:cracked_glass_good_lcd',
	'watch_series_1:broken_lcd',
	'watch_series_1:doa',
	'watch_series_2:great_condition',
	'watch_series_2:noticeable_wears_and_tears',
	'watch_series_2:cracked_glass_good_lcd',
	'watch_series_2:broken_lcd',
	'watch_series_2:doa',
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

	$case_size_items_array = get_models_case_size_data($model_data['id']);
	if(!empty($case_size_items_array)) {
		foreach($case_size_items_array as $s_key=>$case_size_item) {
			
			$great_condition_key_nm = 'great condition';
			$noticeable_wears_and_tears_key_nm = 'noticeable wears and tears';
			$cracked_glass_good_lcd_key_nm = 'cracked glass, good LCD';
			$broken_lcd_key_nm = 'Broken lcd';
			$doa_key_nm = 'DOA';

			$s_case_size = $case_size_item['case_size'];
			$data_to_csv['Case_Size'] = $s_case_size;

			$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_data['id']."' AND case_size='".$s_case_size."' AND generation IN('Original (1st Gen)','Watch Series 1','Watch Series 2')");
			$num_of_catalog_data=mysqli_num_rows($mc_query);
			if($num_of_catalog_data>0) {
				while($model_catalog_data=mysqli_fetch_assoc($mc_query)) {
					$saved_generation_name = strtolower($model_catalog_data['generation']);
					$condition_items_array = json_decode($model_catalog_data['conditions'],true);

					if($saved_generation_name == "original (1st gen)") {
						$data_to_csv['original_1st_gen:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['original_1st_gen:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['original_1st_gen:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['original_1st_gen:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['original_1st_gen:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_generation_name == "watch series 1") {
						$data_to_csv['watch_series_1:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['watch_series_1:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['watch_series_1:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['watch_series_1:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['watch_series_1:doa'] = $condition_items_array[$doa_key_nm];
					} elseif($saved_generation_name == "watch series 2") {
						$data_to_csv['watch_series_2:great_condition'] = $condition_items_array[$great_condition_key_nm];
						$data_to_csv['watch_series_2:noticeable_wears_and_tears'] = $condition_items_array[$noticeable_wears_and_tears_key_nm];
						$data_to_csv['watch_series_2:cracked_glass_good_lcd'] = $condition_items_array[$cracked_glass_good_lcd_key_nm];
						$data_to_csv['watch_series_2:broken_lcd'] = $condition_items_array[$broken_lcd_key_nm];
						$data_to_csv['watch_series_2:doa'] = $condition_items_array[$doa_key_nm];
					}
				}
			} else {
				$data_to_csv['original_1st_gen:great_condition'] = '';
				$data_to_csv['original_1st_gen:noticeable_wears_and_tears'] = '';
				$data_to_csv['original_1st_gen:cracked_glass_good_lcd'] = '';
				$data_to_csv['original_1st_gen:broken_lcd'] = '';
				$data_to_csv['original_1st_gen:doa'] = '';
				$data_to_csv['watch_series_1:great_condition'] = '';
				$data_to_csv['watch_series_1:noticeable_wears_and_tears'] = '';
				$data_to_csv['watch_series_1:cracked_glass_good_lcd'] = '';
				$data_to_csv['watch_series_1:broken_lcd'] = '';
				$data_to_csv['watch_series_1:doa'] = '';
				$data_to_csv['watch_series_2:great_condition'] = '';
				$data_to_csv['watch_series_2:noticeable_wears_and_tears'] = '';
				$data_to_csv['watch_series_2:cracked_glass_good_lcd'] = '';
				$data_to_csv['watch_series_2:broken_lcd'] = '';
				$data_to_csv['watch_series_2:doa'] = '';
			}														
			$data_to_csv_array[] = $data_to_csv;
		}
	} else {
		$data_to_csv['Case_Size'] = '';
		$data_to_csv['original_1st_gen:great_condition'] = '';
		$data_to_csv['original_1st_gen:noticeable_wears_and_tears'] = '';
		$data_to_csv['original_1st_gen:cracked_glass_good_lcd'] = '';
		$data_to_csv['original_1st_gen:broken_lcd'] = '';
		$data_to_csv['original_1st_gen:doa'] = '';
		$data_to_csv['watch_series_1:great_condition'] = '';
		$data_to_csv['watch_series_1:noticeable_wears_and_tears'] = '';
		$data_to_csv['watch_series_1:cracked_glass_good_lcd'] = '';
		$data_to_csv['watch_series_1:broken_lcd'] = '';
		$data_to_csv['watch_series_1:doa'] = '';
		$data_to_csv['watch_series_2:great_condition'] = '';
		$data_to_csv['watch_series_2:noticeable_wears_and_tears'] = '';
		$data_to_csv['watch_series_2:cracked_glass_good_lcd'] = '';
		$data_to_csv['watch_series_2:broken_lcd'] = '';
		$data_to_csv['watch_series_2:doa'] = '';
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
		$f_data_to_csv[] = $data_to_csv_data['Case_Size'];
		
		$f_data_to_csv[] = $data_to_csv_data['original_1st_gen:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['original_1st_gen:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['original_1st_gen:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['original_1st_gen:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['original_1st_gen:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['watch_series_1:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_1:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_1:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_1:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_1:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['watch_series_2:great_condition'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_2:noticeable_wears_and_tears'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_2:cracked_glass_good_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_2:broken_lcd'];
		$f_data_to_csv[] = $data_to_csv_data['watch_series_2:doa'];
		
		$f_data_to_csv[] = $data_to_csv_data['Meta_Title'];
		$f_data_to_csv[] = $data_to_csv_data['Meta_Description'];
		$f_data_to_csv[] = $data_to_csv_data['Meta_Keywords'];

		fputcsv($fp, $f_data_to_csv);
	}
}
?>