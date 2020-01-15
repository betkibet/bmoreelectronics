<?php
//Header section
include("include/header.php");

$search_by = $post['search'];

//Fetching data from model
require_once('models/search/search.php');

//Get model data list from models/search/search.php, function get_model_data_list
$model_data_list = get_model_data_list($search_by);
$search_count = $model_data_list;
if(!empty($model_data_list) && $search_by) {
?>
	<div id="breadcrumb">
		<div class="wrap">
			<ul>
				<li><a href="<?=SITE_URL?>">Home</a></li>
				<li class="active"><a href="#">Search</a></li>
			</ul>
		</div>
	</div>

	<section id="select-device" class="sectionbox white-bg">
		<div class="wrap">
			<div class="sec-title"><h3>Select <strong>Your Model</strong></h3></div>
			<div class="content-block">
				<div class="list clearfix">
					<ul class="clearfix">
						<?php
						foreach($model_data_list as $model_list) { ?>
							<li>
								<div class="imgbox">
								<?php
								if($model_list['model_img']) {
									$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_list['model_img'].'&h=138';
									echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
								} ?>
								</div>
								<div class="btnbox"><a href="<?=SITE_URL.$model_list['sef_url'].'/'.createSlug($model_list['title']).'/'.$model_list['id']?>" class="btn"><?=$model_list['title']?></a></div>
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
	
	<?php
	if(isset($_POST['search'])) { ?>
	<section id="select-device" class="sectionbox white-bg">
		<div class="wrap">
			<div><h3>No matching handsets/devices found.</h3></div>
		</div>
	</section>
	<?php
	}
} ?>
