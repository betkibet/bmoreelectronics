<?php
$Model = $excel_file_data[5];
$Processor_Title = $excel_file_data[6];
$Ram_Title = $excel_file_data[7];
$Storage_Title = $excel_file_data[8];
$Graphics_Card = $excel_file_data[9];
$Offer_New = $excel_file_data[10];
$Offer_Mint = $excel_file_data[11];
$Offer_Good = $excel_file_data[12];
$Offer_Fair = $excel_file_data[13];
$Offer_Broken = $excel_file_data[14];
$Offer_Damaged = $excel_file_data[15];
$Meta_Title = $excel_file_data[16];
$Meta_Description = $excel_file_data[17];
$Meta_Keywords = $excel_file_data[18];

$conditions_array[$Model_ID][$Model][$Processor_Title][$Ram_Title][$Storage_Title][$Graphics_Card] = array(
						'New'=>$Offer_New,
						'Mint'=>$Offer_Mint,
						'Good'=>$Offer_Good,
						'Fair'=>$Offer_Fair,
						'Broken'=>$Offer_Broken,
						'Damaged'=>$Offer_Damaged,
					);

$ram_array[$Model_ID][$Ram_Title] = $Ram_Title;
$processor_array[$Model_ID][$Processor_Title] = $Processor_Title;
$storage_array[$Model_ID][$Storage_Title] = $Storage_Title;
$model_array[$Model_ID][$Model] = $Model;
$graphics_card_array[$Model_ID][$Graphics_Card] = $Graphics_Card;

$model_data_array[$Model_ID] = array('Model_ID'=>$Model_ID,
						'Category_Title'=>$Category_Title,
						'Brand_Title'=>$Brand_Title,
						'Device_Title'=>$Device_Title,
						'Model_Title'=>$Model_Title,
						'Model_Image'=>$Model_Image,

						'prices_array'=>$conditions_array[$Model_ID],
						'ram_array'=>$ram_array[$Model_ID],
						'processor_array'=>$processor_array[$Model_ID],
						'storage_array'=>$storage_array[$Model_ID],
						'model_array'=>$model_array[$Model_ID],
						'graphics_card_array'=>$graphics_card_array[$Model_ID],
						'condition_array'=>array('New'=>'New','Mint'=>'Mint','Good'=>'Good','Fair'=>'Fair','Broken'=>'Broken','Damaged'=>'Damaged'),
						'Meta_Title'=>$Meta_Title,
						'Meta_Description'=>$Meta_Description,
						'Meta_Keywords'=>$Meta_Keywords,
						'fields_cat_type'=>$fields_cat_type
					);
?>