<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
  <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
  <!-- BEGIN: Aside Menu -->
  <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
      <?php /*?><li class="m-menu__item  <?php if($file_name=="profile"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="profile.php" class="m-menu__link ">
          <i class="m-menu__link-icon flaticon-graph"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Dashboard
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li><?php */?>
      <!-- <li class="m-nav__item">
        <a href="general_settings.php" class="m-nav__link">
          <i class="m-nav__link-icon flaticon-share"></i>
          <span class="m-nav__link-text">
            Settings
          </span>
        </a>
      </li>
      <li class="m-nav__item">
        <a href="staff.php" class="m-nav__link">
          <i class="m-nav__link-icon flaticon-chat-1"></i>
          <span class="m-nav__link-text">
            Staff User(s)
          </span>
        </a>
      </li> -->
      <li class="m-menu__item <?php if($file_name=="device_categories"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="device_categories.php" class="m-menu__link ">
          <i class="m-menu__link-icon la-align-justify la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Categories
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item <?php if($file_name=="brand"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="brand.php" class="m-menu__link ">
          <i class="m-menu__link-icon la-bold la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Brands
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item <?php if($file_name=="device"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="device.php" class="m-menu__link ">
          <i class="m-menu__link-icon la-mobile la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Devices
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item <?php if($file_name=="mobile"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="mobile.php" class="m-menu__link ">
          <i class="m-menu__link-icon la la-maxcdn"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Models
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item <?php if($file_name=="orders"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="orders.php" class="m-menu__link ">
          <i class="m-menu__link-icon la la-paw"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Orders
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
	  <?php /*?><li class="m-menu__item <?php if($file_name=="partners"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="partners.php" class="m-menu__link ">
          <i class="m-menu__link-icon fa fa-user"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Partners
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li><?php */?>
      <li class="m-menu__item <?php if($file_name=="users"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="users.php" class="m-menu__link ">
          <i class="m-menu__link-icon fa fa-users"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Customers
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="contact" || $file_name=="review" || $file_name=="bulk_order" || $file_name=="affiliate"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
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
            <li class="m-menu__item <?php if($file_name=="affiliate"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
              <a  href="affiliate.php" class="m-menu__link ">
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span></span>
                </i>
                <span class="m-menu__link-text">
                  Affiliates
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="m-menu__item <?php if($file_name=="promocode"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="promocode.php" class="m-menu__link ">
          <i class="m-menu__link-icon la-ticket la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Promo Codes
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <li class="m-menu__item <?php if($file_name=="email_template"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="email_templates.php" class="m-menu__link ">
          <i class="m-menu__link-icon la-stack-exchange la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Email Templates
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
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
      <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="groups" || $file_name=="custom_fields"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
          <i class="m-menu__link-icon flaticon-file-1"></i>
          <span class="m-menu__link-text">
            Custom Fields
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
          <span class="m-menu__arrow"></span>
          <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
              <span class="m-menu__link">
                <span class="m-menu__link-text">
                  Custom Fields
                </span>
              </span>
            </li>
            <li class="m-menu__item <?php if($file_name=="groups"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
              <a  href="groups.php" class="m-menu__link ">
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span></span>
                </i>
                <span class="m-menu__link-text">
                  Manage Groups
                </span>
              </a>
            </li>
            <li class="m-menu__item <?php if($file_name=="custom_fields"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
              <a  href="custom_fields.php" class="m-menu__link ">
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span></span>
                </i>
                <span class="m-menu__link-text">
                  Custom Fields
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <?php /*?><li class="m-menu__item <?php if($file_name=="page"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="page.php" class="m-menu__link ">
          <i class="m-menu__link-icon la-file-text la"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Pages
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li><?php */?>
	  
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
                  System Page
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
	  
      <li class="m-menu__item <?php if($file_name=="menu"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="menu.php?position=header" class="m-menu__link ">
          <i class="m-menu__link-icon  la la-list-ul"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Menus
              </span>
              <span class="m-menu__link-badge">
                <!-- <span class="m-badge m-badge--danger">
                  2
                </span> -->
              </span>
            </span>
          </span>
        </a>
      </li>
      <?php /*?><li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="promocode" || $file_name=="email_template"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
          <i class="m-menu__link-icon la  la-sitemap"></i>
          <span class="m-menu__link-text">
            Others
          </span>
          <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu ">
          <span class="m-menu__arrow"></span>
          <ul class="m-menu__subnav">
            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
              <span class="m-menu__link">
                <span class="m-menu__link-text">
                  Others
                </span>
              </span>
            </li>
            <li class="m-menu__item <?php if($file_name=="promocode"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
              <a  href="promocode.php" class="m-menu__link ">
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span></span>
                </i>
                <span class="m-menu__link-text">
                  Promo Codes
                </span>
              </a>
            </li>
            <li class="m-menu__item <?php if($file_name=="email_template"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
              <a  href="email_templates.php" class="m-menu__link ">
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span></span>
                </i>
                <span class="m-menu__link-text">
                  Email Templates
                </span>
              </a>
            </li>
          </ul>
        </div>
      </li><?php */?>
      <?php /*?><li class="m-menu__item <?php if($file_name=="general_settings"){echo 'm-menu__item--active';}?>" aria-haspopup="true">
        <a  href="general_settings.php" class="m-menu__link ">
          <i class="m-menu__link-icon la la-cog"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Settings
              </span>
              <span class="m-menu__link-badge">
              </span>
            </span>
          </span>
        </a>
      </li><?php */?>
	  
	  <li class="m-menu__item  m-menu__item--submenu <?php if($file_name=="general_settings" || $file_name=="home_settings" || $file_name=="service_hours"){echo 'm-menu__item--active m-menu__item--open';}?>" aria-haspopup="true"  m-menu-submenu-toggle="hover">
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
            <li class="m-menu__item <?php if($file_name=="home_settings"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
              <a  href="home_settings.php" class="m-menu__link ">
                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                  <span></span>
                </i>
                <span class="m-menu__link-text">
                  Home Page
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
          </ul>
        </div>
      </li>
	  
      <li class="m-menu__item <?php if($file_name=="staff"){echo 'm-menu__item--active';}?>" aria-haspopup="true" >
        <a  href="staff.php" class="m-menu__link ">
          <i class="m-menu__link-icon la la-users"></i>
          <span class="m-menu__link-title">
            <span class="m-menu__link-wrap">
              <span class="m-menu__link-text">
                Staff User(s)
              </span>
              <span class="m-menu__link-badge">
              </span>
            </span>
          </span>
        </a>
      </li>
      
      
    </ul>
  </div>
  <!-- END: Aside Menu -->
</div>
