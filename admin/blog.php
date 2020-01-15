<?php
$file_name="blog";

//Header section
require_once("include/header.php");

$post_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_records FROM blog_posts_seo");
$post_p_data = mysqli_fetch_assoc($post_p_query);
$pages->set_total($post_p_data['num_of_records']);

//Fetch blog list
$query = mysqli_query($db,"SELECT postID, postTitle, postDate FROM blog_posts_seo ORDER BY postID DESC ".$pages->get_limit()."");

//Fetch categories of respective blog
function get_categories_of_blog($postID) {
	global $db;
	$cats_name = '';
	$ci = 1;
	$cat_q = mysqli_query($db,'SELECT bpc.catID, c.catTitle FROM blog_post_cats AS bpc LEFT JOIN blog_cats AS c ON bpc.catID=c.catID WHERE bpc.postID = "'.$postID.'"');
	$cat_num_rows = mysqli_num_rows($cat_q);
	if($cat_num_rows>0) {
		while($category_data = mysqli_fetch_assoc($cat_q)) {
			$cats_name .= $category_data['catTitle'];
			if($ci==($cat_num_rows)) {
				$cats_name .= '';
			} else {
				$cats_name .= ', ';
			}
			$ci++;
		}
	}
	return $cats_name;
}

//Template file
require_once("views/blog/blog.php");

//Footer section
// require_once("include/footer.php"); ?>
