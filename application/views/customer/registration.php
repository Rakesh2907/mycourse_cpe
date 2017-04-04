<style>.required{
	color: red;
	}</style>
 <style> .error{ font-size:12px !important;
	 	color:red; } </style>   
<div class="section-full bd-min-hgt">
 <?php
//echo "<pre>"; print_r($data_register);die;
 $first_name=$last_name=$email_id=$err='';
 if(sizeof($data_register) > 0)
 {
 	$first_name=$data_register['first_name'];
	$last_name=$data_register['last_name'];
	$email_id=$data_register['email'];
	$err=$data_register['data_err'];
 }
  if($err !=''){?>
                 <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    <?php echo $err;?>
                </div>
                	  
			<?php 	 } ?>
  <div class="regist-wrp">
    <div class="col-sm-6 col-xs-12 left-sec">
      <div class="reg-form-outer">
        <div class="head-sec">
          <h3>Create an account</h3>
          <div class="sub-head">Have an account? <a href="<?php echo $this->config->item('base_url');?>customer_con/login">Log In</a></div>
        </div>
        <!--<form class="cust_Form inline-label">-->
        <?php  
       
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/registration/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
              <input type="hidden" class="css-checkbox" id="ajax_login" name="ajax_login" value="0">
               <input type="hidden" class="css-checkbox" id="mysubmit" name="mysubmit" value="registration">
               <input type="hidden" name="selected_states" value="" id="selected_states"/>
          <div class="form-group">
            <label class="control-label">First Name<span class="required" aria-required="true">*</span></label>
            <div class="inline-fld">
              <input type="text" name="fname" id="fname" required="required" class="form-control" value="<?php echo  $first_name;?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Last Name<span class="required" aria-required="true">*</span></label>
            <div class="inline-fld">
              <input type="text" class="form-control" name="lname" id="lname" required="required" value="<?php echo  $last_name;?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Email<span class="required" aria-required="true">*</span></label>
            <div class="inline-fld">
              <input type="email" class="form-control" name="email" id="email"  value="<?php echo  $email_id;?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Create Password<span class="required" aria-required="true">*</span></label>
            <div class="inline-fld">
              <div class="pass-fld">
                <input type="password" class="form-control pwd" name="password" id="password" required="required"  maxlength="17">
                <a href="javascript:void(0)" class="reveal" id="show_hide">Show</a> </div>
            </div>
          </div>
          <div class="form-group state_sear">
            <label class="control-label"><span class="visible-sm">Credit States</span></label>
            <div class="inline-fld">
             <ul class="list-inline state_tags" id="selction-ajax"></ul>
              <!--<ul class="list-inline state_tags">
                <li><span>New York <a href="#" class="close icon-cross"></a></span></li>
              </ul>-->
            </div>
          </div>
          <div class="form-group">
            <label class="control-label hidden-sm">Credit States<span class="required" aria-required="true">*</span></label>
            <div class="inline-fld">
              <div class="srch-sec">
                <button type="submit" class="btn"><span class="icon-search"></span></button>
               <!-- <input type="text" placeholder="Search for States" class="form-control">-->
                <input type="text" placeholder="Search for States" class="form-control" name="course_state" id="autocomplete-ajax" autocomplete="off" required="required">
                 <span class="help-block help-block-error" for="selected_states" style="color:#F30;"><?php echo form_error('selected_states'); ?></span>
              </div>
            </div>
          </div>
          <div class="form-group certi">
            <label class="control-label">Certifications</label>
            <div class="inline-fld">
              <ul class="list-unstyled list-inline check_stl">
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG1" name="certifications[]" value="CPA">

                <label class="css-label" for="checkboxG1">CPA</label>
              </li>
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG2" name="certifications[]" value="CFP">
                <label class="css-label" for="checkboxG2">CFP</label>
              </li>
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG3" name="certifications[]" value="EA">
                <label class="css-label" for="checkboxG3">EA</label>
              </li>
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG4" name="certifications[]" value="RTRP">
                <label class="css-label" for="checkboxG4">RTRP</label>
              </li>
            </ul>
            </div>
          </div>
          <div class="btn-sec">
           <!-- <button class="btn fad-orange md-large next-step">CREATE ACCOUNT</button>-->
            <input class="btn fad-orange md-large next-step" type="submit" value="Create Account" />
          </div>
 <!--       </form>-->
  <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>
      </div>
      <!-- reg-form-outer --> 
      
    </div>
    <!-- /left-sec -->
    
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
      <div class="gr-texture"><img alt="Texture" src="<?php echo $this->config->item("cdn_css_image")?>images/gr-texture.png" width="601" /></div>
      <!-- /gr-texture --> 
    </div>
  </div>
  <!-- /regist-wrp --> 
</div>
<!-- section full -->

</div>
<!-- /page --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>global/plugins/jquery-validation/js/jquery.validate.min.js"></script> 
<script type="text/javascript">
	$(document).ready(function() 
    {	
    	$('#myform').validate(
        {
            onkeyup: false,
			 ignore: "",
            rules: {
                email: {required: true, email: true},                
                fname: {required: true},                
                lname: {required: true},                
                password: {required: true,minlength: 6, maxlength: 16},   
				//selected_states: {required: true}, 
				               
		    },
            messages: 
			{
                email: {required: "Please Enter Email Address."},               
                fname: {required: "Please Enter First Name."},               
                lname: {required: "Please Enter Last Name."},               
                password: {required: "Please Enter password."} ,    
				//course_state: {required: "Please Select Atleast One State."},            
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