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
//echo "<pre>";print_r($page_details);die;
$correct=$page_details[0]['page_status']
?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
                 <h4 class="form-section">Page Title</h4>
                 <div class="row">
                 <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $page_details[0]['page_title']; ?>
                </div>
                </div>
            </div>
            <h4 class="form-section">Page Description</h4>
                 <div class="row">
                 <div class="col-md-12">
                  <div class="form-group">
                  <?php echo $page_details[0]['page_desc']; ?>
                   
                </div>
                </div>
            </div>
         <h4 class="form-section">Page Status</h4>
            <div class="row">
                 <div class="col-md-12">
                  <div class="form-group">
                  <?php echo $page_details[0]['page_status']; ?>
                   
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
