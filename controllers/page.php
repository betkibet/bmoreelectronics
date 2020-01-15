<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$page_q=mysqli_query($db,'SELECT image FROM pages WHERE id="'.$post['d_id'].'"');
	$page_data=mysqli_fetch_assoc($page_q);

	$query=mysqli_query($db,'DELETE FROM pages WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		if($page_data['image']!="")
			unlink('../../images/pages/'.$page_data['image']);

		$msg="Page has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'page.php');
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
	setRedirect(ADMIN_URL.'page.php');
} elseif(isset($post['add_edit'])) {
	$id = $post['id'];
	$is_custom_url=$post['is_custom_url'];
	if($is_custom_url == '1') {
		$url=real_escape_string($post['url']);
	} else {
		$url=createSlug(real_escape_string($post['url']));
	}
	$is_open_new_window=$post['is_open_new_window'];
	$css_menu_class=$post['css_menu_class'];
	$css_menu_fa_icon=$post['css_menu_fa_icon'];
	$menu_name=real_escape_string($post['menu_name']);
	$title=real_escape_string($post['title']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$content=real_escape_string($post['description']);
	foreach($post['position'] as $key=>$val) {
		$position_array[$val] = $val;
	}
	//$cat_id=$post['cat_id'];
	$show_title=$post['show_title'];
	$image_text=real_escape_string($post['image_text']);

	$position=real_escape_string(json_encode($position_array));
	$ordering=$post['ordering'];
	$published = $post['published'];
	$menu_align = $post['menu_align'];
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
			setRedirect(ADMIN_URL.'edit_page.php?id='.$id.($post['slug']?'&slug='.$post['slug']:''));
		} else {
			setRedirect(ADMIN_URL.'edit_page.php');
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
				setRedirect(ADMIN_URL.'edit_page.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_page.php');
			}
			exit();
		}
	}

	if($id) {
		$query=mysqli_query($db,'UPDATE pages SET menu_name="'.$menu_name.'", url="'.$url.'", is_custom_url="'.$is_custom_url.'", title="'.$title.'", show_title="'.$show_title.'", image_text="'.$image_text.'"'.$imageupdate.', meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", content="'.$content.'", position="'.$position.'", ordering="'.$ordering.'", published="'.$published.'", is_open_new_window="'.$is_open_new_window.'", css_menu_class="'.$css_menu_class.'", css_menu_fa_icon="'.$css_menu_fa_icon.'", menu_align="'.$menu_align.'", updated_date="'.$date.'"'.$upt_query.' WHERE id="'.$id.'"');
		if($query=="1") {
			$msg="Page has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_page.php?id='.$id.($post['slug']?'&slug='.$post['slug']:''));
	} else {
		$query=mysqli_query($db,'INSERT INTO pages(menu_name, url, is_custom_url, title, show_title, image_text, image, meta_title, meta_desc, meta_keywords, content, position, ordering, published, added_date, type, slug, is_open_new_window, css_menu_class, css_menu_fa_icon, menu_align) values("'.$menu_name.'","'.$url.'","'.$is_custom_url.'","'.$title.'","'.$show_title.'","'.$image_text.'","'.$image_name.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$content.'","'.$position.'","'.$ordering.'","'.$published.'","'.$date.'","'.$type.'","'.$slug.'","'.$is_open_new_window.'","'.$css_menu_class.'","'.$css_menu_fa_icon.'","'.$menu_align.'")');
		if($query=="1") {
			$msg="Page has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'page.php');
		} else {
			$msg='Sorry! something wrong save failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_page.php');
		}
	}
} elseif($post['r_img_id']) {
	$query=mysqli_query($db,'SELECT image FROM pages WHERE id="'.$post['r_img_id'].'"');
	$page_data=mysqli_fetch_assoc($query);

	mysqli_query($db,'UPDATE pages SET image="" WHERE id='.$post['r_img_id']);
	if($page_data['image']!="")
		unlink('../../images/pages/'.$page_data['image']);

	setRedirect(ADMIN_URL.'edit_page.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'page.php');
}
exit();
?>
