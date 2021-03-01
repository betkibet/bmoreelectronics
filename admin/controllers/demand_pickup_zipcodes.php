<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

if(isset($post['update'])) {
	$zipcodes = real_escape_string($post['zipcodes']);
	$url = real_escape_string($post['url']);
	
	$zip_arr = array();
	if($zipcodes) {
		$zip_arr = explode(',',$zipcodes);
	}

	$import_zip_arr = array();
	if($_FILES['file_name']['name'] != "") {
		$path = str_replace(' ','_',$_FILES['file_name']['name']);
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		if($ext=="csv" || $ext=="xls" || $ext=="xlsx") {

			$filename=$_FILES['file_name']['tmp_name'];
			move_uploaded_file($filename,'../uploaded_file/'.$path);
			
			$data_imported = false;
			$excel_file_path = '../uploaded_file/'.$path;
			require('../libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
			require('../libraries/spreadsheet-reader-master/SpreadsheetReader.php');
			$excel_file_data_list = new SpreadsheetReader($excel_file_path);
			foreach($excel_file_data_list as $ek=>$excel_file_data)
			{
				$import_zip = $excel_file_data[0];
				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($import_zip!="") {
						$import_zip_arr[] = real_escape_string($import_zip);
						$data_imported = true;
					}
				}
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'demand_pickup_zipcodes.php');
			exit;
		}
	}
	
	$f_zip_arr = array_unique(array_merge($zip_arr,$import_zip_arr));
	$zip_code_dt = '';
	if(!empty($f_zip_arr)) {
		$zip_code_dt = implode(',',$f_zip_arr);
	}
	
	if($post['id']) {
		$query=mysqli_query($db,"UPDATE demand_pickup_zipcodes SET zipcodes='".$zip_code_dt."',url='".$url."' WHERE id='".$post['id']."'");
		if($query=="1") {
			$msg="Zipcodes has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'demand_pickup_zipcodes.php');
	}
} else {
	setRedirect(ADMIN_URL.'demand_pickup_zipcodes.php');
}
exit();
?>