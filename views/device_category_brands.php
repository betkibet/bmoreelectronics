<?php
$category_data = get_category_data($category_id);

$meta_title = $category_data['title'];
$meta_desc = '';
$meta_keywords = '';

$main_title = $category_data['title'];
$sub_title = $category_data['sub_title'];
$short_description = $category_data['short_description'];
$description = $category_data['description'];
$main_img = '';
if($category_data['image']) {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$main_title.'">';
}

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/device_cat_brands.php'); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Select Your Brand</a></li>
		</ul>
	</div>
</div>

<!-- head-graphics -->
<section id="head-graphics">
	<img src="<?=SITE_URL?>images/apple_header_img.jpg" alt="" class="img-fluid">
	<div class="header-caption">
		<h2>Find Your <span>Model</span></h2>
		<p>Please Select Memory Size of your model to processed</p>
		<div class="device-h-search">
			<form action="<?=SITE_URL?>search" method="post">
				<input type="text" name="search" class="srch_list_of_model" placeholder="Search by device or model name..." required>
				<button type="submit"><i class="ico-search">Search</i></button>
			</form>
		</div>
	</div>
</section>

<div id="main">
<?php
//Get data from models/device_cat_brands.php, get_brand_data_list function
$brand_data_list = get_brand_data_list($category_id);
$brand_num_of_rows = count($brand_data_list);
if($brand_num_of_rows == '1') {
	$brand_cat_url = SITE_URL.'device-brand/'.$brand_data_list['0']['brand_id'].'/'.$category_id;
	setRedirect($brand_cat_url,'');
	exit();
}
if($brand_num_of_rows>0) { ?>
	<section id="select-device" class="sectionbox white-bg">
		<div class="wrap">
			<div class="sec-title"><h3>Select <strong>Your Brand</strong></h3></div>
			<div class="content-block">
				<div class="list clearfix">
					<ul class="clearfix">
						<?php
						foreach($brand_data_list as $brand_list) { ?>
							<li>
								<a href="<?=SITE_URL.'device-brand/'.$brand_list['brand_id'].'/'.$category_id?>">
								<div class="imgbox">
								<?php
								if($brand_list['model_img']) {
									$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/brand/'.$brand_list['brand_image'].'&h=138';
									echo '<img src="'.$md_img_path.'" alt="'.$brand_list['brand_title'].'">';
								} ?>
								</div>
								<div class="btnbox">
									<?=$brand_list['brand_title']?>
								</div>
								</a>
							</li>
						<?php
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</section>
<?php
} else { ?>
	<section id="select-device" class="sectionbox white-bg">
		<div class="wrap">
			<div><h3>Items not available</h3></div>
		</div>
	</section>
<?php
}

if($description!="") { ?>
	<section class="sectionbox white-bg">
		<div class="wrap">
		<?php
		if($sub_title!="" || $short_description!="") { ?>
		<div class="row">
		  <div class="col-md-12">
			<div class="block clearfix">
			  <div class="head pb-3 text-center clearfix">
				<?php
				if($sub_title!="") { ?>
				<div class="sec-title"><h3><strong><?=$sub_title?></strong></h3></div>
				<?php
				}
				if($short_description!="") { ?>
				<div class="h3"><?=$short_description?></div>
				<?php
				} ?>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		}
		echo $description; ?>
		</div>
	</section>
<?php
} ?>	
</div>