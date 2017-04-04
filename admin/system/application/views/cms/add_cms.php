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
			echo form_open('cms_con/add_cms_pages',$attributes);
			
			$cmstitl = set_value('cmstitl');	
			$data_cmstitl = array(
						  		 'name'         => 'cmstitl',
								  'id'          => 'cmstitl',
								  'value'       => $cmstitl,
								  'class'		=> 'form-control',
								  'required' => 'required',
								  'placeholder'		=> 'Page Title'
								  );
			
			$cmstitl = set_value('cmsdesc');
			$data_cmsdesc = array(
						  		 'name'         => 'cmsdesc',
								  'id'          => 'cmsdesc',
								  //'value'       => $cmsdesc,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'required' => 'required',
								  'placeholder'		=> 'Page Description'
      							
								  );				  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
            <h3 class="form-section">CMS Page </h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Page Title<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_cmstitl); ?>
                   <span class="help-block help-block-error" for="qtitle" style="color:#F30;"><?php echo form_error('cmstitl'); ?></span>
                </div>
              </div>
              <!--/span-->
              
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Page Description<span class="required" aria-required="true"> *</span></label>
                     <?php echo $this->ckeditor->editor("cmsdesc"); ?>
                    <span class="help-block help-block-error" for="data_qanswer1" style="color:#F30;"><?php echo form_error('cmsdesc'); ?></span>
                </div>
              </div>
            </div>
            <!--/row-->
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>cms_con/<?php //echo $courseid;; ?>"><button type="button" class="btn default">Cancel</button></a>
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