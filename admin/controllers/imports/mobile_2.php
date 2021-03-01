<?php
$Carrier_Title = $excel_file_data[5];
$Storage_Title = $excel_file_data[6];
$Offer_New = $excel_file_data[7];
$Offer_Mint = $excel_file_data[8];
$Offer_Good = $excel_file_data[9];
$Offer_Fair = $excel_file_data[10];
$Offer_Broken = $excel_file_data[11];
$Offer_Damaged = $excel_file_data[12];
$Meta_Title = $excel_file_data[13];
$Meta_Description = $excel_file_data[14];
$Meta_Keywords = $excel_file_data[15];

$conditions_array[$Model_ID][$Carrier_Title][$Storage_Title] = array(
						'New'=>$Offer_New,
						'Mint'=>$Offer_Mint,
						'Good'=>$Offer_Good,
						'Fair'=>$Offer_Fair,
						'Broken'=>$Offer_Broken,
						'Damaged'=>$Offer_Damaged,
					);

$carrier_array[$Model_ID][$Carrier_Title] = $Carrier_Title;
$storage_array[$Model_ID][$Storage_Title] = $Storage_Title;

$model_data_array[$Model_ID] = array('Model_ID'=>$Model_ID,
						'Category_Title'=>$Category_Title,
						'Brand_Title'=>$Brand_Title,
						'Device_Title'=>$Device_Title,
						'Model_Title'=>$Model_Title,
						'Model_Image'=>$Model_Image,

						'prices_array'=>$conditions_array[$Model_ID],
						'carrier_array'=>$carrier_array[$Model_ID],
						'storage_array'=>$storage_array[$Model_ID],
						'condition_array'=>array('New'=>'New','Mint'=>'Mint','Good'=>'Good','Fair'=>'Fair','Broken'=>'Broken','Damaged'=>'Damaged'),
						'Meta_Title'=>$Meta_Title,
						'Meta_Description'=>$Meta_Description,
						'Meta_Keywords'=>$Meta_Keywords,
						'fields_cat_type'=>$fields_cat_type
					);
?>