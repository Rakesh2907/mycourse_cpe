<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>CPE Nation | Home</title>
<link rel="icon" href="<?php echo $this->config->item("cdn_css_image")?>images/favicon.ico" type="image/x-icon">
<!-- Bootstrap -->
<link href="<?php echo $this->config->item("cdn_css_image")?>css/bootstrap.min.css" rel="stylesheet">
<!-- Feather Fonts -->
<link href="<?php echo $this->config->item("cdn_css_image")?>css/feather.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $this->config->item("cdn_css_image")?>css/font-awesome.min.css">
<!-- Custom Stylesheet -->
<link href="<?php echo $this->config->item("cdn_css_image")?>css/stylesheet.css" rel="stylesheet">
<link href="<?php echo $this->config->item("cdn_css_image")?>css/custom.css" rel="stylesheet">
<!-- Font Family -->
<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,500italic,600,600italic,700" rel="stylesheet" type="text/css">
<!-- Select Box -->
<link href="<?php echo $this->config->item("cdn_css_image")?>css/bootstrap-select.css" rel="stylesheet">
<!-- drawer -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("cdn_css_image")?>css/jv-jquery-mobile-menu.css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="homepage">
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<div class="page">
  <div class="wrapper header-top">
    <a href="<?php echo base_url();?>cart"><div class="cart-mobile white-cart"><span class="cart-number"><?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?></span></div></a>
    <div class="logo pull-left"> <a href="<?php echo base_url()?>"> <img class="white-logo" src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-wht.png" alt="CPENATION" /> <img class="clr-logo" src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-clr.png" alt="CPENATION" /> </a> </div>
    <!-- /logo -->
    
    <div class="right-nav main-nav pull-right">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url();?>compliance-bundles">BUNDLES</a></li>
        <li><a href="<?php echo base_url();?>subscriptions">SUBSCRIPTIONS</a></li>
        <li><a href="<?php echo base_url();?>individual-courses">CATALOG</a></li>
        <li class="dropdown"><a href="<?php echo base_url();?>faq_con/get_faq/" class="dropdown-toggle">HELP <span class="caret"></span></a>
            <ul class="dropdown-menu">
             <li><a href="<?php echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
             <li><a href="<?php echo base_url();?>faq_con/get_faq/">FAQ</a></li>
             <li><a href="<?php echo base_url();?>faq_con/contactus/">Contact Us</a></li>
            </ul>
            </li> <!-- dropdown -->
		<?php if($this->session->userdata('user_id')){?> 
         <!-- <li><a href="<?php //echo base_url();?>mycourses">ACCOUNT11</a></li>-->
          
          <li class="dropdown"><a href="#" class="dropdown-toggle">Hello, <?php echo $this->session->userdata('user_name'); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                 <li><a href="<?php echo base_url();?>mycredits">My Credits</a></li>
                 <li><a href="<?php echo base_url();?>mycourses">My Courses</a></li>
                 <li><a href="<?php echo base_url();?>mycertificates">My Certificates</a></li>
                 <li><a href="<?php echo base_url();?>myorders">Order History</a></li>
                 <li><a href="<?php echo base_url();?>mybilling">Billing</a></li>
                 <li><a href="<?php echo base_url();?>mysetting">Settings</a></li>
                <li><a href="<?php echo base_url();?>logout">LOG OUT</a></li>
                  </ul>
            </li> <!-- dropdown -->
            <li><a class="cart-mn" href="<?php echo base_url();?>cart"><img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /> <img class="cart-bsk menu_ic_blc" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket-black.png" width="24" alt="cart" /> <span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
          <li class="btn-link" id="hidlogouth"><a href="<?php echo base_url();?>logout" class="btn">LOG OUT</a></li>
        <?php }else{ ?>
          <li><a class="cart-mn" href="<?php echo base_url();?>cart"><img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /> <img class="cart-bsk menu_ic_blc" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket-black.png" width="24" alt="cart" /> <span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
        <li class="btn-link"><a href="<?php echo base_url();?>customer_con/login" class="btn">LOG IN</a></li>
        <?php } ?>
      </ul>
      <div class="hamburger hamburger--spin cust-position">
        <div class="hamburger-box">
          <div class="hamburger-inner"></div>
        </div>
      </div>
    </div>
    <!-- /right-nav --> 
    
  </div>
  <!-- /wrapper -->
  
  <div class="wrapper header-bg">
    <div class="container text-center">
      <div class="header-text-sec">
      <form action="<?php echo base_url();?>compliance-bundles" method="post" id="frontpage_form">
        <h1><span>Af</span>fordable CPE Catered to You.</h1>
        <div class="header-text"> <span class="res-blk-text">I'm looking for </span> <span class="text-line-select">
          <select class="selectpicker" data-width="100%" id="course_type">
            <option selected="" value="compliance-bundles">Compliance Bundles</option>
            <option value="subscriptions">Subscriptions</option>
            <option value="individual-courses">Individual Courses</option>
          </select>
          </span> <span class="res-blk-text">available in </span> <span class="text-line-select right-select">
          <select class="selectpicker" data-width="100%" name="dropdown_states" data-live-search="true">
            <option value="">Select States</option>
			   <?php 
			         foreach($states as $key => $stateval)
					 {
						 if($current_state == $stateval['state_id']){
							 $selected = 'selected="selected"';
						 }else{
							 $selected = '';
						 }
			   ?>
                    <option value="<?php echo $stateval['state_id'];?>" <?php echo $selected;?>><?php echo $stateval['state'];?></option>		
               <?php } ?>
          </select>
          </span> </div>
          <input type="submit" class="btn fad-orange large" name="get_started" value="Get Started">
        </form>
       </div>
       
      <!-- /header-text --> 
      
    </div>
    <div class="head-bg-texture"><img src="<?php echo $this->config->item("cdn_css_image")?>images/head-texture.png" alt="Texture" /></div>
  </div>
  <!-- /header-bg -->
  <div id="cstHead"></div>
  <div class="wrapper bg-pale-grey home-gray" >
    <div class="container conv-course text-center">
      <h3>Convenient Course Bundles Save You Money.</h3>
      <div class="row">
        <div class="col-sm-6 col-md-5 col-lg-4 col-lg-offset-2 col-md-offset-1">
          <div class="cours_bdl_wrp">
            <div class="icon"><img src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-bag.png" alt="bundle-bag" /></div>
            <h4>Compliance Bundles</h4>
            <p>Compliance without the hassle. Our bundles contain all your required credits for any state.</p>
            <a href="<?php echo base_url();?>compliance-bundles" class="btn dull-blue medium">See Bundles</a> </div>
          <!-- /cours_bdl_wrp --> 
        </div>
        <div class="col-sm-6 col-md-5 col-lg-4">
          <div class="cours_bdl_wrp">
            <div class="icon"><img src="<?php echo $this->config->item("cdn_css_image")?>images/unlimited-symbol.png" alt="bundle-bag" /></div>
            <h4>Unlimited Subscriptions</h4>
            <p>Design your own program. Complete access to all our courses for one low price.</p>
            <a href="<?php echo base_url();?>subscriptions" class="btn dull-blue medium">SEE SUBSCRIPTIONS</a> </div>
          <!-- /cours_bdl_wrp --> 
        </div>
      </div>
      <div class="ind-course-link"><span class="icon icon-layers"></span> Looking for individual courses? <a href="<?php echo base_url();?>individual-courses">Browse our full catalog.</a></div>
    </div>
  </div>
  <!-- /wrapper -->
  
  <div class="wrapper col-2-full text-con-left">
    <div class="col-xs-12 col-sm-6 pull-right right-sect bg-grd">
      <div class="textur-bg"><img src="<?php echo $this->config->item("cdn_css_image")?>images/honeycomb-app-bg.png" alt="." /></div>
      <img class="rgt-img" src="<?php echo $this->config->item("cdn_css_image")?>images/app-screens-presentation.png" width="354" alt="App Screen" /> </div>
    <!-- /right-sect -->
    
    <div class="col-xs-12 col-sm-6 pull-left left-sect">
      <div class="text-sec text-center">
        <h4>Content Optimized for All Your Devices</h4>
        <p>Written and video content presented on a truly adaptive platform. Take your courses on your computer, your tablet, or your smartphone; allowing you to complete CPE when it is the most convenient.</p>
        <a class="btn fad-orange medium" href="<?php echo base_url();?>individual-courses">BROWSE CATALOG</a> </div>
      <!-- /text-sec --> 
    </div>
    <!-- /left-sect --> 
  </div>
  <div class="wrapper col-2-full text-con-right">
    <div class="col-xs-12 col-sm-6 pull-left left-sect bg-grd-left">
      <div class="graph-sec">
        <div class="graph-bar"><img src="<?php echo $this->config->item("cdn_css_image")?>images/tracker-bar.png" alt="Track" width="332" /></div>
        <div class="graph-circle"><img src="<?php echo $this->config->item("cdn_css_image")?>images/tracker-circle.png" alt="Track" width="192" /></div>
      </div>
      <!-- /graph-sec --> 
    </div>
    <!-- /left-sect -->
    
    <div class="col-xs-12  col-sm-6 pull-right right-sect">
      <div class="text-sec text-center">
        <h4>Easy Intelligent Tracking</h4>
        <p>Take the guesswork out of compliance. Our  credit tracker ensures you meet your requirements as efficiently as possible.</p>
        <a class="btn fad-orange medium" href="<?php echo base_url();?>customer_con/user_setting">TRACK CREDITS</a> </div>
      <!-- /text-sec --> 
    </div>
    <!-- /right-sect --> 
  </div>
  <div class="container">
    <div class="cert-course text-center">
      <h3>Certified Courses Keep You Compliant</h3>
      <p class="col-lg-offset-2 col-md-offset-1 col-lg-8 col-md-10">

