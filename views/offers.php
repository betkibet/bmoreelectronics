<?php
//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" width="100%">
		<!--<div class="header-caption">
			<h2><?=$active_page_data['title']?></h2>
		</div>-->
	</section>
<?php
} ?>

<main>
  <section class="showcase-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block clearfix showcase-block">
            <div class="head text-center clearfix">
              <p>PROMOCODES & COUPONS</p>
              <div class="h2">You’ve just hit the</div>
              <div class="h3">Discount Jackpot.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="offer-section">
    <div class="container">
		<div class="row">
			<?php
			$promocode_list = get_promocode_list('future');
			if(count($promocode_list) > 0) {
				foreach($promocode_list as $promocode_data) { ?>
				  <div class="col-md-3">
					<div class="block clearfix offer-item">
						<?php
						if($promocode_data['image']!="") {
							echo '<img src="'.SITE_URL.'images/promocodes/'.$promocode_data['image'].'" alt=""/>';
						} ?>
						
						<p class="discount">
						<?php
						if($promocode_data['discount_type']=="flat") {
							echo amount_fomat($promocode_data['discount']).' OFF';
						} elseif($promocode_data['discount_type']=="percentage") {
							echo $promocode_data['discount'].'% OFF';
						} ?></p>
						
						<p><?=$promocode_data['description']?></p>
						
						<p class="date">
						<?php
						if($promocode_data['never_expire'] == '1') {
							echo 'Never Expire';
						} else {
							echo date("m/d/Y",strtotime($promocode_data['to_date']));
						} ?></p>
						
						<h1><?=$promocode_data['promocode']?></h1>
						<?php
						if($promocode_data['multiple_act_by_same_cust']=='1' && $promocode_data['multi_act_by_same_cust_qty']>0) {
							echo '<p class="msg">*Limited per customer</p>';
						} ?>
					</div>
				  </div>
				<?php 
				}
			} else { ?>
			  <div class="col-md-3">
				<div class="block clearfix offer-item">
				  <h3>No offer found</h3>
				</div>
			  </div>
			<?php
			} ?>
		</div>
    </div>
  </section>
  <section id="best-deals-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block clearfix best-deals-block">
            <img src="images/gift_box.png" alt="">
            <h1>Looking for the best deals?</h1>
            <h3>You’re in the right place.</h3>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>