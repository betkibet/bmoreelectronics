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
                  Staff List
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="edit_staff.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                  <form action="controllers/staff.php" method="post">
                  <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                    <thead>
                      <tr>
                        <th width="110">
                          Username
                        </th>
                        <th>
                          Email
                        </th>
                        <th>
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					$num_rows = mysqli_num_rows($query);
					if($num_rows>0) {
						while($admin_data=mysqli_fetch_assoc($query)) { ?>
                      <tr>
                        <td>
                          <?=$admin_data['username']?>
                        </td>
                        <td>
                          <?=$admin_data['email']?>
                        </td>
                        <td Width="190">
                        <?php
						if($admin_data['status']==1) {
							echo '<a href="controllers/staff.php?p_id='.$admin_data['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Published</button></a>';
						} elseif($admin_data['status']==0) {
							echo '<a href="controllers/staff.php?p_id='.$admin_data['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Unpublished</button></a>';
						}
						?>
                        <a href="edit_staff.php?id=<?=$admin_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>
      					<a href="controllers/staff.php?d_id=<?=$admin_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php }
                      }?>
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


<!-- <div id="wrapper">
  <header id="header" class="container">
    <?php/* require_once("include/admin_menu.php"); ?>
  </header>

  <section class="container" role="main">
    <div class="row">
      <article class="span12 data-block">
        <header>
          <h2>Staff List</h2>
          <ul class="data-header-actions">
            <li><a href="edit_staff.php">Add New</a></li>
          </ul>
        </header>
        <section>
          <form action="controllers/staff.php" method="post">
            <?php require_once('confirm_message.php');?>
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th width="110">Username</th>
                  <th>Email</th>
                  <th width="200">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
							$num_rows = mysqli_num_rows($query);
							if($num_rows>0) {
								while($admin_data=mysqli_fetch_assoc($query)) { ?>
                <tr>
                  <td>
                    <?=$admin_data['username']?>
                  </td>
                  <td>
                    <?=$admin_data['email']?>
                  </td>
                  <td>
                    <a href="edit_staff.php?id=<?=$admin_data['id']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
                    <a href="controllers/staff.php?d_id=<?=$admin_data['id']?>" class="btn btn-danger btn-alt" onclick="return confirm('Are you sure to delete this record?')"><i class="icon-trash"></i></a>
                    <?php
										if($admin_data['status']==1) {
											echo '<a href="controllers/staff.php?p_id='.$admin_data['id'].'&status=0"><button class="btn btn-alt btn-success" style="pointer-events: none;">Active</button></a>';
										} elseif($admin_data['status']==0) {
											echo '<a href="controllers/staff.php?p_id='.$admin_data['id'].'&status=1"><button class="btn btn-alt btn-danger" style="pointer-events: none;">Inactive</button></a>';
										}
										?>
                  </td>
                </tr>
                <?php
								}
							} else { ?>
                  <tr>
                    <td align="center">No Data Found</td>
                  </tr>
                  <?php
							} ?>
              </tbody>
            </table>
          </form>
          <?php
					echo $pages->page_links(); */?>
        </section>
      </article>
    </div>
  </section>
  <div id="push"></div>
</div> -->
