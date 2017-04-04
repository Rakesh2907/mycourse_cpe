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
			echo form_open('coupon_con/coupon_edit',$attributes);
			
			$coupon_code = set_value('coupon_code');				  
			$data_coupon_code = array(
						  		 'name'         => 'coupon_code',
								  'id'          => 'coupon_code1',
								  'value'       => $coupon_details[0]['coupon_code'],
								  'class'		=> 'form-control',
								  'placeholder' => 'coupon_code',
								  'required'     =>'required'
								   //'onblur'=>'myFunction()'
								 );
			
			$coupon_discnt = set_value('coupon_discnt');	
			$data_coupon_discnt = array(
						  		 'name'         => 'coupon_discnt',
								  'id'          => 'coupon_discnt',
								  'value'       => $coupon_details[0]['coupon_discount'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Coupon Discount',
								  'required'     =>'required'
								 
								  );
			$coupon_max = set_value('coupon_discnt');	
			$data_coupon_max = array(
						  		 'name'         => 'coupon_max',
								  'id'          => 'coupon_max',
								  'value'       => $coupon_details[0]['max_redemption'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Max Limit',
								  'required'     =>'required'
							 );
			     $coupon_type = $coupon_details[0]['coupon_type'];		
			     $discnt_type = $coupon_details[0]['discount_type'];									  
			
			$data_courses = array();
			foreach($course_details as $courses)
			{
				$id = $courses['course_id'];
				$data_courses[$id] = $courses['course_name'];
			}
			
		    $coupon_course = explode(',',$coupon_details[0]['courseid']);
			
			$data_course = array();
			if(count($coupon_course) > 0)
			{	
				foreach($coupon_course as $keyval => $cval)
				{
					$data_course[$cval] = $cval;
				} 
		    }
			
					$data_customer = array();
						foreach($customers as $customer)
						{
							$cust_abbr = $customer['id'];
							$data_customer[$cust_abbr] = $customer['first_name'].' '.$customer['last_name'].'';
						}		
						$customer_data = set_value('customer_mail[]');	
						
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
        <div class="form-body">
          <h3 class="form-section"></h3>
          <?php if(validation_errors()){?>
          <div class="alert alert-danger display-hide" style="display: block;">
            <button class="close" data-close="alert"></button>
            You have some form errors. Please check below. </div>
          <?php } ?>
           <input type="hidden" name="couponid" id="couponid" value="<?php echo $coupon_details[0]['coupon_id']?>"  />
          <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                  <label class="control-label">Select Coupon Code Type<span class="required" aria-required="true"> *</span></label>
                 </div>
                 </div>
            <div class="col-md-9">
              <div class="form-group">
                 <label class="radio-inline">
											<?php 
												if($coupon_type == 'peruser')
												{
													$data = array(
													'name' 	=> 'coupon_type',
													'id' 	=> 'coupon_type1',
													'value' => 'peruser',
													'checked'=> true,
													'type'	=> 'radio'
													);
												}else{
													
													$data = array(
													'name' 	=> 'coupon_type',
													'id' 	=> 'coupon_type1',
													'value' => 'peruser',
													'checked'=> false,
													'type'	=> 'radio'
												);
												}
											
								   			 echo form_radio($data)."Per User";
											?>
			
           								</label>
                      <label class="radio-inline">
											<?php 
											if($coupon_type == 'percourse')
												{
													$data = array(
														'name' 	=> 'coupon_type',
														'id' 	=> 'coupon_type2',
														'value' => 'percourse',
														'checked'=> true,
														'type'	=> 'radio'
														);
												}else{
													
												$data = array(
														'name' 	=> 'coupon_type',
														'id' 	=> 'coupon_type2',
														'value' => 'percourse',
														'checked'=> false,
														'type'	=> 'radio'
														);	
											}
								   			 echo form_radio($data)."Per Course";
											?>
											</label>
                             <label class="radio-inline">
											<?php 
											if($coupon_type == 'allcourse')
												{
												$data = array(
													'name' 	=> 'coupon_type',
													'id' 	=> 'coupon_type3',
													'value' => 'allcourse',
													'checked'=> true,
													'type'	=> 'radio'
													);
												}else
												{
													$data = array(
													'name' 	=> 'coupon_type',
													'id' 	=> 'coupon_type3',
													'value' => 'allcourse',
													'checked'=> false,
													'type'	=> 'radio'
													);
												}
								   			 echo form_radio($data)."All Courses";
											?>
											</label>                                                       
              </div>
            </div>
            <!--/span-->
            
            
          </div>
         
          <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                  <label class="control-label">Select Discount Type<span class="required" aria-required="true"> *</span></label>
                 </div>
                 </div>
            <div class="col-md-9">
              <div class="form-group">
                 <label class="radio-inline">
											<?php 
											if($discnt_type == 'percent')
												{
													$data = array(
														'name' 	=> 'discount_type',
														'id' 	=> 'discount_type',
														'value' => 'percent',
														'checked'=> true,
														'type'	=> 'radio'
														);
												}else{
													$data = array(
														'name' 	=> 'discount_type',
														'id' 	=> 'discount_type',
														'value' => 'percent',
														'checked'=> false,
														'type'	=> 'radio'
														);
													
												}
								   			 echo form_radio($data)."% Percentage";
											?>
			
           								</label>
                      <label class="radio-inline">
											<?php 
											if($discnt_type == 'amount')
												{
													$data = array(
														'name' 	=> 'discount_type',
														'id' 	=> 'discount_type',
														'value' => 'amount',
														'checked'=> true,
														'type'	=> 'radio'
														);
												}else{
													
													$data = array(
														'name' 	=> 'discount_type',
														'id' 	=> 'discount_type',
														'value' => 'amount',
														'checked'=> false,
														'type'	=> 'radio'
														);
											 }
								   			 echo form_radio($data)."Amount";
											?>
											</label>
                                                                            
              </div>
            </div>
            <!--/span-->
            
            
          </div>
          <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                  <label class="control-label">Max Redemption Limit<span class="required" aria-required="true"> *</span></label>
                 </div>
                 </div>
            <div class="col-md-9">
              <div class="form-group">
                
                <?php echo form_input($data_coupon_max); ?> <span class="help-block help-block-error" for="coupon_max" style="color:#F30;"><?php echo form_error('coupon_max'); ?></span>
               
              </div>
            </div>
            <!--/span-->
            
            
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Coupon Code<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_coupon_code); ?> <span class="help-block help-block-error" for="coupon_code" style="color:#F30;"><?php echo form_error('coupon_code'); ?></span>
                <label id="err" style="display:none; color:red;">coupon code alresdy exists</label>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Coupon Discount<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_coupon_discnt); ?> <span class="help-block help-block-error" for="coupon_discnt" style="color:#F30;"><?php echo form_error('coupon_discnt'); ?></span> </div>
            </div>
        
            
          </div>
          <!--/row--> 
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Start Date<span class="required" aria-required="true"> *</span></label>
                  <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
				  <input type="text" class="form-control" id="startdate" name="startdate" required="required" readonly value="<?php echo $coupon_details[0]['start_date'];?>" >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>
              </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">End Date<span class="required" aria-required="true"> *</span></label>
                  <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
				  <input type="text" class="form-control" id="enddate" name="enddate" required="required" readonly value="<?php echo $coupon_details[0]['end_date'];?>" >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>
              </div>
            </div>
          </div>
          
          <div class="row" id="cust" style=" <?php if($coupon_type == 'peruser') { echo 'display:blok;"';}{ ?>display:none;" <?php }?>>
              <!--/span-->
              <div class="col-md-12">
                 <div class="form-group">
					 <label class="control-label">Select Customers<span class="required" aria-required="true"> *</span></label>
                   
                  <?php echo form_multiselect('customer_mail[]',$data_customer,explode(',',$coupon_details[0]['user_id']),'id="select2_sample2" class="form-control select2"'); ?>
                      <span class="help-block help-block-error" for="customer_mail" style="color:#F30;"><?php echo form_error('customer_mail[]'); ?></span> 
				 </div>
              </div>
              </div>
          <!--/row--> 
          
           <div id="course" style=" <?php if($coupon_type == 'percourse') { echo 'display:blok;"';}{ ?>display:none;" <?php }?>>
            <h3 class="form-section">Courses</h3>
            <div class="row"> 
            <div class="form-group">
                   <?php 
				    $count = 1;
				    foreach($course_details as $courses)
			        {	
					   if(isset($data_course) && count($data_course) > 0)
					   {
							if($data_course[$courses['course_id']] == $courses['course_id']){
								 $checked = 'checked="checked"';
							}else{
								 $checked = '';
							}
					   }else{
						    $checked = '';
					   }
						
						if($count%10 == 1)
						{
							 echo '<div class="col-sm-6"><ul class="list-unstyled">';
						}
						echo '<li><input type="checkbox" '.$checked.' name="bundle_courses[]" value="'.$courses['course_id'].'" />'.$courses['course_name'].'</li>';
						if ($count%10 == 0)
    					{
							 echo "</ul></div>";
						}
						$count++;	
					}
					if ($count%10 != 1) echo "</ul></div>";
					?>
                </div>
             
                
            </div>
            </div>
        </div>
        <div class="form-actions right">
          <div class="row">
            <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url();?>coupon_con">
              <button type="button" class="btn default">Cancel</button>
              </a> </div>
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
<script>

$( "#coupon_type1" ).click(function() {
	$( "#course" ).hide();
	$( "#cust" ).show();
	});
$( "#coupon_type2" ).click(function() {
	$( "#cust" ).hide();
	$( "#course" ).show();
	});	
	
$( "#coupon_type3" ).click(function() {
	$( "#cust" ).hide();
	$( "#course" ).hide();
	});	
	
	
$( "#coupon_code" ).blur(function() {
  var code=$( "#coupon_code" ).val();
 
  	$.ajax({
				url: SITE_URL+"coupon_con/check_coupon_code/"+code, 
				async:false,
				success: function(result){
					
					if(result == 'true')
					{
					 $("#err").show();
					}
					
				}
			});	
});

</script>