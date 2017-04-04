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
			echo form_open('course_con/add_course_chapter',$attributes);
			
			$chptname = set_value('chptname');	
			$data_chptname = array(
						  		 'name'         => 'chptname',
								  'id'          => 'chptname',
								  'value'       => $chptname,
								  'class'		=> 'form-control',
								  'required'     =>'required',
								  'placeholder'		=> 'Chapter Name'
								  );
			
			$chptname = set_value('chptdesc');
			$data_chptdesc = array(
						  		 'name'         => 'chptdesc',
								  'id'          => 'chptdesc',
								  //'value'       => $chptdesc,
								  'rows'        => '5',
      							  'cols'        => '10',
								   'class'		=> 'form-control',
								   'required'     =>'required',
								  'placeholder'		=> 'Chapter Description'
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
			
								  				  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="course_id" id="course_id" value="<?php echo $courseid;?>" />
            <h3 class="form-section">Course Chapter </h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Chapter Title<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_chptname); ?>
                   <span class="help-block help-block-error" for="qtitle" style="color:#F30;"><?php echo form_error('chptname'); ?></span>
                </div>
              </div>
              <!--/span-->
              
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Chapter Description<span class="required" aria-required="true"> *</span></label>
                    <?php //echo form_textarea($data_chptdesc); ?>
                     <?php echo $this->ckeditor->editor("chptdesc"); ?>
                    <span class="help-block help-block-error" for="data_qanswer1" style="color:#F30;"><?php echo form_error('chptdesc'); ?></span>
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
            <!--/row-->
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>course_con/manage_course_chapter/<?php echo $courseid;; ?>"><button type="button" class="btn default">Cancel</button></a>
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