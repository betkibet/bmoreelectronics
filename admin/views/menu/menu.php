<style type="text/css">
.not-active {
   pointer-events: none;
   cursor: default;
   opacity:0.6;
}
</style>

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
                  Menus
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="edit_menu.php?position=<?=$menu_position?>" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
              <?php /*?><div class="row">
                <div class="col-sm-12">
                  <div id="m_table_1_filter" class="dataTables_filter float-right">
                    <label class="">
                    <form method="get">
                      <div class="input-group">
                        <select name="position" id="position" class="form-control form-control-sm m-select2 m-select2-general w-100">
						<option value="top_right" <?php if("top_right"==$menu_position){echo 'selected="selected"';}?>>Top Right Menu</option>
						<option value="header" <?php if("header"==$menu_position){echo 'selected="selected"';}?>>Header Menu</option>
						<option value="footer_column1" <?php if("footer_column1"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column1</option>
						<option value="footer_column2" <?php if("footer_column2"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column2</option>
						<option value="footer_column3" <?php if("footer_column3"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column3</option>
						<option value="copyright_menu" <?php if("copyright_menu"==$menu_position){echo 'selected="selected"';}?>>Copyright Menu</option>
						</select>
						<button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm float-right ml-2" type="submit" name="search">Go</button>
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
                          <select name="position" id="position" class="form-control form-control-sm m-select2 m-select2-general w-100">
							<option value="top_right" <?php if("top_right"==$menu_position){echo 'selected="selected"';}?>>Top Right Menu</option>
							<option value="header" <?php if("header"==$menu_position){echo 'selected="selected"';}?>>Header Menu</option>
							<option value="footer_column1" <?php if("footer_column1"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column1</option>
							<option value="footer_column2" <?php if("footer_column2"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column2</option>
							<option value="footer_column3" <?php if("footer_column3"==$menu_position){echo 'selected="selected"';}?>>Footer Menu Column3</option>
							<option value="copyright_menu" <?php if("copyright_menu"==$menu_position){echo 'selected="selected"';}?>>Copyright Menu</option>
						  </select>
						  	
                          <button class="btn btn-alt btn-primary ml-2" type="submit" name="search">Go</button>
                          <?php
						  /*if($post['filter_by']!="") {
          					echo '<a href="users.php" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  }*/ ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
              <div class="row">
                <div class="col-sm-12">
                  	<form action="controllers/menu.php" method="post">
                  <table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inline" id="m_table_1_">
                    <thead>
                      <tr>
                        <th width="25">
                          #
                        </th>
                        <th>
                          Menu Name
                        </th>
                        <th>
                          Parent Menu
                        </th>
						<th>
                          Page Name
                        </th>
                        <th width="100">
                          Order <button type="submit" name="sbt_order" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-save"></i></button>
                        </th>
                        <th>
                          Actions
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $n = 0;
                        $num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($menu_data=mysqli_fetch_assoc($query)) {
                          $parent_menu_id = '';
                          $parent_menu_data = array();

                          $parent_menu_id = $menu_data['parent'];
                          if($parent_menu_id>0) {
                            $parent_menu_data = get_parent_menu_data($parent_menu_id);
                          } ?>
                      <tr>
                        <td width="30"><?=$n=$n+1?></td>
						<td><?=$menu_data['menu_name']?></td>
						<td><?=$parent_menu_data['menu_name']?></td>
						<td><?=$menu_data['page_title']?></td>
                        <td><input type="text" class="input-small form-control m-input" id="ordering<?=$menu_data['id']?>" value="<?=$menu_data['ordering']?>" name="ordering[<?=$menu_data['id']?>]"></td>
                        <td Width="190">
                        <?php
						if($menu_data['status']==1) {
							echo '<a href="controllers/menu.php?p_id='.$menu_data['id'].'&published=0&position='.$menu_position.'"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Active</button></a>';
						} elseif($menu_data['status']==0) {
							echo '<a href="controllers/menu.php?p_id='.$menu_data['id'].'&published=1&position='.$menu_position.'"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Inactive</button></a>';
						} ?>

                        <a href="edit_menu.php?id=<?=$menu_data['id']?>&position=<?=$menu_position?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>
      					<a href="controllers/menu.php?d_id=<?=$menu_data['id']?>&position=<?=$menu_position?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php }
                      } ?>
                    </tbody>
                  </table>
				  <input type="hidden" name="position" value="<?=$menu_position?>" />
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
