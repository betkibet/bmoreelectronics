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
      <div class="m-content">
        <?php require_once('confirm_message.php');?>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                  Models
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
			    <?php
				if($prms_model_add == '1') { ?>
                <li class="m-portlet__nav-item">
                  <a href="edit_mobile.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                    <span>
                      <i class="la la-plus"></i>
                      <span>
                        Add New
                      </span>
                    </span>
                  </a>
                </li>
				<?php
				} ?>
              </ul>
            </div>
          </div>
          <div class="m-portlet__body">
		  
			<form method="post">
				<div class="form-group row">
					<div class="col-lg-2">
						<input type="text" class="form-control m-input" placeholder="Search By Title" name="filter_by" id="filter_by" value="<?=_dt_parse($post['filter_by'])?>" autocomplete="nope" maxlength="255">
					</div>
					<div class="col-lg-2">
						<select name="field_type" id="field_type" class="form-control m-input custom-select">
							<option value=""> - Select Type - </option>
							<option value="mobile" <?php if("mobile"==$post['field_type']){echo 'selected="selected"';}?>>Mobile</option>
							<option value="tablet" <?php if("tablet"==$post['field_type']){echo 'selected="selected"';}?>>Tablet</option>
							<option value="watch" <?php if("watch"==$post['field_type']){echo 'selected="selected"';}?>>Watch</option>
							<option value="laptop" <?php if("laptop"==$post['field_type']){echo 'selected="selected"';}?>>Laptop</option>
							<option value="other" <?php if("other"==$post['field_type']){echo 'selected="selected"';}?>>Other</option>
						</select>
					</div>
					<div class="col-lg-2">
						<select name="cat_id" id="cat_id" class="form-control m-input custom-select">
							<option value=""> - Select Category - </option>
							<?php
							while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
								<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$post['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
							<?php
							} ?>
						</select>
					</div>
					<div class="col-lg-2">
						<select name="brand_id" id="brand_id" class="form-control m-input custom-select">
							<option value=""> - Select Brand - </option>
							<?php
							while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
								<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$post['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
							<?php
							} ?>
						</select>
					</div>
					<div class="col-lg-2">		
						<select name="device_id" id="device_id" class="form-control m-input custom-select">
							<option value=""> - Select Device - </option>
							<?php
							while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
								<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$post['device_id']){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
							<?php
							} ?>
						</select>
					</div>
					<div class="col-lg-2">
						<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Search <i class="la la-search"></i></button>
						<?php
						if($post['filter_by'] || $post['cat_id'] || $post['brand_id'] || $post['device_id'] || $post['field_type']) {
							echo '<a href="mobile.php?clear" class="btn btn-alt btn-danger ml-2 mt-2">Clear <i class="la la-remove"></i></a>';
						} ?>
					</div>
				</div>
			</form>
					
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
			
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/mobile.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<input type="hidden" name="cat_id" value="<?=$post['cat_id']?>">
						<input type="hidden" name="brand_id" value="<?=$post['brand_id']?>">
						<input type="hidden" name="device_id" value="<?=$post['device_id']?>">
						<input type="hidden" name="filter_by" value="<?=$post['filter_by']?>">
						<input type="hidden" name="field_type" value="<?=$post['field_type']?>">
						
						<?php
						if($prms_model_delete == '1') { ?>
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
						<?php
						} ?>
						<button class="btn btn-sm btn-accept m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" type="button" onclick="ExportModal();return false;" name="import"><span><i class="la la-download"></i><span> Import</span></span></button>
						<?php
						if($post['cat_id']) { ?>
						<button class="btn btn-sm btn-info m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" name="export"><span><i class="la la-upload"></i><span> Export</span></span></button>
						<?php
						} ?>
						
						<button class="btn btn-sm btn-accept m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" type="button" onclick="ImportMetaModal();return false;"><i class="la la-download"></i> Import Meta</button>
						<button class="btn btn-sm btn-info m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" type="submit" name="export_meta"><i class="la la-upload"></i> Export Meta</button>				
					</form>
				</div>
			  </div>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/mobile.php" method="post">
				  
				  	<input type="hidden" name="cat_id" value="<?=$post['cat_id']?>">
					<input type="hidden" name="brand_id" value="<?=$post['brand_id']?>">
					<input type="hidden" name="device_id" value="<?=$post['device_id']?>">
					<input type="hidden" name="filter_by" value="<?=$post['filter_by']?>">
					<input type="hidden" name="field_type" value="<?=$post['field_type']?>">
					
                    <table class="table table-bordered table-hover table-checkable dataTable dtr-inline" <?php /*?>id="m_table_1"<?php */?>>
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <th width="110">Icon</th>
						  <th width="50">
						  <?php
						  if($post['id_shorting'] == "asc") { ?>
							<a href="?id_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">ID <?=($post['id_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
						  <?php
						  } elseif($post['id_shorting'] == "desc" || $post['id_shorting'] == "") { ?>
							<a href="?id_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">ID <?=($post['id_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
						  <?php
						  } ?>
						  </th>
                          <th width="200">
						  <?php
						  if($post['title_shorting'] == "asc") { ?>
							<a href="?title_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">Title <?=($post['title_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
						  <?php
						  } elseif($post['title_shorting'] == "desc" || $post['title_shorting'] == "") { ?>
							<a href="?title_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">Title <?=($post['title_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
						  <?php
						  } ?>
						  </th>
						  <th>Category / Brand / Device</th>
						  <?php
						  if($post['device_id']) { ?>
                          <th width="100">
							  <?php
							  if($post['oid_shorting'] == "asc") { ?>
								<a href="?oid_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">Order <?=($post['oid_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
							  <?php
							  } elseif($post['oid_shorting'] == "desc" || $post['oid_shorting'] == "") { ?>
								<a href="?oid_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">Order <?=($post['oid_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
							  <?php
							  } ?>
                              <button type="submit" name="sbt_order" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-save"></i></button>
                          </th>
						  <?php
						  } ?>
                          <th width="220">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($device_data=mysqli_fetch_assoc($query)) {?>
                        <tr>
                          <td>
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand m-checkbox--single">
                              <input type="checkbox" onclick="clickontoggle('<?=$device_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$device_data['id']?>">
                              <span></span>
                            </label>
                          </td>
                          <td>
							<?php 
							if($device_data['model_img']) {
								echo '<img src="../images/mobile/'.$device_data['model_img'].'" width="100" />';
							} ?>
						  </td>
						  <td>
						    <?=$device_data['id']?>
                          </td>
							<td><a href="edit_mobile.php?id=<?=$device_data['id']?>"><?=$device_data['title']?></a></td>
							<td>
							<?php
							$cat_brand_dev_title = '';
							if($device_data['cat_title']!="") {
								$cat_brand_dev_title .= '<a href="edit_category.php?id='.$device_data['cat_id'].'">'.$device_data['cat_title'].'</a> / ';
							} else {
								$cat_brand_dev_title .= ' - / ';
							}
							if($device_data['brand_title']!="") {
								$cat_brand_dev_title .= '<a href="edit_brand.php?id='.$device_data['brand_id'].'">'.$device_data['brand_title'].'</a> / ';
							} else {
								$cat_brand_dev_title .= ' - / ';
							}
							if($device_data['device_title']!="") {
								$cat_brand_dev_title .= '<a href="edit_device.php?id='.$device_data['device_id'].'">'.$device_data['device_title'].'</a>';
							} else {
								$cat_brand_dev_title .= ' - ';
							}
							echo $cat_brand_dev_title; ?>
							</td>
						  <?php
						  if($post['device_id']) { ?>
                          <td>
                            <input type="text" class="m-input--square form-control m-input" id="ordering<?=$device_data['id']?>" value="<?=$device_data['ordering']?>" name="ordering[<?=$device_data['id']?>]">
                          </td>
						  <?php
						  } ?>
                          <td Width="190">
                            <?php
							if($device_data['published']==1) {
								echo '<a href="controllers/mobile.php?p_id='.$device_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Published</button></a>';
							} elseif($device_data['published']==0) {
								echo '<a href="controllers/mobile.php?p_id='.$device_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Unpublished</button></a>';
							}
							
							if($prms_model_edit == '1') { ?>
                            <a href="edit_mobile.php?id=<?=$device_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
							<?php
							}
							if($prms_model_delete == '1') { ?>
        					<a href="controllers/mobile.php?d_id=<?=$device_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to delete this record?')"><i class="la la-trash"></i></a>
							<?php
							} ?>
							<a href="controllers/mobile.php?c_id=<?=$device_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to copy this model?')"><i class="la la-copy"></i></a>
                          </td>
                        </tr>
                        <?php }
                        } ?>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
              <?php
			  $current_url_params = get_all_get_params();
			  $current_url_params = ($current_url_params?$current_url_params.'&':'?');
			  echo $pages->page_links($current_url_params); ?>
            </div>
          </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
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

<div class="modal fade" id="export_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Model(s) Import</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/mobile.php" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group">
					<label for="recipient-name" class="form-control-label">Select File</label>
					<input type="file" class="form-control" id="file_name" name="file_name">
				</div>
				<div class="form-group">
					<label>Choose Type To Download Sample File</label>
					<div class="controls">
						<select name="cat_d_type" id="cat_d_type" class="form-control" style="width:100px; display:inline;">
							<option value="mobile">Mobile</option>
							<option value="tablet">Tablet</option>
							<option value="watch">Watch</option>
							<option value="laptop">Laptop</option>
							<option value="other">Other</option>
						</select>

						<a href="sample_files/models-mobile-sample-file.csv" class="btn btn-md btn-success sample_file_d_link" style="margin-left:3px;"><i class="la la-download"></i> Download Sample File</a>
					</div>
				</div>
				
				<div class="form-group">
					<!--<a href="sample_files/sample_file.csv" class="btn btn-sm btn-success"><i class="la la-download"></i> Download Sample File</a>
					<br />-->
					<small>Models icon you need to upload in this folder by FTP/Cpanel (<?=CP_ROOT_PATH?>/images/mobile)</small>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="import">IMPORT</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="import_meta_modal" tabindex="-1" role="dialog" aria-labelledby="import_meta_modal_lbl" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="import_meta_modal_lbl">Model(s) Meta Import</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/mobile.php" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Select File</label>
						<input type="file" class="form-control" id="file_name" name="file_name">
					</div>
					<div class="form-group">
						<a href="sample_files/sample_file_for_meta.csv" class="btn btn-md btn-success"><i class="la la-download"></i> Download Sample File</a>
						<br />
						<small>Models icon you need to upload in this folder by FTP/Cpanel (<?=CP_ROOT_PATH?>/images/mobile)</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="import_meta">IMPORT</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
function ExportModal() {
	jQuery(document).ready(function($) {
		$('#export_modal').modal({backdrop: 'static',keyboard: false});
	});
}

function ImportMetaModal() {
	jQuery(document).ready(function($) {
		$('#import_meta_modal').modal({backdrop: 'static',keyboard: false});
	});
}

jQuery(document).ready(function($) {
	$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		var cat_id = document.getElementById("cat_id").value;
		var brand_id = document.getElementById("brand_id").value;
		var device_id = document.getElementById("device_id").value;
		var field_type = document.getElementById("field_type").value;
		if(val.trim()=="" && cat_id=="" && brand_id=="" && device_id=="" && field_type=="") {
			alert('Please enter Title or Select value from dropdowns');
			return false;
		}
	});

	$('.bulk_remove').on('click', function(e) {
		var ids = document.getElementById("ids").value;
		if(ids=="") {
			alert('Please first make a selection from the list.');
			return false;
		} else {
			var Ok = confirm("Are you sure to delete this record(s)?");
			if(Ok == true) {
				return true;
			} else {
				return false;
			}
		}
	});

	$('#chk_all').on('click', function(e) {
		if($(this).is(':checked',true)) {
			$(".sub_chk").prop('checked', true);
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
				values.push($(this).val());
			});
			$('#ids').val(values);
		} else {
			$(".sub_chk").prop('checked',false);
			var values = new Array();
			$.each($("input[name='chk[]']:checked"), function() {
				values.push($(this).val());
			});
			$('#ids').val(values);
		}
	});

	$('.sub_chk').on('click', function(e) {
		if($(this).is(':checked',true)) {
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
	
	$("#cat_d_type").on('change', function(e) {
		var val = $(this).val();
		
		var sample_file_path;

		if(val == "mobile") {
			sample_file_path = "sample_files/models-mobile-sample-file.csv";
		}
		if(val == "tablet") {
			sample_file_path = "sample_files/models-tablet-sample-file.csv";
		}
		if(val == "watch") {
			sample_file_path = "sample_files/models-watch-sample-file.csv";
		}
		if(val == "laptop") {
			sample_file_path = "sample_files/models-laptop-sample-file.csv";
		}
		if(val == "other") {
			sample_file_path = "sample_files/models-other-sample-file.csv";
		}
		if(sample_file_path) {
			$(".sample_file_d_link").show();
			$(".sample_file_d_link").attr("href", sample_file_path);
		} else {
			$(".sample_file_d_link").hide();
			$(".sample_file_d_link").attr("href", "");
		}
	});
	
});

function clickontoggle(id) {
	jQuery(document).ready(function($){
		if($(this).is(':checked',true)) {
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
