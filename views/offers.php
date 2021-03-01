<?php
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

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<div class="head text-center clearfix">
						<h3>You’ve just hit the<span class="text-primary">Discount Jackpot.</span></h3>
						<p>PROMOCODES & COUPONS</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


  
<section class="offer-section">
	<div class="container">
		<div class="row justify-content-center">
			<?php
			$promocode_list = get_promocode_list('future');
			if(count($promocode_list) > 0) {
				foreach($promocode_list as $promocode_data) { ?>
					<div class="col-md-3">
						
							<div class="card">
								<div class="card-body">
									<?php
									if($promocode_data['image']!="") {
										echo '<img src="'.SITE_URL.'images/promocodes/'.$promocode_data['image'].'" alt=""/>';
									} ?>
									<p class="discount mb-0">
									<?php
									if($promocode_data['discount_type']=="flat") {
										echo amount_fomat($promocode_data['discount']).' OFF';
									} elseif($promocode_data['discount_type']=="percentage") {
										echo $promocode_data['discount'].'% OFF';
									} ?></p>
									<p class="mb-0"><?=$promocode_data['description']?></p>
									<p class="date mb-0"><strong>
									<?php
									if($promocode_data['never_expire'] == '1') {
										echo 'Never Expire';
									} else {
										echo date("m/d/Y",strtotime($promocode_data['to_date']));
									} ?></strong></p>
									<h4 class="mb-0 pt-3"><code><?=$promocode_data['promocode']?></code></h4>
									<?php
									if($promocode_data['multiple_act_by_same_cust']=='1' && $promocode_data['multi_act_by_same_cust_qty']>0) {
										echo '<p class="pt-4 text-right mb-0"><small>*Limited per customer</small></p>';
									} ?>
								</div>
							</div>
						
					</div>
				<?php 
				}
			} else { ?>
				<div class="col-md-12">
					<div class="block">
						<h3>No offer found</h3>
					</div>
				</div>
			<?php
			} ?>
		</div>
	</div>
</section>
<section id="best-deals-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block text-center clearfix">
					<img src="images/gift_box.png" alt="">
					<h1>Looking for the best deals?</h1>
					<h3>You’re in the right place.</h3>
					<a href="#" class="btn btn-primary btn-lg pl-5 pr-5">CHOOSE YOUR DEVICE TYPE OR BRAND</a>
				</div>
			</div>
		</div>
	</div>
</section>
