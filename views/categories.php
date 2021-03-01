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

//Fetching data from model
require_once('models/model.php');

//Get data from admin/include/functions.php, get_category_data_list function
$category_data_list = get_category_data_list();
$num_of_category = count($category_data_list);
if($num_of_category>0) { ?>
	<section id="showCategory" class="pb-3">
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
				<div class="row category pb-5">
				  <?php
				  foreach($category_data_list as $category_data) { ?>
				  <div class="col-6 col-md-6 col-lg-3 p-2">
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
} ?>