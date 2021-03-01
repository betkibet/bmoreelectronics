<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$mode = $post['mode'];
if($mode == "imei") {
	$imei_number = $post['imei_number'];
	echo 'IMEI number code here... Coming soon...';
} else {
	$device_id = $post['device_id'];
	if($device_id>0) {
		$query = mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.device_id='".$device_id."' ORDER BY m.ordering ASC");
		$no_of_models = mysqli_num_rows($query);
		if($no_of_models>0) {
			echo '<ul>';
			while($model_data=mysqli_fetch_assoc($query)) { ?>
				<li>
					<div class="custom-control custom-radio">
						<input type="radio" class="model_id custom-control-input" name="model_id" id="model_id_<?=$model_data['id']?>" value="<?=$model_data['id']?>">
						<label for="model_id_<?=$model_data['id']?>" class="custom-control-label">
							<p>
								<?php
								if($model_data['model_img']) {
									//$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=100';
									$md_img_path = SITE_URL.'images/mobile/'.$model_data['model_img'];
									echo '<img src="'.$md_img_path.'" alt="'.$model_data['title'].'">';
								} ?>
							</p>
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