CPE Nation is registered with NASBA as a Quality Assurance Service (QAS) sponsor of continuing professional education.  Our Sponsor Identification Number is 138340.</p>
    </div>
    <ul class="cer-course-logo list-inline">
      <li><img src="<?php echo $this->config->item("cdn_css_image")?>images/certfied-logo-1.png" alt="NASBA" width="154" title="CPE Nation is registered with the National Association of State Boards of Accountancy (NASBA) as a sponsor of continuing professional education on the National Registry of CPE Sponsors. State boards of accountancy have final authority on the acceptance of individual courses for CPE credit. Complaints regarding registered sponsors may be submitted to the National Registry of CPE Sponsors through its website: NASBAregistry.org."/></li>
      <li><img src="<?php echo $this->config->item("cdn_css_image")?>images/certfied-logo-2.png" alt="CPE" width="141" title="CPE Nation is registered with the National Association of State Boards of Accountancy (NASBA) as a sponsor of continuing professional education on the National Registry of CPE Sponsors. State boards of accountancy have final authority on the acceptance of individual courses for CPE credit. Complaints regarding registered sponsors may be submitted to the National Registry of CPE Sponsors through its website: NASBAregistry.org."/></li>
      <li><img src="<?php echo $this->config->item("cdn_css_image")?>images/certfied-logo-3.png" alt="QAS" width="167"  title="CPE Nation is registered with the National Association of State Boards of Accountancy (NASBA) as a sponsor of continuing professional education on the National Registry of CPE Sponsors. State boards of accountancy have final authority on the acceptance of individual courses for CPE credit. Complaints regarding registered sponsors may be submitted to the National Registry of CPE Sponsors through its website: NASBAregistry.org."/></li>
    </ul>
  </div>
  <div class="wrapper cour-prep-wrp">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-sm-offset-6">
          <div class="cours-pre-cont">
            <h3>Courses Prepared by the Country's Top Professionals</h3>
            <p>We scout the top talent to bring you interesting and relevant content. Go beyond compliance, and enjoy learning again.</p>
            <a href="<?php echo base_url();?>faculty_con" class="btn fad-orange medium">MEET OUR FACULTY</a> </div>
          <!-- /cours-pre-cont --> 
        </div>
      </div>
    </div>
  </div>
  <!-- /wrapper  -->
  
  <div class="container per-state">
    <div class="row">
      <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-lg-5 col-md-5 col-sm-6 col-xs-12 pull-right"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/map.png" width="344" alt="Map" /> </div>
      <div class="col-lg-offset-1 col-lg-5 col-md-6 col-sm-5 col-xs-12">
        <h3>Personalized State Requirements</h3>
        <p class="size-18">Get your up-to-date state requirements in an easy to understand format.</p>
        <a href="<?php echo base_url();?>state_con/state_equirement/" class="btn fad-orange medium">SEE REQUIREMENTS</a> </div>
    </div>
  </div>
  <div class="container bottom-links hidden-xs">
    <div class="row">
      <div class="links">
        <?php 
		    $count = 1;
			foreach($states as $key => $stateval)
			{
				
				if($count%10 == 1)
				{
					 echo '<div class="col-sm-2"><ul class="list-unstyled">';
			    }
				//echo '<li><a href="'.base_url().'state_con/state_equirement/'.$stateval['state_id'].'">'.$stateval['state'].' CPE</a></li>';
				echo '<li><a href="'.base_url().'course_con/index/'.$stateval['state_id'].'">'.$stateval['state'].' CPE</a></li>';
				if ($count%10 == 0)
    			{
       				 echo "</ul></div>";
    			}
				$count++;
		    }
			if ($count%10 != 1) echo "</ul></div>";
			 
		?>
      </div>
    </div>
  </div>
  <div class="help-wrp">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 text-left help-que"><strong>Questions?</strong> <a href="<?php echo base_url();?>faq_con/contactus">Get some help</a></div>
        <div class="col-sm-6 text-right help-no">888.656.5334 | <a href="mailto:help@cpenation.com">help@cpenation.com</a></div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-sm-9 col-xs-12 pull-right footer-links">
          <ul class="list-unstyled list-inline">
            <li><a href="<?php echo base_url();?>index_con/get_cms/about">ABOUT</a></li>
            <li><a href="<?php echo base_url();?>subscriptions">SUBSCRIPTIONS</a></li>
            <li><a href="<?php echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
            <li><a href="<?php echo base_url();?>individual-courses">COURSES</a></li>
            <li><a href="<?php echo base_url();?>faq_con/get_faq">FAQ</a></li>
            <li><a href="<?php echo base_url();?>index_con/get_cms/terms">Terms</a></li>
          </ul>
        </div>
        <div class="col-md-4 col-sm-3 col-xs-12 footer-logo"><a href="<?php echo base_url();?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-wht.png" alt="CPENATION" /></a></div>
      </div>
      <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 nasba-number">CPE Nation is a registered sponsor on the National Registry of CPE Sponsors. Our Sponsor Identification Number is 138340.</div></div>
    </div>
  </div>
  <!-- /footer --> 
  
