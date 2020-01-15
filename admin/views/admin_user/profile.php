<script type="text/javascript">
  function check_form(a) {
    if (a.username.value.trim() == "") {
      alert('Please enter your username');
      a.username.focus();
      a.username.value = '';
      return false;
    }

    if (a.email.value.trim() == "") {
      alert('Please enter your email');
      a.email.focus();
      a.email.value = '';
      return false;
    }

    if (a.password.value.trim() != "") {
      if (a.rpassword.value.trim() == "") {
        alert('Please retype password.');
        a.rpassword.focus();
        a.rpassword.value = '';
        return false;
      }

      if (a.password.value.trim() != a.rpassword.value.trim()) {
        alert('Password and Retype password not matched.');
        a.rpassword.focus();
        a.rpassword.value = '';
        return false;
      }
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
                      Profile
                    </h3>
                  </div>
                </div>
              </div>
              <!--begin::Form-->
              <form class="m-form" action="controllers/admin_user/profile.php" role="form" method="post" onSubmit="return check_form(this);">
                <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group">
                      <label for="field-1">
                        Username :
                      </label>
                      <input type="text" name="username" class="form-control m-input" id="field-1" value="<?=@$get_userdata_row['username']?>" placeholder="Enter your username" required>
                      <!-- <span class="m-form__help">
                        Please enter your username
                      </span> -->
                    </div>
                    <div class="form-group m-form__group">
                      <label for="field-2">
                        E-mail :
                      </label>
                      <input type="email" name="email" class="form-control m-input" id="field-2" value="<?=@$get_userdata_row['email']?>" placeholder="Enter your E-mail" required>
                      <!-- <span class="m-form__help">
                        Please enter your username
                      </span> -->
                    </div>
                    <div class="form-group m-form__group">
                      <label for="field-3">
                        Change Password :
                      </label>
                      <input type="password" name="password" class="form-control m-input" id="field-3" placeholder="Enter your passowrd">
                      <!-- <span class="m-form__help">
                        Please enter your username
                      </span> -->
                    </div>
                    <div class="form-group m-form__group">
                      <label for="field-4">
                        Retype Password :
                      </label>
                      <input type="password" name="rpassword" class="form-control m-input" id="field-4" placeholder="Retype your passowrd">
                      <!-- <span class="m-form__help">
                        Please enter your username
                      </span> -->
                    </div>
                    <input type="hidden" name="id" value="<?=@$get_userdata_row['id']?>"/>
                    <input type="hidden" name="old_password" value="<?=@$get_userdata_row['password']?>"/>
                  </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                    <button type="submit" name="update" class="btn btn-primary">
                      Submit
                    </button>
                  </div>
                </div>
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