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
                  Locations
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
			    <?php
				//if($prms_order_add == '1') { ?>
                <li class="m-portlet__nav-item">
                  <a href="edit_location.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                    <span>
                      <i class="la la-plus"></i>
                      <span>
                        Add New
                      </span>
                    </span>
                  </a>
                </li>
				<?php
				//} ?>
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
                          <input type="search" class="form-control m-input" placeholder="Name" name="filter_by" id="filter_by" value="<?=_dt_parse($post['filter_by'])?>" autocomplete="nope">
						  	
                          <button class="btn btn-alt btn-primary ml-2 searchbx" name="search" type="submit">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="") {
          					echo '<a href="location.php?clear" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <?php
			  //if($prms_order_delete == '1') { ?>
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/location.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  <?php
			  //} ?>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/location.php" method="post">
                    <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <th>
						  <?php
						  if($post['name_shorting'] == "asc") { ?>
							<a href="?name_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">Location <?=($post['name_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
						  <?php
						  } elseif($post['name_shorting'] == "desc" || $post['name_shorting'] == "") { ?>
							<a href="?name_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">Location <?=($post['name_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
						  <?php
						  } ?>
                          </th>
						  <th>
						  	Address
						  </th>
						  <th>
						  	City
						  </th>
						  <th>
						  	Zipcode
						  </th>
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
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						$num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($location_data=mysqli_fetch_assoc($query)) {?>
                        <tr>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                              <input type="checkbox" onclick="clickontoggle('<?=$location_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$location_data['id']?>">
                              <span></span>
                            </label>
                          </td>
                          <td>
							<?=$location_data['name']?>
						  </td>
                          <td>
                            <?=$location_data['address']?>
                          </td>
						  <td>
                            <?=$location_data['city']?>
                          </td>
						  <td>
                            <?=$location_data['zipcode']?>
                          </td>
                          <td>
                            <input type="text" class="m-input--square form-control m-input" id="ordering<?=$location_data['id']?>" value="<?=$location_data['ordering']?>" name="ordering[<?=$location_data['id']?>]">
                          </td>
                          <td Width="220">
                            <?php
							if($location_data['published']==1) {
								echo '<a href="controllers/location.php?p_id='.$location_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Published</button></a>';
							} elseif($location_data['published']==0) {
								echo '<a href="controllers/location.php?p_id='.$location_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Unpublished</button></a>';
							}
							
							//if($prms_order_edit == '1') { ?>
                            <a href="edit_location.php?id=<?=$location_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
							<?php
							//}
							//if($location_data['type']!="fixed") {
								if($prms_order_delete == '1') { ?>
								<a href="controllers/location.php?d_id=<?=$location_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('are you sure to delete this record?')"><i class="la la-trash"></i></a>
								<?php
								}
							//} ?>
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
			alert('Please enter name');
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