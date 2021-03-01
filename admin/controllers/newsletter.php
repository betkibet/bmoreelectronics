<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM newsletters WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM newsletters WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['active_id'])) {
	$query=mysqli_query($db,"UPDATE newsletters SET status='1' WHERE id='".$post['active_id']."'");
	if($query=="1") {
		$msg="Record successfully Activated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['inactive_id'])) {
	$query=mysqli_query($db,"UPDATE newsletters SET status='0' WHERE id='".$post['inactive_id']."'");
	if($query=="1") {
		$msg="Record successfully Inactivated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['send_email'])) {
	$type = $post['type'];
	$content = $post['content'];

	if($type == "all") {
		$n_l_query = mysqli_query($db,"SELECT * FROM newsletters WHERE status='1' ORDER BY id ASC");
		$n_l_num_rows = mysqli_num_rows($n_l_query);
		if($n_l_num_rows>0) {
			while($newsletter_data=mysqli_fetch_assoc($n_l_query)) {
				$send_email_arr[] = $newsletter_data['email'];
			}
		}
	} else {
		$send_email_arr = $post['email_address'];
	}
	
	$is_email_send = false;
	if(!empty($send_email_arr)) {
		
		$admin_user_data = get_admin_user_data();

		foreach($send_email_arr as $k=>$send_email) {
			$shipment_label_email_to_customer = get_template_data('newsletter_email_to_bulk_customer');
			
			$patterns = array(
				'{$logo}',
				'{$admin_logo}',
				'{$admin_email}',
				'{$admin_username}',
				'{$admin_site_url}',
				'{$admin_panel_name}',
				'{$from_name}',
				'{$from_email}',
				'{$site_name}',
				'{$site_url}',
				'{$current_date_time}',
				'{$customer_email}');
	
			$replacements = array(
				$logo,
				$admin_logo,
				$admin_user_data['email'],
				$admin_user_data['username'],
				ADMIN_URL,
				$general_setting_data['admin_panel_name'],
				$general_setting_data['from_name'],
				$general_setting_data['from_email'],
				$general_setting_data['site_name'],
				SITE_URL,
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
				$send_email);
		
			//START email send to customer
			if(!empty($shipment_label_email_to_customer)) {
				$email_subject = str_replace($patterns,$replacements,$shipment_label_email_to_customer['subject']);
				$email_body_text = str_replace($patterns,$replacements,$shipment_label_email_to_customer['content']);

				send_email($send_email, $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				$is_email_send = true;
			} //END email send to customer
		}
	}
	
	if($is_email_send) {
		$msg='Bulk email has been successfully send to customer(s).';
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Criteria not match so please activate status of customer(s) & try again.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'newsletter.php');
	exit();
} elseif(isset($post['import'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'newsletter.php');
		exit();
	} else {
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
				$email = $excel_file_data[0];
				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($email!="") {
						$qr=mysqli_query($db,"SELECT * FROM newsletters WHERE email='".$email."'");
						$exist_mobile_data=mysqli_fetch_assoc($qr);
						if(empty($exist_mobile_data)) {
							mysqli_query($db,"INSERT INTO newsletters(email, date) VALUES('".$email."','".date('Y-m-d H:i:s')."')");
							//$l_nl_id = mysqli_insert_id($db);
							$data_imported = true;
						} else {
							mysqli_query($db,"UPDATE newsletters SET email='".$email."',date='".date('Y-m-d H:i:s')."' WHERE email='".$email."'");
							$data_imported = true;
						}
					}
				}
			}
			if($data_imported) {
				unlink($excel_file_path);
				$msg="Data(s) successfully imported.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong imported failed.';
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['error_msg']=$msg;
		}
	}
	setRedirect(ADMIN_URL.'newsletter.php');
} elseif(isset($post['export'])) {
	$ids = $post['ids'];
	$query = mysqli_query($db,"SELECT * FROM newsletters WHERE status = '1' ORDER BY id ASC");
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'newsletter-'.date("YmdHis").".csv";
		$fp = fopen('php://output', 'w');
		//$fp = fopen('../../uploaded_file/'.$filename, 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		$header = array('Email_Address');
		fputcsv($fp, $header);

		$data_to_csv_array = array();
		while($newsletter_data=mysqli_fetch_assoc($query)) {
			$data_to_csv = array();
			$data_to_csv['Email_Address'] = $newsletter_data['email'];
			$data_to_csv_array[] = $data_to_csv;
		}

		if(!empty($data_to_csv_array)) {
			foreach($data_to_csv_array as $data_to_csv_data) {
				$f_data_to_csv = array();
				$f_data_to_csv[] = $data_to_csv_data['Email_Address'];
				fputcsv($fp, $f_data_to_csv);
			}
		}
		exit;
	}
}
setRedirect(ADMIN_URL.'newsletter.php');
exit();
?>