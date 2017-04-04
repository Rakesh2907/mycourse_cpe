<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<!--<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>-->
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="start <?php if(isset($menutitle) && $menutitle == 'Dashboard'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php echo base_url();?>index_con">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Dashboard'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
				</li>
				<li class="<?php if(isset($menutitle) && $menutitle == 'Customers'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-users"></i>
					<span class="title">Customers</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Customers'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>customer_con">Manage Customers</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>customer_con/add_customer">Add Customer</a>
						</li>
					</ul>
				</li>
				<li class="<?php if(isset($menutitle) && $menutitle == 'Courses'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-docs"></i>
					<span class="title">Courses</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Courses'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>course_con">Manage Courses</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>course_con/add_course">Add Course</a>
						</li>
					</ul>
				</li>
                <li class="<?php if(isset($menutitle) && $menutitle == 'Bundles'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-briefcase"></i>
					<span class="title">Bundles</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Bundles'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>bundle_con">Manage Bundles</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>bundle_con/add_bundle">Add Bundle</a>
						</li>
					</ul>
				</li>
                
                <li class="<?php if(isset($menutitle) && $menutitle == 'Landing Bundles'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-briefcase"></i>
					<span class="title">Landing Pages</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Landing'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>landing_con">Manage Landing Pages</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>landing_con/add_bundle">Add Landing Page</a>
						</li>
					</ul>
				</li>
                
                 <li class="<?php if(isset($menutitle) && $menutitle == 'Subscription'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-badge"></i>
					<span class="title">Subscription</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Subscription'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>subcription_con">Manage Subscription</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>subcription_con/add_subcription">Add Subscription</a>
						</li>
					</ul>
				</li>
                
            		<li class="<?php if(isset($menutitle) && $menutitle == 'CMS'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-layers"></i>
					<span class="title">CMS Pages</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'CMS'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>cms_con">Manage CMS Pages</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>cms_con/add_cms_pages">Add CMS Page</a>
						</li>
					</ul>
				</li>
                
                <li class="<?php if(isset($menutitle) && $menutitle == 'Faculty'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-graduation"></i>
					<span class="title">Faculty</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Faculty Management'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>faculty_con">Manage Faculty</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>faculty_con/add_faculty_details">Add Faculty</a>
						</li>
					</ul>
				</li>
                <li class="<?php if(isset($menutitle) && $menutitle == 'FAQ'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-question" aria-hidden="true"></i>
					<span class="title">FAQ</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'FAQ Management'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>faq_con">Manage FAQ</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>faq_con/add_faq">Add FAQ</a>
						</li>
					</ul>
				</li>
                <li class="<?php if(isset($menutitle) && $menutitle == 'State'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-flag" aria-hidden="true"></i>
					<span class="title">State</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'State Management'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>state_con">Manage State</a>
						</li>
                        
					</ul>
				</li>
                <li class="<?php if(isset($menutitle) && $menutitle == 'Coupon'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-wallet" aria-hidden="true"></i>
					<span class="title">Coupons</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'coupon Management'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>coupon_con">Manage coupon</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>coupon_con/add_coupon_details">Add coupon</a>
						</li>
					</ul>
                    
				</li>
                <li class="<?php if(isset($menutitle) && $menutitle == 'Users Order'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-basket-loaded" aria-hidden="true"></i>
					<span class="title">Orders</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'User Orders Management'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>userorder_con">Manage User Orders</a>
						</li>
                        
					</ul>
				</li>
                <li class="<?php if(isset($menutitle) && $menutitle == 'Reports'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
					<i class="icon-briefcase" aria-hidden="true"></i>
					<span class="title">Reports</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Reports'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>index_con/customer_listing/today">Customers</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>index_con/repeat_customer_listing/today">Repeated Customers</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>index_con/top_customers">Top Customers</a>
						</li>
                           <li>
							<a href="<?php echo base_url();?>index_con/completed_course">Completed Courses</a>
						</li>
                        <li>
							<a href="<?php echo base_url();?>index_con/customer_order_list/today">Orders</a>
						</li>
					</ul>
				</li>
			</ul>
            
		</div>
	</div>