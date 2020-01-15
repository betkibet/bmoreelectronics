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
                  Promo Codes
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="add_promocode.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                  <table class="table table-striped- table-bordered table-hover table-checkable">
                    <thead>
                      <tr>
                      <th>ID</th>
					  <th>Promo Code</th>
					  <th>From Date</th>
					  <th>Expire Date</th>
					  <th>Discount</th>
					  <th>Active</th>
					  <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $num_rows = mysqli_num_rows($result);
                      if($num_rows>0) {
                        while($promocode_data=mysqli_fetch_assoc($result)) {?>
						  <tr>
							<td><?=$promocode_data['id']?></td>
							<td><?=$promocode_data['promocode']?></td>
							<td><?=date("m/d/Y",strtotime($promocode_data['from_date']))?></td>
							<td><?=date("m/d/Y",strtotime($promocode_data['to_date']))?></td>
							<td><?=($promocode_data['discount_type']=="percentage"?$promocode_data['discount'].'%':amount_fomat($promocode_data['discount']))?></td>
							<td><?=$promocode_data['status']=='1'?'Yes':'No'?></td>
							<td>
							  <a href="edit_promocode.php?id=<?=$promocode_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>
							  <a href="controllers/promocode.php?r_id=<?=$promocode_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('Are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
							</td>
						  </tr>
                      <?php }
                      } ?>
                    </tbody>
                  </table>
				  
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
