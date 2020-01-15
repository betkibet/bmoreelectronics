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
                  Pages
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">
              <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                  <a href="edit_system_page.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                  <div id="m_table_1_filter" class="dataTables_filter float-left">
                    <form method="get">
                        <div class="input-group">
                          <input type="search" class="form-control m-input" placeholder="Title" name="filter_by" id="filter_by" value="<?=$post['filter_by']?>" autocomplete="nope">
						  	
                          <button class="btn btn-alt btn-primary ml-2 searchbx" type="submit">Search <i class="la la-search"></i></button>
                          <?php
						  if($post['filter_by']!="") {
          					echo '<a href="system_page.php" class="btn btn-alt btn-danger ml-2">Clear <i class="la la-remove"></i></a>';
						  } ?>
                        </div>
                    </form>
                  </div>
                </div>
              </div>

			  <div class="row m--margin-top-20">
				<div class="col-sm-12">
					<form action="controllers/system_page.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
					</form>
				</div>
			  </div>
			  
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/device_categories.php" method="post">
                  <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                    <thead>
                      <tr>
					  	<th width="10">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                        </th>
                        <th width="60"># 
						<?php
						if($post['id_shorting'] == "asc" || $post['id_shorting'] == "") { ?>
							<a href="?id_shorting=desc<?=($post['title_shorting']?"&title_shorting=".$post['title_shorting']:"").($post['filter_by']?"&filter_by=".$post['filter_by']:"")?>"><i class="la la-arrow-down" aria-hidden="true"></i></a>
						<?php
						} elseif($post['id_shorting'] == "desc") { ?>
							<a href="?id_shorting=asc<?=($post['title_shorting']?"&title_shorting=".$post['title_shorting']:"").($post['filter_by']?"&filter_by=".$post['filter_by']:"")?>"><i class="la la-arrow-up" aria-hidden="true"></i></a>
						<?php
						} ?>
						</th>
                        <th>Title
						<?php
						if($post['title_shorting'] == "asc" || $post['title_shorting'] == "") { ?>
							<a href="?title_shorting=desc<?=($post['id_shorting']?"&id_shorting=".$post['id_shorting']:"").($post['filter_by']?"&filter_by=".$post['filter_by']:"")?>"><i class="la la-arrow-down" aria-hidden="true"></i></a>
						<?php
						} elseif($post['title_shorting'] == "desc") { ?>
							<a href="?title_shorting=asc<?=($post['id_shorting']?"&id_shorting=".$post['id_shorting']:"").($post['filter_by']?"&filter_by=".$post['filter_by']:"")?>"><i class="la la-arrow-up" aria-hidden="true"></i></a>
						<?php
						} ?>
						</th>
                        <th>SEF Url</th>
                        <th>Meta Title</th>
						<th>Meta Desc</th>
						<th>Meta Keywords</th>			
                        <?php /*?><th width="100">
                          Order <button type="submit" name="sbt_order" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-save"></i></button>
                        </th><?php */?>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $n = 0;
                        /*
                        foreach($inbuild_page_array as $inbuild_page_data) {
                          $saved_inbuild_page_data=saved_inbuild_page_data($inbuild_page_data['slug']);
                          $menu_name = $saved_inbuild_page_data['menu_name'];
                          $title = $saved_inbuild_page_data['title'];
                          $url = $saved_inbuild_page_data['url'];
                          $finl_url = ($url?$url:$inbuild_page_data['url']); ?>
                          <tr>
                            <td width="30"><?=$n=$n+1?></td>
                            <td><?=($title?$title:$inbuild_page_data['title'])?></td>
                            <td><a href="<?=SITE_URL.$finl_url?>" target="_blank"><?=$finl_url?></a></td>
                            <td><?=$saved_inbuild_page_data['meta_title']?></td>
                            <td><?=$saved_inbuild_page_data['meta_keywords']?></td>
                            <td><?=$saved_inbuild_page_data['meta_desc']?></td>
                            <td><?=$saved_inbuild_page_data['ordering']?></td>
                            <td>
                              <a href="edit_system_page.php?id=<?=intval($saved_inbuild_page_data['id'])?>&slug=<?=$inbuild_page_data['slug']?>" class="btn btn-alt btn-default"><i class="icon-pencil"></i></a>
                              <?php
                              if(!empty($saved_inbuild_page_data)) {
                                if($saved_inbuild_page_data['published']==1) {
                                  echo '<a href="controllers/system_page.php?p_id='.$saved_inbuild_page_data['id'].'&published=0" class="'.($inbuild_page_data['slug']=='home'?' not-active':'').'"><button class="btn btn-alt btn-success">Published</button></a>';
                                } elseif($saved_inbuild_page_data['published']==0) {
                                  echo '<a href="controllers/system_page.php?p_id='.$saved_inbuild_page_data['id'].'&published=1" class="'.($inbuild_page_data['slug']=='home'?' not-active':'').'"><button class="btn btn-alt btn-danger">Unpublished</button></a>';
                                }
                              }
                              ?>
                            </td>
                          </tr>
                        <?php
                        } */

                        $num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($page_data=mysqli_fetch_assoc($query)) {
                          $position_array = (array)json_decode($page_data['position']);
                          //$imp_position = ucwords(str_replace("_"," ",implode(", ",$position_array)));
                      ?>
                      <tr>
					  	<td>
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand m-checkbox--single">
                              <input type="checkbox" onclick="clickontoggle('<?=$page_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$page_data['id']?>">
                              <span></span>
                            </label>
                          </td>
                        <td width="20"><?=$page_data['id']?></td>
      									<td><?=$page_data['title']?></td>
      									<td><a href="<?=SITE_URL.$page_data['url']?>" target="_blank"><?=$page_data['url']?></a></td>
      									<td><?=$page_data['meta_title']?></td>
      									<td><?=$page_data['meta_keywords']?></td>
      									<td><?=$page_data['meta_desc']?></td>
      									
                        <?php /*?><td>
                          <input type="text" class="m-input--square form-control m-input" id="ordering<?=$page_data['id']?>" value="<?=$page_data['ordering']?>" name="ordering[<?=$page_data['id']?>]">
                        </td><?php */?>
                        <td Width="190">

                          <?php
      										if($page_data['published']==1) {
      											echo '<a href="controllers/system_page.php?p_id='.$page_data['id'].'&published=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Published</button></a>';
      										} elseif($page_data['published']==0) {
      											echo '<a href="controllers/system_page.php?p_id='.$page_data['id'].'&published=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-sm" style="pointer-events: none;">Unpublished</button></a>';
      										} ?>

                          <a href="edit_system_page.php?id=<?=$page_data['id']?>&slug=<?=$page_data['slug']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-sm"><i class="fa fa-pencil-alt"></i></a>

                          <?php
                          /*if(!in_array($page_data['slug'],$inbuild_page_slug)) { ?>
                            <a href="controllers/system_page.php?d_id=<?=$page_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-sm" onclick="return confirm('are you sure to delete this record?')"><i class="fa fa-trash"></i></a>
      										<?php
      										}*/
      										?>

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
			alert('Please enter title of menu');
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