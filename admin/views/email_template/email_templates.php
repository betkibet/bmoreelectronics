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
                  Email Templates
                </h3>
              </div>
            </div>
			<div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
			    <?php
				if($prms_emailtmpl_add == '1') { ?>
                <li class="m-portlet__nav-item">
                  <a href="edit_email_template.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                    <form method="get">
                        <div class="input-group">
                          <select name="filter_by" id="filter_by" class="form-control form-control-sm m-select2 m-select2-general w-100">
							<option value="">Select</option>
							<option value="to_admin" <?php if($post['filter_by']=="to_admin"){echo 'selected="selected"';}?>>To Admin</option>
							<option value="to_customer" <?php if($post['filter_by']=="to_customer"){echo 'selected="selected"';}?>>To Customer</option>
							<?php
							if(!empty($order_status_list)) {
								foreach($order_status_list as $order_status_data) {
									$template_type_val = "order_".str_replace('-','_',$order_status_data['slug'])."_status";
									$template_type_label = "Order ".$order_status_data['name']." Status"; ?>
									<option value="<?=$template_type_val?>" <?php if($template_type_val == $post['filter_by']){echo 'selected="selected"';}?>><?=$template_type_label?></option>
								<?php
								}
							} ?>
						  </select>
						  	
                          <button class="btn btn-alt btn-primary ml-2 searchbx" type="submit">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="") {
          					echo '<a href="email_templates.php" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/device_categories.php" method="post">
                  <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                    <thead>
                      <tr>
						  <th>No.</th>
						  <th>Type</th>
						  <th>Subject</th>
						  <th width="180">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
						<?php
						if($num_of_rows>0) {
							$n = 0;
							while($get_template_list=mysqli_fetch_array($result)) {
								if($post['filter_by'] == "to_admin") {
									if(in_array($get_template_list['type'],$to_admin_tmpl_array)) { ?>
										<tr>
										  <td><?=$n=$n+1?></td>
										  <td><?=$template_type_array[$get_template_list['type']]?></td>
										  <td><?=ucfirst($get_template_list['subject'])?></td>
										  <td>
										    <?php
										    if($prms_emailtmpl_edit == '1') { ?>
										  		<a href="edit_email_template.php?id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
										  	<?php
											}
										    if($get_template_list['status']==1) {
												echo '<a href="controllers/email_template.php?p_id='.$get_template_list['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events:none;">Active</button></a>';
											} elseif($get_template_list['status']==0) {
												echo '<a href="controllers/email_template.php?p_id='.$get_template_list['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events:none;">Inactive</button></a>';
											} ?>
										  </td>
										</tr>
									<?php
									}
								} elseif($post['filter_by'] == "to_customer") {
									if(in_array($get_template_list['type'],$to_customer_tmpl_array)) { ?>
										<tr>
										  <td><?=$n=$n+1?></td>
										  <td><?=$template_type_array[$get_template_list['type']]?></td>
										  <td><?=ucfirst($get_template_list['subject'])?></td>
										  <td>
										  <?php
										  if($prms_emailtmpl_edit == '1') { ?>
										  <a href="edit_email_template.php?id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
										  	<?php
											}
										    if($get_template_list['status']==1) {
												echo '<a href="controllers/email_template.php?p_id='.$get_template_list['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events:none;">Active</button></a>';
											} elseif($get_template_list['status']==0) {
												echo '<a href="controllers/email_template.php?p_id='.$get_template_list['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events:none;">Inactive</button></a>';
											} ?>
										  </td>
										</tr>
									<?php
									}
								} else { ?>
									<tr>
									  <td><?=$n=$n+1?></td>
									  <td>
									  <?php
									  if($get_template_list['is_fixed'] == '0') {
									  	 echo ucwords(str_replace("_"," ",$get_template_list['type']));
									  } else {
									  	 echo $template_type_array[$get_template_list['type']];
									  } ?></td>
									  <td><?=ucfirst($get_template_list['subject'])?></td>
									  <td>
									  <?php
									  if($prms_emailtmpl_edit == '1') { ?>
									  <a href="edit_email_template.php?id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
									  <?php
									  }
									  if($prms_emailtmpl_delete == '1') {
										  if($get_template_list['is_fixed'] == '0') { ?>
											 <a href="controllers/email_template.php?d_id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure you want to delete this record?')"><i class="la la-trash"></i></a>
										  <?php
										  }
									  }
									  
									    if($get_template_list['status']==1) {
											echo '<a href="controllers/email_template.php?p_id='.$get_template_list['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events:none;">Active</button></a>';
										} elseif($get_template_list['status']==0) {
											echo '<a href="controllers/email_template.php?p_id='.$get_template_list['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events:none;">Inactive</button></a>';
										} ?>
									  </td>
									</tr>
								<?php
								}
							}
						}  ?>
                    </tbody>
                  </table>
                </form>
				
				<?php
				echo $pages->page_links(); ?>
					
                </div>
              </div>
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
			alert('Please select dropdown option.');
			return false;
		}
	});
});
</script>
