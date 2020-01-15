<?php 
$file_name="custom_fields";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch signle editable model data
$m_q = mysqli_query($db,"select * from mobile where id = '".$id."'");
$row_pro = mysqli_fetch_assoc($m_q);
//$rrr = explode(",",$row_pro['cstm_group_id']);

$no_of_fields = 0;
$sql_cus_grp = "select * from custom_group where id = '".$id."'";
$exe_cus_grp = mysqli_query($db,$sql_cus_grp);
$row_cus_grp = mysqli_fetch_assoc($exe_cus_grp);
$rrr = explode(",",$row_cus_grp['group_id']);

$sql_grp = "select * from groups order by id asc";
$exe_grp = mysqli_query($db,$sql_grp);
?>

<link href="plugins/nestable/jquery.nestable.css" rel="stylesheet" />
<style type="text/css">
.ui-state-default{
	background: inherit;
    list-style: none;
    border: none;
}
#sortable_1 {
	margin:0px;
	padding:0px;
}
.nav.nav-pills .nav-item {
	margin-left:0px !important;
}
</style>

<?php
//Template file
require_once("views/add_custom_fields.php");

//Footer section
require_once("include/footer.php"); ?>
