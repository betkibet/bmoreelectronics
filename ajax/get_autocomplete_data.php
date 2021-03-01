<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

//$list_of_model = '';
$model_list_arr = array();
$model_list_json = '';
$query = $_REQUEST['query'];
if($query) {
	$m_query = mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND (m.title LIKE '%".$query."%' OR b.title LIKE '%".$query."%' OR concat(b.title,' ', m.title) LIKE '%".$query."%') ORDER BY m.ordering ASC");
	while($model_data = mysqli_fetch_assoc($m_query)) {
		//$name = $model_data['brand_title'].' '.$model_data['title'];
		$name = $model_data['title'];
		$url = SITE_URL.$model_details_page_slug.$model_data['sef_url'];//.'/'.$model_data['id'];
		
		$md_img_path = "";
		if($model_data['model_img']) {
			$md_img_path = SITE_URL.'images/mobile/'.$model_data['model_img'];
		}
		
		$model_list_arr[] = array("value"=>$name,"url"=>$url,"img"=>$md_img_path);
		//$list_of_model .= '{"value":"'.$name.'", "url":"'.$url.'", "img":"'.$md_img_path.'"},';
	}

	if(!empty($model_list_arr)) {
		$model_list_json = json_encode($model_list_arr, JSON_HEX_APOS);
	}
}

echo '{
		"query": "Unit",
		"suggestions": '.$model_list_json.'
	}';

/*echo '{
		"query": "Unit",
		"suggestions": ['.rtrim($list_of_model,',').']
	}';*/
?>