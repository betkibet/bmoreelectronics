<?php

//For home slider
$home_slider_data = get_home_page_data('','slider');
if(count($home_slider_data)>0) {
	$home_slider_data['sub_title'] = str_replace("<p><br></p>","",$home_slider_data['sub_title']);
	$home_slider_data['intro_text'] = str_replace("<p><br></p>","",$home_slider_data['intro_text']);
	$home_slider_data['description'] = str_replace("<p><br></p>","",$home_slider_data['description']);
	$section_color=($home_slider_data['section_color']!=""?$home_slider_data['section_color'].'-bg':'');
	
	$section_bg_imagevideo_path = '';
	$section_bg_image = '';
	$section_bg_video = '';
	$section_image = $home_slider_data['section_image'];
	$section_image_ext = pathinfo($section_image,PATHINFO_EXTENSION);
	
	if($section_image) {
		$section_bg_imagevideo_path = SITE_URL."/images/section/".$section_image;
		if($section_image && $section_image_ext=="png" || $section_image_ext=="jpg" || $section_image_ext=="jpeg" || $section_image_ext=="gif") {
			$section_bg_image = "style=\"background:url('$section_bg_imagevideo_path') no-repeat 0 0;background-size: cover;\"";
		} elseif($section_image) {
			$section_bg_video = '<video class="background-video" autoplay="" loop=""  muted="" playsinline="" data-wf-ignore="true"><source src="'.$section_bg_imagevideo_path.'" data-wf-ignore="true"></video>';
		}
	}
	
	$items_data_array = json_decode($home_slider_data['items'],true);
	if(!empty($items_data_array)) {
		array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array); ?>
		<section id="showcase" class="<?=$section_color?>" <?=$section_bg_image?>>
			<?=$section_bg_video?>
			<div class="gradient-overlay"></div>
			<div class="container-fluid">
			  <div class="row">
				<div class="col-md-6 col-lg-5 col-xl-5">
				  <div class="block showcase-text">
					<h1><?=$items_data_array[0]['item_title']?></h1>
					<p><?=$items_data_array[0]['item_sub_title']?></p>
					<div class="list-inline">
					  <a href="<?=$items_data_array[0]['button_url']?>" class="btn btn-lg mr-3 my-2 rounded-pill  button_fill_light">Get Started</a>
					  <a href="#how-it-works" class="btn btn-lg rounded-pill btn-outline-light">How it Work?</a>
					</div>
				  </div>
				</div>
				<div class="col-md-6 col-lg-6 col-xl-6">
				  <div class="block showcase-image">
					<?php
					if($items_data_array[0]['item_image']!="") { ?>
					<img class="animated slideInRight" src="<?='images/section/'.$items_data_array[0]['item_image']?>" alt="<?=$items_data_array[0]['item_title']?>">
					<?php
					} ?>
				  </div>
				</div>
			  </div>
			</div>
		</section>
	<?php
	}
}

