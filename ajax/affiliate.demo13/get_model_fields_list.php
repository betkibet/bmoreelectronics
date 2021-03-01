<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../../include/custom_js.php");
require_once("../common.php");


$model_id = $post['model_id'];

if($model_id>0) {

//Fetching data from model

require_once('../../models/model.php');



//Get data from models/model.php, get_single_model_data function

$model_data = get_single_model_data($model_id);



$edit_item_id = $_GET['item_id'];

$order_item_data = array();

if($edit_item_id>0) {

	$order_item_data = get_order_item($edit_item_id,'');

	$order_item_data = $order_item_data['data'];

}



$item_name_array = json_decode($order_item_data['item_name'],true);

if(!empty($item_name_array)) {

	foreach($item_name_array as $ei_k => $item_name_data) {

		$fld_id_array[] = $ei_k;

		$items_opt_name = "";

		foreach($item_name_data['opt_data'] as $opt_data) {

			if($opt_data['opt_id']>0) {

				$items_opt_name .= $opt_data['opt_name'].', ';

				$opt_id_array[] = $opt_data['opt_id'];

			} else {

				$items_opt_name .= $opt_data['opt_name'].', ';

			}

		}

		$opt_name_array[$ei_k] .= rtrim($items_opt_name,', ');		

	}

}



$image_name_array = json_decode($order_item_data['images'],true);

if(!empty($image_name_array)) {

	foreach($image_name_array as $eim_k => $image_name_data) {

		$fld_id_array[] = $eim_k;

		$opt_name_array[$eim_k] = $image_name_data['img_name'];

	}

}



$pro_fld_o_q = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$model_id."' AND input_type NOT IN('text','textarea','datepicker','file') ORDER BY sort_order");

$exist_others_pro_fld = mysqli_num_rows($pro_fld_o_q);



/*$pro_fld_c_q = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$model_id."' AND is_condition_field = '1' AND input_type NOT IN('text','textarea','datepicker','file') ORDER BY sort_order");

$exist_con_pro_fld = mysqli_num_rows($pro_fld_c_q);*/



$model_upto_price = 0;

$model_upto_price_data = get_model_upto_price($model_id,$model_data['price']);

$model_upto_price = $model_upto_price_data['price'];

?>



  <section id="model_details" class="pb-0">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

          <div class="block phone-details position-relative clearfix pb-0">

            <div class="card">

				<?php 

				if($model_upto_price>0) {

				echo '<h6 class="btn btn-primary upto-price-button rounded-pill">Up to '.amount_fomat($model_upto_price).'</h6>';

				}?>

              <div class="row">

                <div class="col-md-12">

				    <?php

				    $sql_cus_fld = "SELECT * FROM product_fields WHERE product_id = '".$model_id."' ORDER BY sort_order";

					$exe_cus_fld = mysqli_query($db,$sql_cus_fld);

					$fid=1;

	

					while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {

	

						if(($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {

							continue;

						} ?>

						

					    <div id="section<?=$fid?>" data-required="<?=$row_cus_fld['is_required']?>">

							<div class="h4">

								<?=$row_cus_fld['title']?><?php

								if($row_cus_fld['tooltip']!="" && $tooltips_of_model_fields == '1') {

									$tooltips_data_array[] = array('tooltip'=>$row_cus_fld['tooltip'], 'id'=>'p'.$row_cus_fld['id'], 'name'=>$row_cus_fld['title']); ?>

									<span class="tips" data-toggle="modal" data-target="#info_popup<?='p'.$row_cus_fld['id']?>"><i class="ml-1 fas fa-question-circle"></i></span></span>

								<?php

								} ?>:

							</div>

							<div class="storage-options">

								<?php

								if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio") {

									$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."'";

									$exe_cus_opt = mysqli_query($db,$sql_cus_opt);

									$no_of_dd_options = mysqli_num_rows($exe_cus_opt);

									$temp_fld_no = 1;

									if($no_of_dd_options>0) {

										while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {

											$checked = '';

											$sel_class = "";

											$tab_sel_class = "false";

											$tab_sel__content_class = "";

											

											if(in_array($row_cus_opt['id'],$opt_id_array)) {

												$checked = 'checked';

											} elseif($temp_fld_no == $fid) {

												if($row_cus_opt['is_default']==1) {

													$checked = 'checked';

												}

											}  ?>

											<div class="custom-control custom-radio custom-control-inline">

												<input type="radio" id="<?=$row_cus_opt['id']?>" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>" value="<?=$row_cus_opt['label'].':'.$row_cus_opt['id']?>" <?=$checked?> class="custom-control-input" data-default="<?=$row_cus_opt['is_default']?>">

												<label class="custom-control-label" for="<?=$row_cus_opt['id']?>">

												<?php

												if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {

													echo '<img src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" id="'.$row_cus_opt['id'].'" />';

												} else {

													echo '<span>'.$row_cus_opt['label'].'</span>';

												} ?>

												</label>

											</div>

										<?php

										}

									}

								}

								elseif($row_cus_fld['input_type']=="checkbox") {

									$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$row_cus_fld['id']."'";

									$exe_cus_opt = mysqli_query($db,$sql_cus_opt);

									$no_of_dd_options = mysqli_num_rows($exe_cus_opt);

									$temp_fld_no = 1;

									if($no_of_dd_options>0) {

										while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {

											$checked = '';

											$chk_lab = $row_cus_opt['label'];

											$chk_id = $row_cus_opt['id'];

	

											if(in_array($row_cus_opt['id'],$opt_id_array)) {

												$checked = 'checked';

											} elseif($temp_fld_no == $fid) {

												if($row_cus_opt['is_default']==1) {

													$checked = 'checked';

												}

											}  ?>

											<div class="custom-control custom-radio custom-control-inline">

												<input type="checkbox" name="<?=$row_cus_fld['title'].':'.$row_cus_fld['id']?>[]" id="<?=$row_cus_opt['id']?>" <?=$checked?> value="<?=$chk_lab.':'.$chk_id?>" class="custom-control-input" data-default="<?=$row_cus_opt['is_default']?>">

												<label class="custom-control-label" for="<?=$row_cus_opt['id']?>">

												<?php

												if($row_cus_opt['icon']!="" && $icons_of_model_fields == '1') {

													echo '<img src="'.SITE_URL.'images/'.$row_cus_opt['icon'].'" width="50px" id="'.$row_cus_opt['id'].'" />';

												} else {

													echo '<span>'.$chk_lab.'</span>';

												} ?>

												</label>

											</div>

										<?php

										}

									}

								} ?>

							</div>

							<span class="validation-msg"></span>

					    </div>

				   	<?php

					} ?>

                </div>

              </div>

            </div>

          </div>

		  

		  <div class="block condition-tab clearfix condition-section position-relative mobile-shadow-none">	

			<div class="row">

				<div class="col-md-12 col-lg-12 show-price text-center">

					<h4 class="price-total show_final_amt">$0<span>.00</span></h4>

					<h4 class="price-total apr-spining-icon" style="display:none;"></h4>

					<p><button type="button" class="btn btn-lg btn-primary get_paid_fields">Get Paid</button></p>

				</div>

			</div>

		  </div>

          

        </div>

      </div>

    </div>

  </section>



	<span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>

	

	<input type="hidden" name="sell_this_device" value="yes">

	<input type="hidden" name="quantity" id="quantity" value="1"/>

	<input type="hidden" name="payment_amt" id="payment_amt" value=""/>

	<input id="total_price_org" value="<?=$price?>" type="hidden" />

<?php

}



