<?php
$file_name="blog";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch single blog data based on blog id, If already added post
$query=mysqli_query($db,'SELECT * FROM blog_posts_seo WHERE postID="'.$id.'"');
$blog_data=mysqli_fetch_assoc($query);

function get_categories_list($postID) {
	global $db;
	$cat_q = mysqli_query($db,'SELECT catID, catTitle FROM blog_cats ORDER BY catTitle');
	while($cat_data = mysqli_fetch_assoc($cat_q)){
		$stmt3 = mysqli_query($db,'SELECT catID FROM blog_post_cats WHERE catID = "'.$cat_data['catID'].'" AND postID = "'.$postID.'"') ;
		$row3 = mysqli_fetch_assoc($stmt3);
		if($cat_data['catID']==$row3['catID']) {
		   $checked="checked='checked'";
		} else {
		   $checked = null;
		}
		echo "<label class='m-checkbox showhide_menu_url'><input type='checkbox' name='catID[]' value='".$cat_data['catID']."' $checked> ".$cat_data['catTitle']."<span></span></label>";
	}
}

//Template file
require_once("views/blog/add-post.php");

//Footer section
// require_once("include/footer.php"); ?>
