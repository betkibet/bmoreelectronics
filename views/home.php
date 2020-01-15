<?php
//For home slider
$home_slider_data = get_home_page_data('','slider');
if(count($home_slider_data)>0) { ?>
	<!-- head-graphics -->
	<section id="head-graphics" class="mt-70"> 
		<div class="header-caption">
			<?php
			if($home_slider_data['title'] && $home_slider_data['show_title'] == '1') { 
				echo '<h2>'.$home_slider_data['title'].'</h2>';
			}
			if($home_slider_data['sub_title'] && $home_slider_data['show_sub_title'] == '1') { 
				echo '<h3>'.$home_slider_data['sub_title'].'</h3>';
			}
			if($home_slider_data['intro_text'] && $home_slider_data['show_intro_text'] == '1') { 
				echo '<h4>'.$home_slider_data['intro_text'].'</h4>';
			} ?>
		
			<div class="device-h-search">
				<form action="<?=SITE_URL?>search" method="post">
					<input type="text" name="search" class="srch_list_of_model" placeholder="Search by device or model name...">
					<button type="submit"><i class="ico-search">Search</i></button>
				</form>
			</div>
			<!-- <div class="scroller" id="scroller1"><a href="#scroller1"><img src="images/ico-scroll.png" alt=""></a></div> -->
		</div>
		<?php
		if($home_slider_data['description'] && $home_slider_data['show_description'] == '1') { 
			echo $home_slider_data['description'];
		} ?>
	</section>
<?php
} ?>