</div>
<!-- /page --> 

<!-- drawer Menu -->
<div class="mobile-nav sidebar-off-canvas main-nav">
  <ul class="nav navbar-nav">
    <li class="active"><a href="<?php echo base_url();?>">Home</a></li>
    <li><a href="<?php echo base_url();?>compliance-bundles">BUNDLES</a></li>
    <li><a href="<?php echo base_url();?>subscriptions">SUBSCRIPTIONS</a></li>
    <li><a href="<?php echo base_url();?>individual-courses">CATALOG</a></li>
    <li><a href="<?php echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
    <li><a href="<?php echo base_url();?>faq_con/contactus">HELP</a></li>
   
   	
    <?php if($this->session->userdata('user_id')){?> 
    
        <li><a href="<?php echo base_url();?>mycourses">ACCOUNT</a></li>
          
            <li><a class="cart-mn" href="<?php echo base_url();?>cart">
            <img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /> 
            <span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
          <li class="btn-link"><a href="<?php echo base_url();?>logout" class="btn">LOG OUT</a></li>
        <?php }else{ ?>
          <li><a class="cart-mn" href="<?php echo base_url();?>cart"><img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /><span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
        <li class="btn-link"><a href="<?php echo base_url();?>customer_con/login" class="btn">LOG IN</a></li>
    <?php } ?>
  </ul>
