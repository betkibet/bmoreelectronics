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
                  Devices
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
			    <?php
				if($prms_device_add == '1') { ?>
                <li class="m-portlet__nav-item">
                  <a href="edit_device.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
			  
			  <div class="row">
                <div class="col-sm-12">
                  <div id="m_table_1_filter" class="dataTables_filter float-left">
                    <form method="post">
                        <div class="input-group">
                          <input type="search" class="form-control m-input" placeholder="Title" name="filter_by" id="filter_by" value="<?=_dt_parse($post['filter_by'])?>" autocomplete="nope">
						  	
                          <button class="btn btn-alt btn-primary ml-2 searchbx" name="search" type="submit">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="") {
          					echo '<a href="device.php?clear" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <?php
			  if($prms_device_delete == '1') { ?>
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/device.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  <?php
			  } ?>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/device.php" method="post">
                    <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline" <?php /*?>id="m_table_1"<?php */?>>
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <th class="text-center" width="150" align="center">
                            Image
                          </th>
						  <th class="text-center" width="150" align="center">
                            Icon
                          </th>
                          <th>
							  <?php
							  if($post['title_shorting'] == "asc") { ?>
								<a href="?title_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">Title <?=($post['title_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
							  <?php
							  } elseif($post['title_shorting'] == "desc" || $post['title_shorting'] == "") { ?>
								<a href="?title_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">Title <?=($post['title_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
							  <?php
							  } ?>
                          </th>
						  <?php /*?><th>
                            Brand
                          </th><?php */?>
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
                          <th width="220">
                            Actions
                          </th>
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
                          <td class="text-center">
							<?php 
							if($device_data['device_img']) {
								echo '<img src="../images/device/'.$device_data['device_img'].'" width="80" />';
							} ?>
						  </td>
						  <td class="text-center">
							<?php 
							if($device_data['device_icon']) {
								echo '<img src="../images/device/'.$device_data['device_icon'].'" width="50" />';
							} ?>
						  </td>
                          <td>
                            <?=$device_data['title']?>
                          </td>
						  <?php /*?><td>
                            <?php
							if($device_data['brand_title']!="") {
								echo '<a href="edit_brand.php?id='.$device_data['brand_id'].'">'.$device_data['brand_title'].'</a>';
							} ?>
                          </td><?php */?>
                          <td>
                            <input type="text" class="m-input--square form-control m-input" id="ordering<?=$device_data['id']?>" value="<?=$device_data['ordering']?>" name="ordering[<?=$device_data['id']?>]">
                          </td>
                          <td Width="190">
                            <?php
							if($device_data['published']==1) {
								echo '<a href="controllers/device.php?p_id='.$device_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Published</button></a>';
							} elseif($device_data['published']==0) {
								echo '<a href="controllers/device.php?p_id='.$device_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Unpublished</button></a>';
							}
							if($prms_device_edit == '1') { ?>
                            <a href="edit_device.php?id=<?=$device_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
							<?php
							}
							if($prms_device_delete == '1') { ?>
        					<a href="controllers/device.php?d_id=<?=$device_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('are you sure to delete this record?')"><i class="la la-trash"></i></a>
							<?php
							} ?>
							<a href="controllers/device.php?c_id=<?=$device_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to copy this device?')"><i class="la la-copy"></i></a>
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

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		if(val=="") {
			alert('Please enter title');
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
