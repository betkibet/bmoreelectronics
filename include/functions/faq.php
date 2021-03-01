<?php
function get_faqs_list($limit = 0, $is_show_in_home_page = 0, $is_rand = '') {
	global $db;
	$response = array();
	
	$order_limit_pr = '';
	
	if($is_rand == 1) {
		$order_limit_pr .= ' ORDER BY RAND()';
	}
	
	if($limit > 0) {
		$order_limit_pr .= ' LIMIT '.$limit;
	}
	
	$whr_params = '';
	if($is_show_in_home_page == 1) {
		$whr_params .= " AND is_show_in_home_page=1";
	}
	
	$query=mysqli_query($db,"SELECT * FROM faqs WHERE status=1 ".$whr_params.$order_limit_pr);
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($faqs_data=mysqli_fetch_assoc($query)) {
			$response[] = $faqs_data;
		}
	}
	return $response;
}

function get_faqs_with_html($active_page_data = array()) {
	global $db;
	$response = array();
	$html = '';
	$data = array();

	$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$n = 0;
		
		$html .= '<div class="accordion" id="accordion">';
			while($faq_data=mysqli_fetch_assoc($query)) {
			  $data[] = $faq_data;
			  $n = $n+1;
			  $html .= '<div class="card">
				<div class="card-header" id="headingOne'.$n.'">
				  <h2 class="mb-0">
					<button class="btn btn-link '.($n == 1?'':'collapsed').'" type="button" data-toggle="collapse" data-target="#collapseOne'.$n.'" aria-expanded="'.($n == 1?'true':'false').'" aria-controls="collapseOne'.$n.'">'.$faq_data['title'].'<span><img class="plus" src="images/icons/plus_icon.png" alt="plus icon"><img class="minus" src="images/icons/minus_icon.png" alt="minus icon"></span>
					</button>
				  </h2>
				</div>
				<div id="collapseOne'.$n.'" class="collapse '.($n == 1?'show':'').'" aria-labelledby="headingOne" data-parent="#accordion">
				  <div class="card-body">';
					$html .= $faq_data['description'];
				  $html .= '</div>
				</div>
			  </div>';
			}
		$html .= '</div>';
		$response['data'] = $data;
		$response['html'] = $html;
	}
	return $response;
}

function get_faqs_groups_with_html($active_page_data = array(), $cat_id = 0, $type = "") {
	global $db;
	$response = array();
	$html = '';
	$data = array();

	$g_sql_params = "";
	if(!empty($cat_id)) {
	
		if($type == "model_details") {
			$cat_id_array = array($cat_id);
			//$g_sql_params .= " AND cat_id='".$cat_id."'";
			$g_sql_params .= " AND show_in_model_details='1'";
		} elseif($type == "model_list") {
			$cat_id_array = $cat_id;
			//$g_sql_params .= " AND cat_id IN(".implode(",",$cat_id).")";
			$g_sql_params .= " AND show_in_model_list='1'";
		}

		foreach($cat_id_array as $cat_id_k => $cat_id) {
			$g_query=mysqli_query($db,"SELECT * FROM faqs_groups WHERE status='1' AND FIND_IN_SET(".$cat_id.", cat_id)
".$g_sql_params." ORDER BY ordering ASC");
			$num_of_g_rows = mysqli_num_rows($g_query);
			if($num_of_g_rows>0) {
				$html .= '<h2 class="page_title text-center mt-4">Some <strong>questions</strong> you may have</h2>';
				$html .= '<div class="accordion" id="accordion">';
				$n = 0;
				while($faq_group_data=mysqli_fetch_assoc($g_query)) {
					$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' AND group_id='".$faq_group_data['id']."' ORDER BY ordering ASC");
					$num_of_rows = mysqli_num_rows($query);
					if($num_of_rows>0) {
						while($faq_data=mysqli_fetch_assoc($query)) {
							$data[] = $faq_data;
							$n = $n+1;
							$html .= '<div class="card">
							 <div class="card-header" id="headingOne'.$n.'">
							  	<h3 class="mb-0">
									<button class="btn btn-link '.($n == 1?'':'collapsed').'" type="button" data-toggle="collapse" data-target="#collapseOne'.$n.'" aria-expanded="'.($n == 1?'true':'false').'" aria-controls="collapseOne'.$n.'">'.$faq_data['title'].'<span><img class="plus" src="../images/icons/plus_icon.png" alt="plus icon"><img class="minus" src="../images/icons/minus_icon.png" alt="minus icon"></span>
									</button>
							  	</h3>
							</div>
							<div id="collapseOne'.$n.'" class="collapse '.($n == 1?'show':'').'" aria-labelledby="headingOne" data-parent="#accordion">
								  <div class="card-body">';
									$html .= $faq_data['description'];
								  $html .= '</div>
								</div>
							
							</div>';
						}
					}
				}
				$html .= '</div>';
			}
		}
	} else {
		$g_query=mysqli_query($db,"SELECT * FROM faqs_groups WHERE status='1'".$g_sql_params." ORDER BY ordering ASC");
		$num_of_g_rows = mysqli_num_rows($g_query);
		if($num_of_g_rows>0) {
			$html .= '<div class="row"><div class="col-md-12">';
			$n = 0;
			while($faq_group_data=mysqli_fetch_assoc($g_query)) {
				$html .= '<div class="block clearfix"><div class="h2 text-center">'.$faq_group_data['title'].'</div>';
					$html .= '<script>$(function(){$("#accordion'.$faq_group_data['id'].'").accordion({heightStyle:"content"});});</script>';
					$html .= '<div id="accordion'.$faq_group_data['id'].'" class="faq_accordian">';
	
					$query=mysqli_query($db,"SELECT * FROM faqs WHERE status='1' AND group_id='".$faq_group_data['id']."' ORDER BY ordering ASC");
					$num_of_rows = mysqli_num_rows($query);
					if($num_of_rows>0) {
						while($faq_data=mysqli_fetch_assoc($query)) {
							$data[] = $faq_data;
							$n = $n+1;
							
							$html .= '<h3>'.$faq_data['title'].'</h3>';
							$html .= '<div>';
								$html .= $faq_data['description'];
							$html .= '</div>';
						}
					}
					
					$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div></div>';		
		}
	}
	$response['data'] = $data;
	$response['html'] = $html;
	return $response;
}
?>