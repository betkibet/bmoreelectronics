<!doctype html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_desc?>" />
<title><?=$meta_title?></title>

<!-- Jquery Data Table -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?=SITE_URL?>css/style.css">

<link rel="stylesheet" href="<?=SITE_URL?>css/color.css">
  
<link rel="stylesheet" href="<?=SITE_URL?>css/intlTelInput.css">

<link rel="stylesheet" href="<?=SITE_URL?>css/bootstrapValidator.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">

<?php
if($favicon_icon) {
	echo '<link rel="shortcut icon" href="'.SITE_URL.'images/'.$favicon_icon.'" />';
} ?>

<script src="<?=SITE_URL?>js/jquery.min.js"></script>
<script src="<?=SITE_URL?>js/jquery.scrollTo.min.js"></script>
<script src="<?=SITE_URL?>js/jquery.matchHeight-min.js"></script>
<?=$custom_js_code?>
<?php
require_once("include/custom_js.php");

$body_class = "";
if($page_body_class) {
	$body_class=$page_body_class;
} elseif($url_first_param=="cart") {
	$body_class="inner bg-no-repeat";
} elseif($url_first_param=="sell") { 
	$body_class="no-bg inner";
} elseif($url_first_param!="") {
	$body_class="inner";	
} ?>
</head>

