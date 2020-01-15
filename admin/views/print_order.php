<div id="wrapper">
	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header>
					<h2>Invoice #<?=$order_id?></h2>
					<ul class="data-header-actions">
						<li><a onclick="javascript:window.print();return false;" href="#"><i class="icon-print"></i></a></li>
					</ul>
				</header>
				<section>
					<!-- Grid row -->
					<div class="row-fluid">
						<div class="span4">
							<div class="well">
								<h4 class="no-margin"><?=$order_data['name']?></h4>
								<dl class="no-bottom-margin">
									<dt>Address:</dt>
									<dd><?=$order_data['address']?></dd>
									<dd><?=$order_data['city'].', '.$order_data['state'].' '.$order_data['postcode']?></dd>
									<dd><?=$order_data['country']?></dd>
									<dt>Contact:</dt>
									<dd><a href="mailto:<?=$order_data['email']?>"><?=$order_data['email']?></a></dd>
								</dl>
							</div>
						</div>

						<div class="span4">
							<div class="well">
								<h4 class="no-margin">Billing details</h4>
								<dl class="no-bottom-margin">
									<dt>Total Amount:</dt>
									<dd><?=amount_fomat($total_of_order)?></dd>
									<dt>Invoice Number:</dt>
									<dd>#<?=$order_id?></dd>
									<dt>Invoice Date:</dt>
									<dd><?=date("m-d-Y h:i",strtotime($order_data['date']))?></dd>
									<dt>Approved Date:</dt>
									<dd>
									<?php
									if($order_data['approved_date']=="0000-00-00 00:00:00")
										echo 'xx-xx-xxxx';
									else 
										echo date("m-d-Y h:i",strtotime($order_data['approved_date']));
									?>
									<dt>Due Date:</dt>
									<dd>
									<?php
									if($order_data['expire_date']=="0000-00-00 00:00:00")
										echo 'xx-xx-xxxx';
									else 
										echo date("m-d-Y h:i",strtotime($order_data['expire_date']));
									?>
								</dl>
							</div>
						</div>
						<div class="span4">
							<div class="well">
								<h4 class="no-margin">Payment Details</h4>
								<dl class="no-bottom-margin">
									<dt>Payment Method:</dt>
									<dd><?=ucfirst($order_data['payment_method'])?></dd>
									<?php
									if($order_data['payment_method']=="paypal") { ?>
										<dt>Paypal Address:</dt>
										<dd><?=$order_data['paypal_address']?></dd>
									<?php
									} else if($order_data['payment_method']=="bank") { ?>
										<dt>Account Name:</dt>
										<dd><?=$order_data['act_name']?></dd>
										<dt>Account Number:</dt>
										<dd><?=$order_data['act_number']?></dd>
										<dt>Short Code:</dt>
										<dd><?=$order_data['act_short_code']?></dd>
									<?php
									} else if($order_data['payment_method']=="cheque") { ?>
										<dt>Name:</dt>
										<dd><?=$order_data['chk_name']?></dd>
										<dt>Address:</dt>
										<dd><?=$order_data['chk_street_address']?></dd>
										<dd><?=$order_data['chk_street_address_2']?></dd>
										<dd><?=$order_data['chk_city'].', '.$order_data['chk_state'].' '.$order_data['chk_zip_code']?></dd>
									<?php
									} ?>
								</dl>
							</div>
						</div>
					</div>
					<!-- /Grid row -->

					<table class="table table-striped table-bordered table-condensed table-hover no-margin">
						<thead>
							<tr>
								<th>#</th>
								<th>Item ID</th>
								<th>Item(s)</th>
								<th>Qty</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($order_num_of_rows>0) {
								foreach($order_item_list as $order_item_list_data) {
								//path of this function (get_order_item) admin/include/functions.php
								$order_item_data = get_order_item($order_item_list_data['id'],'general'); ?>
								<tr>
									<td><?=$n=$n+1?></td>
									<td><?=$order_item_list_data['id']?></td>
									<td><?=$order_item_list_data['device_title'].' - '.$order_item_data['device_type']?></td>
									<td><?=$order_item_list_data['quantity']?></td>
									<td><?=amount_fomat($order_item_list_data['price'])?></td>
								</tr>
								<?php
								} ?>
								<tr>
									<td colspan="4"><strong>Sell Order Total:</strong></td>
									<td><strong><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></td>
								</tr>
								<?php
								if($promocode_amt>0) { ?>
									<tr>
										<td colspan="4"><strong><?=$discount_amt_label?></strong></td>
										<td><strong><?=amount_fomat($promocode_amt)?></strong></td>
									</tr>
									<tr>
										<td colspan="4"><strong>Total:</strong></td>
										<td><strong><?=amount_fomat($total_of_order)?></strong></td>
									</tr>
								<?php
								}
							} else {
								echo '<tr><td colspan="5" align="center">No Record Found.</td></tr>';
							} ?>
						</tbody>
					</table>
				</section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>