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
			echo form_open_multipart('course_con/edit_question',$attributes);
			
			$qtitle = set_value('qtitle');
			$courseid = $question_details[0]['course_id'];
			$correct  = $question_details[0]['correct_ans_id'];
			$data_qtitle = array(
						  		 'name'         => 'qtitle',
								  'id'          => 'qtitle',
								  'rows'        => '5',
      							  'cols'        => '10',
								  'value'       => $question_details[0]['ques_title'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Please type the question here'
								  );
								  
			$qanswer1 = set_value('qanswer1');	
			$data_qanswer1 = array(
						  		 'name'         => 'qanswer1',
								  'id'          => 'qanswer1',
								  'value'       => $question_details[0]['ques_ans_1'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer1'
								);
			$qanswer2 = set_value('qanswer2');	
			$data_qanswer2 = array(
						  		 'name'         => 'qanswer2',
								  'id'          => 'qanswer2',
								  'value'       => $question_details[0]['ques_ans_2'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer2'
								);	
            $qanswer3 = set_value('qanswer3');	
			$data_qanswer3 = array(
						  		 'name'         => 'qanswer3',
								  'id'          => 'qanswer3',
								  'value'       => $question_details[0]['ques_ans_3'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer3'
								); 
			$qanswer4 = set_value('qanswer4');	
			$data_qanswer4 = array(
						  		 'name'         => 'qanswer4',
								  'id'          => 'qanswer4',
								  'value'       => $question_details[0]['ques_ans_4'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer4'
								);
			$qanswer5 = set_value('qanswer5');	
			$data_qanswer5 = array(
						  		 'name'         => 'qanswer5',
								  'id'          => 'qanswer5',
								  'value'       => $question_details[0]['ques_ans_5'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer5'
								);										
			
			$fimage = set_value('course_image');				  
			$data_fimage = array(
						  		 'name'         => 'fimage',
								  'id'          => 'fimage',
								  'value'       => $question_details[0]['question_image'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Faculty Image'
								  );																		  
							  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="qid" id="qid" value="<?php echo $ques_id;?>" />
           <input type="hidden" name="course_id" id="course_id" value="<?php echo $courseid;?>" />
            <input type="hidden" id="old_image" name="old_image" value="<?php echo $question_details[0]['question_image'];?>" />
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
                  <?php echo $this->ckeditor->editor("qtitle", $question_details[0]['ques_title']); ?>
                   <span class="help-block help-block-error" for="qtitle" style="color:#F30;"><?php echo form_error('qtitle'); ?></span>
                </div>
                
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Question Image</label>
                   <?php echo form_upload($data_fimage); ?>
                   <?php 
					    if($question_details[0]['s3_images']!=''){
							$image_url = CLOUDFRONT_URL.'questions/'.$question_details[0]['question_image'];
					?>
                     	<img style="margin-top:10px;" src="<?php echo $image_url;?>" width="120" height="100" />
                    <?php		
						}
					    else if($question_details[0]['question_image'] != NULL) {
					 ?>
                     <img style="margin-top:10px;" src="<?php echo $this->config->item('base_url_asset')?>uploads/question/<?php echo $question_details[0]['question_image'];?>" width="120" height="100" /><?php } ?>
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
                       
											<?php 
											$data1 = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans1',
								                'value' => '1',
												'type'	=> 'radio'
												);
										   if($question_details[0]['ques_ans_1']=='')
											{
												$data1['disabled']='disabled';
											}		
											$data['checked']='false';
											if($correct == 1) 
											{   
												$data1['checked']='true';
											}
											?>
                                            <label class="radio-inline">
                                            <?php	
								   			 echo form_radio($data1)."Correct";
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
                       
											<?php 
											
											$data2 = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans2',
								                'value' => '2',
												'type'	=> 'radio'
												);
												
											$data2['checked']='false';
											if($question_details[0]['ques_ans_2']=='')
											{
												$data2['disabled']='disabled';
											}
											if($correct == 2) 
											{  
												$data2['checked']=true;
											}else{
												$data2['checked']=false;
											}
											?>
                                            <label class="radio-inline">
                                            <?php
								   			 echo form_radio($data2)."Correct";
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
                      
											<?php 
											
											$data3 = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans3',
								                'value' => '3',
												'type'	=> 'radio'
												);
												
											$data3['checked']='false';
											if($question_details[0]['ques_ans_3']=='')
											{
												$data3['disabled']='disabled';
											}
											if($correct == 3) 
											{   
												$data3['checked']=true;
											}else{
												$data3['checked']=false;
											}
											//print_r($data3);
											?>
                                             <label class="radio-inline">
                                             <?php
								   			 echo form_radio($data3)."Correct";
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
                       
											<?php 
											
											$data4 = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans4',
								                'value' => '4',
												'type'	=> 'radio'
												);
												
											$data4['checked']='false';
											if($question_details[0]['ques_ans_4']=='')
											{
												$data4['disabled']='disabled';
											}
											if($correct == 4) 
											{
												$data4['checked']=true;
											}else{
												$data4['checked']=false;
											}	
											?>
                                            <label class="radio-inline">
											<?php
								   			 echo form_radio($data4)."Correct";
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
                       
											<?php 
											$data5 = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans5',
								                'value' => '5',
												'type'	=> 'radio'
												);
												
											$data5['checked']=false;
											if($question_details[0]['ques_ans_5']=='')
											{
												$data5['disabled']='disabled';
											}
											if($correct == 5) 
											{   
												$data5['checked']=true;
											}else{
												$data5['checked']=false;
											}	
											?>
                                            <label class="radio-inline">
                                            <?php
								   			 echo form_radio($data5)."Correct";
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
			$("#correct_ans5").attr("disabled", "disabled")
			$("#uniform-correct_ans5").addClass('disabled');
		}
  });
</script>
<!-- END PAGE CONTENT--> 