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
          </div>
          <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
				<?php /*?><div class="row">
					<div class="col-sm-12">
					  <div id="m_table_1_filter" class="dataTables_filter float-right">
						<label class="">
							<form method="post" onSubmit="return check_form(this);">
								<div class="input-group">
									<select name="filter_by" id="filter_by" class="form-control form-control-sm m-select2 m-select2-general w-100">
										<option value="">Select</option>
										<option value="to_admin" <?php if($post['filter_by']=="to_admin"){echo 'selected="selected"';}?>>To Admin</option>
										<option value="to_customer" <?php if($post['filter_by']=="to_customer"){echo 'selected="selected"';}?>>To Customer</option>
									</select>
									<button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm float-right ml-2" type="submit" name="search">Go</button>
									<?php
									if($post['filter_by']) {
										echo '<a href="email_templates.php"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm float-right ml-2" type="button">Clear</button></a>';
									} ?>
								</div>
							</form>
						</label>
					  </div>
					</div>
				</div><?php */?>
			  
			  <div class="row">
                <div class="col-sm-12">
                  <div id="m_table_1_filter" class="dataTables_filter float-left">
                    <form method="get">
                        <div class="input-group">
                          <select name="filter_by" id="filter_by" class="form-control form-control-sm m-select2 m-select2-general w-100">
							<option value="">Select</option>
							<option value="to_admin" <?php if($post['filter_by']=="to_admin"){echo 'selected="selected"';}?>>To Admin</option>
							<option value="to_customer" <?php if($post['filter_by']=="to_customer"){echo 'selected="selected"';}?>>To Customer</option>
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
						  <th>Actions</th>
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
										  <a href="edit_email_template.php?id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a></td>
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
										  <a href="edit_email_template.php?id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a></td>
										</tr>
									<?php
									}
								} else { ?>
									<tr>
									  <td><?=$n=$n+1?></td>
									  <td><?=$template_type_array[$get_template_list['type']]?></td>
									  <td><?=ucfirst($get_template_list['subject'])?></td>
									  <td>
									  <a href="edit_email_template.php?id=<?=$get_template_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a></td>
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
