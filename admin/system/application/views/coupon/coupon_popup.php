<?php 
/*
###################################################################
# eLuminous Technologies - Copyright (C) http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
###################################################################
# Name 		 : appt_popup.php
# Created on : 8th Aug 2016 shailesh khairnar
# Update on	 : 
# Purpose 	 : View question details.
*/ 
#############################################################################
  //ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
//echo "<pre>";print_r($arrLeadDetail);
//echo "1111<pre>";print_r($course);die;
$correct=$coupon_details[0]['coupon_status']

?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
                
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">Coupon Code</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $coupon_details[0]['coupon_code']; ?>
                </div>
                </div>
                <div class="col-md-6">
                <h4 class="form-section">Coupon Type</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo ucfirst($coupon_details[0]['coupon_type']); ?>
                </div>
                </div>
           
            </div>
            
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">Discount</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $coupon_details[0]['coupon_discount']; ?>
                </div>
                </div>
                <div class="col-md-6">
                <h4 class="form-section">Discount Type</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo ucfirst($coupon_details[0]['discount_type']); ?>
                </div>
                </div>
           
            </div>
            
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">Start Date</h4>
                  <div class="form-group">
                  <?php echo $coupon_details[0]['start_date']; ?>
                   
                </div>
                </div>
                <div class="col-md-6">
                  <h4 class="form-section">End Date</h4>
                  <div class="form-group">
                  <?php echo $coupon_details[0]['end_date']; ?>
                   
                </div>
                </div>
                
            </div>
        
            <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">Max Redemption Limit</h4>
                  <div class="form-group">
                  <?php echo $coupon_details[0]['max_redemption']; ?>
                   
                </div>
                </div>
                <div class="col-md-6">
                  <h4 class="form-section">Coupon Status</h4>
                  <div class="form-group">
                  <?php echo ucfirst($coupon_details[0]['coupon_status']); ?>
                   
                </div>
                </div>
                
            </div>
            
            <?php if(count( $course) > 0){ 
			?>
             <h4 class="form-section">Course Names</h4>
			
			<?php foreach($course as $courseid )
			 {
			?>
            
            <div class="row">
                 <div class="col-md-6">
                 
                  <div class="form-group">
                  <?php echo $courseid['course_name']; ?>
                   
                </div>
                </div>
                
            </div>
            
            <?php } }?>
            
             <?php if(count( $users) > 0){ 
			?>
             <h4 class="form-section">Customers Names</h4>
			
			<?php foreach($users as $userdetails )
			 {
			?>
            
            <div class="row">
                 <div class="col-md-6">
                 
                  <div class="form-group">
                  <?php echo ucfirst($userdetails['first_name']).' '.ucfirst($userdetails['last_name']); ?>
                   
                </div>
                </div>
                
            </div>
            
            <?php } }?>
				</div>
                </div>
		</div>
		</div>
	
<link href="<?php echo base_url();?>assets/admin/layout/css/custom1.css" rel="stylesheet" type="text/css"/>
<!--<script src="<?php //echo AL_ASSETS_ADMIN ; ?>pages/scripts/appt_popup.js" type="text/javascript"></script>
<script src="<?php //echo AL_ASSETS_ADMIN ; ?>pages/scripts/table-simple-pagination.js" type="text/javascript"></script>-->
