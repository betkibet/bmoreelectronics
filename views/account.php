<?php
//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} ?>

  <!-- Main -->
  <div id="main" class="myorder_page">
    <section id="user_profile_sec" class="sectionbox white-bg">
      <div class="wrap clearfix">
        	<div id="sidebar_profile">
            	<div class="profile_pic clearfix">
                	<div class="inner">
                    	<?php
						if($user_data['image']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/avatar/'.$user_data['image'].'&w=157&h=157';
                    		echo '<img src="'.$md_img_path.'">';
        				} else {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/placeholder_avatar.jpg&w=157&h=157';
							echo '<img src="'.$md_img_path.'">';
						} ?>
                    </div>
                </div>
                <div class="profile_nav ecolumn">
                	<ul>
                    	<li class="active"><a href="account">My Orders</a></li>
                        <li><a href="profile">Profile</a></li>
                        <li><a href="change-password">Change Password</a></li>
                    </ul>
                    <div class="logout">
                        <a href="controllers/logout.php">Logout</a>
                    </div>
                </div>
            </div><!--#sidebar_profile-->
            
            <div id="container_profile">
            	<div class="inner ecolumn">
                    <h4>Order History</h4>
                    <div id="review-sale-table" class="clearfix">
                    <div class="table-responsive table-bordered">          
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order</th>
                            <th>Order date</th>
                            <th>Status</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">offer</th>
                          </tr>
                        </thead>
						<tbody>
						<?php
						$pages = new Paginator($page_list_limit,'p');
						
						$order_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders WHERE user_id='".$user_id."' AND user_id>0");
						$order_data = mysqli_fetch_assoc($order_query);
						$pages->set_total($order_data['num_of_orders']);
						
						if($order_data['num_of_orders']>0) {
							$order_items_query=mysqli_query($db,"SELECT * FROM orders WHERE user_id='".$user_id."' AND user_id>0 ORDER BY order_id DESC ".$pages->get_limit()."");
							while($order_list=mysqli_fetch_assoc($order_items_query)) {
								$order_price = 0;
								$order_price = get_order_price($order_list['order_id']);
								
								$msg_query=mysqli_query($db,"SELECT * FROM order_messaging WHERE order_id='".$order_list['order_id']."' ORDER BY id DESC");
								$num_msg_rows = mysqli_num_rows($msg_query); ?>
								<tr>
									<td><div class="order"><a href="view_order/<?=$order_list['order_id'].($post['p']>0?'&p='.$post['p']:'')?>"><?=$order_list['order_id']?></a></div></td>
									<td><div class="orderdate"><?=date('m-d-Y',strtotime($order_list['date']))?></div></td>
								<td><div class="status text-red">
									<?=ucwords(str_replace('_',' ',$order_list['status']))?>
									<?php
									if($order_list['status'] == "awaiting_delivery") { ?>
									  <a href="<?=SITE_URL?>controllers/order/order.php?order_id=<?=$order_list['order_id']?>&mode=del"
										class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order?');"
										style="padding:2px 10px;">Cancel Order</a>
									<?php
									} ?>
								</div></td>
								<td><div class="price text-center"><?=amount_fomat($order_price)?></div></td>
								<td>
									<div class="offer text-center">
									<?php
									if(($order_list['status']=="processed" || $order_list['status']=="problem") && $num_msg_rows>0) {
										echo '<a class="btn offer-button" href="order_offer/'.$order_list['order_id'].($post['p']>0?'?p='.$post['p']:'').'"><i class="fa fa-gift" aria-hidden="true"></i>&nbsp;Offer</a>';
									} else {
										echo 'Offer Not Available';
									} ?>
									</div>
								</td>
								</tr>
							<?php
							}
							echo '<tr><td class="divider" colspan="5">'.$pages->page_links().'</td></tr>';
						} else { ?>
							<tr>
								<td colspan="5" align="center">No Data Found</td>
							</tr>
						<?php
						} ?>
						</tbody>
                      </table>
                    </div>
                </div>
				
                <div id="sellorderstatus">
                	<h4>Sell Order status</h4>
                	<div class="row">
                    	<div class="col-sm-6 listouter">
                        	<div class="list"><span>Submitted</span> - You order has been submitted.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Expired</span> - We never received your mobile(s) - 14 days.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Expiring</span> - Still awaiting your mobile(s) - 7 days.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Processed</span> - Mobile(s) received and checked, payment pending.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Received</span> - Mobile(s) received, not yet checked.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Rejected</span> - Your order has been rejected.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Problem</span> - Problem with your order.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Posted</span> - Date mobile(s) posted recorded, awaiting mobile(s).</div>
                        </div>
						
						<div class="col-sm-6 listouter">
                        	<div class="list"><span>Completed</span> - Order complete, payment sent.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Offer Accepted</span> - Your offer has been accepted.</div>
                        </div>
						<div class="col-sm-6 listouter">
                        	<div class="list"><span>Returned</span> - Mobile(s) have been returned.</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>Offer Rejected</span> - Your offer has been rejected.</div>
                        </div>
						<div class="col-sm-6 listouter">
                        	<div class="list"><span>Awaiting Delivery</span> - Sales Pack printed/posted, awaiting mobile(s).</div>
                        </div>
                        <div class="col-sm-6 listouter">
                        	<div class="list"><span>&nbsp;</span>&nbsp;</div>
                        </div>
                    </div>
                </div>
                     
                </div><!--.inner-->
            </div><!--#container_profile-->
      	</div>
    </section>
  </div>
  <!-- /.main -->
