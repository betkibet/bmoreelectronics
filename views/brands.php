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

//Get data from admin/include/functions.php, get_brand_data function
$brand_data_list = get_brand_data();
$num_of_brand = count($brand_data_list);
if($num_of_brand>0) { ?>
  <section id="showCategory" class="pb-3">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block heading page-heading text-center">
            <h3>Сhoose a brand</h3>
          </div>
          <div class="block device-brands clearfix">
            <div class="brand-roll">
            <?php
            foreach($brand_data_list as $brand_data) { ?>
              <div class="brand">
              <a href="<?=SITE_URL.$brand_data['sef_url']?>">
              <?php
              if($brand_data['image']) {
                $md_img_path = SITE_URL.'images/brand/'.$brand_data['image'];
                echo '<img src="'.$md_img_path.'" alt="'.$brand_data['title'].'">';
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
} ?>