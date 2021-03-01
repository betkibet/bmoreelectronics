<?php
//START for faqs
$faqs_data_html = get_faqs_with_html();
if($faqs_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs]",$faqs_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs]",'',$active_page_data['content']);
} //END for faqs

//START for faqs/groups
$faqs_groups_data_html = get_faqs_groups_with_html();
if($faqs_groups_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs_groups]",$faqs_groups_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs_groups]",'',$active_page_data['content']);
} //END for faqs/groups
?>