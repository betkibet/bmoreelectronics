<?php
$csrf_token = generateFormToken('model_details');
$ad_name = SITE_NAME;
?>

<!-- <section class="nav-top-space bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb px-0 mx-0 my-0 py-2 clearfix">
					<ul class="breadcrumb text-big m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['title']?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
 -->
<?php
$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics" id="head-graphics" <?php if($header_image != ""){echo '/style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="header-caption block heading page-heading text-center">
			<?php
			if($show_title == '1') {
				echo '<h3>'.$page_title.'</h3>';
			}
			if($image_text) {
				echo '<p>'.$image_text.'</p>';
			} ?>
		</div>
	</section>
<?php
$is_show_title = false;
} ?>

<section class="bg-gray pb-5 pt-0">
	<!-- <div class="container" id="sell_my_device_container" style='overflow: auto;'> -->
	<div class="container" id="sell_my_device_container">

		<div class="row">
		
		<!--New Code-->
		<div class="col-md-12">
			<form action="<?=SITE_URL?>controllers/model.php" method="post" id="sell_my_device_form" enctype="multipart/form-data">
			
				<div class="wrapAnswersBeta clearfix">
				
					<div id="first_welcome" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<!-- <p>Lalit</p> -->
								<div class="clearfix">
									<div class="question assistant float-left d-flex">
										<div class="image text-center">
											<img src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">
											<p><small><?=$ad_name?></small></p>
										</div>
										
										<div class="loading" id="spinner" style="display:none"></div>
										<div class="msg_div" id="msg_div" style="display:none">
											<span>I'm <?=$ad_name?>. I am happy to help you with the sale</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div class="clearfix" id="second_welcome" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<!-- <p><?=$ad_name?></p> -->
								<div class="clearfix">
									<div class="question assistant float-left d-flex">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">
											<p><small><?=$ad_name?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span>Which device type do you have?</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="device_category_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<?php /*?><p class="text-right">I</p><?php */?>
								<div class="clearfix">
									<div class="question client d-flex float-right">
										<div id="msg_div" style="display:block">
											<div class="mobileScrollY">
												<ul class="clearfix">
													<?php
													$device_category_list=get_category_data_list();
													$num_of_device_category_list = count($device_category_list);
													if($num_of_device_category_list>0) {
														foreach($device_category_list as $device_category_data) { ?>
															<li class="device_cate_type custom-control custom-radio custom-control-inline" id="device_cate_type">
																<input type="radio" class="device_category_id custom-control-input" name="device_category_id" id="device_category_id_<?=$device_category_data['id']?>" value="<?=$device_category_data['id']?>" data-value="<?=$device_category_data['title']?>">
																<label class="custom-control-label" for="device_category_id_<?=$device_category_data['id']?>" value="<?=$device_category_data['id']?>">
																	<div class="imgbox"><i class="fa <?=$device_category_data['fa_icon']?>"></i></div>
																	<div class="btnbox"><?=$device_category_data['title']?></div>
																</label>
															</li>
														<?php
														}
													} ?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="brand_question_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<!-- <p><?=$ad_name?></p> -->
								<div class="clearfix">
									<div class="question assistant float-left d-flex">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">
											<p><small><?=$ad_name?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span>Which brand is your?</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="brand_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<?php /*?><p class="text-right">I</p><?php */?>
								<div class="clearfix">
									<div class="question client float-right">
										<div id="brand_list_data" style="display:block"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="device_question_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<!-- <p><?=$ad_name?></p> -->
								<div class="clearfix">
									<div class="question assistant d-flex float-left">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">
											<p><small><?=$ad_name?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span>Which device is your?</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="device_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="question client float-right">
									<div id="device_list_data" style="display:block"></div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="model_question_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<!-- <p><?=$ad_name?></p> -->
								<div class="clearfix">
									<div class="question assistant d-flex float-left">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">
											<p><small><?=$ad_name?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span>Which model is your?</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="model_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<?php /*?><p class="text-right">I</p><?php */?>
								<div class="question client float-right">
									<div id="model_list_data" style="display:block"></div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="model_dfields"></div>
					<?php /*?><span id="show_final_amt" style="display:none"></span><?php */?>
					<div id="final_offer_div" style="display:none"></div>
				</div>

				<input type="hidden" name="sell_my_device_new" value="1">
				<input type="hidden" name="quantity" id="quantity" value="1"/>
				<input type="hidden" name="device_id" id="device_id" value="" />
				<input type="hidden" id="base_price" name="base_price" value="" />
				<input type="hidden" name="payment_amt" id="payment_amt" value=""/>
				<input type="hidden" id="total_price_org" value=""  />
				<input type="hidden" id="show_final_amt_val" value=""/>
				<input type="hidden" id="fields_cat_type" name="fields_cat_type" value="">
				<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
			</form>
		</div>
		<!--END-->
		
		</div>
	</div>
