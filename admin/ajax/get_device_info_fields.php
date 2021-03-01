<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth("ajax");

$item_id = $post['item_id'];
$query = mysqli_query($db,"SELECT * FROM inventory WHERE item_id='".$item_id."'");
$inventory_data = mysqli_fetch_assoc($query);
$item_name_array = json_decode($inventory_data['item_name'],true);

$items_name = "";
$items_name .= '<table class="table table-borderless child device-info-table"><tr>';
if(!empty($item_name_array)) {
	foreach($item_name_array as $item_name_data) {
		$i_n = ($i_n+1);
		if($i_n%2==0) {
			$items_name .= '<td><strong>'.str_replace("_"," ",$item_name_data['fld_name']).'GG:</strong> ';
			$items_opt_name = "";
			foreach($item_name_data['opt_data'] as $opt_data) {
				$items_opt_name .= $opt_data['opt_name'];//.', ';
			}
			$items_name .= rtrim($items_opt_name,', ');
			$items_name .= '</td>';
		} else {
			$items_name .= '<tr><td><strong>'.str_replace("_"," ",$item_name_data['fld_name']).'BB:</strong> ';
			$items_opt_name = "";
			foreach($item_name_data['opt_data'] as $opt_data) {
				$items_opt_name .= $opt_data['opt_name'];//.', ';
			}
			$items_name .= rtrim($items_opt_name,', ');
			$items_name .= '</td>';
		}
		//$items_name .= ', ';		
	}
	$items_name = rtrim($items_name,', ');
}
$items_name .= '</tr></table>';

/*$items_name .= '<table class="table table-borderless child device-info-table device-info-table-'.$data['id'].'"><tr>';
	$opt_n = 0;
	foreach($item_name_array as $item_name_data) {
		foreach($item_name_data['opt_data'] as $opt_data) {
			if($opt_n%3==0) {
				$items_name .= '</tr><tr><td>'.$opt_data['opt_name'].'</td>';
			} else {
				$items_name .= '<td>'.$opt_data['opt_name'].'</td>';
			}
			$opt_n++;
		}
	}
$items_name .= '</tr></table>';*/
//echo '<b style="margin-left:10px;">'.$inventory_data['model'].'</b><br>'.$items_name;
?>

<div class="modal-header">
	<h5 class="modal-title" id="device_info_popup_l"><?=$inventory_data['model']?></h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<?=$items_name?>
</div>

