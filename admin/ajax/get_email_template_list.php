<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

$status = $post['status'];
if($status != "") {
	$order_status_dt = get_order_status_data('order_status','',$status)['data'];
	$item_status_slug = $order_status_dt['slug'];
		
	$template_type_val = "order_".str_replace('-','_',$item_status_slug)."_status";
	$query=mysqli_query($db,"SELECT * FROM mail_templates WHERE status='1' AND type='".$template_type_val."' AND is_fixed='0'");
	$mail_tmpl_num=mysqli_num_rows($query);
	if($mail_tmpl_num>0) { ?>
	<div class="form-group m-form__group">
		<label for="email_template">Email Template: </label>
		<select class="form-control" name="email_template" id="email_template" onchange="ChangeEmailTemplate(this.value)">
		<?php
		echo '<option value="">Choose Email Template</option>';
		while($mail_tmpl_list=mysqli_fetch_assoc($query)) {
			echo '<option value="'.$mail_tmpl_list['id'].'">'.$mail_tmpl_list['subject'].'</option>';
		} ?>
		</select>
	</div>
	<?php
	}
} ?>