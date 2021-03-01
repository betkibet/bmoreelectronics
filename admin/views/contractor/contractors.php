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
                  Contractor(s)
                </h3>
              </div>
            </div>
			<div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
			  	<?php
				if($prms_customer_add == '1') { ?>
                <li class="m-portlet__nav-item">
                  <a href="edit_contractor.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                          <input type="search" class="form-control m-input" placeholder="Name or Email or Phone" name="filter_by" id="filter_by" value="<?=_dt_parse($post['filter_by'])?>" autocomplete="nope">
                          <button class="btn btn-alt btn-primary ml-2 searchbx" name="search" type="submit">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="") {
          					echo '<a href="contractors.php?clear" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <?php
			  if($prms_customer_delete == '1') { ?>
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/contractor.php" method="POST">
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
						<th>Email</th>
						<th>Assign Orders</th>
						<th>Company</th>
						<th>Date</th>
						<th width="220">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$num_rows = mysqli_num_rows($contractor_query);
					if($num_rows>0) {
						while($customer_data=mysqli_fetch_assoc($contractor_query)) {
							$order_reports_data = get_order_reports(0, $customer_data['id']);
							$statastics_arr = array(
									'Awaiting'=>array('nums'=>$order_reports_data['num_of_awaiting_orders'],'file_nm'=>"awaiting_orders.php"),
									'Unpaid'=>array('nums'=>$order_reports_data['num_of_unpaid_orders'],'file_nm'=>"orders.php"),
									'Paid'=>array('nums'=>$order_reports_data['num_of_paid_orders'],'file_nm'=>"paid_orders.php"),
									'Archive'=>array('nums'=>$order_reports_data['num_of_archive_orders'],'file_nm'=>"archive_orders.php")
							); ?>
							<tr>
								<td>
								  <label class="m-checkbox m-checkbox--brand m-checkbox--single m-checkbox--solid">
									<input type="checkbox" onclick="clickontoggle('<?=$customer_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$customer_data['id']?>">
									<span></span>
								  </label>
								</td>
								<td><?=$customer_data['name']?></td>
								<td><?=$customer_data['email']?></td>
								<td>
								<?php
								foreach($statastics_arr as $statastics_k=>$statastics_v_d) {
									if($statastics_v_d['nums']>0) {
										echo '<b>'.$statastics_k.':</b> <a href="'.$statastics_v_d['file_nm'].'?contractor_id='.$customer_data['id'].'">'.$statastics_v_d['nums'].'</a><br>';
									}
								} ?>
								</td>
								<td><?=$customer_data['company_name']?></td>
								<td><?=format_date($customer_data['date'])?></td>
								<td Width="220">
								<?php
								if($customer_data['status']==1) {
									echo '<a href="controllers/contractor.php?p_id='.$customer_data['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Active</button></a>';
								} elseif($customer_data['status']==0) {
									echo '<a href="controllers/contractor.php?p_id='.$customer_data['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Inactive</button></a>';
								}
								if($prms_customer_edit == '1') { ?>
								<a href="edit_contractor.php?id=<?=$customer_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
								<?php
								}
								if($prms_customer_delete == '1') { ?>
								<a href="controllers/contractor.php?d_id=<?=$customer_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('are you sure to delete this record?')"><i class="la la-trash"></i></a>
								<?php
								} ?>
							</td>
							</tr>
                      	<?php 
					  	}
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
function check_form(a){
	if(a.filter_by.value.trim()==""){
		alert('Please enter Name, Email or Phone');
		a.filter_by.focus();
		return false;
	}
}
</script>

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
