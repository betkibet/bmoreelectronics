<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
  <!-- BEGIN: Header -->
  <?php include("include/admin_menu.php"); ?>
  <!-- END: Header -->

  <!-- begin::Body -->
  <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body main_top_section">
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
                  Archive Orders
                </h3>
              </div>
            </div>
			<div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
			  	<?php
				if($prms_order_add == '1') { ?>
                <li class="m-portlet__nav-item">
                  <a href="add_order.php?order_mode=archive" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                        <div class="form-group row archive_orders">
							<div class="col-lg-3">
                          		<input type="search" class="form-control m-input" placeholder="Order ID, User Name" name="filter_by" id="filter_by" value="<?=_dt_parse($post['filter_by'])?>" autocomplete="nope">
						  	</div>
							<div class="col-lg-3">
						  		<input type="text" class="form-control m-input date-picker" placeholder="From Date" name="from_date" id="from_date" value="<?=_dt_parse($post['from_date'])?>" autocomplete="nope">
						  	</div>
							<div class="col-lg-3">
						  		<input type="text" class="form-control m-input date-picker" placeholder="To Date" name="to_date" id="to_date" value="<?=_dt_parse($post['to_date'])?>" autocomplete="nope">
						  	</div>
							<div class="col-lg-3">
							    <select name="status" id="status" class="form-control m-input custom-select">
									<option value=""> - Status - </option>
									<?php
									if(!empty($order_status_list)) {
										foreach($order_status_list as $order_status_data) { ?>
											<option value="<?=$order_status_data['id']?>" <?php if($post['status']==$order_status_data['id']){echo 'selected="selected"';}?>><?=$order_status_data['name']?></option>
										<?php
										}
									} ?>
								</select>
						  	</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-3">
							  <select name="is_payment_sent" id="is_payment_sent" class="form-control m-input custom-select">
								<option value=""> - Payment Status - </option>
								<option value="1" <?php if($post['is_payment_sent']=='1'){echo 'selected="selected"';}?>>Paid</option>
								<option value="0" <?php if($post['is_payment_sent']=='0'){echo 'selected="selected"';}?>>Unpaid</option>
							  </select>
							</div>
							<div class="col-lg-3">
							  <select name="payment_paid_batch_id" id="payment_paid_batch_id" class="form-control m-input custom-select">
								<option value=""> - Batch ID - </option>
								<?php
								while($order_paid_batch_data=mysqli_fetch_assoc($order_paid_batch_q)) { ?>
								<option value="<?=$order_paid_batch_data['payment_paid_batch_id']?>" <?php if($order_paid_batch_data['payment_paid_batch_id']==$post['payment_paid_batch_id']){echo 'selected="selected"';}?>><?=$order_paid_batch_data['payment_paid_batch_id']?></option>
								<?php
								} ?>
							  </select>
							</div>
							<div class="col-lg-4">
                          	  <button class="btn btn-alt btn-primary ml-2 searchbx" type="submit" name="search">Search <i class="la la-search"></i></button>
							  <?php
							  if($post['filter_by']!="" || $post['from_date']!="" || $post['to_date']!="" || $post['status']!="" || $post['is_payment_sent']!="" || $post['payment_paid_batch_id']!="") {
								echo '<a href="archive_orders.php?clear" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
							  } ?>
						  	</div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <?php
			  if($prms_order_delete == '1') { ?>
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/order/order.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<input type="hidden" name="order_mode" id="order_mode" value="archive">
						
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  <?php
			  } ?>
						
              <div class="row"> 
                <div class="col-sm-12">
                  <form method="post">
                    <table class="table table-bordered table-hover table-checkable dataTable dtr-inline table-responsive archive_table">
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
						  <th>Batch ID</th>
                          <th width="100">
						  <?php
						  if($post['oid_shorting'] == "asc") { ?>
							<a href="?oid_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">Order ID <?=($post['oid_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
						  <?php
						  } elseif($post['oid_shorting'] == "desc" || $post['oid_shorting'] == "") { ?>
							<a href="?oid_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">Order ID <?=($post['oid_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
						  <?php
						  } ?>
						  </th>
                          <th>Customer</th>
						  <th>Affiliate</th>
                          <th>
						  <?php
						  if($post['date_shorting'] == "asc") { ?>
							<a href="?date_shorting=desc<?=$url_params?>" title="<?=$shorting_label?>">Date <?=($post['date_shorting']!=''?'<i class="fas fa-caret-up"></i>':'')?></a>
						  <?php
						  } elseif($post['date_shorting'] == "desc" || $post['date_shorting'] == "") { ?>
							<a href="?date_shorting=asc<?=$url_params?>" title="<?=$shorting_label?>">Date <?=($post['date_shorting']!=''?'<i class="fas fa-caret-down"></i>':'')?></a>
						  <?php
						  } ?>
						  </th>
						  <th>Paid Date</th>
                          <!--<th>Approved Date</th>-->
                          <th>Price</th>
                          <th>Payment Method</th>
						  <th>Payment Status</th>
                          <th>Status</th>
						  <th>Lead</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $num_rows = mysqli_num_rows($order_query);
                        if($num_rows>0) {
                          while($order_data=mysqli_fetch_assoc($order_query)) {
                            $promocode_amt = 0;
                            $total_of_order = 0;

                            //Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
                            $sum_of_orders=get_order_price($order_data['order_id']);

                            if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
                              $promocode_amt = $order_data['promocode_amt'];
                              $total_of_order = $sum_of_orders+$order_data['promocode_amt'];
                            } else {
                              $total_of_order = $sum_of_orders;
                            }
							
							$express_service = $order_data['express_service'];
							$express_service_price = $order_data['express_service_price'];
							$shipping_insurance = $order_data['shipping_insurance'];
							$shipping_insurance_per = $order_data['shipping_insurance_per'];
							
							$f_express_service_price = 0;
							$f_shipping_insurance_price = 0;
							if($express_service == '1') {
								$f_express_service_price = $express_service_price;
							}
							if($shipping_insurance == '1') {
								$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
							}
							
							if($f_express_service_price>0 || $f_shipping_insurance_price>0) {
								$total_of_order = ($total_of_order - $f_express_service_price - $f_shipping_insurance_price);
							} ?>
                        <tr>
                          <td>
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand m-checkbox--single">
                              <input type="checkbox" onclick="clickontoggle('<?=$order_data['order_id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$order_data['order_id']?>">
                              <span></span>
                            </label>
                          </td>
						  <td><?=$order_data['payment_paid_batch_id']?></td>
                          <td><a href="edit_order.php?order_id=<?=$order_data['order_id']?>&order_mode=archive"><?=$order_data['order_id']?></a></td>
                          <td><?=$order_data['first_name'].' '.$order_data['last_name']?></td>
						  <td>
						  <?php
						  if($order_data['aflt_shop_name']!="") { ?>
						  <?=$order_data['aflt_shop_name']?>
						  <?php
						  } ?>
						  </td>
                          <td><?=format_date($order_data['date']).' '.format_time($order_data['date'])?></td>
						  <td><?=format_date($order_data['payment_sent_date']).' '.format_time($order_data['payment_sent_date'])?></td>
						  <!--<td><?=($order_data['approved_date']!='0000-00-00 00:00:00'?format_date($order_data['approved_date']):'')?></td>-->
                          <td><?=amount_fomat($total_of_order)?></td>
                          <td><?=replace_us_to_space_pmt_mthd($order_data['payment_method'])?></td>
						  <td>
							<?php
							if($order_data['is_payment_sent'] == '1') {
								echo 'Paid';
							} else {
								echo 'Unpaid';
							} ?>
						  </td>
                          <td>
                            <span class="m-badge m-badge--secondary m-badge--wide">
                              <?=replace_us_to_space($order_data['order_status_name'])?>
                            </span>
                          </td>
						  <td><?=replace_us_to_space($order_data['order_type'])?></td>
                          <td Width="150">
							<?php
							if($prms_order_edit == '1') { ?>
                            <a href="edit_order.php?order_id=<?=$order_data['order_id']?>&order_mode=archive" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
							<?php
							}
							if($prms_order_delete == '1') { ?>
                            <a href="controllers/order/order.php?d_id=<?=$order_data['order_id']?>&order_mode=archive" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure you want to delete this record?')"><i class="la la-trash"></i></a>
							<?php
							} ?>
                          </td>
                        </tr>
                        <?php }
                        } else {
							echo '<tr><td colspan="12" align="center">No Data Found</td></tr>';
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
		var from_date = document.getElementById("from_date").value;
		var to_date = document.getElementById("to_date").value;
		var status = document.getElementById("status").value;
		var is_payment_sent = document.getElementById("is_payment_sent").value;
		var payment_paid_batch_id = document.getElementById("payment_paid_batch_id").value;
		if(val=="" && from_date=="" && to_date=="" && status=="" && is_payment_sent=="" && payment_paid_batch_id=="") {
			alert('Please enter order id, user name or select value from date picker or select value from dropdown');
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
	
	$('.bulk_undo').on('click', function(e) {
		var ids = document.getElementById("ids").value;
		if(ids=="") {
			alert('Please first make a selection from the list.');
			return false;
		} else {
			var Ok = confirm("Are you sure you want to undone this record(s)?");
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
