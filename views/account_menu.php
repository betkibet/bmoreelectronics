<?php
//$num_of_order = get_order_list_by_user_id($user_id)['num_of_orders']; ?>

<div class="inner clearfix">
  <ul>
	<li>
	  <a <?php if($active_menu == "account"){echo 'class="active"';}?> href="<?=SITE_URL?>account"><span><img src="<?=SITE_URL?>images/icons/orders.png" alt="orders"></span>Orders <?php if($num_of_order>0){echo '<span class="count">('.$num_of_order.')</span>';}?></a>
	</li>
	<li>
	  <a <?php if($active_menu == "coupons"){echo 'class="active"';}?> href="<?=SITE_URL?>coupons"><span><img src="<?=SITE_URL?>images/icons/coupon.png" alt="coupons"></span>Coupons</a>
	</li>
	<?php /*?><li>
	  <a <?php if($active_menu == "track_order"){echo 'class="active"';}?> href="<?=SITE_URL?>track-order"><span><img src="<?=SITE_URL?>images/icons/track-order.png" alt="track order"></span>Track order</a>
	</li><?php */?>
	<li>
	  <a <?php if($active_menu == "profile"){echo 'class="active"';}?> href="<?=SITE_URL?>profile"><span><img src="<?=SITE_URL?>images/icons/setting.png" alt="settings"></span>Settings</a>
	</li>
	<li>
	  <a <?php if($active_menu == "statistics"){echo 'class="active"';}?> href="<?=SITE_URL?>statistics"><span><img src="<?=SITE_URL?>images/icons/statistics.png" alt="statistics"></span>Statistics</a>
	</li>
	<?php /*?><li>
	  <a <?php if($active_menu == "support"){echo 'class="active"';}?> href="<?=SITE_URL?>support"><span><img src="<?=SITE_URL?>images/icons/support.png" alt="support"></span>Support</a>
	</li>
	<li>
	  <a <?php if($active_menu == "security"){echo 'class="active"';}?> href="<?=SITE_URL?>security"><span><img src="<?=SITE_URL?>images/icons/security.png" alt="security"></span>Security</a>
	</li><?php */?>
	<?php /*?><li>
	  <a <?php if($active_menu == "bonus-system"){echo 'class="active"';}?> href="<?=SITE_URL?>bonus-system"><span><img src="<?=SITE_URL?>images/icons/bonus.png" alt="bonus system"></span>Bonus system</a>
	</li><?php */?>
  </ul>
  <?php
  $bonus_data = get_bonus_data_info_by_user($user_id);
  $bonus_percentage = $bonus_data['bonus_data']['percentage'];
  if($active_menu == "bonus-system" && $bonus_percentage>0) { ?>
  <div class="row get-bonus pt-4">
	<div class="col-6">
	  <img src="images/icons/gift-icon-large.png" alt="">
	</div>
	<div class="col-6">
	  <h4>Your bonus</h4>
	  <p><?=$bonus_percentage?>%</p>
	</div>
  </div>
  <?php
  } ?>
</div>