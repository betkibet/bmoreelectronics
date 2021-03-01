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
										  Home Page Settings
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="edit_home_settings.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>Add New</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/home_settings.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
									  <div class="row">
										<div class="col-sm-12">
											<table class="table table-bordered 0table-hover table-checkable dataTable dtr-inline">
											  <thead>
												<tr>
												  <th width="10">
													<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
														<input value="" class="m-checkable" type="checkbox" id="chk_all">
														<span></span>
													</label>
												  </th>
												  <th>Section Name</th>
												  <th>Title</th>
												  <th>Type</th>
												  <th width="100">Order <button type="submit" name="sbt_order" value="Save" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-save"></i></button></th>
												  <th width="150">Actions</th>
												</tr>
											  </thead>
											  <tbody>
												<?php
												$num_rows = mysqli_num_rows($query);
												if($num_rows>0) {
													while($settings_data=mysqli_fetch_assoc($query)) { ?>
														<tr>
															<td>
																<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
																	<input class="m-checkable sub_chk" type="checkbox" onclick="clickontoggle('<?=$settings_data['id']?>');" name="chk[]" value="<?=$settings_data['id']?>">
																	<span></span>
																</label>
															</td>
															<td>
																<?=ucwords(str_replace("_"," ",$settings_data['section_name']))?>
															</td>
															<td>
																<?=$settings_data['title']?>
															</td>
															<td>
																<?php
																if($settings_data['type']) {
																	echo ucwords(str_replace("_"," ",$settings_data['type']));
																} else {
																	echo 'Custom';
																} ?>
															</td>
															<td>
																<input type="text" class="form-control m-input m-input--square" id="ordering<?=$settings_data['id']?>" value="<?=$settings_data['ordering']?>" name="ordering[<?=$settings_data['id']?>]">
															</td>
															<td style="width: 200px">
																<a href="edit_home_settings.php?id=<?=$settings_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
																<?php
																if($settings_data['type']!="inbuild") { ?>
																	<a href="controllers/home_settings.php?d_id=<?=$settings_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to delete this record?')"><i class="la la-trash"></i></a>
																<?php
																}
																if($settings_data['status']==1) {
																	echo '<a href="controllers/home_settings.php?p_id='.$settings_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Active</button></a>';
																} elseif($settings_data['status']==0) {
																	echo '<a href="controllers/home_settings.php?p_id='.$settings_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Inactive</button></a>';
																} ?>
															</td>
														</tr>
													<?php
													}
												} ?>
											  </tbody>
											</table>
								
											<?php
											echo $pages->page_links(); ?>
										</div>
									  </div>
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

<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.searchbx').on('click', function(e) {
      var val = document.getElementById("filter_by").value;
      if (val == "") {
        alert('Please enter Name, Email or Phone');
        return false;
      }
    });

    $('.bulk_remove').on('click', function(e) {
      var ids = document.getElementById("ids").value;
      if (ids == "") {
        alert('Please first make a selection from the list.');
        return false;
      } else {
        var Ok = confirm("Are you sure to delete this record(s)?");
        if (Ok == true) {
          return true;
        } else {
          return false;
        }
      }
    });

    $('#chk_all').on('click', function(e) {
      if ($(this).is(':checked', true)) {
        $(".sub_chk").prop('checked', true);
        var values = new Array();
        $.each($("input[name='chk[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#ids').val(values);
      } else {
        $(".sub_chk").prop('checked', false);
        var values = new Array();
        $.each($("input[name='chk[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#ids').val(values);
      }
    });

    $('.sub_chk').on('click', function(e) {
      if ($(this).is(':checked', true)) {
        var values = new Array();
        $.each($("input[name='chk[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#ids').val(values);
      } else {
        var values = new Array();
        $.each($("input[name='chk[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#ids').val(values);
      }
    });
  });

  function clickontoggle(id) {
    jQuery(document).ready(function($) {
      if ($(this).is(':checked', true)) {
        var values = new Array();
        $.each($("input[name='chk[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#ids').val(values);
      } else {
        var values = new Array();
        $.each($("input[name='chk[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#ids').val(values);
      }
    });
  }
</script>
