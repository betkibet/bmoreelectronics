<?php
$Storage_Title = $excel_file_data[6];

$wi_fi_cellular__great_condition = $excel_file_data[7];
$wi_fi_cellular__noticeable_wears_and_tears = $excel_file_data[8];
$wi_fi_cellular__cracked_glass_good_lcd = $excel_file_data[9];
$wi_fi_cellular__broken_lcd = $excel_file_data[10];
$wi_fi_cellular__doa = $excel_file_data[11];
$wi_fi_only__great_condition = $excel_file_data[12];
$wi_fi_only__noticeable_wears_and_tears = $excel_file_data[13];
$wi_fi_only__cracked_glass_good_lcd = $excel_file_data[14];
$wi_fi_only__broken_lcd = $excel_file_data[15];
$wi_fi_only__doa = $excel_file_data[16];

$Meta_Title = $excel_file_data[17];
$Meta_Description = $excel_file_data[18];
$Meta_Keywords = $excel_file_data[19];

$great_condition_key_nm = 'great condition';
$noticeable_wears_and_tears_key_nm = 'noticeable wears and tears';
$cracked_glass_good_lcd_key_nm = 'cracked glass, good LCD';
$broken_lcd_key_nm = 'Broken lcd';
$doa_key_nm = 'DOA';

$wi_fi_cellular_nwk_key_nm = 'Wi-Fi Cellular';
$wi_fi_only_nwk_key_nm = 'Wi-Fi Only';

$condition_name_array = array($great_condition_key_nm,$noticeable_wears_and_tears_key_nm,$cracked_glass_good_lcd_key_nm,$broken_lcd_key_nm,$doa_key_nm);
$connectivity_name_array = array($wi_fi_cellular_nwk_key_nm,$wi_fi_only_nwk_key_nm);

if($model_title_slug!=$model_title_slug_tmp) {
	$p_cond_price_array = array();
	$storage_size_array = array();
}

$storage_size_array[] = $Storage_Title;

$p_cond_price_array[$wi_fi_cellular_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $wi_fi_cellular__great_condition;
$p_cond_price_array[$wi_fi_cellular_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $wi_fi_cellular__noticeable_wears_and_tears;
$p_cond_price_array[$wi_fi_cellular_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $wi_fi_cellular__cracked_glass_good_lcd;
$p_cond_price_array[$wi_fi_cellular_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $wi_fi_cellular__broken_lcd;
$p_cond_price_array[$wi_fi_cellular_nwk_key_nm][$Storage_Title][$doa_key_nm] = $wi_fi_cellular__doa;

$p_cond_price_array[$wi_fi_only_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $wi_fi_only__great_condition;
$p_cond_price_array[$wi_fi_only_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $wi_fi_only__noticeable_wears_and_tears;
$p_cond_price_array[$wi_fi_only_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $wi_fi_only__cracked_glass_good_lcd;
$p_cond_price_array[$wi_fi_only_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $wi_fi_only__broken_lcd;
$p_cond_price_array[$wi_fi_only_nwk_key_nm][$Storage_Title][$doa_key_nm] = $wi_fi_only__doa;

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

						'storage_size_array'=>$storage_size_array,
						'condition_name_array'=>$condition_name_array,
						'connectivity_name_array'=>$connectivity_name_array,
						'p_cond_price_array'=>$p_cond_price_array);

$model_title_slug_tmp = $model_title_slug;
?>