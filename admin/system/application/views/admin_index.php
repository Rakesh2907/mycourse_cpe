<!-- BEGIN DASHBOARD STATS -->
 <h4>Daily Reports</h4>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="icon-users"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $todays_total_customers;?>
							</div>
							<div class="desc">
								 Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_listing/today">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="icon-docs"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $todays_total_order;?>
							</div>
							<div class="desc">
								 Orders
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_order_list/today">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="icon-briefcase"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $todays_repeat_cust; ?>
							</div>
							<div class="desc">
								 Repeated Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/repeat_customer_listing/today">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
								  <?php
								   if($todays_total_sale > 0)
								   {
								    echo '$'.$todays_total_sale;
								   }else{
									   
									echo '$0';   
								  }?>
							</div>
							<div class="desc">
								 Sale
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
            
            <!-- Weekly orders -->
            <h4>Weekly Reports</h4>
            <div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="icon-users"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $week_total_customers;?>
							</div>
							<div class="desc">
								 Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_listing/week">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="icon-docs"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $week_total_order;?>
							</div>
							<div class="desc">
								 Orders
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_order_list/week">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="icon-briefcase"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $week_repeat_cust; ?>
							</div>
							<div class="desc">
								 Repeated Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/repeat_customer_listing/week">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
                                   <?php
								   if($week_total_sale > 0)
								   {
								    echo '$'.$week_total_sale;
								   }else{
									   
									echo '$0';   
								  }?>
							</div>
							<div class="desc">
								 Sale
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:none;">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
                                   <?php
								   if($last_week_percentage > 0)
								   {
								    echo '%'.$last_week_percentage;
								   }else{
									   
									echo '%0';   
								  }?>
							</div>
							<div class="desc">
								 Last Week
							</div>
						</div>
						<a class="more" href="javascript:void(0)">
						
						</a>
					</div>
				</div>
			</div>
            <!-- End Weekly orders -->
             <!-- Month orders -->
            <h4>Month Reports</h4>
            <div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="icon-users"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $month_total_customers;?>
							</div>
							<div class="desc">
								 Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_listing/month">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="icon-docs"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $month_total_order;?>
							</div>
							<div class="desc">
								 Orders
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_order_list/month">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="icon-briefcase"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $month_repeat_cust; ?>
							</div>
							<div class="desc">
								  Repeated Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/repeat_customer_listing/month">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
								           <?php
								   if($month_total_sale > 0)
								   {
								    echo '$'.$month_total_sale;
								   }else{
									   
									echo '$0';   
								  }?>
							</div>
							<div class="desc">
								 Sale
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:none;">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
								           <?php
								   if($last_year_month_percentage > 0)
								   {
								    echo '%'.$last_year_month_percentage;
								   }else{
									   
									echo '%0';   
								  }?>
							</div>
							<div class="desc">
								 Last year this month
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
            <!-- End Month orders -->
            
             <!-- Year orders -->
            <h4>Year Reports</h4>
            <div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="icon-users"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $year_total_customers;?>
							</div>
							<div class="desc">
								 Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_listing/year">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="icon-docs"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $year_total_order;?>
							</div>
							<div class="desc">
								 Orders
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/customer_order_list/year">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="icon-briefcase"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $year_repeat_cust; ?>
							</div>
							<div class="desc">
								  Repeated Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>index_con/repeat_customer_listing/year">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
								           <?php
								   if($year_total_sale > 0)
								   {
								    echo '$'.$year_total_sale;
								   }else{
									   
									echo '$0';   
								  }?>
							</div>
							<div class="desc">
								 Sale
							</div>
						</div>
						<a class="more" href="#">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
            <!-- End Year orders -->
			<div class="clearfix">
			</div>
			<div class="row ">
				<div class="col-md-6 col-sm-6">
					
				</div>
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid grey-cararra bordered" style="display:none">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bullhorn"></i>Revenue
							</div>
							<div class="actions">
								<div class="btn-group pull-right">
									<a href="" class="btn grey-steel btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									Filter <span class="fa fa-angle-down">
									</span>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:;">
											Q1 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q2 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li class="active">
											<a href="javascript:;">
											Q3 2014 <span class="label label-sm label-success">
											current </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q4 2014 <span class="label label-sm label-warning">
											upcoming </span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<div id="site_activities_loading" style="display: none;">
								<img src="../../assets/admin/layout/img/loading.gif" alt="loading">
							</div>
							<div id="site_activities_content" class="display-none" style="display: block;">
								<div id="site_activities" style="height: 228px; padding: 0px; position: relative;">
								<canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 500px; height: 228px;" width="500" height="228"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 20px; text-align: center;">DEC</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 72px; text-align: center;">JAN</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 123px; text-align: center;">FEB</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 171px; text-align: center;">MAR</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 224px; text-align: center;">APR</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 274px; text-align: center;">MAY</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 327px; text-align: center;">JUN</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 379px; text-align: center;">JUL</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 427px; text-align: center;">AUG</div><div style="position: absolute; max-width: 50px; font: small-caps 400 10px/18px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 209px; left: 481px; text-align: center;">SEP</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; font: small-caps 400 10px/14px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 197px; left: 18px; text-align: right;">0</div><div style="position: absolute; font: small-caps 400 10px/14px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 149px; left: 7px; text-align: right;">500</div><div style="position: absolute; font: small-caps 400 10px/14px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 100px; left: 1px; text-align: right;">1000</div><div style="position: absolute; font: small-caps 400 10px/14px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 52px; left: 1px; text-align: right;">1500</div><div style="position: absolute; font: small-caps 400 10px/14px &quot;Open Sans&quot;,sans-serif; color: rgb(111, 123, 138); top: 3px; left: 1px; text-align: right;">2000</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 500px; height: 228px;" width="500" height="228"></canvas></div>
							</div>
							<div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-success">
										Revenue: </span>
										<h3>$13,234</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-info">
										Tax: </span>
										<h3>$134,900</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-danger">
										Shipment: </span>
										<h3>$1,134</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-warning">
										Orders: </span>
										<h3>235090</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
			<div class="clearfix">
			</div>