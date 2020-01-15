<?php
//Header section
include("include/header.php");

if($active_page_data['image']) {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'">';
	$main_img_text = '<p>'.$active_page_data['image_text'].'</p>';
} else {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/apple_header_img.jpg" alt="Header Image">';
	$main_img_text = '<p>Please Select Memory Size of your model to processed</p>';
}

//Fetching data from model
require_once('models/mobile.php'); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Select Your Category</a></li>
		</ul>
	</div>
</div>

<!-- head-graphics -->
<section id="head-graphics">
	<?=$main_img?>
	<div class="header-caption">
		<h2>Find Your <span>Model</span></h2>
		<?=$main_img_text?>
		<div class="device-h-search">
			<form action="<?=SITE_URL?>search" method="post">
				<input type="text" name="search" class="srch_list_of_model" placeholder="Search by device or model name..." required>
				<button type="submit"><i class="ico-search">Search</i></button>
			</form>
		</div>
	</div>
</section>

<?php
//Get data from admin/include/functions.php, get_category_data_list function
$category_data_list = get_category_data_list();
$num_of_category = count($category_data_list);
if($num_of_category>0) { ?>
	<section class="sectionbox white-bg">
		<div class="wrap">
			<div class="sec-title"><h3>Select <strong>Your Category</strong></h3></div>
			<div class="content-block">
				<div class="model-btn-group">
					<ul>
					<?php
					foreach($category_data_list as $category_data) { ?>
						<li><a href="device-category/<?=$category_data['id']?>"><?=$category_data['title']?></a></li>
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
} ?>