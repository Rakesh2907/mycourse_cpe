<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo $page_title;?></title>
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
<link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

<!-- Select Box -->
<link href="<?php echo $this->config->item("cdn_css_image")?>css/bootstrap-select.css" rel="stylesheet">
<!-- drawer -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("cdn_css_image")?>css/jv-jquery-mobile-menu.css">
<!-- /scroller -->
<link href="<?php echo $this->config->item("cdn_css_image")?>css/jquery.mCustomScrollbar.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.min.js"></script>     
<script type="text/javascript">
   var base_url = '<?php echo base_url()?>';
   var my_selecte_state = new Array();
</script>    
</head>
<body>
<div class="page">
<div class="wrapper header-top inner-nav">
  <div class="container">
    <div class="logo pull-left"> <a href="<?php echo base_url()?>"> <img class="white-logo" src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-wht.png" alt="CPENATION" /> <img class="clr-logo" src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-clr.png" alt="CPENATION" /> </a> </div>
    <!-- /logo -->
    
    <a href="<?php echo base_url();?>cart"><div class="cart-mobile"><span class="cart-number"><?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?></span></div></a>
    
    <div class="right-nav main-nav pull-right">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url();?>compliance-bundles">BUNDLES</a></li>
     	<li><a href="<?php echo base_url();?>subscriptions">SUBSCRIPTIONS</a></li>
        <li><a href="<?php echo base_url();?>individual-courses">CATALOG</a></li>
      <!--  <li><a href="<?php //echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
        
        <li><a href="<?php //echo base_url();?>faq_con/get_faq">HELP</a></li>-->
        <li class="dropdown"><a href="<?php echo base_url();?>faq_con/get_faq/" class="dropdown-toggle">HELP <span class="caret"></span></a>
            <ul class="dropdown-menu">
             <li><a href="<?php echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
             <li><a href="<?php echo base_url();?>faq_con/get_faq/">FAQ</a></li>
             <li><a href="<?php echo base_url();?>faq_con/contactus/">Contact Us</a></li>
            </ul>
            </li> <!-- dropdown -->
            
		<?php if($this->session->userdata('user_id')){?> 
          
          <li class="dropdown"><a href="#" class="dropdown-toggle">Hello, <?php echo $this->session->userdata('user_name'); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                 <li><a href="<?php echo base_url();?>mycourses">My Courses</a></li>
                 <li><a href="<?php echo base_url();?>mycertificates">My Certificates</a></li>
                 <li><a href="<?php echo base_url();?>mycredits">My Credits</a></li>
                 <li><a href="<?php echo base_url();?>myorders">Order History</a></li>
                 <li><a href="<?php echo base_url();?>mybilling">Billing</a></li>
                 <li><a href="<?php echo base_url();?>mysetting">Settings</a></li>
                 <li><a href="<?php echo base_url();?>logout">LOG OUT</a></li>
                  </ul>
            </li> <!-- dropdown -->
            <li><a class="cart-mn" href="<?php echo base_url();?>cart"><img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /> <img class="cart-bsk menu_ic_blc" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket-black.png" width="24" alt="cart" /> <span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
          <li class="btn-link" id="hidlogout"><a href="<?php echo base_url();?>logout" class="btn">LOG OUT</a></li>
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
  <!-- /container --> 
</div>
<!-- /inner-nav -->