</section>

<script>
var tpj=jQuery;

var fade_in_out_time=1000;
var fields_list_data=[];

function show_first_welcome_message(){
	setTimeout(function(){
		var _div=tpj("#first_welcome");
		_div.show();
		var spinner_div=_div.find("div#spinner");
		spinner_div.show();
		var _msg_div=_div.find("div#msg_div");
		spinner_div.fadeOut( fade_in_out_time, function(){
			_msg_div.show();
			show_second_wlecome_message();
		});
	},500)
}

function show_second_wlecome_message(){
	var _div=tpj("#second_welcome");
	_div.show();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	var _msg_div=_div.find("div#msg_div");
	spinner_div.fadeOut( fade_in_out_time, function(){
		_msg_div.show();
		show_device_category_list_div();
	});
}

function show_device_category_list_div(){
	var _div=tpj("#device_category_list_div");
	_div.fadeIn();
}

function show_brand_question_div(){
	var _div=tpj("#brand_question_div");
	_div.fadeIn();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	
	var selected_device_category_name=tpj("input[name=device_category_id]:checked").attr("data-value");
	
	var _msg_div=_div.find("div#msg_div");
	_msg_div.hide();
	_msg_div.html('Which brand is your '+ selected_device_category_name);
	spinner_div.fadeOut(fade_in_out_time, function(){
		_msg_div.show();
	});
}

function show_brand_list_div(){
	tpj.scrollTo(tpj('#brand_question_div'), {
		hash: false,
		offset: -50,
		duration: '500',
		onAfter: function() {
			var _div=tpj("#brand_list_div");
			_div.fadeIn();
		}
	});
}

function hide_brand_list_div(){
	var _div=tpj("#brand_list_div");
	_div.hide();
	tpj("#brand_list_data").html("");
}


function show_model_list_div(){
	tpj.scrollTo(tpj('#model_question_div'), {
		hash: false,
		offset: -50,
		duration: '500',
		onAfter: function() {
			var _div=tpj("#model_list_div");
			_div.fadeIn();
		}
	});
}

function hide_modal_list_div(){
	var _div=tpj("#model_list_div");
	_div.hide();
	tpj("#model_list_data").html("");
	
	clear_model_fields_html();
	
	var _div=tpj("#model_question_div");
	_div.hide();
}

function clear_model_fields_html(){
	tpj("#model_dfields").html("");
	fields_list_data=[];
	
	tpj("#base_price").val('');
	tpj("#payment_amt").val('');
	tpj("#total_price_org").val('');
	tpj("#show_final_amt_val").val('');
	tpj("#show_final_amt").html('');
	tpj("#final_offer_div").html('').hide();
	tpj("#device_id").val('');
}

function show_model_question_div(){
	var _div=tpj("#model_question_div");
	_div.fadeIn();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	
	var selected_brand_id_name=tpj("input[name=brand_id]:checked").attr("data-value");
	
	var _msg_div=_div.find("div#msg_div");
	_msg_div.hide();
	_msg_div.html('Which model is your '+ selected_brand_id_name);
	spinner_div.fadeOut( fade_in_out_time, function(){
		_msg_div.show();
	});
}

