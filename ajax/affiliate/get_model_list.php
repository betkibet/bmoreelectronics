<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$mode = $post['mode'];
if($mode == "imei") {
	$imei_number = $post['imei_number'];
	echo 'IMEI number code here... Coming soon...';
} else {
	$cat_id = $post['cat_id'];
	$brand_id = $post['brand_id'];
	$device_id = 0;
	if($cat_id>0) {
		//Fetching data from model
		require_once('../../models/search/brand.php');

		$model_type_source = '';
		$c_b_d_extra_param_arr['model_type_source'] = $model_type_source;
		$model_data_list = get_c_b_d_model_data_list($brand_id, $cat_id, $device_id, $c_b_d_extra_param_arr);
		if(!empty($model_data_list)) {
			echo '<ul>';
			foreach($model_data_list as $model_data) { ?>
				<li>
					<div class="custom-control custom-radio">
						<input type="radio" class="model_id custom-control-input" name="model_id" id="model_id_<?=$model_data['id']?>" value="<?=$model_data['id']?>">
						<label class="custom-control-label" for="model_id_<?=$model_data['id']?>">
							<?php
							if($model_data['model_img']) {
								$md_img_path = SITE_URL.'images/mobile/'.$model_data['model_img'];
								echo '<p><img src="'.$md_img_path.'" alt="'.$model_data['title'].'"></p>';
							} ?>
							<h4><?=$model_data['title']?></h4>
						</label>
					</div>
					
				</li>								
			<?php
			}
			echo '</ul>';
		} else {
			echo '<strong>Models not exist for this device</strong>';
		}
	}
} ?>