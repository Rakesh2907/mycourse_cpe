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
			echo form_open('state_con/state_edit',$attributes);
			
			$data_status = array();
			$data_status[''] = '--select--';
			$data_status['Active'] = 'Active';
			$data_status['Deleted'] = 'Deleted';
			$status_data = set_value('status');			
			
			$state_phone = set_value('state_phone');				  
			$data_state_phone = array(
						  		 'name'         => 'state_phone',
								  'id'          => 'state_phone',
								  'value'       => $state_details[0]['state_phone'],
								  'class'		=> 'form-control',
								  'required'     =>'required',
								  'placeholder' => 'State phone'
								 );
			
			$state_fax = set_value('state_fax');	
			$data_state_fax = array(
						  		 'name'         => 'state_fax',
								  'id'          => 'state_fax',
								  'value'       => $state_details[0]['state_fax'],
								  'class'		=> 'form-control',
								   'required'     =>'required',
								  'placeholder'		=> 'State Fax'
								  );
			
			$state_web = set_value('state_web');	
			$data_state_web = array(
						  		 'name'         => 'state_web',
								  'id'          => 'state_web',
								  'type'        =>'url',
								  'value'       => $state_details[0]['state_website'],
								  'class'		=> 'form-control',
								   'required'     =>'required',
								  'placeholder'		=> 'State Website',
								   
								  );
								  
			$statedesc = set_value('statedesc');
			$data_statedesc = array(
						  		 'name'         => 'statedesc',
								  'id'          => 'statedesc',
								  'value'       => $state_details[0]['state_desc'],
								  'rows'        => '5',
      							  'cols'        => '10',
								   'class'		=> 'form-control',
								    'required'     =>'required',
								  'placeholder'		=> 'State Description'
      							
								  );	
			
			$statecont = set_value('statecont');
			$data_statecont = array(
						  		 'name'         => 'statecont',
								  'id'          => 'statecont',
								  'value'       => $state_details[0]['state_contact'],
								  'rows'        => '5',
      							  'cols'        => '10',
								   'class'		=> 'form-control',
								    'required'     =>'required',
								  'placeholder'		=> 'Stater Contact'
      							
								  );						  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="sid" id="sid" value="<?php echo $sid;?>" />
            <h3 class="form-section"></h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">State Phone<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_state_phone); ?>
                   <span class="help-block help-block-error" for="state_phone" style="color:#F30;"><?php echo form_error('state_phone'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">State Fx<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_state_fax); ?>
                  <span class="help-block help-block-error" for="state_fax" style="color:#F30;"><?php echo form_error('state_fax'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">State Description<span class="required" aria-required="true"> *</span></label>
                    <?php //echo form_textarea($data_statedesc); ?>
                     <?php echo $this->ckeditor->editor("statedesc", $state_details[0]['state_desc']); ?>
                    <span class="help-block help-block-error" for="statedesc" style="color:#F30;"><?php echo form_error('statedesc'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">State Contact<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_textarea($data_statecont); ?>
                    <span class="help-block help-block-error" for="statecont" style="color:#F30;"><?php echo form_error('statecont'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row--> 
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">State Website<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_input($data_state_web); ?>
                    <span class="help-block help-block-error" for="state_web" style="color:#F30;"><?php echo form_error('state_web'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  
                </div>
              </div>
              <!--/span--> 
            </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>state_con"><button type="button" class="btn default">Cancel</button></a>
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