function show_device_question_div(){
	var _div=tpj("#device_question_div");
	_div.fadeIn();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	
	var selected_brand_id_name=tpj("input[name=brand_id]:checked").attr("data-value");
	
	var _msg_div=_div.find("div#msg_div");
	_msg_div.hide();
	_msg_div.html('Which device is your '+ selected_brand_id_name);
	spinner_div.fadeOut( fade_in_out_time, function(){
		_msg_div.show();
	});
}

function show_device_list_div(){
	tpj.scrollTo(tpj('#device_question_div'), {
		hash: false,
		offset: -50,
		duration: '500',
		onAfter: function() {
			var _div=tpj("#device_list_div");
			_div.fadeIn();
		}
	});
}

function hide_device_list_div(){
	var _div=tpj("#device_list_div");
	_div.hide();
	tpj("#device_list_data").html("");
	var _div=tpj("#device_question_div");
	_div.hide();
}

function create_model_fields(){
	var show_first_model_question_index="null";
	var tpjnn="0";
	if(fields_list_data && fields_list_data.length>0){
		var total_field_count=fields_list_data.length;
		console.log(total_field_count,fields_list_data);
		fields_list_data.forEach(function(item,i){
			tpjnn = Number(tpjnn)+1;
			var field_id=item['id'];
			if(show_first_model_question_index=='null'){
				show_first_model_question_index=i;
			}
			
			var tpjlast_next_button = "";
			if(total_field_count == tpjnn) {
				tpjlast_next_button = "yes";
			}
			
			var qdiv_id='model_question_div_'+i;
			var field_name=item['field_name'];
			var question_title=item['title'];
			
			var input_type=item['input_type'];
			var is_required=item['is_required'];
			var product_options_list=item['product_options_list'];
			var selected_checkbox_values=item['selected_checkbox_values'];
			var selected_radio_dropdown_value=item['selected_radio_dropdown_value'];
			
			var _new_field_name=field_name;//+':'+field_id;
			
			var question_div='<div id="'+qdiv_id+'" style="display:none" class="model_fields model_fields_q" data-field_id="'+field_id+'" data-input_type="'+input_type+'">';
				question_div+='<div class="row">';
					question_div+='<div class="col-md-12">';
						// question_div+='<p><?=$ad_name?></p>';
						question_div+='<div class="clearfix">';
							question_div+='<div class="question assistant d-flex float-left">';
								question_div+='<div class="image text-center">';
								question_div+='<img class="assistant" src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">';
								question_div+='<p><small><?=$ad_name?></small></p>';
								question_div+='</div>';
								question_div+='<div class="loading" id="spinner" style="display:none"></div>';
								question_div+='<div id="msg_div" style="display:none">';
									question_div+='<span>'+question_title+'</span>';
								question_div+='</div>';
							question_div+='</div>';
						question_div+='</div>';
					question_div+='</div>';
				question_div+='</div>';
				
			question_div+="</div>";
			
			tpj("#model_dfields").append(question_div);
			
			var adiv_id='model_ans_div_'+i;
			var ans_div='<div id="'+adiv_id+'" style="display:none" class="model_fields model_fields_ans" data-field_id="'+field_id+'" data-input_type="'+input_type+'" data-required="'+is_required+'">';
			
				ans_div+='<div class="row">';
					ans_div+='<div class="col-md-12">';
					//ans_div+='<p class="text-right">I</p>';
					ans_div+='<div class="question client float-right">';
						ans_div+='<div id="m_ans_div" class="modern-block__content block-content-base">';
							
							if(input_type=="select" || input_type=="radio" || input_type=="checkbox"){
								if(product_options_list && product_options_list.length>0){
									product_options_list.forEach(function(option_item,io){
										
										var product_opt_id=option_item['id'];
										var label=option_item['label'];
										var add_sub=option_item['add_sub'];
										var checked=option_item['checked'];
										var icon=option_item['icon'];
										var is_default=option_item['is_default'];
										var price=option_item['price'];
										var price_type=option_item['price_type'];
										var tooltip=option_item['tooltip'];

										var tooltip_html = '';
										if(tooltip) {
											tooltip_html = '&nbsp;<span class="tooltip-icon" data-toggle="tooltip" title="'+tooltip+'" data-original-title="'+tooltip+'"><i class="fa fa-info-circle"></i></span>';
										}
										
										ans_div+='<span class="options_values">';
											
											if(input_type=="select" || input_type=="radio"){
												var _new_field_value=label;//+':'+product_opt_id;
												ans_div+='<button data-issubmit="'+tpjlast_next_button+'" class="btn btn-sm capacity-row model_radio_select_btn" type="button" data-input_type="'+input_type+'" data-current_i="'+i+'">'+label+''+tooltip_html+'</button>';
												ans_div+=' <input class="radioele" name="'+_new_field_name+'" value="'+_new_field_value+'" type="radio" style="display:none;" data-price="'+price+'" data-add_sub="'+add_sub+'" data-price_type="'+price_type+'" data-default="'+is_default+'" data-issubmit="'+tpjlast_next_button+'" data-input_type="'+input_type+'" data-current_i="'+i+'" ';
												/*if (checked){
													ans_div += ' checked="checked"';
												}*/
												ans_div += '/>';
											} else {
												var _new_field_value=label+':'+product_opt_id;
												ans_div+='<div class="custom-control custom-checkbox custom-control-inline">';
													ans_div+='<input class="checkboxele custom-control-input" name="'+_new_field_name+'[]" id="'+label+'" value="'+_new_field_value+'" type="checkbox" data-price="'+price+'" data-add_sub="'+add_sub+'" data-price_type="'+price_type+'" data-default="'+is_default+'" ';
												/*if ( checked ) {
													ans_div += ' checked="checked"';
												}*/
												
												ans_div += '/><label class="custom-control-label" for="'+label+'">'+label+''+tooltip_html+'</label>';	
												ans_div+='</div>';
											}
		
										ans_div+='</span>';
										
									});
									
									if(input_type=="checkbox"){
										ans_div+='<div class="clearfix"></div>';
										ans_div+='<div class="text-right clearfix">';
										ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+tpjlast_next_button+'" data-current_i="'+i+'">Next&nbsp;<i class="fa fa-forward"></i></a>';
										ans_div+='<span class="text-danger"></span>';
										ans_div+='</div>';
									}
								}
							}
							/*else if(input_type=="text"){
								ans_div+='<input name="'+_new_field_name+'" class="form-control input" type="text"/>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+tpjlast_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i>Next</a>';
							}
							else if(input_type=="textarea"){
								ans_div+='<textarea name="'+_new_field_name+'" class="form-control textarea input"></textarea>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+tpjlast_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i>Next</a>';
							}
							else if(input_type=="datepicker"){
								ans_div+='<input name="'+_new_field_name+'" class="form-control input datepicker" id="datepicker" type="text" autocomplete="off" readonly=""/>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+tpjlast_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i>Next</a>';
							}
							else if(input_type=="file"){
								ans_div+='<span></span><div class="clearfix fileupload"><input name="'+_new_field_name+'" class="form-control input" type="file" class="input" onChange="changefile(this)"/><div class="filenamebox">No file choosen</div></div>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+tpjlast_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i>Next</a>';
							}*/
							
						ans_div+='</div>';
						ans_div+='</div>';
					ans_div+='</div>';
				ans_div+='</div>';
				ans_div+='</div>';
			ans_div+="</div>";
			tpj("#model_dfields").append(ans_div);
		});
	}
	if(show_first_model_question_index!='null'){
		show_model_question_ans_field(show_first_model_question_index);
	}
	
	//tpj(".datepicker").datepicker();
}

