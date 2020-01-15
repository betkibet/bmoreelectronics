<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM pages WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		$msg="Page has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'system_page.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM pages WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'system_page.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE pages SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'system_page.php');
} elseif(isset($post['add_edit'])) {
	$id = $post['id'];
	$is_custom_url=$post['is_custom_url'];
	if($is_custom_url == '1') {
		$url=real_escape_string($post['url']);
	} else {
		$url=createSlug(real_escape_string($post['url']));
	}
	$is_open_new_window=$post['is_open_new_window'];
	$css_page_class=$post['css_page_class'];

	$title=real_escape_string($post['title']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$content=real_escape_string($post['description']);
	
	$cat_id=$post['cat_id'];
	$brand_id=$post['brand_id'];
	$device_id = implode(",",$post['device_id']);
	
	$show_title=$post['show_title'];
	$image_text=real_escape_string($post['image_text']);
	$published = $post['published'];
	
	$c_b_d_type = $post['c_b_d_type'];
	if($c_b_d_type == "cat") {
		$brand_id='';
		$device_id='';
	} elseif($c_b_d_type == "brand") {
		$cat_id='';
		$device_id='';
	} elseif($c_b_d_type == "device") {
		$cat_id='';
		$brand_id='';
	} else {
		$cat_id='';
		$brand_id='';
		$device_id='';
	}

	$date = date('Y-m-d H:i:s');
	
	$type = '';
	$slug = '';
	if($post['slug']) {
		$type = 'inbuild';
		$slug = $post['slug'];
		$upt_query = ', type="'.$type.'", slug="'.$slug.'"';
	}
	
	if($post['slug']=="home") {
		$url='';
	}

	$qry=mysqli_query($db,"SELECT * FROM pages WHERE url='".$url."' AND url!='' AND id!='".$id."'");
	$exist_data=mysqli_fetch_assoc($qry);
	if(!empty($exist_data)) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($id) {
			setRedirect(ADMIN_URL.'edit_system_page.php?id='.$id.($post['slug']?'&slug='.$post['slug']:''));
		} else {
			setRedirect(ADMIN_URL.'edit_system_page.php');
		}
		exit();
	}
	
	if($_FILES['image']['name']) {
		if(!file_exists('../../images/pages/'))
			mkdir('../../images/pages/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/pages/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/pages/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_system_page.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_system_page.php');
			}
			exit();
		}
	}
		
	if($id) {
		$query=mysqli_query($db,'UPDATE pages SET cat_id="'.$cat_id.'", brand_id="'.$brand_id.'", device_id="'.$device_id.'", url="'.$url.'", is_custom_url="'.$is_custom_url.'", title="'.$title.'", show_title="'.$show_title.'", image_text="'.$image_text.'"'.$imageupdate.', meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", content="'.$content.'", published="'.$published.'", is_open_new_window="'.$is_open_new_window.'", updated_date="'.$date.'", css_page_class="'.$css_page_class.'", c_b_d_type="'.$c_b_d_type.'"'.$upt_query.' WHERE id="'.$id.'"');
		if($query=="1") {
			$msg="Page has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_system_page.php?id='.$id.($post['slug']?'&slug='.$post['slug']:''));
	} else {
		$query=mysqli_query($db,'INSERT INTO pages(cat_id, brand_id, device_id, url, is_custom_url, title, show_title, image_text, image, meta_title, meta_desc, meta_keywords, content, published, added_date, type, slug, is_open_new_window, css_page_class, c_b_d_type) values("'.$cat_id.'","'.$brand_id.'","'.$device_id.'","'.$url.'","'.$is_custom_url.'","'.$title.'","'.$show_title.'","'.$image_text.'","'.$image_name.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$content.'","'.$published.'","'.$date.'","'.$type.'","'.$slug.'","'.$is_open_new_window.'","'.$css_page_class.'","'.$c_b_d_type.'")');
		if($query=="1") {
			$msg="Page has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'system_page.php');
		} else {
			$msg='Sorry! something wrong save failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_system_page.php');
		}
	}
} elseif($post['r_img_id']) {
	$query=mysqli_query($db,'SELECT image FROM pages WHERE id="'.$post['r_img_id'].'"');
	$page_data=mysqli_fetch_assoc($query);

	mysqli_query($db,'UPDATE pages SET image="" WHERE id='.$post['r_img_id']);
	if($page_data['image']!="")
		unlink('../../images/pages/'.$page_data['image']);

	setRedirect(ADMIN_URL.'edit_system_page.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'system_page.php');
}
exit();
?>