<!-- Main -->
<div id="main"> 
<?php
$home_page_settings_list = get_home_page_data();
foreach($home_page_settings_list as $home_page_settings_data) {
	$section_color=($home_page_settings_data['section_color']!=""?$home_page_settings_data['section_color'].'-bg':'');
	$section_bg_image = '';
	$section_bg_style_image = '';
	if($home_page_settings_data['section_image']) {
		$section_bg_image = "images/section/".$home_page_settings_data['section_image'];
		$section_bg_style_image = "style=\"background:url('$section_bg_image') no-repeat 0 0;\"";
	}

	if($home_page_settings_data['section_name'] == "how_it_works") { ?>
		<section id="howitwork" class="sectionbox <?=$section_color?>" <?=$section_bg_style_image?>>
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
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "devices") {
		//Get data from admin/include/functions.php, get_device_data_list function
		$device_data_list = get_popular_device_data();
		$num_of_device = count($device_data_list);
		if($num_of_device>0) { ?>
		<section id="choose-device" class="sectionbox dark-bg">
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
				<div class="device-h-search">
					<form action="<?=SITE_URL?>search" method="post">
						<input type="text" name="search" class="srch_list_of_model" placeholder="Search by device or model name...">
						<button type="submit"><i class="ico-search">Search</i></button>
					</form>
				</div>
				
				<div class="content-block">
					<ul id="device_slider" class="list owl-carousel">
						<?php
						foreach($device_data_list as $device_data) {
							$dn = $dn +1; ?>
							<li>
								<div class="roundbox">
									<a href="<?=$device_data['sef_url']?>" class="linkn"><?=$device_data['title']?></a>
									<div class="imgbox">
									<?php
									if($device_data['device_img']) {
										$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/device/'.$device_data['device_img'].'&h=104'; ?>
										<img src="<?=$device_img_path?>" class="img-fluid" alt="<?=$device_data['title']?>">
									<?php
									} ?>
									</div>
									<div class="title"><?=$device_data['title']?></div>
								</div>
							</li>
							<?php
							/*if($dn % 2 == 0) {
								echo '</li><li>';
							}*/
						} ?>
					</ul>
				</div>
			</div>
		</section>
		<?php
		}
	}
	elseif($home_page_settings_data['section_name'] == "models") { ?>
		<section id="findmodal" class="sectionbox <?=$section_color?>" <?=$section_bg_style_image?>>
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
				}
				
				//Get data from admin/include/functions.php, get_top_seller_data_list function
				$top_seller_data_list = get_top_seller_data_list($top_seller_limit);
				$num_of_top_seller = count($top_seller_data_list);
				if($top_seller_limit>0 && $num_of_top_seller>0) { ?>
					<div class="content-block">
						<ul id="findmodal_slider" class="list owl-carousel">
							<?php
							$ts_i=1;
							foreach($top_seller_data_list as $top_seller_data) { ?>
							<li>
								<div class="roundbox">
									<a href="<?=$top_seller_data['sef_url'].'/'.createSlug($top_seller_data['model_title']).'/'.$top_seller_data['id'].'/'.$ts_storage->storage_size?>" class="linkn">&nbsp;</a>
									<div class="imgbox">
										<?php
										if($top_seller_data['model_img']) {
											$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/mobile/'.$top_seller_data['model_img'].'&h=202'; ?>
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
							$ts_i = $ts_i+1;
							} ?>
						</ul>
					</div>
				<?php
				} ?>
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "brands") { ?>
		<?php
		//Get data from admin/include/functions.php, get_brand_data function
		$brand_data_list = get_brand_data();
		$num_of_brand = count($brand_data_list);
		if($num_of_brand>0) { ?>
		<section id="selectbrand" class="sectionbox <?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="wrap">
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
					echo '<h2>'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h2>';
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
				<div class="content-block">
					<ul id="selectbrand_slider" class="list clearfix">
						<?php
						foreach($brand_data_list as $brand_data) {
							//echo '<li><a href="'.SITE_URL.'device-brand/'.$brand_data['id'].'"><img src="images/brand/'.$brand_data['image'].'" class="img-fluid" alt=""></a></li>';
							echo '<li><a href="'.SITE_URL.'brand/'.$brand_data['sef_url'].'"><img src="images/brand/'.$brand_data['image'].'" class="img-fluid" alt=""></a></li>';
						} ?>
					</ul>
				</div>
			</div>
		</section>
		<?php
		} //END for brand section ?>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "why_choose_us") { ?>
		<section id="whychooseus" class="sectionbox <?=$section_color?>" <?=$section_bg_style_image?>>
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
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "categories") { ?>
		<section id="browsecategory" class="sectionbox <?=$section_color?>" <?=$section_bg_style_image?>>
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
				}
				//Get data from admin/include/functions.php, get_category_data_list function
				$category_data_list = get_category_data_list();
				$num_of_category = count($category_data_list);
				if($num_of_category>0) { ?>
					<div class="content-block">
						<ul id="browsecategory_slider" class="list owl-carousel">
							<?php
							$ci = 1;
							foreach($category_data_list as $category_data) { ?>
							<li>
								<a href="device-category/<?=$category_data['id']?>" class="linkn">&nbsp;</a>
								<div class="imgbox">
									<?=($category_data['fa_icon']!=""?'<i class="fa '.$category_data['fa_icon'].'"></i>':'')?>
								</div>
								<div class="title"><?=$category_data['title']?></div>
							</li>
							<?php $ci++;
							} ?>
						</ul>
					</div>
				<?php
				} ?>
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "sell_your_iphone") { ?>
		<section id="sellbrand" class="sectionbox blue-bg <?=$section_color?>" <?=$section_bg_style_image?>>
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
				}
				
				//Get data from admin/include/functions.php, get_top_seller_data_list function
				$top_seller_data_list = get_top_seller_data_list($top_seller_limit);
				$num_of_top_seller = count($top_seller_data_list);
				if($top_seller_limit>0 && $num_of_top_seller>0) { ?>
					<div class="content-block">
						<ul id="sellbrand_slider" class="list owl-carousel">
							<?php
							$ts_i=1;
							foreach($top_seller_data_list as $top_seller_data) { ?>
							<li>
								<div class="roundbox">
									<a href="<?=$top_seller_data['sef_url'].'/'.createSlug($top_seller_data['model_title']).'/'.$top_seller_data['id'].'/'.$ts_storage->storage_size?>" class="linkn">&nbsp;</a>
									<div class="imgbox">
										<?php
										if($top_seller_data['model_img']) {
											$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/mobile/'.$top_seller_data['model_img'].'&h=202'; ?>
											<img src="<?=$md_img_path?>" class="img-fluid" alt="">
										<?php
										} ?>
									</div>
									<div class="title"><?=$top_seller_data['title']?></div>
									<div class="price-text">Cash in up to $8.31</div>
								</div>
							</li>
							<?php
							$ts_i = $ts_i+1;
							} ?>
						</ul>
					</div>
				<?php
				} ?>
			</div>
		</section>
	<?php
	}
	elseif($home_page_settings_data['section_name'] == "get_a_quote") { ?>
		<section id="getquote" class="sectionbox gray-bg <?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="wrap">
				<a name="request_quote"></a>
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
					echo '<h2 style="color: #ffffff;">'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h2>';
				}
				if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
					echo '<div class="intro-text" style="color: #ffffff;">'.$home_page_settings_data['sub_title'].'</div>';
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
	elseif($home_page_settings_data['section_name'] == "reviews") { ?>
		<!--START for review section-->
		<?php
		//Get review list
		$review_list_data = get_review_list_data(1,8);
		if(!empty($review_list_data)) { ?>
		<section id="latestreview" class="sectionbox white-bg <?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="wrap">
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
					echo '<div class="title"><h2>'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h2><a href="'.$reviews_link.'" class="seeall_link">See All</a></div>';
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
					<div id="review_slider" class="owl-carousel owl-theme">
						<?php
						foreach($review_list_data as $key => $review_data) { ?>
							<div class="item">
								<div class="testimonial_box">
									<p><?=$review_data['content']?></p>
									<div class="authorbox">
									<?php
									if($review_data['photo']) {
										echo '<img src="'.SITE_URL.'images/review/'.$review_data['photo'].'" class="author_img">';
									} else {
										echo '<img src="'.SITE_URL.'images/placeholder_avatar.jpg" class="author_img">';
									} ?>
									<div class="name"><?=$review_data['name']?></div>
									<div class="designation"><?=($review_data['country']?$review_data['country'].', ':'').$review_data['state'].', '.$review_data['city']?></div>
									</div>
								</div>
							</div>
						<?php
						} ?>
					</div>
				</div>
			</div>
		</section>
		<?php
		} ?>
		<!--END for review section-->
	<?php
	} else { ?>
		<!--Select Brand-->
		<section id="selectbrand" class="sectionbox <?=$section_color?>" <?=$section_bg_style_image?>>
			<div class="wrap">
				<?php
				if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') { 
					echo '<div class="title"><h2>'.lastwordstrongorspan($home_page_settings_data['title'],'span').'</h2></div>';
				}
				if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { 
					echo '<div class="intro-text">'.$home_page_settings_data['sub_title'].'</div>';
				}
				if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
					echo '<div class="subtitlebox">'.$home_page_settings_data['intro_text'].'</div>';
				}
				if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
					echo '<div class="content-block text-left">'.$home_page_settings_data['description'].'</div>';
				} ?>
			</div>
		</section>
	<?php
	}
} ?>
</div><!-- /.main -->
  
<script>
function getQuoteDevice(val)
{
	var brand_id = val.trim();
	if(brand_id) {
		post_data = "brand_id="+brand_id+"&token=<?=uniqid()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_device.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						console.log(data);
						$('#quote_device').html(data);
						$('.add-quote-device').selectpicker('refresh');

						$('#quote_model').html('<option value="">Please Choose</option>');
						$('.add-quote-model').selectpicker('refresh');
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}

function getQuoteModel(val)
{
	var brand_id = $("#quote_make").val().trim();
	var device_id = val.trim();
	if(brand_id && device_id) {
		post_data = "device_id="+device_id+"&brand_id="+brand_id+"&token=<?=uniqid()?>";
		jQuery(document).ready(function($){
			$.ajax({
				type: "POST",
				url:"ajax/get_quote_model.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						console.log(data);
						$('#quote_model').html(data);
						$('.add-quote-model').selectpicker('refresh');
					} else {
						alert('Something wrong so please try again...');
						return false;
					}
				}
			});
		});
	}
}
</script>