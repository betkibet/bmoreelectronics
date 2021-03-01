<?php
$meta_title = "Bonus System";
$active_menu = "bonus-system";

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

$bonus_data_list = get_bonus_data_list();
$upto_percentage = $bonus_data_list[0]['percentage']; ?>

  <section id="showAccount" class="py-0">
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
            <?php require_once('views/account_menu.php');?>
          </div>
          <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
            <div class="block heading page-heading pt-4 setting-heading">
                <h3>For wholesalers and regular customers</h3>
            </div>
            <div class="block mt-0 pt-0 page-content">
              <p>Valued customers.</p>
              <p>We are appriciate our bussiness with every our customer. We are doing our work honest. We try to be the best company in the industry of used cell phones. Our offers for used electronics is best on the market and we have for you more!</p>
              <p>If you are wholesaller or regular customer we'll pay you more. Please, check out our bonus system that works fully automated and will allow you to get up to <?=$upto_percentage?>% bonus for your orders.</p>
              <p>Thank you four your bussines!</p>
              <div class="row">
                <div class="col-md-12 col-lg-5">
                  <table class="table table-stripped table-percentage">
                    <tr>
                      <th>Bonus</th>
                      <th>Paid devices</th>
                    </tr>
					<?php
					if(!empty($bonus_data_list)) {
						foreach($bonus_data_list as $bonus_data) { ?>
							<tr>
							  <td><?=$bonus_data['percentage']?> %</td>
							  <td><?=$bonus_data['paid_device']?></td>
							</tr>
						<?php
						}
					} ?>
                  </table>
                </div>
                <div class="col-md-12 col-lg-7 bonus-up">
                  <h4>Up your<br />bonus to <span><?=$upto_percentage?>%</span></h4>
                  <p>We are appriciate our bussiness with every our customer. We are doing our work honest. We try to be the best company in the industry of used cell phones. Our offers for used electronics is best on the market and we have for you more!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>