<?php
$section_name = $home_settings_data['section_name']; ?>

<script type="text/javascript">
function check_form(a) {
	if(a.title.value.trim() == "") {
		alert('Please enter title');
		a.title.focus();
		return false;
	}

	/*if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}*/

	if(jQuery('.summernote2').summernote('codeview.isActivated')) {
		jQuery('.summernote2').summernote('codeview.deactivate');
	}
}

jQuery(document).ready(function() {
	var maxField = 10;
	
	var addButton_2 = $('.add_payment_status');
    var wrapper_2 = $('.payment_status_wrapper');
	
	var num_of_items = $('#num_of_items').val();
    var x_2 = num_of_items;
    
    //Once add button is clicked
    $(addButton_2).click(function() {
        //Check maximum number of input fields
        if(x_2 < maxField) { 
            x_2++; //Increment field counter
			
			<?php
			if($section_name == "how_it_works" || $section_name == "why_choose_us") { ?>
			var fieldHTML_2 = '<div class="form-group m-form__group row">';
			fieldHTML_2 += '<div class="col-lg-12">';
				fieldHTML_2 += '<div class="row">';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="text" class="form-control m-input" name="item_title['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-3">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input class="form-control m-input" name="item_description['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<label class="m-radio" style="margin-bottom:1px;">';
								fieldHTML_2 += '<input type="radio" class="icon_type_fa" data-id="'+x_2+'" name="item_icon_type['+x_2+']" value="fa" checked="checked">Fa Icon<span></span>';
							fieldHTML_2 += '</label>';
							fieldHTML_2 += '<label class="m-radio">';
								fieldHTML_2 += '<input type="radio" class="icon_type_img" data-id="'+x_2+'" name="item_icon_type['+x_2+']" value="custom">Image<span></span>';
							fieldHTML_2 += '</label>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control fa_icon_showhide'+x_2+'">';
							fieldHTML_2 += '<input class="form-control m-input" name="item_fa_icon['+x_2+']">';
						fieldHTML_2 += '</div>';
						fieldHTML_2 += '<div class="m-form__control custom_icon_showhide'+x_2+'" style="display:none;">';
							fieldHTML_2 += '<div class="custom-file">';
								fieldHTML_2 += '<input type="file" id="item_image" class="custom-file-input" name="item_image['+x_2+']" onChange="checkFile(this);" accept="image/*">';
								fieldHTML_2 += '<label class="custom-file-label" for="image">Choose file</label>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-1">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="number" class="form-control m-input" name="item_ordering['+x_2+']" style="padding-left:5px;padding-right:5px;" min="1">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<div class="remove_payment_status btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
								fieldHTML_2 += '<span><i class="la la-trash-o"></i><span>Delete</span>';
								fieldHTML_2 += '</span>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
				fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
			<?php
			}
			
			if($section_name == "slider") { ?>
			var fieldHTML_2 = '<div class="form-group m-form__group row">';
			fieldHTML_2 += '<div class="col-lg-12">';
				fieldHTML_2 += '<div class="row">';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="text" class="form-control m-input" name="item_title['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="text" class="form-control m-input" name="item_sub_title['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-1">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<label class="m-checkbox">';
								fieldHTML_2 += '<input type="checkbox" name="use_title_as_button['+x_2+']" value="1">';
								fieldHTML_2 += 'Use title as Button';
								fieldHTML_2 += '<span></span>';
							fieldHTML_2 += '</label>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="text" class="form-control m-input" name="button_url['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<div class="custom-file">';
								fieldHTML_2 += '<input type="file" id="item_image" class="custom-file-input" name="item_image['+x_2+']" onChange="checkFile(this);" accept="image/*">';
								fieldHTML_2 += '<label class="custom-file-label" for="image">Choose file</label>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-1">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="number" class="form-control m-input" name="item_ordering['+x_2+']" style="padding-left:5px;padding-right:5px;" min="1">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					fieldHTML_2 += '<div class="col-md-2">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<div class="remove_payment_status btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
								fieldHTML_2 += '<span><i class="la la-trash-o"></i><span>Delete</span>';
								fieldHTML_2 += '</span>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
				fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
			<?php
			} ?>
										
            $(wrapper_2).append(fieldHTML_2); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper_2).on('click', '.icon_type_fa, .icon_type_img', function(e){
		var id = $(this).attr("data-id");
		var type = $(this).val();
		if(type == "fa") {
			$(".custom_icon_showhide"+id).hide();
			$(".fa_icon_showhide"+id).show();
		} else if(type == "custom") {
			$(".custom_icon_showhide"+id).show();
			$(".fa_icon_showhide"+id).hide();
		}
    });
	
	$(wrapper_2).on('click', '.remove_payment_status', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent().parent('div').remove();
        x--;
    });
});

function checkFile(fieldObj) {
	if (fieldObj.files.length == 0) {
		return false;
	}

	var id = fieldObj.id;
	var str = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.') + 1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize / 10485760).toFixed(2);

	if ((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")) {
		var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
		alert(error);
		document.getElementById(id).value = '';
		return false;
	}
}

function checkImageVideo(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

	var id = fieldObj.id;
	var str = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.') + 1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize / 10485760).toFixed(2);

	if(FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg" && FileExt != "mp4" && FileExt != "3gp" && FileExt != "mov" && FileExt != "wmv" && FileExt != "flv" && FileExt != "avi") {
		var error = "Please make sure your image/video is in png | jpg | jpeg | gif | mp4 | 3gp | mov | wmv | flv | avi format.\n\n";
		alert(error);
		document.getElementById(id).value = '';
		return false;
	}
}
</script>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<!-- BEGIN: Header -->
	<?php include("include/admin_menu.php"); ?>
	<!-- END: Header -->

	<!-- begin::Body -->
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
		<!-- BEGIN: Left Aside -->
		<?php include("include/navigation.php"); ?>
		<!-- END: Left Aside -->
		<div class="m-grid__item m-grid__item--fluid m-wrapper">
			<div class="m-content ">
				<?php include('confirm_message.php'); ?>
				<!--Begin::Section-->
				<div class="row">
					<div class="col-lg-12">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Home Settings':'Add Home Settings')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/home_settings.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<?php
										if($home_settings_data['type']=="inbuild") { ?>
										<div class="form-group m-form__group">
											<label for="input">Section Name :</label>
											<?=ucwords(str_replace("_"," ",$section_name))?>
										</div>
										<?php
										} ?>
										
										<?php /*?><div class="form-group m-form__group">
											<label for="input">Choose Section Color :</label>
											<select class="form-control m-input m-select2 m-select2-general" name="section_color" id="section_color">
												<option value=""> -Select- </option>
												<option value="white" <?php if($home_settings_data['section_color'] == "white"){echo 'selected="selected"';}?>>White</option>
												<option value="gray" <?php if($home_settings_data['section_color'] == "gray"){echo 'selected="selected"';}?>>Gray</option>
												<option value="dark" <?php if($home_settings_data['section_color'] == "dark"){echo 'selected="selected"';}?>>Dark</option>
												<option value="heavydark" <?php if($home_settings_data['section_color'] == "heavydark"){echo 'selected="selected"';}?>>Heavy dark</option>
												<option value="lightblue" <?php if($home_settings_data['section_color'] == "lightblue"){echo 'selected="selected"';}?>>Light Blue</option>
											</select>
										</div><?php */?>
										
										<?php
										//if($section_name != "slider") { ?>
										<div class="form-group m-form__group">
											<label for="fileInput">Background Image/Video :</label>
											<div class="custom-file">
												<input type="file" id="section_image" class="custom-file-input" name="section_image" onChange="checkImageVideo(this);">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											$section_image = $home_settings_data['section_image'];
											$section_image_ext = pathinfo($section_image,PATHINFO_EXTENSION);
											if($section_image) {
												if($section_image_ext=="png" || $section_image_ext=="jpg" || $section_image_ext=="jpeg" || $section_image_ext=="gif") {
													echo '<img src="../images/section/'.$section_image.'" width="200" class="my-md-2">';
												} else {
													echo '<a class="btn btn-info btn-sm" target="_blank" href="../images/section/'.$section_image.'">'.$home_settings_data['section_image'].'</a>';
												} ?>
												<a class="btn btn-danger btn-sm my-md-2" data-dismiss="fileupload" href="controllers/home_settings.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$home_settings_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
												<input type="hidden" name="old_section_image" value="<?=$section_image?>">
											<?php
											} ?>
                    					</div>
										<?php
										//} ?>
										
										<div class="form-group m-form__group">
											<label for="input">Title :</label>
											<input type="text" class="form-control m-input" id="title" value="<?=$home_settings_data['title']?>" name="title">
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_title" name="show_title" value="1" <?=($home_settings_data['show_title']=='1'?'checked="checked"':'')?>>
													Show Title
													<span></span>
												</label>
											</div>
										</div>
										
										<?php
										if($section_name != "slider") { ?>
										<div class="form-group m-form__group">
											<label for="input">
											Sub Title :
										    </label>
											<input type="text" class="form-control m-input" id="sub_title" value="<?=$home_settings_data['sub_title']?>" name="sub_title">
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_sub_title" name="show_sub_title" value="1" <?=($home_settings_data['show_sub_title']=='1'?'checked="checked"':'')?>>
													Show Sub Title
													<span></span>
												</label>
											</div>
										</div>

										<?php /*?><div class="form-group m-form__group">
											<label for="input">
											Intro Text :
										    </label>
											<textarea class="form-control m-input summernote" id="intro_text"  name="intro_text" rows="5"><?=$home_settings_data['intro_text']?></textarea>
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_intro_text" name="show_intro_text" value="1" <?=($home_settings_data['show_intro_text']=='1'?'checked="checked"':'')?>>
													Show Intro Text
													<span></span>
												</label>
											</div>
										</div><?php */?>
										
										<div class="form-group m-form__group">
											<label for="input">
											Description :
											</label>
											<textarea class="form-control m-input summernote2" id="description"  name="description" rows="5"><?=$home_settings_data['description']?></textarea>
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_description" name="show_description" value="1" <?=($home_settings_data['show_description']=='1'?'checked="checked"':'')?>>
													Show Description
													<span></span>
												</label>
											</div>
										</div>
										<?php
										}
										
										$n_i = 0;
										if($section_name == "how_it_works" || $section_name == "why_choose_us") { ?>
											<div class="payment_status_wrapper">
												<div class="form-group m-form__group row" style="padding-bottom:0px;">
													<div class="col-lg-12">
														<h4>Items</h4>
													</div>
												</div>
												<div class="form-group m-form__group row" style="padding-bottom:0px;">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Title</strong></label>
																</div>
															</div>
															<div class="col-md-3">
																<div class="m-form__control">
																	<label for="input"><strong>Description</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Icon Type</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Fa Icon OR Image</strong></label>
																</div>
															</div>
															<div class="col-md-1">
																<div class="m-form__control">
																	<label for="input"><strong>Ordering</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Action</strong></label>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<?php
												$n_i = 0;
												$items_data_array = json_decode($home_settings_data['items'],true);
												foreach($items_data_array as $items_data) {
												$item_icon_type = $items_data['item_icon_type'];
												$n_i = ($n_i+1); ?>
												<div class="form-group m-form__group row">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-md-2">
																<div class="m-form__control">
																	<input type="text" class="form-control m-input" name="item_title[<?=$n_i?>]" value="<?=$items_data['item_title']?>">
																</div>
															</div>
															<div class="col-md-3">
																<div class="m-form__control">
																	<input class="form-control m-input" name="item_description[<?=$n_i?>]" value="<?=$items_data['item_description']?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label class="m-radio" style="margin-bottom:1px;">
																		<input type="radio" class="icon_type_fa" data-id="<?=$n_i?>" name="item_icon_type[<?=$n_i?>]" value="fa" <?=($item_icon_type=='fa'||$item_icon_type==''?'checked="checked"':'')?>>
																		Fa Icon
																		<span></span>
																	</label>
																	<label class="m-radio">
																		<input type="radio" class="icon_type_img" data-id="<?=$n_i?>" name="item_icon_type[<?=$n_i?>]" value="custom" <?=($item_icon_type=='custom'?'checked="checked"':'')?>>
																		Image
																		<span></span>
																	</label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control fa_icon_showhide<?=$n_i?>" <?php if($item_icon_type=='fa'||$item_icon_type==''){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																	<input class="form-control m-input" name="item_fa_icon[<?=$n_i?>]" value="<?=$items_data['item_fa_icon']?>">
																</div>
																<div class="m-form__control custom_icon_showhide<?=$n_i?>" <?php if($item_icon_type=='custom'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																	<input type="hidden" name="old_item_image[<?=$n_i?>]" value="<?=$items_data['item_image']?>">
																	<div class="custom-file">
																		<input type="file" class="custom-file-input" name="item_image[<?=$n_i?>]" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	<?php
																	if($items_data['item_image']!="") { ?>
																		<a href="../images/section/<?=$items_data['item_image']?>" target="_blank">
																			<img src="../images/section/<?=$items_data['item_image']?>" width="25" class="my-md-2">
																		</a>
																	<?php
																	} ?>
																</div>
															</div>
															<div class="col-md-1">
																<div class="m-form__control">
																	<input type="number" class="form-control m-input" name="item_ordering[<?=$n_i?>]" value="<?=$items_data['item_ordering']?>" style="padding-left:5px;padding-right:5px;" min="1">
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<div class="remove_payment_status btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																		<span>
																			<i class="la la-trash-o"></i>
																			<span>Delete</span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php
												} ?>
											</div>
											<div class="m-form__group form-group row">
												<div class="col-lg-4">
													<div class="add_payment_status btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>Add</span>
														</span>
													</div>
												</div>
											</div>
										<?php
										} elseif($section_name == "slider") { ?>
											<div class="payment_status_wrapper">
												<div class="form-group m-form__group row" style="padding-bottom:0px;">
													<div class="col-lg-12">
														<h4>Items</h4>
													</div>
												</div>
												<div class="form-group m-form__group row" style="padding-bottom:0px;">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Title</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Sub Title</strong></label>
																</div>
															</div>
															<div class="col-md-1">
																<div class="m-form__control">
																	<label for="input"><strong>Use title as Button</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Button Url</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Slider Image</strong></label>
																</div>
															</div>
															<div class="col-md-1">
																<div class="m-form__control">
																	<label for="input"><strong>Ordering</strong></label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<label for="input"><strong>Action</strong></label>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<?php
												$n_i = 0;
												$items_data_array = json_decode($home_settings_data['items'],true);
												foreach($items_data_array as $items_data) {
												$item_icon_type = $items_data['item_icon_type'];
												$n_i = ($n_i+1); ?>
												<div class="form-group m-form__group row">
													<div class="col-lg-12">
														<div class="row">
															<div class="col-md-2">
																<div class="m-form__control">
																	<input type="text" class="form-control m-input" name="item_title[<?=$n_i?>]" value="<?=$items_data['item_title']?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<input type="text" class="form-control m-input" name="item_sub_title[<?=$n_i?>]" value="<?=$items_data['item_sub_title']?>">
																</div>
															</div>
															<div class="col-md-1">
																<div class="m-form__control">
																	<label class="m-checkbox">
																		<input type="checkbox" name="use_title_as_button[<?=$n_i?>]" value="1" <?php if($items_data['use_title_as_button'] == '1'){echo 'checked="checked"';}?>>
																		<span></span>
																	</label>
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<input type="text" class="form-control m-input" name="button_url[<?=$n_i?>]" value="<?=$items_data['button_url']?>">
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<input type="hidden" name="old_item_image[<?=$n_i?>]" value="<?=$items_data['item_image']?>">
																	<div class="custom-file">
																		<input type="file" class="custom-file-input" name="item_image[<?=$n_i?>]" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	<?php
																	if($items_data['item_image']!="") { ?>
																		<a href="../images/section/<?=$items_data['item_image']?>" target="_blank">
																		<img src="../images/section/<?=$items_data['item_image']?>" width="50" class="my-md-2">
																		</a>
																	<?php
																	} ?>
																</div>
															</div>
															<div class="col-md-1">
																<div class="m-form__control">
																	<input type="number" class="form-control m-input" name="item_ordering[<?=$n_i?>]" value="<?=$items_data['item_ordering']?>" style="padding-left:5px;padding-right:5px;" min="1">
																</div>
															</div>
															<div class="col-md-2">
																<div class="m-form__control">
																	<div class="remove_payment_status btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																		<span>
																			<i class="la la-trash-o"></i>
																			<span>Delete</span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php
												} ?>
											</div>
											<div class="m-form__group form-group row">
												<div class="col-lg-4">
													<div class="add_payment_status btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>Add</span>
														</span>
													</div>
												</div>
											</div>
											
											<div class="form-group m-form__group">
												<div class="m-checkbox-inline pt-2">
													<label class="m-checkbox">
														<input type="checkbox" id="show_search_model_box" name="show_search_model_box" value="1" <?=($home_settings_data['show_search_model_box']=='1'?'checked="checked"':'')?>>
														Show Search Model Box
														<span></span>
													</label>
												</div>
											</div>
										<?php
										} ?>
										
										<input type="hidden" id="num_of_items" value="<?=($n_i>0?$n_i:1)?>">
										<div class="m-form__group form-group">
											<label for="status">Status :</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?=($home_settings_data['status']=='1'||$home_settings_data['status']==''?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="0" <?=($home_settings_data['status']=='0'?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$home_settings_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="home_settings.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Portlet-->
					</div>
				</div>
				<!--End::Section-->
			</div>
		</div>
	</div>
	<!-- end:: Body -->
	<!-- begin::Footer -->
	<?php include("include/footer.php");?>
	<!-- end::Footer -->
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
	<i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
