<?php
//Header section
include("include/header.php");

if($active_page_data['image']) {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'">';
	$main_img_text = '<p>'.$active_page_data['image_text'].'</p>';
} else {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/apple_header_img.jpg" alt="Header Image">';
	$main_img_text = '<p>Please Select Memory Size of your model to processed</p>';
} ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Select Your Device</a></li>
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
if($active_page_data['image'] != "") {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'">'; ?>
	<!-- head-graphics -->
	<section id="head-graphics">
		<?php
		echo $main_img;
		if($active_page_data['title'] || $active_page_data['image_text']) { ?>
		<div class="header-caption">
			<h2><?=lastwordstrongorspan($active_page_data['title'],'span')?></h2>
			<p><?=$active_page_data['image_text']?></p>
		</div>
		<?php
		} ?>
	</section>
<?php
} ?>

<!-- Main -->
<div id="main">
	<?php
	//Get data from admin/include/functions.php, get_device_data function
	$device_data = get_device_data_list();
	$num_of_device = count($device_data);
	if($num_of_device>0) { ?>
		<!-- Select Your Device -->
		<section id="select-device" class="sectionbox white-bg">
			<div class="wrap">
				<div class="sec-title"><h3>Select Your <strong>Device</strong></h3></div>
				<div class="content-block">
					<div class="list clearfix">
						<ul class="clearfix">
							<?php
							$di = 1;
							foreach($device_data as $device_data) { ?>
								<li><a href="<?=$device_data['sef_url']?>">
									<div class="imgbox">
									<?php
									if($device_data['device_img']) {
										$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/device/'.$device_data['device_img'].'&h=138'; ?>
										<img src="<?=$device_img_path?>" alt="<?=$model_list['title']?>">
									<?php
									} ?>
									</div>
									<div class="btnbox"><?=$device_data['title']?></div>
									</a>
								</li>
							<?php
							$di++;
							} ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
	<?php
	}
	if($active_page_data['content']) {
		echo $active_page_data['content'];
	} ?>
</div><!-- /.main -->