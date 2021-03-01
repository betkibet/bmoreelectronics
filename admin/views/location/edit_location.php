<script type="text/javascript">
function check_form(a) {
	if(a.name.value.trim()=="") {
		alert('Please enter location name');
		a.name.focus();
		a.name.value='';
		return false;
	} else if(a.address.value.trim()=="") {
		alert('Please enter address');
		a.address.focus();
		a.address.value='';
		return false;
	} else if(a.country.value.trim()=="") {
		alert('Please enter country');
		a.country.focus();
		a.country.value='';
		return false;
	} else if(a.state.value.trim()=="") {
		alert('Please enter state');
		a.state.focus();
		a.state.value='';
		return false;
	} else if(a.city.value.trim()=="") {
		alert('Please enter city');
		a.city.focus();
		a.city.value='';
		return false;
	} else if(a.zipcode.value.trim()=="") {
		alert('Please enter zipcode');
		a.zipcode.focus();
		a.zipcode.value='';
		return false;
	} else if(a.email.value.trim()=="") {
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	} else if(a.phone.value.trim()=="") {
		alert('Please enter phone');
		a.phone.focus();
		a.phone.value='';
		return false;
	}
}

jQuery(document).ready(function($) {
	$('#allowed_num_of_booking_per_time_slot').on("change",function(e) {
		var checked = $("#allowed_num_of_booking_per_time_slot").is(":checked");
		if(checked){
			$('.booking_allowed_per_time_slot').show();
		} else {
			$('.booking_allowed_per_time_slot').hide();	
		}
	});

	<?php
	$days_arr = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
	foreach($days_arr as $d_k => $d_v) { ?>
		$("[id='closed[<?=$d_v?>]']").click(function(e) {
			if($(this).prop("checked") == true) {
				$("[name='open_time[<?=$d_v?>]']").val('');
				$("[name='open_time[<?=$d_v?>]']").prop("disabled", true);
				$("[name='close_time[<?=$d_v?>]']").val('');
				$("[name='close_time[<?=$d_v?>]']").prop("disabled", true);
			} else {
				$("[name='open_time[<?=$d_v?>]']").removeAttr("disabled");
				$("[name='close_time[<?=$d_v?>]']").removeAttr("disabled");
			}
		});

		if($("[id='closed[<?=$d_v?>]']").prop("checked") == true) {
			$("[name='open_time[<?=$d_v?>]']").val('');
			$("[name='open_time[<?=$d_v?>]']").prop("disabled", true);
			$("[name='close_time[<?=$d_v?>]']").val('');
			$("[name='close_time[<?=$d_v?>]']").prop("disabled", true);
		} else {
			$("[name='open_time[<?=$d_v?>]']").removeAttr("disabled");
			$("[name='close_time[<?=$d_v?>]']").removeAttr("disabled");
		}
	<?php
	} ?>

});
</script>

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
			<div class="m-content ">
				<?php include('confirm_message.php'); ?>
				<!--Begin::Section-->
				<div class="row">
					<div class="col-lg-12">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Location':'Add Location')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/location.php" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__content">
										<?php include('confirm_message.php'); ?>
									</div>
									<div class="form-group m-form__group">
										<label for="name">Name</label>
										<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$location_data['name']?>" name="name">
									</div>
									<div class="form-group m-form__group">
										<label for="address">Address</label>
										<textarea class="form-control m-input m-input--square" cols="30" rows="3" id="address" name="address"><?=$location_data['address']?></textarea>
									</div>
									<div class="form-group m-form__group row">
										<div class="col-lg-3">
											<label for="country">Country</label>
											<input type="text" class="form-control m-input m-input--square" id="country" value="<?=$location_data['country']?>" name="country">
										</div>
										<div class="col-lg-3">
											<label for="state">State</label>
											<input type="text" class="form-control m-input m-input--square" id="state" value="<?=$location_data['state']?>" name="state">
										</div>
										<div class="col-lg-3">
											<label for="city">City</label>
											<input type="text" class="form-control m-input m-input--square" id="city" value="<?=$location_data['city']?>" name="city">
										</div>
										<div class="col-lg-3">
											<label for="zipcode">Zipcode</label>
											<input type="text" class="form-control m-input m-input--square" id="zipcode" value="<?=$location_data['zipcode']?>" name="zipcode">
										</div>
									</div>
									<div class="form-group m-form__group row">
										<div class="col-lg-6">
											<label for="email">Email</label>
											<input type="text" class="form-control m-input m-input--square" id="email" value="<?=$location_data['email']?>" name="email">
										</div>
										<?php /*?><div class="col-lg-4">
											<label for="cc_email">CC Email</label>
											<input type="text" class="form-control m-input m-input--square" id="cc_email" value="<?=$location_data['cc_email']?>" name="cc_email">
										</div><?php */?>
										<div class="col-lg-6">
											<label for="phone">Phone</label>
											<input type="text" class="form-control m-input m-input--square" id="phone" value="<?=$location_data['phone']?>" name="phone">
										</div>
									</div>
									
									<?php
									$h_inc = (60 * 60);
									$start = (strtotime('01:00'));
									$end = (strtotime('24:00')); ?>
									<div class="form-group m-form__group row">
										<div class="col-lg-4">
											<label for="start_time">Appt. Start Time</label>
											<select class="form-control select2 m_select2" name="start_time" id="start_time">
												<option value=""> - Select - </option>
												<?php
												$saved_start_time=$location_data['start_time'];
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("g:i a", $i);
													if($saved_start_time==$start_appt_time)
														$isSelected="selected";
													else
														$isSelected="";
													echo '<option value="'.$start_appt_time.'" '.$isSelected.'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-4">
											<label for="end_time">Appt. End Time</label>
											<select class="form-control select2 m_select2" name="end_time" id="end_time">
												<option value=""> - Select - </option>
												<?php
												$saved_start_time=$location_data['end_time'];
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("g:i a", $i);
													if($saved_start_time==$start_appt_time)
														$isSelected="selected";
													else
														$isSelected="";
													echo '<option value="'.$start_appt_time.'" '.$isSelected.'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-4">
											<label for="time_interval">Appt. Time Interval (Minute)</label>
											<select class="form-control select2 m_select2" name="time_interval" id="time_interval">
												<option value=""> - Select - </option>
												<?php
												$saved_time_interval=$location_data['time_interval'];
												for($i = 5; $i <= 60; $i += 5) {
													if($saved_time_interval==$i)
														$isSelected="selected";
													else
														$isSelected="";
													echo '<option value="'.$i.'" '.$isSelected.'>'.$i.'</option>';
												} ?>
											</select>
										</div>
									</div>
									
									<div class="form-group m-form__group row">
										<div class="col-lg-6">
											<label for="allowed_num_of_booking_per_time_slot">&nbsp;</label>
											<div class="m-checkbox-inline">
												<label class="m-checkbox">
													<input id="allowed_num_of_booking_per_time_slot" type="checkbox" value="1" name="allowed_num_of_booking_per_time_slot" <?php if($location_data['allowed_num_of_booking_per_time_slot']=="1"){echo 'checked="checked"';}?>>
													<span></span> Set number of booking allowed per time slot
												</label>
											</div>
										</div>
										<div class="col-lg-6">
											<label>Type</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input id="is_show_in_store_shipping" type="radio" value="store" name="shipping_type" <?php if($location_data['shipping_type']=='store' || !$location_data['id']){echo 'checked="checked"';}?>>
													Store
													<span></span>
												</label>
												<label class="m-radio">
													<input id="is_show_in_starbucks_shipping" type="radio" value="starbucks" name="shipping_type" <?php if($location_data['shipping_type']=='starbucks'){echo 'checked="checked"';}?>>
													Starbucks
													<span></span>
												</label>
											</div>
										</div>
									</div>
									
									<div class="form-group m-form__group row booking_allowed_per_time_slot" <?php if($location_data['allowed_num_of_booking_per_time_slot']=="1"){echo 'style="display:block;"';} else {echo 'style="display:none;"';}?>>
										<div class="col-lg-6">
											<label for="num_of_booking_per_time_slot">Enter number of booking per time slot</label>
											<input type="number" class="form-control m-input m-input--square" name="num_of_booking_per_time_slot" value="<?=$location_data['num_of_booking_per_time_slot']?>">
										</div>
									</div>
									
									<?php /*?><div class="m-form__group form-group">
										<label for="">Google Calendar API</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="google_cal_api" name="google_cal_api" value="1" <?=($location_data['google_cal_api']=='1'?'checked="checked"':'')?>> Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="google_cal_api" name="google_cal_api" value="0" <?=($location_data['google_cal_api']=='0'||$location_data['google_cal_api']==''?'checked="checked"':'')?>> No
												<span></span>
											</label>
										</div>
										<?php
										if($location_data['is_google_cal_auth'] == '1') {
											$google_cal_auth_info = json_decode($location_data['google_cal_auth_info']);
											echo '<a href="'.SITE_URL.'admin/social/index.php?UnAuthorize=yes&location_id='.$location_data['id'].'" onclick="return confirm(\'Are you sure you want to unauthorize?\');">UnAuthorize ('.$google_cal_auth_info->auth_email.')</a>';
										} else {
											echo '<a href="'.SITE_URL.'admin/social/index.php?location_id='.$location_data['id'].'">Authorize</a>';
										} ?>
									</div><?php */?>
									
									<div class="form-group m-form__group">
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="show_appt_datetime_selection_in_place_order" type="checkbox" value="1" name="show_appt_datetime_selection_in_place_order" <?php if($location_data['show_appt_datetime_selection_in_place_order']=="1"){echo 'checked="checked"';}?>>
												<span></span> Show Appointment Date/Time Selection While Placing Order
											</label>
										</div>
										<div class="m-checkbox-inline">
											<label class="m-checkbox">
												<input id="show_working_hours_in_place_order" type="checkbox" value="1" name="show_working_hours_in_place_order" <?php if($location_data['show_working_hours_in_place_order']=="1"){echo 'checked="checked"';}?>>
												<span></span> Show Working Hours Of Location While Placing Order
											</label>
										</div>
									</div>
									
									<?php
									$h_inc = (60 * 30); ?>
									<div class="form-group m-form__group m--padding-bottom-5">
										<h4 class="m-section__heading">Service Hours</h4>
									</div>
									<div class="form-group m-form__group row m--padding-top-10 m--padding-bottom-5">
										<div class="col-lg-2">
											<label for="days"><h5>Days</h5></label>
										</div>
										<div class="col-lg-2">
											<label for="open_time"><h5>Open Time</h5></label>
										</div>
										<div class="col-lg-2">
											<label for="close_time"><h5>Close Time</h5></label>
										</div>
										<div class="col-lg-2">
											<label for="closed"><h5>Closed</strong></h5>
										</div>
									</div>
	
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Sunday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[sunday]" id="open_time[sunday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->sunday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[sunday]" id="close_time[sunday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->sunday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[sunday]" name="closed[sunday]" value="yes" <?php if($closed->sunday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Monday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[monday]" id="open_time[monday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->monday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[monday]" id="close_time[monday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->monday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[monday]" name="closed[monday]" value="yes" <?php if($closed->monday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Tuesday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[tuesday]" id="open_time[tuesday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->tuesday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[tuesday]" id="close_time[tuesday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->tuesday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[tuesday]" name="closed[tuesday]" value="yes" <?php if($closed->tuesday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Wednesday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[wednesday]" id="open_time[wednesday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->wednesday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[wednesday]" id="close_time[wednesday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->wednesday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[wednesday]" name="closed[wednesday]" value="yes" <?php if($closed->wednesday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Thursday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[thursday]" id="open_time[thursday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->thursday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[thursday]" id="close_time[thursday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->thursday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[thursday]" name="closed[thursday]" value="yes" <?php if($closed->thursday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Friday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[friday]" id="open_time[friday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->friday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[friday]" id="close_time[friday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->friday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[friday]" name="closed[friday]" value="yes" <?php if($closed->friday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group row m--padding-top-5 m--padding-bottom-5">
										<div class="col-lg-2 m--padding-top-10">
											<strong>Saturday</strong>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="open_time[saturday]" id="open_time[saturday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$start_appt_time=date("h:i a", $i);
													echo '<option value="'.$start_appt_time.'" '.($open_time->saturday==$start_appt_time?"selected":"").'>'.$start_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<select class="form-control select2 m_select2" name="close_time[saturday]" id="close_time[saturday]">
												<option value=""> - Select - </option>
												<?php
												for($i = $start; $i <= $end; $i += $h_inc) {
													$close_appt_time=date("h:i a", $i);
													echo '<option value="'.$close_appt_time.'" '.($close_time->saturday==$close_appt_time?"selected":"").'>'.$close_appt_time.'</option>';
												} ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="m-checkbox">
											<input type="checkbox" id="closed[saturday]" name="closed[saturday]" value="yes" <?php if($closed->saturday=='yes'){echo 'checked';}?>> <span></span>
											</label>
										</div>
									</div>
									
									<div class="m-form__group form-group">
										
									</div>
									
									<div class="m-form__group form-group">
										<label>
											Publish :
										</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" name="published" value="1" <?php if(!$location_data['id']){echo 'checked="checked"';}?> <?=($location_data['published']==1?'checked="checked"':'')?>>
												Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" name="published" value="0" <?=($location_data['published']=='0'?'checked="checked"':'')?>>
												No
												<span></span>
											</label>
										</div>
									</div>
								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions">
										<button id="m_form_submit" type="submit" class="btn btn-primary" name="update"><?=($id?'Update':'Save')?></button>
										<a href="location.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$location_data['id']?>" />
							</form>
							<!--end::Form-->
						</div>
						<!--end::Portlet-->
					</div>
				</div>
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
