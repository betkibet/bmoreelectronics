<?php
function get_recent_posts($blog_recent_posts) {
	if($blog_recent_posts) {
		global $db;

		$blog_url = get_inbuild_page_url('blog');
		$output = '';
		$stmt = mysqli_query($db,'SELECT postTitle, postSlug FROM blog_posts_seo ORDER BY postID DESC LIMIT 5');
		$num_of_recent_post = mysqli_num_rows($stmt);
		if($num_of_recent_post>0) {
		  $output .= '<div class="h3">Recent Posts</div>';
		  $output .= '<ul>';
			  while($row = mysqli_fetch_assoc($stmt)) {
				$output .= '<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="'.SITE_URL.$blog_url.'/'.$row['postSlug'].'">'.$row['postTitle'].'</a></li>';
			  }
		  $output .= '</ul>';
		}
		echo $output;
	}
}

function get_blog_categories($blog_categories) {
	if($blog_categories) {
		global $db;
		$output = '';
		$stmt = mysqli_query($db,'SELECT catTitle, catSlug FROM blog_cats ORDER BY catID DESC');
		$num_of_recent_post = mysqli_num_rows($stmt);
		if($num_of_recent_post>0) {
			$output .= '<div class="h3">Catgories</div>';
			$output .= '<ul>';
				while($row = mysqli_fetch_assoc($stmt)){
					$output .= '<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="'.SITE_URL.'category/'.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
				}
			$output .= '</ul>';
		}
		echo $output;
	}
}

function get_blog_list($page_list_limit, $blog_rm_words_limit, $page_url) {
	global $db;
	$output = '';
	try {
		$pages = new Paginator($page_list_limit,'p');
		$stmt = mysqli_query($db,'SELECT postID FROM blog_posts_seo');
		$pages->set_total(mysqli_num_rows($stmt));

		$stmt = mysqli_query($db,'SELECT postID, postTitle, postSlug, postCont, postDate, image FROM blog_posts_seo ORDER BY postID DESC '.$pages->get_limit());
		while($row = mysqli_fetch_assoc($stmt)) {
		$output .= '<div class="block clearfix">';
			if($row['image']) {
				$output .= '<img src="'.SITE_URL.'images/blog/'.$row['image'].'" alt="">';
			}
			$output .= '<h1 class="h3"><a href="'.$page_url.'/'.$row['postSlug'].'">'.$row['postTitle'].'</a></h1>';
			$output .= '<div class="blog-credits">Posted on <span class="date">'.date('jS M Y H:i:s', strtotime($row['postDate'])).'</span> in ';
				$stmt2 = mysqli_query($db,'SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = "'.$row['postID'].'"');
				$links = array();
				while($cat = mysqli_fetch_assoc($stmt2)){
					$links[] = "<a href='".SITE_URL."category/".$cat['catSlug']."'>".$cat['catTitle']."</a>";
				}
				$output .= implode(", ", $links);
			$output .= '</div>';
			$output .= '<p>'.limit_words($row['postCont'],$blog_rm_words_limit).'</p>';
			$output .= '<p><a href="'.$page_url.'/'.$row['postSlug'].'">Read More</a></p>';
		$output .= '</div>';
		}
		$output .= $pages->page_links();
	} catch(Exception $e) {
		$output .= $e->getMessage();
	}
	echo $output;
}

