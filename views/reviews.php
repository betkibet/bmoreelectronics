<?php
//Get review list
$review_list_data = get_review_list_data(1);
$total_num_of_rev = count($review_list_data); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$active_page_data['menu_name']?></a></li>
		</ul>
	</div>
</div>

<div id="main" class="testimonials_page">
	<?php
	//Header Image
	if($active_page_data['image'] != "") { ?>
		<section id="head-graphics">
			<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" class="img-fluid" alt="<?=$active_page_data['title']?>">
			<div class="header-caption caption_contact">
				<h2><?=$active_page_data['title']?></h2>
				<?php
				if($active_page_data['image_text'] != "") {
					echo '<p>'.$active_page_data['image_text'].'</p>';
				} ?>
			</div>
		</section>
	<?php
	} ?>
		
	<section id="" class="sectionbox white-bg">
	  <div class="wrap">
		 <div class="page_title"><h2>Lets Read Testimonials From <br><span class="text-blue">Best Clients</span></h2></div>
		 <div class="content-block">
		  <?php
		  if($total_num_of_rev > 0) { ?>
			  <div class="row">
				<?php
				$numOfCols = 3;
				$rowCount = 0;
				foreach($review_list_data as $key => $review_data) { ?>
					<div class="col-md-4">
						<div class="testimonial_box">
							<p><?=$review_data['content']?></p>
							<div class="authorbox">
								<?php
								if($review_data['photo']) { ?>
									<img src="<?=SITE_URL.'images/review/'.$review_data['photo']?>" class="author_img">
								<?php
								} else { ?>
									<img src="images/placeholder_avatar.jpg" class="author_img">
								<?php
								} ?>
								<div class="name"><?=$review_data['name']?></div>
								<div class="designation"><?=($review_data['country']?$review_data['country'].', ':'').$review_data['state'].', '.$review_data['city']?></div>
							</div>
						</div>
					</div>
				<?php
				$rowCount++;
				if($rowCount % $numOfCols == 0){echo '</div><div class="row">';}
				} ?>
			  </div>
			<?php
			} ?>
		 </div>
	  </div>
	</section>
</div>