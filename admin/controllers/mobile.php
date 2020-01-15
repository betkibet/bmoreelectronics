<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['c_id'])) {
	$qry=mysqli_query($db,"SELECT * FROM mobile WHERE id='".$post['c_id']."'");
	$model_data=mysqli_fetch_assoc($qry);
	$model_data['title'] = $model_data['title'].' - Copy';
	$model_data['published'] = 0;
	
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

	setRedirect(ADMIN_URL.'add_product.php?id='.$last_insert_id);
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
} if(isset($post['update'])) {
	$device_id = $post['device_id'];
	$cat_id = $post['cat_id'];
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

	if(!empty($post['storage_size'])) {
		foreach($post['storage_size'] as $key=>$value) {
			if(trim($value)) {
				$storage[] = array('storage_size'=>$value,'storage_price'=>$post['storage_price'][$key]);
			}
		}
		$storage_data=real_escape_string(json_encode($storage));
	}

	if(!empty($post['condition_name'])) {
		foreach($post['condition_name'] as $c_key=>$c_value) {
			if(trim($c_value)) {
				$condition[] = array('condition_name'=>$c_value,'condition_price'=>$post['condition_price'][$c_key],'condition_terms'=>htmlentities($post['condition_terms'][$c_key]),'disabled_network'=>$post['disabled_network'][$c_key]);
			}
		}
		$condition_data=real_escape_string(json_encode($condition));
	}

	if(!empty($post['color_name'])) {
		foreach($post['color_name'] as $cl_key=>$cl_value) {
			if(trim($cl_value)) {
				$colors[] = array('color_name'=>$cl_value,'color_price'=>$post['color_price'][$cl_key]);
			}
		}
		$colors_data=real_escape_string(json_encode($colors));
	}

	if(!empty($post['accessories_name'])) {
		foreach($post['accessories_name'] as $asr_key=>$asr_value) {
			if(trim($asr_value)) {
				$accessories[] = array('accessories_name'=>$asr_value,'accessories_price'=>$post['accessories_price'][$asr_key]);
			}
		}
		$accessories_data=real_escape_string(json_encode($accessories));
	}

	if(!empty($post['miscellaneous_name'])) {
		foreach($post['miscellaneous_name'] as $m_key=>$m_value) {
			if(trim($m_value)) {
				$miscellaneous[] = array('miscellaneous_name'=>$m_value,'miscellaneous_price'=>$post['miscellaneous_price'][$m_key]);
			}
		}
		$miscellaneous_data=real_escape_string(json_encode($miscellaneous));
	}

	if(!empty($post['network_name'])) {	
		foreach($post['network_name'] as $n_key=>$n_value) {
			$network_price = 0;
			$network_price = ($post['network_price'][$n_key]>0?$post['network_price'][$n_key]:0);
			$network[] = array('network_name'=>$n_value,'network_price'=>$network_price,'most_popular'=>$post['most_popular'][$n_key],'change_unlock'=>$post['change_unlock'][$n_key]);
		}
		$network_data=real_escape_string(json_encode($network));
	}

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

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE mobile SET title="'.$title.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", device_id="'.$device_id.'", cat_id="'.$cat_id.'", price="'.$price.'" '.$imageupdate.', storage="'.$storage_data.'", conditions="'.$condition_data.'", unlock_price="'.$unlock_price.'", network="'.$network_data.'", tooltip_device="'.$tooltip_device.'", tooltip_condition="'.$tooltip_condition.'", tooltip_network="'.$tooltip_network.'", tooltip_colors="'.$tooltip_colors.'", tooltip_miscellaneous="'.$tooltip_miscellaneous.'", tooltip_accessories="'.$tooltip_accessories.'", top_seller="'.$top_seller.'", published="'.$published.'", colors="'.$colors_data.'", accessories="'.$accessories_data.'", miscellaneous="'.$miscellaneous_data.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Model has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_mobile.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO mobile(title, meta_title, meta_desc, meta_keywords, device_id, cat_id, price, model_img, storage, conditions, unlock_price, network, tooltip_device, tooltip_condition, tooltip_network, tooltip_colors, tooltip_miscellaneous, tooltip_accessories, top_seller, published, colors, accessories, miscellaneous) values("'.$title.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$device_id.'","'.$cat_id.'","'.$price.'","'.$image_name.'","'.$storage_data.'","'.$condition_data.'","'.$unlock_price.'","'.$network_data.'","'.$tooltip_device.'","'.$tooltip_condition.'","'.$tooltip_network.'","'.$tooltip_colors.'","'.$tooltip_miscellaneous.'","'.$tooltip_accessories.'","'.$top_seller.'","'.$published.'","'.$colors_data.'","'.$accessories_data.'","'.$miscellaneous_data.'")');
		if($query=="1") {
			$msg="Model has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'mobile.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_mobile.php');
		}
	}
} elseif(isset($post['r_img_id'])) {
	$mobile_data_q=mysqli_query($db,'SELECT model_img FROM mobile WHERE id="'.$post['r_img_id'].'"');
	$mobile_data=mysqli_fetch_assoc($mobile_data_q);

	$del_logo=mysqli_query($db,'UPDATE mobile SET model_img="" WHERE id='.$post['r_img_id']);
	if($mobile_data['model_img']!="")
		unlink('../../images/mobile/'.$mobile_data['model_img']);

	setRedirect(ADMIN_URL.'add_product.php?id='.$post['id']);
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
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'mobile.php');
} else {
	setRedirect(ADMIN_URL.'mobile.php');
}
exit();
?>