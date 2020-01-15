<script language="javascript" type="text/javascript">
  function close_day(formObj) {
    var t = formObj.split('[');
    var tmp = t[1].split(']');
    var day = tmp[0];

    if (document.getElementById(formObj).checked) {
      document.getElementById('open_time[' + day + ']').disabled = true;
      document.getElementById('close_time[' + day + ']').disabled = true;

      document.getElementById('open_time_zone' + day + '').disabled = true;
      document.getElementById('close_time_zone' + day + '').disabled = true;

      document.getElementById('open_time[' + day + ']').value = '';
      document.getElementById('close_time[' + day + ']').value = '';
    } else {
      document.getElementById('open_time[' + day + ']').disabled = false;
      document.getElementById('close_time[' + day + ']').disabled = false;

      document.getElementById('open_time_zone' + day + '').disabled = false;
      document.getElementById('close_time_zone' + day + '').disabled = false;
    }
  }

  function enableText(checkBool, textID) {
    textFldObj = document.getElementById(textID);
    textFldObj.disabled = !checkBool;
    if (!checkBool) {
      textFldObj.value = '';
    }
  }
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
      <div class="m-content">
        <?php require_once('confirm_message.php');?>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                  Service Hours
                </h3>
              </div>
            </div>
          </div>
          <div class="m-portlet__body">
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
              <div class="row">
                <div class="col-sm-12">
                  <form action="controllers/service_hours.php" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                    <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                      <thead>
                        <tr>
                          <th>Days</th>
                          <th width="224">Open Time</th>
                          <th width="224">Close Time</th>
                          <th>Closed</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr id="tr_bg_checksunday_0" <?php //if($closed->sunday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Sunday</td>
                          <td>
                            <div id="div_open_time_zonesunday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group">
                              <input type="text" class="form-control m-input m-input--square" id="open_time[sunday_0]" name="open_time[sunday_0]" value="<?=$open_time->sunday;?>" size="25" <?php if($closed->sunday=='yes') echo 'disabled';?>>
                            </div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                               if($closed->sunday=='yes')
                                  $sun_attr = ' disabled';
                               else
                                  $sun_attr = 'class="select_box"';
                               ?>
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonesunday_0" name="open_time_zone[sunday_0]" <?=$sun_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($open_time_zone->sunday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($open_time_zone->sunday=="pm"){echo 'selected="selected"';}?>>PM</option>
                               </select>
                            </div>
                          </td>
                          <td>
                            <div id="div_close_time_zonesunday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group">
                              <input type="text" class="<?php if($closed->sunday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[sunday_0]" name="close_time[sunday_0]" value="<?=$close_time->sunday;?>" size="25" <?php if($closed->sunday=='yes')
                              echo 'disabled';?>>
                            </div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonesunday_0" name="close_time_zone[sunday_0]" <?=$sun_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($close_time_zone->sunday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($close_time_zone->sunday=="pm"){echo 'selected="selected"';}?>>PM</option>
                               </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[sunday_0]" name="closed[sunday_0]" value="yes" onclick="close_day(this.id);" <?php if($closed->sunday=='yes') echo 'checked';?>>
                              <span></span>
                            </label>
                          </td>
                        </tr>

                        <tr id="tr_bg_checkmonday_0" <?php //if($closed->monday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Monday</td>
                          <td>
                            <div id="div_open_time_zonemonday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group">
                              <input type="text" class="<?php if($closed->monday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="open_time[monday_0]" name="open_time[monday_0]" value="<?=$open_time->monday;?>" <?php if($closed->monday=='yes'){
                              echo 'disabled'; }?>>
                            </div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                              if($closed->monday=='yes')
                                $mon_attr = ' disabled';
                              else
                                $mon_attr = 'class="select_box"';
                              ?>
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonemonday_0" name="open_time_zone[monday_0]" <?=$mon_attr?>>
                              <option value=" ">Select</option>
                              <option value="am" <?php if($open_time_zone->monday=="am"){echo 'selected="selected"';}?>>AM</option>
                              <option value="pm" <?php if($open_time_zone->monday=="pm"){echo 'selected="selected"';}?>>PM</option>
                              </select>
                            </div>
                          </td>
                          <td>
                            <div id="div_close_time_zonemonday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group">
                              <input type="text" class="<?php if($closed->monday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[monday_0]" name="close_time[monday_0]" value="<?=$close_time->monday;?>" <?php if($closed->monday=='yes'){
                              echo 'disabled'; }?>>
                            </div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonemonday_0" name="close_time_zone[monday_0]" <?=$mon_attr?>>
                              <option value=" ">Select</option>
                              <option value="am" <?php if($close_time_zone->monday=="am"){echo 'selected="selected"';}?>>AM</option>
                              <option value="pm" <?php if($close_time_zone->monday=="pm"){echo 'selected="selected"';}?>>PM</option>
                             </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[monday_0]"  name="closed[monday_0]"  value="yes" onclick="close_day(this.id);" <?php if($closed->monday=='yes')  { echo 'checked'; }  ?>>
                              <span></span>
                            </label>
                          </td>
                        </tr>

                        <tr id="tr_bg_checktuesday_0" <?php //if($closed->tuesday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Tuesday</td>
                          <td>
                            <div id="div_open_time_zonetuesday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->tuesday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="open_time[tuesday_0]" name="open_time[tuesday_0]" value="<?=$open_time->tuesday;?>" <?php if($closed->tuesday=='yes'){
                              echo 'disabled'; }?>></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                              if($closed->tuesday=='yes')
                                $tues_attr = ' disabled';
                              else
                                $tues_attr = 'class="select_box"';
                              ?>

                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonetuesday_0" name="open_time_zone[tuesday_0]" <?=$tues_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($open_time_zone->tuesday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($open_time_zone->tuesday=="pm"){echo 'selected="selected"';}?>>PM</option>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div id="div_close_time_zonetuesday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->tuesday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[tuesday_0]" name="close_time[tuesday_0]" value="<?=$close_time->tuesday;?>" <?php if($closed->tuesday=='yes'){
                              echo 'disabled'; }?>></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonetuesday_0" name="close_time_zone[tuesday_0]" <?=$tues_attr?>>
                              <option value=" ">Select</option>
                              <option value="am" <?php if($close_time_zone->tuesday=="am"){echo 'selected="selected"';}?>>AM</option>
                              <option value="pm" <?php if($close_time_zone->tuesday=="pm"){echo 'selected="selected"';}?>>PM</option>
                             </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[tuesday_0]"   name="closed[tuesday_0]"  value="yes" onclick="close_day(this.id);" <?php if($closed->tuesday=='yes')  { echo 'checked'; }  ?> >
                              <span></span>
                            </label>
                          </td>
                        </tr>

                        <tr id="tr_bg_checkwednesday_0" <?php //if($closed->wednesday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Wednesday</td>
                          <td>
                            <div id="div_open_time_zonewednesday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->wednesday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="open_time[wednesday_0]" name="open_time[wednesday_0]" value="<?=$open_time->wednesday;?>" <?php if($closed->wednesday=='yes'){
                              echo 'disabled'; }?>></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                              if($closed->wednesday=='yes')
                                $wed_attr = ' disabled';
                              else
                                $wed_attr = 'class="select_box"';
                             ?>
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonewednesday_0" name="open_time_zone[wednesday_0]" <?=$wed_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($open_time_zone->wednesday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($open_time_zone->wednesday=="pm"){echo 'selected="selected"';}?>>PM</option>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div id="div_close_time_zonewednesday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->wednesday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[wednesday_0]" name="close_time[wednesday_0]" value="<?=$close_time->wednesday;?>" <?php if($closed->wednesday=='yes'){
                              echo 'disabled'; }?> /></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonewednesday_0" name="close_time_zone[wednesday_0]" <?=$wed_attr?>>
                              <option value=" ">Select</option>
                              <option value="am" <?php if($close_time_zone->wednesday=="am"){echo 'selected="selected"';}?>>AM</option>
                              <option value="pm" <?php if($close_time_zone->wednesday=="pm"){echo 'selected="selected"';}?>>PM</option>
                             </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[wednesday_0]"  name="closed[wednesday_0]"  value="yes" onclick="close_day(this.id);" <?php if($closed->wednesday=='yes')  { echo 'checked'; }?>>
                              <span></span>
                            </label>
                          </td>
                        </tr>

                        <tr id="tr_bg_checkthursday_0" <?php //if($closed->thursday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Thursday</td>
                          <td>
                            <div class="c1 <?php if($closed->thursday!='yes') { echo 'blue_bg'; }?>" id="div_open_time_zonethursday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->thursday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="open_time[thursday_0]" name="open_time[thursday_0]" value="<?=$open_time->thursday;?>" <?php if($closed->thursday=='yes'){
                              echo 'disabled'; }?>></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                              if($closed->thursday=='yes')
                                $thu_attr = ' disabled';
                              else
                                $thu_attr = 'class="select_box"';
                              ?>
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonethursday_0" name="open_time_zone[thursday_0]" <?=$thu_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($open_time_zone->thursday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($open_time_zone->thursday=="pm"){echo 'selected="selected"';}?>>PM</option>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div id="div_close_time_zonethursday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->thursday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[thursday_0]" name="close_time[thursday_0]" value="<?=$close_time->thursday;?>" <?php if($closed->thursday=='yes'){
                              echo 'disabled'; }?> ></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonethursday_0" name="close_time_zone[thursday_0]" <?=$thu_attr?>>
                              <option value=" ">Select</option>
                              <option value="am" <?php if($close_time_zone->thursday=="am"){echo 'selected="selected"';}?>>AM</option>
                              <option value="pm" <?php if($close_time_zone->thursday=="pm"){echo 'selected="selected"';}?>>PM</option>
                             </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[thursday_0]" name="closed[thursday_0]" value="yes" onclick="close_day(this.id);" <?php if($closed->thursday=='yes')  { echo 'checked'; }  ?> >
                              <span></span>
                            </label>
                          </td>
                        </tr>

                        <tr id="tr_bg_checkfriday_0" <?php //if($closed->friday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Friday</td>
                          <td>
                            <div id="div_open_time_zonefriday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->friday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="open_time[friday_0]" name="open_time[friday_0]" value="<?=$open_time->friday;?>" <?php if($closed->friday=='yes'){
                              echo 'disabled'; } ?>></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                              if($closed->friday=='yes')
                                $fri_attr = ' disabled';
                              else
                                $fri_attr = 'class="select_box"';
                             ?>
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonefriday_0" name="open_time_zone[friday_0]" <?=$fri_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($open_time_zone->friday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($open_time_zone->friday=="pm"){echo 'selected="selected"';}?>>PM</option>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div class="c1 <?php if($closed->friday!='yes') { echo 'blue_bg'; }?>" id="div_close_time_zonefriday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->friday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[friday_0]" name="close_time[friday_0]" value="<?=$close_time->friday;?>" <?php if($closed->friday=='yes'){
                              echo 'disabled'; } ?> ></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonefriday_0" name="close_time_zone[friday_0]" <?=$fri_attr?>>
                              <option value=" ">Select</option>
                              <option value="am" <?php if($close_time_zone->friday=="am"){echo 'selected="selected"';}?>>AM</option>
                              <option value="pm" <?php if($close_time_zone->friday=="pm"){echo 'selected="selected"';}?>>PM</option>
                             </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[friday_0]" name="closed[friday_0]"  value="yes" onclick="close_day(this.id);" <?php if($closed->friday=='yes')  { echo 'checked'; } ?> >
                              <span></span>
                            </label>
                          </td>
                        </tr>

                        <tr id="tr_bg_checksaturday_0" <?php //if($closed->saturday=='yes') { echo 'style="background-color:#D7D7D7"'; }?>>
                          <td>Saturday</td>
                          <td>
                            <div id="div_open_time_zonesaturday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group"><input type="text" class="<?php if($closed->saturday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="open_time[saturday_0]" name="open_time[saturday_0]" value="<?=$open_time->saturday;?>" <?php if($closed->saturday=='yes'){
                              echo 'disabled'; } ?>></div>
                            <div class="gray_selectbox form-group m-form__group">
                              <?php
                                if($closed->saturday=='yes')
                                  $sat_attr = ' disabled';
                                else
                                  $sat_attr = 'class="select_box"';
                                ?>

                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="open_time_zonesaturday_0" name="open_time_zone[saturday_0]" <?=$sat_attr?>>
                                 <option value=" ">Select</option>
                                 <option value="am" <?php if($open_time_zone->saturday=="am"){echo 'selected="selected"';}?>>AM</option>
                                 <option value="pm" <?php if($open_time_zone->saturday=="pm"){echo 'selected="selected"';}?>>PM</option>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div id="div_close_time_zonesaturday_0"><span class="span_at"></span></div>
                            <div class="form-group m-form__group">
                              <input type="text" class="<?php if($closed->saturday=='yes') { echo 'textbox_un_edit';}else{ echo 'textbox'; }?> form-control m-input m-input--square" id="close_time[saturday_0]" name="close_time[saturday_0]" value="<?=$close_time->saturday;?>" <?php if($closed->saturday=='yes'){
                              echo 'disabled'; } ?>>
                            </div>
                            <div class="gray_selectbox form-group m-form__group">
                              <select class="form-control m-input m-input--square m-select2 m-select2-general" id="close_time_zonesaturday_0" name="close_time_zone[saturday_0]" <?=$sat_attr?>>
                                <option value=" ">Select</option>
                                <option value="am" <?php if($close_time_zone->saturday=="am"){echo 'selected="selected"';}?>>AM</option>
                                <option value="pm" <?php if($close_time_zone->saturday=="pm"){echo 'selected="selected"';}?>>PM</option>
                               </select>
                            </div>
                          </td>
                          <td>
                            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
                              <input type="checkbox" id="closed[saturday_0]" name="closed[saturday_0]" value="yes" onclick="close_day(this.id);" <?php if($closed->saturday=='yes') { echo 'checked="checked"'; } ?>>
                              <span></span>
                            </label>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <input type="hidden" name="id" value="<?=$brand_data['id']?>" />
                    <div class="m-portlet__foot m-portlet__foot--fit">
                      <div class="m-form__actions m-form__actions">
                        <button type="submit" name="update" class="btn btn-primary">
                          <?=($id?'Update':'Save')?>
                        </button>
                        <?php /*?><a href="general_settings.php" class="btn btn-secondary">Back</a><?php */?>
                      </div>
                    </div>
                  </form>
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
