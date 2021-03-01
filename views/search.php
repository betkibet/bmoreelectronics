<?php
//Header section
include("include/header.php");

$search_by = isset($post['search'])?$post['search']:'';

//Fetching data from model
require_once('models/search/search.php');

//Get model data list from models/search/search.php, function get_model_data_list
$model_data_list = get_model_data_list($search_by);
$search_count = $model_data_list;
if(!empty($model_data_list) && $search_by) { ?>
	  <section id="showCategory">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
				<h3>Choose you model<span> to calculate the cost:</span></h3>
			  </div>
			  <div class="block devices clearfix">
				<div class="row category model-category pb-5 justify-content-center">					
				<?php
				$cat_ids_array = array();
				foreach($model_data_list as $model_list) {
				  $cat_ids_array[] = $model_list['cat_id'];
				  
				  $model_upto_price = 0;
				  $model_upto_price_data = get_model_upto_price($model_list['id'],$model_list['price']);
				  $model_upto_price = $model_upto_price_data['price']; ?>
				  <div class="col-6 col-md-6 col-lg-3 p-2">
					<a href="<?=SITE_URL.$model_details_page_slug.$model_list['sef_url']?>" class="card">
					  <div class="image">
						<?php
						if($model_list['model_img']) {
							$md_img_path = SITE_URL.'images/mobile/'.$model_list['model_img'];
							echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
						} ?>
					  </div>
					  <h5><?=$model_list['title']?></h5>
					  <?php
					  if($model_upto_price>0) {
					  	echo '<h6 class="price">Up to '.amount_fomat($model_upto_price).'</h6>';
					  } ?>
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
} else { ?>
	<section id="head-graphics">
		<img src="<?=SITE_URL?>images/apple_header_img.jpg" alt="" class="img-fluid">
		<div class="header-caption text-center search_section">
			<h2>Find Your <span>Model</span></h2>
			<p>Please Select Memory Size of your model to processed</p>
			<div class="device-h-search">
				<form action="<?=SITE_URL?>search" method="post">
					<input type="text" name="search" class="srch_list_of_model" placeholder="<?=$searchbox_placeholder?>" required><br/>
					<button type="submit" class="btn btn-primary btn-lg search_btn">Search</button>
				</form>
			</div>
		</div>
	</section>
	
	<?php
	if($search_by) { ?>
	  <section id="showCategory" class="pb-0 pt-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block text-center">
				<h3>Items not available</h3>
			  </div>
			</div>
		  </div>
		</div>
	  </section>
	<?php
	}
} ?>
