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
                  Affiliate List
                </h3>
              </div>
            </div>
            <?php /*?><div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <form action="controllers/affiliate.php" method="POST">
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
                </li>
              </ul>
            </div><?php */?>
          </div>
          <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
			
			  <div class="row">
				<div class="col-sm-12">
					<form action="controllers/affiliate.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  
              <div class="row">
                <div class="col-sm-12" style="overflow:scroll;">
                  <table class="table table-bordered table-hover table-checkable dataTable dtr-inline">
                    <thead>
                      <tr>
                        <th width="10">
                          <label class="m-checkbox m-checkbox--brand m-checkbox--solid m-checkbox--single">
                            <input type="checkbox" id="chk_all" class="m-input">
                            <span></span>
                          </label>
                        </th>
                        <th>Name</th>
						<th>Company</th>
						<th>Web Address</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Subject</th>
						<th>Message</th>
						<th>Date/Time</th>
						<th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
					  $num_rows = mysqli_num_rows($query);
                      if($num_rows>0) {
                        while($affiliate_data=mysqli_fetch_assoc($query)) {?>
						  <tr>
							<td>
							  <label class="m-checkbox m-checkbox--brand m-checkbox--single m-checkbox--solid">
								<input type="checkbox" onclick="clickontoggle('<?=$affiliate_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$affiliate_data['id']?>">
								<span></span>
							  </label>
							</td>
							<td><?=$affiliate_data['name']?></td>
							<td><?=$affiliate_data['company']?></td>
							<td><?=$affiliate_data['web_address']?></td>
							<td><?=$affiliate_data['phone']?></td>
							<td><?=$affiliate_data['email']?></td>
							<td><?=$affiliate_data['subject']?></td>
							<td><?=$affiliate_data['message']?></td>
							<td><?=date('m/d/Y H:i A',strtotime($affiliate_data['date']))?></td>
							<td>
								<a href="controllers/affiliate.php?d_id=<?=$affiliate_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
							</td>
						  </tr>
                      	<?php 
					  	}
                      } ?>
                    </tbody>
                  </table>
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
		if(val=="") {
			alert('Please enter Name, Email or Phone');
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