function show_model_question_ans_field(field_id,force_fully="0"){
	var qdiv_id='model_question_div_'+field_id;
	var _div=tpj("#"+qdiv_id);
	
	if(_div.length == 0) {
		
	} else {
		_div.show();
		if(force_fully=="0"){
			var spinner_div=_div.find("div#spinner");
			spinner_div.show();
			var _msg_div=_div.find("div#msg_div");
			
			tpj.scrollTo(_div, {
				hash: false,
				offset: -50,
				duration: '500',
				onAfter: function() {
					console.log('reached');
				}
			});
			
			spinner_div.fadeOut( fade_in_out_time, function(){
				_msg_div.show();
				setTimeout(function() {
					var adiv_id='model_ans_div_'+field_id;
					var _div=tpj("#"+adiv_id);
					_div.show();
					//tpj.scrollTo(_div, 500);
				}, 500);
			});
		}
		else{
			tpj.scrollTo(_div, {
				hash: false,
            	offset: -50,
				duration: '500',
				onAfter: function() {
					console.log('reached');
				}
			});
			//tpj.scrollTo(_div, 500);
		}
	}
}

/*function updatePrice(price,sign,type){
	if(type==0){
		var total_price_org = tpj("#total_price_org").val();
		price = (total_price_org*price)/100;
		var total_price = tpj("#show_final_amt_val").val();
	}else{
		var total_price = tpj("#show_final_amt_val").val();
	}
	
	if(sign=="+"){
		total_price = Number(total_price) + Number(price);
	}else{
		total_price = Number(total_price) - Number(price);
	}
	tpj("#show_final_amt_val").val(total_price);
	tpj("#show_final_amt").html(total_price);
	tpj("#payment_amt").val(total_price);
}*/

