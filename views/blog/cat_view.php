<?php
//Url param
$cat_url = trim($url_second_param);

//Header section
include("include/header.php");

//Get data from model
include("models/blog/blog.php"); ?>

<section class="blog clearfix">
  <div class="container">
    <div class="row display-md-inline-flex">
      <div class="col-md-9 float-none">
        <div class="contain">
          <?php
      		//Get blog list data based on respective cat
      		get_blog_list_based_on_cat($cat_url, $blog_rm_words_limit,$page_list_limit); 
      		?>
        </div>
      </div>
      <?php
	  if($blog_recent_posts == '1' || $blog_categories == '1') { ?>
      <div class="col-md-3 float-none">
        <div class="right-sidebar clearfix">
          <?php
		  //Get recent posts
		  get_recent_posts($blog_recent_posts);
		  
		  //Get Catgories
		  get_blog_categories($blog_categories); 
		  ?>
        </div>
      </div>
	  <?php
	  } ?>
    </div>
  </div>
</section>