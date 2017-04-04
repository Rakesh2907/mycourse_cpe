<?php //echo "<pre>"; print_r($course_evalution); echo "</pre>";?>
<script src="<?php echo $this->config->item("cdn_css_image")?>js/Chart.min.js"></script> 
<style>
.cr_cir .mng_ch {
  margin-left: -70px;
  position: relative;
}
.cr-graph .cr_cir {
  overflow: hidden;
}
.mng_ch canvas {
  height: 150px !important;
  width: 300px !important;
}
</style>
<?php 
if($rew_success!=''){?>
<script type="text/javascript">
   $('document').ready(function(){
     $("#download_tab").trigger('click');
   });
</script>
<?php } ?> 
<div class="container bd-min-hgt page-content evl-dwn-wrp">
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12"> 
      
      <!-- Wizard Test -->
      <div class="wizard eval-cont">
        <div class="wizard-inner ch-links">
          <ul class="nav-tabs tab-nav list-inline">
            <li class="active"><a data-toggle="tab" href="#eval_Tab">1. Course Evaluation </a></li>
            <li id="mysecondTab"><a data-toggle="tab" href="#dwn_Cert" id="download_tab">2. Download Certificate</a> </li>
          </ul>
        </div>
        <!-- /wizard-inner -->
        
        <div class="tab-content">
          <div class="tab-pane active" role="tabpanel" id="eval_Tab">
          <form class="cust_Form other-spec" method="post" action="">
            <div class="text-section">
              <?php if($rew_success!=''){
			  ?>
                     <div class="alert alert-success fade in">
    					<a href="#" class="close" data-dismiss="alert">&times;</a><?php echo $rew_success;?>
					 </div>
              <?php } ?>
              <h2>Course Evaluation</h2>
              <i><?php echo trim($course_details[0]['course_name']);?></i>
              <p>Thank you for taking our course, <?php echo trim($course_details[0]['course_name']);?>. Please take a moment to offer your feedback on the course. 
                Please rank each item below, with 1 being the lowest score, and 5 being the highest score.</p>
            </div>
            <!-- /text-section -->
            
            <div class="eval-sec-outer">
              <table class="table table-borderless cst-tbl">
                <thead class="hidden-xs">
                <th>AUTHOR AND COURSE CONTENT</th>
                  <th> <ul class="range-label list-unstyled">
                      <li><span>1</span></li>
                      <li><span>2</span></li>
                      <li><span>3</span></li>
                      <li><span>4</span></li>
                      <li><span>5</span></li>
                    </ul>
                  </th>
                  </thead>
                <tbody>
                  <tr>
                    <td class="eval-con-left">Was this course effective?</td>
                    <td class="eval-range-outer"><div class="eval-range-sld">
                        <div class="range-slide" id="eval-slider-1"></div>
                      </div></td>
                      <input type="hidden" name="ques_1" value="1" id="ques_1" />
                  </tr>
                  <tr>
                    <td class="eval-con-left">Were the stated learning objectives met?</td>
                    <td class="eval-range-outer"><div class="eval-range-sld">
                        <div class="range-slide" id="eval-slider-2"></div>
                      </div></td>
                      <input type="hidden" name="ques_2" value="1" id="ques_2" />
                  </tr>
                  <tr>
                    <td class="eval-con-left">Were the stated prerequisite requirements appropriate and sufficient?</td>
                    <td class="eval-range-outer"><div class="eval-range-sld">
                        <div class="range-slide" id="eval-slider-3"></div>
                      </div></td>
                      <input type="hidden" name="ques_3" value="1" id="ques_3" /> 
                  </tr>
                  <tr>
                    <td class="eval-con-left">Were the program materials relevant and did they contribute to the achievement of the learning objectives?</td>
                    <td class="eval-range-outer"><div class="eval-range-sld">
                        <div class="range-slide" id="eval-slider-4"></div>
                      </div></td>
                      <input type="hidden" name="ques_4" value="1" id="ques_4" />
                  </tr>
                  <tr>
                    <td class="eval-con-left">Was the time allotted to the course appropriate?</td>
                    <td class="eval-range-outer"><div class="eval-range-sld">
                        <div class="range-slide" id="eval-slider-5"></div>
                      </div></td>
                      <input type="hidden" name="ques_5" value="1" id="ques_5" />
                  </tr>
                  <tr>
                    <td class="eval-con-left">How likely would you be to recommend CPE Nation to a friend?</td>
                    <td class="eval-range-outer"><div class="eval-range-sld">
                        <div class="range-slide" id="eval-slider-6"></div>
                      </div></td>
                      <input type="hidden" name="ques_6" value="1" id="ques_6" />
                  </tr>
                </tbody>
              </table>
            </div>
            
              <div class="form-group text-area-fld">
                <label class="control-label">Other (please specify)</label>
                <textarea class="form-control" name="comment"><?php if(isset($course_evalution[0]['notes'])){ echo $course_evalution[0]['notes'];}else{ echo '';}?></textarea>
              </div>
              <!-- /form-group -->
              
              <div class="btn-sec text-center">
                 <!-- <a class="btn fad-orange medium" href="#">SUBMIT</a>-->
                  <input type="submit" name="submit" value="SUBMIT" class="btn fad-orange medium"/>
               </div>
            </form>
          </div>
          <!-- /tab-pane -->
          
          <div class="tab-pane dwn_Cert" role="tabpanel" id="dwn_Cert">
            <div class="text-section">
              <h2>Thank you for submitting the course evaluation!</h2>
              <p>Please be sure to follow your <a href="<?php echo base_url()?>/state_con/state_equirement/<?php echo $mystate_id;?>">state requirements</a> for any reporting requirements. You can now download your 
                certificate below, or access it any time in your <a href="<?php echo base_url()?>/mycourses">My Account</a> page.</p>
              <div class="btn-sec">
                 <?php 
               		if($user_course[0]['s3_course_certificate']!='NULL' || $user_course[0]['s3_course_certificate']!='')
			   		{
				 ?>
                 	<a href="<?php echo base_url()?>customer_con/download_awspdf/?file=<?php echo $user_course[0]['s3_course_certificate'];?>&course_name=<?php echo trim($coursename);?>" class="btn fad-orange medium">Download Certificate</a>
                 <?php		
			  		}else{
				?>		
              	<a href="<?php echo base_url()?>customer_con/dowload_pdf/?file=<?php echo $certificate_file;?>" class="btn fad-orange medium">Download Certificate</a>
				<?php } ?>
                </div>
            </div>
            <div class="cr-text-line">This course earned you an additional <span id="addcredit"></span> credits <span id="creditcats"></span><a class="visible-xs" href="#">Go to your credit Tracker.</a></div>
            <div class="row" id="cr_inf">
              <div class="cr-graph">
                <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12 pull-right">
                     <div class="cr_cir">
                        <div class="mng_ch"><canvas id="myChart"></canvas></div>
                     </div>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-8 col-xs-12 pull-left">
                  <div class="cr-track">
                    <ul class="list-unstyled graph-list" id="stae_credit_types">
                      
            
                    </ul>
                  </div>
                  <!-- /cr-track --> 
                </div>
              </div>
            </div>
            <!-- /row --> 
            
          </div>
          <div class="clearfix"></div>
        </div>
        <!-- /tab-content --> 
      </div>
      <!-- /wizard --> 
      <!-- /wizard test --> 
      
    </div>
    <!-- col--> 
    
  </div>
  <!-- /row --> 
