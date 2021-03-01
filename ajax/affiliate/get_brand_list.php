<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$cat_id = $post['cat_id'];
if($cat_id>0) {

	//Fetching data from brand
	require_once('../../models/device_cat_brands.php');
	
	//Get data from models/device_cat_brands.php, get_brand_data_list function
	$brand_data_list = get_brand_data_list($cat_id);

	if(!empty($brand_data_list)) {
		echo '<ul>';
		foreach($brand_data_list as $brand_data) { ?>
			<li>
				<div class="custom-control custom-radio">
					<input type="radio" class="brand_id custom-control-input" name="brand_id" id="brand_id_<?=$brand_data['brand_id']?>" value="<?=$brand_data['brand_id']?>">
					<label for="brand_id_<?=$brand_data['brand_id']?>" class="custom-control-label">
						<p>
							<?php
							if($brand_data['brand_image']) {
								$md_img_path = SITE_URL.'images/brand/'.$brand_data['brand_image'];
								echo '<img src="'.$md_img_path.'" alt="'.$brand_data['brand_title'].'">';
							} ?>
						</p>
						<?php /*?><h4><?=$brand_data['title']?></h4><?php */?>
					</label>
				</div>
			</li>								
		<?php
		}
		echo '</ul>';
	} else {
		echo '<strong>brands not exist for this device</strong>';
	}
} ?>