$home_page_settings_list = get_home_page_data();
foreach($home_page_settings_list as $home_page_settings_data) {
	$home_page_settings_data['sub_title'] = str_replace("<p><br></p>","",$home_page_settings_data['sub_title']);
	$home_page_settings_data['intro_text'] = str_replace("<p><br></p>","",$home_page_settings_data['intro_text']);
	$home_page_settings_data['description'] = str_replace("<p><br></p>","",$home_page_settings_data['description']);
	$section_color=($home_page_settings_data['section_color']!=""?$home_page_settings_data['section_color'].'-bg':'');
	
	$section_bg_imagevideo_path = '';
	$section_bg_image = '';
	$section_bg_video = '';
	$section_image = $home_page_settings_data['section_image'];
	$section_image_ext = pathinfo($section_image,PATHINFO_EXTENSION);
	
	if($section_image) {
		$section_bg_imagevideo_path = SITE_URL."/images/section/".$section_image;
		if($section_image && $section_image_ext=="png" || $section_image_ext=="jpg" || $section_image_ext=="jpeg" || $section_image_ext=="gif") {
			$section_bg_image = "style=\"background:url('$section_bg_imagevideo_path') no-repeat 0 0;background-size: cover;\"";
		} elseif($section_image) {
			$section_bg_video = '<video class="review_background-video" autoplay="" loop=""  muted="" playsinline="" data-wf-ignore="true"><source src="'.$section_bg_imagevideo_path.'" data-wf-ignore="true"></video>';
		}
	}

	if($home_page_settings_data['section_name'] == "how_it_works") {
		$items_data_array = json_decode($home_page_settings_data['items'],true);
		if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
		  <section id="easy-step_section" class="<?=$section_color?>" <?=$section_bg_image?>>
		    <?=$section_bg_video?>
		 	<a name="how-it-works"></a>
			<div class="container-fluid">
			  <div class="row">
				<div class="col-md-12">
				  <div class="block heading text-center clearfix">
					<h3>It's easy as 1. 2. 3</h3>
				  </div>
				  <div class="block easy-steps clearfix">
				    <div class="card-group">
						<?php
						array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
						foreach($items_data_array as $ik=>$items_data) {
							$item_fa_item = "";
							$item_icon_type = $items_data['item_icon_type'];
							if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
								$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
							} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
								$item_fa_item = '<img src="images/section/'.$items_data['item_image'].'" class="img-fluid" alt="">';
							} ?>
							
							 <div class="card border-0">
								<div class="card-body">
								  <?php
								  if($item_fa_item) {
								  	echo '<div class="image '.($ik==0?'laptop':'').'">'.$item_fa_item.'</div>';
								  }
								  if($items_data['item_title']) {
									echo '<h5 class="card-title">'.$items_data['item_title'].'</h5>';
								  }
								  if($items_data['item_description']) {
									echo '<p>'.$items_data['item_description'].'</p>';
								  } ?>
								</div>
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
	}
	elseif($home_page_settings_data['section_name'] == "top_devices") {
		//Get data from admin/include/functions.php, get_popular_device_data function
		$device_data_list = get_popular_device_data();
		$num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
			<section id="device-category-sec" class="<?=$section_color?>" <?=$section_bg_image?>>
			    <?=$section_bg_video?>
				<div class="wrap">
					<?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h2>'.lastwordstrongorspan($home_page_settings_data['title'],'strong').'</h2>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
					
					<div class="block block-category">
						<ul>
							<?php
							foreach($device_data_list as $device_data) { ?>
								<li>
									<a href="<?=$device_data['sef_url']?>">
										<div class="image">
											<?php
											if($device_data['device_icon']) {
												$device_icon_path = SITE_URL.'images/device/'.$device_data['device_icon']; ?>
												<img src="<?=$device_icon_path?>" alt="<?=$device_data['title']?>">
											<?php
											} ?>
										</div>
										<span><?=$device_data['title']?></span>
									</a>
								</li>
							<?php
							} ?>
						</ul>
					</div>
				</div>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "categories") {
	  //Get data from admin/include/functions.php, get_category_data_list function
	  $category_data_list = get_category_data_list();
	  $num_of_category = count($category_data_list);
	  if($num_of_category>0) { ?>
		<section id="showCategory" class="pb-0 <?=$section_color?>" <?=$section_bg_image?>>
		    <?=$section_bg_video?>
			<a name="category-section"></a> 
			<div class="container-fluid">
			  <div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-4">
				  <div class="block heading text-center">
					<h3>Choose you device's category <span>to calculate the cost:</span></h3>
					<form action="<?=SITE_URL?>search" method="post">
					  <div class="form-group">
						<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="Search for your device here...">
					  </div>
					</form>
				  </div>
				  <div class="block devices clearfix">
					<div class="row category pb-5 center-content">
					  <?php
					  foreach($category_data_list as $category_data) { ?>
					  <div class="col-6 col-md-3 col-lg-3 col-sm-4 p-2">
						<a href="<?=$category_data['sef_url']?>" class="card">
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
	}
	elseif($home_page_settings_data['section_name'] == "devices") {
	    //Get data from admin/include/functions.php, get_popular_device_data function
		$device_data_list = get_popular_device_data();
		$num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
			<section class="pt-0">
			    <?=$section_bg_video?>
				<a name="device-section"></a>
				<div class="container-fluid">
				  <div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					  <div class="block heading text-center">
						<h3>Choose you device<span> to calculate the cost:</span></h3>
						<form action="<?=SITE_URL?>search" method="post">
						  <div class="form-group">
							<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="Search for your device here...">
						  </div>
						</form>
					  </div>
					  <div class="block devices choose_model_all">
						<div class="row center-content">
						  <div class="col-6 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2"> 
								<!-- first -->
								<a href="<?=SITE_URL?>sell-iphone" class="card">
							  <div class="card-body">
								<div class="row">
								 <!--  <div class="col-6 p-0 d-flex align-items-center">
									
								  </div> -->
								  <div class="col-12 text-center">
								  	<h5>Apple iPhone</h5>
									<img src="images/device/iPhoneX.png">
								  </div>
								</div>
							  </div>
							</a>
						  </div>
						  <div class="col-6 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2">
							<a href="<?=SITE_URL?>ipad" class="card">
							  <div class="card-body">
								<div class="row">
								  <div class="col-12 text-center">
									<h5>iPad</h5>
									<img width="75%" src="images/device/iPad.png">
								  </div>
								</div>
							  </div>
							</a>
						  </div>
						  <div class="col-6 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2">
							<a href="<?=SITE_URL?>apple-watch" class="card third">
							  <div class="card-body">
								<div class="row">
								  <div class="col-12 text-center">
									<h5>Apple Whatch</h5>
									<img width="65%" src="images/device/iWhatch.png">
								  </div>
								</div>
							  </div>
							</a>
						  </div>
						  <div class="col-6 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2">
							<a href="<?=SITE_URL?>homepod" class="card fourth">
							  <div class="card-body">
								<div class="row">
								  <div class="col-12 text-center">
									<h5>HomePod</h5>
									<img width="65%" src="images/device/home_pod.png">
								  </div>
								</div>
							  </div>
							</a>
						  </div>
						  <div class="col-6 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2">
							<a href="<?=SITE_URL?>airpods" class="card">
							  <div class="card-body">
								<div class="row">
								  <div class="col-12 text-center">
									<h5>AirPods</h5>
									<img width="65%" src="images/device/airpods.png">
								  </div>
								</div>
							  </div>
							</a>
						  </div>
						  <div class="col-6 col-lg-3 col-md-3 col-sm-4 col-xs-6 p-2">
							<a href="<?=SITE_URL?>sell-macbook-retina" class="card">
							  <div class="card-body">
								<div class="row">
								 <!--  <div class="col-5 p-0 d-flex align-items-center">
									
								  </div> -->
								  <div class="col-12 text-center">
								  	<h5 >MacBook</h5>
									<img width="100%" src="images/device/macbook.png">
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
			
			<?php /*?><section id="deviceSection" class="pt-0">
				<a name="device-section"></a>
				<div class="container-fluid">
				  <div class="row align-items-center">
						<div class="col-md-4">
							<div class="block calculate-cost clearfix">
								<img src="<?=SITE_URL?>images/white-logo-symbol.png" alt="">
								<h3>Choose you device's to <span>calculate the cost</span></h3>
								<form class="form-inline" action="<?=SITE_URL?>search" method="post">
									<div class="form-group">
										<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=$searchbox_placeholder?>">
										<!-- <button type="button" class="btn btn-clear" id="ftr_signup_btn"><i class="fas fa-arrow-right"></i></button> -->
									</div>
								</form>
							</div>
						</div>
						<div class="col-md-8">
							<div id="deviceSlider" class="device-slider">
								<?php
								foreach($device_data_list as $device_data) { ?>
									<div class="device">
										<a href="<?=$device_data['sef_url']?>">
											<?php
											if($device_data['device_img']) {
												$device_img_path = SITE_URL.'images/device/'.$device_data['device_img']; ?>
												<img src="<?=$device_img_path?>" class="img-fluid" alt="<?=$device_data['title']?>">
											<?php
											} ?>
										</a>
										<h5><?=$device_data['title']?></h5>
									</div>
								<?php
								} ?>
							</div>
						</div>
				  </div>
				</div>
			</section><?php */?>
	  <?php
	  }
	}
	elseif($home_page_settings_data['section_name'] == "models") {
		//Get data from admin/include/functions.php, get_top_seller_data_list function
		$top_seller_data_list = get_top_seller_data_list($top_seller_limit);
		$num_of_top_seller = count($top_seller_data_list);
		if($top_seller_limit>0 && $num_of_top_seller>0) { ?>
			<section id="findmodal" class="sectionbox <?=$section_color?>" <?=$section_bg_image?>>
			     <?=$section_bg_video?>
				<div class="wrap">
					<?php
					if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
						echo '<h2>'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h2>';
					}
					if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
						echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
					}
					if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
						echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
					}
					if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
						echo $home_page_settings_data['description'];
					} ?>
					<div class="content-block">
						<ul id="findmodal_slider" class="list owl-carousel">
							<?php
							foreach($top_seller_data_list as $top_seller_data) { ?>
							<li>
								<div class="roundbox">
									<a href="<?=$top_seller_data['sef_url'].'/'.createSlug($top_seller_data['model_title']).'/'.$top_seller_data['id'].'/'.$ts_storage->storage_size?>" class="linkn">&nbsp;</a>
									<div class="imgbox">
										<?php
										if($top_seller_data['model_img']) {
											$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$top_seller_data['model_img'].'&h=202'; ?>
											<img src="<?=$md_img_path?>" class="img-fluid" alt="">
										<?php
										} ?>
									</div>
									<div class="text-f-left">
										<div class="title"><?=$top_seller_data['brand_title']?></div>
										<div class="reset"><?=$top_seller_data['title']?></div>
										<div class="btn-group">
											<!--<a href="#" class="btn-s-white">16 GB</a>
											<a href="#" class="btn-s-white">32 GB</a>
											<a href="#" class="btn-s-white">16 GB</a>
											<a href="#" class="btn-s-white">32 GB</a>-->
										</div>
									</div>
								</div>
							</li>
							<?php
							} ?>
						</ul>
					</div>
				</div>
			</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "brands") {
		//Get data from admin/include/functions.php, get_brand_data function
		$brand_data_list = get_brand_data();
		$num_of_brand = count($brand_data_list);
		if($num_of_brand>0) { ?>
		<section id="select_brand" class="<?=$section_color?>" <?=$section_bg_image?>>
		    <?=$section_bg_video?>
			<div class="container">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="block heading text-center">
						<?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3 class="pb-3">'.$home_page_settings_data['title'].'</h3>';
							// echo '<h3 class="pb-3">'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['sub_title'].'</div>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<p class="intro-text">'.$home_page_settings_data['intro_text'].'</p>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
					</div>
					<div class="block brands-slider clearfix home_brand_section">
					<div class="block device-brands clearfix">
						<div class="brand-roll">
							<?php
							foreach($brand_data_list as $brand_data) {
								//echo '<li><a href="'.SITE_URL.'device-brand/'.$brand_data['id'].'"><img src="images/brand/'.$brand_data['image'].'" class="img-fluid" alt=""></a></li>';
								echo '<div class="brand"><a href="'.SITE_URL.$brand_data['sef_url'].'"><img src="images/brand/'.$brand_data['image'].'" class="img-fluid" alt=""></a></div>';
							} ?>
						</div> 
					</div>
				</div>
				</div>
			</div>
		</section>
		<?php
		} //END for brand section
	}
	elseif($home_page_settings_data['section_name'] == "why_choose_us") {
		$items_data_array = json_decode($home_page_settings_data['items'],true);
		if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
		  <section id="whyChoose" class="<?=$section_color?>" <?=$section_bg_image?>>
		    <?=$section_bg_video?>
		    <a name="why-us"></a>
			<div class="container">
			  <div class="row">
				<div class="col-md-12">
				  <div class="block heading text-center clearfix">
					<h3>Why choose us?</h3>
				  </div>
				  <div class="block why-choose">
					<div class="card-group">
						<?php
						array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
						foreach($items_data_array as $items_data) {
							$item_fa_item = "";
							$item_icon_type = $items_data['item_icon_type'];
							if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
								$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
							} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
								$item_fa_item = '<img src="images/section/'.$items_data['item_image'].'" class="img-fluid" alt="">';
							} ?>
							
							 <div class="card">
								<div class="card-body">
								  <?php
								  if($item_fa_item) {
								  	echo $item_fa_item;
								  }
								  if($items_data['item_title']) {
									echo '<h5 class="card-title">'.$items_data['item_title'].'</h5>';
								  }
								  if($items_data['item_description']) {
									echo '<p>'.$items_data['item_description'].'</p>';
								  } ?>
								</div>
							  </div>
						<?php
						} ?>
					</div>
				  </div>
				  <div class="block text-center clearfix">
					<a href="<?=SITE_URL?>#category-section" class="btn btn-primary btn-lg mr-3 my-2 rounded-pill">Get Started</a>
				  </div>
				</div>
			  </div>
			</div>
		  </section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "get_a_quote") { ?>
		<section id="getquote" class="sectionbox gray-bg <?=$section_color?>" <?=$section_bg_image?>>
		    <?=$section_bg_video?>
			<div class="wrap">
				<a name="request_quote"></a>
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
					echo '<h2>'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h2>';
				}
				if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
					echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
				}
				if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
					echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
				}
				if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
					echo $home_page_settings_data['description'];
				} ?>
				<form action="controllers/home.php" method="post">
				<div class="content-block">
					<div class="quote_box">
						<div class="input_bg">
							<label>MAKE</label>
							<select class="quote_select" name="quote_make" id="quote_make" onchange="getQuoteDevice(this.value);">
								<option>Please Choose</option>
								<?php
								$quote_mk_list = autocomplete_data_search()['quote_mk_list'];
								foreach($quote_mk_list as $quote_mk_key=>$quote_mk_data) {
									echo '<option value="'.$quote_mk_key.'">'.$quote_mk_data.'</option>';
								} ?>
							</select>
						</div>

						<div class="input_bg">
							<label>Device</label>
							<select class="quote_select" name="quote_device" id="quote_device" onchange="getQuoteModel(this.value);">
								<option>Please Choose</option>
							</select>
						</div>
						
						<div class="input_bg">
							<label>Model</label>
							<select class="quote_select" name="quote_model" id="quote_model">
								<option>Please Choose</option>
							</select>
						</div>
						
						<div class="btnbox">
							<button type="submit" name="submit_quote">How Much?</button>
						</div>

					</div>
				</div>
				</form>
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "newsletter") {
		if($newslettter_section == '1') { ?>
		  <section class="<?=$section_color?>" <?=$section_bg_image?>>
		     <?=$section_bg_video?>
			<div class="container-fluid">
			  <div class="row justify-content-center">
				<div class="col-md-10 col-lg-8 col-xl-6">
				  <div class="block heading">
						
						<?php
						if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
							echo '<h3 class="feature-title">'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h3>';
						}
						if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
							echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
						}
						if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
							echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
						}
						if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
							echo $home_page_settings_data['description'];
						} ?>
						<form action="<?=SITE_URL?>controllers/newsletter.php" method="post" id="newsletter_form" class="form-inline">
							<div class="form-group">
							<input type="email" name="ftr_signup_email" id="ftr_signup_email" placeholder="yourmail@mail.com" class="form-control text-left border-bottom border-top-0 border-right-0 border-left-0 center">
							<button type="button" class="btn btn-primary btn-lg my-2 rounded-pill" id="clk_ftr_signup_btn">Send</button>
							</div>
							<?php
							$newsletter_csrf_token = generateFormToken('newsletter'); ?>
							<input type="hidden" name="csrf_token" value="<?=$newsletter_csrf_token?>">
						</form>
						</div> 
				</div>
			  </div>
			</div>
		  </section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "reviews") {
		//Get review list
		$review_list_data = get_review_list_data(1,8);
		if(!empty($review_list_data)) { ?>
			<section id="review" class="<?=$section_color?>" <?=$section_bg_image?>>
				<?=$section_bg_video?>
				<div class="gradient-overlay"></div>
				<div class="container-fluid">
				  <div class="row">
					<div class="col-md-12">
					  <div class="block heading dark text-center">
						<h3>Reviews</h3>
					  </div>
					  <div class="block review-slide">
						<div class="row slider-nav">
							<?php
							$rev_read_more_arr = array();
							foreach($review_list_data as $key => $review_data) { ?>
							  <div class="col-md-12">
								<div class="card">
								  <div class="card-body">
									<div class="row">
									  <div class="col-12">
										<div class="media">
											<?php
											if($review_data['photo']) {
												echo '<img src="'.SITE_URL.'images/review/'.$review_data['photo'].'" class="rounded-circle" width="82">';
											} else {
												echo '<img src="'.SITE_URL.'images/placeholder_avatar.jpg" class="rounded-circle" width="82">';
											} ?>
										  <div class="media-body ml-3">
											<h4><?=$review_data['name']?></h4>
											<?php
											/*if($review_data['source']) { ?>
											<p class="text-secondary">from <?=$review_data['source']?></p>
											<?php
											}*/ ?>
										  </div>
										</div>
									  </div>
									  <div class="col-12">
										<?php
										$rev_content = '';
										$rev_con_words = str_word_count($review_data['content']);
										$rev_content = limit_words($review_data['content'],20);
										if($rev_con_words>20) {
											$rev_content .= ' <a href="javascript;" data-toggle="modal" data-target="#reviewModal'.$review_data['id'].'">Read More</a>';
											$rev_read_more_arr[] = array('id'=>$review_data['id'],'name'=>$review_data['name'],'content'=>$review_data['content']);
										} ?>
										<p><?=$rev_content?></p>
									  </div>
									</div>
								  </div>
								</div>
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
			if(count($rev_read_more_arr)>0) {
				foreach($rev_read_more_arr as $rev_read_more_data) { ?>
					<div class="modal fade" id="reviewModal<?=$rev_read_more_data['id']?>" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel<?=$rev_read_more_data['id']?>" aria-hidden="true">
						<div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
							  <h5 class="modal-title" id="reviewModalLabel<?=$rev_read_more_data['id']?>"><?=$rev_read_more_data['name']?></h5>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							  </button>
							</div>
							<div class="modal-body pt-0">
							  <p><?=$rev_read_more_data['content']?></p>
							</div>
						  </div>
						</div>
					</div> 
				<?php
				}
			}
		}
	} else { ?>
		<section class="about_custom_block_section <?=$section_color?>" <?=$section_bg_image?>>
			<?=$section_bg_video?>
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
					echo '<div class="block heading text-center"><h3>'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h3></div>';
				}
				if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
					echo '<div class="block intro-text text-center">'.$home_page_settings_data['sub_title'].'</div>';
				}
				if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
					echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
				}
				if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
					echo $home_page_settings_data['description'];
				} ?>
		</section>
	<?php
	}
} ?>