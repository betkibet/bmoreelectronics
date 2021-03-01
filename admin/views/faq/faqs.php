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



		<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">

			<div class="m-alert__icon">

				<i class="flaticon-info m--font-primary"></i>

			</div>

			<div class="m-alert__text">

				You can use this shortcode [faqs] in pages for display faqs

			</div>

		</div>



        <div class="m-portlet m-portlet--mobile">

          <div class="m-portlet__head">

            <div class="m-portlet__head-caption">

              <div class="m-portlet__head-title">

                <h3 class="m-portlet__head-text">

                  Faqs

                </h3>

              </div>

            </div>

            <div class="m-portlet__head-tools">

              <ul class="m-portlet__nav">

                <li class="m-portlet__nav-item">

				  <?php

				  if($prms_faq_add == '1') { ?>

                  <a href="edit_faq.php" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">

                    <span>

                      <i class="la la-plus"></i>

                      <span>

                        Add New

                      </span>

                    </span>

                  </a>

				  <?php

				  } ?>

                </li>

              </ul>

            </div>

          </div>

          <div class="m-portlet__body">

            <!--begin: Datatable -->

            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

			

			 <?php

			 if($prms_faq_delete == '1') { ?>

			  <div class="row m--margin-top-20">

				<div class="col-sm-12">

					<form action="controllers/faq.php" method="POST">

						<input type="hidden" name="ids" id="ids" value="">

						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>

					</form>

				</div>

			  </div>

			  <?php

			  } ?>

					

              <div class="row">

                <div class="col-sm-12">

                  <form action="controllers/faq.php" method="post">

                    <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline">

                      <thead>

                        <tr>

                          <th width="10">

                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">

                              <input type="checkbox" id="chk_all" class="m-input">

                              <span></span>

                            </label>

                          </th>

                          <th>

                            Title

                          </th>

                          <th>

                            Group

                          </th>

                          <th width="100">

                            Order <button type="submit" name="sbt_order" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-save"></i></button>

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

							while($faq_data=mysqli_fetch_assoc($query)) { ?>

								<tr>

								  <td>

									<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">

									  <input type="checkbox" onclick="clickontoggle('<?=$faq_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$faq_data['id']?>">

									  <span></span>

									</label>

								  </td>

								  <td><?=$faq_data['title']?></td>

								  <td><?=$faq_data['group_title']?></td>

								  <td>

									<input type="text" class="m-input--square form-control m-input" id="ordering<?=$faq_data['id']?>" value="<?=$faq_data['ordering']?>" name="ordering[<?=$faq_data['id']?>]">

								  </td>

								  <td Width="190">

									<?php

									if($faq_data['status']==1) {

										echo '<a href="controllers/faq.php?p_id='.$faq_data['id'].'&status=0"><button class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Published</button></a>';

									} elseif($faq_data['status']==0) {

										echo '<a href="controllers/faq.php?p_id='.$faq_data['id'].'&status=1"><button class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs" style="pointer-events: none;">Unpublished</button></a>';

									}



									if($prms_faq_edit == '1') { ?>

									<a href="edit_faq.php?id=<?=$faq_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>

									<?php

									}

									if($prms_faq_delete == '1') {

										if(isset($faq_data['type']) && $faq_data['type']!="fixed") { ?>

											<a href="controllers/faq.php?d_id=<?=$faq_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to delete this record?')"><i class="la la-trash"></i></a>

										<?php

										}

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

              <?php

			  $current_url_params = get_all_get_params();

			  $current_url_params = ($current_url_params?$current_url_params.'&':'?');

			  echo $pages->page_links($current_url_params); ?>

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