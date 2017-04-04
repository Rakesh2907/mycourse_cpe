<div class="section-full bd-min-hgt">
<div class="regist-wrp">
<div class="col-sm-6 col-xs-12 left-sec">

<div class="reg-form-outer login-form">
<div class="head-sec">
<h3>Login to Your Account</h3>
<div class="sub-head">Don't have an account? <a href="<?php echo $this->config->item('base_url');?>customer_con/registration">Create one</a></div>
</div>
<style>.required{
	color: red;
	}</style>
<!--<form class="cust_Form inline-label">-->
<?php  
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/login/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
             
             <?php if($error_text !=''){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                   <?php echo $error_text; ?>
                </div>
            <?php } ?>
  <div class="form-group"><label class="control-label">Email<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><input type="email" class="form-control" name="username" id="username" required value="<?php echo $username ?>"></div></div>

<div class="form-group pass-fld"><label class="control-label">Password<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><input type="password" class="form-control" name="password" id="password" required></div></div>

<div class="form-group text-right for-pass"><a data-target="#forget_Pass" data-toggle="modal" href="#">forgot your password?</a></div>

<div class="btn-sec">
<!--<button class="btn fad-orange md-large next-step">LOG IN</button>-->
 <input  class="btn fad-orange md-large next-step" type="submit" name="submit" value="login" />
</div>
 <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>

</div> <!-- reg-form-outer -->

</div> <!-- /left-sec -->

<div class="col-sm-6 col-xs-12 acc-right-sec grd-bg hidden-xs">
<div class="reg-text-cont">
<h3>Why you'll love CPE Nation:</h3>

<ul class="list-unstyled">
<li>Top Quality Content</li>
<li>Multiple Course Formats</li>
<li>Ultra Modern Platform</li>
<li>User-Friendly Credit Tracker</li>
</ul>
</div>

<div class="gr-texture"><img alt="Texture" src="<?php echo $this->config->item("cdn_css_image")?>images/gr-texture.png" width="601" /></div> <!-- /gr-texture -->
</div>

</div> <!-- /regist-wrp -->
</div> <!-- section full -->


 <!-- /footer -->


</div> <!-- /page -->



<!-- drawer Menu -->
<div class="mobile-nav sidebar-off-canvas main-nav">
<ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">BUNDLES</a></li>
            <li><a href="#">SUBSCRIPTIONS</a></li>
            <li><a href="#">CATALOG</a></li>
            <li><a href="#">HELP</a></li>
            <li><a href="#">Account</a></li>
            <li class="btn-link"><a href="#" class="btn"><img class="cart-bsk" src="images/cart-basket.png" width="24" alt="cart" />Cart (1)</a></li>
            
          </ul> 
</div>
<!-- /drawer -->

<!-- Modal -->
<div id="forget_Pass" class="modal fade cst-flat-popup" role="dialog">
  <div class="modal-dialog mdl-cs-wd leave_com f-Pass">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center">Password Reset</h4>
      </div>
      <div class="modal-body">
      <p class="intr-txt text-center">Please enter your email below, and we will send you instructions for resetting your password.</p>
        <!-- Form -->

     	    	<?php $attributes = array('class' => 'cust_Form inline-label', 'id' => 'myforgotform');
					echo form_open('customer_con/forgotpassword/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
  <div class="form-group"><label class="control-label">Email</label>
<div class="inline-fld"><input type="email" class="form-control" name="forgotmail" id="forgotmail" required ></div></div>

<div class="btn-sec text-center">
<!--<button class="btn dull-blue md-large">RESET PASSWORD</button>-->
 <input  type="submit" name="submit" value="RESET PASSWORD"   class="btn dull-blue md-large"/>
</div>
 <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>
        <!-- /Form -->
      </div>
    </div>

  </div>
</div> <!-- Modal close -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
        
        <!-- Sticky -->
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
 
     <!-- close Sticky -->
        
        
     
        <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>
        
        
      
    <!-- /drawer -->
    
    <!-- accordian -->
    <script>
	$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-up").removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-down").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
});
	</script>
    <!-- accordian close -->
    
    <!-- /scroller -->
      
       <script>
		(function($){
			$(window).load(function(){
				
			
				$(".max-scroll .bootstrap-select .dropdown-menu.inner, .smlr_Course .bdl_sc_Grd").mCustomScrollbar({
					theme:"dark-2"
				});
											
			});
		})(jQuery);
	</script>
    <!-- /scroller close -->
    
    <!-- filter show hide -->
        <script>
    function toggler(divId) {
    $("#" + divId).toggle();
}
</script>
<!-- /filter show hide -->

<!-- password to text -->
<script>
$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});

 jQuery(function(){
    jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    jQuery(window).resize(function(){
        jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    });
});
</script>
