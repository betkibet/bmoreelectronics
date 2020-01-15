<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="x-ua-compatible" content="IE=edge" >

<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_desc?>" />
<title><?=$meta_title?></title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/owl.carousel.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/owl.theme.default.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/css-org.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/theme.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/main.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/main_media.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/intlTelInput.css">
<link rel="icon" href="<?=SITE_URL?>/images/favicon.ico" type="image/x-icon"/>

<link rel="stylesheet" href="<?=SITE_URL?>css/bootstrapValidator.min.css">

<script src="<?=SITE_URL?>js/jquery.min.js"></script>

<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">


<script>
function openNav() {
    document.getElementById("nav").style.width = "250px";
    document.getElementById("wrapper").style.marginLeft = "0";
	document.getElementById("wrapper").style.marginLeft = "0";
    //document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("nav").style.width = "0";
    document.getElementById("wrapper").style.marginLeft= "0";
    //document.body.style.backgroundColor = "white";
}
</script>

<?=$custom_js_code?>
</head>
<body <?=(trim($url_first_param)!=""?'class="inner"':'')?>>

<!-- Wrapper -->
<div id="wrapper">
	<?php
	//START for confirm message
	$confirm_message = getConfirmMessage()['msg'];
	echo $confirm_message;
	//END for confirm message ?>
		
  <!-- Header -->
  <header id="header">
    <div class="wrap clearfix">
    	<span class="menuicon" onClick="openNav()">&nbsp;</span>
        <h1 class="logo">
        	<a href="<?=SITE_URL?>">
				<?php
				if($logo_url) {
        			echo '<img src="'.$logo_url.'?uniqid='.unique_id().'" class="brand-logo" max-height="74px" max-width="119">';
				}
				if($logo_fixed_url) {
            		echo '<img src="'.$logo_fixed_url.'?uniqid='.unique_id().'" class="brand-logo-fixed" max-height="74px" max-width="119">';
				} ?>
            </a>
        </h1>
        
        <nav id="nav" class="ra_nav">
        <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">&times;</a>
        <ul>
		  <?php
		  $header_menu_list = get_menu_list('header');
		  foreach($header_menu_list as $header_menu_data) {
		  	  $is_open_new_window = $header_menu_data['is_open_new_window'];
		  	  if($header_menu_data['page_id']>0) {
			  	  $menu_url = $header_menu_data['p_url'];
				  $is_custom_url = $header_menu_data['p_is_custom_url'];
			  } else {
			      $menu_url = $header_menu_data['url'];
				  $is_custom_url = $header_menu_data['is_custom_url'];
			  }
			  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
			  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
			  
			  $menu_fa_icon = "";
			  if($header_menu_data['css_menu_fa_icon']) {
				  $menu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
			  }
			  
			  $active_m_menu_class = "";
			  if($active_page_data['menu_id']>0 && $active_page_data['menu_id']==$header_menu_data['id']) {
			  	$active_m_menu_class = " active";
			  } ?>
			  
			  <li class="<?=(count($header_menu_data['submenu'])>0?'submenu':'').$active_m_menu_class?>">
				<a href="<?=$menu_url?>" class="<?=$header_menu_data['css_menu_class']?>" <?=$is_open_new_window?>><?=$header_menu_data['menu_name'].$menu_fa_icon?></a>
				<?php
				if(count($header_menu_data['submenu'])>0) {
					$header_submenu_list = $header_menu_data['submenu'];
					echo '<ul class="droupdown">';
						foreach($header_submenu_list as $header_submenu_data) {
							$s_is_open_new_window = $header_submenu_data['is_open_new_window'];
							if($header_submenu_data['page_id']>0) {
								$s_is_custom_url = $header_submenu_data['p_is_custom_url'];
								$s_menu_url = $header_submenu_data['p_url'];
							} else {
								$s_menu_url = $header_submenu_data['url'];
								$s_is_custom_url = $header_submenu_data['is_custom_url'];
							}
							$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
							$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
							
							$submenu_fa_icon = "";
						    if($header_menu_data['css_menu_fa_icon']) {
							    $submenu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
						    }
							
							$active_s_menu_class = "";
						    if($active_page_data['menu_id']>0 && $active_page_data['menu_id']==$header_submenu_data['id']) {
							   $active_s_menu_class = " active";
						    } ?>
							<li class="<?=$active_s_menu_class?>"><a href="<?=$s_menu_url?>" class="<?=$header_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$header_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
						<?php
						}
					echo '</ul>';
				} ?>
			  </li>
		  <?php
		  } ?>
        </ul>
        </nav>
        <!-- Nav -->

		<div class="dropdown cart-btn">
			<?php
			if($basket_item_count_sum_data['basket_item_count']>0) {
        		echo '<span class="count_item">'.$basket_item_count_sum_data['basket_item_count'].'</span>';
			} ?>
        	<a href="<?=SITE_URL?>revieworder" class="dropdown-toggle link" data-toggle="dropdown">Cart</a>
			<?php
			//Get data from index.php, get_basket_item_count_sum function
			if(count($basket_item_count_sum_data['basket_item_data'])>0) { ?>
				<div class="dropdown-menu">
					<div class="inner">
						<div class="dis_table">
							<?php
							//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
							$sum_of_orders=get_order_price($order_id);

							foreach($basket_item_count_sum_data['basket_item_data'] as $order_item_data) {
								$order_item_url = $order_item_data['sef_url'].'/'.createSlug($order_item_data['model_title']).'/'.$order_item_data['model_id'].'/'.$order_item_data['storage'];
								$order_item_name = $order_item_data['model_title'].' '.$order_item_data['storage'];
								$order_item_price = amount_fomat($order_item_data['price']); ?>
								<div class="row">
									<div class="col-xs-7"><?=$order_item_name?><br><span class="text-blue"><?=$order_item_data['quantity']?> x <?=$order_item_price?></span></div>
									<div class="col-xs-3">
										<?php
										if($order_item_data['model_img']) {
											echo '<img src="'.SITE_URL.'images/mobile/'.$order_item_data['model_img'].'" class="img-fluid" height="39"/>';
										} ?>
									</div>
									<div class="col-xs-2"><a href="<?=SITE_URL?>controllers/revieworder/review.php?rorder_id=<?=$order_item_data['id']?>"><span class="remove">x</span></a></div>
								</div>
							<?php
							} ?>

							<div class="row total">
								<div class="col-xs-12">Sell Order Total <span class="price"><?=amount_fomat($sum_of_orders)?></span></div>
							</div>
							<div class="row btn_row">
								<div class="col-xs-12">
									<a href="<?=SITE_URL?>revieworder" class="btn btn-gray">VIEW CART</a>
									<?php /*?><a href="<?=SITE_URL?>revieworder" class="btn btn-blue">CHECK OUT</a><?php */?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			} else { ?>
				<div class="dropdown-menu cartempty">
					<div class="inner">No products in the cart</div>
				</div>
			<?php
			} ?>
        </div>

		<ul id="myaccountouter">
		  <?php
		  $topright_menu_list = get_menu_list('top_right');
		  foreach($topright_menu_list as $topright_menu_data) {
		  	  $is_open_new_window = $topright_menu_data['is_open_new_window'];
		  	  if($topright_menu_data['page_id']>0) {
			  	  $menu_url = $topright_menu_data['p_url'];
				  $is_custom_url = $topright_menu_data['p_is_custom_url'];
			  } else {
			  	  $menu_url = $topright_menu_data['url'];
				  $is_custom_url = $topright_menu_data['is_custom_url'];
			  }
			  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
			  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
			  
			  $menu_fa_icon = "";
			  if($topright_menu_data['css_menu_fa_icon']) {
				  $menu_fa_icon = '&nbsp;<i class="'.$topright_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
			  } ?>
			  <li <?=(count($topright_menu_data['submenu'])>0?'class="submenu"':'')?>>
				<a class="myaccount <?=$topright_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$topright_menu_data['menu_name'].$menu_fa_icon?></a>
				<ul class="adroupdown">
					<?php
					if($_SESSION['user_id']>0) { ?>
						<li><a href="<?=SITE_URL?>account">My Orders</a></li>
						<li><a href="<?=SITE_URL?>profile">My Profile</a></li>
						<li><a href="<?=SITE_URL?>controllers/logout.php">Logout</a></li>
					<?php
					} else { ?>
						<li><a href="#" id="login_link" data-toggle="modal" data-target="#signupbox">Login</a></li>
						<li><a href="#" data-toggle="modal" data-target="#signupbox">Signup</a></li>
					<?php
					}
					
					if(count($topright_menu_data['submenu'])>0) {
						$topright_submenu_list = $topright_menu_data['submenu'];
						foreach($topright_submenu_list as $topright_submenu_data) {
							$s_is_open_new_window = $topright_submenu_data['is_open_new_window'];
							if($topright_submenu_data['page_id']>0) {
								$s_is_custom_url = $topright_submenu_data['p_is_custom_url'];
								$s_menu_url = $topright_submenu_data['p_url'];
							} else {
								$s_menu_url = $topright_submenu_data['url'];
								$s_is_custom_url = $topright_submenu_data['is_custom_url'];
							}
							$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
							$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
							
							$submenu_fa_icon = "";
							if($topright_submenu_data['css_menu_fa_icon']) {
								$submenu_fa_icon = '&nbsp;<i class="'.$topright_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
							} ?>
							<li><a href="<?=$s_menu_url?>" class="<?=$topright_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$topright_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
						<?php
						}
					} ?>
				</ul>
			  </li>
		  <?php
		  } ?>
        </ul>
        
        <a href="<?=SITE_URL?>#request_quote" class="btn-quote ra_request_quote">Request A Quote</a> 

        <div class="searchbox">
        	<span class="ico-search"></span>
        </div>

        <div class="searchfield">
        	<div class="relative">
				<form action="<?=SITE_URL?>search" method="post">
            		<input class="searchbox srch_list_of_model" type="text" name="search" placeholder="Search Model...">
                	<span class="closebtn">X</span>
				</form>
            </div>
        </div>
        
      </div>
  </header>