</div>
<!-- container -->
<!-- Evaluation Range Slider -->
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery-ui.js"></script>
<script>
$( "#eval-slider-1" ).slider({
    value: '<?php if(isset($course_evalution[0]['ques1'])){ echo $course_evalution[0]['ques1'];}else{ echo '1';}?>',
    min: 1,
    max: 5,
    step: 1,
	change: function(event, ui) {
	  $("#ques_1").val(ui.value);
    }
})
.each(function() {

  //
  // Add labels to slider whose values 
  // are specified by min, max and whose
  // step is set to 1
  //

  // Get the options for this slider
  var opt = $(this).data().uiSlider.options;
  
  // Get the number of possible values
  var vals = opt.max - opt.min;
  // Space out values
  for (var i = 0; i <= vals; i++) {
    
    var el = $('<label>'+(i+1)+'</label>').css('left',(i/vals*100)+'%');
  
    $( "#eval-slider-1" ).append(el);
    
  }
  
});

// 
$( "#eval-slider-2" ).slider({
    value: '<?php if(isset($course_evalution[0]['ques2'])){ echo $course_evalution[0]['ques2'];}else{ echo '1';}?>',
    min: 1,
    max: 5,
    step: 1,
	change: function(event, ui) {
      $("#ques_2").val(ui.value);
    }
})
.each(function() {

  //
  // Add labels to slider whose values 
  // are specified by min, max and whose
  // step is set to 1
  //

  // Get the options for this slider
  var opt = $(this).data().uiSlider.options;
  
  // Get the number of possible values
  var vals = opt.max - opt.min;
  
  // Space out values
  for (var i = 0; i <= vals; i++) {
    
    var el = $('<label>'+(i+1)+'</label>').css('left',(i/vals*100)+'%');
  
    $( "#eval-slider-2" ).append(el);
    
  }
  
});

