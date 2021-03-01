<?php
$meta_title = "My Coupons";
$active_menu = "coupons";

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} elseif($user_data['status'] == '0' || empty($user_data)) {
	$is_include = 1;
	require_once('controllers/logout.php');

	$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

$promocode_list = get_promocode_list(); ?>

  <section id="showAccount" class="py-0">
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
          	<?php require_once('views/account_menu.php');?> 
          </div>
          <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
						<div class="block heading page-heading setting-heading clearfix">
				<h3 class="float-left">Coupons</h3>
			</div>
            <div class="block order-list text-center">
			  <?php
			  if(!empty($promocode_list)) { ?>
              <table id="ac_table_id" class="display">
                <thead>
                  <tr>
                    <th class="no-sort">Code</th>
                    <th class="no-sort">Name<span></span></th>
                    <th>Expiration Date<span></span></th>
                    <th>Value<span></span></th>
                    <th class="no-sort">Status</th>
                    <!--<th class="d-md-none"></th>-->
                  </tr>
                </thead>
                <tbody>
				  <?php
				  foreach($promocode_list as $promocode_data) { ?>
				  <tr>
					<td><span>Code</span><?=$promocode_data['promocode']?></td>
					<?php /*?><td><span>Promo</span><?=date("m/d/Y",strtotime($promocode_data['from_date']))?></td><?php */?>
					<td><span>Name</span><?=$promocode_data['name']?></td>
					<td data-sort="<?=($promocode_data['never_expire'] != '1'?$promocode_data['to_date']:'')?>"><span>Expiration Date</span><?php
					if($promocode_data['never_expire'] == '1') {
						echo 'Never Expire';
					}/* elseif($promocode_data['to_date']>=date("Y-m-d")) {
						echo dateDiffInDays(date("Y-m-d"), $promocode_data['to_date']);
					}*/ else {
						echo format_date($promocode_data['to_date']);
					} ?></td>
					<td><span>Value</span><?php
					if($promocode_data['discount_type']=="flat") {
						echo amount_fomat($promocode_data['discount']).' OFF';
					} elseif($promocode_data['discount_type']=="percentage") {
						echo $promocode_data['discount'].'% OFF';
					} ?></td>
					<td><span>Status</span>
					<?php
					if($promocode_data['never_expire'] == '1') {
						echo '<span class="badge badge-primary d-block">Active</span>';
					} elseif($promocode_data['to_date']>=date("Y-m-d")) {
						echo '<span class="badge badge-success d-block">Active</span>';
					} else {
						echo '<span class="badge badge-danger d-block">Expired</span>';
					} ?>
					</td>
					<!--<td class="d-md-none"><a class="btn btn-lg btn-outline-dark rounded-pill ml-lg-5" href="#">more info</a></td>-->
				  </tr>
				  <?php
				  } ?>
                </tbody>
              </table>
			  
              <div class="table d-block d-md-none">
				  <?php
				  $pagination = new Paginator($page_list_limit,'p');

				  $promocode_list = get_promocode_list('',$page_list_limit,'1');
				  foreach($promocode_list as $promocode_data) { ?>
					<div class="tr clearfix">
					  <div class="td head"><span>Code</span><?=$promocode_data['promocode']?></div>
					  <?php /*?><div class="td"><span>Promo</span><?=date("m/d/Y",strtotime($promocode_data['from_date']))?></div><?php */?>
					  <div class="td"><span>Name</span><?=$promocode_data['name']?></div>
					  <div class="td"><span>Expiration Date</span><?php
						if($promocode_data['never_expire'] == '1') {
							echo 'Never Expire';
						}/* elseif($promocode_data['to_date']>=date("Y-m-d")) {
							echo dateDiffInDays(date("Y-m-d"), $promocode_data['to_date']);
						}*/ else {
							echo format_date($promocode_data['to_date']);
						} ?></div>
					  <div class="td"><span>Value</span><?php
						if($promocode_data['discount_type']=="flat") {
							echo amount_fomat($promocode_data['discount']).' OFF';
						} elseif($promocode_data['discount_type']=="percentage") {
							echo $promocode_data['discount'].'% OFF';
						} ?></div>
					  <div class="td"><span>Status</span><span class="text-primary d-block"><?php
						if($promocode_data['never_expire'] == '1') {
							echo '<span class="text-primary d-block">Active</span>';
						} elseif($promocode_data['to_date']>=date("Y-m-d")) {
							echo '<span class="text-primary d-block">Active</span>';
						} else {
							echo '<span class="text-danger d-block">Expired</span>';
						} ?></span></div>
					  <!-- <div class="td last"><a class="btn btn-lg btn-outline-dark rounded-pill ml-lg-5" href="/model_details.html">more info</a></div> -->
					</div>
				  <?php
				  } ?>
              </div>
			  
			  <div class="d-block div-table-pagination d-md-none">
			  	<?php
			  	echo $pagination->page_links(); ?>
			  
				<!--<div class="row">
					<div class="col-8">
						<ul class="pagination">
							<li class="page-item"><a class="page-link" href="#">Previous</a></li>
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">Next</a></li>
						</ul>
					</div>
					<div class="col-4">
						<select class="custom-select">
							<option value="1">10</option>
							<option value="2">20</option>
							<option value="3">30</option>
						</select>
					</div>
				</div>-->
			  </div>
			  <?php
			  } else {
			  	echo '<h4>You have no coupons yet.</h4>';
			  } ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>