/*function updatePrice_chk_new(price,sign,type,obj){
	if(tpj(obj).is(":checked")){
		
	}else{
	   if(sign=="+"){
			sign = "-";
		}else{
			sign = "+";
		} 
	}
	updatePrice(price,sign,type);
	create_final_offer_div();
}*/

function changefile(obj){
	var str  = obj.value;
	tpj(obj).next().html(str);
	//tpj(obj).prev().html("");
}

function create_final_offer_div(cback=""){
	var selected_device_category_name=tpj("input[name=device_category_id]:checked").attr("data-value");
	var selected_brand_id_name=tpj("input[name=brand_id]:checked").attr("data-value");
	var selected_device_id_name=tpj("input[name=device_id]:checked").attr("data-value");
	var selected_device_model_name=tpj("input[name=model_id]:checked").attr("data-value");
	var show_final_amt_val='';//tpj("#show_final_amt_val").val();

	var selected_device_model_image=tpj("input[name=model_id]:checked").attr("data-model_image");
	
	var selected_fields_data_list=[];
	
	if(fields_list_data && fields_list_data.length>0){
		var total_field_count=fields_list_data.length;
		fields_list_data.forEach(function(item,i){
			
			var field_id=item['id'];
			var field_name=item['field_name'];
			var field_title=item['title'];
			var input_type=item['input_type'];
			
			var _new_field_name=field_name;//+':'+field_id;
			
			var field_value="";
			var is_valid_to_add=true;
			var this_field_value_array=[];
			if(input_type=="text" || input_type=="textarea" || input_type=="datepicker"){
				var this_field_value=tpj('[name="'+_new_field_name+'"]').val();
				if(this_field_value && this_field_value!=''){
					this_field_value_array=this_field_value.split(':');
				}
				field_value=this_field_value_array['0'];
			}
			else if(input_type=="select" || input_type=="radio"){
				var this_field_value=tpj('input[name="'+_new_field_name+'"]:checked').val();
				if(this_field_value && this_field_value!=''){
					this_field_value_array=this_field_value.split(':');
				}
				field_value=this_field_value_array['0'];
			}
			else if(input_type=="checkbox"){
				var checkbox_values=[];
				tpj('input[name="'+_new_field_name+'[]"]:checked').each(function(){
					var this_field_value=this.value;
					if(this_field_value && this_field_value!=''){
						this_field_value_array=this_field_value.split(':');
					}
					checkbox_values.push(this_field_value_array['0']);
				});
				field_value=checkbox_values.join(", ");
			}
			else{
				is_valid_to_add=false;
			}
			
			if(is_valid_to_add){
				selected_fields_data_list.push({'field_name':field_title,'field_value':field_value,'current_field_index':i});
			}
			
		});
	}
	
	var offer_html='<div class="row">';
			offer_html+='<div class="col-md-12">';
				// offer_html+='<p><?=$ad_name?></p>';
				offer_html+='<div class="clearfix">';
					offer_html+='<div class="question assistant final float-left">';
						offer_html+='<div class="top d-flex">';	
							offer_html+='<div class="image text-center">';	
								offer_html+='<img class="assistant" src="<?=SITE_URL?>images/assistantForQuestion-small.svg" alt="">';
								offer_html+='<p class="pl-2"><small><?=$ad_name?></small></p>';
							offer_html+='</div>';
							offer_html+='<div class="description">';
								offer_html+='<h4>Here you will receive your offer</h4>';
							offer_html+='</div>';
						offer_html+='</div>';
						offer_html+='<div id="msg_div">';
								offer_html+='<div class="row">';
										offer_html+='<div class="col-md-3">';
											if(selected_device_model_image!=''){
												offer_html+='<div class="image">';
													offer_html+='<img class="assistant" src="'+selected_device_model_image+'" alt="">';
												offer_html+='</div>';
											}
												offer_html+='<div>';
												
												offer_html+='</div>';
										offer_html+='</div>';  
										offer_html+='<div class="col-md-9">';
											offer_html+='<div class="row">';
											
												offer_html+='<div class="col-md-6">';
													offer_html+='<p><strong>BRAND:</strong>';
														offer_html+='<br />'+selected_brand_id_name;
														offer_html+='<button type="button" class="btn btn-link" onClick=\'show_brand_list_div()\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
													offer_html+='</p>';
												offer_html+='</div>';
												
												if(selected_device_id_name!=null && selected_device_id_name!='' && selected_device_id_name!='null'){
													offer_html+='<div class="col-md-6">';
														offer_html+='<p><strong>Device:</strong>';
															offer_html+='<br />'+selected_device_id_name;
															offer_html+='<button type="button" class="btn btn-link" onClick=\'show_device_list_div()\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
														offer_html+='</p>';
													offer_html+='</div>';
												}
												
												offer_html+='<div class="col-md-6">';
													offer_html+='<p><strong>MODEL:</strong>';
														offer_html+='<br />'+selected_device_model_name;
														offer_html+='<button type="button" class="btn btn-link" onClick=\'show_model_list_div()\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
													offer_html+='</p>';
												offer_html+='</div>';
												if(selected_fields_data_list && selected_fields_data_list.length>0){
													selected_fields_data_list.forEach(function(data,i){
														offer_html+='<div class="col-md-6">';
															offer_html+='<p><strong>'+data['field_name']+'</strong>';
															offer_html+='<br />'+data['field_value'];
															offer_html+='<button type="button" class="btn btn-link" onClick=\'show_model_question_ans_field("'+data['current_field_index']+'","1")\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
														offer_html+='</p>';
														offer_html+='</div>';
													});
												}
											offer_html+='</div>';
											offer_html+='<button type="submit" class="btn btn-primary btn-lg mb-3 step5next">Sell Now</button>';
												offer_html+='<strong class="show_final_amt"><span id="show_final_amt">'+show_final_amt_val+'</span></strong>';
										offer_html+='</div>';
								offer_html+='</div>';
						
							
							
							
							
							
							
							// offer_html+='<p><span>Here you will receive your offer:</span> <?=$amount_sign_with_prefix?><span id="show_final_amt">'+show_final_amt_val+'</span><?=$amount_sign_with_postfix?></p>';
							
							// offer_html+='<div class="col-md-12 text-right">';
							// 	offer_html+='<button type="submit" class="btn btn-primary step5next">Sell Now</button>';
							// offer_html+='</div>';
							
							
						offer_html+='</div>';
					offer_html+='</div>';
				offer_html+='</div>';
			offer_html+='</div>';
	offer_html+='</div>';
	
	tpj("#final_offer_div").html(offer_html);
	if(cback!='' && typeof cback === "function"){
		cback();
	}
}	

