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
//echo "<pre>";print_r($order);die;
//$correct=$order_details[0]['order_status']
?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
      
             <div class="row">
                 <div class="col-md-4">
                 <b>Course Name</b>
                  <div class="form-group">
                </div>
                </div>
                <div class="col-md-4">
                   <b>Course Type</b>
                  <div class="form-group">
                </div>
                </div>
                  <div class="col-md-4">
                   <b>Course Amount</b>
                  <div class="form-group">
                </div>
                </div>
            </div>
          <?php 
			
				$count_order = count($order);
				if($count_order > 0)
				{ 
				  foreach($order as $row )
				  {
			?>
            <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                  <?php echo $row['name'];?> 
                </div>
                
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                  <?php echo $row['type'];?> 
                </div>
                
                </div>
                  <div class="col-md-4">
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
