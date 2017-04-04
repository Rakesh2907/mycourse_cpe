<style>
.modal-open .modal.cst-flat-popup::after {
  background-color: rgba(74, 73, 74, 0.78);
  content: "";
  display: block;
  height: 100%;
  left: 0;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: -1;
}
.exam-result {
  margin-top: 75px;
}
/*.modal-backdrop.in {
 display:none;
}*/
</style>
<div class="container page-content bd-min-hgt crs-rev-wrp exam-outer">
  <div class="go-back col-lg-offset-1"> <a href="<?php echo base_url()?>take-course/<?php echo $user_course_id;?>">Back</a> </div>
  <!-- /back-course -->
  
  <div class="row">
    <div class="col-lg-9 col-lg-offset-2 col-md-10 col-md-offset-1 cours-rev-que">
      <div class="rev-head">
        <h3>FINAL EXAM</h3>
        <h4><?php echo trim($course_details[0]['course_name']);?></h4>
        <div class="exam-instr">This exam requires a grade of <?php echo trim($course_details[0]['passing_grade']);?>% or higher to receive credit.</div>
      </div>
      <!-- /rev-head  -->
      <?php 
	     if(count($course_exam) > 0)
	     {
	  ?>
      <form method="post" action="">
      <ul class="que-list list-unstyled">
        <?php 
		  $i = 1;
		  foreach($course_exam as $key => $exams_que)
		  { 
			?>
            <li id="<?php echo $exams_que['ques_id'];?>">
              <div class="que-tst"><?php echo $i;?>. <?php echo trim($exams_que['ques_title']);?></div>
              <?php
			       if($exams_que['s3_images']!='' ||  $exams_que['s3_images']!='')
				   {
			  ?>
              	   <div class="que-img"><img src="<?php echo $exams_que['s3_images'] ;?>" alt="Questions" /></div>	 
              <?php		   
				   }else if($exams_que['question_image'] !=''){?>
               <div class="que-img"><img src="<?php echo $this->config->item("upload_path").'question/'.$exams_que['question_image'] ;?>" alt="Questions" /></div>
               <?php }?>
                  <ul class="ans-option list-unstyled">
                    <?php if(isset($exams_que['ques_ans_1']) && $exams_que['ques_ans_1']!=''){?>
                    <li>
                      <input type="radio" name="radiog_dark[<?php echo $exams_que['ques_id'];?>]" id="ans1ques_<?php echo $exams_que['ques_id'];?>" class="css-checkbox" value="1">
                      
                      <label for="ans1ques_<?php echo $exams_que['ques_id'];?>" class="css-label"><?php echo $exams_que['ques_ans_1'];?></label>
                    </li>
                    <?php } ?>
                    <?php if(isset($exams_que['ques_ans_2']) && $exams_que['ques_ans_2']!=''){?>
                    <li>
                      <input type="radio" name="radiog_dark[<?php echo $exams_que['ques_id'];?>]" id="ans2ques_<?php echo $exams_que['ques_id'];?>" class="css-checkbox" value="2">
                      <label for="ans2ques_<?php echo $exams_que['ques_id'];?>" class="css-label"><?php echo $exams_que['ques_ans_2'];?></label>
                    </li>
                    <?php } ?>
                    <?php if(isset($exams_que['ques_ans_3']) && $exams_que['ques_ans_3']!=''){?>
                    <li>
                      <input type="radio" name="radiog_dark[<?php echo $exams_que['ques_id'];?>]" id="ans3ques_<?php echo $exams_que['ques_id'];?>" class="css-checkbox"  value="3">
                      <label for="ans3ques_<?php echo $exams_que['ques_id'];?>" class="css-label"><?php echo $exams_que['ques_ans_3'];?></label>
                    </li>
                     <?php } ?>
                     <?php if(isset($exams_que['ques_ans_4']) && $exams_que['ques_ans_4']!=''){?>
                    <li>
                      <input type="radio" name="radiog_dark[<?php echo $exams_que['ques_id'];?>]" id="ans4ques_<?php echo $exams_que['ques_id'];?>" class="css-checkbox"  value="4">
                      <label for="ans4ques_<?php echo $exams_que['ques_id'];?>" class="css-label"><?php echo $exams_que['ques_ans_4'];?></label>
                    </li>
                     <?php } ?>
                     <?php if(isset($exams_que['ques_ans_5']) && $exams_que['ques_ans_5']!=''){?>
                    <li>
                      <input type="radio" name="radiog_dark[<?php echo $exams_que['ques_id'];?>]" id="ans5ques_<?php echo $exams_que['ques_id'];?>" class="css-checkbox"  value="5">
                      <label for="ans5ques_<?php echo $exams_que['ques_id'];?>" class="css-label"><?php echo $exams_que['ques_ans_5'];?></label>
                    </li>
                     <?php } ?>
                  </ul>
            </li>
      <?php
	      $i = $i + 1;
		  }
	  ?>
        </ul>
        
      <?php 	  
	   }else{
	  } ?>
      <!-- /que-list -->
      
      <div class="chapt-action text-center"> <!--<a href="#" data-toggle="modal" data-target="#exm-Res" class="btn fad-orange medium md-lg">Submit</a>-->
         <input type="submit" value="Submit" name="submit" class="btn fad-orange medium md-lg"/>
      </div>
      <!-- /chapt-action --> 
      </form>
    </div>
    <!-- col --> 
    
  </div>
  <!-- /row --> 
