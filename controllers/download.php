<?php
$download_link = $_REQUEST['download_link'];
if($_REQUEST['download_link']!="") {
	if(function_exists('mime_content_type')) {
		$mtype = mime_content_type($download_link);
	} elseif(function_exists('finfo_file')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mtype = finfo_file($finfo, $download_link);
		finfo_close($finfo);  
	} else {
		$mtype = "application/force-download";
	}

	header('Content-Description: File Transfer');
	header("Content-Disposition: attachment; filename=\"".basename($download_link)."\"");
	//header("Content-Type:".$mtype);
	header("Content-Type:application/pdf");
	header('Content-Length:'.filesize($download_link));
	readfile($download_link);
}