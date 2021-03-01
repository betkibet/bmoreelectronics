<?php
//Get review list
$review_list_data = get_review_list_data(1);
$total_num_of_rev = count($review_list_data);

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];
?>
<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<p>'.$image_text.'</p>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
} ?>

<?php
if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h3><?=$page_title?></h3>
				</div>
			</div>
		</div>
	</section>
<?php
} ?>
	
<section class="<?=$active_page_data['css_page_class']?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h3>Lets Read Testimonials From <br><span class="text-primary">Best Clients</span></h3>
				</div>
				<div class="block review-slide page only_review">
					<?php
					if ($total_num_of_rev > 0) {?>
						<div class="row">
						<?php
						$numOfCols = 3;
						$rowCount = 0;
						foreach ($review_list_data as $key => $review_data) {?>
							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="image">
												<?php
												if ($review_data['photo']) {?>
													<img width="82" src="<?=SITE_URL . 'images/review/' . $review_data['photo']?>" class="rounded-circle">
												<?php
												} else {?>
													<img width="82" src="images/placeholder_avatar.jpg" class="rounded-circle">
												<?php
												} ?> 
											</div>
											<div class="col-12">
													<div class="media">
														<div class="media-body">
															<h4><?=$review_data['name']?></h4>
														</div>
													</div>
											</div>
											<div class="col-md-12">
													<p><?=$review_data['content']?></p>
											</div>
										</div>
									</div>
									<!-- <div class="designation"><?=($review_data['country'] ? $review_data['country'] . ', ' : '') . $review_data['state'] . ', ' . $review_data['city']?></div> -->		
								</div>
							</div>
							<?php
							$rowCount++;
							if ($rowCount % $numOfCols == 0) {echo '</div><div class="row">';}
						} ?>
						</div>
					<?php
					} ?>
				</div>
				<div class="block text-center">
					<a href="<?=$review_form_link?>" class="btn btn-primary">Write A Review</a>
				</div>
			</div>
		</div>
	</div>
</section>