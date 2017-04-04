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
//echo "<pre>";print_r($chapter_quest_details);die;
$correct=$chapter_quest_details[0]['rev_correct_ans_id']
?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
                 <h4 class="form-section">Question Title111</h4>
                 <div class="row">
                 <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $chapter_quest_details[0]['rev_ques_title']; ?>
                </div>
                </div>
            </div>
            <h4 class="form-section">Answers</h4>
                 <div class="row">
                 <div class="col-md-6">
                  <div class="form-group">
                  <label class="control-label"><i class="fa <?php echo ($correct == 1 ? 'fa-check' : 'fa-times');?>"></i></label>
                  <?php echo $chapter_quest_details[0]['rev_ques_ans_1']; ?>
                   
                </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                  <div class="form-group">
                  <label class="control-label"><i class="fa <?php echo ($correct == 2 ? 'fa-check' : 'fa-times');?>"></i></label>
                  <?php echo $chapter_quest_details[0]['rev_ques_ans_2']; ?>
                   
                </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                  <div class="form-group">
                  <label class="control-label"><i class="fa <?php echo ($correct == 3 ? 'fa-check' : 'fa-times');?>"></i></label>
                  <?php echo $chapter_quest_details[0]['rev_ques_ans_3']; ?>
                   
                </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                  <div class="form-group">
                  <label class="control-label"><i class="fa <?php echo ($correct == 4 ? 'fa-check' : 'fa-times');?>"></i></label>
                  <?php echo $chapter_quest_details[0]['rev_ques_ans_4']; ?>
                  
                </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                  <div class="form-group">
                  <label class="control-label"><i class="fa <?php echo ($correct == 5 ? 'fa-check' : 'fa-times');?>"></i></label>
                  <?php echo $chapter_quest_details[0]['rev_ques_ans_5']; ?>
                   
                </div>
                </div>
            </div>
            
                 <!--<h4 class="form-section">Correct Answer</h4>-->
                 <div class="row">
                 <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php //echo $chapter_quest_details[0]['rev_correct_ans_text']; ?>
                </div>
                </div>
                
              </div>
              <!-- <h4 class="form-section">Wrong Answer</h4>-->
                 <div class="row">
                 <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php //echo $chapter_quest_details[0]['rev_wronge_ans_text']; ?>
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
