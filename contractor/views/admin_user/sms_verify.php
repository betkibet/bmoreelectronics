<script type="text/javascript">
function checklogin(a){
	if(a.sms_code.value.trim()=="") {
		a.sms_code.focus();
		a.sms_code.value='';
		return false;
	}
}
</script>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
  <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url('assets/app/media/img//bg/bg-3.jpg');">
    <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
      <div class="m-login__container">
        <div class="m-login__logo">
          <a href="<?=CONTRACTOR_URL?>">
            <?=$admin_logo?>
          </a>
        </div>
		
        <div class="m-login__signin">
          <?php
          require_once('confirm_message.php'); ?>
          <div class="m-login__head">
            <h3 class="m-login__title">
              Welcome to <?=ADMIN_PANEL_NAME?> Admin
            </h3>
          </div>
          <form class="m-login__form m-form" action="controllers/admin_user/sms_verify.php" method="post" role="form" onSubmit="return checklogin(this);">
            <div class="form-group m-form__group">
				<input type="text" class="form-control m-input" name="sms_code" id="sms_code" placeholder="Enter Verify Code" autocomplete="off" maxlength="7" />
            </div>
            
            <div class="m-login__form-action">
              <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" type="submit" name="login">Login</button>
			  
			  <a href="controllers/admin_user/sms_verify.php?cancel=yes" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">
                Cancel
              </a>
			  
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- end:: Page -->

