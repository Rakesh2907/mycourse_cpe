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
			echo form_open_multipart('bundle_con/add_bundle',$attributes);
			
			
			$bundle_name = set_value('bundle_name');				  
			$data_course_name = array(
						  		 'name'         => 'bundle_name',
								  'id'          => 'bundle_name',
								  'value'       => $bundle_name,
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder' => 'Bundle Name'
								 );
			
		    $bundle_desc = set_value('bundle_desc');				  
			$data_bundle_desc = array(
						  		  'name'        => 'bundle_desc',
								  'id'          => 'bundle_desc',
								  'value'       => $bundle_desc,
								  'rows'		=> '2',
								  'cols'		=> '10',
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Bundle Description'
								 ); 
			
			$bundle_image = set_value('bundle_image');				  
			$data_bundle_image = array(
						  		 'name'         => 'bundle_image',
								  'id'          => 'bundle_image',
								  'value'       => $bundle_image,
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Bundle Image'
								  );
			
			
			$bundle_price = set_value('bundle_price');				  
			$data_bundle_price = array(
						  		 'name'         => 'bundle_price',
								  'id'          => 'bundle_price',
								  'value'       => $bundle_price,
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Price'
								  );
			
			$back_color = set_value('back_color');				  
			$data_back_color = array(
						  		 'name'         => 'back_color',
								  'id'          => 'hue-demo',
								  'data-control' =>"hue",
								  'value'       => '#C7B3DF',
								  'class'		=> 'form-control demo',
								  'placeholder'		=> 'Color'
							   );
							  
			$courses_data = set_value('bundle_courses[]');
			$data_courses = array();
			foreach($course_details as $courses)
			{
				$id = $courses['course_id'];
				$data_courses[$id] = $courses['course_name'];
			}
			
			$data_state = array();
			$data_state[''] = '--Select state--';
			foreach($states as $state)
			{
				$state_id = $state['state_id'];
				$data_state[$state_id] = $state['state'];
			}		
			$state_data = set_value('state_id');	
			
			
			$data_bundle = array();
			$data_bundle['active'] = 'Active';
			$data_bundle['retire'] = 'Retire';
			
			$status_data = set_value('status');
		     
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
		
		
	   ?>
          <div class="form-body">
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
                  <label class="control-label">Bundle Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_course_name); ?>
                   <span class="help-block help-block-error" for="bundle_name" style="color:#F30;"><?php echo form_error('bundle_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Bundle Price<span class="required" aria-required="true"> *</span></label>
                      <?php echo form_input($data_bundle_price); ?>
                      <span class="help-block help-block-error" for="bundle_price" style="color:#F30;"><?php echo form_error('bundle_price'); ?></span>  
                   </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Bundle Description<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_textarea($data_bundle_desc); ?>
                  <span class="help-block help-block-error" for="bundle_desc" style="color:#F30;"><?php echo form_error('bundle_desc'); ?></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Bundle Image<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_upload($data_bundle_image); ?>
                </div>
              </div>
            </div>
            <!--/row-->
            
            <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">States<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_dropdown('state_id',$data_state,$state_data,'class="select2_category form-control" tabindex="0" required="required" onchange="getstatecourse(this)"');?>
                     <span class="help-block help-block-error" for="prerequisites" style="color:#F30;"><?php echo form_error('state_id'); ?></span> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                   <?php echo form_dropdown('bundle_status',$data_bundle,$status_data,'class="select2_category form-control" tabindex="0"');?>
                </div>
              </div>
            </div>
             <div class="row">
                 <div class="form-group">
                   <label class="col-md-3 control-label">Color</label>
                      <div class="col-md-3">
                           <?php echo form_input($data_back_color); ?> 
                      </div>
                 </div>
             </div>   
            <h3 class="form-section">Courses</h3>
           <div class="row">
  			 <div class="col-md-12" id="state_courses" style="display:none">
                
             </div>     
    </div>
            
            <!--/row--> 
            
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>bundle_con"><button type="button" class="btn default">Cancel</button></a>
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
<script type="text/javascript">
   function getstatecourse(elm)
   {
	   $("#state_courses").hide();
	   $.ajax({
			  url: base_url+'course_con/get_state_courses',
			  dataType: 'html',
			  type: 'POST',
			  data: {
        					state_id: $(elm).val()
    		  	}
			}).done(function(response) {
				$("#state_courses").html(' ');
				$("#state_courses").html(response);
				$("#state_courses").show();
		    });
   }
</script>