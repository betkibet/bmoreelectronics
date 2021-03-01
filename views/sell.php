<?php
$meta_title = "Sell Devices";
$meta_desc = "Sell Devices";
$meta_keywords = "Sell Devices";

//Header section
include("include/header.php");

//Get data from admin/include/functions.php, get_category_data_list function
$category_data_list = get_category_data_list();
$num_of_category = count($category_data_list);
if($num_of_category>0) { ?>
	<section id="showCategory" class="pb-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
				<h3 class="pb-3">Choose you device's category <span>to calculate the cost:</span></h3>
				<form action="<?=SITE_URL?>search" method="post">
				  <div class="form-group">
					<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=$searchbox_placeholder?>">
				  </div>
				</form>
			  </div>
			  <div class="block devices clearfix"> 
				<div class="row category pb-5 center-content">
				  <?php
				  foreach($category_data_list as $category_data) { ?>
				  <div class="col-6 col-md-4 col-lg-3 col-sm-4 p-2">
					<a href="<?=SITE_URL.$category_data['sef_url']?>" class="card">
					  <div class="image">
						<?php
						if($category_data['icon_type']=="fa" && $category_data['fa_icon']!="") {
							echo '<i class="fa '.$category_data['fa_icon'].'"></i>';
						} elseif($category_data['icon_type']=="custom" && $category_data['image']!="") {
							$ct_img_path = SITE_URL.'images/categories/'.$category_data['image'];
							$ct_h_img_path = SITE_URL.'images/categories/'.$category_data['hover_image'];
							echo '<img src="'.$ct_img_path.'" alt="'.$category_data['title'].'">';
							echo '<img src="'.$ct_h_img_path.'" alt="'.$category_data['title'].'">';
						} ?>
					  </div>
					  <h5><?=$category_data['title']?></h5>
					</a>
				  </div>
				<?php
				} ?>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	</section>
<?php
}

//Get data from admin/include/functions.php, get_device_data_list function
$device_data = get_device_data_list();
$num_of_device = count($device_data);
if($num_of_device>0) { ?>
<section class="pt-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
				<h3 class="pb-3">Choose you device<span> to calculate the cost:</span></h3>
				<form action="<?=SITE_URL?>search" method="post">
				  <div class="form-group">
					<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="Search for your device here...">
				  </div>
				</form>
			  </div>
			  <div class="block devices choose_model_all">
				<div class="row center-content">
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>sell-iphone" class="card">
					  <div class="card-body">
						<div class="row">
						  <!-- <div class="col-6 p-0">
							
						  </div> -->
						  <div class="col-12 text-center">
						  	<h5>Apple iPhone</h5>
							<img src="<?=SITE_URL?>images/device/iPhoneX.png">
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>ipad" class="card">
					  <div class="card-body">
						<div class="row">
						  <div class="col-12 text-center">
							<h5>iPad</h5>
							<img width="75%" src="<?=SITE_URL?>images/device/iPad.png">
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>apple-watch" class="card third">
					  <div class="card-body">
						<div class="row">
						  <div class="col-12 text-center">
							<h5>Apple Whatch</h5>
							<img width="65%" src="<?=SITE_URL?>images/device/iWhatch.png">
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>homepod" class="card fourth">
					  <div class="card-body">
						<div class="row">
						  <div class="col-12 text-center">
							<h5>HomePod</h5>
							<img width="65%" src="<?=SITE_URL?>images/device/home_pod.png">
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>airpods" class="card">
					  <div class="card-body">
						<div class="row">
						  <div class="col-12 text-center">
							<h5>AirPods</h5>
							<img width="65%" src="<?=SITE_URL?>images/device/airpods.png">
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>sell-macbook-retina" class="card first">
					  <div class="card-body">
						<div class="row">
						  <!-- <div class="col-5 p-0 align-self-center">
							
						  </div> -->
						  <div class="col-12 text-center">
						  	<h5>MacBook</h5>
							<img width="100%" src="<?=SITE_URL?>images/device/macbook.png">
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	</section>
<?php
} ?>