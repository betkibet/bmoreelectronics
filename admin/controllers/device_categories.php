<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$category_q=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$post['d_id'].'"');
	$category_data=mysqli_fetch_assoc($category_q);
	
	$query=mysqli_query($db,'DELETE FROM categories WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($category_data['image']!="")
			unlink('../../images/categories/'.$category_data['image']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$category_q=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$id_v.'"');
			$category_data=mysqli_fetch_assoc($category_q);
			if($category_data['image']!="")
				unlink('../../images/categories/'.$category_data['image']);

			$query=mysqli_query($db,'DELETE FROM categories WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE categories SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";

		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$fields_type=real_escape_string($post['fields_type']);
	$fa_icon=real_escape_string($post['fa_icon']);
	$sub_title=real_escape_string(str_replace("<p><br></p>","",$post['sub_title']));
	$short_description=real_escape_string(str_replace("<p><br></p>","",$post['short_description']));
	$description=real_escape_string(str_replace("<p><br></p>","",$post['description']));
	$published = $post['published'];
	$icon_type = $post['icon_type'];
	$sef_url=createSlug(real_escape_string($post['sef_url']));
	
	//Check Valid SEF URL
	$is_valid_sef_url_arr = check_sef_url_validation($sef_url, $post['id'], "category");
	if($is_valid_sef_url_arr['valid']!=true) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($post['id']) {
			setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
		} else {
			setRedirect(ADMIN_URL.'edit_category.php');
		}
		exit();
	}
	
	if($_FILES['image']['name']) {
		if(!file_exists('../../images/categories/'))
			mkdir('../../images/categories/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/categories/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/categories/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_category.php');
			}
			exit();
		}
	}
	
	if($_FILES['hover_image']['name']) {
		if(!file_exists('../../images/categories/'))
			mkdir('../../images/categories/',0777);

		$hover_image_ext = pathinfo($_FILES['hover_image']['name'],PATHINFO_EXTENSION);
		if($hover_image_ext=="png" || $hover_image_ext=="jpg" || $hover_image_ext=="jpeg" || $hover_image_ext=="gif") {
			if($post['old_hover_image']!="")
				unlink('../../images/categories/'.$post['old_hover_image']);

			$hover_image_tmp_name=$_FILES['hover_image']['tmp_name'];
			$hover_image_name='hover_'.date('YmdHis').'.'.$hover_image_ext;
			$hover_imageupdate=', hover_image="'.$hover_image_name.'"';
			move_uploaded_file($hover_image_tmp_name,'../../images/categories/'.$hover_image_name);
		} else {
			$msg="Hover image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_category.php');
			}
			exit();
		}
	}
	
	if($_FILES['cart_image']['name']) {
		if(!file_exists('../../images/categories/'))
			mkdir('../../images/categories/',0777);

		$cart_image_ext = pathinfo($_FILES['cart_image']['name'],PATHINFO_EXTENSION);
		if($cart_image_ext=="png" || $cart_image_ext=="jpg" || $cart_image_ext=="jpeg" || $cart_image_ext=="gif") {
			if($post['old_cart_image']!="")
				unlink('../../images/categories/'.$post['old_cart_image']);

			$cart_image_tmp_name=$_FILES['cart_image']['tmp_name'];
			$cart_image_name='cart_'.date('YmdHis').'.'.$cart_image_ext;
			$cart_imageupdate=', cart_image="'.$cart_image_name.'"';
			move_uploaded_file($cart_image_tmp_name,'../../images/categories/'.$cart_image_name);
		} else {
			$msg="Cart image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_category.php');
			}
			exit();
		}
	}
	
	function save_category_fields($cat_id,$post) {
		global $db;
		
		//START save/update for storage section
		$saved_storage_ids = array();
		if(empty($post['storage_size'])) {
			mysqli_query($db,"DELETE FROM category_storage WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['storage_size'])) {
			$storage_i_q=mysqli_query($db,'SELECT * FROM category_storage WHERE cat_id="'.$cat_id.'"');
			$initial_storage_data_rows=mysqli_num_rows($storage_i_q);

			foreach($post['storage_size'] as $key=>$value) {
				if(trim($value)) {
					if($initial_storage_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_storage(cat_id, storage_size, storage_size_postfix, top_seller) values("'.$cat_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['top_seller'][$key].'")');
						$saved_storage_ids[] = mysqli_insert_id($db);
					} else {
						$storage_q=mysqli_query($db,'SELECT * FROM category_storage WHERE cat_id="'.$cat_id.'" AND id="'.$key.'"');
						$category_storage_data=mysqli_fetch_assoc($storage_q);
						if(empty($category_storage_data)) {
							$query=mysqli_query($db,'INSERT INTO category_storage(cat_id, storage_size, storage_size_postfix, top_seller) values("'.$cat_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['top_seller'][$key].'")');
							$saved_storage_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_storage SET storage_size="'.$post['storage_size'][$key].'", storage_size_postfix="'.$post['storage_size_postfix'][$key].'", top_seller="'.$post['top_seller'][$key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$key.'"');
							$saved_storage_ids[] = $key;
						}
					}
				}
			}
		}
		if(!empty($saved_storage_ids)) {
			mysqli_query($db,"DELETE FROM category_storage WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_storage_ids).")");
		} //END save/update for storage section

		//START save/update for condition section
		$saved_condition_ids = array();
		if(empty($post['condition_name'])) {
			mysqli_query($db,"DELETE FROM category_condition WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['condition_name'])) {
			$condition_i_q=mysqli_query($db,'SELECT * FROM category_condition WHERE cat_id="'.$cat_id.'"');
			$initial_condition_data_rows=mysqli_num_rows($condition_i_q);
			
			foreach($post['condition_name'] as $cd_key=>$cd_value) {
				if(trim($cd_value)) {
					if($initial_condition_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_condition(cat_id, condition_name, condition_terms) values("'.$cat_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.real_escape_string($post['condition_terms'][$cd_key]).'")');
						$saved_condition_ids[] = mysqli_insert_id($db);
					} else {
						$condition_q=mysqli_query($db,'SELECT * FROM category_condition WHERE cat_id="'.$cat_id.'" AND id="'.$cd_key.'"');
						$category_condition_data=mysqli_fetch_assoc($condition_q);
						if(empty($category_condition_data)) {
							$query=mysqli_query($db,'INSERT INTO category_condition(cat_id, condition_name, condition_terms) values("'.$cat_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.real_escape_string($post['condition_terms'][$cd_key]).'")');
							$saved_condition_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_condition SET condition_name="'.real_escape_string($post['condition_name'][$cd_key]).'", condition_terms="'.real_escape_string($post['condition_terms'][$cd_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$cd_key.'"');
							$saved_condition_ids[] = $cd_key;
						}
					}
				}
			}
		}
		if(!empty($saved_condition_ids)) {
			mysqli_query($db,"DELETE FROM category_condition WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_condition_ids).")");
		} //END save/update for condition section
		
		//START save/update for network section
		$saved_network_ids = array();
		if(empty($post['network_name'])) {
			mysqli_query($db,"DELETE FROM category_networks WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['network_name'])) {
			$network_i_q=mysqli_query($db,'SELECT * FROM category_networks WHERE cat_id="'.$cat_id.'"');
			$initial_network_data_rows=mysqli_num_rows($network_i_q);
			
			foreach($post['network_name'] as $n_key=>$n_value) {
				if(trim($n_value)) {
				
					if(trim($_FILES['network_icon']['name'][$n_key])) {
						if(!file_exists('../../images/network/'))
							mkdir('../../images/network/',0777);

						$network_image_ext = pathinfo($_FILES['network_icon']['name'][$n_key],PATHINFO_EXTENSION);
						if($network_image_ext=="png" || $network_image_ext=="jpg" || $network_image_ext=="jpeg" || $network_image_ext=="gif") {
							$net_image_tmp_name=$_FILES['network_icon']['tmp_name'][$n_key];
							$network_icon=$n_key.date('YmdHis').'.'.$network_image_ext;
							move_uploaded_file($net_image_tmp_name,'../../images/network/'.$network_icon);
						} else {
							$msg="Image type must be png, jpg, jpeg, gif";
							$_SESSION['success_msg']=$msg;
							if($post['id']) {
								setRedirect(ADMIN_URL.'edit_mobile.php?id='.$cat_id);
							} else {
								setRedirect(ADMIN_URL.'edit_mobile.php');
							}
							exit();
						}
					} else {
						$network_icon=$post['old_network_icon'][$n_key];
					}

					if($initial_network_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_networks(cat_id, network_name, network_icon) values("'.$cat_id.'","'.$post['network_name'][$n_key].'","'.$network_icon.'")');
						$saved_network_ids[] = mysqli_insert_id($db);
					} else {
						$network_q=mysqli_query($db,'SELECT * FROM category_networks WHERE cat_id="'.$cat_id.'" AND id="'.$n_key.'"');
						$category_network_data=mysqli_fetch_assoc($network_q);
						if(empty($category_network_data)) {
							$query=mysqli_query($db,'INSERT INTO category_networks(cat_id, network_name, network_icon) values("'.$cat_id.'","'.$post['network_name'][$n_key].'","'.$network_icon.'")');
							$saved_network_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_networks SET network_name="'.$post['network_name'][$n_key].'", network_icon="'.$network_icon.'" WHERE cat_id="'.$cat_id.'" AND id="'.$n_key.'"');
							$saved_network_ids[] = $n_key;
						}
					}
				}
			}
		}
		if(!empty($saved_network_ids)) {
			mysqli_query($db,"DELETE FROM category_networks WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_network_ids).")");
		} //END save/update for network section

		//START save/update for connectivity section
		$saved_connectivity_ids = array();
		if(empty($post['connectivity_name'])) {
			mysqli_query($db,"DELETE FROM category_connectivity WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['connectivity_name'])) {
			$connectivity_i_q=mysqli_query($db,'SELECT * FROM category_connectivity WHERE cat_id="'.$cat_id.'"');
			$initial_connectivity_data_rows=mysqli_num_rows($connectivity_i_q);

			foreach($post['connectivity_name'] as $c_key=>$c_value) {
				if(trim($c_value)) {
					if($initial_connectivity_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_connectivity(cat_id, connectivity_name) values("'.$cat_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'")');
						$saved_connectivity_ids[] = mysqli_insert_id($db);
					} else {
						$connectivity_q=mysqli_query($db,'SELECT * FROM category_connectivity WHERE cat_id="'.$cat_id.'" AND id="'.$c_key.'"');
						$category_connectivity_data=mysqli_fetch_assoc($connectivity_q);
						if(empty($category_connectivity_data)) {
							$query=mysqli_query($db,'INSERT INTO category_connectivity(cat_id, connectivity_name) values("'.$cat_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'")');
							$saved_connectivity_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_connectivity SET connectivity_name="'.real_escape_string($post['connectivity_name'][$c_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$c_key.'"');
							$saved_connectivity_ids[] = $c_key;
						}
					}
				}
			}
		}
		if(!empty($saved_connectivity_ids)) {
			mysqli_query($db,"DELETE FROM category_connectivity WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_connectivity_ids).")");
		} //END save/update for connectivity section
		
		//START save/update for model section
		$saved_model_ids = array();
		if(empty($post['model_name'])) {
			mysqli_query($db,"DELETE FROM category_model WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['model_name'])) {
			$model_i_q=mysqli_query($db,'SELECT * FROM category_model WHERE cat_id="'.$cat_id.'"');
			$initial_model_data_rows=mysqli_num_rows($model_i_q);

			foreach($post['model_name'] as $ml_key=>$ml_value) {
				if(trim($ml_value)) {
					if($initial_model_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_model(cat_id, model_name) values("'.$cat_id.'","'.real_escape_string($post['model_name'][$ml_key]).'")');
						$saved_model_ids[] = mysqli_insert_id($db);
					} else {
						$model_q=mysqli_query($db,'SELECT * FROM category_model WHERE cat_id="'.$cat_id.'" AND id="'.$ml_key.'"');
						$category_model_data=mysqli_fetch_assoc($model_q);
						if(empty($category_model_data)) {
							$query=mysqli_query($db,'INSERT INTO category_model(cat_id, model_name) values("'.$cat_id.'","'.real_escape_string($post['model_name'][$ml_key]).'")');
							$saved_model_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_model SET model_name="'.real_escape_string($post['model_name'][$ml_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$ml_key.'"');
							$saved_model_ids[] = $ml_key;
						}
					}
				}
			}
		}
		if(!empty($saved_model_ids)) {
			mysqli_query($db,"DELETE FROM category_model WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_model_ids).")");
		} //END save/update for model section
		
		//START save/update for graphics_card section
		$saved_graphics_card_ids = array();
		if(empty($post['graphics_card_name'])) {
			mysqli_query($db,"DELETE FROM category_graphics_card WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['graphics_card_name'])) {
			$graphics_card_i_q=mysqli_query($db,'SELECT * FROM category_graphics_card WHERE cat_id="'.$cat_id.'"');
			$initial_graphics_card_data_rows=mysqli_num_rows($graphics_card_i_q);

			foreach($post['graphics_card_name'] as $gc_key=>$gc_value) {
				if(trim($gc_value)) {
					if($initial_graphics_card_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_graphics_card(cat_id, graphics_card_name) values("'.$cat_id.'","'.real_escape_string($post['graphics_card_name'][$gc_key]).'")');
						$saved_graphics_card_ids[] = mysqli_insert_id($db);
					} else {
						$graphics_card_q=mysqli_query($db,'SELECT * FROM category_graphics_card WHERE cat_id="'.$cat_id.'" AND id="'.$gc_key.'"');
						$category_graphics_card_data=mysqli_fetch_assoc($graphics_card_q);
						if(empty($category_graphics_card_data)) {
							$query=mysqli_query($db,'INSERT INTO category_graphics_card(cat_id, graphics_card_name) values("'.$cat_id.'","'.real_escape_string($post['graphics_card_name'][$gc_key]).'")');
							$saved_graphics_card_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_graphics_card SET graphics_card_name="'.real_escape_string($post['graphics_card_name'][$gc_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$gc_key.'"');
							$saved_graphics_card_ids[] = $gc_key;
						}
					}
				}
			}
		}
		if(!empty($saved_graphics_card_ids)) {
			mysqli_query($db,"DELETE FROM category_graphics_card WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_graphics_card_ids).")");
		} //END save/update for graphics_card section

		//START save/update for watchtype section
		$saved_watchtype_ids = array();
		if(empty($post['watchtype_name'])) {
			mysqli_query($db,"DELETE FROM category_watchtype WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['watchtype_name'])) {
			$watchtype_i_q=mysqli_query($db,'SELECT * FROM category_watchtype WHERE cat_id="'.$cat_id.'"');
			$initial_watchtype_data_rows=mysqli_num_rows($watchtype_i_q);
			
			foreach($post['watchtype_name'] as $gnrtn_key=>$gnrtn_value) {
				if(trim($gnrtn_value)) {
					if($initial_watchtype_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_watchtype(cat_id, watchtype_name) values("'.$cat_id.'","'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'")');
						$saved_watchtype_ids[] = mysqli_insert_id($db);
					} else {
						$watchtype_q=mysqli_query($db,'SELECT * FROM category_watchtype WHERE cat_id="'.$cat_id.'" AND id="'.$gnrtn_key.'"');
						$category_watchtype_data=mysqli_fetch_assoc($watchtype_q);
						if(empty($category_watchtype_data)) {
							$query=mysqli_query($db,'INSERT INTO category_watchtype(cat_id, watchtype_name) values("'.$cat_id.'","'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'")');
							$saved_watchtype_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_watchtype SET watchtype_name="'.real_escape_string($post['watchtype_name'][$gnrtn_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$gnrtn_key.'"');
							$saved_watchtype_ids[] = $gnrtn_key;
						}
					}
				}
			}
		}
		if(!empty($saved_watchtype_ids)) {
			mysqli_query($db,"DELETE FROM category_watchtype WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_watchtype_ids).")");
		} //END save/update for watchtype section
		
		//START save/update for case_material section
		$saved_case_material_ids = array();
		if(empty($post['case_material_name'])) {
			mysqli_query($db,"DELETE FROM category_case_material WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['case_material_name'])) {
			$case_material_i_q=mysqli_query($db,'SELECT * FROM category_case_material WHERE cat_id="'.$cat_id.'"');
			$initial_case_material_data_rows=mysqli_num_rows($case_material_i_q);
			
			foreach($post['case_material_name'] as $gnrtn_key=>$gnrtn_value) {
				if(trim($gnrtn_value)) {
					if($initial_case_material_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_case_material(cat_id, case_material_name) values("'.$cat_id.'","'.real_escape_string($post['case_material_name'][$gnrtn_key]).'")');
						$saved_case_material_ids[] = mysqli_insert_id($db);
					} else {
						$case_material_q=mysqli_query($db,'SELECT * FROM category_case_material WHERE cat_id="'.$cat_id.'" AND id="'.$gnrtn_key.'"');
						$category_case_material_data=mysqli_fetch_assoc($case_material_q);
						if(empty($category_case_material_data)) {
							$query=mysqli_query($db,'INSERT INTO category_case_material(cat_id, case_material_name) values("'.$cat_id.'","'.real_escape_string($post['case_material_name'][$gnrtn_key]).'")');
							$saved_case_material_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_case_material SET case_material_name="'.real_escape_string($post['case_material_name'][$gnrtn_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$gnrtn_key.'"');
							$saved_case_material_ids[] = $gnrtn_key;
						}
					}
				}
			}
		}
		if(!empty($saved_case_material_ids)) {
			mysqli_query($db,"DELETE FROM category_case_material WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_case_material_ids).")");
		} //END save/update for case_material section
		
		//START save/update for case_size section
		$saved_case_size_ids = array();
		if(empty($post['case_size'])) {
			mysqli_query($db,"DELETE FROM category_case_size WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['case_size'])) {
			$case_size_i_q=mysqli_query($db,'SELECT * FROM category_case_size WHERE cat_id="'.$cat_id.'"');
			$initial_case_size_data_rows=mysqli_num_rows($case_size_i_q);
			
			foreach($post['case_size'] as $case_size_key=>$case_size_value) {
				if(trim($case_size_value)) {
					if($initial_case_size_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_case_size(cat_id, case_size) values("'.$cat_id.'","'.real_escape_string($post['case_size'][$case_size_key]).'")');
						$saved_case_size_ids[] = mysqli_insert_id($db);
					} else {
						$case_size_q=mysqli_query($db,'SELECT * FROM category_case_size WHERE cat_id="'.$cat_id.'" AND id="'.$case_size_key.'"');
						$category_case_size_data=mysqli_fetch_assoc($case_size_q);
						if(empty($category_case_size_data)) {
							$query=mysqli_query($db,'INSERT INTO category_case_size(cat_id, case_size) values("'.$cat_id.'","'.real_escape_string($post['case_size'][$case_size_key]).'")');
							$saved_case_size_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_case_size SET case_size="'.real_escape_string($post['case_size'][$case_size_key]).'" WHERE cat_id="'.$cat_id.'" AND id="'.$case_size_key.'"');
							$saved_case_size_ids[] = $case_size_key;
						}
					}
				}
			}
		}
		if(!empty($saved_case_size_ids)) {
			mysqli_query($db,"DELETE FROM category_case_size WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_case_size_ids).")");
		} //END save/update for case_size section
		
		//START save/update for accessories section
		$saved_accessories_ids = array();
		if(empty($post['accessories_name'])) {
			mysqli_query($db,"DELETE FROM category_accessories WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['accessories_name'])) {
			$accessories_i_q=mysqli_query($db,'SELECT * FROM category_accessories WHERE cat_id="'.$cat_id.'"');
			$initial_accessories_data_rows=mysqli_num_rows($accessories_i_q);
			
			foreach($post['accessories_name'] as $accesr_key=>$accesr_value) {
				if(trim($accesr_value)) {
					if($initial_accessories_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_accessories(cat_id, accessories_name, accessories_price) values("'.$cat_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
						$saved_accessories_ids[] = mysqli_insert_id($db);
					} else {
						$accessories_q=mysqli_query($db,'SELECT * FROM category_accessories WHERE cat_id="'.$cat_id.'" AND id="'.$accesr_key.'"');
						$category_accessories_data=mysqli_fetch_assoc($accessories_q);
						if(empty($category_accessories_data)) {
							$query=mysqli_query($db,'INSERT INTO category_accessories(cat_id, accessories_name, accessories_price) values("'.$cat_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
							$saved_accessories_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_accessories SET accessories_name="'.real_escape_string($post['accessories_name'][$accesr_key]).'", accessories_price="'.$post['accessories_price'][$accesr_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$accesr_key.'"');
							$saved_accessories_ids[] = $accesr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_accessories_ids)) {
			mysqli_query($db,"DELETE FROM category_accessories WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_accessories_ids).")");
		} //END save/update for accessories section

		//START save/update for band_included section
		$saved_band_included_ids = array();
		if(empty($post['band_included_name'])) {
			mysqli_query($db,"DELETE FROM category_band_included WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['band_included_name'])) {
			$band_included_i_q=mysqli_query($db,'SELECT * FROM category_band_included WHERE cat_id="'.$cat_id.'"');
			$initial_band_included_data_rows=mysqli_num_rows($band_included_i_q);

			foreach($post['band_included_name'] as $bndinc_key=>$bndinc_value) {
				if(trim($bndinc_value)) {
					if($initial_band_included_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_band_included(cat_id, band_included_name, band_included_price) values("'.$cat_id.'","'.real_escape_string($post['band_included_name'][$bndinc_key]).'","'.$post['band_included_price'][$bndinc_key].'")');
						$saved_band_included_ids[] = mysqli_insert_id($db);
					} else {
						$band_included_q=mysqli_query($db,'SELECT * FROM category_band_included WHERE cat_id="'.$cat_id.'" AND id="'.$bndinc_key.'"');
						$category_band_included_data=mysqli_fetch_assoc($band_included_q);
						if(empty($category_band_included_data)) {
							$query=mysqli_query($db,'INSERT INTO category_band_included(cat_id, band_included_name, band_included_price) values("'.$cat_id.'","'.real_escape_string($post['band_included_name'][$bndinc_key]).'","'.$post['band_included_price'][$bndinc_key].'")');
							$saved_band_included_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_band_included SET band_included_name="'.real_escape_string($post['band_included_name'][$bndinc_key]).'", band_included_price="'.$post['band_included_price'][$bndinc_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$bndinc_key.'"');
							$saved_band_included_ids[] = $bndinc_key;
						}
					}
				}
			}
		}
		if(!empty($saved_band_included_ids)) {
			mysqli_query($db,"DELETE FROM category_band_included WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_band_included_ids).")");
		} //END save/update for band_included section

		//START save/update for processor section
		$saved_processor_ids = array();
		if(empty($post['processor_name'])) {
			mysqli_query($db,"DELETE FROM category_processor WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['processor_name'])) {
			$processor_i_q=mysqli_query($db,'SELECT * FROM category_processor WHERE cat_id="'.$cat_id.'"');
			$initial_processor_data_rows=mysqli_num_rows($processor_i_q);
			
			foreach($post['processor_name'] as $prcr_key=>$prcr_value) {
				if(trim($prcr_value)) {
					if($initial_processor_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_processor(cat_id, processor_name, processor_price) values("'.$cat_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
						$saved_processor_ids[] = mysqli_insert_id($db);
					} else {
						$processor_q=mysqli_query($db,'SELECT * FROM category_processor WHERE cat_id="'.$cat_id.'" AND id="'.$prcr_key.'"');
						$category_processor_data=mysqli_fetch_assoc($processor_q);
						if(empty($category_processor_data)) {
							$query=mysqli_query($db,'INSERT INTO category_processor(cat_id, processor_name, processor_price) values("'.$cat_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
							$saved_processor_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_processor SET processor_name="'.real_escape_string($post['processor_name'][$prcr_key]).'", processor_price="'.$post['processor_price'][$prcr_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$prcr_key.'"');
							$saved_processor_ids[] = $prcr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_processor_ids)) {
			mysqli_query($db,"DELETE FROM category_processor WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_processor_ids).")");
		} //END save/update for processor section
		
		//START save/update for ram section
		$saved_ram_ids = array();
		if(empty($post['ram_size'])) {
			mysqli_query($db,"DELETE FROM category_ram WHERE cat_id='".$cat_id."'");
		} elseif(!empty($post['ram_size'])) {
			$ram_i_q=mysqli_query($db,'SELECT * FROM category_ram WHERE cat_id="'.$cat_id.'"');
			$initial_ram_data_rows=mysqli_num_rows($ram_i_q);
			
			foreach($post['ram_size'] as $ram_key=>$ram_value) {
				if(trim($ram_value)) {
					if($initial_ram_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO category_ram(cat_id, ram_size, ram_size_postfix, ram_price) values("'.$cat_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
						$saved_ram_ids[] = mysqli_insert_id($db);
					} else {
						$ram_q=mysqli_query($db,'SELECT * FROM category_ram WHERE cat_id="'.$cat_id.'" AND id="'.$ram_key.'"');
						$category_ram_data=mysqli_fetch_assoc($ram_q);
						if(empty($category_ram_data)) {
							$query=mysqli_query($db,'INSERT INTO category_ram(cat_id, ram_size, ram_size_postfix, ram_price) values("'.$cat_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
							$saved_ram_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE category_ram SET ram_size="'.real_escape_string($post['ram_size'][$ram_key]).'", ram_size_postfix="'.real_escape_string($post['ram_size_postfix'][$ram_key]).'", ram_price="'.$post['ram_price'][$ram_key].'" WHERE cat_id="'.$cat_id.'" AND id="'.$ram_key.'"');
							$saved_ram_ids[] = $ram_key;
						}
					}
				}
			}
		}
		if(!empty($saved_ram_ids)) {
			mysqli_query($db,"DELETE FROM category_ram WHERE cat_id='".$cat_id."' AND id NOT IN(".implode(",",$saved_ram_ids).")");
		} //END save/update for ram section
		
	}

	$tooltip_device=real_escape_string($post['tooltip_device']);
	$tooltip_storage=real_escape_string($post['tooltip_storage']);
	$tooltip_condition=real_escape_string($post['tooltip_condition']);
	$tooltip_network=real_escape_string($post['tooltip_network']);
	$tooltip_connectivity=real_escape_string($post['tooltip_connectivity']);
	$tooltip_watchtype=real_escape_string($post['tooltip_watchtype']);
	$tooltip_case_material=real_escape_string($post['tooltip_case_material']);
	$tooltip_case_size=real_escape_string($post['tooltip_case_size']);
	$tooltip_accessories=real_escape_string($post['tooltip_accessories']);
	$tooltip_band_included=real_escape_string($post['tooltip_band_included']);
	$tooltip_processor=real_escape_string($post['tooltip_processor']);
	$tooltip_ram=real_escape_string($post['tooltip_ram']);
	$tooltip_model=real_escape_string($post['tooltip_model']);
	$tooltip_graphics_card=real_escape_string($post['tooltip_graphics_card']);
	
	$required_storage=real_escape_string($post['required_storage']);
	$required_condition=real_escape_string($post['required_condition']);
	$required_network=real_escape_string($post['required_network']);
	$required_connectivity=real_escape_string($post['required_connectivity']);
	$required_watchtype=real_escape_string($post['required_watchtype']);
	$required_case_material=real_escape_string($post['required_case_material']);
	$required_case_size=real_escape_string($post['required_case_size']);
	$required_accessories=real_escape_string($post['required_accessories']);
	$required_band_included=real_escape_string($post['required_band_included']);
	$required_processor=real_escape_string($post['required_processor']);
	$required_ram=real_escape_string($post['required_ram']);
	$required_model=real_escape_string($post['required_model']);
	$required_graphics_card=real_escape_string($post['required_graphics_card']);

	$storage_title=real_escape_string($post['storage_title']);
	$condition_title=real_escape_string($post['condition_title']);
	$network_title=real_escape_string($post['network_title']);
	$connectivity_title=real_escape_string($post['connectivity_title']);
	$case_size_title=real_escape_string($post['case_size_title']);
	$type_title=real_escape_string($post['type_title']);
	$case_material_title=real_escape_string($post['case_material_title']);
	$color_title=real_escape_string($post['color_title']);
	$accessories_title=real_escape_string($post['accessories_title']);
	$screen_size_title=real_escape_string($post['screen_size_title']);
	$screen_resolution_title=real_escape_string($post['screen_resolution_title']);
	$lyear_title=real_escape_string($post['lyear_title']);
	$processor_title=real_escape_string($post['processor_title']);
	$ram_title=real_escape_string($post['ram_title']);
	$graphics_card_title=real_escape_string($post['graphics_card_title']);
	$band_included_title=real_escape_string($post['band_included_title']);
	$model_title=real_escape_string($post['model_title']);

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE categories SET title="'.$title.'", fields_type="'.$fields_type.'", fa_icon="'.$fa_icon.'" '.$imageupdate.' '.$hover_imageupdate.' '.$cart_imageupdate.', sub_title="'.$sub_title.'", short_description="'.$short_description.'", description="'.$description.'", published="'.$published.'", icon_type="'.$icon_type.'", tooltip_device="'.$tooltip_device.'", tooltip_storage="'.$tooltip_storage.'", tooltip_condition="'.$tooltip_condition.'", tooltip_network="'.$tooltip_network.'", tooltip_connectivity="'.$tooltip_connectivity.'", tooltip_watchtype="'.$tooltip_watchtype.'", tooltip_case_material="'.$tooltip_case_material.'", tooltip_case_size="'.$tooltip_case_size.'", tooltip_accessories="'.$tooltip_accessories.'", tooltip_processor="'.$tooltip_processor.'", tooltip_ram="'.$tooltip_ram.'", tooltip_band_included="'.$tooltip_band_included.'", tooltip_model="'.$tooltip_model.'", tooltip_graphics_card="'.$tooltip_graphics_card.'", storage_title="'.$storage_title.'", condition_title="'.$condition_title.'", network_title="'.$network_title.'", connectivity_title="'.$connectivity_title.'", case_size_title="'.$case_size_title.'", type_title="'.$type_title.'", case_material_title="'.$case_material_title.'", color_title="'.$color_title.'", accessories_title="'.$accessories_title.'", screen_size_title="'.$screen_size_title.'", screen_resolution_title="'.$screen_resolution_title.'", lyear_title="'.$lyear_title.'", processor_title="'.$processor_title.'", ram_title="'.$ram_title.'", graphics_card_title="'.$graphics_card_title.'", band_included_title="'.$band_included_title.'", model_title="'.$model_title.'", sef_url="'.$sef_url.'", required_storage="'.$required_storage.'", required_condition="'.$required_condition.'", required_network="'.$required_network.'", required_connectivity="'.$required_connectivity.'", required_watchtype="'.$required_watchtype.'", required_case_material="'.$required_case_material.'", required_case_size="'.$required_case_size.'", required_accessories="'.$required_accessories.'", required_processor="'.$required_processor.'", required_ram="'.$required_ram.'", required_band_included="'.$required_band_included.'", required_model="'.$required_model.'", required_graphics_card="'.$required_graphics_card.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$cat_id = $post['id'];
			save_category_fields($cat_id,$post);
			
			$msg="Category has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO categories(title, fields_type, fa_icon, image, hover_image, cart_image, sub_title, short_description, description, published, icon_type, tooltip_device, tooltip_storage, tooltip_condition, tooltip_network, tooltip_connectivity, tooltip_watchtype, tooltip_case_material, tooltip_case_size, tooltip_accessories, tooltip_processor, tooltip_ram, tooltip_band_included, tooltip_model, tooltip_graphics_card, storage_title, condition_title, network_title, connectivity_title, case_size_title, type_title, case_material_title, color_title, accessories_title, screen_size_title, screen_resolution_title, lyear_title, processor_title, ram_title, graphics_card_title, band_included_title, model_title, sef_url, required_storage, required_condition, required_network, required_connectivity, required_watchtype, required_case_material, required_case_size, required_accessories, required_processor, required_ram, required_band_included, required_model, required_graphics_card) values("'.$title.'","'.$fields_type.'","'.$fa_icon.'","'.$image_name.'","'.$image_name.'","'.$hover_image_name.'", "'.$sub_title.'", "'.$short_description.'", "'.$description.'", "'.$published.'","'.$icon_type.'", "'.$tooltip_device.'", "'.$tooltip_storage.'", "'.$tooltip_condition.'", "'.$tooltip_network.'", "'.$tooltip_connectivity.'", "'.$tooltip_watchtype.'", "'.$tooltip_case_material.'", "'.$tooltip_case_size.'", "'.$tooltip_accessories.'", "'.$tooltip_processor.'", "'.$tooltip_ram.'", "'.$tooltip_band_included.'", "'.$tooltip_model.'", "'.$tooltip_graphics_card.'", "'.$storage_title.'", "'.$condition_title.'", "'.$network_title.'", "'.$connectivity_title.'", "'.$case_size_title.'", "'.$type_title.'", "'.$case_material_title.'", "'.$color_title.'", "'.$accessories_title.'", "'.$screen_size_title.'", "'.$screen_resolution_title.'", "'.$lyear_title.'", "'.$processor_title.'", "'.$ram_title.'", "'.$graphics_card_title.'", "'.$band_included_title.'", "'.$model_title.'", "'.$sef_url.'", "'.$required_storage.'", "'.$required_condition.'", "'.$required_network.'", "'.$required_connectivity.'", "'.$required_watchtype.'", "'.$required_case_material.'", "'.$required_case_size.'", "'.$required_accessories.'", "'.$required_processor.'", "'.$required_ram.'", "'.$required_band_included.'", "'.$required_model.'", "'.$required_graphics_card.'")');
		if($query=="1") {
			$cat_id = mysqli_insert_id($db);
			save_category_fields($cat_id,$post);
			
			$msg="Category has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'device_categories.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_category.php');
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE categories SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['r_img_id'])) {
	$get_behand_data=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$post['r_img_id'].'"');
	$brand_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE categories SET image="" WHERE id='.$post['r_img_id']);
	if($brand_data['image']!="")
		unlink('../../images/categories/'.$brand_data['image']);

	setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
} elseif(isset($post['r_h_img_id'])) {
	$q=mysqli_query($db,'SELECT hover_image FROM categories WHERE id="'.$post['r_h_img_id'].'"');
	$device_data=mysqli_fetch_assoc($q);

	$del_logo=mysqli_query($db,'UPDATE categories SET hover_image="" WHERE id='.$post['r_h_img_id']);
	if($device_data['hover_image']!="")
		unlink('../../images/categories/'.$device_data['hover_image']);
		
	setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
} elseif(isset($post['r_c_img_id'])) {
	$q=mysqli_query($db,'SELECT cart_image FROM categories WHERE id="'.$post['r_c_img_id'].'"');
	$device_data=mysqli_fetch_assoc($q);

	$del_logo=mysqli_query($db,'UPDATE categories SET cart_image="" WHERE id='.$post['r_c_img_id']);
	if($device_data['cart_image']!="")
		unlink('../../images/categories/'.$device_data['cart_image']);

	setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'device_categories.php');
}
exit();
?>