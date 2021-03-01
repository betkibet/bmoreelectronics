<?php
//Get data from model
include("models/blog/blog.php"); ?>
<div class="all_blog_detail_section">
	<section class="main_blog_detail">
		<div class="container">
			<div class="block heading page-heading blog_head text-center">
		        <div class="block heading page-heading">
		        	<?php
					if ($active_page_data['show_title'] == '1') {
							echo '<div class="block heading page-heading"><h1><strong>' . $active_page_data['title'] . '</strong></h1></div>';
					} ?>

		        </div>
			</div>    
		</div>
	</section> 
	<section class="blog clearfix <?=$active_page_data['css_page_class']?>">
	  	<div class="container-fluid">
	    	<div class="row">
	      		<div class="col-md-9">
					
					<?php
					//Get blog list data
					get_blog_list($page_list_limit, $blog_rm_words_limit, $page_url);?>
											</div>
										<?php
					if ($blog_recent_posts == '1' || $blog_categories == '1') {?>
						<div class="col-md-3 right-sidebar">
						
								<?php
					//Get recent posts
							get_recent_posts($blog_recent_posts);

							//Get Catgories
							get_blog_categories($blog_categories);
							?>
							
						</div>
					<?php
					}?>
	    		</div>
	    	</div>
	  	</div>
	</section>
</div>