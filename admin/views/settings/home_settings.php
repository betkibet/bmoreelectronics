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
									  <th width="100">Order <button type="submit" name="sbt_order" value="Save" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-save"></i></button></th>
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
										<!-- <input type="checkbox" onclick="clickontoggle('<?=$settings_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$settings_data['id']?>"> -->
										<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
										<input value="" class="m-checkable sub_chk" type="checkbox" onclick="clickontoggle('<?=$settings_data['id']?>');" name="chk[]" value="<?=$settings_data['id']?>">
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
										<?=ucwords(str_replace("_"," ",$settings_data['type']))?>
									  </td>
									  <td>
										<input type="text" class="form-control m-input m-input--square" id="ordering<?=$settings_data['id']?>" value="<?=$settings_data['ordering']?>" name="ordering[<?=$settings_data['id']?>]">
									  </td>
									  <td style="width: 200px">
										<a href="edit_home_settings.php?id=<?=$settings_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>
										<?php
														if($settings_data['type']!="inbuild") { ?>
										  <a href="controllers/home_settings.php?d_id=<?=$settings_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
										  <?php
														}
														if($settings_data['status']==1) {
															echo '<a href="controllers/home_settings.php?p_id='.$settings_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Active</button></a>';
														} elseif($settings_data['status']==0) {
															echo '<a href="controllers/home_settings.php?p_id='.$settings_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Inactive</button></a>';
														}
														?>
									  </td>
									</tr>
									<?php
												}
											} ?>
								  </tbody>
								</table>
													<!-- <div class="form-group m-form__group">
														<label for="field-1">
									Title :
								  </label>
														<input type="text" class="form-control m-input" id="first_name" value="<?=$brand_data['title']?>" name="title">
													</div> -->
													<!-- <div class="form-group m-form__group">
														<label for="fa_icon">Fa Icon :</label>
														<select class="form-control m-input" name="fa_icon" id="fa_icon">
															<option value=""> -Select- </option>
															<?php
															foreach($fa_icon_list as $fa_icon_k=>$fa_icon_val) { ?>
															<option value="<?=$fa_icon_val?>" <?php if($brand_data['fa_icon']==$fa_icon_val){echo 'selected="selected"';}?>><?=ucwords(str_replace(array("fa-","-"),array(""," "),$fa_icon_val))?></option>
															<?php
															} ?>
														</select>
													</div> -->
													<!-- <div class="form-group m-form__group">
														<label for="exampleTextarea">
															Description :
														</label>
														<textarea class="form-control m-input" id="exampleTextarea" name="description" rows="5"><?=$brand_data['description']?></textarea>
													</div> -->
													<!-- <div class="m-form__group form-group">
														<label for="">
															Publish :
														</label>
														<div class="m-radio-inline">
															<label class="m-radio">
																<input type="radio" id="published" name="published" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($brand_data['published']==1?'checked="checked"':'')?>>
																Yes
																<span></span>
															</label>
															<label class="m-radio">
																<input type="radio"  id="published" name="published" value="0" <?=($brand_data['published']=='0'?'checked="checked"':'')?>>
																No
																<span></span>
															</label>
														</div>
													</div> -->
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

<!-- <div id="wrapper">
  <header id="header" class="container">
    <?php/* require_once("include/admin_menu.php"); ?>
  </header>

  <section class="container" role="main">
    <div class="row">
      <article class="span12 data-block">
        <header>
          <h2>Home Page Settings</h2>
          <ul class="data-header-actions">
            <li><a href="edit_home_settings.php">Add New</a></li>
          </ul>
        </header>
        <section>
          <?php require_once('confirm_message.php');?>

          <form action="controllers/home_settings.php" method="POST">
            <div class="control-group">
              <div class="controls">
                <input type="hidden" name="ids" id="ids" value="">
                <button class="btn btn-alt btn-danger bulk_remove" name="bulk_remove">Bulk Remove</button>
              </div>
            </div>
          </form>

          <div id="table_pagination_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <form action="controllers/home_settings.php" method="post">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="10"><input type="checkbox" id="chk_all"></th>
                    <th width="110">Section Name</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th width="30">Order <input type="submit" name="sbt_order" value="Save" class="btn btn-alt"></th>
                    <th width="200">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($settings_data=mysqli_fetch_assoc($query)) { ?>
                  <tr>
                    <td><input type="checkbox" onclick="clickontoggle('<?=$settings_data['id']?>');" class="sub_chk" name="chk[]" value="<?=$settings_data['id']?>"></td>
                    <td>
                      <?=ucwords(str_replace("_"," ",$settings_data['section_name']))?>
                    </td>
                    <td>
                      <?=$settings_data['title']?>
                    </td>
                    <td>
                      <?=ucwords(str_replace("_"," ",$settings_data['type']))?>
                    </td>
                    <td>
                      <input type="text" class="input-small" id="ordering<?=$settings_data['id']?>" value="<?=$settings_data['ordering']?>" name="ordering[<?=$settings_data['id']?>]">
                    </td>
                    <td>
                      <a href="edit_home_settings.php?id=<?=$settings_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
                      <?php
										if($settings_data['type']!="inbuild") { ?>
                        <a href="controllers/home_settings.php?d_id=<?=$settings_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
                        <?php
										}
										if($settings_data['published']==1) {
											echo '<a href="controllers/home_settings.php?p_id='.$settings_data['id'].'&published=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Active</button></a>';
										} elseif($settings_data['published']==0) {
											echo '<a href="controllers/home_settings.php?p_id='.$settings_data['id'].'&published=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Inactive</button></a>';
										}
										?>
                    </td>
                  </tr>
                  <?php
								}
							} ?>
                </tbody>
              </table>
            </form>
            <?php
					echo $pages->page_links(); */?>
          </div>
        </section>
      </article>
    </div>
  </section>
  <div id="push"></div>
</div> -->

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