function get_blog_details($blog_url) {
	if($blog_url) {
		global $db;
		$output = '';
		
		$stmt = mysqli_query($db,'SELECT postID, postTitle, postCont, postDate, image FROM blog_posts_seo WHERE postSlug = "'.$blog_url.'"');
        $row = mysqli_fetch_assoc($stmt);

        //if post does not exists redirect user.
        if($row['postID'] == '') {
        	setRedirect(SITE_URL);
        	exit;
        }
       
		$output .= '<div class="block clearfix">';
			if($row['image']) {
				$output .= '<img src="'.SITE_URL.'images/blog/'.$row['image'].'" alt="">';
			}
			$output .= '<div class="h3">'.$row['postTitle'].'</div>';
			$output .= '<div class="blog-credits">Posted on <span class="date">'.date('jS M Y H:i:s', strtotime($row['postDate'])).'</span> in ';
				$stmt2 = mysqli_query($db,'SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = "'.$row['postID'].'"');
				$links = array();
				while($cat = mysqli_fetch_assoc($stmt2)){
					$links[] = "<a href='".SITE_URL."category/".$cat['catSlug']."'>".$cat['catTitle']."</a>";
				}
				$output .= implode(", ", $links);

			$output .= '</div>';
			$output .= '<p>'.$row['postCont'].'</p>';
	   $output .= '</div>';
	   echo $output;
	}
}

function get_blog_list_based_on_cat($cat_url, $blog_rm_words_limit, $page_list_limit) {
	if($cat_url) {
		global $db;
		$output = '';
		
		$blog_url = get_inbuild_page_url('blog');
	
		$stmt = mysqli_query($db,'SELECT catID,catTitle FROM blog_cats WHERE catSlug = "'.$cat_url.'"');
		$row = mysqli_fetch_assoc($stmt);
	
		//If post does not exists redirect user.
		if($row['catID'] == ''){
			setRedirect(SITE_URL);
			exit;
		}
		
		$output .= '<div class="h1 nomargintop">Blog <small><i class="fa fa-angle-double-right" aria-hidden="true"></i> Posts in '.$row['catTitle'].'</small></div>';
		try {
			$pages = new Paginator($page_list_limit,'p');
	
			$stmt = mysqli_query($db,'SELECT blog_posts_seo.postID FROM blog_posts_seo, blog_post_cats WHERE blog_posts_seo.postID = blog_post_cats.postID AND blog_post_cats.catID = "'.$row['catID'].'"');
		
			//pass number of records to
			$pages->set_total(mysqli_num_rows($stmt));
		
			$stmt = mysqli_query($db,'
				SELECT
					blog_posts_seo.postID, blog_posts_seo.postTitle, blog_posts_seo.postSlug, blog_posts_seo.postCont, blog_posts_seo.postDate, blog_posts_seo.image
				FROM
					blog_posts_seo,
					blog_post_cats
				WHERE
					 blog_posts_seo.postID = blog_post_cats.postID
					 AND blog_post_cats.catID = "'.$row['catID'].'"
				ORDER BY
					postID DESC
				'.$pages->get_limit());
		
			while($row = mysqli_fetch_assoc($stmt)) {
				$output .= '<div class="block clearfix">';
					if($row['image']) {
						$output .= '<img src="'.SITE_URL.'images/blog/'.$row['image'].'" alt="">';
					}
					$output .= '<div class="h3"><a href="'.$row['postSlug'].'">'.$row['postTitle'].'</a></div>';
					$output .= '<div class="blog-credits">Posted on <span class="date">'.date('jS M Y H:i:s', strtotime($row['postDate'])).'</span> in ';
						$stmt2 = mysqli_query($db,'SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = "'.$row['postID'].'"');
		
						$links = array();
						while($cat = mysqli_fetch_assoc($stmt2)) {
							$links[] = "<a href='".SITE_URL."category/".$cat['catSlug']."'>".$cat['catTitle']."</a>";
						}
						$output .= implode(", ", $links);
		
					$output .= '</div>';
					$output .= '<p>'.limit_words($row['postCont'],$blog_rm_words_limit).'</p>';
					$output .= '<p><a href="'.SITE_URL.$blog_url.'/'.$row['postSlug'].'">Read More</a></p>';
				$output .= '</div>';
			}
			$output .= $pages->page_links('c-'.$_GET['id'].'&');
		} catch(Exception $e) {
			$output .= $e->getMessage();
		}
		echo $output;
	}
}