</div>
<!-- /drawer --> 

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<!--<script src="js/jquery.min.js"></script>--> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/bootstrap.min.js"></script> 
<script>
		$(document).scroll(function () {
			//stick nav to top of page
			var y = $(this).scrollTop();
			//alert(y);
			var cstHead = $('#cstHead').offset().top;
			//alert(cstHead);
			if (y > cstHead) {
				$('.header-top').addClass('sticky');
			} else {
				$('.header-top').removeClass('sticky');
			}
		});
</script> 

<!-- Sticky 
    <script type="text/javascript">
		$(document).ready(function() {
			// grab the initial top offset of the navigation 
		   	var stickyNavTop = $('.header-top').offset().top;
		   	
		   	// our function that decides weather the navigation bar should have "fixed" css position or not.
		   	var stickyNav = function(){
			    var scrollTop = $(window).scrollTop(); // our current vertical position from the top
			         
			    // if we've scrolled more than the navigation, change its position to fixed to stick to top,
			    // otherwise change it back to relative
			    if (scrollTop > stickyNavTop) { 
			        $('.header-top').addClass('sticky');
			    } else {
			        $('.header-top').removeClass('sticky'); 
			    }
			};

			stickyNav();
			// and run it again every time you scroll
			$(window).scroll(function() {
				stickyNav();
			});
		});
		
	
	</script>
 
      close Sticky --> 

<script src="<?php echo $this->config->item("cdn_css_image")?>js/bootstrap-select.js"></script> 
<script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script> 
    <script>
	$('.main-nav ul li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeIn(400);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeOut(230);
});
	</script>

<!-- drawer --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/TweenMax.min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jv-jquery-mobile-menu-min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/script-right.js"></script> 
<!-- /drawer -->
<script>
 $(window).on('load', function () {
	  $('#course_type').change(function(){
			 $('#frontpage_form').attr('action','<?php echo base_url();?>'+$(this).val());
	  });
 });  
</script>
<?php include_once("ga.php") ?>
</body>
</html>