// 
$( "#eval-slider-3" ).slider({
    value: '<?php if(isset($course_evalution[0]['ques3'])){ echo $course_evalution[0]['ques3'];}else{ echo '1';}?>',
    min: 1,
    max: 5,
    step: 1,
	change: function(event, ui) {
      $("#ques_3").val(ui.value);
    }
})
.each(function() {

  //
  // Add labels to slider whose values 
  // are specified by min, max and whose
  // step is set to 1
  //

  // Get the options for this slider
  var opt = $(this).data().uiSlider.options;
  
  // Get the number of possible values
  var vals = opt.max - opt.min;
  
  // Space out values
  for (var i = 0; i <= vals; i++) {
    
    var el = $('<label>'+(i+1)+'</label>').css('left',(i/vals*100)+'%');
  
    $( "#eval-slider-3" ).append(el);
    
  }
  
});

// 
$( "#eval-slider-4" ).slider({
    value: '<?php if(isset($course_evalution[0]['ques4'])){ echo $course_evalution[0]['ques4'];}else{ echo '1';}?>',
    min: 1,
    max: 5,
    step: 1,
	change: function(event, ui) {
       $("#ques_4").val(ui.value);
    }
})
.each(function() {

  //
  // Add labels to slider whose values 
  // are specified by min, max and whose
  // step is set to 1
  //

  // Get the options for this slider
  var opt = $(this).data().uiSlider.options;
  
  // Get the number of possible values
  var vals = opt.max - opt.min;
  
  // Space out values
  for (var i = 0; i <= vals; i++) {
    
    var el = $('<label>'+(i+1)+'</label>').css('left',(i/vals*100)+'%');
  
    $( "#eval-slider-4" ).append(el);
    
  }
  
});

// 
$( "#eval-slider-5" ).slider({
    value: '<?php if(isset($course_evalution[0]['ques5'])){ echo $course_evalution[0]['ques5'];}else{ echo '1';}?>',
    min: 1,
    max: 5,
    step: 1,
	change: function(event, ui) {
      $("#ques_5").val(ui.value);
    }
})
.each(function() {

  //
  // Add labels to slider whose values 
  // are specified by min, max and whose
  // step is set to 1
  //

  // Get the options for this slider
  var opt = $(this).data().uiSlider.options;
  
  // Get the number of possible values
  var vals = opt.max - opt.min;
  
  // Space out values
  for (var i = 0; i <= vals; i++) {
    
    var el = $('<label>'+(i+1)+'</label>').css('left',(i/vals*100)+'%');
  
    $( "#eval-slider-5" ).append(el);
    
  }
  
});

// 
$( "#eval-slider-6" ).slider({
    value: '<?php if(isset($course_evalution[0]['ques6'])){ echo $course_evalution[0]['ques6'];}else{ echo '1';}?>',
    min: 1,
    max: 5,
    step: 1,
	change: function(event, ui) {
        $("#ques_6").val(ui.value);
    }
})
.each(function() {

  //
  // Add labels to slider whose values 
  // are specified by min, max and whose
  // step is set to 1
  //

  // Get the options for this slider
  var opt = $(this).data().uiSlider.options;
  
  // Get the number of possible values
  var vals = opt.max - opt.min;
  
  // Space out values
  for (var i = 0; i <= vals; i++) {
    
    var el = $('<label>'+(i+1)+'</label>').css('left',(i/vals*100)+'%');
  
    $( "#eval-slider-6" ).append(el);
    
  }
  
});
</script>
<script type="text/javascript">
   var sel_state_id = '<?php echo $mystate_id;?>';
   var courses = '<?php echo $course_id;?>';
   
   $("#mysecondTab").click(function(){
	    $.ajax({
			  url: base_url+'bundle_con/get_type_credits',
			  dataType: 'json',
			  type: 'POST',
			  data: {
        					stateid: sel_state_id,
							bundle_courses: courses,
							evalution: 1,
							user_course_id: <?php echo $user_course_id?>
    		  	}
			}).done(function(response) {
				$('#credit_types').html('');
				if(response['sucess'] =='True'){
						 $('#stae_credit_types').html();
							$('#credit_types').html(response['html']);
							
							$('#stae_credit_types').html(response['trackhtml']);
							$('#addcredit').html(response['addcredit']);
							if(response['creditcats'] != false)
							{
								$('#creditcats').html('in '+response['creditcats']);
							}
							
							$('#cr_inf').show();
							if(response['addcredit'] == 0)
							{
								
								$('.cr-text-line').hide();
							}
							
				}else{
							$('#credit_types').html('<li>No credits are found</li>');
				}
		    });
   });
   
   
</script>
<!-- Evaluation Range Slider Close -->