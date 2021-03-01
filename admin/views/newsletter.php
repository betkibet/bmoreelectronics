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
                  Newsletters
                </h3>
              </div>
            </div>
          </div>
          <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
			  
			  <?php
			  if($prms_form_delete == '1') { ?>
			  <div class="row">
				<div class="col-sm-12">
					<form action="controllers/newsletter.php" method="POST">
						<input type="hidden" name="ids" id="ids" value="">
						<button class="btn btn-sm btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air bulk_remove" name="bulk_remove"><span><i class="la la-remove"></i><span>Bulk Remove</span></span></button>
						
						<button class="btn btn-sm btn-accept m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" type="button" onclick="ImportMetaModal();return false;"><i class="la la-download"></i> Import </button>
						<button class="btn btn-sm btn-info m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" type="submit" name="export"><i class="la la-upload"></i> Export </button>
						<button class="btn btn-sm btn-success m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air m--margin-left-10" type="button" onclick="SendEmailModal();return false;"><i class="la la-send-o"></i> Send Bulk Email </button>
					</form>
				</div>
			  </div>
			  <?php
			  } ?>
			  
              <div class="row">
                <div class="col-sm-12" style="overflow:scroll;">
                  <form action="controllers/device_categories.php" method="post">
                    <table class="table table-bordered table-hover table-checkable dataTable dtr-inline">
                      <thead>
                        <tr>
                          <th width="10">
                            <label class="m-checkbox m-checkbox--brand m-checkbox--solid m-checkbox--single">
                              <input type="checkbox" id="chk_all" class="m-input">
                              <span></span>
                            </label>
                          </th>
                          <?php /*?><th>First Name</th>
						  <th>Last Name</th><?php */?>
						  <th>Email</th>
						  <th width="100">Status</th>
						  <th width="100">Date/Time</th>
						  <th width="50">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num_rows = mysqli_num_rows($query);
                        if($num_rows>0) {
                          while($newsletter_data=mysqli_fetch_assoc($query)) {?>
                        <tr>
                            <td>
								<label class="m-checkbox m-checkbox--brand m-checkbox--solid m-checkbox--single">
								    <input type="checkbox" onclick="clickontoggle('<?=$newsletter_data['id']?>');" class="sub_chk m-input" name="chk[]" value="<?=$newsletter_data['id']?>">
								    <span></span>
								</label>
                            </td>
						    <?php /*?><td><?=$newsletter_data['first_name']?></td>
							<td><?=$newsletter_data['last_name']?></td><?php */?>
							<td><?=$newsletter_data['email']?></td>
							<td>
							<?php
							if($newsletter_data['status']=='0') {
								echo '<a href="controllers/newsletter.php?active_id='.$newsletter_data['id'].'" class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs">Inactive</a>';
							} else {
								echo '<a href="controllers/newsletter.php?inactive_id='.$newsletter_data['id'].'" class="btn btn-brand m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-xs">Active</a>';
							} ?>
							</td>
							<td><?=format_date($newsletter_data['date']).' '.format_time($newsletter_data['date'])?></td>
							<td>
								<?php
								if($prms_form_delete == '1') { ?>
								<a href="controllers/newsletter.php?d_id=<?=$newsletter_data['id']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure to delete this record?')"><i class="la la-trash"></i></a>
								<?php
								} ?>
							</td>
                        </tr>
                        <?php }
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

<div class="modal fade" id="import_meta_modal" tabindex="-1" role="dialog" aria-labelledby="import_meta_modal_lbl" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="import_meta_modal_lbl">Data(s) Import</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/newsletter.php" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Select File</label>
						<input type="file" class="form-control" id="file_name" name="file_name">
					</div>
					<div class="form-group">
						<a href="sample_files/sample_file_for_newsletter.csv" class="btn btn-md btn-success"><i class="la la-download"></i> Download Sample File</a>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="import">IMPORT</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="send_email_modal" tabindex="-1" role="dialog" aria-labelledby="import_meta_modal_lbl" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="import_meta_modal_lbl">Send Bulk Email To Customer(s)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/newsletter.php" method="POST" onSubmit="return check_sendbulk_form(this);">
				<div class="modal-body">
					<div class="m-form__group form-group">
						<div class="m-radio-inline">
							<label class="m-radio">
								<input type="radio" name="type" id="type_all" value="all" onclick="choose_send_email_type('all');" checked="checked">
								All
								<span></span>
							</label>
							<label class="m-radio">
								<input type="radio" name="type" id="type_choose" value="choose" onclick="choose_send_email_type('choose');">
								Choose Email(s)
								<span></span>
							</label>
						</div>
					</div>
					<div class="form-group m-form__group choose_cust_showhide">
						<select class="form-control select2 m_select2" multiple="multiple" name="email_address[]" id="email_address">
							<?php
							$n_l_num_rows = mysqli_num_rows($n_l_query);
							if($n_l_num_rows>0) {
								while($newsletter_dt=mysqli_fetch_assoc($n_l_query)) { ?>
									<option value="<?=$newsletter_dt['email']?>"><?=$newsletter_dt['email']?></option>
								<?php
								}
							} ?>
						</select>
					</div>
					
					<div class="form-group m-form__group">
						<label for="content">
							Content :
						</label>
						<textarea class="form-control m-input summernote" id="content" name="content" rows="5"><?=$email_body_text?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="send_email">Send</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
function check_sendbulk_form(a) {
	if(jQuery("#type_choose").prop("checked")) {
		var email_address = jQuery("#email_address option:selected").text();
		if(email_address == "") {
			alert('Please choose email(s)');
			return false;
		}
	}

	if(a.content.value.trim()=="") {
		alert('Please enter content');
		a.content.focus();
		return false;
	} else {
		var ok = confirm("Are you sure you want to send bulk email to customer(s)?");
		if(ok == false) {
			return false;
		}
	}
	
	if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}
}

function ImportMetaModal() {
	jQuery(document).ready(function($) {
		$('#import_meta_modal').modal({backdrop: 'static',keyboard: false});
	});
}

function SendEmailModal() {
	jQuery(document).ready(function($) {
		$('#send_email_modal').modal({backdrop: 'static',keyboard: false});
		choose_send_email_type('all');
	});
}

function choose_send_email_type(type) {
	if(type == "all") {
		$(".choose_cust_showhide").hide();
	} else {
		$(".choose_cust_showhide").show();

		$('.m_select2').select2({
			placeholder: " - Select - ",
			allowClear: true
		});
	}
}

jQuery(document).ready(function($) {
	/*$('.searchbx').on('click', function(e) {
		var val = document.getElementById("filter_by").value;
		if(val=="") {
			alert('Please enter Name, Email or Phone');
			return false;
		}
	});*/

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