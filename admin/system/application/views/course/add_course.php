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
			echo form_open_multipart('course_con/add_course',$attributes);
			
			
			$course_name = set_value('course_name');				  
			$data_coursename = array(
						  		 'name'         => 'course_name',
								  'id'          => 'course_name',
								  'value'       => $course_name,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder' => 'Course Name'
								 );
								 
			$field_study = set_value('field_study');				  
			$data_fieldstudy = array(
						  		 'name'         => 'field_study',
								  'id'          => 'field_study',
								  'value'       => $field_study,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder' => 'Field of Study'
								 );					 
			
		    $course_description = set_value('course_description');				  
			$data_coursedescription = array(
						  		  'name'        => 'course_description',
								  'id'          => 'course_description',
								  'value'       => $course_description,
								  'rows'		=> '2',
								  'cols'		=> '10',
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Course Description'
								 ); 
			
			$course_image = set_value('course_image');				  
			$data_courseimage = array(
						  		 'name'         => 'course_image',
								  'id'          => 'course_image',
								  'value'       => $course_image,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Course Image'
								  );
			
			
			$course_price = set_value('course_price');				  
			$data_courseprice = array(
						  		 'name'         => 'course_price',
								  'id'          => 'course_price',
								  'value'       => $course_price,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Price'
								  );
								  
			$discount_price = set_value('discount_price');				  
			$data_discount_price = array(
						  		 'name'         => 'discount_price',
								  'id'          => 'discount_price',
								  'value'       => $discount_price,
								  'class'		=> 'form-control',								  
								  'placeholder'		=> 'Discounted Price'
								  );
								  
			$instructional_delivery_method = set_value('instructional_delivery_method');				  
			$data_delivery_method = array(
						  		 'name'         => 'instructional_delivery_method',
								  'id'          => 'instructional_delivery_method',
								  'value'       => $instructional_delivery_method,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Instructional Delivery Method'
								  );
								  
			
			$prerequisites = set_value('prerequisites');	
			$data_prerequisites = array(
						  		 'name'         => 'prerequisites',
								  'id'          => 'prerequisites',
								  'value'       => $prerequisites,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Prerequisites'
								  );
								  
			$knowledge_level = set_value('knowledge_level');	
			$data_knowledgelevel = array(
						  		 'name'         => 'knowledge_level',
								  'id'          => 'knowledge_level',
								  'value'       => $knowledge_level,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Knowledge Level'
								  );
								  
			$cpe_credits = set_value('cpe_credits');	
			$data_cpe_credits = array(
						  		 'name'         => 'cpe_credits',
								  'id'          => 'cpe_credits',
								  'value'       => $cpe_credits,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'CPE credits'
								);
								  
			$passing_grade = set_value('passing_grade');	
			$data_passing_grade = array(
						  		 'name'         => 'passing_grade',
								  'id'          => 'passing_grade',
								  'value'       => $passing_grade,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Passing Grade'
								  );
								  
			$advance_preparation = set_value('advance_preparation');
			$data_advance_preparation = array(
						  		 'name'         => 'advance_preparation',
								  'id'          => 'advance_preparation',
								  'value'       => $advance_preparation,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Advance Preparation'
								  );
								  
			$back_color = set_value('back_color');				  
			$data_back_color = array(
						  		 'name'         => 'back_color',
								  'id'          => 'hue-demo',
								  'data-control' =>"hue",
								  'value'       => '#C7B3DF',
								   'required' 	=> 'required',
								  'class'		=> 'form-control demo',
								  'placeholder'		=> 'Color'
			);					  
								  
			$course_period = set_value('course_period');	
			   $data_course_period = array();
			   $data_course_period[''] = 'Select Course Period';
			   $data_course_period['3'] = '3 Months';
			   $data_course_period['6'] = '6 Months';
			   $data_course_period['9'] = '9 Months';
			   $data_course_period['12'] = '12 Months';
			   $data_course_period['18'] = '18 Months';
			   $data_course_period['24'] = '24 Months';
				   
   
   $active_data = set_value('active_check');
			/*$data_course_period = array(
						  		 'name'         	=> 'course_period',
								  'id'         	 	=> 'course_period',
								  'value'       	=> $course_period,
								  'class'			=> 'form-control',
								  'placeholder'		=> 'Course period'
							  );*/
			
			$course_date = set_value('course_date');	
			$data_course_date = array(
						  		 'name'         => 'course_date',
								  'id'          => 'course_date',
								  'value'       => date("m/d/Y"),
								  'class'		=> 'form-control form-control-inline input-medium date-picker',
								  'placeholder'		=> 'Course Date'
								  );
								  
			$phone = set_value('phone');	
			$data_phone = array(
						  		 'name'         => 'phone',
								  'id'          => 'phone',
								  'value'       => $phone,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Phone'
								  );
			$intro_video = set_value('intro_video');	
			$data_intro_video = array(
						  		 'name'         => 'intro_video',
								 'type'         => 'url',
								  'id'          => 'intro_video',
								  'value'       => $intro_video,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Intro Video URL'
								  );
			$introPDF = set_value('introPDF');				  
			$data_introPDF = array(
						  		 'name'         => 'introPDF',
								  'id'          => 'introPDF',
								  'value'       => $introPDF,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Intro PDF'
								  );
			
			
						  
			$faculty_data = set_value('course_faculty[]');
			$data_faculty = array();
			foreach($faculty_details as $faculty)
			{
				$id = $faculty['faculty_member_id'];
				$data_faculty[$id] = $faculty['first_name'].' '.$faculty['last_name'];
			}
			
			$data_status = array();
			$data_status['pending'] = 'Pending';
			$data_status['active'] = 'Active';
			$data_status['retired'] = 'Retire';
			$status_data = set_value('status');
		
		    $data_course_format = array();
			$data_course_format['Text'] = 'Text';
		    $data_course_format['Webcast'] = 'Webcast';
			$data_course_format['Webinar'] = 'Webinar';
			$data_course_format['Live seminar'] = 'Live seminar'; 
			$format_data = set_value('course_format');
		
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
                  <label class="control-label">Course Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_coursename); ?>
                   <span class="help-block help-block-error" for="course_name" style="color:#F30;"><?php echo form_error('course_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Field Of Study<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_fieldstudy); ?>
                   <span class="help-block help-block-error" for="field_study" style="color:#F30;"><?php echo form_error('field_study'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            
            <div class="row">
         
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">Course Description<span class="required" aria-required="true"> *</span></label>
                  <?php //echo form_textarea($data_coursedescription); ?>
                  <?php echo $this->ckeditor->editor("course_description"); ?>
                  <span class="help-block help-block-error" for="course_description" style="color:#F30;"><?php echo form_error('course_description'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Course Image</label>
                    <?php echo form_upload($data_courseimage); ?>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Instructional Delivery Method<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_input($data_delivery_method); ?>    
                    <span class="help-block help-block-error" for="instructional_delivery_method" style="color:#F30;"><?php echo form_error('instructional_delivery_method'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Prerequisites<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_prerequisites); ?>
                     <span class="help-block help-block-error" for="prerequisites" style="color:#F30;"><?php echo form_error('prerequisites'); ?></span> 
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Knowledge Level<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_knowledgelevel); ?>
                 	 <span class="help-block help-block-error" for="knowledge_level" style="color:#F30;"><?php echo form_error('knowledge_level'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">CPE Credits<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_cpe_credits); ?>
                    <span class="help-block help-block-error" for="cpe_credits" style="color:#F30;"><?php echo form_error('cpe_credits'); ?></span>
                  
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Passing Grade<span class="required" aria-required="true"> *</span></label>
         			<?php echo form_input($data_passing_grade); ?>
                    <span class="help-block help-block-error" for="course_price" style="color:#F30;"><?php echo form_error('passing_grade'); ?></span> 
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Advance Preparation</label>
                    		 <?php echo form_input($data_advance_preparation); ?>
                    </div> 
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Authors<span class="required" aria-required="true"> *</span></label>
                    		  <?php echo form_multiselect('course_faculty[]',$data_faculty,$faculty_data,'class="form-control" required="required"'); ?>
                        <span class="help-block help-block-error" for="course_faculty" style="color:#F30;"><?php echo form_error('course_faculty[]'); ?></span>     
                    </div> 
                </div>
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                
                  <label class="control-label">Course Period<span class="required" aria-required="true"> *</span></label>
                     <?php //echo form_input($data_course_period); ?>
                     <?php echo form_dropdown('course_period',$data_course_period,$course_period,'class="form-control select2" required="required"'); ?>
                     <span class="help-block help-block-error" for="course_period" style="color:#F30;"><?php echo form_error('course_period'); ?></span>  
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Course Date</label>
                    <?php echo form_input($data_course_date); ?>
                </div>
              </div>
            </div>
            <!--/row-->
            <div class="row"> 
              <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Course Price<span class="required" aria-required="true"> *</span></label>
                      <?php echo form_input($data_courseprice); ?>
                      <span class="help-block help-block-error" for="course_price" style="color:#F30;"><?php echo form_error('course_price'); ?></span>  
                   </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Discounted Price</label>
                   <?php echo form_input($data_discount_price); ?>
                      <span class="help-block help-block-error" for="discount_price" style="color:#F30;"><?php echo form_error('discount_price'); ?></span> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Intro PDF</label>
                    <?php echo form_upload($data_introPDF); ?>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Intro Video URL</label>
                    <?php echo form_input($data_intro_video); ?>    
                    <span class="help-block help-block-error" for="intro_video" style="color:#F30;"><?php echo form_error('intro_video'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
             <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Color<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_back_color); ?>
                      <span class="help-block help-block-error" for="back_color" style="color:#F30;"><?php echo form_error('back_color'); ?></span>  
                   </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status<span class="required" aria-required="true"> *</span></label>
                   <?php echo form_dropdown('course_status',$data_status,$status_data,'class="select2_category form-control" tabindex="0"');?>
                   <span style="color:#03F">First complete data like credits,course material,chapters,review and exam quetions then acivate the course.</span>
                </div>
              </div>
             </div>
             
             <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                   <label class="control-label">Course Requirments</label> <br />
                  <?php foreach($course_requirments as $requirments)
						{ ?>
                       <input type="checkbox" name="requirments[]" value="<?php echo $requirments['req_id']; ?>" /><?php echo  $requirments['req_name'];?>&nbsp; 					
				  <?php } ?>                      
                   </div>
              </div>
                <div class="col-md-6"> 
                   <div class="form-group">
                      <label class="control-label">Course Format<span class="required" aria-required="true"> *</span></label>
                       <?php echo form_dropdown('course_format',$data_course_format,$format_data,'class="select2_category form-control" tabindex="0"');?>
                       <span class="help-block help-block-error" for="course_format" style="color:#F30;"><?php echo form_error('course_format'); ?></span>
                   </div>
                </div>
              
             </div>
            <!--/row--> 
          </div>
         
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>course_con"><button type="button" class="btn default">Cancel</button></a>
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