<body class="<?=$body_class?>">
	<div class="social_fixed">
        <div class="float-sm">
		  <?php
		  if($site_phone) { ?>
		  <div class="fl-fl float-whatsapp">
		    <i class="fa fa-whatsapp" aria-hidden="true"></i>
		    <a href="https://api.whatsapp.com/send?phone=<?=$site_phone?>&amp;text=Hi There! Need help" target="_blank">Chat With Us</a>
		  </div>
		  <?php
		  }
		  if($site_phone) { ?>
		  <div class="fl-fl float-contact">
		    <i class="fa fa-phone" aria-hidden="true"></i>
		    <a href="tel:<?=$site_phone?>" target="_blank"><?=$site_phone?></a>
		  </div>
		  <?php
		  } ?>
	</div>	
	<?php
	echo $after_body_js_code;
	if($url_first_param!="order-completion") {
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
		//END for confirm message
	} ?>

  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-2 align-items-center">
          <div class="block logo clearfix">
            <a class="logo-link" <?=(trim($url_first_param)!=""?'':'')?> href="<?=SITE_URL?>">
				<?php
				if($logo_url) {
        			echo '<img class="desktop_logo" width="'.$logo_width.'" height="'.$logo_height.'" src="'.$logo_url.'" alt="'.SITE_NAME.'">';
				}
				if($logo_fixed_url) {
            		echo '<img width="'.$fixed_logo_width.'" height="'.$fixed_logo_height.'" src="'.$logo_fixed_url.'" class="logo-mobile" alt="'.SITE_NAME.'">';
				} ?>
            </a>
            <a class="menu-toggle" href="#">
              <span></span>
              <span></span>
              <span></span>
            </a>
            <ul class="mobile-user-menu">
              <li>
				<?php
				if(isset($_SESSION['user_id']) && $_SESSION['user_id']>0) { ?>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><img src="<?=SITE_URL?>images/icons/user.png"></a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
					  <i class="fas fa-caret-up"></i>
					  <a class="dropdown-item first-item text-center hello-text">Hello <?=$user_data['name']?></a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item last-item" href="<?=SITE_URL?>account">Orders</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item last-item" href="<?=SITE_URL?>coupons">Coupons</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item last-item" href="<?=SITE_URL?>profile">Setting</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item last-item" href="<?=SITE_URL?>statistics">Statistics</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item last-item" href="<?=SITE_URL?>bonus-system">Bonus System</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item last-item" href="<?=SITE_URL?>controllers/logout.php">Logout</a>
					</div>
				<?php
				} else { ?>
					<a href="javascript:void(0);" id="login_link" data-toggle="modal" data-target="#SignInRegistration"><img src="<?=SITE_URL?>images/icons/user.png"></a>
					<?php /*?><i class="fas fa-caret-up"></i>
					<a class="dropdown-item first-item text-center hello-text">Hello Guest</a>
					<div class="dropdown-divider"></div>
					<a href="javascript:void(0);" class="dropdown-item" id="login_link" data-toggle="modal" data-target="#SignInRegistration">Login</a><?php */?>
				<?php
				} ?>
              </li>
              <li>
                <a href="<?=SITE_URL?>cart">
                    <img src="<?=SITE_URL?>images/icons/cart.png">
					<?php
					if(isset($basket_item_count_sum_data['basket_item_count']) && $basket_item_count_sum_data['basket_item_count']>0) {
						echo '<span class="badge badge-danger">'.$basket_item_count_sum_data['basket_item_count'].'</span>';
					} ?>
                </a>
              </li>
            </ul>
            <a class="close-icon menu-toggle" href="#"><img src="<?=SITE_URL?>images/icons/close.png" alt=""></a>
          </div>
        </div>
        <div class="col-md-12 col-lg-8">
		  <?php
		  if($is_act_header_menu == '1') { ?>
          <div class="block main-menu home">
            <ul>
			  <?php
			  $is_private_menu_show = false;
			  if(isset($active_menu) && ($active_menu == "account" || $active_menu == "coupons" || $active_menu == "track_order" || $active_menu == "profile" || $active_menu == "statistics" || $active_menu == "bonus-system")) {
			  	$is_private_menu_show = true;
			  }
		  
			  $header_menu_list = get_menu_list('header');
			  foreach($header_menu_list as $header_menu_data) {
				  $is_open_new_window = $header_menu_data['is_open_new_window'];
				  if($header_menu_data['page_id']>0) {
					  $menu_url = $header_menu_data['p_url'];
				  } else {
					  $menu_url = $header_menu_data['url'];
				  }
				  $is_custom_url = $header_menu_data['is_custom_url'];
				  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
				  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
				  
				  $menu_fa_icon = "";
				  if($header_menu_data['css_menu_fa_icon']) {
					  $menu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
				  }
				  
				  $active_m_menu_class = "";
				  if(isset($active_page_data['menu_id']) && $active_page_data['menu_id']>0 && $active_page_data['menu_id']==$header_menu_data['id']) {
					$active_m_menu_class .= " active";
				  }
				  if($is_private_menu_show) {
				    // $active_m_menu_class .= " d-none d-lg-block";
				    $active_m_menu_class .= "";
				  }
				  
				  $fix_menu_popup = "";
				  if($header_menu_data['page_slug'] == "order-track") {
					  $fix_menu_popup = 'data-toggle="modal" data-target="#trackOrderForm"';
				  } elseif($header_menu_data['page_slug'] == "bulk-order-form") {
					 // $fix_menu_popup = 'data-toggle="modal" data-target="#bulkOrderForm"';
				  } ?>

				  <li class="<?=(count($header_menu_data['submenu'])>0?'submenu':'').$active_m_menu_class?>">
					<a href="<?=$menu_url?>" class="<?=$header_menu_data['css_menu_class']?>" <?=$is_open_new_window.$fix_menu_popup?>><?=$header_menu_data['menu_name'].$menu_fa_icon?> <!-- <i class="fa fa-chevron-down" aria-hidden="true"></i> --></a>
					<?php
					if(count($header_menu_data['submenu'])>0) {
						$header_submenu_list = $header_menu_data['submenu'] ;

						echo '<ul class="droupdown">';

							foreach($header_submenu_list as $header_submenu_data) {
								$s_is_open_new_window = $header_submenu_data['is_open_new_window'];
								if($header_submenu_data['page_id']>0) {
									$s_menu_url = $header_submenu_data['p_url'];
								} else {
									$s_menu_url = $header_submenu_data['url'];
								}
								$s_is_custom_url = $header_submenu_data['is_custom_url'];
								$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
								$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
								
								$submenu_fa_icon = "";
								if($header_menu_data['css_menu_fa_icon']) {
									$submenu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
								}
								
								$active_s_menu_class = "";
								if(isset($active_page_data['menu_id']) && $active_page_data['menu_id']>0 && $active_page_data['menu_id']==$header_submenu_data['id']) {
								   $active_s_menu_class = " active";
								} ?>
								<li class="<?=$active_s_menu_class?>"><a href="<?=$s_menu_url?>" class="<?=$header_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$header_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
							<?php
							}
						echo '</ul>';
					} ?>
				  </li>
			  <?php
			  }
			  if($is_private_menu_show) {
			  	$num_of_order = get_order_list_by_user_id($user_id)['num_of_orders']; ?>
				<!-- <li class="d-block d-lg-none <?php if($active_menu == "account"){echo 'active';}?>">
					<a href="<?=SITE_URL?>account"><span><img src="<?=SITE_URL?>images/icons/orders.png" alt="orders"></span>Orders <?php if($num_of_order>0){echo '<span class="count">('.$num_of_order.')</span>';}?></a>
				</li>
				<li class="d-block d-lg-none <?php if($active_menu == "coupons"){echo 'active';}?>">
					<a href="<?=SITE_URL?>coupons"><span><img src="<?=SITE_URL?>images/icons/coupon.png" alt="coupons"></span>Coupons</a>
				</li> -->
				<?php /*?><li class="d-block d-lg-none <?php if($active_menu == "track_order"){echo 'active';}?>">
					<a href="<?=SITE_URL?>track-order"><span><img src="<?=SITE_URL?>images/icons/track-order.png" alt="track order"></span>Track order</a>
				</li><?php */?>
				<!-- <img src="<?=SITE_URL?>images/icons/setting.png" alt="settings"> -->
				<!-- <li class="d-block d-lg-none <?php if($active_menu == "profile"){echo 'active';}?>">
					<a href="<?=SITE_URL?>profile"><span></span>Settings</a>
				</li>
				<li class="d-block d-lg-none <?php if($active_menu == "statistics"){echo 'active';}?>">
					<a href="<?=SITE_URL?>statistics"><span><img src="<?=SITE_URL?>images/icons/statistics.png" alt="statistics"></span>Statistics</a>
				</li>
				<li class="d-block d-lg-none <?php if($active_menu == "bonus-system"){echo 'active';}?>">
					<a href="<?=SITE_URL?>bonus-system"><span><img src="<?=SITE_URL?>images/icons/bonus.png" alt="bonus system"></span>Bonus system</a>
				</li> -->
			  <?php
			  } ?>
            </ul>
          </div>
		  <?php
		  } ?>
        </div>
        <div class="col-md-5 col-lg-2">
          <div class="block user-menu clearfix">
            <ul class="justify-content-end">
				<li>
					<?php
					if(isset($_SESSION['user_id']) && $_SESSION['user_id']>0) { ?>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><img src="<?=SITE_URL?>images/icons/user.png"></a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
						  <i class="fas fa-caret-up"></i>
						  <a class="dropdown-item first-item text-center hello-text" <?php /*?>href="<?=SITE_URL?>profile"<?php */?>>Hello <?=$user_data['name']?></a>
						  <div class="dropdown-divider"></div>
						  <a class="dropdown-item last-item" href="<?=SITE_URL?>account">My Account</a>
						  <div class="dropdown-divider"></div>
						  <a class="dropdown-item last-item" href="<?=SITE_URL?>controllers/logout.php">Logout</a>
						</div>
					<?php
					} else { ?>
						<a href="javascript:void(0);" data-toggle="modal" data-target="#SignInRegistration"><img src="<?=SITE_URL?>images/icons/user.png"></a>
						<?php /*?><i class="fas fa-caret-up"></i>
						<a class="dropdown-item first-item text-center hello-text">Hello Guest</a>
						<div class="dropdown-divider"></div>
						<a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#SignInRegistration">Login</a><?php */?>
					<?php
					} ?>
				</li>
				<li>
					<a href="<?=SITE_URL?>cart">
						<img src="<?=SITE_URL?>images/icons/cart.png">
						<?php
						if(isset($basket_item_count_sum_data['basket_item_count']) && $basket_item_count_sum_data['basket_item_count']>0) {
							echo '<span class="badge badge-danger">'.$basket_item_count_sum_data['basket_item_count'].'</span>';
						} ?>
					</a>
				</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>