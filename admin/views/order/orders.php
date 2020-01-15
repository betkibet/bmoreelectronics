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
                  Orders
                </h3>
              </div>
            </div>
            <?php /*?><div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <form action="controllers/order/order.php" method="POST">
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
                  <div id="m_table_1_filter" class="dataTables_filter float-left">
                    <form method="get">
                        <div class="input-group">
                          <input type="search" class="form-control m-input" placeholder="Order ID, User Name" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>" autocomplete="nope">
						  
						  <input type="text" class="form-control form-control-md ml-2 datepicker" placeholder="From Date" name="from_date" id="from_date" value="<?=$post['from_date']?>" autocomplete="nope">
						  
						  <input type="text" class="form-control form-control-md ml-2 datepicker" placeholder="To Date" name="to_date" id="to_date" value="<?=$post['to_date']?>" autocomplete="nope">
						  
						<select name="status" id="status" class="form-control m-input custom-select">
							<option value=""> - Status - </option>
							
							<option value="unconfirmed" <?php if($post['status']=='unconfirmed'){echo 'selected="selected"';}?>>Unconfirmed</option>
							<option value="submitted" <?php if($post['status']=='submitted'){echo 'selected="selected"';}?>>Submitted</option>
							<option value="expiring" <?php if($post['status']=='expiring'){echo 'selected="selected"';}?>>Expiring</option>
							<option value="received" <?php if($post['status']=='received'){echo 'selected="selected"';}?>>Received</option>
							<option value="problem" <?php if($post['status']=='problem'){echo 'selected="selected"';}?>>Problem</option>
							<option value="completed" <?php if($post['status']=='completed'){echo 'selected="selected"';}?>>Completed</option>
							<option value="returned" <?php if($post['status']=='returned'){echo 'selected="selected"';}?>>Returned</option>
							<option value="awaiting_delivery" <?php if($post['status']=='awaiting_delivery'){echo 'selected="selected"';}?>>Awaiting Delivery</option>
							<option value="expired" <?php if($post['status']=='expired'){echo 'selected="selected"';}?>>Expired</option>
							<option value="processed" <?php if($post['status']=='processed'){echo 'selected="selected"';}?>>Processed</option>
							<option value="rejected" <?php if($post['status']=='rejected'){echo 'selected="selected"';}?>>Rejected</option>
							<option value="posted" <?php if($post['status']=='posted'){echo 'selected="selected"';}?>>Posted</option>
						</select>
								
                          <button class="btn btn-alt btn-primary ml-2 searchbx" type="submit" name="search">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="" || $post['from_date']!="" || $post['to_date']!="" || $post['status']!="") {
          					echo '<a href="orders.php" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/order/order.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/device.php" method="post">
                    <table class="table table-bordered table-hover table-checkable dataTable dtr-inline" <?php /*?>id="m_table_1"<?php */?>>
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <th>Order ID</th>
                          <th>Customer</th>
						  <th>Partner</th>
                          <th>Date</th>
                          <!--<th>Approved Date</th>-->
                          <th>Price</th>
                          <th>Payment Method</th>
                          <th>Status</th>
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
                            } ?>
                        <tr>
                          <td>
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand m-checkbox--single">
                              <input type="checkbox" onclick="clickontoggle('<?=$order_data['order_id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$order_data['order_id']?>">
                              <span></span>
                            </label>
                          </td>
                          <td><a href="edit_order.php?order_id=<?=$order_data['order_id']?>"><?=$order_data['order_id']?></a></td>
                          <td><a href="edit_user.php?id=<?=$order_data['user_id']?>"><?=$order_data['first_name'].' '.$order_data['last_name']?></a></td>
						  <td>
						  <?php
						  if($order_data['p_store_name']!="") { ?>
						  <a href="edit_partner.php?id=<?=$order_data['partner_id']?>"><?=$order_data['p_store_name']?></a>
						  <?php
						  } ?>
						  </td>
                          <td><?=date("m-d-Y H:i",strtotime($order_data['date']))?></td>
                          <!--<td><?=($order_data['approved_date']!='0000-00-00 00:00:00'?date("m-d-Y",strtotime($order_data['approved_date'])):'')?></td>-->
                          <td><?=amount_fomat($total_of_order)?></td>
                          <td><?=replace_us_to_space($order_data['payment_method'])?></td>
                          <td>
                            <span class="m-badge  m-badge--secondary m-badge--wide">
                              <?=replace_us_to_space($order_data['status'])?>
                            </span>
                          </td>
                          <td Width="150">
                            <a href="order_offer.php?order_id=<?=$order_data['order_id']?>" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm">Offer</a>
                            <a href="edit_order.php?order_id=<?=$order_data['order_id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>
                            <a href="controllers/order/order.php?d_id=<?=$order_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php }
                        } ?>
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
		var from_date = document.getElementById("from_date").value;
		var to_date = document.getElementById("to_date").value;
		var status = document.getElementById("status").value;
		if(val=="" && from_date=="" && to_date=="" && status=="") {
			alert('Please enter Order ID, User Name or Select value from date picker');
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
