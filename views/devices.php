<?php
//Header section
include("include/header.php");

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
} else {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/apple_header_img.jpg" alt="Header Image">';
	$main_img_text = '<p>Please Select Memory Size of your model to processed</p>';
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
					<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=$searchbox_placeholder?>">
				  </div>
				</form>
			  </div>
			  <div class="block devices choose_model_all">
				<div class="row center-content">
				  <div class="col-6 col-lg-3 col-md-4 col-sm-6 col-xs-6 p-2">
					<a href="<?=SITE_URL?>apple-iphone" class="card first">
					  <div class="card-body">
						<div class="row">
						  <!-- <div class="col-6 p-0">
							
						  </div> -->
						  <div class="col-12 p-0 text-center">
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
					<a href="<?=SITE_URL?>macbook-device" class="card first">
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
		
	<!-- Select Your Device -->
	<?php /*?><section id="select-device" class="sectionbox">
		<div class="wrap">
			<div class="sec-title"><h3>Select Your <strong>Device</strong></h3></div>
			<div class="content-block">
				<div class="list clearfix">
					<ul class="clearfix">
						<?php
						foreach($device_data as $device_data) { ?>
							<li>
								<a href="<?=$device_data['sef_url']?>">
									<div class="imgbox">
									<?php
									if($device_data['device_img']) {
										$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=138'; ?>
										<img src="<?=$device_img_path?>" alt="<?=$model_list['title']?>">
									<?php
									} ?>
									</div>
									<div class="btnbox"><?=$device_data['title']?></div>
								</a>
							</li>
						<?php
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</section><?php */?>
<?php
}
/*if($active_page_data['content']) {
	echo $active_page_data['content'];
}*/ ?>