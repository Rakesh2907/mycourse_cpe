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
			echo form_open_multipart('faculty_con/faculty_edit',$attributes);
			
			$fid 	  = $faculty_details[0]['faculty_member_id'];
			$status  = $faculty_details[0]['active'];
			
			$email = set_value('email');				  
			$data_email = array(
						  		 'name'         => 'email',
								  'id'          => 'email',
								  'value'       => $faculty_details[0]['email'],
								  'class'		=> 'form-control',
								  'placeholder' => 'Email'
								 );
			
			$fname = set_value('fname');	
			$data_fname = array(
						  		 'name'         => 'fname',
								  'id'          => 'fname',
								  'value'       => $faculty_details[0]['first_name'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'First Name'
								  );
								  
			$lname = set_value('lname');	
			$data_lname = array(
						  		 'name'         => 'lname',
								  'id'          => 'lname',
								  'value'       => $faculty_details[0]['last_name'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Last Name'
								);
								  
			$firm = set_value('firm');	
			$data_firm = array(
						  		 'name'         => 'firm',
								  'id'          => 'firm',
								  'value'       => $faculty_details[0]['firm_name'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Firm'
								  );
			$fimage = set_value('course_image');				  
			$data_fimage = array(
						  		 'name'         => 'fimage',
								  'id'          => 'fimage',
								  'value'       => $faculty_details[0]['faculty_image'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Faculty Image'
								  );					  
								  
			$phone = set_value('phone');	
			$data_phone = array(
						  		 'name'         => 'phone',
								  'id'          => 'phone',
								  'value'       => $faculty_details[0]['phone'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Phone'
								  );
		
			$data_status = array();
			$data_status[''] = '--select--';
			$data_status['1'] = 'Active';
			$data_status['0'] = 'Deleted';
			$status_data = set_value('status');		
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="fid" id="fid" value="<?php echo $fid;?>" />
            <input type="hidden" id="old_image" name="old_image" value="<?php echo $faculty_details[0]['faculty_image'];?>" />
            <h3 class="form-section">Faculty Info</h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">First Name</label>
                  <?php echo form_input($data_fname); ?>
                   <span class="help-block help-block-error" for="fname" style="color:#F30;"><?php echo form_error('fname'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Last Name</label>
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
                  <label class="control-label">Email</label>
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
                  <label class="control-label">Faculty Image</label>
                   <?php echo form_upload($data_fimage); ?>
                   <?php if($faculty_details[0]['faculty_image'] != 'NULL') { ?><img style="margin-top:10px;" src="<?php echo base_url()?>uploads/faculty/<?php echo $faculty_details[0]['faculty_image'];?>" width="65" height="40" /><?php } ?>
                     <span class="help-block help-block-error" for="password" style="color:#F30;"><?php echo form_error('fimage'); ?></span> 
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row--> 
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                    <?php echo form_dropdown('status',$data_status,$faculty_details[0]['active'],'class="select2_category form-control" data-placeholder="Select status"');?>
                    <span class="help-block help-block-error" for="lawyer_type" style="color:#F30;"><?php echo form_error('lawyer_type'); ?></span>
                </div>
              </div>
          </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>customer_con"><button type="button" class="btn default">Cancel</button></a>
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