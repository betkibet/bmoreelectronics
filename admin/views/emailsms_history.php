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
                  Email/SMS History
                </h3>
              </div>
            </div>
          </div>
          <div class="m-portlet__body">
		  
			<form method="post">
				<div class="form-group row">
					<div class="col-lg-3">
						<input type="text" class="form-control m-input" placeholder="Search By Order ID, To Email, SMS Phone" name="filter_by" id="filter_by" value="<?=_dt_parse($post['filter_by'])?>" autocomplete="nope" maxlength="255">
					</div>
					<div class="col-lg-2">
						<select name="order_id" id="order_id" class="form-control m-input custom-select">
							<option value=""> - Order ID - </option>
							<?php
							while($order_data = mysqli_fetch_assoc($order_query)) { ?>
								<option value="<?=$order_data['order_id']?>" <?php if($post['order_id']==$order_data['order_id']){echo 'selected="selected"';}?>><?=$order_data['order_id']?></option>
							<?php
							} ?>
						</select>
					</div>
					<div class="col-lg-3">
						<button class="btn btn-alt btn-primary searchbx" type="submit" name="search">Search <i class="la la-search"></i></button>
						<?php
						if($post['filter_by']!="" || $post['order_id']!="") {
							echo '<a href="emailsms_history.php?clear" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						} ?>
					</div>
				</div>
			</form>
			
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
			
			  <?php
				if($prms_emailtmpl_delete == '1') { ?>
			  <div class="row">
				<div class="col-sm-12">
					<form action="controllers/emailsms_history.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  <?php
				} ?>
					
              <div class="row">
                <div class="col-sm-12" style="overflow:scroll;">
                    <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed">
						<thead>
							<tr>
								<th width="10">
									<label class="m-checkbox m-checkbox--brand m-checkbox--single m-checkbox--solid">
									  <input type="checkbox" id="chk_all" class="m-input">
									  <span></span>
									</label>
								</th>
								<th>Order ID</th>
								<!--<th>From Email</th>-->
								<th>To Email</th>
								<th>Subject</th>
								<th>SMS Phone</th>
								<!--<th>IP</th>-->
								<th>LeadSource</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
                        <tbody>
						<?php 
						$num_rows = mysqli_num_rows($query);
						if($num_rows>0) {
							while($emailsms_data=mysqli_fetch_assoc($query)) {?>
							<tr>
								<td>
									<label class="m-checkbox m-checkbox--brand m-checkbox--single m-checkbox--solid">
									  <input type="checkbox" onclick="clickontoggle('<?=$emailsms_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$emailsms_data['id']?>">
									  <span></span>
									</label>
								</td>
								<td><?=($emailsms_data['order_id']?'<a href="edit_order.php?order_id='.strtoupper($emailsms_data['order_id']).'">'.$emailsms_data['order_id'].'</a>':'No Data')?></td>
								<!--<td><?=$emailsms_data['from_email']?></td>-->
								<td><?=$emailsms_data['to_email']?></td>
								<td><?=$emailsms_data['subject']?></td>
								<td><?=$emailsms_data['sms_phone']?></td>
								<!--<td><?=$emailsms_data['visitor_ip']?></td>-->
								<td><?=ucwords(str_replace("_"," ",$emailsms_data['form_type']))?></td>
								<td><?=format_date($emailsms_data['date']).' '.format_time($emailsms_data['date'])?></td>
								<td>
									<?php
									if($prms_emailtmpl_edit == '1') { ?>
									<a href="view_emailsms_history.php?id=<?=$emailsms_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-eye"></i></a>
									<?php
									}
									if($prms_emailtmpl_delete == '1') { ?>
									<a href="controllers/emailsms_history.php?d_id=<?=$emailsms_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to delete this record?')"><i class="la la-trash"></i></a>
									<?php
									} ?>
								</td>
							</tr>
							<?php 
							}
						} ?>
                        </tbody>
                    </table>
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
		var order_id = document.getElementById("order_id").value;
		if(val=="" && order_id=="") {
			alert('Please enter Order ID, To Email, SMS Phone OR please choose Order ID from dropdown');
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