function final_show_model_details(){
	var cback=function(){
		/*tpj("#final_offer_div").fadeIn(300);
		tpj.scrollTo(tpj("#final_offer_div"), {
			hash: false,
			duration: '1000',
			onAfter: function() {
				console.log(tpj("#final_offer_div"));
			}
		});*/
	};
	
	create_final_offer_div(cback);
	tpj("#final_offer_div").fadeIn(300);
	tpj.scrollTo(tpj("#final_offer_div"), {
		hash: false,
		offset: -50,
		duration: '1000',
		onAfter: function() {
			console.log(tpj("#final_offer_div"));
		}
	});
}

function get_price() {
	tpj.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>ajax/get_model_price.php',
		data: tpj('#sell_my_device_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);
				var total_price = resp_data.payment_amt;

				var _t_price=formatMoney(total_price);
				var f_price=format_amount(_t_price);
				
				tpj("#show_final_amt").html(f_price);
				tpj("#show_final_amt_val").val(total_price);
				tpj("#payment_amt").val(total_price);

				//tpj(".device_nm").html(resp_data.device_nm);
			}
		}
	});
}

(function( tpj ) {
	tpj(function() {

		tpj(document).on('click', '.device_category_id', function() {
			hide_brand_list_div();
			hide_device_list_div();
			hide_modal_list_div();
			show_brand_question_div();
			var device_category_id = tpj(this).val();
		    post_data = "device_category_id="+device_category_id+"&token=<?=get_unique_id_on_load()?>&m=brand_list";
			tpj(document).ready(function(tpj){
				tpj.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/get_nlist.php",
					data:post_data,
					success:function(data) {
						tpj("#brand_list_data").html(data);
						show_brand_list_div();
					}
				});
			});
		});
		
		tpj(document).on('click', '.brand_id', function() {
			
			hide_modal_list_div();
			hide_device_list_div();
			
			var device_list=tpj(this).attr("data-device_list");
			var ajax_method="model_list";
			if(device_list>1){
				ajax_method="device_list";
				show_device_question_div();
			}
			else{
				show_model_question_div();
			}
		
			var brand_id = tpj(this).val();
			var device_category_id=tpj("input[name=device_category_id]:checked").val();
		    post_data = "brand_id="+brand_id+"&device_category_id="+device_category_id+"&token=<?=get_unique_id_on_load()?>&m="+ajax_method;
			tpj(document).ready(function(tpj){
				tpj.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/get_nlist.php",
					data:post_data,
					success:function(data) {
						
						if(device_list>1){
							tpj("#device_list_div").hide();
							tpj("#device_list_data").html(data);
							show_device_list_div();
						}
						else{
							tpj("#model_list_div").hide();
							tpj("#model_list_data").html(data);
							show_model_list_div();
						}
					}
				});
			});
		});
		
		tpj(document).on('click', '.device_id', function() {
			
			var ajax_method="model_list";
			
			hide_modal_list_div();
			show_model_question_div();
		
			var device_id = tpj(this).val();
			var brand_id = tpj("input[name=brand_id]:checked").val();
			var device_category_id=tpj("input[name=device_category_id]:checked").val();
		    post_data = "brand_id="+brand_id+"&device_id="+device_id+"&device_category_id="+device_category_id+"&token=<?=get_unique_id_on_load()?>&m="+ajax_method;
			tpj(document).ready(function(tpj){
				tpj.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/get_nlist.php",
					data:post_data,
					success:function(data) {
						tpj("#model_list_div").hide();
						tpj("#model_list_data").html(data);
						show_model_list_div();
					}
				});
			});
		});
		
		tpj(document).on('click', '.device_model_id', function() {
			clear_model_fields_html();
			var model_id = tpj(this).val();

			post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>&m=get_model_field_list";
			tpj(document).ready(function(tpj){
				tpj.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/get_nlist.php",
					data:post_data,
					success:function(result) {
						if(result.status=="success") {
							var data=result.data;
							fields_list_data=data.fields_list_data;
							
							var price=data.price;
							var device_id=data.device_id;
							
							tpj("#base_price").val(price);
							//tpj("#payment_amt").val(price);
							tpj("#total_price_org").val(price);
							//tpj("#show_final_amt_val").val(price);
							//tpj("#show_final_amt").html(price);
							tpj("#device_id").val(device_id);
							tpj("#fields_cat_type").val(data.fields_cat_type);
						} else {
							fields_list_data=[];
						}
						create_model_fields();
					}
				});
			});
		});
		
		
		
		
		
		tpj(document).on('click', '.model_next_btn', function() {
			var is_submit = tpj(this).attr("data-issubmit");
			var data_input_type = tpj(this).attr("data-input_type");
			var current_i= tpj(this).attr("data-current_i");
			var next_show_i=Number(current_i)+1;
			
			
			var current_ans_row=tpj("#model_ans_div_"+current_i);
			var crt_row_type = current_ans_row.attr("data-input_type");
            var is_required = current_ans_row.attr("data-required");
			
			if(is_required=="1"){
				if(tpj(this).prev().hasClass("input")){
					if(tpj(this).prev().val()==""){
						if(crt_row_type=="file"){
							tpj(this).prev().prev().html("Please Choose File");
						}else{
							tpj(this).prev().attr("placeholder","Please Enter Value");
						}
						return false;
					}
				}
				else if(crt_row_type=="radio" || crt_row_type=="select"){
					var cc = current_ans_row.find("input:checked").length;
					if(cc==0){
						tpj(this).next().html("<br />Please choose an option");
						return false;
					}
					else{
						tpj(this).next().html("");
					}
				}
				else if(crt_row_type=="checkbox"){
					var cc = current_ans_row.find("input:checked").length;
					if(cc==0){
						tpj(this).next().html("<br />Please choose an option");
						return false;
					}
					else{
						tpj(this).next().html("");
					}
				}
			}
			
			setTimeout(function() {
				get_price();
			}, 500);
			
			if(is_submit==""){
				show_model_question_ans_field(next_show_i);
				create_final_offer_div();
			}
			else if(is_submit=="yes"){
				final_show_model_details();
			}
		});

		tpj(document).on('click', '.checkboxele', function() {
			create_final_offer_div();
			
			setTimeout(function() {
				get_price();
			}, 500);
		});

		tpj(document).on('click', '.model_radio_select_btn', function() {
			tpj(this).parent().siblings().each(function(){
                tpj(this).find(".capacity-row").removeClass("sel");
            });
			/*var elem = tpj(this).parent().parent().find("input:checked");
            price = elem.attr("data-price");
            type = elem.attr("data-price_type");
            sign = elem.attr("data-add_sub");   
            if(typeof price !== 'undefined'){
                if(sign=="+"){
                    sign = "-";
                }else{
                    sign = "+";
                }
                updatePrice(price,sign,type);
            }*/
            tpj(this).next().click();
            tpj(this).addClass("sel");
			
			var is_submit = tpj(this).attr("data-issubmit");
			var data_input_type = tpj(this).attr("data-input_type");
			var current_i= tpj(this).attr("data-current_i");
			var next_show_i=Number(current_i)+1;

			if(is_submit==""){
				show_model_question_ans_field(next_show_i);
				create_final_offer_div();
			}
			else if(is_submit=="yes"){
				final_show_model_details();
			}
			
			setTimeout(function() {
				get_price();
			}, 500);
		});
		
		show_first_welcome_message();
		
	});
})(jQuery);
</script>

<style>
.loading {
    margin: 20px;
    font-size: 36px;
    font-family: sans-serif;
}

.loading:after {
  display: inline-block;
  animation: dotty steps(1,end) 1s infinite;
  content: '';
}

@keyframes dotty {
  0%   { content: ''; }
  25%  { content: '.'; }
  50%  { content: '..'; }
  75%  { content: '...'; }
  100% { content: ''; }
}
</style>
<script src="<?=SITE_URL?>js/jquery.scrollTo.min.js"></script>