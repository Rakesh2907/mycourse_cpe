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
			echo form_open('cms_con/page_edit',$attributes);
			
			$correct  = $page_details[0]['page_status'];
			
			$pagename = set_value('pagename');
			$data_pagename = array(
						  		 'name'         => 'pagename',
								  'id'          => 'pagename',
								  'value'       => $page_details[0]['page_title'],
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Chapter Name'
								  );
								  
			$pagedesc = set_value('pagedesc');	
			$data_pagedesc = array(
						  		 'name'         => 'pagedesc',
								  'id'          => 'pagedesc',
								  'value'       => $page_details[0]['page_desc'],
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'	=> 'Chapter Description');
      							
			$data_status = array();
			$data_status[''] = '--select--';
			$data_status['Active'] = 'Active';
			$data_status['Deleted'] = 'Deleted';
			$status_data = set_value('status');					 
												  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);	  
	   ?>
          <div class="form-body">
           <input type="hidden" name="pageid" id="pageid" value="<?php echo $page_id;?>" />
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
                  <?php echo form_input($data_pagename); ?>
                   <span class="help-block help-block-error" for="qtitle" style="color:#F30;"><?php echo form_error('pagename'); ?></span>
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
                    <?php echo $this->ckeditor->editor("pagedesc", $data_pagedesc['value']); ?>
                    <span class="help-block help-block-error" for="data_qanswer1" style="color:#F30;"><?php echo form_error('pagedesc'); ?></span>
                </div>
              </div>
              <!--/span-->
											
            </div>
              <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                    <?php echo form_dropdown('status',$data_status,$page_details[0]['page_status'],'class="select2_category form-control" data-placeholder="Select status"');?>
                    <span class="help-block help-block-error" for="lawyer_type" style="color:#F30;"><?php echo form_error('lawyer_type'); ?></span>
                </div>
              </div>
          </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>cms_con/"><button type="button" class="btn default">Cancel</button></a>
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