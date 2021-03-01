<?php
$meta_title = "Account - Profile / My Orders / Change Password";
$active_menu = "account";

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

$order_dlist = get_order_list_by_user_id($user_id);
$order_data_list = $order_dlist['order_list']; ?>

  <section id="showAccount" class="py-0">
    <div class="container-fluid">
			
      <div class="block setting-page account py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
          	<?php require_once('views/account_menu.php');?>
          </div>
          <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
						<div class="block heading page-heading setting-heading clearfix">
				<h3 class="float-left">Orders</h3>
			</div>
            <div class="block order-list text-center">
			  <?php
			  if(!empty($order_data_list)) { ?>
              <table id="ac_table_id" class="display">
                <thead>
                  <tr>
                    <th class="no-sort">ID</th>
                    <th>Date<span></span></th>
                    <th>Devices QTY<span></span></th>
                    <th>Last update<span></span></th>
                    <th class="no-sort">Status</th>
                    <th class="d-md-none"></th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  foreach($order_data_list as $order_data) {?>
				  <tr>
					<td><span>ID</span><a href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>"><?=$order_data['order_id']?></a></td>
					<td data-sort="<?=$order_data['date']?>"><span>Date</span><?=format_date($order_data['date'])?></td>
					<td><span>Devices QTY</span><?=$order_data['items_quantity']?></td>
					<td><span>Last update</span><?=($order_data['update_date']!='0000-00-00 00:00:00'?format_date($order_data['update_date']):'No updates yet')?></td>
					<td><span>Status</span>
						<label class="badge badge-danger text-light"><small><?=replace_us_to_space($order_data['order_status_name'])?></small></label>
					</td>
					<td class="d-md-none"><a class="btn btn-lg btn-outline-dark rounded-pill ml-lg-5" href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>">more info</a></td>
				  </tr>
				  <?php
				  } ?>
                </tbody>
              </table>

              <div class="table d-block d-md-none">
			    <?php
				$pagination = new Paginator($page_list_limit,'p');
				
				$order_dlist = get_order_list_by_user_id($user_id,'',$page_list_limit,'1');
				$order_data_list = $order_dlist['order_list'];
				foreach($order_data_list as $order_data) {?>
				<div class="tr clearfix">
				  <div class="td head"><span>ID</span><a href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>"><?=$order_data['order_id']?></a></div>
				  <div class="td"><span>Date</span><?=format_date($order_data['date'])?></div>
				  <div class="td"><span>Devices QTY</span><?=$order_data['items_quantity']?></div>
				  <div class="td"><span>Last update</span><?=($order_data['update_date']!='0000-00-00 00:00:00'?format_date($order_data['update_date']):'No updates yet')?></div>
				  <div class="td"><span>Status</span><span class="text-danger d-block"><?=replace_us_to_space($order_data['order_status_name'])?></span></div>
				  <div class="td last"><a class="btn btn-lg btn-outline-dark rounded-pill ml-lg-5" href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>">more info</a></div>
				</div>
				<?php
				} ?>
              </div>
			  
			  <div class="d-block div-table-pagination d-md-none">
			  	<?php
			  	echo $pagination->page_links(); ?>
			  </div>
			  <?php
			  } else {
			  	echo '<h4>You have no orders yet.</h4>';
			  } ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>