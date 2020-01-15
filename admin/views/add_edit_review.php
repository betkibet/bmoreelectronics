<script type="text/javascript">
function check_form(a) {
	if(a.name.value.trim()==""){
		alert('Please enter name');
		a.name.focus();
		a.name.value='';
		return false;
	}

	if(a.email.value.trim()==""){
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	}

	if(a.state.value.trim()==""){
		alert('Please enter state');
		a.state.focus();
		a.state.value='';
		return false;
	}

	if(a.city.value.trim()==""){
		alert('Please enter city');
		a.city.focus();
		a.city.value='';
		return false;
	}

	if(a.stars.value.trim()==""){
		alert('Please select rating');
		a.stars.focus();
		a.stars.value='';
		return false;
	}

	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}

	if(a.content.value.trim()==""){
		alert('Please enter content');
		a.content.focus();
		a.content.value='';
		return false;
	}

	if(a.date.value.trim()==""){
		alert('Please select date');
		a.date.focus();
		a.date.value='';
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
					<div class="col-lg-8">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Review':'Add Review')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/review.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="input">Name : *</label>
											<input type="text" class="form-control m-input" name="name" id="name" value="<?=$review_data['name']?>">
										</div>
										<div class="form-group m-form__group">
											<label for="input">Email : *</label>
											<input type="text" class="form-control m-input" name="email" id="email" value="<?=$review_data['email']?>">
										</div>
										<div class="form-group m-form__group">
											<label for="input">Country :</label>
											<select class="form-control m-select2 m-select2-general" name="country" id="country">
											  <option value=""> - Country - </option>
												<?php
												foreach($countries_list as $c_k => $c_v) { ?>
													<option value="<?=$c_v?>" <?php if($c_v==$review_data['country']){echo 'selected="selected"';}?>><?=$c_v?></option>
												<?php
												} ?>
											</select>
										</div>
										<div class="form-group m-form__group">
											<label for="input">State : *</label>
											<input type="text" class="form-control m-input" name="state" id="state" value="<?=$review_data['state']?>">
										</div>
										<div class="form-group m-form__group">
											<label for="input">City : *</label>
											<input type="text" class="form-control m-input" name="city" id="city" value="<?=$review_data['city']?>">
										</div>
										<div class="form-group m-form__group">
											<label for="input">How would you rate this business overall? : *</label>
											<select class="form-control m-select2 m-select2-general" name="stars" id="stars">
											  <option value=""> - Rating Star - </option>
												<?php
												for($si = 0.5; $si<= 5.0; $si=$si+0.5) { ?>
													<option value="<?=$si?>" <?php if($si==$review_data['stars']){echo 'selected="selected"';}?>><?=$si?></option>
												<?php
												} ?>
											</select>
										</div>
										<div class="form-group m-form__group">
											<label for="input">Title : *</label>
											<input type="text" class="form-control m-input" name="title" id="title" value="<?=$review_data['title']?>">
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Content :
											</label>
											<textarea class="form-control m-input summernote" id="input" name="content" rows="5"><?=$review_data['content']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Date : *
											</label>
											<input class="form-control m-input" type="date" id="date" name="date" placeholder="Select date (mm/dd/yyyy)" value="<?=($review_data['date']!='0000-00-00'?date('Y-m-d',strtotime($review_data['date'])):'')?>">
										</div>
										
										<div class="form-group m-form__group">
											<label for="fileInput">Image :</label>
											<div class="custom-file">
												<input type="file" id="image" class="custom-file-input" name="image" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											if($review_data['photo']!="") { ?>
												<img src="../images/review/<?=$review_data['photo']?>" width="200" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/review.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$review_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
												<input type="hidden" id="old_image" name="old_image" value="<?=$review_data['photo']?>">
											<?php
											} ?>
                    					</div>
										<div class="m-form__group form-group">
											<label for="">
												Status :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($review_data['status']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="0" <?=($review_data['status']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$review_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" class="btn btn-primary" name="add_update"><?=($id?'Update':'Save') ?></button>
										<a href="review.php" class="btn btn-secondary">Back</a>
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

