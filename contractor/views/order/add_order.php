<?php
if($post['order_mode'] == "paid") {
	$back_url = CONTRACTOR_URL.'paid_orders.php';
} elseif($post['order_mode'] == "awaiting") {
	$back_url = CONTRACTOR_URL.'awaiting_orders.php';
} elseif($post['order_mode'] == "archive") {
	$back_url = CONTRACTOR_URL.'archive_orders.php';
} elseif($post['order_mode'] == "abandone") {
	$back_url = CONTRACTOR_URL.'abandone_orders.php';
} else {
	$back_url = CONTRACTOR_URL.'orders.php';
} ?>

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
		<div class="row">
			<div class="col-md-12">
				<div class="m-portlet">
					<div class="m-portlet__head m-portlet__head-bg-brand">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Add Order
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<!--begin::Section-->
						<div class="m-section">
							<div class="m-section__content">
								<form action="controllers/order/order.php" method="POST" class="m-form" id="model_details_form" onSubmit="return chechdata();" enctype="multipart/form-data">
									
									<div class="form-group m-form__group">
										<label for="user_id">Select Customer *</label>
										<select name="user_id" id="user_id" class="form-control" required>
											<option value=""> - Select - </option>
											<?php
											foreach($contractor_users_list as $user_data) {
											//while($user_data = mysqli_fetch_assoc($u_q)) { ?>
												<option value="<?=$user_data['id']?>"><?=(trim($user_data['name'])!=""?$user_data['name']:$user_data['email'])?></option>
											<?php
											} ?>
										</select>
									</div>
								
									<div class="m-form__section m-form__section--first model_form_data">
			
									</div>
									<div class="form-actions">
									  <a href="<?=$back_url?>" class="btn btn-secondary">Back To Order List</a>
									</div>
								</form>
							</div>
						</div>
						<!--end::Section-->
					</div>
				</div>
			</div>
		</div>
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
//check_form

function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}
	
	var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
		var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
		alert(error);
		document.getElementById(id).value = '';
		return false;
	}
}

function EditOrder(item_id) {
	post_data = "item_id="+item_id;
	jQuery(document).ready(function($) {
		$.ajax({
			type:"POST",
			url:"ajax/get_model_data.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					$('.model_form_data').html(data);
					$('.model_form_data').show();
				}
			}
		});
	});
}

jQuery(document).ready(function ($) {
	$('#user_id').on("change",function(e) {
		var user_id = $("#user_id").val();
		if(user_id>0) {
			EditOrder(0);
		} else {
			$('.model_form_data').hide();
		}
	});
});
</script>
