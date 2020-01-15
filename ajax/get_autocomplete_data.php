<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$list_of_model = '';
$query = $_REQUEST['query'];
if($query) {
	$m_query = mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND (m.title LIKE '%".$query."%' OR b.title LIKE '%".$query."%' OR concat(b.title,' ', m.title) LIKE '%".$query."%') ORDER BY m.ordering ASC");
	while($model_data = mysqli_fetch_assoc($m_query)) {
		$name = $model_data['brand_title'].' '.$model_data['title'];
		$url = SITE_URL.$model_data['sef_url'].'/'.createSlug($model_data['title']).'/'.$model_data['id'];
		$list_of_model .= '{"value":"'.$name.'", "url":"'.$url.'"},';
	}
}

echo '{
		"query": "Unit",
		"suggestions": ['.rtrim($list_of_model,',').']
	}';
?>