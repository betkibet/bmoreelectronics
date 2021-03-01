<?php
$meta_title = "Statistics";
$active_menu = "statistics";

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
} ?>

  <section id="showAccount" class="py-0">
    <div class="container-fluid">
      <div class="row">
       <div class="col-md-12">
          <div class="block setting-page account py-0 clearfix">
            <div class="row">
              <div class="col-md-5 left-menu col-lg-4 col-xl-3">
				<?php require_once('views/account_menu.php');?>
			  </div>
              <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
                <div class="block heading page-heading pt-4 setting-heading clearfix">
                  <div class="float-left">
                    <h3 class="mb-3">Statistics for the whole period</h3>
                  </div>
                  <div class="float-right">
                    <form class="statistic-form" id="statistic-form">
                      <select class="custom-select" name="stat_period" id="stat_period" onchange="check_statistic_info();">
                        <option value="all" selected>All time</option>
						<option value="last_month">Last month</option>
                        <option value="3_month">3 month</option>
                        <option value="6_month">6 month</option>
                        <option value="9_month">9 month</option>
                      </select>
                    </form>
                  </div>
                </div>
                <div class="block statistic-info"></div>
              </div>
            </div>
          </div>
       </div>
      </div>
    </div>
  </section>
  
<script>
function check_statistic_info() {
	jQuery(document).ready(function($) {
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/statistic_info.php',
			data: $('#statistic-form').serialize(),
			success: function(data) {
				if(data!="") {
					$('.statistic-info').html(data);
					return false;
				}
			}
		});
	});
}
check_statistic_info();
</script>