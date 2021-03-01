<?php
$Model = $excel_file_data[5];
$Offer_New = $excel_file_data[6];
$Offer_Mint = $excel_file_data[7];
$Offer_Good = $excel_file_data[8];
$Offer_Fair = $excel_file_data[9];
$Offer_Broken = $excel_file_data[10];
$Offer_Damaged = $excel_file_data[11];
$Meta_Title = $excel_file_data[12];
$Meta_Description = $excel_file_data[13];
$Meta_Keywords = $excel_file_data[14];

$conditions_array[$Model_ID][$Model] = array(
						'New'=>$Offer_New,
						'Mint'=>$Offer_Mint,
						'Good'=>$Offer_Good,
						'Fair'=>$Offer_Fair,
						'Broken'=>$Offer_Broken,
						'Damaged'=>$Offer_Damaged,
					);

$model_array[$Model_ID][$Model] = $Model;

$model_data_array[$Model_ID] = array('Model_ID'=>$Model_ID,
						'Category_Title'=>$Category_Title,
						'Brand_Title'=>$Brand_Title,
						'Device_Title'=>$Device_Title,
						'Model_Title'=>$Model_Title,
						'Model_Image'=>$Model_Image,

						'prices_array'=>$conditions_array[$Model_ID],
						'model_array'=>$model_array[$Model_ID],
						'condition_array'=>array('New'=>'New','Mint'=>'Mint','Good'=>'Good','Fair'=>'Fair','Broken'=>'Broken','Damaged'=>'Damaged'),
						'Meta_Title'=>$Meta_Title,
						'Meta_Description'=>$Meta_Description,
						'Meta_Keywords'=>$Meta_Keywords,
						'fields_cat_type'=>$fields_cat_type
					);
?>