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
                  Staff Group List
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="edit_staff_group.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                    <span>
                      <i class="la la-plus"></i>
                      <span>
                        Add New
                      </span>
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/staff_group.php" method="post">
                  <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                    <thead>
                      <tr>
                        <th>Name</th>
						<th>Permissions</th>
						<th width="200">Actions</th>
                      </tr>
                    </thead>
					<tbody>
						<?php 
						$num_rows = mysqli_num_rows($query);
						if($num_rows>0) {
							while($groups_list=mysqli_fetch_assoc($query)) {
							$nn = 0;
							$permissions_array = json_decode($groups_list['permissions'], true);
							$permissions = '';
							if(!empty($permissions_array)) {
								foreach($permissions_array as $permissions_k=>$permissions_v) {
									if($permissions_v == '1') {
										$permissions .= ucwords(str_replace("_"," ",$permissions_k)).", ";
									}
								}
							} ?>
							<tr>
								<td><?=$groups_list['name']?></td>
								<td><?=rtrim($permissions,', ')?></td>
								<td>
									<?php
									if($groups_list['status']==1) {
										echo '<a href="controllers/staff_group.php?p_id='.$groups_list['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Published</button></a>';
									} elseif($groups_list['status']==0) {
										echo '<a href="controllers/staff_group.php?p_id='.$groups_list['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Unpublished</button></a>';
									} ?>
									<a href="edit_staff_group.php?id=<?=$groups_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>
									<?php
									if(isset($groups_list['type']) && $groups_list['type']!="fixed") { ?>
										<a href="controllers/staff_group.php?d_id=<?=$groups_list['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('are you sure to delete this record?')"><i class="la la-trash"></i></a>
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

