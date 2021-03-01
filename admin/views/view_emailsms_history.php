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
					<div class="col-lg-10">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  Email/SMS Details
										</h3>
									</div>
								</div>
							</div>
							<div class="m-form">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										
										<div class="form-group m-form__group row">
											<div class="col-sm-6">
												<label for="input">
													From Email
												</label>
												<div class="form-control m-input">
													<?=$inbox_mail_sms_data['from_email']?>
												</div>
											</div>
											<div class="col-sm-6">
												<label for="input">
													To Email
												</label>
												<div class="form-control m-input">
													<?=$inbox_mail_sms_data['to_email']?>
												</div>
											</div>
										</div>
										
										<div class="form-group m-form__group row">
											<div class="col-sm-6">
												<label for="input">
													IP
												</label>
												<div class="form-control m-input">
													<?=$inbox_mail_sms_data['visitor_ip']?>
												</div>
											</div>
											<div class="col-sm-6">
												<label for="input">
													LeadSource
												</label>
												<div class="form-control m-input">
													<?=ucwords(str_replace("_"," ",$inbox_mail_sms_data['form_type']))?>
												</div>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label for="input">
												Subject
											</label>
											<div class="form-control m-input">
												<?=$inbox_mail_sms_data['subject']?>
											</div>
										</div>
										
										<?php
										global $company_address;
										global $company_city;
										global $company_state;
										global $company_zipcode;
										global $company_country;
										global $copyright;
										global $other_settings;
									
										$header_bg_color = ($other_settings['header_bg_color']?"#".$other_settings['header_bg_color']:"#126de5");
										$header_text_color = ($other_settings['header_text_color']?"#".$other_settings['header_text_color']:"#ffffff");
										$footer_bg_color = ($other_settings['footer_bg_color']?"#".$other_settings['footer_bg_color']:"#242b3d");
										$footer_text_color = ($other_settings['footer_text_color']?"#".$other_settings['footer_text_color']:"#a0a3ab");
									
										$logo_fixed_url = SITE_URL.'images/'.$general_setting_data['logo_fixed'];
										
										$contact_link = SITE_URL.get_inbuild_page_url('contact');
										$blog_link = SITE_URL.get_inbuild_page_url('blog');
										
										$email_html = '';
										$email_html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
										  $email_html .= '<tbody>';
											$email_html .= '<tr>';
											  $email_html .= '<td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-top: 8px;">';
												$email_html .= '<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
												  $email_html .= '<tbody>';
													$email_html .= '<tr>';
													  $email_html .= '<td class="o_bg-primary o_px o_py-md o_br-t o_sans o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: '.$header_bg_color.';border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-top: 24px;padding-bottom: 24px;">';
														$email_html .= '<p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-white" href="'.SITE_URL.'" style="text-decoration: none;outline: none;color: '.$header_text_color.';"><img src="'.$logo_fixed_url.'" width="136" height="36" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>';
													  $email_html .= '</td>';
													$email_html .= '</tr>';
												  $email_html .= '</tbody>';
												$email_html .= '</table>';
											  $email_html .= '</td>';
											$email_html .= '</tr>';
										  $email_html .= '</tbody>';
										$email_html .= '</table>';
										$email_html .= $inbox_mail_sms_data['body'];
									
										$email_html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
										  $email_html .= '<tbody>';
											$email_html .= '<tr>';
											  $email_html .= '<td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-bottom: 8px;">';
												$email_html .= '<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
												  $email_html .= '<tbody>';
													$email_html .= '<tr>';
													  $email_html .= '<td class=" o_bg-dark o_px-md o_py-lg o_br-b o_sans o_text-xs o_text-dark_light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color: '.$footer_bg_color.';color: '.$footer_text_color.';border-radius: 0px 0px 4px 4px;padding-left: 24px;padding-right: 24px;padding-top: 32px;padding-bottom: 32px;">';
														$email_html .= '<p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;">'.$copyright.'</p>';
														$email_html .= '<p class="o_mb-xs" style="margin-top: 0px;margin-bottom:0px;">'.$company_address.', '.$company_city.', '.$company_state.' '.$company_zipcode.($company_country?', '.$company_country:'').'</p>';
														/*$email_html .= '<p class="o_mb-lg" style="margin-top: 0px;">
														  <a class="o_text-dark_light o_underline" href="'.$contact_link.'" style="text-decoration: underline;outline: none;color: #a0a3ab;">Help Center</a> <span class="o_hide-xs">&nbsp; &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
														  <a class="o_text-dark_light o_underline" href="'.$blog_link.'" style="text-decoration: underline;outline: none;color: #a0a3ab;">Blog</a>
														</p>';*/
													  $email_html .= '</td>';
													$email_html .= '</tr>';
												  $email_html .= '</tbody>';
												$email_html .= '</table>';
												//$email_html .= '<div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div>';
											  $email_html .= '</td>';
											$email_html .= '</tr>';
										  $email_html .= '</tbody>';
										$email_html .= '</table>'; ?>
										<div class="form-group m-form__group">
											<label for="input">
												Email Content
											</label>
											<div class="form-control m-input">
											<?=$email_html?>
											</div>
										</div>
										<?php
										if($inbox_mail_sms_data['sms_content']!="") { ?>
										<div class="form-group m-form__group">
											<label for="input">
												SMS Content
											</label>
											<div class="form-control m-input">
											<?=$inbox_mail_sms_data['sms_content']?>
											</div>
										</div>
										<?php
										} ?>
									</div>
								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<a href="emailsms_history.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
							</div>
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
