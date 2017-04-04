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
//echo "<pre>";print_r($state_details);die;
?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
                
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">State Name</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $state_details[0]['state']." (".$state_details[0]['state_abbr'].")"; ?>
                </div>
                </div>
                <div class="col-md-6">
                <h4 class="form-section">State Description</h4>
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $state_details[0]['state_desc']; ?>
                </div>
                </div>
            </div>
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">State Contact</h4>
                  <div class="form-group">
                  <?php echo $state_details[0]['state_phone']; ?>
                   
                </div>
                </div>
                <div class="col-md-6">
                  <h4 class="form-section">State Faxs</h4>
                  <div class="form-group">
                  <?php echo $state_details[0]['state_fax']; ?>
                   
                </div>
                </div>
                
            </div>
                 <div class="row">
                 <div class="col-md-6">
                  <h4 class="form-section">State Contact Address</h4>
                  <div class="form-group">
                  <?php echo nl2br($state_details[0]['state_contact']); ?>
                </div>
                </div>
                    <div class="col-md-6">
                  <h4 class="form-section">State Website</h4>
                  <div class="form-group">
                  <?php echo nl2br($state_details[0]['state_website']); ?>
                </div>
                </div>
                
            </div>
            
				</div>
                </div>
		</div>
		</div>
	
<link href="<?php echo base_url();?>assets/admin/layout/css/custom1.css" rel="stylesheet" type="text/css"/>
<!--<script src="<?php //echo AL_ASSETS_ADMIN ; ?>pages/scripts/appt_popup.js" type="text/javascript"></script>
<script src="<?php //echo AL_ASSETS_ADMIN ; ?>pages/scripts/table-simple-pagination.js" type="text/javascript"></script>-->
