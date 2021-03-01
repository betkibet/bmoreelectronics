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
								<h4 class="no-margin"><?=$order_data['shipping_first_name'].' '.$order_data['shipping_last_name']?></h4>
								<dl class="no-bottom-margin">
								  <dt>Address:</dt>
								  <dd>
									<?=$order_data['shipping_address1'].($order_data['shipping_address2']?'<br>'.$order_data['shipping_address2']:'')?>
								  </dd>
								  <dd>
									<?=$order_data['shipping_city'].', '.$order_data['shipping_state'].' '.$order_data['shipping_postcode']?>
								  </dd>
								  <dd>
									<?=$order_data['shipping_country']?>
								  </dd>
									<dt>Contact:</dt>
									<dd>
													<a href="mailto:<?=$order_data['email']?>">
													  <?=$order_data['email']?>
													</a>
													<?php
													if($order_data['phone']) { ?>
													<a href="callto:<?=$order_data['phone']?>">
													  <?=$order_data['phone']?>
													</a>
													<?php
													} ?>
												  </dd>
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
									<?php
									if($order_data['payment_method']) { ?>
										<dd><b>Payment Method:</b> <?=replace_us_to_space_pmt_mthd($order_data['payment_method'])?></dd>
									<?php
									}
									
									$payment_method_details = json_decode($order_data['payment_method_details'],true);
									if(!empty($payment_method_details)) {
										foreach($payment_method_details as $k => $v) {
											echo '<dt>'.replace_us_to_space($k).':</dt><dd>'.$v.'</dd>';
										}
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