</div>

<?php 
 if($examResult == 'success') {
?>

<!-- Modal -->
<div id="pass-Res" class="modal fade cst-flat-popup" role="dialog">
  <div class="modal-dialog mdl-cs-wd exam-result">
    <!-- Modal content-->
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center"><span class="">CONGRATULATIONS!</span></h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
    <div class="text-content">
   <div class="fst-line"> <div class="st-line">You scored <?php echo round($passingPercentage); ?>% on the final exam, you have successfully passed!</div>   </div>
    <p>Continue to the course evaluation, so you can receive your certificate.</p>
   
    </div>
<div class="btn-sec text-center">
<a class="btn grey-green medium" href="<?php echo base_url()?>course-evalution/<?php echo $user_course_id;?>">COURSE EVALUATION</a><br>
</div>
</div>
</div>
</div>
</div>
<script>
    $('document').ready(function(){
		
		$.ajax({
			url: base_url+'customer_con/certificate_upload_aws',
			  dataType: 'html',
			  type: 'POST',
			  data: {
        					user_course_id: '<?php echo $user_course_id;?>',
    		  	}
		}).done(function(response) {
			  $('#pass-Res').modal({
 			  backdrop: false,
  			  show: true
			});
		});
		
	});
</script>
<?php }else if($examResult == 'failed'){ ?>
<div id="fail-Res" class="modal fade cst-flat-popup" role="dialog">
  <div class="modal-dialog mdl-cs-wd exam-result">
    <!-- Modal content-->
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center">EXAM FAILED!</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
    <div class="text-content">
    <div class="fst-line"><p>You scored <span class="bld"><?php echo round($passingPercentage); ?>%</span> on the final exam. Unfortunately, you have failed.</p></div>
    <div class="st-line">Please review the course material and try again!</div>
    </div>
<div class="btn-sec text-center">
<a class="btn fad-orange medium" href="javascript:void(0)" onClick="remove_popup()">TRY AGAIN</a><br>
<p><a class="rev-crs" href="<?php echo base_url()?>take-course/<?php echo $user_course_id;?>">Review Course Materials</a></p>
</div>



      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  $('document').ready(function(){
	   $('#fail-Res').modal({
	  backdrop: false,
	  show: true
	});
  });
   function remove_popup()
   {
		$('#fail-Res').modal('hide');
   }
</script>
<?php } ?>