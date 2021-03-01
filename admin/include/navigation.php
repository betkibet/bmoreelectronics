<?php
//if(!empty($staff_permissions_data)) { ?>
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
  <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
  <!-- BEGIN: Aside Menu -->
  <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
	  <li class="m-menu__item <?php if($file_name=="dashboard"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="dashboard.php" class="m-menu__link">
          <i class="m-menu__link-icon la-home la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Dashboard
              </span>
            </span>
          </span>
        </a>
      </li>
	  
	  <?php
	  if($prms_order_view == '1' || $prms_customer_view == '1' || $prms_emailtmpl_view == '1') { ?>
	  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="awaiting_orders" || $file_name=="orders" || $file_name=="paid_orders" || $file_name=="archive_orders" || $file_name=="edit_order" || $file_name=="users" || $file_name=="emailsms_history" || $file_name=="view_emailsms_history" || $file_name=="contractors"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
          <i class="m-menu__link-icon la la-paw"></i>
          <span class="m-menu__link-text">
            Customers / Orders
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
          <span class="m-menu__arrow"></span>
          <ul class="m-menu__subnav">
			  <?php
			  if($prms_customer_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="users"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a href="users.php" class="m-menu__link ">
				  <i class="m-menu__link-icon fa fa-users"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Customers
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  }
			  if($prms_customer_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="contractors"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a href="contractors.php" class="m-menu__link ">
				  <i class="m-menu__link-icon fa fa-users"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Contractors
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  }
	  		  if($prms_order_view == '1') { ?>
			  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="awaiting_orders" || $file_name=="orders" || $file_name=="paid_orders" || $file_name=="archive_orders" || $file_name=="edit_order"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				  <i class="m-menu__link-icon la la-paw"></i>
				  <span class="m-menu__link-text">
					Orders
				  </span>
				  <i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
				  <span class="m-menu__arrow"></span>
				  <ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
					  <span class="m-menu__link">
						<span class="m-menu__link-text">
						  Orders
						</span>
					  </span>
					</li>
					<li class="m-menu__item <?php if($file_name=="awaiting_orders" || ($file_name=="edit_order" && $_GET['order_mode']=="awaiting")){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="awaiting_orders.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Awaiting Orders
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="orders" || ($file_name=="edit_order" && $_GET['order_mode']=="unpaid")){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="orders.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Unpaid Orders
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="paid_orders" || ($file_name=="edit_order" && $_GET['order_mode']=="paid")){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="paid_orders.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Paid Orders
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="archive_orders" || ($file_name=="edit_order" && $_GET['order_mode']=="archive")){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="archive_orders.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Archive Orders
						</span>
					  </a>
					</li>
				  </ul>
				</div>
			  </li>
			  <?php
			  }
			  if($prms_emailtmpl_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="emailsms_history" || $file_name=="view_emailsms_history"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="emailsms_history.php" class="m-menu__link ">
				  <i class="m-menu__link-icon  la la-list-ul"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Email/SMS History
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  } ?>
			 </ul>
			</div>
		</li>
	  <?php
	  }

	  if($prms_category_view == '1' || $prms_brand_view == '1' || $prms_device_view == '1' || $prms_model_view == '1' || $prms_promocode_view == '1') { ?>
	  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="device_categories" || $file_name=="brand" || $file_name=="device" || $file_name=="mobile" || $file_name=="promocode"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
          <i class="m-menu__link-icon la la-align-justify"></i>
          <span class="m-menu__link-text">
            Products
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
          <span class="m-menu__arrow"></span>
          <ul class="m-menu__subnav">
			  <?php
			  if($prms_category_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="device_categories"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="device_categories.php" class="m-menu__link ">
				  <i class="m-menu__link-icon la-align-justify la"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Categories
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  }
			  if($prms_brand_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="brand"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="brand.php" class="m-menu__link ">
				  <i class="m-menu__link-icon la-bold la"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Brands
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  }
			  if($prms_device_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="device"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="device.php" class="m-menu__link ">
				  <i class="m-menu__link-icon la-mobile la"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Devices
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  }
			  if($prms_model_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="mobile"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="mobile.php" class="m-menu__link ">
				  <i class="m-menu__link-icon la la-maxcdn"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Models
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  }
			  if($prms_promocode_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="promocode"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="promocode.php" class="m-menu__link ">
				  <i class="m-menu__link-icon la-ticket la"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Promo Codes
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  } ?>
			</ul>
		</div>
	  </li> 
	  <?php
	  }

	  if($prms_page_view == '1' || $prms_form_view == '1' || $prms_menu_view == '1' || $prms_blog_view == '1' || $prms_faq_view == '1') { ?>
	  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="system_page" || $file_name=="custom_page" || $file_name=="paid_orders" || $file_name=="archive_orders" || $file_name=="contact" || $file_name=="review" || $file_name=="bulk_order" || $file_name=="newsletter" || $file_name=="menu" || $file_name=="blog" || $file_name=="categories" || $file_name=="faqs_groups" || $file_name=="faqs" || $file_name=="home_settings"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
          <i class="m-menu__link-icon la la-file-text"></i>
          <span class="m-menu__link-text">
            Site
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
          <span class="m-menu__arrow"></span>
          <ul class="m-menu__subnav">
			  <?php
			  if($prms_page_view == '1') { ?>
			  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="system_page" || $file_name=="custom_page"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				  <i class="m-menu__link-icon la-file-text la"></i>
				  <span class="m-menu__link-text">
					Pages
				  </span>
				  <i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
				  <span class="m-menu__arrow"></span>
				  <ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
					  <span class="m-menu__link">
						<span class="m-menu__link-text">
						  Pages
						</span>
					  </span>
					</li>
					<li class="m-menu__item <?php if($file_name=="system_page"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="system_page.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Site Page
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="custom_page"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="custom_page.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Custom Page
						</span>
					  </a>
					</li>
				  </ul>
				</div>
			  </li>
			  <li class="m-menu__item <?php if($file_name=="home_settings"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a  href="home_settings.php" class="m-menu__link ">
					<i class="m-menu__link-icon la-file-text la">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  Home Page
					</span>
				  </a>
			  </li>
			  <?php
			  }
			  if($prms_form_view == '1') { ?>
				<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="contact" || $file_name=="review" || $file_name=="bulk_order" || $file_name=="newsletter"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				  <i class="m-menu__link-icon la-tasks la"></i>
				  <span class="m-menu__link-text">
					Forms
				  </span>
				  <i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
				  <span class="m-menu__arrow"></span>
				  <ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
					  <span class="m-menu__link">
						<span class="m-menu__link-text">
						  Forms
						</span>
					  </span>
					</li>
					<li class="m-menu__item <?php if($file_name=="contact"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="contact.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Contacts
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="review"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="review.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Reviews
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="bulk_order"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="bulk_order.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Bulk Orders
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="newsletter"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="newsletter.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Newsletters
						</span>
					  </a>
					</li>
				  </ul>
				</div>
				</li>
			  <?php
			  }
			  if($prms_menu_view == '1') { ?>
				<li class="m-menu__item <?php if($file_name=="menu"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="menu.php?position=header" class="m-menu__link ">
				  <i class="m-menu__link-icon  la la-list-ul"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Menus
					  </span>
					</span>
				  </span>
				</a>
				</li>
			  <?php
			  }
			  if($prms_blog_view == '1') { ?>
				<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="blog" || $file_name=="categories"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				  <i class="m-menu__link-icon la la-newspaper-o"></i>
				  <span class="m-menu__link-text">
					Blog
				  </span>
				  <i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
				  <span class="m-menu__arrow"></span>
				  <ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
					  <span class="m-menu__link">
						<span class="m-menu__link-text">
						  Blog
						</span>
					  </span>
					</li>
					<li class="m-menu__item <?php if($file_name=="blog"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="blog.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Blog
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="categories"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="categories.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Categories
						</span>
					  </a>
					</li>
				  </ul>
				</div>
				</li>
			  <?php
			  }
			  if($prms_faq_view == '1') { ?>
				<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="faqs_groups" || $file_name=="faqs"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				  <i class="m-menu__link-icon la la-question"></i>
				  <span class="m-menu__link-text">
					Faqs
				  </span>
				  <i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu ">
				  <span class="m-menu__arrow"></span>
				  <ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
					  <span class="m-menu__link">
						<span class="m-menu__link-text">
						  Faqs
						</span>
					  </span>
					</li>
					<li class="m-menu__item <?php if($file_name=="faqs_groups"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="faqs_groups.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Faqs Groups
						</span>
					  </a>
					</li>
					<li class="m-menu__item <?php if($file_name=="faqs"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
					  <a  href="faqs.php" class="m-menu__link ">
						<i class="m-menu__link-bullet m-menu__link-bullet--dot">
						  <span></span>
						</i>
						<span class="m-menu__link-text">
						  Faqs
						</span>
					  </a>
					</li>
				  </ul>
				</div>
				</li>
			  <?php
			  } ?>
			</ul>
		</div>
	  </li> 
	  <?php
	  } ?>
	  
	  <li class="m-menu__item <?php if($file_name=="affiliate"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
		<a  href="affiliate.php" class="m-menu__link ">
		  <i class="m-menu__link-icon fa fa-user"></i>
		  <span class="m-menu__link-title">
			<span class="m-menu__link-wrap">
			  <span class="m-menu__link-text">
				Affiliates
			  </span>
			</span>
		  </span>
		</a>
	  </li>

	  <?php
	  if($admin_type == "super_admin" || $prms_emailtmpl_view == '1') { ?>
	  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="general_settings" || $file_name=="service_hours" || $file_name=="staff" || $file_name=="staff_group" || $file_name=="email_template" || $file_name=="order_status" || $file_name=="order_item_status" || $file_name=="location" || $file_name=="order_complete_page"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
          <i class="m-menu__link-icon la la-cog"></i>
          <span class="m-menu__link-text">
            Settings
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
          <span class="m-menu__arrow"></span>
          <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
              <span class="m-menu__link">
                <span class="m-menu__link-text">
                  Settings
                </span>
              </span>
            </li>

			<?php
		    if($admin_type == "super_admin") { ?>
				<li class="m-menu__item <?php if($file_name=="general_settings"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a  href="general_settings.php" class="m-menu__link ">
					<i class="m-menu__link-bullet m-menu__link-bullet--dot">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  General
					</span>
				  </a>
				</li>
				<li class="m-menu__item <?php if($file_name=="service_hours"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a  href="service_hours.php" class="m-menu__link ">
					<i class="m-menu__link-bullet m-menu__link-bullet--dot">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  Service Hours
					</span>
				  </a>
				</li>
				<li class="m-menu__item <?php if($file_name=="order_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a href="order_status.php" class="m-menu__link ">
					<i class="m-menu__link-bullet m-menu__link-bullet--dot">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  Order Status
					</span>
				  </a>
				</li>
				<li class="m-menu__item <?php if($file_name=="order_item_status"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a href="order_item_status.php" class="m-menu__link ">
					<i class="m-menu__link-bullet m-menu__link-bullet--dot">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  Order Item Status
					</span>
				  </a>
				</li>
				<li class="m-menu__item <?php if($file_name=="location"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a href="location.php" class="m-menu__link ">
					<i class="m-menu__link-bullet m-menu__link-bullet--dot">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  Store Locations
					</span>
				  </a>
				</li>
				<li class="m-menu__item <?php if($file_name=="order_complete_page"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				  <a href="order_complete_pages.php" class="m-menu__link ">
					<i class="m-menu__link-bullet m-menu__link-bullet--dot">
					  <span></span>
					</i>
					<span class="m-menu__link-text">
					  Order Complete Pages
					</span>
				  </a>
				</li>
				
				<li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="staff" || $file_name=="staff_group"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
					<a  href="javascript:;" class="m-menu__link m-menu__toggle">
					  <i class="m-menu__link-icon la la-users"></i>
					  <span class="m-menu__link-text">
						Staff User(s)
					  </span>
					  <i class="m-menu__ver-arrow la la-angle-right"></i>
					</a>
					<div class="m-menu__submenu ">
					  <span class="m-menu__arrow"></span>
					  <ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
						  <span class="m-menu__link">
							<span class="m-menu__link-text">
							  Staff User(s)
							</span>
						  </span>
						</li>
						<li class="m-menu__item <?php if($file_name=="staff"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
						  <a  href="staff.php" class="m-menu__link ">
							<i class="m-menu__link-bullet m-menu__link-bullet--dot">
							  <span></span>
							</i>
							<span class="m-menu__link-text">
							  Staff User(s)
							</span>
						  </a>
						</li>
						<li class="m-menu__item <?php if($file_name=="staff_group"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
						  <a  href="staff_group.php" class="m-menu__link ">
							<i class="m-menu__link-bullet m-menu__link-bullet--dot">
							  <span></span>
							</i>
							<span class="m-menu__link-text">
							  Staff Group(s)
							</span>
						  </a>
						</li>
					  </ul>
					</div>
				</li>
			  <?php
			  }
			  
			  if($prms_emailtmpl_view == '1') { ?>
			  <li class="m-menu__item <?php if($file_name=="email_template"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
				<a  href="email_templates.php" class="m-menu__link ">
				  <i class="m-menu__link-icon la-stack-exchange la"></i>
				  <span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
					  <span class="m-menu__link-text">
						Email Templates
					  </span>
					</span>
				  </span>
				</a>
			  </li>
			  <?php
			  } ?>
          </ul>
        </div>
      </li>
	  <?php
	  } ?>
    </ul>
  </div>
  <!-- END: Aside Menu -->
</div>
<?php
//} ?>
