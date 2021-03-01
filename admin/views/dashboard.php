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
	
		<!-- END: Left Aside -->
		<div class="m-grid__item m-grid__item--fluid m-wrapper">
	
			<!-- BEGIN: Subheader -->
			<div class="m-subheader ">
				<div class="d-flex align-items-center">
					<div class="mr-auto">
						<h3 class="m-subheader__title">Dashboard</h3>
					</div>
				</div>
			</div>
			<!-- END: Subheader -->

			<div class="m-content">
				<div class="row">
				
					<div class="col-xl-4">
						<!--begin:: Widgets/Audit Log-->
						<div class="m-portlet m-portlet--full-height ">
							<form class="statistic-form" id="statistic-form">
								<div class="m-portlet__head" style="padding:0 1.2rem;">
									
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<h3 class="m-portlet__head-text">
												Statistics&nbsp;&nbsp;
											</h3>
										</div>
									</div>
									<div class="m-portlet__head-tools">
										
										<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
											<li class="nav-item m-tabs__item">
												
												  <select class="custom-select" name="stat_period" id="stat_period" onchange="check_statistic_info('select');">
													<option value="all" selected>All time</option>
													<option value="last_month">Last month</option>
													<option value="3_month">3 month</option>
													<option value="6_month">6 month</option>
													<option value="9_month">9 month</option>
												  </select>
												
											</li>
										</ul>
										
										&nbsp;<input type="text" class="form-control m-input stat_datepicker" placeholder="Custom Date" name="stat_date" id="stat_date" autocomplete="nope" style="width:105px;">
										
									</div>
								</div>
							</form>
							<div class="m-portlet__body">								
								<div class="tab-content">
									<div class="tab-pane active" id="m_widget4_tab1_content">
										<div class="m-list-timeline m-list-timeline--skin-light">
											<div class="m-list-timeline__items statistic-info">
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Audit Log-->
					</div>
					<div class="col-xl-4">
						<!--begin:: Widgets/Audit Log-->
						<div class="m-portlet m-portlet--full-height ">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Customers
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
										<li class="nav-item m-tabs__item">
											<a href="edit_user.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>Add New</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
								<div class="tab-content">
									<div class="tab-pane active" id="m_widget4_tab1_content">
										<div class="m-list-timeline m-list-timeline--skin-light">
											<div class="m-list-timeline__items">
												<?php
												if($num_of_user_rows>0) {
													while($user_data=mysqli_fetch_assoc($user_query)) {
														if($user_data['status']=='1') { ?>
															<div class="m-list-timeline__item">
																<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
																<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Published</span></span>
																<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="users.php?status=<?=$user_data['status']?>" class="m-badge m-badge--success m-badge--wide"><?=$user_data['num_of_users']?></a></span></span>
															</div>
														<?php
														}
														elseif($user_data['status']=='0') { ?>
															<div class="m-list-timeline__item">
																<span class="m-list-timeline__badge m-list-timeline__badge--metal"></span>
																<span class="m-list-timeline__text"><span class="m-badge m-badge--metal m-badge--wide">Unpublished</span></span>
																<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="users.php?status=<?=$user_data['status']?>" class="m-badge m-badge--metal m-badge--wide"><?=$user_data['num_of_users']?></a></span></span>
															</div>
														<?php
														}
													}
												} else { ?>
													<div class="alert alert-info alert-dismissible fade show" role="alert">
														Report Not Available
													</div>
												<?php
												} ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Audit Log-->
					</div>
					<div class="col-xl-4">
						<!--begin:: Widgets/Audit Log-->
						<div class="m-portlet m-portlet--full-height ">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Devices Info
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
										<li class="nav-item m-tabs__item">
											<a href="add_product.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>Add New</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
								<div class="tab-content">
									<div class="tab-pane active" id="m_widget4_tab1_content">
										
										<div class="m-list-timeline m-list-timeline--skin-light">
											<div class="m-list-timeline__items">
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Models</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="mobile.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_mobile_rows?></a></span></span>
												</div>
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Devices</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="device.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_device_rows?></a></span></span>
												</div>
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Brands</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="brand.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_brand_rows?></a></span></span>
												</div>
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Categories</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="device_categories.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_category_rows?></a></span></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Audit Log-->
					</div>						
					<div class="col-xl-4">
						<!--begin:: Widgets/Audit Log-->
						<div class="m-portlet m-portlet--full-height ">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Orders
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
										<li class="nav-item m-tabs__item">
											<a href="add_order.php" class="btn btn-sm btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
												<span>
													<i class="la la-plus"></i>
													<span>Add New</span>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
								<div class="tab-content">
									<div class="tab-pane active" id="m_widget4_tab1_content">
										
										<div class="m-list-timeline m-list-timeline--skin-light">
											<div class="m-list-timeline__items">
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Awaiting Orders</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="awaiting_orders.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_awaiting_orders?></a></span></span>
												</div>
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Unpaid Orders</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="orders.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_unpaid_orders?></a></span></span>
												</div>
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Paid Orders</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="paid_orders.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_paid_orders?></a></span></span>
												</div>
												<div class="m-list-timeline__item">
													<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
													<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Archive Orders</span></span>
													<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="archive_orders.php" class="m-badge m-badge--success m-badge--wide"><?=$num_of_archive_orders?></a></span></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Audit Log-->
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

<script>
function check_statistic_info(type) {
	jQuery(document).ready(function($) {
		if(type == "select") {
			$('#stat_date').val('');
		}
		
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>admin/ajax/statistic_info.php?type='+type,
			data: $('#statistic-form').serialize(),
			success: function(data) {
				if(data!="") {
					$('.statistic-info').html(data);
					return false;
				}
			}
		});
	});
}
check_statistic_info('select');

$('.stat_datepicker').datepicker({
	format: "mm/dd/yyyy",
	autoclose: true
}).change(dateChanged).on('changeDate', dateChanged);

function dateChanged(ev) {
	check_statistic_info('custom');
}
</script>
