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
			echo form_open_multipart('subcription_con/add_subcription',$attributes);
			
			
			$title = set_value('title');				  
			$data_subcription_name = array(
						  		 'name'         => 'title',
								  'id'          => 'title',
								  'value'       => $title,
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder' => 'Subscription Name'
								 );
			
		    $price = set_value('price');				  
			$data_subcription_price = array(
						  		  'name'        => 'price',
								  'id'          => 'price',
								  'value'       => $price,
								  'rows'		=> '2',
								  'cols'		=> '10',
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Price'
								 ); 
			
			$duration = set_value('duration');				  
			$data_duration = array(
						  		 'name'         => 'duration',
								  'id'          => 'duration',
								  'value'       => $duration,
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Duration'
								  );
								  
			$data_subcription = array();
			$data_subcription['in-active'] = 'In-Active';
			$data_subcription['active'] = 'Active';
			
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Subcription Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_subcription_name); ?>
                   <span class="help-block help-block-error" for="course_name" style="color:#F30;"><?php echo form_error('title'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Subcription Price<span class="required" aria-required="true"> *</span></label>
                      <?php echo form_input($data_subcription_price); ?>
                      <span class="help-block help-block-error" for="course_price" style="color:#F30;"><?php echo form_error('price'); ?></span>  
                   </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Duration (Months)<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_duration); ?>
                  <span class="help-block help-block-error" for="course_description" style="color:#F30;"><?php echo form_error('duration'); ?></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                   <?php echo form_dropdown('status',$data_subcription,$status_data,'class="select2_category form-control" tabindex="0"');?>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>subcription_con"><button type="button" class="btn default">Cancel</button></a>
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