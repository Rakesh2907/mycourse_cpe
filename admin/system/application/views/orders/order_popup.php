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
$correct=$order_details[0]['order_status']
?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
                
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">User Name</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php //echo $order_details[0]['first_name']; ?>
                  <?php echo ucfirst($order_details[0]['first_name'])." ".ucfirst($order_details[0]['last_name']);?>
                </div>
                </div>
                <div class="col-md-6">
                <h4 class="form-section">Order Number</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $order_details[0]['order_number']; ?>
                </div>
                </div>
            </div>
           
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">Order Total</h4>
                  <div class="form-group">
                  <?php echo $order_details[0]['final_total']; ?>
                   
                </div>
                </div>
                <div class="col-md-6">
                  <h4 class="form-section">Order Date</h4>
                  <div class="form-group">
                  <?php echo $order_details[0]['order_date']; ?>
                   
                </div>
                </div>
            </div>
            	 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">Trans No</h4>
                  <div class="form-group">
                  <?php echo $order_details[0]['txn_number']; ?>
                   
                </div>
                </div>
                <div class="col-md-6">
                  <h4 class="form-section">Order Status</h4>
                  <div class="form-group">
                  <?php echo $order_details[0]['order_status']; ?>
                   
                </div>
                </div>
            </div>
         <h4 class="form-section"><b>Purchased Details</b></h4>
             <div class="row">
                 <div class="col-md-6">
                 <b>Purchased Item</b>
                  <div class="form-group">
                </div>
                </div>
                  <div class="col-md-6">
                   <b>Purchased Amount</b>
                  <div class="form-group">
                </div>
                </div>
            </div>
          <?php 
			
				$count_course = count($order_course);
				if($count_course > 0)
				{ 
				  foreach($order_course as $row )
				  {
			?>
            <div class="row">
                 <div class="col-md-6">
                  <div class="form-group">
                  <?php echo $row['course_name'];?> 
                </div>
                </div>
                  <div class="col-md-6">
                  <div class="form-group">
                   <?php echo $row['course_amount'];?>
                </div>
                </div>
            </div>
            
             <?php
				 }
			}?>
				</div>
                </div>
		</div>
		</div>
	
<link href="<?php echo base_url();?>assets/admin/layout/css/custom1.css" rel="stylesheet" type="text/css"/>
<!--<script src="<?php //echo AL_ASSETS_ADMIN ; ?>pages/scripts/appt_popup.js" type="text/javascript"></script>
<script src="<?php //echo AL_ASSETS_ADMIN ; ?>pages/scripts/table-simple-pagination.js" type="text/javascript"></script>-->
