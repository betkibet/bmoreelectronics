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
                  Brands
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="edit_brand.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                    <span>
                      <i class="la la-plus"></i>
                      <span>
                        Add New
                      </span>
                    </span>
                  </a>
                </li>
                <?php /*?><li class="m-portlet__nav-item">
                  <form action="controllers/brand.php" method="POST">
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
                </li><?php */?>
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
                          <input type="search" class="form-control m-input" placeholder="Title" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>" autocomplete="nope">
						  	
                          <button class="btn btn-alt btn-primary ml-2 searchbx" type="submit">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="") {
          					echo '<a href="brand.php" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
			  
			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/brand.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/brand.php" method="post">
                    <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline" <?php /*?>id="m_table_1"<?php */?>>
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <th width="110">
                            Icon
                          </th>
                          <th>
                            Title
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
                        <?php $num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($brand_data=mysqli_fetch_assoc($query)) {?>
                        <tr>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                              <input type="checkbox" onclick="clickontoggle('<?=$brand_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$brand_data['id']?>">
                              <span></span>
                            </label>
                          </td>
                          <td>
							<?php if($brand_data['image'])	echo '<img src="../images/brand/'.$brand_data['image'].'" width="100" />'; // width="100" height="100"?>
						  </td>
                          <td>
                            <?=$brand_data['title']?>
                          </td>
                          <td>
                            <input type="text" class="m-input--square form-control m-input" id="ordering<?=$brand_data['id']?>" value="<?=$brand_data['ordering']?>" name="ordering[<?=$brand_data['id']?>]">
                          </td>
                          <td Width="190">
                            <?php
							if($brand_data['published']==1) {
								echo '<a href="controllers/brand.php?p_id='.$brand_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Published</button></a>';
							} elseif($brand_data['published']==0) {
								echo '<a href="controllers/brand.php?p_id='.$brand_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Unpublished</button></a>';
							}
							?>
                            <a href="edit_brand.php?id=<?=$brand_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>
        										<a href="controllers/brand.php?d_id=<?=$brand_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
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

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		if(val=="") {
			alert('Please enter title');
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