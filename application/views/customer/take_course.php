<?php
if(count($course_details) > 0)
{ 
    $authors_details = $this->course_mod->get_course_faculties($course_details[0]['course_author']); 
	$param_course = $course_details[0]['course_id'];
	foreach($authors_details as $key => $authorsVal)
	 { 
	     $auth_name[] = '<a href="'.base_url().'faculty_con/faculty_details/'.$authorsVal['faculty_member_id'].'">'.$authorsVal['first_name'].' '.$authorsVal['last_name'].'</a>';
	 }
	 $auth_list = implode(', ',$auth_name);
	 
	 $course_credits = $this->course_mod->get_credits($course_details[0]['course_id']);
	 $coures_text = $this->course_mod->get_text_doc($course_details[0]['course_id']);
	 $course_video = $this->course_mod->get_video($course_details[0]['course_id']);
	  
	 $credits_states = array(); 
	 foreach($course_credits as $mycredits)
	 {
			$dataArray[$mycredits['state_abbr']]['credits'] += $mycredits['credit_numbers'];
			$dataArray[$mycredits['state_abbr']]['state_id'] = $mycredits['state_id'];
			$dataArray[$mycredits['state_abbr']]['state'] = $mycredits['state'];
			$dataArray[$mycredits['state_abbr']]['type'][][$mycredits['type']]= $mycredits['credit_numbers'];
	 } 
	 
	 $course_chapters = $this->course_mod->get_chapters($course_details[0]['course_id']); 	
?> 
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
<script type="text/javascript">var current_user_id = '<?php echo $cuserid;?>';</script>
<style>
.modal-open .modal.vdo_Popup::after {
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
/*.modal-backdrop.in {
 display:none;
}*/
</style>
<div class="bg-lg-gray bdl_det_wrp crs_dtl_wrp bd-min-hgt">

<div class="section-full inner-header" <?php if(isset($course_details[0]['back_color']) && $course_details[0]['back_color']!=''){ echo 'style="background-color:'.$course_details[0]['back_color'].'"';} ?>>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 text-center">
        <div class="bnd_img">
             <?php $img_file = DIR_IMAGES.''.$course_details[0]['course_image']; 
			       if(isset($course_details[0]['s3_images']) && $course_details[0]['s3_images']!='')
				   {
			?>
            		<img src="<?php echo $course_details[0]['s3_images'];?>" width="164" height="236" alt="Bundle" /> 
            <?php		    
				   }elseif (file_exists($img_file) || $course_details[0]['course_image']!='') 
				   { 
			?>	
            		<img src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $course_details[0]['course_image'];?>" width="164" height="236" alt="Bundle" />    	
			<?php  }else{ ?>
			  		 <img src="<?php echo $this->config->item("cdn_css_image")?>images/bundl-main-img.png" width="164" height="236" alt="Bundle" />  
			<?php }?> 
         </div>
      </div>
    </div>
  </div>
</div>
<!-- /inner-header -->

<div class="section-full">
  <div class="hgt-33 thm-progress clearfix visible-xs">
    <div class="progress">
      <div class="progr-cap"><?php echo $totalpercent;?>% COMPLETE</div>
      <div style="width:<?php echo $totalpercent;?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $totalpercent;?>" role="progressbar" class="progress-bar"></div>
    </div>
  </div>
  <!-- /thm-progress -->
  
  <div class="container">
    <div class="row bdl-det-pg">
      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 col-sm-offset-1 col-lg-offset-1 details-rgt pull-right">
        <div class="row mg-space-xs">
          <div class="wht-panel bdl_dtl_info rds-bt-pad rmv-lr-xs">
            <div class="bdl_head clr-dl_blue no-icon"><?php echo trim($course_details[0]['course_name']);?> <i class="small-text">This course was purchased on <?php echo date('m/d/Y',strtotime($orders_details[0]['order_date']));?></i> </div>
            <div class="course-info comment-pos">
              <h4 class="head-with-icon"><img src="<?php echo $this->config->item("cdn_css_image")?>images/glass-icon.png" width="25" alt="Glass" />Start Your Course</h4>
              <div class="top-comment hidden-xs"><a data-target="#leave-comment" data-toggle="modal" href="#"> Comments / Questions?</a></div>
              <div class="start-crs-sec">
                <div class="sub-head">1. View Course Content</div>
                <div class="inr-des"> 
                  <?php if(sizeof($course_video) > 0 ){ ?>
                  <!-- video Section -->
                  <div class="vdo-wrp">
                    <!--<div class="vdo-parts">
                      <ul class="list-unstyled list-inline">
                        <li class="head">Part</li>
                        <li><a class="current" href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">4</a></li>
                      </ul>
                    </div>-->
                    <div class="vdo-crs">
                      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner" role="listbox">
                         <?php 
						    $count = 1;
						    $flag = 0;
						    foreach($course_video as $vkey => $valvideo) 
						 	{
								if($course_progress[$valvideo['id']] < 100 && !$flag){
									$class = 'active';
									$flag = 1;
								}else{
									$class = '';
							    }
						  ?>
                              <div class="item <?php echo $class;?>">
                                <div class="vdo-overlap">
                                  <div class="play-icon" data-target="#my_Video" data-toggle="modal" data-backdrop="false"><img id="<?php echo $count;?>" width="53" src="<?php echo $this->config->item("cdn_css_image")?>images/video-play.png" alt="Play"   onclick="open_video(<?php echo $valvideo['id'];?>,'<?php echo $valvideo['video_url'];?>',<?php echo $count;?>)" data-video_id="<?php echo $valvideo['id'];?>" data-vimeo-url="<?php echo $valvideo['video_url'];?>"/></div>
                                  <img src="<?php echo $this->config->item("cdn_css_image")?>images/vdo-img.png" alt="video" /> </div>
                                <div class="vdo-text text-center<?php if($course_progress[$valvideo['id']] == 100){echo ' completed';}?>"><?php echo $valvideo['video_name'];?></div>
                              </div>
                          <!-- item -->
                          <?php 
						      $count = $count + 1;
						  } ?>
                
                        </div>
                        <!-- /carousel-inner --> 
                        <!-- controls -->
                        <div class="cars-control"> <a class="left" href="#myCarousel" role="button" data-slide="prev"> <span class="icon icon-arrow-left" aria-hidden="true"></span> </a> <a class="right" href="#myCarousel" role="button" data-slide="next"> <span class="icon icon-arrow-right" aria-hidden="true"></span> </a> </div>
                        <!-- /controls --> 
                        
                      </div>
                      <!-- /carousel --> 
                      
                    </div>
                    <!-- /vdo-crs --> 
                    
                  </div>
                  <!-- /vdo-wrp --> 
                  <!-- close video Section -->
                  <?php } if(count($coures_text) > 0){?>
                  
                  <div class="sub-head">Download Material</div>
                  <ul class="list-unstyled dwn-links">
                    <?php 
					
						foreach($coures_text as $key => $course_doc)
						{   
							   $doc_file = DIR_DOC.''.$course_doc['course_pdf']; 
							   if($course_doc['s3_pdf']!=''){
						?>
                         		<li><a target="_blank" href="<?php echo $course_doc['s3_pdf'];?>" onclick="percentage_status(<?php echo $course_doc['id'];?>,<?php echo $course_doc['course_id'];?>,<?php echo $user_course_id;?>,<?php echo $cuserid;?>,'Text');"><?php echo trim($course_doc['pdf_name']);?></a></li>	
                        <?php		   
							   }elseif (file_exists($doc_file) || $course_doc['course_pdf']!='') 
							   { 
								?>
										<li><a target="_blank" href="<?php echo CLOUDFRONT_URL.'material/'.$course_doc['course_pdf'];?>" onclick="percentage_status(<?php echo $course_doc['id'];?>,<?php echo $course_doc['course_id'];?>,<?php echo $user_course_id;?>,<?php echo $cuserid;?>,'Text');"><?php echo trim($course_doc['pdf_name']);?></a></li>
								<?php
							   }
						} 
					
					?>
                  </ul>
                  <!-- /list-pdf-links --> 
                  <?php } ?>
                </div>
              </div>
              <!-- /start-crs-sec -->
              
              <div class="start-crs-sec">
                <div class="sub-head">2. Complete Review Questions
                  <div class="info-icon">?
                    <div class="info-tool">Please download course materials to enable the Course Review section.</div>
                  </div>
                  <!-- /info-icon --> 
                </div>
                <!-- /sub-head -->
                <div class="inr-des">
                    <?php 
					  if($totalpercent >= '0')
					  {
						  $url = base_url().'start-review/'.$user_course[0]['id'].'?chapter_id='.$first_chapters[0]['chapter_id'];
						  $style = 'style="background-color:#40798c"';
					  }else{
						  $url = 'javascript:void(0)';
						  $style = 'style="background-color:#e7e7e7"';
					  }
					?>
                    
                   <a href="<?php echo $url;?>" class="btn btn-pale-grey medium" <?php echo $style;?>>START REVIEW</a> 
                </div>
              </div>
              <!-- /start-crs-sec -->
              
              <div class="start-crs-sec">
                <div class="sub-head">3. Take Final Exam
                  <div class="info-icon">?
                    <div class="info-tool">Please complete Review Questions to enable the Final Exam section.</div>
                  </div>
                  <!-- /info-icon --> 
                </div>
                <!-- /sub-head -->
                <div class="inr-des"> 
                    <?php 
					  if($totalpercent >= '75')
					  {
						  $url = base_url().'start-exam/'.$user_course[0]['id'];
						   $style = 'style="background-color:#40798c"';
					  }else{
						  $url = 'javascript:void(0)';
						  $style = 'style="background-color:#e7e7e7"';
					  }
					?>
                  <a href="<?php echo $url;?>" class="btn btn-pale-grey medium" <?php echo $style;?>>START EXAM</a> 
                </div>
                
                <!--<div class="othr-links">
<ul class="list-unstyled">
<li class="comment"><a href="#" data-toggle="modal" data-target="#leave-comment">Questions / Comments?</a></li>
<li class="instr"><a href="#">Full Course Instructions</a></li>
</ul>
</div> --> 
                
              </div>
              <!-- /start-crs-sec --> 
              
            </div>
            <!-- /course-info --> 
            
          </div>
          <div class="wht-panel credit-sec"> 
            
            <!-- popup -->
                    
            <!-- popup -->
            <div class="cust_pop_Sec cr_cnt_p reg_Ac" id="cr_inf">
              <div class="cus_Pop_Inner"> <a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross visible-sm visible-xs"></a>
                <h4 class="track_head visible-xs">Credit Tracker</h4>
                <i class="cr_inst">This course earned you an additional <span id="addcredit"></span> credits in '<span id="creditcats"></span>'.</i>
                <div class="cr-graph">
                  <div class="cr_bar">
                    <ul class="list-unstyled graph-list" id="stae_credit_types">
                      
                    </ul>
                   <!-- <img src="<?php //echo $this->config->item("cdn_css_image")?>images/cre-bar.png" width="352" alt="Bars" />--></div>
                 <div class="cr_cir">
                  
                  <div class="mng_ch"><canvas id="myChart"></canvas></div>
                  </div>
                </div>
                <!-- /cr-graph --> 
                
              </div>
            </div>
          
            <!-- /popup -->
            
            <div class="credit-details">
              <div class="crd-icon"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-diamond-blc.png" width="24" height="22" alt="Credit Diamond" /></div>
              <div class="cr-head"> <span class="text-line-select smp-drop max-scroll">
                <select id="categories" data-width="100%" class="selectpicker" onchange="credit_type(this,<?php echo $param_course;?>)">
                 <?php foreach($dataArray as $key => $states)
				 {
					  if($states['state_id'] == $course_state){
						  $selected = 'selected = "selected"';
					  }else{
						  $selected = '';
					  }
					  $credit_word = " Credits - ";
					  if($states['credits'] == 1){
						  $credit_word = " Credit - ";
					  }
				 ?>
                  <option value="<?php echo $states['state_id'];?>" <?php echo $selected?>><?php echo $states['credits'];echo $credit_word; echo $key;?></option>
                 <?php } ?>
                </select>
                </span> </div>
              <ul class="cr-list list-unstyled" id="credit_types"></ul>
            </div>
            <!-- /credit-sec -->
            
            <div class="cr-cnt"><a onclick="toggler('cr_inf');" href="javascript:void(0)">How does this affect my credit count?</a> </div>
          </div>
          <div class="wht-panel bdl_desc rmv-lr-xs">
            <h5 class="head-sm">Course Description</h5>
            <p><?php echo trim($course_details[0]['course_description']);?></p>
            <h5 class="head-sm desc_head_2">Learning Objectives</h5>
            <div class="lrn_chp_wrp">
              <ul class="list-unstyled chapt_list">
                <?php 
	                //Tony changed this to automatically scale between 0% opacity and 100%, so we don't have to pick each color for each chapter.
	                $num_chapters = count($course_chapters);
	                if($num_chapters > 0){
		              $color_stop = 1 / $num_chapters;
					  $i = 1;
					  foreach($course_chapters as $chapters){
				?>
                	   <li class="ch_<?php echo $i;?>"> 
                       <div class="chp_head" <?php if(isset($chapters['back_color']) && $chapters['back_color']!=''){ echo 'style="border-color:rgba(239,148,108,'.round(($color_stop * $i),2).')"';} ?>><?php echo trim($chapters['chapter_name']);?></div>
                  	   <div class="chp_desc"><?php echo trim($chapters['chapter_desc']);?></div>
                       </li>
                <?php
				      $i++;
					 }
				}else{ ?>
                	<li>No Chapters assign to this course.</li>
                <?php } ?> 
              </ul>
              </ul>
            </div>
            <!-- /lrn_chp_wrp --> 
            
          </div>
        </div>
        <!-- /mg-space --> 
        
      </div>
      <!-- / col -->
      
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 details-left tk-crs-sid pull-left">
        <div class="row">
          <div class="hgt-33 thm-progress clearfix hidden-xs">
            <div class="progress">
              <div class="progr-cap"><?php echo $totalpercent;?>% COMPLETE</div>
              <div style="width:<?php echo $totalpercent;?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $totalpercent;?>" role="progressbar" class="progress-bar"></div>
            </div>
          </div>
          <!-- /thm-progress -->
          
          <div class="wht-panel details-sidebar crs-info-sdb pd-top">
            <ul class="list-unstyled text-center cours_List">
              <li>
                <h6>Instructional Delivery Method</h6>
                <?php echo trim($course_details[0]['instructional_delivery_method']);?></li>
              <li>
                <h6>Prerequisite</h6>
                <?php echo trim($course_details[0]['prerequisites']);?></li>
              <li>
                <h6>Field of Study</h6>
                 <?php echo trim($course_details[0]['field_of_study']);?></li>
              <li>
                <h6>Level of Knowledge</h6>
                <?php echo trim($course_details[0]['knowledge_level']);?></li>
              <li>
                <h6>Recommended CPE Credit</h6>
                <?php echo trim($course_details[0]['cpe_credits']);?></li>
              <li>
                <h6>CPE Final Exam Required Passing Grade</h6>
                <?php echo trim($course_details[0]['passing_grade']);?>%</li>
              <li>
                <h6>Advanced Preparation</h6>
                <?php echo trim($course_details[0]['advance_preparation']);?></li>
              <li>
                <h6>Course Reviewed / Updated</h6>
                <?php echo date('m/d/Y',strtotime($course_details[0]['course_date']));?></li>
              <li>
                <h6>Course Author</h6>
                <?php echo $auth_list;?></li>
            </ul>
            <div class="row">
              <div class="col-xs-12 note-sec"> <strong>Please Note:</strong><br>
                <p>Please Note: This course must be completed within <?php echo $course_details[0]['course_period']?> months of date of receipt of this course for CPE credit.</p>
              </div>
            </div>
            <!-- note-sec --> 
            
          </div>
          <!-- /wht-panel --> 
          
        </div>
        <!-- /row --> 
        
      </div>
      <!-- /col --> 
      
    </div>
  </div>
</div>

</div> <!-- bd-min-hgt -->
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.vimeo.api.js"></script>
<script type="text/javascript">
$('document').ready(function(){
	    $("#categories").trigger('change');
		
		$('#cfeedback_form').submit( function(e){
			  e.preventDefault();
			  $('#loader_feedback').show();
			  $('#cfeedback_form').hide();
			  $.ajax({
				   url: base_url+'customer_con/feedback',
				    dataType: 'html',
             		type: 'POST',
              		data: {
						'course_id': '<?php echo $course_details[0]['course_id'];?>',
						'feed_back': $("#comment").val(),
						'user_id': current_user_id
					}
			  }).done(function(response){
				  if(response == 'success'){
					  $("#feedbackstatus").css("color", "#9DBC93");
					  $('#feedbackstatus').html('Sent Successfully...');
					  $('#loader_feedback').hide();
					  $('#cfeedback_form').show();
					  $('.modal-body').hide();
					  setTimeout(function(){ $('#leave-comment').modal('hide') }, 3000);
				  }else{
					  $('#feedbackstatus').css("color", "#EF946C");
					  $('#feedbackstatus').html('Failed..! Try again.');
					  $('#loader_feedback').hide();
					  $('#cfeedback_form').show();
				  }
			  });
		});
		$('#myviderclose').click(function(){
			location.reload();
		});
		
});

function percentage_status(doc_id,course_id,user_course_id,user_id,type)
{
	     $.ajax({
			  url: base_url+'customer_con/update_percentage',
			  dataType:"html",
			  type:'POST',
			  data:{
				  'docid':doc_id,
				  'courseid': course_id,
				  'usercourseid':user_course_id,
				  'userid':user_id,
				  'type':type
			  }
		 }).done(function(response){
			 location.reload(true);
		 });
}
 var user_course_id = '<?php echo $user_course_id;?>';
 var course_id = '<?php echo $course_details[0]['course_id']?>';
 var user_id = current_user_id;
 var video_id = 0;
 var done = false;
 var starting_time = 2;
 var interval;
 var my_current_senconds = 0;
<?php if(sizeof($course_video) > 0 ){ ?>	 
 function open_video(myvideo_id,video_url,player_id)
 { 
 	  video_id = myvideo_id;
	  var clipURL = video_url+'?api=1&player_id='+player_id
	  
	  $(".current_myplayer").remove();
	  var ifrm = document.createElement("iframe");
      ifrm.setAttribute("src", clipURL);
	  ifrm.setAttribute('class','current_myplayer');
      ifrm.width = "696";
      ifrm.height = "520";
      ifrm.id = 'player_' + player_id;
      ifrm.frameborder = 0;
      document.getElementById("your-parent-Div").appendChild(ifrm); 
      
      var vid = $("#player_"+player_id);
	  
	   $.ajax({
		    url: base_url+'customer_con/get_video_notes',
			dataType:"html",
			type:'POST',
			data:{
				'user_course_id': '<?php echo $user_course_id;?>',
				'video_id' : video_id,
				'user_id' : current_user_id,
				'course_id' : '<?php echo $course_details[0]['course_id']?>'
			}
	   }).done(function(response){
			 $("#notes_wrp").html(response);
	   });
	  
	  
	  $("#player_"+player_id).vimeo("play").on("play", function(event,data){
                      console.log("play event was triggered");
					  //if(((data.percent)*100).toFixed(0) != 100){
						 getVideoDetails(video_id,course_id,user_id,user_course_id,player_id);
					  //}
                  })
                  .on("pause", function(event,data){
                      console.log("pause event was triggered");
					  if(((data.percent)*100).toFixed(0) != 100)
					  {
						storeDetails(user_course_id,video_id,course_id,user_id,((data.percent)*100).toFixed(0),data.seconds,player_id);
					  }
                  })
                  .on("playProgress", function(event, data){
				      //console.log(((data.percent)*100).toFixed(0));
                      progress = ((data.percent)*100).toFixed(0);
					 if(((data.percent)*100).toFixed(0) == 100 && !done)
					 {
							storeDetails(user_course_id,video_id,course_id,user_id,100,data.seconds,player_id);
							clearInterval(interval);
							done=true;				
					}
					else{
						if(!done && ((data.percent)*100).toFixed(0) > starting_time)
						{
										
							interval = setInterval(storeDetails(user_course_id,video_id,course_id,user_id,((data.percent)*100).toFixed(0),data.seconds,player_id),30000);
							starting_time = parseInt(starting_time) + parseInt(2);
											
						}
					 }
                  })
                  .on("finish", function(e,data){
                      vid.vimeo("unload");
                      console.log("Finished event triggered");
                      //todo: maybe close popup and advance to next video automatically

                  });
				  
				  function storeDetails(user_course_id,video_id,course_id,user_id,percentage,seconds,player_id)
				  {
					    my_current_senconds = seconds;
						var url = "<?php echo base_url();?>customer_con/tracking_video"; 
						
							$.ajax({
								type: "POST",
								data: { 
								   video_id: video_id,
								   course_id: course_id,
								   user_id: user_id,
								   percentage: percentage,
								   user_course_id:user_course_id,
								   played_time:seconds,
								   type: 'Video'
								},
								url: url,
								async: true,
								beforeSend: function(){
								},
								success: function(msg) {
									return false;	
								}
							});
						
					}
					
				  function getVideoDetails(video_id,course_id,user_id,user_course_id,player_id)
				  {
						 var url = "<?php echo base_url();?>customer_con/get_video_details";
						 $.ajax({
								type: "POST",
								data: { 
								   video_id: video_id,
								   course_id: course_id,
								   user_id: user_id,
								   user_course_id: user_course_id,
								   type: 'Video'
								},
								url: url,
								async: true,
								beforeSend: function(){
								},
								success: function(res) {
									var obj = jQuery.parseJSON(res);
									if(obj.length > 0)
									{
									    if(obj[0].completed_percentage == '100'){
				                            return true;
										}else{
										     $("#player_"+player_id).vimeo("seekTo",obj[0].video_played_time);
											  return true;
										}
									}
								}
							});
					}
					
     // alert(video_id+' URL ='+video_url);
 }
 

<?php } ?>

</script>
<!-- / Stop video Close Popup  -->
<script>
  function add_new_notes()
  {
	   $('.add-notes-lnk').hide();
	   $('.notes-txt').show();
	   $('#add_my_new_notes').val('');
  }
  function canel_add_notes()
  {
	    $('.add-notes-lnk').show();
	    $('#mynotes').hide();
  }
  function edit_notes(note_id)
  {
	  $('#current_text_'+note_id).hide();
	  $('#my_edit_'+note_id).show();
  } 
  function cancel_edit(note_id)
  {
	   $('#current_text_'+note_id).show();
	   $('#my_edit_'+note_id).hide();
  }
  
  function delete_notes(note_id)
  {
	   $.ajax({
		     url: base_url+'customer_con/delete_notes',
			 dataType: 'html',
			 type: 'POST',
			 data: {
				 user_id :  current_user_id,
				 notes_id : note_id
			 }
		  }).done(function(response){
			  if(response == 1){
				  $("#notes_list_"+note_id).remove();
			  }
		 });
  }
  
  function save_edit(note_id)
  {
	    $.ajax({
		     url: base_url+'customer_con/edit_notes',
			 dataType: 'html',
			 type: 'POST',
			 data: {
				 user_id :  current_user_id,
				 notes_id : note_id,
				 edit_text : $("#edit_text_"+note_id).val()
			 }
		  }).done(function(response){
			  if(response == 1){
				  $("#my_edit_"+note_id).hide();
				  $("#current_text_"+note_id).html($("#edit_text_"+note_id).val());
				  $("#current_text_"+note_id).show();
			  }
		 });
  }
  function hide_note()
  {
	   $('#notes_wrp').hide();
  }
  
  function add_new_video_notes(video_id,user_course_id,course_id)
  {
	  //console.log(my_current_senconds);
	   var add_new_text = $("#add_my_new_notes").val();
	  
	   var hours = Math.floor(my_current_senconds / 3600);
	   var minute = Math.floor((my_current_senconds - (hours*3600)) / 60);
	   var seconds = parseFloat(my_current_senconds % 60).toFixed(0);
	   var strTime = minute+':'+seconds;
	   
	   $.ajax({
				   url: base_url+'customer_con/customer_notes',
				   dataType: 'html',
             	   type: 'POST',
              	   data: {
					    course_id : course_id,
						user_id :  current_user_id,
						user_course_id : user_course_id,
						my_notes: add_new_text,
						current_date: '<?php echo date('Y-m-d');?>',
						current_time: '<?php echo date('H:i');?>',
						myvideo_id: video_id,
						video_seconds: my_current_senconds
				   }
	  }).done(function(response){
			if($.isNumeric(response)){
				//alert('Saved successfully...');
				 $("#showing_notes_list").prepend('<li id="notes_list_'+response+'"><div class="notes-head"><span class="vr-line"></span><a href="#" class="nts-hd">'+strTime+'</a><ul class="nts-action"><li><a href="javascript:void(0)" class="delete" onclick="delete_notes('+response+');"><span class="icon icon-trash"></span></a></li><li><a data-toggle="modal" data-target="#chg_report_Period" href="javascript:void(0)" class="sprite-icons crs-edit-Icon" onclick="edit_notes('+response+')"></a></li></ul></div><div class="notes-txt" id="current_text_'+response+'">'+add_new_text+'</div></li><li class="edt-notes" id="my_edit_'+response+'" style="display:none;"><div class="notes-txt"><textarea class="form-control" id="edit_text_'+response+'">'+add_new_text+'</textarea></div><div class="save-nts-action text-right"> <a class="cancel" href="javascript:void(0)" onclick="cancel_edit('+response+')">Cancel</a> <a class="btn fad-orange" onclick="save_edit('+response+')">Save</a></div></li>');
				 $('.add-notes-lnk').show();
	   			 $('#mynotes').hide();
			}else{
				alert(response);
			} 
	  });   
  }
</script>
<div id="my_Video" class="modal fade vdo_Popup abs-pop" role="dialog">
  <div class="modal-dialog mdl-cs-wd">

    <!-- Modal content-->
    <div class="modal-content nts-btn">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal" id="myviderclose"></button>
        <div class="vdo-insr">Your play position will be saved if you close the video.</div>
      </div>
      <div class="view-nots-btn text-right">
      	<a class="btn fad-orange medium" href="javascript:void(0)" onclick="toggler('notes_wrp');">Take Notes</a>
      </div> <!-- /view-nots-btn -->
      <div class="modal-body">
            <div class="vdo-overlap12" id="your-parent-Div">
    <!--<div class="play-icon"><img width="100" alt="Play" src="<?php echo $this->config->item("cdn_css_image")?>images/video-play.png"></div>-->
            <iframe class="current_myplayer" width="696" height="520" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src=""></iframe>
			           </div>
                       
                       
        <!-- overlay -->
      </div>
    </div>

  </div>
</div> <!-- Modal close -->
<!-- notes sidebar -->
<div id="notes_wrp" class="note_outer"></div>

<script>
 $(function(){
    $('.notes_sec') .css({'max-height': (($(window).height() - 165))+'px'});
    $(window).resize(function(){
        $('.notes_sec') .css({'max-height': (($(window).height() - 165))+'px'});
    });
});

</script>

<!-- /notes sidebar -->
<?php } ?>
