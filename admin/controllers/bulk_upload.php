<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
if(isset($post['b_upload'])) {	
	 $file = $_FILES["bulk_upload"]["tmp_name"];
	 $handle = fopen($file, "r");
	 $c = 0;
	 while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
	 {
	 	/*echo $mobile_id; echo "&nbsp;"; echo $mobile_title; echo "&nbsp;"; echo $storage_capacity; echo "&nbsp;";echo $offer_new; echo "&nbsp;";echo $offer_mint; echo "&nbsp;";echo $offer_good; echo "&nbsp;";echo $offer_fair; echo "&nbsp;";echo $offer_broken; echo "&nbsp;";echo $offer_damaged; echo "<br>";
		 $mobile_title = $filesop[0];*/
		$mobile_title = $filesop[0];
		 $getId = mysqli_query($db, "SELECT id FROM mobile WHERE title = '".$mobile_title."'");
		  while($r = mysqli_fetch_array($getId)){
		  	$mobile_id = $r['id'];
		  }
		 $carrier_title = $filesop[1];
		 $storage_capacity = $filesop[2];
		 $offer_new = $filesop[3];
		 $offer_mint = $filesop[4];
		 $offer_good = $filesop[5];
		 $offer_fair = $filesop[6];
		 $offer_broken = $filesop[7];
		 $offer_damaged = $filesop[8];

		 if($offer_new==''){
		 	$offer_new = 0;
		 }
		 if($offer_mint==''){
		 	$offer_mint = 0;
		 }
		 if($offer_good==''){
		 	$offer_good = 0;
		 }
		 if($offer_fair==''){
		 	$offer_fair = 0;
		 }
		 if($offer_broken ==''){
		 	$offer_broken = 0;
		 }
		 if($offer_damaged==''){
		 	$offer_damaged = 0;
		 }
		 

	 	$sql = mysqli_query($db,'INSERT INTO reference_prices (mobile_id,carrier_title,storage_capacity,offer_new,offer_mint,offer_good,offer_fair,offer_broken,offer_damaged) VALUES ('.$mobile_id.',"'.$carrier_title.'","'.$storage_capacity.'",'.$offer_new.','.$offer_mint.','.$offer_good.','.$offer_fair.','.$offer_broken.','.$offer_damaged.')');
	 }


	 if($sql){
	  $msg = "Your data has been saved";
	  $_SESSION['success_msg']=$msg;
	 }else{
	  $msg = "Sorry! There is some problem." .mysqli_error($db);
	  $_SESSION['error_msg']=$msg;
	 }
	 setRedirect(ADMIN_URL.'mobile_bulk_upload.php');

} elseif(isset($post['b_upload_edit'])) {	
	 $file = $_FILES["bulk_upload"]["tmp_name"];
	 $handle = fopen($file, "r");
	 $c = 0;
	 while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
	 {
		 $mobile_title = $filesop[0];
		 $carrier_title = $filesop[1];
		 $storage_capacity = $filesop[2];
		 $offer_new = $filesop[3];
		 $offer_mint = $filesop[4];
		 $offer_good = $filesop[5];
		 $offer_fair = $filesop[6];
		 $offer_broken = $filesop[7];
		 $offer_damaged = $filesop[8];
		 $id = $filesop[9];

		 echo $id;
		 if($offer_new==''){
		 	$offer_new = 0;
		 }
		 if($offer_mint==''){
		 	$offer_mint = 0;
		 }
		 if($offer_good==''){
		 	$offer_good = 0;
		 }
		 if($offer_fair==''){
		 	$offer_fair = 0;
		 }
		 if($offer_broken ==''){
		 	$offer_broken = 0;
		 }
		 if($offer_damaged==''){
		 	$offer_damaged = 0;
		 }
		 

	 	$sql = mysqli_query($db,'UPDATE reference_prices SET carrier_title = "'.$carrier_title.'", storage_capacity = "'.$storage_capacity.'", offer_new = '.$offer_new.', offer_mint = '.$offer_mint.', offer_good = '.$offer_good.',offer_fair = '.$offer_fair.', offer_broken = '.$offer_broken.', offer_damaged = '.$offer_damaged.' WHERE id = '.$id.' ');
	 }


	 if($sql){
	 $msg = "You data has been saved";
	 $_SESSION['success_msg'] = $msg;
	 }else{
	  $msg = "Sorry! There is some problem.";
	  $_SESSION['error_msg'] = $msg;
	 }
	 setRedirect(ADMIN_URL.'mobile_bulk_upload.php');
}
elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM reference_prices WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'mobile_bulk_upload.php');
}
elseif(isset($post['d_id'])) {
	
	$query=mysqli_query($db,'DELETE FROM reference_prices WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		$msg="Deleted Successfully.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile_bulk_upload.php');
}

