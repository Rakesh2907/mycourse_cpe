<div class="container page-content bd-min-hgt crs-rev-wrp">
    <div class="go-back"> <a href="<?php echo base_url()?>take-course/<?php echo $user_course_id?>">BACK TO COURSE</a> <span class="save-inst">(Your answers will be saved)</span> </div>
    <!-- /back-course -->
    
    <div class="row">
      <div class="col-sm-12 col-md-8 col-md-offset-2">
        <div class="rev-head">
          <h3><?php echo trim($course_details[0]['course_name']);?></h3>
          <h4>Review Questions</h4>
        </div>
        <!-- /rev-head  --> 
      </div>
      <!-- /col --> 
    </div>
    <!-- row -->
    
    <div class="row">
      <div class="col-sm-2 chp-list-sec">
        <ul class="list-unstyled chapt_list">
         <?php 
	         
	       //Tony changed this to automatically scale between 0% opacity and 100%, so we don't have to pick each color for each chapter.
	       $num_chapters = count($course_chapters);
	       if($num_chapters > 0){
		      $color_stop = 1 / $num_chapters;
		      }
		      $i = 1;
  
	         
		   foreach($course_chapters as $key => $chapter)
		   {         
			  
			  $arofChapters[] = $chapter['chapter_id'];
				
		      $count_ques[$chapter['chapter_id']] = count($this->course_mod->get_chapter_questions($chapter['chapter_id'],$course_id));
			  
			  $count_ans[$chapter['chapter_id']] = count($this->customer_mod->get_review_answers($chapter['chapter_id'],$user_course_id,$cuserid,$course_id));
			
			  if(isset($chapter['back_color']) && $chapter['back_color']!='')
			  {
			      $style = 'style="border-color:rgba(239,148,108,'.round(($color_stop * $i),2).')"';
			  }else{
				  $style = '';  
			  }
			  
			  if($chapter['chapter_id'] == $current_chapter)
			  {
			      $active = 'active';
			  }else{
			     
			      $active = '';
			  }
			  
			  if($count_ans[$chapter['chapter_id']] == $count_ques[$chapter['chapter_id']])
			  {
				  $class = "complete";
			  }else{
				  $class = "";
			  }
			 
		 ?>
          <li class="ch_1 <?php echo $active;?> <?php echo $class;?>">
            <div class="chp_head" <?php echo $style;?>><a href="<?php echo base_url()?>start-review/<?php echo $user_course_id?>/?chapter_id=<?php echo $chapter['chapter_id'];?>"><?php echo $chapter['chapter_name'];?></a></div>
          </li>
          <?php 
	          $i++;
	          }
		     $currentPosition = array_search($current_chapter,$arofChapters);
			 $nextChapter = $arofChapters[$currentPosition+1];
			 $prevChapter = $arofChapters[$currentPosition-1];
			//echo $currentPosition.'=>'.$nextChapter.'==>'.$prevChapter;
		  ?>
        </ul>
      </div>
      <!-- /col -->
      
      <div class="col-md-8 col-sm-10 cours-rev-que">
        <ul class="que-list list-unstyled">
          <?php 
		    $i = 1;
			
		    foreach($chapter_questions as $qusKey => $chap_ques)
		    {
				
		   ?>
          <li id="<?php echo $chap_ques['rev_ques_id'];?>">
            <div class="que-tst"><?php echo $i;?>.&nbsp;<?php echo trim($chap_ques['rev_ques_title']);?></div>
            <ul class="ans-option list-unstyled">
              <?php 
			  if(isset($chap_ques['rev_ques_ans_1']) && $chap_ques['rev_ques_ans_1']!='')
			  {   
			  ?>
              <li>
                <div id="ans1content_<?php echo $chap_ques['rev_ques_id'];?>">
                    <input type="radio" name="radiog_dark_<?php echo $chap_ques['rev_ques_id'];?>" id="ans1_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-checkbox">
                    <label for="ans1_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-label"><?php echo trim($chap_ques['rev_ques_ans_1']);?></label>
                </div>
                <?php
				     if(trim($chap_ques['rev_ques_ans_'.$chap_ques['rev_correct_ans_id'].'']) == trim($chap_ques['rev_ques_ans_1']))
					 {
				?>
                        <div id="ans1text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler correct-ans" style="display:none" data-correct="<?php echo $chap_ques['rev_correct_ans_id']?>"><?php echo trim($chap_ques['ans1_text']);?></div>
                <?php 
					 }else{
				?>
                		<div id="ans1text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler wrong-ans" style="display:none"><?php echo trim($chap_ques['ans1_text']);?></div>
                <?php		 
					 } 
				?>
               
              </li> 
              <?php } ?>
              <?php if(isset($chap_ques['rev_ques_ans_2']) && $chap_ques['rev_ques_ans_2']!=''){
				     
			  ?> 
              <li>
                 <div id="ans2content_<?php echo $chap_ques['rev_ques_id'];?>">
                	<input type="radio" name="radiog_dark_<?php echo $chap_ques['rev_ques_id'];?>" id="ans2_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-checkbox">
                    <label for="ans2_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-label"><?php echo trim($chap_ques['rev_ques_ans_2']);?></label>
                 </div>
                 <?php
				     if(trim($chap_ques['rev_ques_ans_'.$chap_ques['rev_correct_ans_id'].'']) == trim($chap_ques['rev_ques_ans_2']))
					 {
				 ?>
                 		 <div id="ans2text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler correct-ans" style="display:none" data-correct="<?php echo $chap_ques['rev_correct_ans_id']?>"><?php echo trim($chap_ques['ans2_text']);?></div>
                 <?php 		 
					 }else{
				 ?>
                 		  <div id="ans2text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler wrong-ans" style="display:none"><?php echo trim($chap_ques['ans2_text']);?></div>
                 <?php		 
					 } 
				 ?>
              </li>    
                <!-- /ans-aler -->
              <?php } ?>
              <?php if(isset($chap_ques['rev_ques_ans_3']) && $chap_ques['rev_ques_ans_3']!=''){?> 
                  <li>
                       <div id="ans3content_<?php echo $chap_ques['rev_ques_id'];?>">
                        <input type="radio" name="radiog_dark_<?php echo $chap_ques['rev_ques_id'];?>" id="ans3_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-checkbox">
                        <label for="ans3_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-label"><?php echo trim($chap_ques['rev_ques_ans_3']);?></label>
                       </div> 
                     <?php
				     if(trim($chap_ques['rev_ques_ans_'.$chap_ques['rev_correct_ans_id'].'']) == trim($chap_ques['rev_ques_ans_3']))
					 {
				 ?>
                 		<div id="ans3text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler correct-ans" style="display:none" data-correct="<?php echo $chap_ques['rev_correct_ans_id']?>"><?php echo trim($chap_ques['ans3_text']);?></div>
                 <?php 		 
					 }else{
				 ?>
                        <div id="ans3text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler wrong-ans" style="display:none"><?php echo trim($chap_ques['ans3_text']);?></div>
                 <?php		 
					 } 
				 ?>   
                  </li>
              <?php } ?>
              <?php if(isset($chap_ques['rev_ques_ans_4']) && $chap_ques['rev_ques_ans_4']!=''){?> 
                  <li>
                       <div id="ans4content_<?php echo $chap_ques['rev_ques_id'];?>">
                        <input type="radio" name="radiog_dark_<?php echo $chap_ques['rev_ques_id'];?>" id="ans4_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-checkbox">
                        <label for="ans4_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-label"><?php echo trim($chap_ques['rev_ques_ans_4']);?></label>
                       </div> 
                    <?php
				     if(trim($chap_ques['rev_ques_ans_'.$chap_ques['rev_correct_ans_id'].'']) == trim($chap_ques['rev_ques_ans_4']))
					 {
				 ?>
                 		<div id="ans4text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler correct-ans" style="display:none" data-correct="<?php echo $chap_ques['rev_correct_ans_id']?>"><?php echo trim($chap_ques['ans4_text']);?></div>
                 <?php 		 
					 }else{
				 ?>
                        <div id="ans4text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler wrong-ans" style="display:none"><?php echo trim($chap_ques['ans4_text']);?></div>
                 <?php		 
					 } 
				 ?>  
                  </li>
               <?php } ?>
               <?php if(isset($chap_ques['rev_ques_ans_5']) && $chap_ques['rev_ques_ans_5']!=''){?> 
                  <li>
                    <div id="ans5content_<?php echo $chap_ques['rev_ques_id'];?>">
                    <input type="radio" name="radiog_dark_<?php echo $chap_ques['rev_ques_id'];?>" id="ans5_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-checkbox">
                    <label for="ans5_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="css-label"><?php echo trim($chap_ques['rev_ques_ans_5']);?></label>
                    </div>
                    
                    <?php
				     if(trim($chap_ques['rev_ques_ans_'.$chap_ques['rev_correct_ans_id'].'']) == trim($chap_ques['rev_ques_ans_5']))
					 {
				   ?>
                   			 <div id="ans5text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler correct-ans" style="display:none" data-correct="<?php echo $chap_ques['rev_correct_ans_id']?>"><?php echo trim($chap_ques['ans5_text']);?></div>
					 <?php 		 
                         }else{
                     ?>
                     	 	 <div id="ans5text_reviewid_<?php echo $chap_ques['rev_ques_id'];?>" class="ans-aler wrong-ans" style="display:none"><?php echo trim($chap_ques['ans5_text']);?></div>
					 <?php		 
                         } 
                     ?>
                  </li>
              <?php } ?>  
            </ul>
          </li>
          <!-- /li -->
          <?php
		      $i = $i + 1;
		   } ?> 
        </ul>
        <!-- /que-list -->
        
        <div class="chapt-action">
          <?php if($currentPosition != 0){?>
          	 <div class="pull-left prev-chp"><a href="<?php echo base_url()?>start-review/<?php echo $user_course_id?>/?chapter_id=<?php echo $prevChapter;?>">Previous Chapter</a></div>
          <?php } ?> 
          <?php if($nextChapter != 0 || $nextChapter != ''){?> 
          <a href="<?php echo base_url()?>start-review/<?php echo $user_course_id?>/?chapter_id=<?php echo $nextChapter;?>" class="btn fad-orange medium md-lg pull-right">NEXT CHAPTER</a> 
          <?php }else{?>
	      <a href="<?php echo base_url()?>take-course/<?php echo $user_course_id?>" class="btn fad-orange medium md-lg pull-right complete-review" style="display: none;">COMPLETE REVIEW</a>   
          <?php } ?>
          </div>
        <!-- /chapt-action --> 
        
      </div>
      <!-- col --> 
      
    </div>
    <!-- /row --> 
  </div>
