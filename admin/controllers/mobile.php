<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['c_id'])) {
	$qry=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$post['c_id']."'");
	$model_data=mysqli_fetch_assoc($qry);
	$model_data['title'] = $model_data['title'].' - Copy';
	$model_data['published'] = 0;
	$model_data['model_img'] = '';
	
	$svd_query = mysqli_query($db,"INSERT INTO mobile(brand_id,title,meta_title,meta_desc,meta_keywords,device_id,price,model_img,tooltip_device,top_seller,published,cat_id,ordering) values ('".$model_data['brand_id']."','".$model_data['title']."','".$model_data['meta_title']."','".$model_data['meta_desc']."','".$model_data['meta_keywords']."','".$model_data['device_id']."','".$model_data['price']."','".$model_data['model_img']."','".$model_data['tooltip_device']."','".$model_data['top_seller']."','".$model_data['published']."','".$model_data['cat_id']."','".$model_data['ordering']."')");
	if($svd_query == '1') {
		$last_insert_id = mysqli_insert_id($db);
		$pf_qry=mysqli_query($db,"SELECT * FROM product_fields WHERE product_id='".$model_data['id']."'");
		while($product_fields_data=mysqli_fetch_assoc($pf_qry)) {
			$pf_svd_query=mysqli_query($db,"INSERT INTO `product_fields`(`title`, `input_type`, `is_required`, `sort_order`, `tooltip`, `icon`, `product_id`) VALUES ('".$product_fields_data['title']."','".$product_fields_data['input_type']."','".$product_fields_data['is_required']."','".$product_fields_data['sort_order']."','".$product_fields_data['tooltip']."','".$product_fields_data['icon']."','".$last_insert_id."')");
			if($pf_svd_query == '1') {
				$last_pf_insert_id = mysqli_insert_id($db);
				$po_qry=mysqli_query($db,"SELECT * FROM product_options WHERE product_field_id='".$product_fields_data['id']."'");
				while($product_options_data=mysqli_fetch_assoc($po_qry)) {
					mysqli_query($db,"INSERT INTO `product_options`(`label`, `add_sub`, `price_type`, `price`, `sort_order`, `is_default`, `tooltip`, `icon`, `product_field_id`) VALUES ('".$product_options_data['label']."','".$product_options_data['add_sub']."','".$product_options_data['price_type']."','".$product_options_data['price']."','".$product_options_data['sort_order']."','".$product_options_data['is_default']."','".$product_options_data['tooltip']."','".$product_options_data['icon']."','".$last_pf_insert_id."')");
				}
			}
		}

		$msg="Model has been successfully cloned.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}

	setRedirect(ADMIN_URL.'edit_mobile.php?id='.$last_insert_id);
	exit();
} elseif(isset($post['d_id'])) {
	$behand_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['d_id'].'"');
	$behand_data=mysqli_fetch_assoc($behand_q);

	$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($behand_data['model_img']!="")
			unlink('../../images/mobile/'.$behand_data['model_img']);

		$msg="Delete Successfully.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$mobile_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$id_v.'"');
			$mobile_data=mysqli_fetch_assoc($mobile_q);
			if($mobile_data['model_img']!="")
				unlink('../../images/mobile/'.$mobile_data['model_img']);

			$query=mysqli_query($db,'DELETE FROM mobile WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE mobile SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['update'])) {
	$device_id = $post['device_id'];
	$cat_id = $post['cat_id'];
	$brand_id = $post['brand_id'];
	$title=real_escape_string($post['title']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$price=real_escape_string($post['price']);
	$top_seller=real_escape_string($post['top_seller']);
	$unlock_price=real_escape_string($post['unlock_price']);
	$tooltip_device=real_escape_string($post['tooltip_device']);
	$tooltip_condition=real_escape_string($post['tooltip_condition']);
	$tooltip_network=real_escape_string($post['tooltip_network']);
	$tooltip_colors=real_escape_string($post['tooltip_colors']);
	$tooltip_miscellaneous=real_escape_string($post['tooltip_miscellaneous']);
	$tooltip_accessories=real_escape_string($post['tooltip_accessories']);
	$published = $post['published'];
	$sef_url = createSlug($post['title']);
	$meta_canonical_url=real_escape_string($post['meta_canonical_url']);
	
	$category_data = get_category_data($cat_id);
	$fields_type = $category_data['fields_type'];

	if($_FILES['model_img']['name']) {
		if(!file_exists('../../images/mobile/'))
			mkdir('../../images/mobile/',0777);
			
		$image_ext = pathinfo($_FILES['model_img']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/mobile/'.$post['old_image']);

			$image_tmp_name=$_FILES['model_img']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', model_img="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/mobile/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_mobile.php');
			}
			exit();
		}
	}
	
	function save_model_fields($model_id,$post) {
		global $db;
		
		//START save/update for storage section
		$saved_storage_ids = array();
		if(empty($post['storage_size'])) {
			mysqli_query($db,"DELETE FROM models_storage WHERE model_id='".$model_id."'");
		} elseif(!empty($post['storage_size'])) {
			foreach($post['storage_size'] as $key=>$value) {
				if(trim($value)) {
					$storage_q=mysqli_query($db,'SELECT * FROM models_storage WHERE model_id="'.$model_id.'" AND id="'.$key.'"');
					$models_storage_data=mysqli_fetch_assoc($storage_q);
					if(empty($models_storage_data)) {
						$query=mysqli_query($db,'INSERT INTO models_storage(model_id, storage_size, storage_size_postfix, plus_minus, fixed_percentage, storage_price, top_seller) values("'.$model_id.'","'.$post['storage_size'][$key].'","'.$post['storage_size_postfix'][$key].'","'.$post['storage_plus_minus'][$key].'","'.$post['storage_fixed_percentage'][$key].'","'.$post['storage_price'][$key].'","'.$post['top_seller'][$key].'")');
						$saved_storage_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_storage SET storage_size="'.$post['storage_size'][$key].'",storage_size_postfix="'.$post['storage_size_postfix'][$key].'",plus_minus="'.$post['storage_plus_minus'][$key].'",fixed_percentage="'.$post['storage_fixed_percentage'][$key].'",storage_price="'.$post['storage_price'][$key].'",top_seller="'.$post['top_seller'][$key].'" WHERE model_id="'.$model_id.'" AND id="'.$key.'"');
						$saved_storage_ids[] = $key;
					}
				}
			}
		}
		if(!empty($saved_storage_ids)) {
			mysqli_query($db,"DELETE FROM models_storage WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_storage_ids).")");
		} //END save/update for storage section

		//START save/update for condition section
		$saved_condition_ids = array();
		if(empty($post['condition_name'])) {
			mysqli_query($db,"DELETE FROM models_condition WHERE model_id='".$model_id."'");
		} elseif(!empty($post['condition_name'])) {
			foreach($post['condition_name'] as $cd_key=>$cd_value) {
				if(trim($cd_value)) {
					$condition_q=mysqli_query($db,'SELECT * FROM models_condition WHERE model_id="'.$model_id.'" AND id="'.$cd_key.'"');
					$models_condition_data=mysqli_fetch_assoc($condition_q);
					if(empty($models_condition_data)) {
						$query=mysqli_query($db,'INSERT INTO models_condition(model_id, condition_name, plus_minus, fixed_percentage, condition_price, condition_terms, disabled_network) values("'.$model_id.'","'.real_escape_string($post['condition_name'][$cd_key]).'","'.$post['condition_plus_minus'][$cd_key].'","'.$post['condition_fixed_percentage'][$cd_key].'","'.$post['condition_price'][$cd_key].'","'.real_escape_string($post['condition_terms'][$cd_key]).'","'.$post['disabled_network'][$cd_key].'")');
						$saved_condition_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_condition SET condition_name="'.real_escape_string($post['condition_name'][$cd_key]).'",plus_minus="'.$post['condition_plus_minus'][$cd_key].'",fixed_percentage="'.$post['condition_fixed_percentage'][$cd_key].'",condition_price="'.$post['condition_price'][$cd_key].'",condition_terms="'.real_escape_string($post['condition_terms'][$cd_key]).'",disabled_network="'.$post['disabled_network'][$cd_key].'" WHERE model_id="'.$model_id.'" AND id="'.$cd_key.'"');
						$saved_condition_ids[] = $cd_key;
					}
				}
			}
		}
		if(!empty($saved_condition_ids)) {
			mysqli_query($db,"DELETE FROM models_condition WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_condition_ids).")");
		} //END save/update for condition section
		
		//START save/update for network section
		$saved_network_ids = array();
		if(empty($post['network_name'])) {
			mysqli_query($db,"DELETE FROM models_networks WHERE model_id='".$model_id."'");
		} elseif(!empty($post['network_name'])) {
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
								setRedirect(ADMIN_URL.'edit_mobile.php?id='.$model_id);
							} else {
								setRedirect(ADMIN_URL.'edit_mobile.php');
							}
							exit();
						}
					} else {
						$network_icon=$post['old_network_icon'][$n_key];
					}

					$network_price = 0;
					$network_price = ($post['network_price'][$n_key]>0?$post['network_price'][$n_key]:0);
			
					$network_q=mysqli_query($db,'SELECT * FROM models_networks WHERE model_id="'.$model_id.'" AND id="'.$n_key.'"');
					$models_network_data=mysqli_fetch_assoc($network_q);
					if(empty($models_network_data)) {
						$query=mysqli_query($db,'INSERT INTO models_networks(model_id, network_name, plus_minus, fixed_percentage, network_price, most_popular, change_unlock, network_icon) values("'.$model_id.'","'.$post['network_name'][$n_key].'","'.$post['network_plus_minus'][$n_key].'","'.$post['network_fixed_percentage'][$n_key].'","'.$network_price.'","'.$post['most_popular'][$n_key].'","'.$post['change_unlock'][$n_key].'","'.$network_icon.'")');
						$saved_network_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_networks SET network_name="'.$post['network_name'][$n_key].'",plus_minus="'.$post['network_plus_minus'][$n_key].'",fixed_percentage="'.$post['network_fixed_percentage'][$n_key].'",network_price="'.$network_price.'",most_popular="'.$post['most_popular'][$n_key].'",change_unlock="'.$post['change_unlock'][$n_key].'",network_icon="'.$network_icon.'" WHERE model_id="'.$model_id.'" AND id="'.$n_key.'"');
						$saved_network_ids[] = $n_key;
					}
				}
			}
		}
		if(!empty($saved_network_ids)) {
			mysqli_query($db,"DELETE FROM models_networks WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_network_ids).")");
		} //END save/update for network section
		
		//START save/update for connectivity section
		$saved_connectivity_ids = array();
		if(empty($post['connectivity_name'])) {
			mysqli_query($db,"DELETE FROM models_connectivity WHERE model_id='".$model_id."'");
		} elseif(!empty($post['connectivity_name'])) {
			foreach($post['connectivity_name'] as $c_key=>$c_value) {
				if(trim($c_value)) {
					$connectivity_q=mysqli_query($db,'SELECT * FROM models_connectivity WHERE model_id="'.$model_id.'" AND id="'.$c_key.'"');
					$models_connectivity_data=mysqli_fetch_assoc($connectivity_q);
					if(empty($models_connectivity_data)) {
						$query=mysqli_query($db,'INSERT INTO models_connectivity(model_id, connectivity_name) values("'.$model_id.'","'.real_escape_string($post['connectivity_name'][$c_key]).'")');
						$saved_connectivity_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_connectivity SET connectivity_name="'.real_escape_string($post['connectivity_name'][$c_key]).'" WHERE model_id="'.$model_id.'" AND id="'.$c_key.'"');
						$saved_connectivity_ids[] = $c_key;
					}
				}
			}
		}
		if(!empty($saved_connectivity_ids)) {
			mysqli_query($db,"DELETE FROM models_connectivity WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_connectivity_ids).")");
		} //END save/update for connectivity section
		
		//START save/update for model section
		$saved_model_ids = array();
		if(empty($post['model_name'])) {
			mysqli_query($db,"DELETE FROM models_model WHERE model_id='".$model_id."'");
		} elseif(!empty($post['model_name'])) {
			foreach($post['model_name'] as $ml_key=>$ml_value) {
				if(trim($ml_value)) {
					$model_q=mysqli_query($db,'SELECT * FROM models_model WHERE model_id="'.$model_id.'" AND id="'.$ml_key.'"');
					$models_model_data=mysqli_fetch_assoc($model_q);
					if(empty($models_model_data)) {
						$query=mysqli_query($db,'INSERT INTO models_model(model_id, model_name) values("'.$model_id.'","'.real_escape_string($post['model_name'][$ml_key]).'")');
						$saved_model_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_model SET model_name="'.real_escape_string($post['model_name'][$ml_key]).'" WHERE model_id="'.$model_id.'" AND id="'.$ml_key.'"');
						$saved_model_ids[] = $ml_key;
					}
				}
			}
		}
		if(!empty($saved_model_ids)) {
			mysqli_query($db,"DELETE FROM models_model WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_model_ids).")");
		} //END save/update for model section
		
		//START save/update for graphics_card section
		$saved_graphics_card_ids = array();
		if(empty($post['graphics_card_name'])) {
			mysqli_query($db,"DELETE FROM models_graphics_card WHERE model_id='".$model_id."'");
		} elseif(!empty($post['graphics_card_name'])) {
			foreach($post['graphics_card_name'] as $gc_key=>$gc_value) {
				if(trim($gc_value)) {
					$graphics_card_q=mysqli_query($db,'SELECT * FROM models_graphics_card WHERE model_id="'.$model_id.'" AND id="'.$gc_key.'"');
					$models_graphics_card_data=mysqli_fetch_assoc($graphics_card_q);
					if(empty($models_graphics_card_data)) {
						$query=mysqli_query($db,'INSERT INTO models_graphics_card(model_id, graphics_card_name) values("'.$model_id.'","'.real_escape_string($post['graphics_card_name'][$gc_key]).'")');
						$saved_graphics_card_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_graphics_card SET graphics_card_name="'.real_escape_string($post['graphics_card_name'][$gc_key]).'" WHERE model_id="'.$model_id.'" AND id="'.$gc_key.'"');
						$saved_graphics_card_ids[] = $gc_key;
					}
				}
			}
		}
		if(!empty($saved_graphics_card_ids)) {
			mysqli_query($db,"DELETE FROM models_graphics_card WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_graphics_card_ids).")");
		} //END save/update for graphics_card section

		//START save/update for watchtype section
		$saved_watchtype_ids = array();
		if(empty($post['watchtype_name'])) {
			mysqli_query($db,"DELETE FROM models_watchtype WHERE model_id='".$model_id."'");
		} elseif(!empty($post['watchtype_name'])) {
			foreach($post['watchtype_name'] as $acce_key=>$acce_value) {
				if(trim($acce_value)) {
					$watchtype_q=mysqli_query($db,'SELECT * FROM models_watchtype WHERE model_id="'.$model_id.'" AND id="'.$acce_key.'"');
					$models_watchtype_data=mysqli_fetch_assoc($watchtype_q);
					if(empty($models_watchtype_data)) {
						$query=mysqli_query($db,'INSERT INTO models_watchtype(model_id, watchtype_name) values("'.$model_id.'","'.real_escape_string($post['watchtype_name'][$acce_key]).'")');
						$saved_watchtype_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_watchtype SET watchtype_name="'.real_escape_string($post['watchtype_name'][$acce_key]).'" WHERE model_id="'.$model_id.'" AND id="'.$acce_key.'"');
						$saved_watchtype_ids[] = $acce_key;
					}
				}
			}
		}
		if(!empty($saved_watchtype_ids)) {
			mysqli_query($db,"DELETE FROM models_watchtype WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_watchtype_ids).")");
		} //END save/update for watchtype section
		
		//START save/update for case_material section
		$saved_case_material_ids = array();
		if(empty($post['case_material_name'])) {
			mysqli_query($db,"DELETE FROM models_case_material WHERE model_id='".$model_id."'");
		} elseif(!empty($post['case_material_name'])) {
			foreach($post['case_material_name'] as $acce_key=>$acce_value) {
				if(trim($acce_value)) {
					$case_material_q=mysqli_query($db,'SELECT * FROM models_case_material WHERE model_id="'.$model_id.'" AND id="'.$acce_key.'"');
					$models_case_material_data=mysqli_fetch_assoc($case_material_q);
					if(empty($models_case_material_data)) {
						$query=mysqli_query($db,'INSERT INTO models_case_material(model_id, case_material_name) values("'.$model_id.'","'.real_escape_string($post['case_material_name'][$acce_key]).'")');
						$saved_case_material_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_case_material SET case_material_name="'.real_escape_string($post['case_material_name'][$acce_key]).'" WHERE model_id="'.$model_id.'" AND id="'.$acce_key.'"');
						$saved_case_material_ids[] = $acce_key;
					}
				}
			}
		}
		if(!empty($saved_case_material_ids)) {
			mysqli_query($db,"DELETE FROM models_case_material WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_case_material_ids).")");
		} //END save/update for case_material section

		//START save/update for case_size section
		$saved_case_size_ids = array();
		if(empty($post['case_size'])) {
			mysqli_query($db,"DELETE FROM models_case_size WHERE model_id='".$model_id."'");
		} elseif(!empty($post['case_size'])) {
			foreach($post['case_size'] as $misc_key=>$misc_value) {
				if(trim($misc_value)) {
					$case_size_q=mysqli_query($db,'SELECT * FROM models_case_size WHERE model_id="'.$model_id.'" AND id="'.$misc_key.'"');
					$models_case_size_data=mysqli_fetch_assoc($case_size_q);
					if(empty($models_case_size_data)) {
						$query=mysqli_query($db,'INSERT INTO models_case_size(model_id, case_size) values("'.$model_id.'","'.real_escape_string($post['case_size'][$misc_key]).'")');
						$saved_case_size_ids[] = mysqli_insert_id($db);
					} else {
						$query=mysqli_query($db,'UPDATE models_case_size SET case_size="'.real_escape_string($post['case_size'][$misc_key]).'" WHERE model_id="'.$model_id.'" AND id="'.$misc_key.'"');
						$saved_case_size_ids[] = $misc_key;
					}
				}
			}
		}
		if(!empty($saved_case_size_ids)) {
			mysqli_query($db,"DELETE FROM models_case_size WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_case_size_ids).")");
		} //END save/update for case_size section
		
		//START save/update for accessories section
		$saved_accessories_ids = array();
		if(empty($post['accessories_name'])) {
			mysqli_query($db,"DELETE FROM models_accessories WHERE model_id='".$model_id."'");
		} elseif(!empty($post['accessories_name'])) {
			$accessories_i_q=mysqli_query($db,'SELECT * FROM models_accessories WHERE model_id="'.$model_id.'"');
			$initial_accessories_data_rows=mysqli_num_rows($accessories_i_q);
			
			foreach($post['accessories_name'] as $accesr_key=>$accesr_value) {
				if(trim($accesr_value)) {
					if($initial_accessories_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_accessories(model_id, accessories_name, accessories_price) values("'.$model_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
						$saved_accessories_ids[] = mysqli_insert_id($db);
					} else {
						$accessories_q=mysqli_query($db,'SELECT * FROM models_accessories WHERE model_id="'.$model_id.'" AND id="'.$accesr_key.'"');
						$models_accessories_data=mysqli_fetch_assoc($accessories_q);
						if(empty($models_accessories_data)) {
							$query=mysqli_query($db,'INSERT INTO models_accessories(model_id, accessories_name, accessories_price) values("'.$model_id.'","'.real_escape_string($post['accessories_name'][$accesr_key]).'","'.$post['accessories_price'][$accesr_key].'")');
							$saved_accessories_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_accessories SET accessories_name="'.real_escape_string($post['accessories_name'][$accesr_key]).'", accessories_price="'.$post['accessories_price'][$accesr_key].'" WHERE model_id="'.$model_id.'" AND id="'.$accesr_key.'"');
							$saved_accessories_ids[] = $accesr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_accessories_ids)) {
			mysqli_query($db,"DELETE FROM models_accessories WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_accessories_ids).")");
		} //END save/update for accessories section
		
		//START save/update for band_included section
		$saved_band_included_ids = array();
		if(empty($post['band_included_name'])) {
			mysqli_query($db,"DELETE FROM models_band_included WHERE model_id='".$model_id."'");
		} elseif(!empty($post['band_included_name'])) {
			$band_included_i_q=mysqli_query($db,'SELECT * FROM models_band_included WHERE model_id="'.$model_id.'"');
			$initial_band_included_data_rows=mysqli_num_rows($band_included_i_q);

			foreach($post['band_included_name'] as $bndinc_key=>$bndinc_value) {
				if(trim($bndinc_value)) {
					if($initial_band_included_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_band_included(model_id, band_included_name, band_included_price) values("'.$model_id.'","'.real_escape_string($post['band_included_name'][$bndinc_key]).'","'.$post['band_included_price'][$bndinc_key].'")');
						$saved_band_included_ids[] = mysqli_insert_id($db);
					} else {
						$band_included_q=mysqli_query($db,'SELECT * FROM models_band_included WHERE model_id="'.$model_id.'" AND id="'.$bndinc_key.'"');
						$models_band_included_data=mysqli_fetch_assoc($band_included_q);
						if(empty($models_band_included_data)) {
							$query=mysqli_query($db,'INSERT INTO models_band_included(model_id, band_included_name, band_included_price) values("'.$model_id.'","'.real_escape_string($post['band_included_name'][$bndinc_key]).'","'.$post['band_included_price'][$bndinc_key].'")');
							$saved_band_included_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_band_included SET band_included_name="'.real_escape_string($post['band_included_name'][$bndinc_key]).'", band_included_price="'.$post['band_included_price'][$bndinc_key].'" WHERE model_id="'.$model_id.'" AND id="'.$bndinc_key.'"');
							$saved_band_included_ids[] = $bndinc_key;
						}
					}
				}
			}
		}
		if(!empty($saved_band_included_ids)) {
			mysqli_query($db,"DELETE FROM models_band_included WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_band_included_ids).")");
		} //END save/update for band_included section

		//START save/update for processor section
		$saved_processor_ids = array();
		if(empty($post['processor_name'])) {
			mysqli_query($db,"DELETE FROM models_processor WHERE model_id='".$model_id."'");
		} elseif(!empty($post['processor_name'])) {
			$processor_i_q=mysqli_query($db,'SELECT * FROM models_processor WHERE model_id="'.$model_id.'"');
			$initial_processor_data_rows=mysqli_num_rows($processor_i_q);
			
			foreach($post['processor_name'] as $prcr_key=>$prcr_value) {
				if(trim($prcr_value)) {
					if($initial_processor_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_processor(model_id, processor_name, processor_price) values("'.$model_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
						$saved_processor_ids[] = mysqli_insert_id($db);
					} else {
						$processor_q=mysqli_query($db,'SELECT * FROM models_processor WHERE model_id="'.$model_id.'" AND id="'.$prcr_key.'"');
						$models_processor_data=mysqli_fetch_assoc($processor_q);
						if(empty($models_processor_data)) {
							$query=mysqli_query($db,'INSERT INTO models_processor(model_id, processor_name, processor_price) values("'.$model_id.'","'.real_escape_string($post['processor_name'][$prcr_key]).'","'.$post['processor_price'][$prcr_key].'")');
							$saved_processor_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_processor SET processor_name="'.real_escape_string($post['processor_name'][$prcr_key]).'", processor_price="'.$post['processor_price'][$prcr_key].'" WHERE model_id="'.$model_id.'" AND id="'.$prcr_key.'"');
							$saved_processor_ids[] = $prcr_key;
						}
					}
				}
			}
		}
		if(!empty($saved_processor_ids)) {
			mysqli_query($db,"DELETE FROM models_processor WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_processor_ids).")");
		} //END save/update for processor section
		
		//START save/update for ram section
		$saved_ram_ids = array();
		if(empty($post['ram_size'])) {
			mysqli_query($db,"DELETE FROM models_ram WHERE model_id='".$model_id."'");
		} elseif(!empty($post['ram_size'])) {
			$ram_i_q=mysqli_query($db,'SELECT * FROM models_ram WHERE model_id="'.$model_id.'"');
			$initial_ram_data_rows=mysqli_num_rows($ram_i_q);
			
			foreach($post['ram_size'] as $ram_key=>$ram_value) {
				if(trim($ram_value)) {
					if($initial_ram_data_rows<=0) {
						$query=mysqli_query($db,'INSERT INTO models_ram(model_id, ram_size, ram_size_postfix, ram_price) values("'.$model_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
						$saved_ram_ids[] = mysqli_insert_id($db);
					} else {
						$ram_q=mysqli_query($db,'SELECT * FROM models_ram WHERE model_id="'.$model_id.'" AND id="'.$ram_key.'"');
						$models_ram_data=mysqli_fetch_assoc($ram_q);
						if(empty($models_ram_data)) {
							$query=mysqli_query($db,'INSERT INTO models_ram(model_id, ram_size, ram_size_postfix, ram_price) values("'.$model_id.'","'.real_escape_string($post['ram_size'][$ram_key]).'","'.real_escape_string($post['ram_size_postfix'][$ram_key]).'","'.$post['ram_price'][$ram_key].'")');
							$saved_ram_ids[] = mysqli_insert_id($db);
						} else {
							$query=mysqli_query($db,'UPDATE models_ram SET ram_size="'.real_escape_string($post['ram_size'][$ram_key]).'", ram_size_postfix="'.real_escape_string($post['ram_size_postfix'][$ram_key]).'", ram_price="'.$post['ram_price'][$ram_key].'" WHERE model_id="'.$model_id.'" AND id="'.$ram_key.'"');
							$saved_ram_ids[] = $ram_key;
						}
					}
				}
			}
		}
		if(!empty($saved_ram_ids)) {
			mysqli_query($db,"DELETE FROM models_ram WHERE model_id='".$model_id."' AND id NOT IN(".implode(",",$saved_ram_ids).")");
		} //END save/update for ram section
			
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE mobile SET title="'.$title.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", device_id="'.$device_id.'", cat_id="'.$cat_id.'", brand_id="'.$brand_id.'", price="'.$price.'" '.$imageupdate.', tooltip_device="'.$tooltip_device.'", top_seller="'.$top_seller.'", published="'.$published.'", ordering="'.$ordering.'", sef_url="'.$sef_url.'", meta_canonical_url="'.$meta_canonical_url.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$model_id = $post['id'];
			save_model_fields($model_id,$post);

			/*$d_mc_query=mysqli_query($db,'DELETE FROM model_catalog WHERE model_id="'.$post['id'].'"');
			if($d_mc_query=="1") {
				if(!empty($post['p_cond_price'])) {
					if($fields_type == "mobile" || $fields_type == "tablet") {
						foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
								$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata));
								if($fields_type == "mobile") {
									mysqli_query($db,'INSERT INTO model_catalog(model_id, network, storage, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
								} elseif($fields_type == "tablet") {
									mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, storage, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
								}
							}
						}
					} elseif($fields_type == "watch") {
						foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
								foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
									$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata_subdata));
									if($fields_type == "watch") {
										mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, case_size, model, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_condition_data.'")');
									}
								}
							}
						}
					} elseif($fields_type == "other") {
						foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
							$p_condition_data=real_escape_string(json_encode($p_cond_price_data));
							if($fields_type == "other") {
								mysqli_query($db,'INSERT INTO model_catalog(model_id, model, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_condition_data.'")');
							}
						}
					} elseif($fields_type == "laptop") {
						foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
								foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
									foreach($p_cond_price_subdata_subdata as $p_sss=>$p_cond_price_sub_sub_sub) {
										foreach($p_cond_price_sub_sub_sub as $p_ssss=>$p_cond_price_sub_sub_sub_sub) {
											$p_condition_data=real_escape_string(json_encode($p_cond_price_sub_sub_sub_sub));
											if($fields_type == "laptop") {
												mysqli_query($db,'INSERT INTO model_catalog(model_id, model, processor, ram, storage, graphics_card, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_sss.'","'.$p_ssss.'","'.$p_condition_data.'")');
											}
										}
									}
								}
							}
						}
					}
				}
			}*/

			$msg="Model has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
	} else {
		$_q='INSERT INTO mobile(title, meta_title, meta_desc, meta_keywords, device_id, cat_id, brand_id, price, model_img, tooltip_device, top_seller, published, ordering, sef_url, meta_canonical_url) values("'.$title.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$device_id.'","'.$cat_id.'","'.$brand_id.'","'.$price.'","'.$image_name.'","'.$tooltip_device.'","'.$top_seller.'","'.$published.'","'.$ordering.'","'.$sef_url.'","'.$meta_canonical_url.'")';
		$query=mysqli_query($db,$_q);
		if($query=="1") {
			$model_id = mysqli_insert_id($db);
			save_model_fields($model_id,$post);
			
			$msg="Model has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'mobile.php');
		} else {
			$msg='Sorry! something wrong add failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_mobile.php');
		}
	}
} elseif(isset($post['pricing'])) {
	if($post['id']) {
		$category_data = get_category_data($post['cat_id']);
		$fields_type = $category_data['fields_type'];

		$d_mc_query=mysqli_query($db,'DELETE FROM model_catalog WHERE model_id="'.$post['id'].'"');
		if($d_mc_query=="1") {
			if(!empty($post['p_cond_price'])) {
				if($fields_type == "mobile" || $fields_type == "tablet") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata));
							if($fields_type == "mobile") {
								mysqli_query($db,'INSERT INTO model_catalog(model_id, network, storage, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							} elseif($fields_type == "tablet") {
								mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, storage, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							}/* elseif($fields_type == "watch") {
								mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, case_size, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							}*/
						}
					}
				} /*elseif($fields_type == "watch") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
								$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata_subdata));
								if($fields_type == "watch") {
									mysqli_query($db,'INSERT INTO model_catalog(model_id, watchtype, case_material, case_size, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_condition_data.'")');
								}
							}
						}
					}
				}*/ elseif($fields_type == "watch") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
								$p_condition_data=real_escape_string(json_encode($p_cond_price_subdata_subdata));
								if($fields_type == "watch") {
									mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, case_size, model, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_condition_data.'")');
								}
							}
						}
					}
				} elseif($fields_type == "other") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						$p_condition_data=real_escape_string(json_encode($p_cond_price_data));
						if($fields_type == "other") {
							mysqli_query($db,'INSERT INTO model_catalog(model_id, model, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_condition_data.'")');
						}
					}
				} elseif($fields_type == "laptop") {
					foreach($post['p_cond_price'] as $p_n=>$p_cond_price_data) {
						foreach($p_cond_price_data as $p_s=>$p_cond_price_subdata) {
							foreach($p_cond_price_subdata as $p_ss=>$p_cond_price_subdata_subdata) {
								foreach($p_cond_price_subdata_subdata as $p_sss=>$p_cond_price_sub_sub_sub) {
									foreach($p_cond_price_sub_sub_sub as $p_ssss=>$p_cond_price_sub_sub_sub_sub) {
										$p_condition_data=real_escape_string(json_encode($p_cond_price_sub_sub_sub_sub));
										if($fields_type == "laptop") {
											mysqli_query($db,'INSERT INTO model_catalog(model_id, model, processor, ram, storage, graphics_card, conditions) values("'.$post['id'].'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_sss.'","'.$p_ssss.'","'.$p_condition_data.'")');
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$msg="Model pricing has been successfully updated.";
		$_SESSION['success_msg']=$msg;
		//setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id'].'&pricing=1');
		setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
	}
} elseif(isset($post['export'])) {
	$ids = $post['ids'];

	$filter_by = "";
	if($post['filter_by']) {
		$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
	}

	if($post['cat_id']) {
		$filter_by .= " AND m.cat_id = '".$post['cat_id']."'";
	}

	if($post['brand_id']) {
		$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
	}

	if($post['device_id']) {
		$filter_by .= " AND m.device_id = '".$post['device_id']."'";
	}

	if($ids) {
		$filter_by .= " AND m.id IN(".$ids.")";
	}

	$query=mysqli_query($db,"SELECT m.*, c.title AS cat_title, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE 1 ".$filter_by." ORDER BY m.id ASC");
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		$fp = fopen('php://output', 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		$category_data = get_category_data($post['cat_id']);
		$fields_type = $category_data['fields_type'];
		if($fields_type == "mobile") {
			include("exports/mobile_2.php");
		} elseif($fields_type == "tablet") {
			include("exports/tablet_2.php");
		} elseif($fields_type == "watch") {
			include("exports/watch_2.php");
		} elseif($fields_type == "laptop") {
			include("exports/laptop_2.php");
		} elseif($fields_type == "other") {
			include("exports/other_2.php");
		}
	}
	exit();
} elseif(isset($post['import'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'mobile.php');
		exit();
	} else {
		$path = str_replace(' ','_',$_FILES['file_name']['name']);
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		if($ext=="csv" || $ext=="xls" || $ext=="xlsx") {

			$model_data_array = array();
			
			$filename=$_FILES['file_name']['tmp_name'];
			move_uploaded_file($filename,'../uploaded_file/'.$path);

			$excel_file_path = '../uploaded_file/'.$path;
			require('../libraries/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
			require('../libraries/spreadsheet-reader-master/SpreadsheetReader.php');
			$excel_file_data_list = new SpreadsheetReader($excel_file_path);
			foreach($excel_file_data_list as $ek=>$excel_file_data)
			{
				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0))
				{
					$Model_ID = $excel_file_data[0];
					$Category_Title = $excel_file_data[1];
					$Brand_Title = $excel_file_data[2];
					$Device_Title = $excel_file_data[3];
					$Model_Title = $excel_file_data[4];
					$model_title_slug = createSlug($Model_Title);
					//$Model_Image = $excel_file_data[5];

					$c_query=mysqli_query($db,"SELECT * FROM categories WHERE published='1' AND title='".$Category_Title."'");
					$category_data = mysqli_fetch_assoc($c_query);
					$fields_cat_type = $category_data['fields_type'];
					if($fields_cat_type == "mobile") {
						include("imports/mobile_2.php");
					} elseif($fields_cat_type == "tablet") {
						include("imports/tablet_2.php");
					} elseif($fields_cat_type == "watch") {
						include("imports/watch_2.php");
					} elseif($fields_cat_type == "laptop") {
						include("imports/laptop_2.php");
					} elseif($fields_cat_type == "other") {
						include("imports/other_2.php");
					}
				}
			}

			/*echo '<pre>';
			print_r($model_data_array);
			exit;*/

			foreach($model_data_array as $model_data) {
				$Model_ID = $model_data['Model_ID'];
				$Category_Title = real_escape_string($model_data['Category_Title']);
				$Brand_Title = real_escape_string($model_data['Brand_Title']);
				$Device_Title = real_escape_string($model_data['Device_Title']);
				$Model_Title = real_escape_string($model_data['Model_Title']);
				//$Model_Image = $model_data['Model_Image'];
				//$meta_title = real_escape_string($model_data['Meta_Title']);
				//$meta_desc = real_escape_string($model_data['Meta_Description']);
				//$meta_keywords = real_escape_string($model_data['Meta_Keywords']);
				$fields_cat_type = $model_data['fields_cat_type'];
				$connectivity_array = $model_data['connectivity_array'];
				$case_size_array = $model_data['case_size_array'];
				$carrier_array = $model_data['carrier_array'];
				$storage_array = $model_data['storage_array'];
				$ram_array = $model_data['ram_array'];
				$processor_array = $model_data['processor_array'];
				$model_array = $model_data['model_array'];
				$graphics_card_array = $model_data['graphics_card_array'];
				$prices_array = $model_data['prices_array'];
				
				$qr = mysqli_query($db,"SELECT * FROM mobile WHERE id='".$Model_ID."'");
				$exist_mobile_data = mysqli_fetch_assoc($qr);
				
				if($Category_Title!="") {
					$ctg_q=mysqli_query($db,"SELECT * FROM categories WHERE title='".$Category_Title."'");
					$exist_category_data=mysqli_fetch_assoc($ctg_q);
					$cat_id = $exist_category_data['id'];
					if(empty($exist_category_data)) {
						mysqli_query($db,"INSERT INTO categories(title,published) VALUES('".$Category_Title."','1')");
						$cat_id = mysqli_insert_id($db);
					}
				}
				
				if($Brand_Title!="") {
					$brd_q=mysqli_query($db,"SELECT * FROM brand WHERE title='".$Brand_Title."'");
					$exist_brand_data=mysqli_fetch_assoc($brd_q);
					$brand_id = $exist_brand_data['id'];
					if(empty($exist_brand_data)) {
						mysqli_query($db,"INSERT INTO brand(title,published) VALUES('".$Brand_Title."','1')");
						$brand_id = mysqli_insert_id($db);
					}
				}

				if($Device_Title!="") {
					$dvc_q=mysqli_query($db,"SELECT * FROM devices WHERE title='".$Device_Title."'");
					$exist_device_data=mysqli_fetch_assoc($dvc_q);
					$device_id = $exist_device_data['id'];
					if(empty($exist_device_data)) {
						mysqli_query($db,"INSERT INTO devices(brand_id,title,published) VALUES('".$brand_id."','".$Device_Title."','1')");
						$device_id = mysqli_insert_id($db);
					} else {
						mysqli_query($db,"UPDATE devices SET brand_id='".$brand_id."' WHERE id='".$device_id."'");
					}
				}

				if($Model_Title!="") {
					if(empty($exist_mobile_data)) {
						//$query = mysqli_query($db,"INSERT INTO mobile(cat_id, device_id, title, model_img, meta_title, meta_desc, meta_keywords) VALUES('".$cat_id."', '".$device_id."', '".$Model_Title."', '".$Model_Image."', '".$meta_title."', '".$meta_desc."', '".$meta_keywords."')");
						//$query = mysqli_query($db,"INSERT INTO mobile(cat_id, device_id, title, model_img) VALUES('".$cat_id."', '".$device_id."', '".$Model_Title."', '".$Model_Image."')");
						$query = mysqli_query($db,"INSERT INTO mobile(cat_id, device_id, title) VALUES('".$cat_id."', '".$device_id."', '".$Model_Title."')");
						$Model_ID = mysqli_insert_id($db);
					} else {
						//$query = mysqli_query($db,"UPDATE mobile SET cat_id='".$cat_id."', device_id='".$device_id."', title='".$Model_Title."', model_img='".$Model_Image."', meta_title='".$meta_title."', meta_desc='".$meta_desc."', meta_keywords='".$meta_keywords."' WHERE id='".$Model_ID."'");
						$query = mysqli_query($db,"UPDATE mobile SET cat_id='".$cat_id."', device_id='".$device_id."', title='".$Model_Title."' WHERE id='".$Model_ID."'");
					}
					
					if(!empty($model_data['storage_array'])) {
						foreach($model_data['storage_array'] as $key=>$value) {
							if(trim($value)) {
								$split_strg_val = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$value);
								$storage_q=mysqli_query($db,'SELECT * FROM models_storage WHERE model_id="'.$Model_ID.'" AND storage_size="'.$split_strg_val['0'].'" AND storage_size_postfix="'.$split_strg_val['1'].'"');
								$models_storage_data=mysqli_fetch_assoc($storage_q);
								if(empty($models_storage_data)) {
									$query=mysqli_query($db,'INSERT INTO models_storage(model_id, storage_size, storage_size_postfix) values("'.$Model_ID.'","'.$split_strg_val['0'].'","'.$split_strg_val['1'].'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_storage SET storage_size="'.$split_strg_val['0'].'",storage_size_postfix="'.$split_strg_val['1'].'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_storage_data['id'].'"');
								}
							}
						}
					}

					if(!empty($model_data['ram_array'])) {
						foreach($model_data['ram_array'] as $ram_key=>$ram_value) {
							if(trim($ram_value)) {
								$split_ram_strg_val = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$ram_value);
								$ram_q=mysqli_query($db,'SELECT * FROM models_ram WHERE model_id="'.$Model_ID.'" AND ram_size="'.$split_ram_strg_val['0'].'" AND ram_size_postfix="'.$split_ram_strg_val['1'].'"');
								$models_ram_data=mysqli_fetch_assoc($ram_q);
								if(empty($models_ram_data)) {
									$query=mysqli_query($db,'INSERT INTO models_ram(model_id, ram_size, ram_size_postfix) values("'.$Model_ID.'","'.$split_ram_strg_val['0'].'","'.$split_ram_strg_val['1'].'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_ram SET ram_size="'.$split_ram_strg_val['0'].'",ram_size_postfix="'.$split_ram_strg_val['1'].'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_ram_data['id'].'"');
								}
							}
						}
					}

					if(!empty($model_data['carrier_array'])) {
						foreach($model_data['carrier_array'] as $n_key=>$n_value) {
							if(trim($n_value)) {
								$ntwk_q=mysqli_query($db,'SELECT * FROM models_networks WHERE model_id="'.$Model_ID.'" AND network_name="'.$n_value.'"');
								$models_ntwk_data=mysqli_fetch_assoc($ntwk_q);
								if(empty($models_ntwk_data)) {
									$query=mysqli_query($db,'INSERT INTO models_networks(model_id, network_name) values("'.$Model_ID.'","'.$n_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_networks SET network_name="'.$n_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_ntwk_data['id'].'"');
								}
							}
						}
					}
					
					if(!empty($model_data['condition_array'])) {
						foreach($model_data['condition_array'] as $c_key=>$c_value) {
							if(trim($c_value)) {
								$cond_q=mysqli_query($db,'SELECT * FROM models_condition WHERE model_id="'.$Model_ID.'" AND condition_name="'.$c_value.'"');
								$models_cond_data=mysqli_fetch_assoc($cond_q);
								if(empty($models_cond_data)) {
									$query=mysqli_query($db,'INSERT INTO models_condition(model_id, condition_name) values("'.$Model_ID.'","'.$c_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_condition SET condition_name="'.$c_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_cond_data['id'].'"');
								}
							}
						}
					}

					if(!empty($model_data['connectivity_array'])) {
						foreach($model_data['connectivity_array'] as $cnct_key=>$cnct_value) {
							if(trim($cnct_value)) {
								$cnct_q=mysqli_query($db,'SELECT * FROM models_connectivity WHERE model_id="'.$Model_ID.'" AND connectivity_name="'.$cnct_value.'"');
								$models_cnct_data=mysqli_fetch_assoc($cnct_q);
								if(empty($models_cnct_data)) {
									$query=mysqli_query($db,'INSERT INTO models_connectivity(model_id, connectivity_name) values("'.$Model_ID.'","'.$cnct_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_connectivity SET connectivity_name="'.$cnct_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_cnct_data['id'].'"');
								}
							}
						}
					}
					
					if(!empty($model_data['model_array'])) {
						foreach($model_data['model_array'] as $mdl_key=>$mdl_value) {
							if(trim($mdl_value)) {
								$mdl_q=mysqli_query($db,'SELECT * FROM models_model WHERE model_id="'.$Model_ID.'" AND model_name="'.$mdl_value.'"');
								$models_mdl_data=mysqli_fetch_assoc($mdl_q);
								if(empty($models_mdl_data)) {
									$query=mysqli_query($db,'INSERT INTO models_model(model_id, model_name) values("'.$Model_ID.'","'.$mdl_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_model SET model_name="'.$mdl_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_mdl_data['id'].'"');
								}
							}
						}
					}
					
					if(!empty($model_data['graphics_card_array'])) {
						foreach($model_data['graphics_card_array'] as $gcn_key=>$gcn_value) {
							if(trim($gcn_value)) {
								$gcn_q=mysqli_query($db,'SELECT * FROM models_graphics_card WHERE model_id="'.$Model_ID.'" AND graphics_card_name="'.$gcn_value.'"');
								$models_gcn_data=mysqli_fetch_assoc($gcn_q);
								if(empty($models_gcn_data)) {
									$query=mysqli_query($db,'INSERT INTO models_graphics_card(model_id, graphics_card_name) values("'.$Model_ID.'","'.$gcn_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_graphics_card SET graphics_card_name="'.$gcn_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_gcn_data['id'].'"');
								}
							}
						}
					}
					
					if(!empty($model_data['processor_array'])) {
						foreach($model_data['processor_array'] as $prces_key=>$prces_value) {
							if(trim($prces_value)) {
								$prces_q=mysqli_query($db,'SELECT * FROM models_processor WHERE model_id="'.$Model_ID.'" AND processor_name="'.$prces_value.'"');
								$models_prces_data=mysqli_fetch_assoc($prces_q);
								if(empty($models_prces_data)) {
									$query=mysqli_query($db,'INSERT INTO models_processor(model_id, processor_name) values("'.$Model_ID.'","'.$prces_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_processor SET processor_name="'.$prces_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_prces_data['id'].'"');
								}
							}
						}
					}
					
					if(!empty($model_data['case_size_array'])) {
						foreach($model_data['case_size_array'] as $cssz_key=>$cssz_value) {
							if(trim($cssz_value)) {
								$cssz_q=mysqli_query($db,'SELECT * FROM models_case_size WHERE model_id="'.$Model_ID.'" AND case_size="'.$cssz_value.'"');
								$models_cssz_data=mysqli_fetch_assoc($cssz_q);
								if(empty($models_cssz_data)) {
									$query=mysqli_query($db,'INSERT INTO models_case_size(model_id, case_size) values("'.$Model_ID.'","'.$cssz_value.'")');
								} else {
									$query=mysqli_query($db,'UPDATE models_case_size SET case_size="'.$cssz_value.'" WHERE model_id="'.$Model_ID.'" AND id="'.$models_cssz_data['id'].'"');
								}
							}
						}
					}
				}

				mysqli_query($db,'DELETE FROM model_catalog WHERE model_id="'.$Model_ID.'"');
				if($fields_cat_type == "mobile") {
					if(!empty($prices_array)) {
						foreach($prices_array as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_sub) {
								$p_condition_data=real_escape_string(json_encode($p_cond_price_sub));
									mysqli_query($db,'INSERT INTO model_catalog(model_id, network, storage, conditions) values("'.$Model_ID.'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							}
						}
					}
				} elseif($fields_cat_type == "tablet") {
					if(!empty($prices_array)) {
						foreach($prices_array as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_sub) {
								$p_condition_data=real_escape_string(json_encode($p_cond_price_sub));
									mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, storage, conditions) values("'.$Model_ID.'","'.$p_n.'","'.$p_s.'","'.$p_condition_data.'")');
							}
						}
					}
				} elseif($fields_cat_type == "watch") {
					if(!empty($prices_array)) {
						foreach($prices_array as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_sub) {
								foreach($p_cond_price_sub as $p_ss=>$p_cond_price_sub_sub) {
									$p_condition_data=real_escape_string(json_encode($p_cond_price_sub_sub));
									mysqli_query($db,'INSERT INTO model_catalog(model_id, connectivity, case_size, model, conditions) values("'.$Model_ID.'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_condition_data.'")');
								}
							}
						}
					}
				} elseif($fields_cat_type == "other") {
					if(!empty($prices_array)) {
						foreach($prices_array as $p_n=>$p_cond_price_data) {
							$p_condition_data=real_escape_string(json_encode($p_cond_price_data));
							mysqli_query($db,'INSERT INTO model_catalog(model_id, model, conditions) values("'.$Model_ID.'","'.$p_n.'","'.$p_condition_data.'")');
						}
					}
				} elseif($fields_cat_type == "laptop") {
					if(!empty($prices_array)) {
						foreach($prices_array as $p_n=>$p_cond_price_data) {
							foreach($p_cond_price_data as $p_s=>$p_cond_price_sub) {
								foreach($p_cond_price_sub as $p_ss=>$p_cond_price_sub_sub) {
									foreach($p_cond_price_sub_sub as $p_sss=>$p_cond_price_sub_sub_sub) {
										foreach($p_cond_price_sub_sub_sub as $p_ssss=>$p_cond_price_sub_sub_sub_sub) {
											$p_condition_data=real_escape_string(json_encode($p_cond_price_sub_sub_sub_sub));
											mysqli_query($db,'INSERT INTO model_catalog(model_id, model, processor, ram, storage, graphics_card, conditions) values("'.$Model_ID.'","'.$p_n.'","'.$p_s.'","'.$p_ss.'","'.$p_sss.'","'.$p_ssss.'","'.$p_condition_data.'")');
										}
									}
								}
							}
						}
					}
				}
			}

			if($query == '1') {
				unlink($excel_file_path);
				$msg="Data(s) successfully imported.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong imported failed.';
				$_SESSION['error_msg']=$msg;
			}
		} else {
			$msg="Allow only .csv, .xls or .xlsx file.";
			$_SESSION['success_msg']=$msg;
		}
	}
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['r_img_id'])) {
	$mobile_data_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['r_img_id'].'"');
	$mobile_data=mysqli_fetch_assoc($mobile_data_q);

	$del_logo=mysqli_query($db,'UPDATE mobile SET model_img="" WHERE id='.$post['r_img_id']);
	if($mobile_data['model_img']!="")
		unlink('../../images/mobile/'.$mobile_data['model_img']);

	setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE mobile SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Please enter ordering value per row wise.';
		$_SESSION['error_msg']=$msg;
	}
	
	$url_params = "?device_id=".$post['device_id'];
	if($post['filter_by']) {
		$url_params .= "&filter_by=".$post['filter_by'];
	}
	if($post['cat_id']) {
		$url_params .= "&cat_id=".$post['cat_id'];
	}
	if($post['brand_id']) {
		$url_params .= "&brand_id=".$post['brand_id'];
	}

	setRedirect(ADMIN_URL.'mobile.php'.$url_params);
} elseif($post['action']=="set_default_fields" && isset($post['id'])) {
	$model_id = $post['id'];
	
	$m_q=mysqli_query($db,'SELECT * FROM mobile WHERE id="'.$model_id.'"');
	$models_data=mysqli_fetch_assoc($m_q);
	$cat_id=$models_data['cat_id'];

	$storage_items_array = get_category_storage_data($cat_id);
	$condition_items_array = get_category_condition_data($cat_id);
	$network_items_array = get_category_networks_data($cat_id);
	$connectivity_items_array = get_category_connectivity_data($cat_id);
	$watchtype_items_array = get_category_watchtype_data($cat_id);
	$case_material_items_array = get_category_case_material_data($cat_id);
	$case_size_items_array = get_category_case_size_data($cat_id);
	$accessories_items_array = get_category_accessories_data($cat_id);
	$band_included_items_array = get_category_band_included_data($cat_id);
	$processor_items_array = get_category_processor_data($cat_id);
	$ram_items_array = get_category_ram_data($cat_id);
	$model_items_array = get_category_model_data($cat_id);
	$graphics_card_items_array = get_category_graphics_card_data($cat_id);

	mysqli_query($db,"DELETE FROM models_storage WHERE model_id='".$model_id."'");
	if(!empty($storage_items_array)) {
		foreach($storage_items_array as $storage_item) {
			mysqli_query($db,'INSERT INTO models_storage(model_id, storage_size, storage_size_postfix, plus_minus, fixed_percentage, storage_price, top_seller) values("'.$model_id.'","'.$storage_item['storage_size'].'","'.$storage_item['storage_size_postfix'].'","'.$storage_item['plus_minus'].'","'.$storage_item['fixed_percentage'].'","'.$storage_item['storage_price'].'","'.$storage_item['top_seller'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_condition WHERE model_id='".$model_id."'");
	if(!empty($condition_items_array)) {
		foreach($condition_items_array as $condition_item) {
			$query=mysqli_query($db,'INSERT INTO models_condition(model_id, condition_name, plus_minus, fixed_percentage, condition_price, condition_terms, disabled_network) values("'.$model_id.'","'.real_escape_string($condition_item['condition_name']).'","'.$condition_item['plus_minus'].'","'.$condition_item['fixed_percentage'].'","'.$condition_item['condition_price'].'","'.real_escape_string($condition_item['condition_terms']).'","'.$condition_item['disabled_network'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_connectivity WHERE model_id='".$model_id."'");
	if(!empty($connectivity_items_array)) {
		foreach($connectivity_items_array as $connectivity_item) {
			$query=mysqli_query($db,'INSERT INTO models_connectivity(model_id, connectivity_name) values("'.$model_id.'","'.real_escape_string($connectivity_item['connectivity_name']).'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_model WHERE model_id='".$model_id."'");
	if(!empty($model_items_array)) {
		foreach($model_items_array as $model_item) {
			$query=mysqli_query($db,'INSERT INTO models_model(model_id, model_name) values("'.$model_id.'","'.real_escape_string($model_item['model_name']).'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_graphics_card WHERE model_id='".$model_id."'");
	if(!empty($graphics_card_items_array)) {
		foreach($graphics_card_items_array as $graphics_card_item) {
			$query=mysqli_query($db,'INSERT INTO models_graphics_card(model_id, graphics_card_name) values("'.$model_id.'","'.real_escape_string($graphics_card_item['graphics_card_name']).'")');
		}
	}

	mysqli_query($db,"DELETE FROM models_ram WHERE model_id='".$model_id."'");
	if(!empty($ram_items_array)) {
		foreach($ram_items_array as $ram_item) {
			$query=mysqli_query($db,'INSERT INTO models_ram(model_id, ram_size, ram_size_postfix, ram_price) values("'.$model_id.'","'.real_escape_string($ram_item['ram_size']).'","'.$ram_item['ram_size_postfix'].'","'.$ram_item['ram_price'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_processor WHERE model_id='".$model_id."'");
	if(!empty($processor_items_array)) {
		foreach($processor_items_array as $processor_item) {
			$query=mysqli_query($db,'INSERT INTO models_processor(model_id, processor_name, processor_price) values("'.$model_id.'","'.real_escape_string($processor_item['processor_name']).'","'.$processor_item['processor_price'].'")');
		}
	}

	mysqli_query($db,"DELETE FROM models_accessories WHERE model_id='".$model_id."'");
	if(!empty($accessories_items_array)) {
		foreach($accessories_items_array as $accessories_item) {
			$query=mysqli_query($db,'INSERT INTO models_accessories(model_id, accessories_name, plus_minus, fixed_percentage, accessories_price) values("'.$model_id.'","'.real_escape_string($accessories_item['accessories_name']).'","'.$accessories_item['plus_minus'].'","'.$accessories_item['fixed_percentage'].'","'.$accessories_item['accessories_price'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_band_included WHERE model_id='".$model_id."'");
	if(!empty($band_included_items_array)) {
		foreach($band_included_items_array as $band_included_item) {
			$query=mysqli_query($db,'INSERT INTO models_band_included(model_id, band_included_name, plus_minus, fixed_percentage, band_included_price) values("'.$model_id.'","'.real_escape_string($band_included_item['band_included_name']).'","'.$band_included_item['plus_minus'].'","'.$band_included_item['fixed_percentage'].'","'.$band_included_item['band_included_price'].'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_case_size WHERE model_id='".$model_id."'");
	if(!empty($case_size_items_array)) {
		foreach($case_size_items_array as $case_size_item) {
			$query=mysqli_query($db,'INSERT INTO models_case_size(model_id, case_size) values("'.$model_id.'","'.real_escape_string($case_size_item['case_size']).'")');
		}
	}
	
	mysqli_query($db,"DELETE FROM models_networks WHERE model_id='".$model_id."'");
	if(!empty($network_items_array)) {
		foreach($network_items_array as $network_item) {

			$network_price = 0;
			$network_price = ($network_item['network_price']>0?$network_item['network_price']:0);
		
			$query=mysqli_query($db,'INSERT INTO models_networks(model_id, network_name, plus_minus, fixed_percentage, network_price, most_popular, change_unlock, network_icon) values("'.$model_id.'","'.$network_item['network_name'].'","'.$network_item['plus_minus'].'","'.$network_item['fixed_percentage'].'","'.$network_price.'","'.$network_item['most_popular'].'","'.$network_item['change_unlock'].'","'.$network_item['network_icon'].'")');
		}
	}

	setRedirect(ADMIN_URL.'edit_mobile.php?id='.$model_id);
} elseif(isset($post['import_meta'])) {
	if($_FILES['file_name']['name'] == "") {
		$msg="Please choose .csv, .xls or .xlsx file.";
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'mobile.php');
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
				$Model_ID = $excel_file_data[0];
				$Title = real_escape_string($excel_file_data[1]);
				$Sef_Url = real_escape_string($excel_file_data[2]);
				$Model_Image = $excel_file_data[3];
				$Meta_Title = real_escape_string($excel_file_data[4]);
				$Meta_Keywords = real_escape_string($excel_file_data[5]);
				$Meta_Description = real_escape_string($excel_file_data[6]);
				$Meta_Canonical_URL = $excel_file_data[7];

				if(($ext=="xls" && $ek>1) || ($ext!="xls" && $ek>0)) {
					if($Title!="") {
						$qr=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$Model_ID."'");
						$exist_mobile_data=mysqli_fetch_assoc($qr);
						if(empty($exist_mobile_data)) {
							mysqli_query($db,"INSERT INTO mobile(title, sef_url, meta_title, meta_desc, meta_keywords, meta_canonical_url, model_img) VALUES('".$Title."','".$Sef_Url."','".$Meta_Title."','".$Meta_Description."','".$Meta_Keywords."','".$Meta_Canonical_URL."','".$Model_Image."')");
							//$f_model_id = mysqli_insert_id($db);
							$data_imported = true;
						} else {
							mysqli_query($db,"UPDATE mobile SET title='".$Title."', sef_url='".$Sef_Url."', meta_title='".$Meta_Title."', meta_desc='".$Meta_Description."', meta_keywords='".$Meta_Keywords."', meta_canonical_url='".$Meta_Canonical_URL."', model_img='".$Model_Image."' WHERE id='".$Model_ID."'");
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
	setRedirect(ADMIN_URL.'mobile.php');
} elseif(isset($post['export_meta'])) {
	$ids = $post['ids'];

	$filter_by = "";
	if($post['filter_by']) {
		$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
	}

	if($post['cat_id']) {
		$filter_by .= " AND m.cat_id = '".$post['cat_id']."'";
	}

	if($post['brand_id']) {
		$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
	}

	if($post['device_id']) {
		$filter_by .= " AND m.device_id = '".$post['device_id']."'";
	}

	if($ids) {
		$filter_by .= " AND m.id IN(".$ids.")";
	}

	$query=mysqli_query($db,"SELECT m.*, c.title AS cat_title, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE 1 ".$filter_by." ORDER BY m.id ASC");
	$num_rows = mysqli_num_rows($query);
	if($num_rows>0) {
		$filename = 'models-'.date("YmdHis").".csv";
		$fp = fopen('php://output', 'w');
		//$fp = fopen('../../uploaded_file/'.$filename, 'w');	
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);

		$header = array('Model_ID','Title','Sef_Url','Meta_Title','Meta_Keywords','Meta_Description','Meta_Canonical_URL');
		fputcsv($fp, $header);

		$data_to_csv_array = array();
		while($model_data=mysqli_fetch_assoc($query)) {
			$data_to_csv = array();
			$data_to_csv['Model_ID'] = $model_data['id'];
			$data_to_csv['Title'] = $model_data['title'];
			$data_to_csv['Sef_Url'] = $model_data['sef_url'];
			$data_to_csv['Model_Image'] = $model_data['model_img'];
			$data_to_csv['Meta_Title'] = $model_data['meta_title'];
			$data_to_csv['Meta_Keywords'] = $model_data['meta_keywords'];
			$data_to_csv['Meta_Description'] = $model_data['meta_desc'];
			$data_to_csv['Meta_Canonical_URL'] = $model_data['meta_canonical_url'];
			$data_to_csv_array[] = $data_to_csv;
		}

		if(!empty($data_to_csv_array)) {
			foreach($data_to_csv_array as $data_to_csv_data) {
				$f_data_to_csv = array();
				$f_data_to_csv[] = $data_to_csv_data['Model_ID'];
				$f_data_to_csv[] = $data_to_csv_data['Title'];
				$f_data_to_csv[] = $data_to_csv_data['Sef_Url'];
				$f_data_to_csv[] = $data_to_csv_data['Model_Image'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Title'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Keywords'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Description'];
				$f_data_to_csv[] = $data_to_csv_data['Meta_Canonical_URL'];
				fputcsv($fp, $f_data_to_csv);
			}
		}
	}
	exit;
} else {
	setRedirect(ADMIN_URL.'mobile.php');
}
exit();
?>