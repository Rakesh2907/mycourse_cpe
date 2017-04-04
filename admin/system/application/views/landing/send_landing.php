<?php ob_start();
$landing_url = $this->config->item('front_url');
$code =md5($bundle_details[0]['bundle_id']);
?>
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

          <div class="form-body">
          <input type="hidden" name="bid" id="bid" value="<?php echo $bundle_details[0]['bundle_id'];?>"  />
          <input type="hidden" name="expiry_date" id="expiry_date" value="<?php echo $bundle_details[0]['end_date'];?>"  />
            <?php if($err_msg !=''){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    <?php echo $err_msg; ?>
                </div>
            <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Bundle Name</label>
                  <?php echo $bundle_details[0]['bundle_name'];?>
                  
                   <span class="help-block help-block-error" for="course_name" style="color:#F30;"><?php echo form_error('bundle_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Bundle Price</label>
                      <?php echo $bundle_details[0]['bundle_price'];?>
                      <span class="help-block help-block-error" for="course_price" style="color:#F30;"></span>  
                   </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
            
            <!--/row-->
            
            <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">States</label>
                   <?php echo $bundle_details[0]['state'];?> 
                     <span class="help-block help-block-error" for="prerequisites" style="color:#F30;"></span> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">End Date</label>
                      <?php echo date("Y-m-d",strtotime($bundle_details[0]['end_date']));?> 
                </div>
              </div>
            </div>
            
             <div class="row">
              <!--/span-->
              <div class="col-md-12">
                 <div class="form-group">
					 <label class="control-label">Landing URL</label>
                     <a href="<?php echo $landing_url.'compliance-landing/'.$code; ?>"><?php echo $landing_url.'compliance-landing/'.$code; ?></a>
				 </div>
              </div>
              </div>
              
              
           
          </div>
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                 
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
   function getstatecourse(elm)
   {
	   //alert($(elm).val());
   }
</script>
<?php ob_end_flush();?>