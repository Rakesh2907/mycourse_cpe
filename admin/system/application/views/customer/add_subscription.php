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
			echo form_open('customer_con/add_subscription_order',$attributes);
		
			$data_amount = array(
						  		 'name'         => 'amount',
								  'id'          => 'amount',
								   'class'		=> 'form-control',
								  'placeholder'		=> '',
								  'required'     =>'required'
      							
								  );	
		    $data_subs = array();
			$data_subs[''] = '--Select Subscription --';
			foreach($course_details as $course)
			{
				$course_id = $course['subscription_id'];
				$data_subs[$course_id] = $course['title'];
			}		
			$course_data = set_value('course_id');	
			
			
								  
								  			  
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
                   <label class="control-label">Subscription <span class="required" aria-required="true"> *</span></label>
                     <?php echo form_dropdown('course_id',$data_subs,$course_data,'class="select2_category form-control cd" tabindex="0" required="required"');?>
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
                  <label class="control-label">Amount<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_amount); ?>
                    <span class="help-block help-block-error" for="amount" style="color:#F30;"><?php echo form_error('amount'); ?></span>
                </div>
              </div>
            </div>
            <!--/row-->
            
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>customer_con/custome_orders/<?php echo $userid;; ?>"><button type="button" class="btn default">Cancel</button></a>
                  </div>
              <div class="col-md-6"> </div>
            </div>
          </div>
           <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>" />
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
$( ".cd" ).change(function() {
  var courseid=$( ".cd" ).val();
 
  	$.ajax({
				url: SITE_URL+"customer_con/get_subscription_amount/"+courseid, 
				async:false,
				success: function(result){
					
					if(result != '')
					{
					  $( "#amount" ).val(result);
					}
					
				}
			});	
});

</script>