<?php
//Get data from model
include("models/blog/blog.php"); ?>

<section class="blog clearfix">
  <div class="container">
    <div class="row display-md-inline-flex">
      <div class="col-md-9 float-none">
      	<div class="contain">
		  	<h1 class="h2 nomargintop"><strong><?=$active_page_data['title']?></strong></h1>
			<?php
			//Get blog list data
			get_blog_list($page_list_limit, $blog_rm_words_limit, $page_url); 
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