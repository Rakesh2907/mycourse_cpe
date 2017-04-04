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
			echo form_open('faq_con/faq_edit',$attributes);
			
			$correct  = $page_details[0]['faq_status'];
			/* echo "<pre>";
			print_r($page_details); */ 
			$pagename = set_value('ques');
			$data_ques = array(
						  		 'name'         => 'ques',
								  'id'          => 'ques',
								  'value'       => $page_details[0]['question'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Question',
								  'required'     =>'required'
								  );
								  
			$pagedesc = set_value('answer');	
			$data_answer = array(
						  		 'name'         => 'answer',
								  'id'          => 'answer',
								  'value'       => $page_details[0]['answer'],
								  'rows'        => '5',
      							  'cols'        => '10',
								   'class'		=> 'form-control',
								   'required'     =>'required',
								  'placeholder'	=> 'Answer');
      							
			$data_status = array();
			$data_status[''] = '--select--';
			$data_status['Active'] = 'Active';
			$data_status['Deleted'] = 'Deleted';
			$status_data = set_value('status');					 
			
			$data_type = array();
			$data_type[''] = '--select FAQ For--';
			$data_type['support'] = 'Support Page';
			$data_type['checkout'] = 'Checkout Page';
			$data_type['subscription'] = 'Subscription Page';
			$type_data = set_value('type');	
									  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="faqid" id="faqid" value="<?php echo $id;?>" />
            <h3 class="form-section">FAQ </h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">FAQ For<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_dropdown('type',$data_type,$page_details[0]['faq_type'],'class="form-control select2"'); ?>
                </div>
              </div>
          </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Question<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_ques); ?>
                   <span class="help-block help-block-error" for="qtitle" style="color:#F30;"><?php echo form_error('ques'); ?></span>
                </div>
              </div>
              <!--/span-->
              
              <!--/span--> 
            </div>
            <!--/row-->
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_textarea($data_answer); ?>
                    <span class="help-block help-block-error" for="data_qanswer1" style="color:#F30;"><?php echo form_error('answer'); ?></span>
                </div>
              </div>
              <!--/span-->
											
            </div>
              <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_dropdown('status',$data_status,$page_details[0]['faq_status'],'class="select2_category form-control" data-placeholder="Select status"');?>
                    <span class="help-block help-block-error" for="lawyer_type" style="color:#F30;"><?php echo form_error('lawyer_type'); ?></span>
                </div>
              </div>
          </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>faq_con/"><button type="button" class="btn default">Cancel</button></a>
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