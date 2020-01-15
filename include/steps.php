<?php
if($order_steps=='1') {
	$step1 = 'current-step';
	$step2 = 'disabled-step';
	$step3 = 'disabled-step';
	$step4 = 'disabled-step';

	$step1_icon = ' class="active"';
	$step2_icon = '';
	$step3_icon = '';
	$step4_icon = '';
} elseif($order_steps=='2') {
	$step1 = 'active-step';
	$step2 = 'current-step';
	$step3 = 'disabled-step';
	$step4 = 'disabled-step';

	$step1_icon = ' class="active"';
	$step2_icon = ' class="active"';
	$step3_icon = '';
	$step4_icon = '';
} elseif($order_steps=='3') {
	$step1 = 'active-step';
	$step2 = 'active-step';
	$step3 = 'current-step';
	$step4 = 'disabled-step';

	$step1_icon = ' class="active"';
	$step2_icon = ' class="active"';
	$step3_icon = '';
	$step4_icon = '';
} elseif($order_steps=='4') {
	$step1 = 'active-step';
	$step2 = 'active-step';
	$step3 = 'active-step';
	$step4 = 'current-step';

	$step1_icon = ' class="active"';
	$step2_icon = ' class="active"';
	$step3_icon = ' class="active"';
	$step4_icon = '';
} elseif($order_steps=='5') {
	$step1 = 'active-step';
	$step2 = 'active-step';
	$step3 = 'active-step';
	$step4 = 'current-step';

	$step1_icon = ' class="active"';
	$step2_icon = ' class="active"';
	$step3_icon = ' class="active"';
	$step4_icon = ' class="active"';
} ?>

<div class="row">
	<div class="col-md-12">
	  <div class="items-steps clearfix">
		<ul>
		  <li <?=$step1_icon?>><a href="#"><span class="text"><strong>ADD ITEMS</strong></span><span class="line-bar"><strong class="icon icon1">1</strong><i class="fa fa-check" aria-hidden="true"></i>
</span><span class="line"></span></a></li>
		  <li <?=$step2_icon?>><a href="#"><span class="text"><strong>REVIEW SALE</strong></span><span class="line-bar"><strong class="icon icon2">2</strong><i class="fa fa-check" aria-hidden="true"></i>
</span><span class="line"></span></a></li>
		  <li <?=$step3_icon?>><a href="#"><span class="text"><strong>YOUR DETAILS</strong></span><span class="line-bar"><strong class="icon icon3">3</strong><i class="fa fa-check" aria-hidden="true"></i>
</span><span class="line"></span></a></li>
		  <li <?=$step4_icon?>><a href="#"><span class="text"><strong>COMPLETE SALE</strong></span><span class="line-bar"><strong class="icon icon4">4</strong><i class="fa fa-check" aria-hidden="true"></i>
</span><span class="line"></span></a></li>
		</ul>
	  </div>
	</div>
</div>