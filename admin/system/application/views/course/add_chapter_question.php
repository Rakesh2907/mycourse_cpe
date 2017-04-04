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
			echo form_open('course_con/add_chapter_question',$attributes);
			
			$qtitle = set_value('qtitle');	
			$data_qtitle = array(
						  		 'name'         => 'qtitle',
								  'id'          => 'qtitle',
								  //'value'       => $qtitle,
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
																				  
	/*		$correctAnswer = set_value('correctAnswer');	
			$data_correctAnswer = array(
						  		 'name'         => 'correctAnswer',
								  'id'          => 'correctAnswer',
								  'value'       => $correctAnswer,
								   'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Correct Answer Text'
								);										
			
			$wrongAnswer = set_value('wrongAnswer');	
			$data_wrongAnswer = array(
						  		 'name'         => 'wrongAnswer',
								  'id'          => 'wrongAnswer',
								  'value'       => $wrongAnswer,
								   'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Wrong Answer Text'
								);		*/								
			
			$qanswer1text = set_value('qanswer1text');	
			$data_qanswer1text = array(
						  		 'name'         => 'qanswer1text',
								  'id'          => 'qanswer1text',
								  'value'       => $qanswer1text,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer text'
								);
			$qanswer2text = set_value('qanswer2text');
			$data_qanswer2text = array(
						  		 'name'         => 'qanswer2text',
								  'id'          => 'qanswer2text',
								  'value'       => $qanswer2text,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer text'
								);					
			
			$qanswer3text = set_value('qanswer3text');
			$data_qanswer3text = array(
						  		 'name'         => 'qanswer3text',
								  'id'          => 'qanswer3text',
								  'value'       => $qanswer3text,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer text'
								);		
			
			$qanswer4text = set_value('qanswer4text');
			$data_qanswer4text = array(
						  		 'name'         => 'qanswer4text',
								  'id'          => 'qanswer4text',
								  'value'       => $qanswer4text,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer text'
								);		
			$qanswer5text = set_value('qanswer5text');
			$data_qanswer5text = array(
						  		 'name'         => 'qanswer5text',
								  'id'          => 'qanswer5text',
								  'value'       => $qanswer5text,
								  'rows'        => '5',
      							  'cols'        => '10',
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Answer text'
								);												
																													  
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
          <div class="form-body">
           <input type="hidden" name="chapterid" id="chapterid" value="<?php echo $chapterid;?>" />
            <input type="hidden" name="courseid" id="courseid" value="<?php echo $courseid;?>" />
            <h3 class="form-section">Chapter Review Question </h3>
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
              
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 1</label>
                    <?php echo form_input($data_qanswer1); ?>
                    <span class="help-block help-block-error" for="data_qanswer1" style="color:#F30;"><?php echo form_error('qanswer1'); ?></span>
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
								                'id' 	=> 'correct_ans',
								                'value' => '1',
												'checked'=> true,
												'type'	=> 'radio'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
           <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 1 Text</label>
                    <?php echo form_textarea($data_qanswer1text); ?>
                    <span class="help-block help-block-error" for="qanswer1text" style="color:#F30;"><?php echo form_error('qanswer1text'); ?></span>
                </div>
              </div>
            </div> 
            <hr style="border-width:medium" />
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
								                'id' 	=> 'correct_ans',
								                'value' => '2',
												'checked'=> false,
												'type'	=> 'radio'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 2 Text</label>
                    <?php echo form_textarea($data_qanswer2text); ?>
                    <span class="help-block help-block-error" for="qanswer2text" style="color:#F30;"><?php echo form_error('qanswer2text'); ?></span>
                </div>
              </div>
            </div>
            <hr style="border-width:medium" />
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
								                'id' 	=> 'correct_ans',
								                'value' => '3',
												'checked'=> false,
												'type'	=> 'radio'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 3 Text</label>
                    <?php echo form_textarea($data_qanswer3text); ?>
                    <span class="help-block help-block-error" for="qanswer3text" style="color:#F30;"><?php echo form_error('qanswer3text'); ?></span>
                </div>
              </div>
       
            </div>
            <hr style="border-width:medium" />
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
								                'id' 	=> 'correct_ans',
								                'value' => '4',
												'checked'=> false,
												'type'	=> 'radio'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 4 Text</label>
                    <?php echo form_textarea($data_qanswer4text); ?>
                    <span class="help-block help-block-error" for="qanswer4text" style="color:#F30;"><?php echo form_error('qanswer4text'); ?></span>
                </div>
              </div>
       
            </div>
            <hr style="border-width:medium" />
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
                    <!--<span class="help-block help-block-error" for="cemail" style="color:#F30;"><?php//echo form_error('cemail'); ?></span>-->
                </div>
              </div>
                       <label class="radio-inline">
											<?php 
											$data = array(
								                'name' 	=> 'correct_ans',
								                'id' 	=> 'correct_ans',
								                'value' => '5',
												'checked'=> false,
												'type'	=> 'radio'
												);
								   			 echo form_radio($data)."Correct";
											?>
											</label>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Answer 5 Text</label>
                    <?php echo form_textarea($data_qanswer5text); ?>
                    <span class="help-block help-block-error" for="qanswer5text" style="color:#F30;"><?php echo form_error('qanswer5text'); ?></span>
                </div>
              </div>
       
            </div>
            
     <!--       <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Correct Answer Text</label>
                    <?php //echo form_textarea($data_correctAnswer); ?>
                    <span class="help-block help-block-error" for="correctAnswer" style="color:#F30;"><?php //echo form_error('correctAnswer'); ?></span>
                </div>
              </div>-->
              <!--/span-->
              <!--<div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Wrong Answer Text</label>
                    <?php //echo form_textarea($data_wrongAnswer); ?>
                    <span class="help-block help-block-error" for="wrongAnswer" style="color:#F30;"><?php //echo form_error('wrongAnswer'); ?></span>
                </div>
              </div>
            </div>-->
            
            
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>course_con/manage_chapter_question/<?php echo $chapterid; ?>/<?php echo $courseid;?>"><button type="button" class="btn default">Cancel</button></a>
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