<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i><?php echo $pagetitle;?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
       <?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('faculty_con/add_faculty_details',$attributes);
			
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
			
			$fname = set_value('fname');	
			$data_fname = array(
						  		 'name'         => 'fname',
								  'id'          => 'fname',
								  'value'       => $fname,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'First Name',
								  'required'     =>'required'
								  );
								  
			$lname = set_value('lname');	
			$data_lname = array(
						  		 'name'         => 'lname',
								  'id'          => 'lname',
								  'value'       => $lname,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Last Name',
								  'required'     =>'required'
								);
								  
			$firm = set_value('firm');	
			$data_firm = array(
						  		 'name'         => 'firm',
								  'id'          => 'firm',
								  'value'       => $firm,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Firm'
								  );
			$fimage = set_value('course_image');				  
			$data_fimage = array(
						  		 'name'         => 'fimage',
								  'id'          => 'fimage',
								  'value'       => $fimage,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Faculty Image',
								  'required'     =>'required'
								  );					  
								  
			$phone = set_value('phone');	
			$data_phone = array(
						  		 'name'         => 'phone',
								  'id'          => 'phone',
								  'value'       => $phone,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Phone'
								  );
		
		    $biography = set_value('biography');
		    $data_biography = array(
						  		 'name'         => 'biography',
								  'id'          => 'biography',
								  //'value'       => $chptdesc,
								  'rows'        => '5',
      							  'cols'        => '10',
								   'class'		=> 'form-control',
								   'required'     =>'required',
								  'placeholder'		=> 'Biography'
								  );
								  
			
			$practice_area = set_value('practice_area');	
			$data_practice_area = array(
						  		 'name'         => 'practice_area',
								  'id'          => 'practice_area',
								  'value'       => $practice_area,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Practice Area',
								  'required'     =>'required'
								);
								
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
            <h3 class="form-section">Personal Info</h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
             <?php if(isset($err_msg) && $err_msg!=''){ ?> 
             <div class="alert alert-danger">
              <?php echo $err_msg;?>
            </div>
        <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">First Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_fname); ?>
                   <span class="help-block help-block-error" for="fname" style="color:#F30;"><?php echo form_error('fname'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Last Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_lname); ?>
                  <span class="help-block help-block-error" for="lname" style="color:#F30;"><?php echo form_error('lname'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_input($data_email); ?>
                    <span class="help-block help-block-error" for="email" style="color:#F30;"><?php echo form_error('email'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Phone Number</label>
                     <?php echo form_input($data_phone); ?>
                     <span class="help-block help-block-error" for="password" style="color:#F30;"><?php echo form_error('phone'); ?></span> 
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name</label>
                    <?php echo form_input($data_firm); ?>
                    <span class="help-block help-block-error" for="email" style="color:#F30;"><?php echo form_error('firm'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Faculty Image<span class="required" aria-required="true"> * (Upload Max Size:-2mb and Dimension 166 X 166)</span></label>
                   <?php echo form_upload($data_fimage); ?>
                     <span class="help-block help-block-error" for="password" style="color:#F30;"><?php echo form_error('fimage'); ?></span> 
                </div>
               
              </div>
              <!--/span--> 
            </div>
            <!--/row--> 
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Faculty Biography</label>
                    <?php //echo form_textarea($data_biography); ?>
                    <?php echo $this->ckeditor->editor("biography"); ?>
                    <span class="help-block help-block-error" for="biography" style="color:#F30;"><?php echo form_error('biography'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Faculty Practice Area<span class="required" aria-required="true"> *</span></label>
                   <?php echo form_input($data_practice_area); ?>
                     <span class="help-block help-block-error" for="practice_area" style="color:#F30;"><?php echo form_error('practice_area'); ?></span> 
                </div>
              </div>
              <!--/span-->  
            </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>faculty_con"><button type="button" class="btn default">Cancel</button></a>
                  </div>
              <div class="col-md-6"> </div>
            </div>
          </div>
          <?php	
			echo form_fieldset_close(); 
			echo form_close();
		  ?>
        <!-- END FORM--> 
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT--> 