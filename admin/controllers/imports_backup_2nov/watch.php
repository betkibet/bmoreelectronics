<?php
$Case_Size = $excel_file_data[6];

$original_1st_gen__great_condition = $excel_file_data[7];
$original_1st_gen__noticeable_wears_and_tears = $excel_file_data[8];
$original_1st_gen__cracked_glass_good_lcd = $excel_file_data[9];
$original_1st_gen__broken_lcd = $excel_file_data[10];
$original_1st_gen__doa = $excel_file_data[11];
$watch_series_1__great_condition = $excel_file_data[12];
$watch_series_1__noticeable_wears_and_tears = $excel_file_data[13];
$watch_series_1__cracked_glass_good_lcd = $excel_file_data[14];
$watch_series_1__broken_lcd = $excel_file_data[15];
$watch_series_1__doa = $excel_file_data[16];
$watch_series_2__great_condition = $excel_file_data[17];
$watch_series_2__noticeable_wears_and_tears = $excel_file_data[18];
$watch_series_2__cracked_glass_good_lcd = $excel_file_data[19];
$watch_series_2__broken_lcd = $excel_file_data[20];
$watch_series_2__doa = $excel_file_data[21];

$Meta_Title = $excel_file_data[22];
$Meta_Description = $excel_file_data[23];
$Meta_Keywords = $excel_file_data[24];

$great_condition_key_nm = 'great condition';
$noticeable_wears_and_tears_key_nm = 'noticeable wears and tears';
$cracked_glass_good_lcd_key_nm = 'cracked glass, good LCD';
$broken_lcd_key_nm = 'Broken lcd';
$doa_key_nm = 'DOA';

$original_1st_gen_gnrs_key_nm = 'Original (1st Gen)';
$watch_series_1_gnrs_key_nm = 'Watch Series 1';
$watch_series_2_gnrs_key_nm = 'Watch Series 2';

$condition_name_array = array($great_condition_key_nm,$noticeable_wears_and_tears_key_nm,$cracked_glass_good_lcd_key_nm,$broken_lcd_key_nm,$doa_key_nm);
$generation_name_array = array($original_1st_gen_gnrs_key_nm,$watch_series_1_gnrs_key_nm,$watch_series_2_gnrs_key_nm);

if($model_title_slug!=$model_title_slug_tmp) {
	$p_cond_price_array = array();
	$case_size_array = array();
}

$case_size_array[] = $Case_Size;

$p_cond_price_array[$original_1st_gen_gnrs_key_nm][$Case_Size][$great_condition_key_nm] = $original_1st_gen__great_condition;
$p_cond_price_array[$original_1st_gen_gnrs_key_nm][$Case_Size][$noticeable_wears_and_tears_key_nm] = $original_1st_gen__noticeable_wears_and_tears;
$p_cond_price_array[$original_1st_gen_gnrs_key_nm][$Case_Size][$cracked_glass_good_lcd_key_nm] = $original_1st_gen__cracked_glass_good_lcd;
$p_cond_price_array[$original_1st_gen_gnrs_key_nm][$Case_Size][$broken_lcd_key_nm] = $original_1st_gen__broken_lcd;
$p_cond_price_array[$original_1st_gen_gnrs_key_nm][$Case_Size][$doa_key_nm] = $original_1st_gen__doa;

$p_cond_price_array[$watch_series_1_gnrs_key_nm][$Case_Size][$great_condition_key_nm] = $watch_series_1__great_condition;
$p_cond_price_array[$watch_series_1_gnrs_key_nm][$Case_Size][$noticeable_wears_and_tears_key_nm] = $watch_series_1__noticeable_wears_and_tears;
$p_cond_price_array[$watch_series_1_gnrs_key_nm][$Case_Size][$cracked_glass_good_lcd_key_nm] = $watch_series_1__cracked_glass_good_lcd;
$p_cond_price_array[$watch_series_1_gnrs_key_nm][$Case_Size][$broken_lcd_key_nm] = $watch_series_1__broken_lcd;
$p_cond_price_array[$watch_series_1_gnrs_key_nm][$Case_Size][$doa_key_nm] = $watch_series_1__doa;

$p_cond_price_array[$watch_series_2_gnrs_key_nm][$Case_Size][$great_condition_key_nm] = $watch_series_2__great_condition;
$p_cond_price_array[$watch_series_2_gnrs_key_nm][$Case_Size][$noticeable_wears_and_tears_key_nm] = $watch_series_2__noticeable_wears_and_tears;
$p_cond_price_array[$watch_series_2_gnrs_key_nm][$Case_Size][$cracked_glass_good_lcd_key_nm] = $watch_series_2__cracked_glass_good_lcd;
$p_cond_price_array[$watch_series_2_gnrs_key_nm][$Case_Size][$broken_lcd_key_nm] = $watch_series_2__broken_lcd;
$p_cond_price_array[$watch_series_2_gnrs_key_nm][$Case_Size][$doa_key_nm] = $watch_series_2__doa;

$model_data_array[$model_title_slug] = array('Model_ID'=>$Model_ID,
						'Category_Title'=>$Category_Title,
						'Brand_Title'=>$Brand_Title,
						'Device_Title'=>$Device_Title,
						'Model_Title'=>$Model_Title,
						'Meta_Title'=>$Meta_Title,
						'Meta_Description'=>$Meta_Description,
						'Meta_Keywords'=>$Meta_Keywords,
						'Model_Image'=>$Model_Image,
						'fields_cat_type'=>$fields_cat_type,

						'case_size_array'=>$case_size_array,
						'condition_name_array'=>$condition_name_array,
						'generation_name_array'=>$generation_name_array,
						'p_cond_price_array'=>$p_cond_price_array);

$model_title_slug_tmp = $model_title_slug;
?>