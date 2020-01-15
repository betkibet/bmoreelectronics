<?php
//Get brand data list based on catID
function get_brand_data_list($cat_id) {
	global $db;
	$response = array();

	$sql_whr = "";
	if($cat_id>0) {
		 $sql_whr = "AND m.cat_id='".$cat_id."'";
	}
	
	$brand_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title, b.image AS brand_image, b.description AS brand_desc, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.brand_id>0 ".$sql_whr." GROUP BY b.id ORDER BY m.id DESC");
	$brand_num_of_rows = mysqli_num_rows($brand_query);
	if($brand_num_of_rows>0) {
		while($brand_list=mysqli_fetch_assoc($brand_query)) {
			$response[] = $brand_list;
		}
	}
	return $response;
}
?>
