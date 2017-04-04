<?php 

$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open(base_url().'faq_con/contactus',$attributes);
			
			$name = set_value('name');	
			$data_name = array(
						  		 'name'         => 'name',
								  'id'          => 'name',
								  'value'       => $name,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'First Name',
								   'required'     =>'required'
									);
			
			$email = set_value('email');				  
			$data_email = array(
						  		 'name'         => 'email',
								  'id'          => 'email',
								  'type'        =>'email',
								  'value'       => $email,
								  'class'		=> 'form-control',
								  'placeholder' => 'Email',
								  'required'     =>'required'
								 );
			$subject = set_value('subject');	
			$data_subject = array(
						  		 'name'         => 'subject',
								  'id'          => 'subject',
								  'value'       => $subject,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'subject',
								   'required'     =>'required'
									);
			$message = set_value('message');				  
			$data_message = array(
						  		  'name'        => 'message',
								  'id'          => 'message',
								  'value'       => $message,
								  'rows'		=> '2',
								  'cols'		=> '10',
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Message',
								   'required'     =>'required'
								 ); 											 	  
			
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => 'SUBMIT',
								'class' => 'btn fad-orange medium'
			
			);
												  
								  
?>

<div class="bd-min-hgt">

<div class="section-full small-inner-head rem-mrg">
<div class="container">
<div class="row">
<div class="col-md-12 col-lg-12">
<h4>Customer Support</h4>
</div>
</div>
</div>
</div>

<div class="container side-bar-brd contact_wrp">
<div class="row acc_details_wrp">
 <div class="col-lg-2 col-md-2">
 <div class="sidebar-links">
 
 <div class="drop-nav-outer">
 <button data-toggle="dropdown" id="inp_impact" class="dropdown-toggle btn drp-btn visible-xs visible-sm">
 <span id="text">Contact Us</span><span class="caret"></span></button>
 
 <ul id="drop-nav" class="dropdown-menu list-unstyled my_ac_nav">
 <li><a href="<?php echo base_url();?>faq_con/get_faq">FAQ</a></li>
 <li <?php if($navigation == 'contact'){ ?>class="active" <?php }?>><a href="javascript:void(0);">Contact Us</a></li>
 </ul>
 </div> <!-- /drop-nav -->
 </div>
 </div> <!-- /col -->
 

 
 <div class="col-lg-7 col-lg-offset-1 col-md-9 col-md-offset-1 page-content contact_wrp">
 
<div class="cont-form">
<div class="head-sec">
<h2>Get In Touch</h2>
<p>Please fill out the inquiry form below, and one of our representatives will be in touch with you promptly.</p>
</div>

<div class="row">
	<?php if(validation_errors()){?>
                        <div class="alert alert-danger display-hide" style="display: block;">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                    <?php } ?>
                      <?php if($suc_msg !=''){ ?>
    <div class="alert alert-success">
          <?php echo $suc_msg;?>
        </div>
        <?php }  ?>
<div class="col-md-12 col-md-offset-0 col-sm-10 col-sm-offset-1 hidefrm">

<div class="form-group"><label class="control-label">Name<span class="required" aria-required="true">*</span></label>
<div class="inline-fld">
<?php echo form_input($data_name); ?>
<span class="help-block help-block-error" for="name" style="color:#F30;">
<?php echo form_error('name'); ?></span>
</div></div> <!-- /form-group -->

<div class="form-group"><label class="control-label">Email  Address<span class="required" aria-required="true">*</span></label>
<div class="inline-fld">
<?php echo form_input($data_email); ?>
                           <span class="help-block help-block-error" for="email" style="color:#F30;"><?php echo form_error('email'); ?></span>

</div></div> <!-- /form-group -->

<div class="form-group"><label class="control-label">Subject<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><?php echo form_input($data_subject); ?>
                           <span class="help-block help-block-error" for="subject" style="color:#F30;"><?php echo form_error('subject'); ?></span>
                           </div></div> <!-- /form-group -->

<div class="form-group text-area-fld"><label class="control-label">Message<span class="required" aria-required="true">*</span></label>
<div class="inline-fld"><?php echo form_textarea($data_message); ?>
                  <span class="help-block help-block-error" for="message" style="color:#F30;"><?php echo form_error('message'); ?></span></div></div> <!-- /form-group -->

<div class="btn-sec">
<!--<a href="#" class="btn fad-orange medium">SUBMIT</a>-->
<?php echo form_submit($arr_submit)?>   
</div>

 <?php	
			echo form_fieldset_close(); 
			echo form_close();
		  ?>
<div class="call-us"><span class="or">or</span> Call us at <strong>1 (888) 656-5334</strong></div>
</div> <!-- col -->
</div> <!-- /row -->


</div> <!-- /cont-form -->
 
 </div>
 
</div><!-- /row -->
</div> <!-- container -->

</div> <!-- /bd-min-hgt -->

<script>
$(document).ready(function(e) {
    
	var hideform = '<?php echo $suc_msg; ?>';
	
	if(hideform !='')
	{
		$(".hidefrm").hide();
	}
});

 jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
</script>