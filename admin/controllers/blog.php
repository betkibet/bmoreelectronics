<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_b_id'])) {
	$query=mysqli_query($db,'DELETE FROM blog_posts_seo WHERE postID="'.$post['d_b_id'].'"');
	if($query=="1") {
		mysqli_query($db,'DELETE FROM blog_post_cats WHERE postID="'.$post['d_b_id'].'"');
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'blog.php');
} elseif(isset($post['add_edit_blog'])) {
	$id = $post['id'];
	$postTitle=real_escape_string($post['postTitle']);
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$postSlug=real_escape_string($post['postTitle']);
	$postDesc=real_escape_string($post['postDesc']);
	$postCont=real_escape_string($post['postCont']);
	$catID=$post['catID'];
	$postDate = date('Y-m-d H:i:s');

	if($_FILES['image']['name']) {
		if(!file_exists('../../images/blog/'))
			mkdir('../../images/blog/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/blog/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($id) {
				setRedirect(ADMIN_URL.'edit-post.php?id='.$id);
			} else {
				setRedirect(ADMIN_URL.'add-post.php');
			}
		}
	}
	
	if($id) {
		$query=mysqli_query($db,'UPDATE blog_posts_seo SET postTitle="'.$postTitle.'",meta_title="'.$meta_title.'",meta_desc="'.$meta_desc.'",meta_keywords="'.$meta_keywords.'",postSlug="'.createSlug($postSlug).'",postDesc="'.$postDesc.'",postCont="'.$postCont.'",postDate="'.$postDate.'"'.$imageupdate.' WHERE postID="'.$id.'"');
		if($query=="1") {
			//Delete all items with the current postID
			mysqli_query($db,'DELETE FROM blog_post_cats WHERE postID="'.$id.'"');
			
			//add categories
			if(is_array($catID)){
				foreach($catID as $catID){
					mysqli_query($db,'INSERT INTO blog_post_cats (postID,catID)VALUES("'.$id.'","'.$catID.'")');
				}
			}
			
			$msg="Post has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'add-post.php?id='.$id);
	} else {
		$query=mysqli_query($db,'INSERT INTO blog_posts_seo(postTitle,meta_title,meta_desc,meta_keywords,postSlug,postDesc,postCont,postDate,image) values("'.$postTitle.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.createSlug($postSlug).'","'.$postDesc.'","'.$postCont.'","'.$postDate.'","'.$image_name.'")');
		if($query=="1") {
			$postID = mysqli_insert_id($db);
			//Add categories
			if(is_array($catID)){
				foreach($catID as $catID){
					mysqli_query($db,'INSERT INTO blog_post_cats (postID,catID)VALUES("'.$postID.'","'.$catID.'")');
				}
			}

			$msg="Post has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'blog.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'add-post.php');
		}
	}
	exit();
} elseif($post['r_b_img_id']) {
	mysqli_query($db,'UPDATE blog_posts_seo SET image="" WHERE postID='.$post['r_b_img_id']);
	setRedirect(ADMIN_URL.'add-post.php?id='.$post['r_b_img_id']);
	exit();
} elseif(isset($_REQUEST['d_c_id'])) {
	$query=mysqli_query($db,'DELETE FROM blog_cats WHERE catID="'.$_REQUEST['d_c_id'].'"');
	if($query=="1") {
		$msg="Category has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'categories.php');
	exit();
} elseif(isset($post['add_edit_cat'])) {
	$id = $post['id'];
	$catTitle=real_escape_string($post['catTitle']);
	$catSlug=real_escape_string($post['catTitle']);

	if($catTitle) {
		if($id) {
			$query=mysqli_query($db,'UPDATE blog_cats SET catTitle="'.$catTitle.'",catSlug="'.createSlug($catSlug).'" WHERE catID="'.$id.'"');
			if($query=="1") {
				$msg="Category has been successfully updated.";
				$_SESSION['success_msg']=$msg;
			} else {
				$msg='Sorry! something wrong updation failed.';
				$_SESSION['error_msg']=$msg;
			}
			setRedirect(ADMIN_URL.'add-category.php?id='.$id);
		} else {
			$query=mysqli_query($db,'INSERT INTO blog_cats(catTitle,catSlug) VALUES("'.$catTitle.'","'.createSlug($catSlug).'")');
			if($query=="1") {
				$msg="Category has been successfully added.";
				$_SESSION['success_msg']=$msg;
				setRedirect(ADMIN_URL.'categories.php');
			} else {
				$msg='Sorry! something wrong updation failed.';
				$_SESSION['error_msg']=$msg;
				setRedirect(ADMIN_URL.'add-category.php');
			}
		}
		exit();
	}
} else {
	setRedirect(ADMIN_URL.'blog.php');
	exit();
}
