<script type="text/javascript">
	function check_form(a) {
		if (a.postTitle.value.trim() == "") {
			alert('Please enter title');
			a.postTitle.focus();
			return false;
		} else if (a.postCont.value.trim() == "") {
			alert('Please enter content');
			a.postCont.focus();
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
                      <?=($id?'Edit Category':'Add Category')?>
                    </h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/blog.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="field-1">
												Title :
											</label>
											<input type="text" class="form-control m-input" id="postTitle" value="<?=$blog_data['postTitle']?>" name="postTitle">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Meta Title :
											</label>
											<input type="text" class="form-control m-input" id="meta_title" value="<?=$blog_data['meta_title']?>" name="meta_title">
										</div>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Meta Description :
											</label>
											<textarea class="form-control m-input" id="meta_desc" name="meta_desc" rows="5"><?=$blog_data['meta_desc']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Meta Keywords :
											</label>
											<textarea class="form-control m-input" id="meta_keywords"  name="meta_keywords" rows="5"><?=$blog_data['meta_keywords']?></textarea>
										</div>
										
										<div class="form-group m-form__group">
											<label for="image">Image :</label>
											<div class="custom-file">
												<input type="file" id="image" class="custom-file-input" name="image" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											if($blog_data['image']!="") { ?>
												<img src="../images/blog/<?=$blog_data['image']?>" width="200" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/blog.php?id=<?=$_REQUEST['id']?>&r_b_img_id=<?=$blog_data['postID']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
												<input type="hidden" id="old_image" name="old_image" value="<?=$blog_data['image']?>">
											<?php
											} ?>
                    					</div>
										
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Content :
											</label>
											<textarea class="form-control m-input summernote" id="postCont" name="postCont" rows="5"><?=$blog_data['postCont']?></textarea>
										</div>
										<div class="form-group m-form__group">
										  <div class="m-checkbox-list">
												<label class="control-label" for="input">Categories</label>
												<div class="controls">
													<?php get_categories_list($id); ?>
												</div>
										  </div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$blog_data['postID']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="add_edit_blog" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="blog.php" class="btn btn-secondary">Back</a>
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
