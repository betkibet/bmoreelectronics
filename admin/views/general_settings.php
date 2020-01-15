<script type="text/javascript">
function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
	    var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function checkFileXml(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "xml")){
	    var error = "Please make sure your file is in xml format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function chg_mailer_type(type) {
	if(type=="smtp") {
		$(".showhide_smtp_fields").show();
		$(".showhide_emailapi_fields").hide();
	} else if(type=="sendgrid") {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").show();
	} else {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").hide();
	}
}
</script>


<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<!-- BEGIN: Header -->
	<?php include("include/admin_menu.php"); ?>
	<!-- END: Header -->

	<!-- begin::Body -->
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
		<!-- BEGIN: Left Aside -->
		<?php include("include/navigation.php"); ?>
		<!-- END: Left Aside -->
		<div class="m-grid__item m-grid__item--fluid m-wrapper">
			<div class="m-content ">
				<?php include('confirm_message.php'); ?>
				<!--Begin::Section-->
				<div class="row">
					<div class="col-lg-12">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<form class="m-form" action="controllers/general_settings.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
	              <div class="m-portlet__head">
	                <div class="m-portlet__head-caption">
	                  <div class="m-portlet__head-title">
	                    <h3 class="m-portlet__head-text">
	                      Settings
	                    </h3>
	                  </div>
	                </div>
	              </div>
	              <div class="m-portlet__body">
	                <div class="row">
	                	<div class="col-md-3">
							<ul class="nav nav-tabs flex-column nav-pills vartical-tab  m-tabs-line m-tabs-line--success" role="tablist">
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="false">
			                      General Settings
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="true">
			                      Company Details
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="true">
			                      Email Settings
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_4" role="tab" aria-selected="true">
			                      Socials Settings
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_5" role="tab" aria-selected="true">
			                      SMS Settings
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_6" role="tab" aria-selected="true">
			                      Blog Settings
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_7" role="tab" aria-selected="true">
			                      Shipping API
			                    </a>
			                  </li>
							  
							  <li><a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_9" role="tab" aria-selected="true">Captcha Settings</a></li>
							  <li><a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_10" role="tab" aria-selected="true">Email Template Settings</a></li>
							  
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_8" role="tab" aria-selected="true">
			                      Sitemap (XML)
			                    </a>
			                  </li>
			                  <?php /*?><li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" href="home_settings.php">
			                      Home Page Settings
			                    </a>
			                  </li>
			                  <li class="nav-item m-tabs__item">
			                    <a class="nav-link m-tabs__link" href="service_hours.php">
			                      Service Hours
			                    </a>
			                  </li><?php */?>
			                </ul>
	                	</div>
										<div class="col-md-9">
											<div class="tab-content">
			                  <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
							                      <i class="la la-gear"></i>
							                    </span>
																	<h3 class="m-portlet__head-text">
							                      General Settings
							                    </h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="field-1">
																		Admin Panel Name :
																	</label>
																	<input type="text" class="form-control m-input" id="admin_panel_name" value="<?=$general_setting_data['admin_panel_name']?>" name="admin_panel_name">
																</div>
																
																<div class="form-group m-form__group">
																	<label for="logo">Admin Logo :</label>
																	<div class="custom-file">
																		<input type="file" id="admin_logo" class="custom-file-input" name="admin_logo" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="logo">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	if($general_setting_data['admin_logo']!="") { ?>
																		<img src="../images/<?=$general_setting_data['admin_logo'].'?token='.uniqid()?>" width="200" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_a_logo_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																	<?php
																	} ?>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="logo">Front Logo :</label>
																	<div class="custom-file">
																		<input type="file" id="logo" class="custom-file-input" name="logo" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="logo">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	if($general_setting_data['logo']!="") { ?>
																		<img src="../images/<?=$general_setting_data['logo'].'?token='.uniqid()?>" width="200" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_logo_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																	<?php
																	} ?>
																</div>
										
																<div class="form-group m-form__group">
																	<label for="logo">Front Logo (Fixed) :</label>
																	<div class="custom-file">
																		<input type="file" id="logo_fixed" class="custom-file-input" name="logo_fixed" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="logo">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	if($general_setting_data['logo_fixed']!="") { ?>
																		<img src="../images/<?=$general_setting_data['logo_fixed'].'?token='.uniqid()?>" width="200" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_logo_fixed_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																	<?php
																	} ?>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="field-1">
																	Site Name :
																    </label>
																	<input type="text" class="form-control m-input" id="site_name" value="<?=$general_setting_data['site_name']?>" name="site_name">
																</div>
																<div class="form-group m-form__group">
																	<label for="field-1">
																		Website :
																	</label>
																	<input type="text" class="form-control m-input" id="field-1" value="<?=$general_setting_data['website']?>" name="website">
																</div>
																<div class="form-group m-form__group">
																	<label for="field-1">
																	Header/Footer Phone :
																    </label>
																	<input type="text" class="form-control m-input" id="phone" value="<?=$general_setting_data['phone']?>"  name="phone">
																</div>
																<div class="form-group m-form__group">
																	<label for="field-1">
																	Header/Footer Email :
																    </label>
																	<input type="text" class="form-control m-input" id="email" value="<?=$general_setting_data['email']?>"  name="email">
																</div>
																<div class="form-group m-form__group">
																	<label for="field-1">
																	Copyright :
																    </label>
																	<input type="text" class="form-control m-input" id="field-1" value="<?=$general_setting_data['copyright']?>" name="copyright">
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Status of Terms & Conditions :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="terms_status" name="terms_status" value="1" <?=($general_setting_data['terms_status']=='1'||$general_setting_data['disp_currency']==''?'checked="checked"':'')?>>
																			Enable
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="terms_status" name="terms_status" value="0" <?=($general_setting_data['terms_status']=='0'?'checked="checked"':'')?>>
																			Disable
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Display Terms & Conditions :
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="display_terms" type="checkbox" value="ac_creation" name="display_terms[ac_creation]" <?php if($display_terms['ac_creation']=="ac_creation"){echo 'checked="checked"';}?>>
																			On Account Creation
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="display_terms" type="checkbox" value="confirm_sale" name="display_terms[confirm_sale]" <?php if($display_terms['confirm_sale']=="confirm_sale"){echo 'checked="checked"';}?>>
																			On Confirm Sale
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="field-1">
						                        Terms & Conditions :
						                      </label>
																	<textarea class="form-control m-input summernote" id="terms" name="terms" rows="5"><?=$general_setting_data['terms']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Show Missing Product Section :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="missing_product_section" name="missing_product_section" value="1" <?=($general_setting_data['missing_product_section']=='1'?'checked="checked"':'')?>>
																			Yes
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="missing_product_section" name="missing_product_section" value="0" <?=(intval($general_setting_data['missing_product_section'])=='0'?'checked="checked"':'')?>>
																			No
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label for="top_seller_limit">
																			Top Seller Limit :
																		</label>
																		<input type="text" class="form-control m-input" id="top_seller_limit" value="<?=$general_setting_data['top_seller_limit']?>" name="top_seller_limit">
																	</div>
																	<div class="col-4">
																		<label for="order_prefix">
																			Order Prefix :
																		</label>
																		<input type="text" class="form-control m-input" id="order_prefix" value="<?=$general_setting_data['order_prefix']?>" name="order_prefix" maxlength="5">
																	</div>
																	<div class="col-4">
																		<label for="page_list_limit">Page List Limit :</label>
																		<select class="form-control m-select2 m-select2-general" name="page_list_limit" id="page_list_limit">
																			<option value=""> -Select- </option>
																			<option value="5" <?php if($page_list_limit=='5'){echo 'selected="selected"';}?>>5</option>
																			<option value="10" <?php if($page_list_limit=='10'){echo 'selected="selected"';}?>>10</option>
																			<option value="15" <?php if($page_list_limit=='15'){echo 'selected="selected"';}?>>15</option>
																			<option value="20" <?php if($page_list_limit=='20'){echo 'selected="selected"';}?>>20</option>
																			<option value="25" <?php if($page_list_limit=='25'){echo 'selected="selected"';}?>>25</option>
																			<option value="50" <?php if($page_list_limit=='50'){echo 'selected="selected"';}?>>50</option>
																			<option value="100" <?php if($page_list_limit=='100'){echo 'selected="selected"';}?>>100</option>
																			<option value="200" <?php if($page_list_limit=='200'){echo 'selected="selected"';}?>>200</option>
																			<option value="500" <?php if($page_list_limit=='500'){echo 'selected="selected"';}?>>500</option>
																		</select>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Promocode Section :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="promocode_section_on" name="promocode_section" value="1" <?php if($general_setting_data['promocode_section']=='1'){echo 'checked="checked"';}?>>
																			Yes
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="promocode_section_off" name="promocode_section" value="0" <?php if($general_setting_data['promocode_section']=='0'){echo 'checked="checked"';}?>>
																			No
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																	<label for="currency">Currency :</label>
																	<select class="form-control m-select2 m-select2-general" name="currency" id="currency">
																   <option value=""> -Select- </option>
																   <option value="AFN,؋" <?php if($currency[0]=='AFN'){echo 'selected="selected"';}?>>AFN(؋)</option>
				 												   <option value="ALL,Lek" <?php if($currency[0]=='ALL'){echo 'selected="selected"';}?>>ALL(Lek)</option>
				 												   <option value="USD,$" <?php if($currency[0]=='USD'){echo 'selected="selected"';}?>>USD($)</option>
				 												   <option value="EUR,€" <?php if($currency[0]=='EUR'){echo 'selected="selected"';}?>>EUR(€)</option>
				 												   <option value="AOA,Kz" <?php if($currency[0]=='AOA'){echo 'selected="selected"';}?>>AOA(Kz)</option>
				 												   <option value="XCD,$" <?php if($currency[0]=='XCD'){echo 'selected="selected"';}?>>XCD($)</option>
				 												   <option value="ARS,$" <?php if($currency[0]=='ARS'){echo 'selected="selected"';}?>>ARS($)</option>
				 												   <option value="AWG,ƒ" <?php if($currency[0]=='AWG'){echo 'selected="selected"';}?>>AWG(ƒ)</option>
				 												   <option value="AUD,$" <?php if($currency[0]=='AUD'){echo 'selected="selected"';}?>>AUD($)</option>
				 												   <option value="AZN,ман" <?php if($currency[0]=='AZN'){echo 'selected="selected"';}?>>AZN(ман)</option>
				 												   <option value="BSD,$" <?php if($currency[0]=='BSD'){echo 'selected="selected"';}?>>BSD($)</option>
				 												   <option value="BBD,$" <?php if($currency[0]=='BBD'){echo 'selected="selected"';}?>>BBD($)</option>
				 												   <option value="BYR,p." <?php if($currency[0]=='BYR'){echo 'selected="selected"';}?>>BYR(p.)</option>
				 												   <option value="BZD,BZ$" <?php if($currency[0]=='BZD'){echo 'selected="selected"';}?>>BZD(BZ$)</option>
				 												   <option value="BMD,$" <?php if($currency[0]=='BMD'){echo 'selected="selected"';}?>>BMD($)</option>
				 												   <option value="BOB,$b" <?php if($currency[0]=='BOB'){echo 'selected="selected"';}?>>BOB($b)</option>
				 												   <option value="BAM,KM" <?php if($currency[0]=='BAM'){echo 'selected="selected"';}?>>BAM(KM)</option>
				 												   <option value="BWP,P" <?php if($currency[0]=='BWP'){echo 'selected="selected"';}?>>BWP(P)</option>
				 												   <option value="NOK,kr" <?php if($currency[0]=='NOK'){echo 'selected="selected"';}?>>NOK(kr)</option>
				 												   <option value="BRL,R$" <?php if($currency[0]=='BRL'){echo 'selected="selected"';}?>>BRL(R$)</option>
				 												   <option value="BND,$" <?php if($currency[0]=='BND'){echo 'selected="selected"';}?>>BND($)</option>
				 												   <option value="BGN,лв" <?php if($currency[0]=='BGN'){echo 'selected="selected"';}?>>BGN(лв)</option>
				 												   <option value="KHR,៛" <?php if($currency[0]=='KHR'){echo 'selected="selected"';}?>>KHR(៛)</option>
				 												   <option value="XAF,FCF" <?php if($currency[0]=='XAF'){echo 'selected="selected"';}?>>XAF(FCF)</option>
				 												   <option value="CAD,$" <?php if($currency[0]=='CAD'){echo 'selected="selected"';}?>>CAD($)</option>
				 												   <option value="KYD,$" <?php if($currency[0]=='KYD'){echo 'selected="selected"';}?>>KYD($)</option>
				 												   <option value="CNY,¥" <?php if($currency[0]=='CNY'){echo 'selected="selected"';}?>>CNY(¥)</option>
				 												   <option value="COP,$" <?php if($currency[0]=='COP'){echo 'selected="selected"';}?>>COP($)</option>
				 												   <option value="NZD,$" <?php if($currency[0]=='NZD'){echo 'selected="selected"';}?>>NZD($)</option>
				 												   <option value="CRC,₡" <?php if($currency[0]=='CRC'){echo 'selected="selected"';}?>>CRC(₡)</option>
				 												   <option value="HRK,kn" <?php if($currency[0]=='HRK'){echo 'selected="selected"';}?>>HRK(kn)</option>
				 												   <option value="CUP,₱" <?php if($currency[0]=='CUP'){echo 'selected="selected"';}?>>CUP(₱)</option>
				 												   <option value="CZK,KĿ" <?php if($currency[0]=='CZK'){echo 'selected="selected"';}?>>CZK(KĿ)</option>
				 												   <option value="DKK,kr" <?php if($currency[0]=='DKK'){echo 'selected="selected"';}?>>DKK(kr)</option>
				 												   <option value="DOP,RD$" <?php if($currency[0]=='DOP'){echo 'selected="selected"';}?>>DOP(RD$)</option>
				 												   <option value="EGP,£" <?php if($currency[0]=='EGP'){echo 'selected="selected"';}?>>EGP(£)</option>
				 												   <option value="SVC,$" <?php if($currency[0]=='SVC'){echo 'selected="selected"';}?>>SVC($)</option>
				 												   <option value="ERN,Nfk" <?php if($currency[0]=='ERN'){echo 'selected="selected"';}?>>ERN(Nfk)</option>
				 												   <option value="EEK,kr" <?php if($currency[0]=='EEK'){echo 'selected="selected"';}?>>EEK(kr)</option>
				 												   <option value="FKP,£" <?php if($currency[0]=='FKP'){echo 'selected="selected"';}?>>FKP(£)</option>
				 												   <option value="FJD,$" <?php if($currency[0]=='FJD'){echo 'selected="selected"';}?>>FJD($)</option>
				 												   <option value="GMD,D" <?php if($currency[0]=='GMD'){echo 'selected="selected"';}?>>GMD(D)</option>
				 												   <option value="GHC,¢" <?php if($currency[0]=='GHC'){echo 'selected="selected"';}?>>GHC(¢)</option>
				 												   <option value="GIP,£" <?php if($currency[0]=='GIP'){echo 'selected="selected"';}?>>GIP(£)</option>
				 												   <option value="GTQ,Q" <?php if($currency[0]=='GTQ'){echo 'selected="selected"';}?>>GTQ(Q)</option>
				 												   <option value="GYD,$" <?php if($currency[0]=='GYD'){echo 'selected="selected"';}?>>GYD($)</option>
				 												   <option value="HTG,G" <?php if($currency[0]=='HTG'){echo 'selected="selected"';}?>>HTG(G)</option>
				 												   <option value="HNL,L" <?php if($currency[0]=='HNL'){echo 'selected="selected"';}?>>HNL(L)</option>
				 												   <option value="HKD,$" <?php if($currency[0]=='HKD'){echo 'selected="selected"';}?>>HKD($)</option>
				 												   <option value="HUF,Ft" <?php if($currency[0]=='HUF'){echo 'selected="selected"';}?>>HUF(Ft)</option>
				 												   <option value="ISK,kr" <?php if($currency[0]=='ISK'){echo 'selected="selected"';}?>>ISK(kr)</option>
				 												   <option value="INR,₹" <?php if($currency[0]=='INR'){echo 'selected="selected"';}?>>INR(₹)</option>
				 												   <option value="IDR,Rp" <?php if($currency[0]=='IDR'){echo 'selected="selected"';}?>>IDR(Rp)</option>
				 												   <option value="IRR,﷼" <?php if($currency[0]=='IRR'){echo 'selected="selected"';}?>>IRR(﷼)</option>
				 												   <option value="ILS,₪" <?php if($currency[0]=='ILS'){echo 'selected="selected"';}?>>ILS(₪)</option>
				 												   <option value="JMD,$" <?php if($currency[0]=='JMD'){echo 'selected="selected"';}?>>JMD($)</option>
				 												   <option value="JPY,¥" <?php if($currency[0]=='JPY'){echo 'selected="selected"';}?>>JPY(¥)</option>
				 												   <option value="KZT,лв" <?php if($currency[0]=='KZT'){echo 'selected="selected"';}?>>KZT(лв)</option>
				 												   <option value="KGS,лв" <?php if($currency[0]=='KGS'){echo 'selected="selected"';}?>>KGS(лв)</option>
				 												   <option value="LAK,₭" <?php if($currency[0]=='LAK'){echo 'selected="selected"';}?>>LAK(₭)</option>
				 												   <option value="LVL,Ls" <?php if($currency[0]=='LVL'){echo 'selected="selected"';}?>>LVL(Ls)</option>
				 												   <option value="LBP,£" <?php if($currency[0]=='LBP'){echo 'selected="selected"';}?>>LBP(£)</option>
				 												   <option value="LSL,L" <?php if($currency[0]=='LSL'){echo 'selected="selected"';}?>>LSL(L)</option>
				 												   <option value="LRD,$" <?php if($currency[0]=='LRD'){echo 'selected="selected"';}?>>LRD($)</option>
				 												   <option value="CHF,CHF" <?php if($currency[0]=='CHF'){echo 'selected="selected"';}?>>CHF(CHF)</option>
				 												   <option value="LTL,Lt" <?php if($currency[0]=='LTL'){echo 'selected="selected"';}?>>LTL(Lt)</option>
				 												   <option value="MOP,MOP" <?php if($currency[0]=='MOP'){echo 'selected="selected"';}?>>MOP(MOP)</option>
				 												   <option value="MKD,ден" <?php if($currency[0]=='MKD'){echo 'selected="selected"';}?>>MKD(ден)</option>
				 												   <option value="MWK,MK" <?php if($currency[0]=='MWK'){echo 'selected="selected"';}?>>MWK(MK)</option>
				 												   <option value="MYR,RM" <?php if($currency[0]=='MYR'){echo 'selected="selected"';}?>>MYR(RM)</option>
				 												   <option value="MVR,Rf" <?php if($currency[0]=='MVR'){echo 'selected="selected"';}?>>MVR(Rf)</option>
				 												   <option value="MRO,UM" <?php if($currency[0]=='MRO'){echo 'selected="selected"';}?>>MRO(UM)</option>
				 												   <option value="MUR,₨" <?php if($currency[0]=='MUR'){echo 'selected="selected"';}?>>MUR(₨)</option>
				 												   <option value="MXN,$" <?php if($currency[0]=='MXN'){echo 'selected="selected"';}?>>MXN($)</option>
				 												   <option value="MNT,₮" <?php if($currency[0]=='MNT'){echo 'selected="selected"';}?>>MNT(₮)</option>
				 												   <option value="MZN,MT" <?php if($currency[0]=='MZN'){echo 'selected="selected"';}?>>MZN(MT)</option>
				 												   <option value="MMK,K" <?php if($currency[0]=='MMK'){echo 'selected="selected"';}?>>MMK(K)</option>
				 												   <option value="NAD,$" <?php if($currency[0]=='NAD'){echo 'selected="selected"';}?>>NAD($)</option>
				 												   <option value="NPR,₨" <?php if($currency[0]=='NPR'){echo 'selected="selected"';}?>>NPR(₨)</option>
				 												   <option value="ANG,ƒ" <?php if($currency[0]=='ANG'){echo 'selected="selected"';}?>>ANG(ƒ)</option>
				 												   <option value="NIO,C$" <?php if($currency[0]=='NIO'){echo 'selected="selected"';}?>>NIO(C$)</option>
				 												   <option value="NGN,₦" <?php if($currency[0]=='NGN'){echo 'selected="selected"';}?>>NGN(₦)</option>
				 												   <option value="KPW,₩" <?php if($currency[0]=='KPW'){echo 'selected="selected"';}?>>KPW(₩)</option>
				 												   <option value="OMR,﷼" <?php if($currency[0]=='OMR'){echo 'selected="selected"';}?>>OMR(﷼)</option>
				 												   <option value="PKR,₨" <?php if($currency[0]=='PKR'){echo 'selected="selected"';}?>>PKR(₨)</option>
				 												   <option value="PAB,B/." <?php if($currency[0]=='PAB'){echo 'selected="selected"';}?>>PAB(B/.)</option>
				 												   <option value="PYG,Gs" <?php if($currency[0]=='PYG'){echo 'selected="selected"';}?>>PYG(Gs)</option>
				 												   <option value="PEN,S/." <?php if($currency[0]=='PEN'){echo 'selected="selected"';}?>>PEN(S/.)</option>
				 												   <option value="PHP,Php" <?php if($currency[0]=='PHP'){echo 'selected="selected"';}?>>PHP(Php)</option>
				 												   <option value="PLN,zł" <?php if($currency[0]=='PLN'){echo 'selected="selected"';}?>>PLN(zł)</option>
				 												   <option value="QAR,﷼" <?php if($currency[0]=='QAR'){echo 'selected="selected"';}?>>QAR(﷼)</option>
				 												   <option value="RON,lei" <?php if($currency[0]=='RON'){echo 'selected="selected"';}?>>RON(lei)</option>
				 												   <option value="RUB,руб" <?php if($currency[0]=='RUB'){echo 'selected="selected"';}?>>RUB(руб)</option>
				 												   <option value="SHP,£" <?php if($currency[0]=='SHP'){echo 'selected="selected"';}?>>SHP(£)</option>
				 												   <option value="WST,WS$" <?php if($currency[0]=='WST'){echo 'selected="selected"';}?>>WST(WS$)</option>
				 												   <option value="STD,Db" <?php if($currency[0]=='STD'){echo 'selected="selected"';}?>>STD(Db)</option>
				 												   <option value="SAR,﷼" <?php if($currency[0]=='SAR'){echo 'selected="selected"';}?>>SAR(﷼)</option>
				 												   <option value="RSD,Дин" <?php if($currency[0]=='RSD'){echo 'selected="selected"';}?>>RSD(Дин)</option>
				 												   <option value="SCR,₨" <?php if($currency[0]=='SCR'){echo 'selected="selected"';}?>>SCR(₨)</option>
				 												   <option value="SLL,Le" <?php if($currency[0]=='SLL'){echo 'selected="selected"';}?>>SLL(Le)</option>
				 												   <option value="SGD,$" <?php if($currency[0]=='SGD'){echo 'selected="selected"';}?>>SGD($)</option>
				 												   <option value="SKK,Sk" <?php if($currency[0]=='SKK'){echo 'selected="selected"';}?>>SKK(Sk)</option>
				 												   <option value="SBD,$" <?php if($currency[0]=='SBD'){echo 'selected="selected"';}?>>SBD($)</option>
				 												   <option value="SOS,S" <?php if($currency[0]=='SOS'){echo 'selected="selected"';}?>>SOS(S)</option>
				 												   <option value="ZAR,R" <?php if($currency[0]=='ZAR'){echo 'selected="selected"';}?>>ZAR(R)</option>
				 												   <option value="GBP,£" <?php if($currency[0]=='GBP'){echo 'selected="selected"';}?>>GBP(£)</option>
				 												   <option value="KRW,₩" <?php if($currency[0]=='KRW'){echo 'selected="selected"';}?>>KRW(₩)</option>
				 												   <option value="LKR,₨" <?php if($currency[0]=='LKR'){echo 'selected="selected"';}?>>LKR(₨)</option>
				 												   <option value="SRD,$" <?php if($currency[0]=='SRD'){echo 'selected="selected"';}?>>SRD($)</option>
				 												   <option value="SEK,kr" <?php if($currency[0]=='SEK'){echo 'selected="selected"';}?>>SEK(kr)</option>
				 												   <option value="SYP,£" <?php if($currency[0]=='SYP'){echo 'selected="selected"';}?>>SYP(£)</option>
				 												   <option value="TWD,NT$" <?php if($currency[0]=='TWD'){echo 'selected="selected"';}?>>TWD(NT$)</option>
				 												   <option value="THB,฿" <?php if($currency[0]=='THB'){echo 'selected="selected"';}?>>THB(฿)</option>
				 												   <option value="TOP,T$" <?php if($currency[0]=='TOP'){echo 'selected="selected"';}?>>TOP(T$)</option>
				 												   <option value="TTD,TT$" <?php if($currency[0]=='TTD'){echo 'selected="selected"';}?>>TTD(TT$)</option>
				 												   <option value="TRY,YTL" <?php if($currency[0]=='TRY'){echo 'selected="selected"';}?>>TRY(YTL)</option>
				 												   <option value="TMM,m" <?php if($currency[0]=='TMM'){echo 'selected="selected"';}?>>TMM(m)</option>
				 												   <option value="UAH,₴" <?php if($currency[0]=='UAH'){echo 'selected="selected"';}?>>UAH(₴)</option>
				 												   <option value="UYU,$U" <?php if($currency[0]=='UYU'){echo 'selected="selected"';}?>>UYU($U)</option>
				 												   <option value="UZS,лв" <?php if($currency[0]=='UZS'){echo 'selected="selected"';}?>>UZS(лв)</option>
				 												   <option value="VUV,Vt" <?php if($currency[0]=='VUV'){echo 'selected="selected"';}?>>VUV(Vt)</option>
				 												   <option value="VEF,Bs" <?php if($currency[0]=='VEF'){echo 'selected="selected"';}?>>VEF(Bs)</option>
				 												   <option value="VND,₫" <?php if($currency[0]=='VND'){echo 'selected="selected"';}?>>VND(₫)</option>
				 												   <option value="YER,﷼" <?php if($currency[0]=='YER'){echo 'selected="selected"';}?>>YER(﷼)</option>
				 												   <option value="ZMK,ZK" <?php if($currency[0]=='ZMK'){echo 'selected="selected"';}?>>ZMK(ZK)</option>
				 												   <option value="ZWD,Z$" <?php if($currency[0]=='ZWD'){echo 'selected="selected"';}?>>ZWD(Z$)</option>
																	</select>
																	</div>
																	<div class="col-6">
																		<label for="published">
																			Display currency :
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="disp_currency" name="disp_currency" value="prefix" <?=($general_setting_data['disp_currency']=="prefix"||$general_setting_data['disp_currency']==""?'checked="checked"':'')?>>
																				Prefix
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="disp_currency" name="disp_currency" value="postfix" <?=($general_setting_data['disp_currency']=="postfix"?'checked="checked"':'')?>>
																				Postfix
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Payment Option :
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="payment_option_bank" type="checkbox" value="bank" name="payment_option[bank]" <?php if($payment_option['bank']=="bank"){echo 'checked="checked"';}?>>
																			Bank
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_paypal" type="checkbox" value="paypal" name="payment_option[paypal]" <?php if($payment_option['paypal']=="paypal"){echo 'checked="checked"';}?>>
																			Paypal
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_cheque" type="checkbox" value="cheque" name="payment_option[cheque]" <?php if($payment_option['cheque']=="cheque"){echo 'checked="checked"';}?>>
																			Cheque
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_zelle" type="checkbox" value="zelle" name="payment_option[zelle]" <?php if($payment_option['zelle']=="zelle"){echo 'checked="checked"';}?>>
																			Zelle
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_cashapp" type="checkbox" value="cashapp" name="payment_option[cashapp]" <?php if($payment_option['cashapp']=="cashapp"){echo 'checked="checked"';}?>>
																			Cashapp
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_venmo" type="checkbox" value="venmo" name="payment_option[venmo]" <?php if($payment_option['venmo']=="venmo"){echo 'checked="checked"';}?>>
																			Venmo
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_google_pay" type="checkbox" value="google_pay" name="payment_option[google_pay]" <?php if($payment_option['google_pay']=="google_pay"){echo 'checked="checked"';}?>>
																			Google Pay
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="payment_option_other" type="checkbox" value="other" name="payment_option[other]" <?php if($payment_option['other']=="other"){echo 'checked="checked"';}?>>
																			Other
																			<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="m-form__group form-group">
																	<label for="published">
																		Default Payment Option :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_bank" name="default_payment_option" value="bank" <?=($general_setting_data['default_payment_option']=="bank"||$general_setting_data['default_payment_option']==""?'checked="checked"':'')?>>
																			Bank<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_paypal" name="default_payment_option" value="paypal" <?=($general_setting_data['default_payment_option']=="paypal"?'checked="checked"':'')?>>
																			Paypal<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cheque" name="default_payment_option" value="cheque" <?=($general_setting_data['default_payment_option']=="cheque"?'checked="checked"':'')?>>
																			Cheque<span></span>
																		</label>
																		
																		<label class="m-radio">
																			<input id="default_payment_option_zelle" type="checkbox" value="zelle" name="default_payment_option" <?php if($general_setting_data['default_payment_option']=="zelle"){echo 'checked="checked"';}?>>
																			Zelle
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input id="default_payment_option_cashapp" type="checkbox" value="cashapp" name="default_payment_option" <?php if($general_setting_data['default_payment_option']=="cashapp"){echo 'checked="checked"';}?>>
																			Cashapp
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input id="default_payment_option_venmo" type="checkbox" value="venmo" name="default_payment_option" <?php if($general_setting_data['default_payment_option']=="venmo"){echo 'checked="checked"';}?>>
																			Venmo
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input id="default_payment_option_google_pay" type="checkbox" value="google_pay" name="default_payment_option" <?php if($general_setting_data['default_payment_option']=="google_pay"){echo 'checked="checked"';}?>>
																			Google Pay
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input id="default_payment_option_other" type="checkbox" value="other" name="default_payment_option" <?php if($general_setting_data['default_payment_option']=="other"){echo 'checked="checked"';}?>>
																			Other
																			<span></span>
																		</label>
																		
																	</div>
																</div>
																
																<div class="m-form__group form-group">
																	<label for="published">
																		Sales Pack :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-checkbox">
																			<input id="sales_pack" type="checkbox" value="free" name="sales_pack[free]" <?php if($sales_pack['free']=='free'){echo 'checked="checked"';}?>>
																			Send free sales pack
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="sales_pack" type="checkbox" value="own" name="sales_pack[own]" <?php if($sales_pack['own']=='own'){echo 'checked="checked"';}?>>
																			print your own sales labels
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Shipping Option :
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="shipping_option" type="checkbox" value="own" name="shipping_option[own]" <?php if($shipping_option['own']=='own'){echo 'checked="checked"';}?>>
																			Post Your Own
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="shipping_option" type="checkbox" value="free_pickup" name="shipping_option[free_pickup]" <?php if($shipping_option['free_pickup']=='free_pickup'){echo 'checked="checked"';}?>>
																			Schedule a Free Pickup
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Customer Verification :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="verification" name="verification" value="none" <?=($general_setting_data['verification']=="none"||$general_setting_data['verification']==""?'checked="checked"':'')?>>
																			None
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="verification" name="verification" value="email" <?=($general_setting_data['verification']=="email"?'checked="checked"':'')?>>
																			Email
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="verification" name="verification" value="sms" <?=($general_setting_data['verification']=="sms"?'checked="checked"':'')?>>
																			SMS
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="exampleTextarea">
																		JS Code before &#60;&#47;head&#62; :
																	</label>
																	<textarea class="form-control m-input" name="custom_js_code" rows="5"><?=$general_setting_data['custom_js_code']?></textarea>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																  Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
			                  </div>
			                  <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Company Details
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="company_name">
																		Company Name :
																	</label>
																	<input type="text" class="form-control m-input" id="company_name" value="<?=$general_setting_data['company_name']?>" name="company_name">
																</div>
																<div class="form-group m-form__group">
																	<label for="company_address">
																		Address :
																	</label>
																	<input type="text" class="form-control m-input" id="company_address" value="<?=$general_setting_data['company_address']?>" name="company_address">
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-3">
																		<label for="company_city">
																			City :
																		</label>
																		<input type="text" class="form-control m-input" id="company_city" value="<?=$general_setting_data['company_city']?>" name="company_city">
																	</div>
																	<div class="col-3">
																		<label for="company_state">
																			State :
																		</label>
																		<input type="text" class="form-control m-input" id="company_state" value="<?=$general_setting_data['company_state']?>" name="company_state">
																	</div>
																	<div class="col-3">
																		<label for="company_country">
																			Country :
																		</label>
																		<input type="text" class="form-control m-input" id="company_country" value="<?=$general_setting_data['company_country']?>" name="company_country">
																	</div>
																	<div class="col-3">
																		<label for="company_zipcode">
																			Zipcode :
																		</label>
																		<input type="text" class="form-control m-input" id="company_zipcode" value="<?=$general_setting_data['company_zipcode']?>" name="company_zipcode">
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="company_phone">
																		Phone :
																	</label>
																	<input type="text" class="form-control m-input" id="company_phone" value="<?=$general_setting_data['company_phone']?>" name="company_phone">
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Mail Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="from_name">
																		From Name :
																	</label>
																	<input type="text" class="form-control m-input" id="from_name" value="<?=$general_setting_data['from_name']?>" name="from_name">
																</div>
																<div class="form-group m-form__group">
																	<label for="from_email">
																		From Email :
																	</label>
																	<input type="text" class="form-control m-input" id="from_email" value="<?=$general_setting_data['from_email']?>" name="from_email">
																</div>
																<div class="form-group m-form__group">
																	<label for="m_select2_2_modal">Mailer :</label>
																	<select class="form-control" name="mailer_type" id="m_select2_2_modal" onchange="chg_mailer_type(this.value);">
																		<option value=""> - Select - </option>
																		<option value="mail" <?php if($general_setting_data['mailer_type']=='mail'||$general_setting_data['mailer_type']==''){echo 'selected="selected"';}?>>PHP Mail</option>
																		<option value="smtp" <?php if($general_setting_data['mailer_type']=='smtp'){echo 'selected="selected"';}?>>SMTP</option>
																		<option value="sendgrid" <?php if($general_setting_data['mailer_type']=='sendgrid'){echo 'selected="selected"';}?>>SendGrid</option>
																	</select>
																</div>
																<?php
																$is_smtp_mailter = 'style="display:none;"';
																$is_emailapi_mailter = 'style="display:none;"';
																if($general_setting_data['mailer_type']=='smtp') {
																	$is_smtp_mailter = 'style="display:block;"';
																}
																if($general_setting_data['mailer_type']=='sendgrid') {
																	$is_emailapi_mailter = 'style="display:block;"';
																} ?>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_host">
																		SMTP Host :
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_host" value="<?=$general_setting_data['smtp_host']?>" name="smtp_host">
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_port">
																		SMTP Port :
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_port" value="<?=$general_setting_data['smtp_port']?>" name="smtp_port">
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_security">SMTP Security :</label>
																	<select class="form-control"  name="smtp_security" id="smtp_security">
																		<option value="none" <?php if($general_setting_data['smtp_security']=='none'){echo 'selected="selected"';}?>>None</option>
																		<option value="ssl" <?php if($general_setting_data['smtp_security']=='ssl'){echo 'selected="selected"';}?>>SSL/TLS</option>
																	</select>
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_username">
																		SMTP Username :
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_username" value="<?=$general_setting_data['smtp_username']?>" name="smtp_username">
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_password">
																		SMTP Password :
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_password" value="<?=$general_setting_data['smtp_password']?>" name="smtp_password">
																</div>
																<div class="form-group m-form__group showhide_emailapi_fields" <?=$is_emailapi_mailter?>>
																	<label for="email_api_key">
																		API Key :
																	</label>
																	<input type="text" class="form-control m-input" id="email_api_key" value="<?=$general_setting_data['email_api_key']?>" name="email_api_key">
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_4" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Socials Link
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="input">
																		Facebook Link :
																	</label>
																	<input type="text" class="form-control m-input" id="field-1" value="<?=$general_setting_data['fb_link']?>"  name="fb_link">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Twitter Link :
																	</label>
																	<input type="text" class="form-control m-input" id="field-1" value="<?=$general_setting_data['twitter_link']?>"  name="twitter_link">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		LinkedIn Link :
																	</label>
																	<input type="text" class="form-control m-input" id="field-1" value="<?=$general_setting_data['linkedin_link']?>"  name="linkedin_link">
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Social Login Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="m-form__group form-group">
																	<label for="published">
																		Social Login :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="show_social_login_on" name="social_login" value="1" <?php if($general_setting_data['social_login']=='1'){echo 'checked="checked"';}?>>
																			Yes
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="show_social_login_off" name="social_login" value="0" <?php if($general_setting_data['social_login']=='0'){echo 'checked="checked"';}?>>
																			No
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Social Login Option :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="social_login_option" name="social_login_option" value="g_f" <?=($general_setting_data['social_login_option']=="g_f"||$general_setting_data['social_login_option']==""?'checked="checked"':'')?>>
																			Google & Facebook
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="social_login_option" name="social_login_option" value="g" <?=($general_setting_data['social_login_option']=="g"?'checked="checked"':'')?>>
																			Google
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="social_login_option" name="social_login_option" value="f" <?=($general_setting_data['social_login_option']=="f"?'checked="checked"':'')?>>
																			Facebook
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Google Client ID :
																	</label>
																	<input type="text" class="form-control m-input" id="google_client_id" value="<?=$general_setting_data['google_client_id']?>" name="google_client_id">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Facebook App ID :
																	</label>
																	<input type="text" class="form-control m-input" id="fb_app_id" value="<?=$general_setting_data['fb_app_id']?>" name="fb_app_id">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Facebook App Secret :
																	</label>
																	<input type="text" class="form-control m-input" id="fb_app_secret" value="<?=$general_setting_data['fb_app_secret']?>" name="fb_app_secret">
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_5" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		SMS Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="m-form__group form-group">
																	<label for="published">
																		SMS Sending Status :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="sms_sending_status" name="sms_sending_status" value="1" <?=($general_setting_data['sms_sending_status']=='1'?'checked="checked"':'')?>>
																			ON
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="sms_sending_status" name="sms_sending_status" value="0" <?=(intval($general_setting_data['sms_sending_status'])=='0'?'checked="checked"':'')?>>
																			OFF
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label for="input">
																			Twilio Account SID :
																		</label>
																		<input type="text" class="form-control m-input" id="twilio_ac_sid" value="<?=$general_setting_data['twilio_ac_sid']?>" name="twilio_ac_sid">
																	</div>
																	<div class="col-4">
																		<label for="input">
																			Twilio Account Auth Token :
																		</label>
																		<input type="text" class="form-control m-input" id="twilio_ac_token" value="<?=$general_setting_data['twilio_ac_token']?>" name="twilio_ac_token">
																	</div>
																	<div class="col-4">
																		<label for="input">
																			Twilio Long Code :
																		</label>
																		<input type="text" class="form-control m-input" id="twilio_long_code" value="<?=$general_setting_data['twilio_long_code']?>" name="twilio_long_code">
																	</div>
																</div>
															</div>
														</div>
														<input type="hidden" name="id" value="<?=$brand_data['id']?>" />
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_6" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Blog Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="input">
																		Excerpt Length (number of words) :
																	</label>
																	<input type="text" class="form-control m-input" id="blog_rm_words_limit" value="<?=$general_setting_data['blog_rm_words_limit']?>" name="blog_rm_words_limit">
																</div>
																<div class="m-form__group form-group row">
																	<div class="col-6">
																		<label for="published">
																			Display Recent Post :
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="1" <?=($general_setting_data['blog_recent_posts']=='1'||$general_setting_data['blog_recent_posts']==""?'checked="checked"':'')?>>
																				Show
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="0" <?=($general_setting_data['blog_recent_posts']=='0'?'checked="checked"':'')?>>
																				Hide
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-6">
																		<label for="blog_categories">
																			Display Categories :
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="blog_categories" name="blog_categories" value="1" <?=($general_setting_data['blog_categories']=='1'||$general_setting_data['blog_categories']==""?'checked="checked"':'')?>>
																				Show
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="blog_categories" name="blog_categories" value="0" <?=($general_setting_data['blog_categories']=='0'?'checked="checked"':'')?>>
																				Hide
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  
			                  					<div class="tab-pane" id="m_tabs_6_8" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Sitemap(XML) File for SEO
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">

																<div class="form-group m-form__group">
																	<label for="fileInput">Upload Sitemap(XML) File :</label>
																	<div class="custom-file">
																		<input type="file" id="xml_file" class="custom-file-input" name="xml_file" onChange="checkFileXml(this)">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	$sitemap_url = "../sitemap.xml";
																	if(file_exists($sitemap_url)) { ?>
																		<a class="btn btn-danger btn-sm mt-2" data-dismiss="fileupload" href="controllers/general_settings.php?r_sitemap=yes" onclick="return confirm('Are you sure to delete sitemap(XML) file?');">Remove</a>
																	<?php
																	} ?>
																</div>
																
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_7" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Shipping API Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="fa_icon">Shipping API :</label>
																	<select class="form-control" name="shipping_api" id="shipping_api">
																		<option value=""> -Select- </option>
																   	<option value="royal_mail" <?php if($general_setting_data['shipping_api']=='royal_mail'){echo 'selected="selected"';}?>>Royal Mail</option>
																		<option value="easypost" <?php if($general_setting_data['shipping_api']=='easypost'){echo 'selected="selected"';}?>>Easy Post</option>
																	</select>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="shipment_generated_by_cust" type="checkbox" value="1" name="shipment_generated_by_cust" <?php if($general_setting_data['shipment_generated_by_cust']=='1'){echo 'checked="checked"';}?>>
																				Allow Shipment Generated to Customer
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="field-1">
																		Shipping API Key :
																	</label>
																	<input type="text" class="form-control m-input" id="shipping_api_key" value="<?=$general_setting_data['shipping_api_key']?>" name="shipping_api_key">
																</div>
																
																
																<div class="m-form__group form-group">
																	<label for="published">Default Carrier Account</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account1" name="default_carrier_account" value="usps" <?=($general_setting_data['default_carrier_account']=="usps"||$general_setting_data['default_carrier_account']==""?'checked="checked"':'')?>>
																			USPS
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account2" name="default_carrier_account" value="ups" <?=($general_setting_data['default_carrier_account']=="ups"?'checked="checked"':'')?>>
																			UPS
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account3" name="default_carrier_account" value="fedex" <?=($general_setting_data['default_carrier_account']=="fedex"?'checked="checked"':'')?>>
																			FedEx
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account4" name="default_carrier_account" value="dhl" <?=($general_setting_data['default_carrier_account']=="dhl"?'checked="checked"':'')?>>
																			DHL
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account5" name="default_carrier_account" value="other" <?=($general_setting_data['default_carrier_account']=="other"?'checked="checked"':'')?>>
																			Other
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="carrier_account_id">Carrier Account ID</label>
																	<input type="text" class="form-control m-input" id="carrier_account_id" value="<?=$general_setting_data['carrier_account_id']?>" name="carrier_account_id">
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="shipping_parcel_length">
																			Shipping Parcel Length :
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_length" value="<?=$general_setting_data['shipping_parcel_length']?>" name="shipping_parcel_length" placeholder="20.2">
																	</div>
																	<div class="col-6">
																		<label for="shipping_parcel_width">
																			Shipping Parcel Width :
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_width" value="<?=$general_setting_data['shipping_parcel_width']?>" name="shipping_parcel_width" placeholder="10.9">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="shipping_parcel_height">
																			Shipping Parcel Height :
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_height" value="<?=$general_setting_data['shipping_parcel_height']?>" name="shipping_parcel_height" placeholder="5">
																	</div>
																	<div class="col-6">
																		<label for="shipping_parcel_weight">
																			Shipping Parcel Weight :
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_weight" value="<?=$general_setting_data['shipping_parcel_weight']?>" name="shipping_parcel_weight" placeholder="65.9">
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_9" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Captcha Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="captcha_key">
																		Captcha Key :
																	</label>
																	<input type="text" class="form-control m-input" name="captcha_settings[captcha_key]" value="<?=$captcha_settings['captcha_key']?>">
																</div>
																<div class="form-group m-form__group">
																	<label for="captcha_secret">
																		Captcha Secret :
																	</label>
																	<input type="text" class="form-control m-input" name="captcha_settings[captcha_secret]" value="<?=$captcha_settings['captcha_secret']?>">
																</div>
																
																<div class="m-form__group form-group">
																	<label>Captcha Form Settings</label>
																	<div class="m-checkbox-inline">
																	
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[contact_form]" <?php if($captcha_settings['contact_form']=="1"){echo 'checked="checked"';}?>>
																			Contact Us Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[write_review_form]" <?php if($captcha_settings['write_review_form']=="1"){echo 'checked="checked"';}?>>
																			Write A Review Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[bulk_order_form]" <?php if($captcha_settings['bulk_order_form']=="1"){echo 'checked="checked"';}?>>
																			Bulk Order Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[affiliate_form]" <?php if($captcha_settings['affiliate_form']=="1"){echo 'checked="checked"';}?>>
																			Affiliate Form <span></span>
																		</label>
																		<?php /*?><label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[appt_form]" <?php if($captcha_settings['appt_form']=="1"){echo 'checked="checked"';}?>>
																			Appt. Form <span></span>
																		</label><?php */?>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[login_form]" <?php if($captcha_settings['login_form']=="1"){echo 'checked="checked"';}?>>
																			Login Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[signup_form]" <?php if($captcha_settings['signup_form']=="1"){echo 'checked="checked"';}?>>
																			Signup Form <span></span>
																		</label>
																		<?php /*?><label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[contractor_form]" <?php if($captcha_settings['contractor_form']=="1"){echo 'checked="checked"';}?>>
																			Contractor Form <span></span>
																		</label>
																		<?php */?>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[order_track_form]" <?php if($captcha_settings['order_track_form']=="1"){echo 'checked="checked"';}?>>
																			Order Track Form <span></span>
																		</label>
																		<!--<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[newsletter_form]" <?php if($captcha_settings['newsletter_form']=="1"){echo 'checked="checked"';}?>>
																			Newsletter Form <span></span>
																		</label>-->
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[missing_product_form]" <?php if($captcha_settings['missing_product_form']=="1"){echo 'checked="checked"';}?>>
																			Missing Product Form <span></span>
																		</label>
																		<!--<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[imei_number_based_search_form]" <?php if($captcha_settings['imei_number_based_search_form']=="1"){echo 'checked="checked"';}?>>
																			IMEI Number Based Search Form <span></span>
																		</label>-->
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_10" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Email Template Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="header_bg_color">Header bg color :</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[header_bg_color]" value="<?=$other_settings['header_bg_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="header_text_color">Header text color :</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[header_text_color]" value="<?=$other_settings['header_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="footer_bg_color">Footer bg color :</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[footer_bg_color]" value="<?=$other_settings['footer_bg_color']?>">
																	</div>
																	<div class="col-6">
																		<label for="footer_text_color">Footer text color :</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[footer_text_color]" value="<?=$other_settings['footer_text_color']?>">
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
			                </div>
										</div>
	                </div>
	              </div>
							</form>
						</div>
						<!--end::Portlet-->
					</div>
				</div>
				<!--End::Section-->
			</div>
		</div>
	</div>
	<!-- end:: Body -->
	<!-- begin::Footer -->
	<?php include("include/footer.php");?>
	<!-- end::Footer -->
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
	<i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
