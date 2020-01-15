<?php
$category_data = get_category_data($category_id);
$cat_id = $category_id;

$meta_title = $category_data['title'];
$meta_desc = '';
$meta_keywords = '';

$main_title = $category_data['title'];
$main_sub_title = '';
$description = $category_data['description'];
$main_img = '';
if($category_data['image']) {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$main_title.'">';
}

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/mobile.php'); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$main_title?></a></li>
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
//Get data from models/mobile.php, get_model_data_list function
$model_data_list = get_model_data_list($device_id, $devices_id, $cat_id);
$model_num_of_rows = count($model_data_list);
if($model_num_of_rows>0) { ?>
	<section id="select-device" class="sectionbox white-bg">
		<div class="wrap">
			<div class="sec-title"><h3>Select <strong>Your Model</strong></h3></div>
			<div class="content-block">
				<div class="list clearfix">
					<ul class="clearfix">
						<?php
						foreach($model_data_list as $model_list) { ?>
							<li>
								<a href="<?=SITE_URL.$model_list['device_sef_url'].'/'.createSlug($model_list['title']).'/'.$model_list['id']?>">
								<div class="imgbox">
								<?php
								if($model_list['model_img']) {
									$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/mobile/'.$model_list['model_img'].'&h=138';
									echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
								} ?>
								</div>
								<div class="btnbox"><?=$model_list['title']?></div>
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
if($description) {
	//echo $description;
} ?>
</div>