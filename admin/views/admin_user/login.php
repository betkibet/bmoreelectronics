<script type="text/javascript">
function checklogin(a){
	if(a.username.value.trim()==""){
		alert('Please enter your username');
		a.username.focus();
		a.username.value='';
		return false;
	}
	if(a.password.value.trim()==""){
		alert('Please enter your password');
		a.password.focus();
		a.password.value='';
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
          <a href="<?=ADMIN_URL?>">
            <?=$admin_logo?>
          </a>
        </div>
		
        <div class="m-login__signin">
          <?php
          require_once('confirm_message.php'); ?>
          <div class="m-login__head">
            <h3 class="m-login__title">
              Sign In To <?=ADMIN_PANEL_NAME?> Admin
            </h3>
          </div>
          <form class="m-login__form m-form" action="controllers/admin_user/login.php" method="post" role="form" onSubmit="return checklogin(this);">
            <div class="form-group m-form__group">
              <input class="form-control m-input" type="text" name="username" id="username" placeholder="Username" autocomplete="off" value="<?=$cookie_data['username']?>">
            </div>
            <div class="form-group m-form__group">
              <input class="form-control m-input m-login__form-input--last" type="password" name="password" id="password" placeholder="Password" autocomplete="off" value="<?=$cookie_data['password']?>">
            </div>
            <div class="row m-login__form-sub">
              <div class="col m--align-left m-login__form-left">
                <label class="m-checkbox  m-checkbox--focus">
                  <input type="checkbox" name="remember_me" value="1" <?php if($cookie_data['remember_me'] == "1"){echo 'checked="checked"';}?>>
                  Remember me
                  <span></span>
                </label>
              </div>
              <div class="col m--align-right m-login__form-right">
                <a href="javascript:;" id="m_login_forget_password" class="m-link">
                  Forget Password ?
                </a>
              </div>
            </div>
            <div class="m-login__form-action">
              <!-- <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary" type="submit" name="login">
                Sign In
              </button> -->
              <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" type="submit" name="login">Login</button>
            </div>
          </form>
        </div>
        
        <div class="m-login__forget-password">
          <div class="m-login__head">
            <h3 class="m-login__title">
              Forgotten Password ?
            </h3>
            <div class="m-login__desc">
              Enter your email to reset your password:
            </div>
          </div>
          <form class="m-login__form m-form" action="controllers/admin_user/lostlogin.php" method="post" role="form" onSubmit="return check_form(this);">
            <div class="form-group m-form__group">
              <input class="form-control m-input" type="email" id="m_email" name="email" placeholder="Enter email" autocomplete="off" required>
            </div>
            <div class="m-login__form-action">
              <button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr" name="reset">
                Request
              </button>
              &nbsp;&nbsp;
              <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">
                Cancel
              </button>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- end:: Page -->
