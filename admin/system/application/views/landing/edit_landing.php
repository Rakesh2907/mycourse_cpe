<?php error_reporting(0);?>
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
			echo form_open_multipart('landing_con/edit_bundle',$attributes);
			
			
			$bundle_name = set_value('bundle_name');				  
			$data_course_name = array(
						  		 'name'         => 'bundle_name',
								  'id'          => 'bundle_name',
								  'value'       => $bundle_details[0]['bundle_name'],
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder' => 'Bundle Name'
								 );
			
		    $bundle_desc = set_value('bundle_desc');				  
			$data_bundle_desc = array(
						  		  'name'        => 'bundle_desc',
								  'id'          => 'bundle_desc',
								  'value'       => $bundle_details[0]['bundle_desc'],
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
								  'value'       => $bundle_details[0]['bundle_image'],
								  'class'		=> 'form-control',
								  //'required'    => 'required',
								  'placeholder'		=> 'Bundle Image'
								  );
			
			
			$expdate=date('d-m-Y', strtotime($bundle_details[0]['end_date']));
			
								 
			$bundle_price = set_value('bundle_price');				  
			$data_bundle_price = array(
						  		 'name'         => 'bundle_price',
								  'id'          => 'bundle_price',
								  'value'       => $bundle_details[0]['bundle_price'],
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Price'
								  );
		  
		    $bundle_dprice = set_value('bundle_dprice');				  
			$data_bundle_dprice = array(
						  		 'name'         => 'bundle_dprice',
								  'id'          => 'bundle_dprice',
								  'value'       => $bundle_details[0]['offer_price'],
								  'class'		=> 'form-control',
								  'required'    => 'required',
								  'placeholder'		=> 'Offer Price'
								  );
		  
			$back_color = set_value('back_color');				  
			$data_back_color = array(
						  		 'name'         => 'back_color',
								  'id'          => 'hue-demo',
								  'data-control' =>"hue",
								  'value'       => $bundle_details[0]['back_color'],
								  'class'		=> 'form-control demo',
								  'placeholder'		=> 'Color'
							   );					  
			
			$intro_video = set_value('intro_video');	
			$data_intro_video = array(
						  		 'name'         => 'intro_video',
								 'type'         => 'url',
								  'id'          => 'intro_video',
								  'value'       => $bundle_details[0]['intro_video'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Intro Video URL'
								  );				  
			/*$courses_data = set_value('bundle_courses[]');
			$data_courses = array();
			foreach($course_details as $courses)
			{
				$id = $courses['course_id'];
				$data_courses[$id] = $courses['course_name'];
			}*/
			
			$bundle_course = explode(',',$bundle_details[0]['landing_courseids']);
			
			$data_course = array();
			if(count($bundle_course) > 0)
			{	
				foreach($bundle_course as $keyval => $cval)
				{
					$data_course[$cval] = $cval;
				} 
		    }	
			
			$bundle_cid= explode(',',$bundle_details[0]['landing_bundleids']);
			
			$data_bundleids = array();
			if(count($bundle_cid) > 0)
			{	
				foreach($bundle_cid as $keyval => $cval)
				{
					$data_bundleids[$cval] = $cval;
				} 
		    }
			//echo "<pre>";print_r($bundle_detail);die;
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
            <input type="hidden" name="bundle_id" value="<?php echo $bundle_details[0]['bundle_id'];?>"/>
            <input type="hidden" id="old_image" name="old_image" value="<?php echo $bundle_details[0]['bundle_image'];?>" />
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Bundle Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_course_name); ?>
                   <span class="help-block help-block-error" for="course_name" style="color:#F30;"><?php echo form_error('bundle_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Bundle Price<span class="required" aria-required="true"> *</span></label>
                      <?php echo form_input($data_bundle_price); ?>
                      <span class="help-block help-block-error" for="course_price" style="color:#F30;"><?php echo form_error('bundle_price'); ?></span>  
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
                  <span class="help-block help-block-error" for="course_description" style="color:#F30;"><?php echo form_error('bundle_desc'); ?></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                      <label class="control-label">Bundle Offer Price</label>
                      <?php echo form_input($data_bundle_dprice); ?>
                      <span class="help-block help-block-error" for="bundle_dprice" style="color:#F30;"><?php echo form_error('bundle_dprice'); ?></span>  
                   </div>
              </div>
            </div>
            <!--/row-->
            
            <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">States<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_dropdown('state_id',$data_state,$bundle_details[0]['state_id'],'id="mystate" class="select2_category form-control" tabindex="0" required="required" onchange="getstatecourse(this)"');?>
                     <span class="help-block help-block-error" for="prerequisites" style="color:#F30;"><?php echo form_error('state_id'); ?></span> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                   <?php echo form_dropdown('bundle_status',$data_bundle,$bundle_details[0]['bundle_status'],'class="select2_category form-control" tabindex="0"');?>
                </div>
              </div>
            </div>

             
              <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Color<span class="required" aria-required="true"> *</span></label>
                      <?php echo form_input($data_back_color); ?> 
                     <span class="help-block help-block-error" for="prerequisites" style="color:#F30;"><?php echo form_error('back_color'); ?></span> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Landing Bundle Expiration<span class="required" aria-required="true"> *</span></label>
                  <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
				  <input type="text" class="form-control" id="expdate" name="expdate" required="required" readonly value="<?php echo $expdate; ?>" >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
                </div>
                <br />
                <input type="checkbox" name="hidedays" <?php if($bundle_details[0]['hidedays']){echo 'checked="checked"';}?> value="1">Hide Days from Countdown<br />
				<input type="checkbox" name="hidecountdown" <?php if($bundle_details[0]['hidecountdown']){echo 'checked="checked"';}?> value="1">Hide Countdown Clock
              </div>
            </div>
            </div>
            <div class="row">
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Intro Video URL</label>
                    <?php echo form_input($data_intro_video); ?>    
                    <span class="help-block help-block-error" for="intro_video" style="color:#F30;"><?php echo form_error('intro_video'); ?></span>
                </div>
              </div>
              <!--/span--> 
                <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Bundle Image<span class="required" aria-required="true"> *</span></label>
                    <?php echo form_upload($data_bundle_image); ?>
                    <?php 
					    if($bundle_details[0]['s3_images']!='NULL'){
							$image_url = CLOUDFRONT_URL.'images/'.$bundle_details[0]['bundle_image'];
					?>
                     	<img style="margin-top:10px;" src="<?php echo $image_url;?>" width="65" height="40" />
                    <?php		
						}
					    else if($bundle_details[0]['bundle_image'] != 'NULL') 
						{ ?>
                          <img style="margin-top:10px;" src="<?php echo $this->config->item("base_url_asset")?>uploads/image/<?php echo $bundle_details[0]['bundle_image'];?>" width="65" height="40" />
				  <?php } ?>
                </div>
              </div>
            </div>
            <h3 class="form-section">Courses</h3>
            
           <div class="row"> 
                 <div class="col-md-12" id="state_courses" style="display:none">
                
                 </div> 
            </div>
            <!--/row--> 
            
            <h3 class="form-section">Bundles</h3>
            
           <div class="row"> 
                <div class="form-group">
                   <?php 
				    $count = 1;
					
				    foreach($bundle_detail as $bundle1)
			        {	
					   if(isset($data_bundleids) && count($data_bundleids) > 0)
					   {
							if($data_bundleids[$bundle1['bundle_id']] == $bundle1['bundle_id']){
								 $checked = 'checked="checked"';
							}else{
								 $checked = '';
							}
					   }else{
						    $checked = '';
					   }
						
						if($count%10 == 1)
						{
							 echo '<ul class="list-unstyled" style="margin-left:10px;">';
						}
						echo '<li><input type="checkbox" '.$checked.' name="bundles[]" value="'.$bundle1['bundle_id'].'" />'.$bundle1['bundle_name'].'</li>';
						if ($count%10 == 0)
    					{
							 echo "</ul>";
						}
						$count++;	
					}
					if ($count%10 != 1) echo "</ul>";
					?>
                </div>
            </div>
            
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>landing_con"><button type="button" class="btn default">Cancel</button></a>
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
$(document).ready(function() { 
    $("#mystate").trigger('change');
});
   function getstatecourse(elm)
   {
	   $("#state_courses").hide();
	   $.ajax({
			  url: base_url+'course_con/get_state_courses',
			  dataType: 'html',
			  type: 'POST',
			  data: {
        					state_id: $(elm).val(),
							bundle_courses: '<?php echo $bundle_details[0]['bundle_courses'];?>'
    		  	}
			}).done(function(response) {
				$("#state_courses").html(' ');
				$("#state_courses").html(response);
				$("#state_courses").show();
		    });
   }
</script>