elseif(isset($post['bulk_edit'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$edited_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$edited_idd[] = $id_v;
			$query=mysqli_query($db,'SELECT * FROM reference_prices WHERE id="'.$id_v.'"');
		}
	}

	if($query) {
		$msg="Successfully Redirected.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Updating failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_mobile_bulk.php');
}

elseif(isset($post['bulk_edit_save'])) {

	$ids_array = explode(',',$post['ids']);
	$countIds = count($ids_array);
	for ($i=0; $i <=$countIds ; $i++) { 
	 $carrier_title = real_escape_string($post['carrier_title'][$i]);
	 $storage_capacity = real_escape_string($post['storage_capacity'][$i]);
	 $offer_new = real_escape_string($post['offer_new'][$i]);
	 $offer_mint = real_escape_string($post['offer_mint'][$i]);
	 $offer_good = real_escape_string($post['offer_good'][$i]);
	 $offer_fair = real_escape_string($post['offer_fair'][$i]);
	 $offer_broken = real_escape_string($post['offer_broken'][$i]);
	 $offer_damaged = real_escape_string($post['offer_damaged'][$i]);
	$query = mysqli_query($db, 'UPDATE reference_prices SET carrier_title = "'.$carrier_title.'", storage_capacity = "'.$storage_capacity.'", offer_new = "'.$offer_new.'", offer_mint = "'.$offer_mint.'", offer_good = "'.$offer_good.'",offer_fair = "'.$offer_fair.'", offer_broken = "'.$offer_broken.'", offer_damaged = "'.$offer_damaged.'" WHERE id = "'.$mobile_id.'" ');
	}

	if($query) {
		$msg="Successfully Updated Bulk records.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Updating failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile_bulk_upload.php');
}
//Update data
elseif (isset($post['s_upload'])) {
	 $mobile_id = real_escape_string($post['id']);
	 $carrier_title = real_escape_string($post['carrier_title']);
	 $storage_capacity = real_escape_string($post['storage_capacity']);
	 $offer_new = real_escape_string($post['offer_new']);
	 $offer_mint = real_escape_string($post['offer_mint']);
	 $offer_good = real_escape_string($post['offer_good']);
	 $offer_fair = real_escape_string($post['offer_fair']);
	 $offer_broken = real_escape_string($post['offer_broken']);
	 $offer_damaged = real_escape_string($post['offer_damaged']);
	if(isset($post['id']))
	{
		//echo $mobile_id;
		$query = mysqli_query($db, 'UPDATE reference_prices SET carrier_title = "'.$carrier_title.'", storage_capacity = "'.$storage_capacity.'", offer_new = "'.$offer_new.'", offer_mint = "'.$offer_mint.'", offer_good = "'.$offer_good.'",offer_fair = "'.$offer_fair.'", offer_broken = "'.$offer_broken.'", offer_damaged = "'.$offer_damaged.'" WHERE id = "'.$mobile_id.'" ');
		if($query=="1"){
			$msg="Data Updated Successfully.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong. Update failed.';
			$_SESSION['error_msg']=$msg;
		}
	}
	else
	{
		$query = mysqli_query($db,"INSERT INTO reference_prices (mobile_id, carrier_title, storage_capacity, offer_new, offer_mint, offer_good, offer_fair, offer_broken, offer_damaged) VALUES ('$mobile_id', '$carrier_title', '$storage_capacity', '$offer_new', '$offer_mint', '$offer_good', '$offer_fair', '$offer_broken','$offer_damaged')");
		if($query=="1"){
			$msg="Data Inserted Successfully.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong. Insert failed.';
			$_SESSION['error_msg']=$msg;
		}
	}

	setRedirect(ADMIN_URL.'mobile_bulk_upload.php');
	
}

/*********** Export CSV function *************/
elseif(isset($_POST["ExportType"]))
{
	$data = mysqli_query($db,"SELECT  a.title, b.carrier_title, b.storage_capacity, b.offer_new, b.offer_mint, b.offer_good,b.offer_fair, b.offer_broken, b.offer_damaged,b.id
		FROM mobile a, reference_prices b WHERE a.id = b.mobile_id"); 
    switch($_POST["ExportType"])
    {
		case "export-to-csv" :
            // Submission from
			$filename = 'model-details' . ".csv";		 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			ExportCSVFile($data);
			//$_POST["ExportType"] = '';
            exit();
        default :
            die("Unknown action : ".$_POST["action"]);
            break;
    }
    setRedirect(ADMIN_URL.'mobile_bulk_upload.php');
}
function ExportCSVFile($records) {
	// create a file pointer connected to the output stream
	$fh = fopen( 'php://output', 'w' );
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // output the column headings
			  fputcsv($fh, array_keys($row));
			  $heading = true;
			}
			// loop over the rows, outputting them
			 fputcsv($fh, array_values($row));
			 
		  }
		  fclose($fh);
}
/*********** Export CSV function *************/

exit();
?>
