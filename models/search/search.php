<?php
//Get model data list based on search by from any searchbox
function get_model_data_list($search_by) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND (d.title LIKE '%".$search_by."%' OR m.title LIKE '%".$search_by."%')");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}
?>
