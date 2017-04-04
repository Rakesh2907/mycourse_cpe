<div class="col-lg-2 col-md-3">
  <div class="sidebar-links">
    <div class="drop-nav-outer">
      <button data-toggle="dropdown" id="inp_impact" class="dropdown-toggle btn drp-btn visible-xs visible-sm"> <span id="text">
	  
	  <?php 
	   switch ($sider_bar) {
				        
						case 'credits':
								$name= 'My Credits';
								break;
						case 'courses':
								$name.='My Courses';
								break;
						case 'certificate':
								$name= 'My Certificates';
								break;
						case 'orders':
								$name= 'Order History';
								break;	
						case 'billing':
								$name= 'Billing';
								break;
						case 'setting':
								$name= 'Settings';
								break;
						default:
							
						}
	  echo $name;
	  
	  ?>
      
      </span><span class="caret"></span></button>
      <ul id="drop-nav" class="dropdown-menu list-unstyled my_ac_nav">
        <li <?php if($sider_bar == 'courses'){ echo 'class="active"';}else{ echo '';}?>><a href="<?php echo base_url();?>mycourses">My Courses</a></li>
        <li <?php if($sider_bar == 'certificate'){ echo 'class="active"';}else{ echo '';}?>><a href="<?php echo base_url();?>mycertificates">My Certificates</a></li>
        <li <?php if($sider_bar == 'credits'){ echo 'class="active"';}else{ echo '';}?>><a href="<?php echo base_url();?>mycredits">My Credits</a></li>
        <li <?php if($sider_bar == 'orders'){ echo 'class="active"';}else{ echo '';}?>><a href="<?php echo base_url();?>myorders">Order History</a></li>
        <li <?php if($sider_bar == 'billing'){ echo 'class="active"';}else{ echo '';}?>><a href="<?php echo base_url();?>mybilling">Billing</a></li>
        <li <?php if($sider_bar == 'setting'){ echo 'class="active"';}else{ echo '';}?>><a href="<?php echo base_url();?>mysetting">Settings</a></li>
      </ul>
    </div>
    <!-- /drop-nav --> 
  </div>
</div>
<!-- /col -->