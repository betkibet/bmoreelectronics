<?php
$Storage_Title = $excel_file_data[6];

$unlocked__great_condition = $excel_file_data[7];
$unlocked__noticeable_wears_and_tears = $excel_file_data[8];
$unlocked__cracked_glass_good_lcd = $excel_file_data[9];
$unlocked__broken_lcd = $excel_file_data[10];
$unlocked__doa = $excel_file_data[11];
$att__great_condition = $excel_file_data[12];
$att__noticeable_wears_and_tears = $excel_file_data[13];
$att__cracked_glass_good_lcd = $excel_file_data[14];
$att__broken_lcd = $excel_file_data[15];
$att__doa = $excel_file_data[16];
$verizon__great_condition = $excel_file_data[17];
$verizon__noticeable_wears_and_tears = $excel_file_data[18];
$verizon__cracked_glass_good_lcd = $excel_file_data[19];
$verizon__broken_lcd = $excel_file_data[20];
$verizon__doa = $excel_file_data[21];
$tmobile__great_condition = $excel_file_data[22];
$tmobile__noticeable_wears_and_tears = $excel_file_data[23];
$tmobile__cracked_glass_good_lcd = $excel_file_data[24];
$tmobile__broken_lcd = $excel_file_data[25];
$tmobile__doa = $excel_file_data[26];
$sprint__great_condition = $excel_file_data[27];
$sprint__noticeable_wears_and_tears = $excel_file_data[28];
$sprint__cracked_glass_good_lcd = $excel_file_data[29];
$sprint__broken_lcd = $excel_file_data[30];
$sprint__doa = $excel_file_data[31];
$other__great_condition = $excel_file_data[32];
$other__noticeable_wears_and_tears = $excel_file_data[33];
$other__cracked_glass_good_lcd = $excel_file_data[34];
$other__broken_lcd = $excel_file_data[35];
$other__doa = $excel_file_data[36];

$Meta_Title = $excel_file_data[37];
$Meta_Description = $excel_file_data[38];
$Meta_Keywords = $excel_file_data[39];

$great_condition_key_nm = 'great condition';
$noticeable_wears_and_tears_key_nm = 'noticeable wears and tears';
$cracked_glass_good_lcd_key_nm = 'cracked glass, good LCD';
$broken_lcd_key_nm = 'Broken lcd';
$doa_key_nm = 'DOA';

$unlocked_nwk_key_nm = 'Unlocked';
$att_nwk_key_nm = 'ATT';
$verizon_nwk_key_nm = 'Verizon';
$tmobile_nwk_key_nm = 'Tmobile';
$sprint_nwk_key_nm = 'Sprint';
$other_nwk_key_nm = 'Other';

$condition_name_array = array($great_condition_key_nm,$noticeable_wears_and_tears_key_nm,$cracked_glass_good_lcd_key_nm,$broken_lcd_key_nm,$doa_key_nm);
$network_name_array = array($unlocked_nwk_key_nm,$att_nwk_key_nm,$verizon_nwk_key_nm,$tmobile_nwk_key_nm,$sprint_nwk_key_nm,$other_nwk_key_nm);

if($model_title_slug!=$model_title_slug_tmp) {
	$p_cond_price_array = array();
	$storage_size_array = array();
}

$storage_size_array[] = $Storage_Title;

$p_cond_price_array[$unlocked_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $unlocked__great_condition;
$p_cond_price_array[$unlocked_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $unlocked__noticeable_wears_and_tears;
$p_cond_price_array[$unlocked_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $unlocked__cracked_glass_good_lcd;
$p_cond_price_array[$unlocked_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $unlocked__broken_lcd;
$p_cond_price_array[$unlocked_nwk_key_nm][$Storage_Title][$doa_key_nm] = $unlocked__doa;

$p_cond_price_array[$att_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $att__great_condition;
$p_cond_price_array[$att_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $att__noticeable_wears_and_tears;
$p_cond_price_array[$att_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $att__cracked_glass_good_lcd;
$p_cond_price_array[$att_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $att__broken_lcd;
$p_cond_price_array[$att_nwk_key_nm][$Storage_Title][$doa_key_nm] = $att__doa;

$p_cond_price_array[$verizon_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $verizon__great_condition;
$p_cond_price_array[$verizon_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $verizon__noticeable_wears_and_tears;
$p_cond_price_array[$verizon_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $verizon__cracked_glass_good_lcd;
$p_cond_price_array[$verizon_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $verizon__broken_lcd;
$p_cond_price_array[$verizon_nwk_key_nm][$Storage_Title][$doa_key_nm] = $verizon__doa;

$p_cond_price_array[$tmobile_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $tmobile__great_condition;
$p_cond_price_array[$tmobile_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $tmobile__noticeable_wears_and_tears;
$p_cond_price_array[$tmobile_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $tmobile__cracked_glass_good_lcd;
$p_cond_price_array[$tmobile_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $tmobile__broken_lcd;
$p_cond_price_array[$tmobile_nwk_key_nm][$Storage_Title][$doa_key_nm] = $tmobile__doa;

$p_cond_price_array[$sprint_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $sprint__great_condition;
$p_cond_price_array[$sprint_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $sprint__noticeable_wears_and_tears;
$p_cond_price_array[$sprint_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $sprint__cracked_glass_good_lcd;
$p_cond_price_array[$sprint_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $sprint__broken_lcd;
$p_cond_price_array[$sprint_nwk_key_nm][$Storage_Title][$doa_key_nm] = $sprint__doa;

$p_cond_price_array[$other_nwk_key_nm][$Storage_Title][$great_condition_key_nm] = $other__great_condition;
$p_cond_price_array[$other_nwk_key_nm][$Storage_Title][$noticeable_wears_and_tears_key_nm] = $other__noticeable_wears_and_tears;
$p_cond_price_array[$other_nwk_key_nm][$Storage_Title][$cracked_glass_good_lcd_key_nm] = $other__cracked_glass_good_lcd;
$p_cond_price_array[$other_nwk_key_nm][$Storage_Title][$broken_lcd_key_nm] = $other__broken_lcd;
$p_cond_price_array[$other_nwk_key_nm][$Storage_Title][$doa_key_nm] = $other__doa;

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
						'network_name_array'=>$network_name_array,
						'p_cond_price_array'=>$p_cond_price_array);

$model_title_slug_tmp = $model_title_slug;
?>