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
                  Mobile Models
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="bulk_add_product.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                    <span>
                      <i class="la la-plus"></i>
                      <span>
                        Add New
                      </span>
                    </span>
                  </a>
                </li>
                <?php /*?><li class="m-portlet__nav-item">
                  <form action="controllers/mobile.php" method="POST">
                    <input type="hidden" name="ids" id="ids" value="">
                    <button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove">
                      <span>
                        <i class="la la-remove"></i>
                        <span>
                			Bulk Remove
                        </span>
                      </span>
                    </button>
                  </form>
                </li><?php */?>
              </ul>
            </div>
          </div>
          <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
			
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/bulk_upload.php" method="POST">
						
					</form>
						<div></div>
				</div>
			  </div>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/bulk_upload.php" method="post">
                    <input type="hidden" name="ids" id="ids" value="">

            <button class="btn btn-sm btn-success m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_edit_save" name="bulk_edit_save">Save</button>
                    <table class="table table-striped table-bordered  table-hover table-checkable dataTable dtr-inline" <?php /*?>id="m_table_1"<?php */?>>
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <th>Title</th>
            						  <th>Carrier</th>
            						  <th>Capacity</th>
                          <th>Offer New</th>
                          <th>Offer Mint</th>
                          <th>Offer Good</th>
                          <th>Offer Fair</th>
                          <th>Offer Broken</th>
                          <th>Offer Damaged</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($device_data=mysqli_fetch_assoc($query)) {?>
                        <tr>
                          <input type="hidden" name="mobile_id[]" value="<?=$device_data['id']?>">
                          <td>
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand m-checkbox--single">
                              <input type="checkbox" onclick="clickontoggle('<?=$device_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$device_data['id']?>">
                              <span></span>
                            </label>
                          </td>
                            <td>
                              <input type="text" class="form-control m-input" id="title" value="<?=$device_data['title']?>" name = "title[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="carrier_title" value="<?=$device_data['carrier_title']?>" name = "carrier_title[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="storage_capacity" value="<?=$device_data['storage_capacity']?>" name = "storage_capacity[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="offer_new" value="<?=$device_data['offer_new']?>" name = "offer_new[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="offer_mint" value="<?=$device_data['offer_mint']?>" name = "offer_mint[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="offer_good" value="<?=$device_data['offer_good']?>" name = "offer_good[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="offer_fair" value="<?=$device_data['offer_fair']?>" name = "offer_fair[]"> 
                            </td>
                            <td>
                              <input type="text" class="m-input--square form-control m-input" id="offer_broken" value="<?=$device_data['offer_broken']?>" name = "offer_broken[]"> 
                            </td>
              							<td>
                              <input type="text" class="m-input--square form-control m-input" id="offer_damaged" value="<?=$device_data['offer_damaged']?>" name = "offer_damaged[]"> 
                            </td>
        				  
                        </tr>
                        <?php }
                        }?>
                      </tbody>
                    </table>
                  </form>
                </div>
              </div>
              <?php echo $pages->page_links(); ?>
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
		var cat_id = document.getElementById("cat_id").value;
		var brand_id = document.getElementById("brand_id").value;
		var device_id = document.getElementById("device_id").value;
		if(val.trim()=="" && cat_id=="" && brand_id=="" && device_id=="") {
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

  $('.bulk_edit_save').on('click', function(e) {
    var ids = document.getElementById("ids").value;
    if(ids=="") {
      alert('Please first make a selection from the list.');
      return false;
    } else {
      var Ok = confirm("Are you sure to edit this record(s)?");
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

$(document).ready(function() {
jQuery('#export-to-csv').bind("click", function() {
var target = $(this).attr('id');
switch(target) {
	case 'export-to-csv' :
	$('#hidden-type').val(target);
	//alert($('#hidden-type').val());
	$('#export-form').submit();
	$('#hidden-type').val('');
	break
}
});
    });

</script>
