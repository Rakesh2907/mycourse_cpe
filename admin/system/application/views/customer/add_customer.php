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
			echo form_open('customer_con/add_customer',$attributes);
			
			$data_gender = array();
			$data_gender[''] = '--select--';
			$data_gender['male'] = 'Male';
			$data_gender['female'] = 'Female';
			$gender_data = set_value('gender');
			
			
			$data_profession_type = array();
			$data_profession_type[''] = '--select--';
			$data_profession_type['Individual'] = 'Individual';
			$data_profession_type['Member Of A Law Firm'] = 'Member Of A Law Firm';
			$profession_data = set_value('profession_type');
			
			
			$data_lawyer_type = array();
			$data_lawyer_type[''] = '--select--';
			$data_lawyer_type['1'] = 'Newly Admitted';
			$data_lawyer_type['2'] = 'Veteran';
			$lawyer_data = set_value('lawyer_type');
			
			$email = set_value('email');				  
			$data_email = array(
						  		 'name'         => 'email',
								  'id'          => 'email',
								  'value'       => $email,
								  'class'		=> 'form-control',
								  'type'		=> 'email',
								  'required'		=> 'required',
								  'placeholder' => 'Email'
								 );
			
		    $cemail = set_value('cemail');				  
			$data_cemail = array(
						  		  'name'        => 'cemail',
								  'id'          => 'cemail',
								  'value'       => $cemail,
								  'class'		=> 'form-control',
								  'type'		=> 'email',
								  'required'		=> 'required',
								  'placeholder'		=> 'Confirm Email'
								 ); 
			
			$password = set_value('password');				  
			$data_password = array(
						  		 'name'         => 'password',
								  'id'          => 'password',
								  'value'       => $password,
								  'class'		=> 'form-control',
								  'type'		=> 'password',
								  'required'		=> 'required',
								  'placeholder'		=> 'Password'
								  );
			
			$cpassword = set_value('cpassword');				  
			$data_cpassword = array(
						  		 'name'         => 'cpassword',
								  'id'          => 'cpassword',
								  'value'       => $cpassword,
								  'type'		=> 'password',
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder'		=> 'Confirn Password'
								  );
								  
			
			$company = set_value('company');	
			$data_company = array(
						  		 'name'         => 'company',
								  'id'          => 'company',
								  'value'       => $company,
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder'		=> 'Company Name'
								  );
								  
			$fname = set_value('fname');	
			$data_fname = array(
						  		 'name'         => 'fname',
								  'id'          => 'fname',
								  'value'       => $fname,
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder'		=> 'First Name'
								  );
								  
			$lname = set_value('lname');	
			$data_lname = array(
						  		 'name'         => 'lname',
								  'id'          => 'lname',
								  'value'       => $lname,
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder'		=> 'Last Name'
								);
								  
			$add1 = set_value('add1');	
			$data_add1 = array(
						  		 'name'         => 'add1',
								  'id'          => 'add1',
								  'value'       => $add1,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Address1'
								  );
								  
			$add2 = set_value('add2');
			$data_add2 = array(
						  		 'name'         => 'add2',
								  'id'          => 'add2',
								  'value'       => $add2,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Address2'
								  );
								  
			$city = set_value('city');	
			$data_city = array(
						  		 'name'         => 'city',
								  'id'          => 'city',
								  'value'       => $city,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'City'
							  );
			
			$zipcode = set_value('zipcode');	
			$data_zipcode = array(
						  		 'name'         => 'zipcode',
								  'id'          => 'zipcode',
								  'value'       => $zipcode,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Zip code'
								  );
								  
			$data_firmsize = array();
			$data_firmsize[''] = "----Select----" ;
			$data_firmsize['1'] = '1';
			$data_firmsize['2-10'] = 'Between 2-10';
			$data_firmsize['11-50'] = 'Between 11-50';
			$data_firmsize['51-250'] = 'Between 51-250';
			$data_firmsize['251-500'] = 'Between 251-500';
			$data_firmsize['501-1000'] = 'Between 501-1000';
			$data_firmsize['1000+'] = '1000+';
			
							  
			$data_state = array();
			foreach($states as $state)
			{
				$state_abbr = $state['state_id'];
				$data_state[$state_abbr] = $state['state'];
			}		
			$state_data = set_value('course_state[]');	
			
			$data_preferredcourse = array();
			$data_preferredcourse['Self study text'] = 'Self study text';
			$data_preferredcourse['Self study video'] = 'Self study video';	
			$data_preferredcourse['Webinar'] = 'Webinar';	
			$data_preferredcourse['Live Lecture'] = 'Live Lecture';  
			
			$preferred_course_data = set_value('preferred_course[]');
			
			$data_interest_area = array();
			$data_interest_area['Accounting'] = 'Accounting';
			$data_interest_area['Audits'] = 'Audits';
			$data_interest_area['Business Law'] = 'Business Law';
			$data_interest_area['Business Management'] = 'Business Management';
			$data_interest_area['Finance'] = 'Finance';
			$data_interest_area['Management'] = 'Management';
			$data_interest_area['Specialized Knowledge & applications'] = 'Specialized Knowledge & applications';
			$data_interest_area['Taxes'] = 'Taxes';
			
			$interest_area_data = set_value('interest_area[]');
			
			$data_active = array();
			$data_active['1'] = 'Active';
			$data_active['0'] = 'In-Active';
			
			$active_data = set_value('active_check');

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
            <?php }
			     if(isset($err_msg) && $err_msg!=''){?>
                 <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    <?php echo $err_msg;?>
                </div>
                	  
			<?php 	 } ?>
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
                  <label class="control-label">Password<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_password); ?>
                     <span class="help-block help-block-error" for="password" style="color:#F30;"><?php echo form_error('password'); ?></span> 
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <!--/span-->
              <div class="col-md-6">
                 <div class="form-group">
					 <label class="control-label">States<span class="required" aria-required="true"> *</span></label>
                      <?php echo form_multiselect('course_state[]',$data_state,$state_data,'id="select2_sample2" class="form-control select2"'); ?>
                      <span class="help-block help-block-error" for="course_state" style="color:#F30;"><?php echo form_error('course_state[]'); ?></span> 
				 </div>
              </div>
             <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Certifications</label> <br />
                      <input type="checkbox" name="certifications[]" value="CPA" />CPA&nbsp; 
                      <input type="checkbox" name="certifications[]" value="CFP" />CFP&nbsp;
                      <input type="checkbox" name="certifications[]" value="EA" />EA&nbsp;
                      <input type="checkbox" name="certifications[]" value="RTRP" />RTRP&nbsp;
                    </div>
             </div>
              <!--/span--> 
            </div>
            <!--/row--> 
            <h3 class="form-section">Preferances</h3>
            <div class="row">
                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Firm Size</label>
                        <?php echo form_dropdown('firm_size',$data_firmsize,'','class="form-control select2"'); ?>
                        <span class="help-block help-block-error" for="password" style="color:#F30;"><?php echo form_error('firm_size'); ?></span>
                    </div>
                </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                     	<label class="control-label">Preferred Courses</label>
                        <?php echo form_multiselect('preferred_course[]',$data_preferredcourse,$preferred_course_data,'id="select2_sample1" class="form-control select2"'); ?>
                    </div>
                  </div>  
            </div>
             <div class="row">
                 <div class="col-md-6">
                     <div class="form-group">
                         <label class="control-label">Area of interest</label>
                          <?php echo form_multiselect('interest_area[]',$data_interest_area,$interest_area_data,'class="form-control select2"'); ?>
                     </div>
                 </div>
                 <div class="col-md-6">
                 	 <div class="form-group">
                  			<label class="control-label">Status</label>
                  			 <?php echo form_dropdown('active_check',$data_active,'','class="form-control select2"'); ?>
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