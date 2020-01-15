<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

//$query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND brand_id='".$post['brand_id']."'");
$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.brand_id='".$post['brand_id']."' AND b.id='".$post['brand_id']."' GROUP BY m.device_id ORDER BY d.ordering ASC");
echo '<option value="">Please Choose</option>';
while($device_list=mysqli_fetch_assoc($query)) {
	echo '<option value="'.$device_list['id'].'">'.$device_list['title'].'</option>';
}	
?>