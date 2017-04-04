<div class="section-full small-inner-head rem-mrg">
<div class="container">
<div class="row">
<div class="col-md-12 col-lg-11 col-lg-offset-1">
<h4>Faculty</h4>
</div>
</div>
</div>
</div>

<div class="container bd-min-hgt join-fclt-outer">
<div class="row">

<div class="col-md-8 col-md-offset-2">

<div class="jn_fac_wrp">
<div class="head-sec text-center">
<h3>Join Our Faculty</h3>
<div class="sub-head">Please complete the form below, and we will be in contact with you shortly.</div>
</div>

<!--<form class="cust_Form inline-label">-->
   <?php  
       
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('faculty_con/join_faculty/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
  
  <?php if($msg !=''){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                   <?php echo $msg; ?>
                </div>
            <?php } ?>           
<style>.required{
	color: red;
	}</style>
 <input type="hidden" class="css-checkbox" id="mysubmit" name="mysubmit" value="joinus">            
<div class="form-group"><label class="control-label">Full Name<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><input type="text" class="form-control" name="fullname" id="fullname" required ><span class="help-block help-block-error" for="coupon_code" style="color:#F30;"><?php echo form_error('fullname'); ?></span></div></div> <!-- /form-group -->

<div class="form-group"><label class="control-label">Email  Address<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><input type="email" class="form-control" name="emailid" id="emailid"  required><span class="help-block help-block-error" for="coupon_code" style="color:#F30;"><?php echo form_error('emailid'); ?></span></div></div> <!-- /form-group -->

<div class="row col-2-fld">
<div class="col-sm-6">
<div class="form-group"><label class="control-label">Phone Number<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><input type="text" class="form-control" name="phoneno" id="phoneno"  required><span class="help-block help-block-error" for="coupon_code" style="color:#F30;"><?php echo form_error('phoneno'); ?></span></div></div> <!-- /form-group -->
</div>
<div class="col-sm-6">
<div class="form-group sml-label"><label class="control-label">Firm</label>
<div class="inline-fld"><input type="text" class="form-control" name="firm" id="firm" ></div></div> <!-- /form-group -->
</div>
</div> <!-- /row -->

<div class="form-group"><label class="control-label">LinkedIn Profile</label>
<div class="inline-fld"><input type="url" class="form-control" name="linkldn" id="linkldn"></div></div> <!-- /form-group -->

<div class="form-group text-area-fld"><label class="control-label">Short Bio<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><textarea class="form-control" name="biodata" id="biodata"  required></textarea><span class="help-block help-block-error" for="coupon_code" style="color:#F30;"><?php echo form_error('biodata'); ?></span></div></div> <!-- /form-group -->

<div class="btn-sec text-center">

      <input class="btn fad-orange medium" type="submit" value="SUBMIT" />
</div>
  <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>
<!--</form>--> <!-- /cust_Form -->

</div> <!-- /jn_fac_wrp -->
</div>

</div>
</div> <!-- /bd-min-hgt -->