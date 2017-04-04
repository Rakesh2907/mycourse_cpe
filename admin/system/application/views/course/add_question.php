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
			echo form_open_multipart('course_con/add_course_question',$attributes);
			
			$qtitle = set_value('qtitle');	
			$data_qtitle = array(
						  		 'name'         => 'qtitle',
								  'id'          => 'qtitle',
								  'value'       => $qtitle,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Please type the question here'
								  );
								  
			$qanswer1 = set_value('qanswer1');	
			$data_qanswer1 = array(
						  		 'name'         => 'qanswer1',
								  'id'          => 'qanswer1',
								  'value'       => $qanswer1,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer1'
								);
			$qanswer2 = set_value('qanswer2');	
			$data_qanswer2 = array(
						  		 'name'         => 'qanswer2',
								  'id'          => 'qanswer2',
								  'value'       => $qanswer2,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer2'
								);	
            $qanswer3 = set_value('qanswer3');	
			$data_qanswer3 = array(
						  		 'name'         => 'qanswer3',
								  'id'          => 'qanswer3',
								  'value'       => $qanswer3,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer3'
								); 
			$qanswer4 = set_value('qanswer4');	
			$data_qanswer4 = array(
						  		 'name'         => 'qanswer4',
								  'id'          => 'qanswer4',
								  'value'       => $qanswer4,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer4'
								);
			$qanswer5 = set_value('qanswer5');	
			$data_qanswer5 = array(
						  		 'name'         => 'qanswer5',
								  'id'          => 'qanswer5',
								  'value'       => $qanswer5,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer5'
								);										
			$fimage = set_value('course_image');				  
			$data_fimage = array(
						  		 'name'         => 'fimage',
								  'id'          => 'fimage',
								  'value'       => $fimage,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Faculty Image',
								 
								  );																	  
							  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="course_id" id="course_id" value="<?php echo $courseid;?>" />
            <h3 class="form-section">Course Question </h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Question Title</label>
                  <?php //echo form_input($data_qtitle); ?>
                  <?php echo $this->ckeditor->editor("qtitle"); ?>
                   <span class="help-block help-block-error" for="qtitle" style="color:#F30;"><?php echo form_error('qtitle'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Question Image</label>
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
                  <label class="control-label">Answer 1</label>
                    <?php echo form_input($data_qanswer1); ?>
                    <span class="help-block help-block-error" for="data_qanswer1" style="color:#F30;"><?php echo form_error('data_qanswer1'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
         
                    <span class="help-block help-block-error" for="cemail" style="color:#F30;"><?php echo form_error('correctans'); ?></span>
                </div>
              </div>
                       <label class="radio-inline">
											<?php 
											$data = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans1',
								                'value' => '1',
												'checked'=> true,
												'type'	=> 'radio',
												'disabled' => 'disabled'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 2</label>
                    <?php echo form_input($data_qanswer2); ?>
                    <span class="help-block help-block-error" for="qanswer2" style="color:#F30;"><?php echo form_error('qanswer2'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
         
                    <span class="help-block help-block-error" for="cemail" style="color:#F30;"><?php echo form_error('cemail'); ?></span>
                </div>
              </div>
                       <label class="radio-inline">
											<?php 
											$data = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans2',
								                'value' => '2',
												'checked'=> false,
												'type'	=> 'radio',
												'disabled' => 'disabled'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 3</label>
                    <?php echo form_input($data_qanswer3); ?>
                    <span class="help-block help-block-error" for="qanswer3" style="color:#F30;"><?php echo form_error('qanswer3'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
         
                    <span class="help-block help-block-error" for="cemail" style="color:#F30;"><?php echo form_error('cemail'); ?></span>
                </div>
              </div>
                       <label class="radio-inline">
											<?php 
											$data = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans3',
								                'value' => '3',
												'checked'=> false,
												'type'	=> 'radio',
												'disabled' => 'disabled'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 4</label>
                    <?php echo form_input($data_qanswer4); ?>
                    <span class="help-block help-block-error" for="qanswer4" style="color:#F30;"><?php echo form_error('qanswer4'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
         
                    <span class="help-block help-block-error" for="cemail" style="color:#F30;"><?php echo form_error('cemail'); ?></span>
                </div>
              </div>
                       <label class="radio-inline">
											<?php 
											$data = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans4',
								                'value' => '4',
												'checked'=> false,
												'type'	=> 'radio',
												'disabled' => 'disabled'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 5</label>
                    <?php echo form_input($data_qanswer5); ?>
                    <span class="help-block help-block-error" for="qanswer5" style="color:#F30;"><?php echo form_error('qanswer5'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
         
                    <span class="help-block help-block-error" for="cemail" style="color:#F30;"><?php echo form_error('cemail'); ?></span>
                </div>
              </div>
                       <label class="radio-inline">
											<?php 
											$data = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans5',
								                'value' => '5',
												'checked'=> false,
												'type'	=> 'radio',
												'disabled' => 'disabled'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>course_con/manage_course_quest/<?php echo $courseid;; ?>"><button type="button" class="btn default">Cancel</button></a>
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
<script type="text/javascript">
  $("#qanswer1").keyup(function( event ) {
	    if($(this).val()!='')
		{
			$("#correct_ans1").prop("disabled", false);
			$("#uniform-correct_ans1").removeClass('disabled');
		}else{
			$("#correct_ans1").attr("disabled", "disabled")
			$("#uniform-correct_ans1").addClass('disabled');
		}
  });
  $("#qanswer2").keyup(function( event ) {
	   if($(this).val()!='')
		{
			$("#correct_ans2").prop("disabled", false);
			$("#uniform-correct_ans2").removeClass('disabled');
		}else{
			$("#correct_ans2").attr("disabled", "disabled")
			$("#uniform-correct_ans2").addClass('disabled');
		}
  });
  $("#qanswer3").keyup(function( event ) {
	    if($(this).val()!='')
		{
			$("#correct_ans3").prop("disabled", false);
			$("#uniform-correct_ans3").removeClass('disabled');
		}else{
			$("#correct_ans3").attr("disabled", "disabled")
			$("#uniform-correct_ans3").addClass('disabled');
		}
  });
  $("#qanswer4").keyup(function( event ) {
	     if($(this).val()!='')
		{
			$("#correct_ans4").prop("disabled", false);
			$("#uniform-correct_ans4").removeClass('disabled');
		}else{
			$("#correct_ans4").attr("disabled", "disabled")
			$("#uniform-correct_ans4").addClass('disabled');
		}
  });
  $("#qanswer5").keyup(function( event ) {
	     if($(this).val()!='')
		{
			$("#correct_ans5").prop("disabled", false);
			$("#uniform-correct_ans5").removeClass('disabled');
		}else{
			$("#correct_ans1").attr("disabled", "disabled")
			$("#uniform-correct_ans5").addClass('disabled');
		}
  });
</script>
<!-- END PAGE CONTENT--> 