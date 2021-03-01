<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

$id = $post['model_id'];

//Fetch signle editable mobile(model) data
$mobile_data_q=mysqli_query($db,'SELECT m.*, c.fields_type, c.accessories_title, c.band_included_title, c.processor_title, c.ram_title FROM mobile AS m LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.id="'.$id.'"');
$mobile_data=mysqli_fetch_assoc($mobile_data_q);
if($id>0 && !empty($mobile_data)) {
	$mobile_data = _dt_parse_array($mobile_data);

	$storage_items_array = get_models_storage_data($id);
	$condition_items_array = get_models_condition_data($id);
	$network_items_array = get_models_networks_data($id);
	$connectivity_items_array = get_models_connectivity_data($id);
	$watchtype_items_array = get_models_watchtype_data($id);
	$case_material_items_array = get_models_case_material_data($id);
	$case_size_items_array = get_models_case_size_data($id);
	$accessories_items_array = get_models_accessories_data($id);
	$band_included_items_array = get_models_band_included_data($id);
	$processor_items_array = get_models_processor_data($id);
	$ram_items_array = get_models_ram_data($id);
	$model_items_array = get_models_model_data($id);
	$graphics_card_items_array = get_models_graphics_card_data($id);

	//$colors_items_array = get_models_color_data($id);
	//$accessories_items_array = get_models_accessories_data($id);
	//$miscellaneous_items_array = get_models_miscellaneous_data($id);

	$fields_cat_type = $mobile_data['fields_type'];

	//START for mobile category type
	if($fields_cat_type=="mobile") { ?>
	<table border="0" width="100%" class="table table-bordered table-hover">
		<tr>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>ID</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Carrier</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Storage</strong>
					</div>
				</div>
			</td>
			<?php
			$p_condition_items_array = $condition_items_array;
			if(!empty($p_condition_items_array)) {
				foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
						</div>
					</div>
					</td>
				<?php
				}
			} ?>
		</tr>

		<?php
		$pn_p = 0;
		$p_network_items_array = $network_items_array;
		if(empty($p_network_items_array)) {
			$p_network_items_array[] = array("network_name"=>"N/A");
		}
		if(!empty($p_network_items_array)) {
			foreach($p_network_items_array as $p_n_key=>$p_network_data) {
				$p_storage_items_array = $storage_items_array;
				if(empty($p_storage_items_array)) {
					$p_storage_items_array[] = array("storage_size"=>"N/A");
				}
				if(!empty($p_storage_items_array)) {
					foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
						$pn_p = ($pn_p+1);
						$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix']; ?>
						<tr>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
									<?=$pn_p?>
								</div>
							</div>
							</td>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
									<?=$p_network_data['network_name']?>
								</div>
							</div>
							</td>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
									<?=$p_storage_size?>
								</div>
							</div>
							</td>
							
							<?php
							$p_condition_items_array = $condition_items_array;
							if(!empty($p_condition_items_array)) {
								foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
									$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND network='".$p_network_data['network_name']."' AND storage='".$p_storage_size."'");
									$model_catalog_data=mysqli_fetch_assoc($mc_query);
									$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
									<td>
									<div class="span1.5">
										<div class="form-group m-form__group">
											<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_network_data['network_name']?>][<?=$p_storage_size?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
										</div>
									</div>
									</td>
								<?php
								}
							} ?>
						</tr>
					<?php
					}
				}
			}
		} ?>
	</table>
	<?php
	} //END for mobile category type
	
	//START for tablet category type
	elseif($fields_cat_type=="tablet") { ?>
	<table border="0" width="100%" class="table table-bordered table-hover">
		<tr>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>ID</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Connectivity</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Storage</strong>
					</div>
				</div>
			</td>
			<?php
			$p_condition_items_array = $condition_items_array;
			if(!empty($p_condition_items_array)) {
				foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
						</div>
					</div>
					</td>
				<?php
				}
			} ?>
		</tr>

		<?php
		$p_connectivity_items_array = $connectivity_items_array;
		if(empty($p_connectivity_items_array)) {
			$p_connectivity_items_array[] = array("connectivity_name"=>"N/A");
		}
		if(!empty($p_connectivity_items_array)) {
			foreach($p_connectivity_items_array as $p_n_key=>$p_connectivity_data) {
				$p_storage_items_array = $storage_items_array;
				if(empty($p_storage_items_array)) {
					$p_storage_items_array[] = array("storage_size"=>"N/A");
				}
				if(!empty($p_storage_items_array)) {
					foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
						$pn_p = ($pn_p+1);
						$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix']; ?>
						<tr>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
									<?=$pn_p?>
								</div>
							</div>
							</td>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
									<?=$p_connectivity_data['connectivity_name']?>
								</div>
							</div>
							</td>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
									<?=$p_storage_size?>
								</div>
							</div>
							</td>
							
							<?php
							$p_condition_items_array = $condition_items_array;
							if(!empty($p_condition_items_array)) {
								foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
									$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND connectivity='".$p_connectivity_data['connectivity_name']."' AND storage='".$p_storage_size."'");
									$model_catalog_data=mysqli_fetch_assoc($mc_query);
									$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
									<td>
									<div class="span1.5">
										<div class="form-group m-form__group">
											<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_connectivity_data['connectivity_name']?>][<?=$p_storage_size?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
										</div>
									</div>
									</td>
								<?php
								}
							} ?>
						</tr>
					<?php
					}
				}
			}
		} ?>
	</table>
	<?php
	} //END for tablet category type
	
	//START for watch category type
	elseif($fields_cat_type=="watch") { ?>
	<table border="0" width="100%" class="table table-bordered table-hover">
		<tr>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>ID</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Connectivity</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Size</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Model</strong>
					</div>
				</div>
			</td>
			<?php
			$p_condition_items_array = $condition_items_array;
			if(!empty($p_condition_items_array)) {
				foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
						</div>
					</div>
					</td>
				<?php
				}
			} ?>
		</tr>

		<?php
		$p_connectivity_items_array = $connectivity_items_array;
		if(empty($p_connectivity_items_array)) {
			$p_connectivity_items_array[] = array("connectivity_name"=>"N/A");
		}
		if(!empty($p_connectivity_items_array)) {
			foreach($p_connectivity_items_array as $p_n_key=>$p_connectivity_data) {
				$p_case_size_items_array = $case_size_items_array;
				if(empty($p_case_size_items_array)) {
					$p_case_size_items_array[] = array("case_size"=>"N/A");
				}
				if(!empty($p_case_size_items_array)) {
					foreach($p_case_size_items_array as $p_s_key=>$p_case_size_item) {
						$p_case_size = $p_case_size_item['case_size'];
						
						$p_model_items_array = $model_items_array;
						if(empty($p_model_items_array)) {
							$p_model_items_array[] = array("model_name"=>"N/A");
						}
						if(!empty($p_model_items_array)) {
							foreach($p_model_items_array as $p_s_key=>$p_model_item) {
								$pn_p = ($pn_p+1); ?>
								<tr>
									<td>
									<div class="span1.5">
										<div class="form-group m-form__group">
											<?=$pn_p?>
										</div>
									</div>
									</td>
									<td>
									<div class="span1.5">
										<div class="form-group m-form__group">
											<?=$p_connectivity_data['connectivity_name']?>
										</div>
									</div>
									</td>
									<td>
									<div class="span1.5">
										<div class="form-group m-form__group">
											<?=$p_case_size?>
										</div>
									</div>
									</td>
									<td>
									<div class="span1.5">
										<div class="form-group m-form__group">
											<?=$p_model_item['model_name']?>
										</div>
									</div>
									</td>
									<?php
									$p_condition_items_array = $condition_items_array;
									if(!empty($p_condition_items_array)) {
										foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
											$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND connectivity='".$p_connectivity_data['connectivity_name']."' AND case_size='".$p_case_size."' AND model='".$p_model_item['model_name']."'");
											$model_catalog_data=mysqli_fetch_assoc($mc_query);
											$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
											<td>
											<div class="span1.5">
												<div class="form-group m-form__group">
														<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_connectivity_data['connectivity_name']?>][<?=$p_case_size?>][<?=$p_model_item['model_name']?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
												</div>
											</div>
											</td>
										<?php
										}
									} ?>
								</tr>
							<?php
							}
						}
					}
				}
			}
		} ?>
	</table>
	<?php
	} //END for watch category type
	
	//START for watch category type
	elseif($fields_cat_type=="other") { ?>
	<table border="0" width="100%" class="table table-bordered table-hover">
		<tr>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>ID</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Model</strong>
					</div>
				</div>
			</td>
			<?php
			$p_condition_items_array = $condition_items_array;
			if(!empty($p_condition_items_array)) {
				foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
						</div>
					</div>
					</td>
				<?php
				}
			} ?>
		</tr>

		<?php
		$p_model_items_array = $model_items_array;
		if(empty($p_model_items_array)) {
			$p_model_items_array[] = array("model_name"=>"N/A");
		}
		if(!empty($p_model_items_array)) {
			foreach($p_model_items_array as $p_s_key=>$p_model_item) {
				$pn_p = ($pn_p+1); ?>
				<tr>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<?=$pn_p?>
						</div>
					</div>
					</td>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<?=$p_model_item['model_name']?>
						</div>
					</div>
					</td>
					<?php
					$p_condition_items_array = $condition_items_array;
					if(!empty($p_condition_items_array)) {
						foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
							$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND model='".$p_model_item['model_name']."'");
							$model_catalog_data=mysqli_fetch_assoc($mc_query);
							$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
							<td>
							<div class="span1.5">
								<div class="form-group m-form__group">
										<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_model_item['model_name']?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
								</div>
							</div>
							</td>
						<?php
						}
					} ?>
				</tr>
			<?php
			}
		} ?>
	</table>
	<?php
	} //END for watch category type
	
	//START for laptop category type
	if($fields_cat_type=="laptop") { ?>
	<table border="0" width="100%" class="table table-bordered table-hover">
		<tr>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>ID</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Model</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Processor</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>RAM</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Storage</strong>
					</div>
				</div>
			</td>
			<td>
				<div class="span1.5">
					<div class="form-group m-form__group">
						<strong>Graphics Card</strong>
					</div>
				</div>
			</td>
			<?php
			$p_condition_items_array = $condition_items_array;
			if(!empty($p_condition_items_array)) {
				foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
					<td>
					<div class="span1.5">
						<div class="form-group m-form__group">
							<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
						</div>
					</div>
					</td>
				<?php
				}
			} ?>
		</tr>

		<?php
		$p_model_items_array = $model_items_array;
		if(empty($p_model_items_array)) {
			$p_model_items_array[] = array("model_name"=>"N/A");
		}
		if(!empty($p_model_items_array)) {
			foreach($p_model_items_array as $p_n_key=>$p_model_data) {
				
				$p_processor_items_array = $processor_items_array;
				if(empty($p_processor_items_array)) {
					$p_processor_items_array[] = array("processor_name"=>"N/A");
				}
				if(!empty($p_processor_items_array)) {
					foreach($p_processor_items_array as $p_n_key=>$p_processor_data) {
					
						$p_ram_items_array = $ram_items_array;
						if(empty($p_ram_items_array)) {
							$p_ram_items_array[] = array("ram_size"=>"N/A");
						}
						if(!empty($p_ram_items_array)) {
							foreach($p_ram_items_array as $p_n_key=>$p_ram_data) {
								$p_ram_size = $p_ram_data['ram_size'].$p_ram_data['ram_size_postfix'];
								$p_storage_items_array = $storage_items_array;
								if(empty($p_storage_items_array)) {
									$p_storage_items_array[] = array("storage_size"=>"N/A");
								}
								if(!empty($p_storage_items_array)) {
									foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
										$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix'];
										$p_graphics_card_items_array = $graphics_card_items_array;
										if(empty($p_graphics_card_items_array)) {
											$p_graphics_card_items_array[] = array("graphics_card_name"=>"N/A");
										}
										if(!empty($p_graphics_card_items_array)) {
											foreach($p_graphics_card_items_array as $p_n_key=>$p_graphics_card_data) {
											$pn_p = ($pn_p+1); ?>
											<tr>
												<td>
												<div class="span1.5">
													<div class="form-group m-form__group">
														<?=$pn_p?>
													</div>
												</div>
												</td>
												<td>
												<div class="span1.5">
													<div class="form-group m-form__group">
														<?=$p_model_data['model_name']?>
													</div>
												</div>
												</td>
												<td>
												<div class="span1.5">
													<div class="form-group m-form__group">
														<?=$p_processor_data['processor_name']?>
													</div>
												</div>
												</td>
												<td>
												<div class="span1.5">
													<div class="form-group m-form__group">
														<?=$p_ram_size?>
													</div>
												</div>
												</td>
												<td>
												<div class="span1.5">
													<div class="form-group m-form__group">
														<?=$p_storage_size?>
													</div>
												</div>
												</td>
												<td>
												<div class="span1.5">
													<div class="form-group m-form__group">
														<?=$p_graphics_card_data['graphics_card_name']?>
													</div>
												</div>
												</td>
												<?php
												$p_condition_items_array = $condition_items_array;
												if(!empty($p_condition_items_array)) {
													foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
														$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND model='".$p_model_data['model_name']."' AND ram='".$p_ram_size."' AND processor='".$p_processor_data['processor_name']."' AND graphics_card='".$p_graphics_card_data['graphics_card_name']."' AND storage='".$p_storage_size."'");
														$model_catalog_data=mysqli_fetch_assoc($mc_query);
														$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
														<td>
														<div class="span1.5">
															<div class="form-group m-form__group">
																	<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_model_data['model_name']?>][<?=$p_processor_data['processor_name']?>][<?=$p_ram_size?>][<?=$p_storage_size?>][<?=$p_graphics_card_data['graphics_card_name']?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
															</div>
														</div>
														</td>
													<?php
													}
												} ?>
											</tr>
											<?php
											}
										}
									}
								}
							}
						}
					}
				}
			}
		} ?>
	</table>
	<?php
	} //END for mobile laptop type ?>

	<input type="hidden" name="id" value="<?=$mobile_data['id']?>" />
	<input type="hidden" name="cat_id" id="cat_id" value="<?=$mobile_data['cat_id']?>" />
<?php
} ?>
<input type="hidden" name="pricing" value="1" />