<script type="text/javascript">
 $('document').ready(function(){
	   var review_progress_id = '<?php echo $review_progress_id;?>';
	   var login_user_id = '<?php echo $cuserid;?>';
	   var user_course_id = '<?php echo $user_course_id?>';
	   
	   $.ajax({
		   url: base_url+'customer_con/get_review_correct_ans',
		   dataType: 'html',
		   type: 'POST',
		   data: {
			   user_course_id: user_course_id,
			   chapter_id: '<?php echo $current_chapter?>'
		   }
	   }).done(function(response) {
			   var obj = jQuery.parseJSON(response);
			   for(var k = 0;k < obj.length; k++)
			   {
				  //alert('inn111');
				  $("#ans"+obj[k].answer_id+"_reviewid_"+obj[k].question_id).prop('checked',true);
				  $("#ans"+obj[k].answer_id+"text_reviewid_"+obj[k].question_id).show();
			   }
	   });
	   
	   
	   $('.ans-option li input[type=radio]').click(function()
	   {
						    var text_id = $(this).attr('id').split('_')[0];
							var review_id =  $(this).attr('id').split('_')[2];
							
							   $('.wrong-ans').hide();
							   //$('.correct-ans').hide();
							   if($('#'+$(this).attr('id')).is(':checked'))
							   {   
							         //console.log('here111'); 
									$('#'+text_id+'text_reviewid_'+review_id).css('display','block');
									if($('#'+text_id+'text_reviewid_'+review_id).attr('data-correct'))
									{
										var correct_ans_id = $('#'+text_id+'text_reviewid_'+review_id).attr('data-correct'); 
										if(review_progress_id!=0)
										{
											insert_answer(review_progress_id,review_id,correct_ans_id,login_user_id,user_course_id);
										}
									}
							   }
					        
	   });
	   function insert_answer(review_progress_id,review_id,correct_ans_id,login_user_id,user_course_id)
	   {
		    var chapter_id = '<?php echo $_REQUEST['chapter_id'] ?>'
		     $.ajax({
			  url: base_url+'customer_con/review_correct_ans',
			  dataType: 'html',
			  type: 'POST',
			  data: {
        					review_progress_id: review_progress_id,
							review_id: review_id,
							correct_ans_id: correct_ans_id,
							login_user_id: login_user_id,
							user_course_id: user_course_id,
							ajax: '1',
							chapter_id: chapter_id
    		  	}
			}).done(function(response) {
				if(response == 'complete'){
					$('.complete-review').fadeIn(200);
					$('.chapt_list').children('.active').addClass('complete');
				}
			});
	   }
 });
</script>  