foreach($tooltips_data_array as $tooltips_data) { ?>

	<div class="modal fade common_popup" id="info_popup<?=$tooltips_data['id']?>" role="dialog">

		<div class="modal-dialog small_dialog">

			<!-- Modal content-->

			<div class="modal-content">

				<button type="button" class="close" data-dismiss="modal"><img src="<?=SITE_URL?>images/payment/close.png" alt=""></button>

				<div class="modal-body">

					<h3 class="title"><?=$tooltips_data['name']?></h3>

					<?=$tooltips_data['tooltip']?>

				</div>

			</div>

		</div>

	</div>

<?php

} ?>



<script>

var tpj=jQuery;



<?php /*?>function checkdata() {

	tpj("#payment_amt").val(tpj(".show_final_amt_val").html());



	var is_return = true;

	tpj('.custom-control-input').each(function(index) {

		var is_required = tpj(this).parent().parent().parent().attr("data-required");

		var is_checked = tpj(this).parent().parent().find("input:checked").length;

		if(is_required=="1") {

			if(is_checked == 0) {

				is_return = false;

				tpj(this).parent().parent().next().html("Please choose an option");

				return false;

			}

		}

	});

	

	if(is_return == false) {

		return false;

	} else {

		return true;

	}

}<?php */?>



function get_price(mode) {

	tpj.ajax({

		type: 'POST',

		url: '<?=SITE_URL?>ajax/get_model_price.php',

		data: tpj('#apr_form').serialize(),

		success: function(data) {

			if(data!="") {

				var resp_data = JSON.parse(data);



				var total_price = resp_data.payment_amt;

				var total_price_html = resp_data.payment_amt_html;



				tpj(".show_final_amt").show();

				tpj(".show_final_amt").html(total_price_html);

				tpj(".show_final_amt_val").html(total_price);

				

				tpj(".apr-spining-icon").hide();

				tpj(".apr-spining-icon").html('');

			}

		}

	});

}



tpj(document).ready(function($) {

	$('.phone-details .custom-control-input, .nav-link, .nav-link-mbl').bind('click keyup', function(event) {

		$(".apr-spining-icon").html('<div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div>');

		$(".apr-spining-icon").show();

		$(".show_final_amt").hide();



		var is_required = $(this).parent().parent().parent().attr("data-required");

		var is_checked = $(this).parent().parent().find("input:checked").length;

		if(is_required=="1") {

			if(is_checked > 0) {

				$(this).parent().parent().next().html("");

			}

		}



		setTimeout(function() {

			get_price('click');

		}, 500);

	});

	

	$('.get_paid_fields').bind('click', function(event) {

		$("#collapse_three_pos").show();

		$("#collapseThree").collapse('show');



		$("#collapse_three_pos").show();

		setTimeout(function() {

			$.scrollTo($('#collapse_three_pos'), 500);

		}, 500);

		

	});

});



get_price('load');

</script>

