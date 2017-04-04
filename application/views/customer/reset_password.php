<?php //echo $error_text;die;  ?>
<style> .error{ font-size:12px !important;
	 	color:red; } </style>   
<div class="section-full bd-min-hgt">
<div class="regist-wrp">
<div class="col-sm-6 col-xs-12 left-sec">

<div class="reg-form-outer login-form">
<div class="head-sec">
<h3>Reset Password</h3>

</div>

<!--<form class="cust_Form inline-label">-->
<?php  
            if($resetlink == '')
			{
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform1');
			echo form_open('customer_con/resetpassword/',$attributes);
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
  <input type="hidden" class="form-control" name="custid" id="custid" value="<?php echo $custid; ?>">   
  <input type="hidden" class="form-control" name="email" id="email" value="<?php echo $email; ?>">           
  <div class="form-group"><label class="control-label">Password</label>
<div class="inline-fld"><input type="password" class="form-control" name="password" id="password" required></div></div>

<div class="form-group pass-fld"><label class="control-label">Confirm Password</label>
<div class="inline-fld"><input type="password" class="form-control" name="confpassword" id="confpassword" required></div></div>



<div class="btn-sec">
<!--<button class="btn fad-orange md-large next-step">LOG IN</button>-->
 <input  class="btn fad-orange md-large next-step" type="submit" name="submit" value="reset" />
</div>
 <?php	
			//echo form_fieldset_close(); 
			echo form_close();
			}else{
		  ?>
            <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                   <?php $error_text1='This Reset password link expired now........'; echo $error_text1; ?>
                </div>
          <?php }?>

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
<div class="inline-fld"><input type="email" class="form-control" name="forgotmail" id="forgotmail" required></div></div>

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
<script src="<?php echo $this->config->item("cdn_css_image")?>global/plugins/jquery-validation/js/jquery.validate.min.js"></script> 
<script type="text/javascript">
	$(document).ready(function() 
    {	
    	$('#myform1').validate(
        {
            onkeyup: false,
			
            rules: {
                password: {required: true,minlength: 6, maxlength: 16},   
				confpassword: {required: true, equalTo: "#password",minlength: 6, maxlength: 16}              
				               
		    },
            messages: 
			{
                password: {required: "Please Enter Password."}, 
				confpassword: {
					required: "Please Enter Confirm Password.",					
					equalTo: "Please enter the same password as above"
				
				}               
            }
        });       
    });
	
jQuery(function(){
    jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    jQuery(window).resize(function(){
        jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    });
});
</script>