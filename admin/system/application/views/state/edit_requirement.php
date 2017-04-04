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
			echo form_open('state_con/requirement_edit',$attributes);
			
			$reqtitle = set_value('reqtitle');				  
			$data_reqtitle = array(
						  		 'name'         => 'reqtitle',
								  'id'          => 'reqtitle',
								  'value'       => $req_details[0]['requirment_title'],
								  'class'		=> 'form-control',
								  'placeholder' => 'Requirement Title',
								  'required'     =>'required'
								   //'onblur'=>'myFunction()'
								 );
			
			$reqdesc = set_value('reqdesc');
			$data_reqdesc = array(
						  		 'name'         => 'reqdesc',
								  'id'          => 'reqdesc',
								  'value'       => $req_details[0]['requirment_desc'],
								  'rows'        => '5',
      							  'cols'        => '10',
								   'class'		=> 'form-control',
								  'placeholder'		=> 'Requirement Description',
								  'required'     =>'required'
      							
								  );	
								  
			$reqhour = set_value('reqhour');	
			$data_reqhour = array(
						  		 'name'         => 'reqhour',
								  'id'          => 'reqhour',
								  'value'       => $req_details[0]['requirment_hours'],
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Requirement Hour',
								  'required'     =>'required'
								 
								  );
			
			$back_color = set_value('back_color');				  
			$data_back_color = array(
						  		 'name'         => 'back_color',
								  'id'          => 'hue-demo',
								  'data-control' =>"hue",
								  'value'       => $req_details[0]['back_color'],
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
           <input type="hidden" name="stateid" id="stateid" value="<?php echo $stateid;?>" />
            <input type="hidden" name="reqid" id="reqid" value="<?php echo $reqid;?>" />
            <h3 class="form-section"></h3>
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Requirement Title*</label>
                  
                  <?php echo form_input($data_reqtitle); ?>
                   <span class="help-block help-block-error" for="reqtitle" style="color:#F30;"><?php echo form_error('reqtitle'); ?></span>
                   <label id="err" style="display:none;">coupon code alresdy exists</label>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Requirement Hour*</label>
                  <?php echo form_input($data_reqhour); ?>
                  <span class="help-block help-block-error" for="reqhour" style="color:#F30;"><?php echo form_error('reqhour'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Requirement Description*</label>
                 <?php echo form_textarea($data_reqdesc); ?>
                    <span class="help-block help-block-error" for="reqdesc" style="color:#F30;"><?php echo form_error('reqdesc'); ?></span>
                   
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
               <div class="form-group">
                   <label class="col-md-3 control-label">Color</label>
                      <div class="col-md-3">
                           <?php echo form_input($data_back_color); ?> 
                      </div>
                 </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row--> 
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>state_con/manage_requirement/<?php echo $stateid; ?>"><button type="button" class="btn default">Cancel</button></a>
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
