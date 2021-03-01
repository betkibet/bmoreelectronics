<?php
$category_data = get_category_data($category_id);

$meta_title = $category_data['meta_title'];
$meta_desc = $category_data['meta_desc'];
$meta_keywords = $category_data['meta_keywords'];

$main_title = $category_data['title'];
$sub_title = $category_data['sub_title'];
$short_description = $category_data['short_description'];
$description = $category_data['description'];
$main_img = '';
if($category_data['image']) {
	$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/categories/'.$category_data['image'].'" alt="'.$main_title.'">';
}

//Header section
include("include/header.php");

//Fetching data from model 
require_once('models/device_cat_brands.php'); 

//Get data from models/device_cat_brands.php, get_brand_data_list function
$brand_data_list = get_brand_data_list($category_id);
$brand_num_of_rows = count($brand_data_list);
if($brand_num_of_rows == '1') {
	$brand_cat_url = SITE_URL.$category_data['sef_url'].'/'.$brand_data_list['0']['brand_sef_url'].'/'.$category_id;
	//setRedirect($brand_cat_url,'');
	//exit();
}
if($brand_num_of_rows>0) { ?>
  <section id="showCategory" class="pb-0 ">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
          <div class="block heading page-heading text-center">
		    <?php
			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) { ?>
		  	<a class="btn btn-primary rounded-pill back-button" href="javascript:void(0);" onclick="history.back();">Back</a>
			<?php
			} ?>
            <h1>Сhoose a brand</h1>  
          </div>
          <div class="block device-brands clearfix">
            <div class="brand-roll d-flex justify-content-center">
			    <?php
				foreach($brand_data_list as $brand_data) { ?>
				  <div class="brand">
					<a href="<?=SITE_URL.$category_data['sef_url'].'/'.$brand_data['brand_sef_url']?>">
					<?php
					if($brand_data['brand_image']) {
						$md_img_path = SITE_URL.'images/brand/'.$brand_data['brand_image'];
						echo '<img src="'.$md_img_path.'" alt="'.$brand_data['brand_title'].'">';
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

if($description!="") { ?>
	<section class="sectionbox white-bg">
		<div class="container">
		<div class="wrap">
		<?php
		if($sub_title!="" || $short_description!="") { ?>
		<div class="row">
		  <div class="col-md-12">
			<div class="block clearfix">
			  <div class="head pb-3 text-center clearfix"> 
				<?php
				if($sub_title!="") { ?>
				<div class="sec-title"><h1 class="title"><strong><?=$sub_title?></strong></h1></div>
				<?php
				}
				if($short_description!="") { ?>
				<div class="h3"><?=$short_description?></div>
				<?php
				} ?>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		}
		echo $description; ?>
		</div>
	</div>
	</section>
<?php
} ?>	
</div>