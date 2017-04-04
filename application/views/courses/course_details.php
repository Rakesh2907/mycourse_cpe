<?php
 if(count($course_details) > 0)
 {  
     $refering_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	 $authors_details = $this->course_mod->get_course_faculties($course_details[0]['course_author']); 
	 $param_course = $course_details[0]['course_id'];
	 foreach($authors_details as $key => $authorsVal)
	 { 
	     $auth_name[] = '<a href="'.base_url().'faculty_con/faculty_details/'.$authorsVal['faculty_member_id'].'">'.$authorsVal['first_name'].' '.$authorsVal['last_name'].'</a>';
	 }
	 $auth_list = implode(', ',$auth_name);
	 
	 $course_credits = $this->course_mod->get_credits($course_details[0]['course_id']);
	 $credits_states = array(); 
	 foreach($course_credits as $mycredits)
	 {
			$dataArray[$mycredits['state_abbr']]['credits'] += $mycredits['credit_numbers'];
			$dataArray[$mycredits['state_abbr']]['state_id'] = $mycredits['state_id'];
			$dataArray[$mycredits['state_abbr']]['state'] = $mycredits['state'];
			$dataArray[$mycredits['state_abbr']]['type'][][$mycredits['type']]= $mycredits['credit_numbers'];
	 } 
	 
	 $course_chapters = $this->course_mod->get_chapters($course_details[0]['course_id']); 
	 $similar_courses = $this->course_mod->get_similar_courses($course_state,$course_details[0]['course_id']);
?>
<script type="text/javascript">var current_user_id = '<?php echo $cuserid;?>';</script>
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
<div class="bd-min-hgt bg-lg-gray pad-tb bdl_det_wrp crs_dtl_wrp">
<div class="bread-links vs-xs">
 
  <div class="col-xs-12 back-with-btn"> <a class="back-link" href="<?php echo $refering_url;?>"><span>Back To Courses</span></a> <a href="javascript:void(0)" class="btn dull-blue medium pull-right sim-crs" onclick="simillar_responsive();">SIMILAR COURSES</a> </div>
</div>
<div class="section-full inner-header" id="top_header" <?php if(isset($course_details[0]['back_color']) && $course_details[0]['back_color']!=''){ echo 'style="background-color:'.$course_details[0]['back_color'].'"';} ?>>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 text-center">
        <div class="bnd_img">
          <?php $img_file = DIR_IMAGES.''.$course_details[0]['course_image']; 
		        if(isset($course_details[0]['s3_images']) && $course_details[0]['s3_images']!='')
				{ 
		  ?>
          		<img src="<?php echo $course_details[0]['s3_images'];?>" width="164" height="236" alt="Course" />
          <?php
				}else if (file_exists($img_file) || $course_details[0]['course_image']!='') {//$this->config->item("upload_path");
			 ?>
          <img src="<?php echo CLOUDFRONT_URL?>images/<?php echo $course_details[0]['course_image'];?>" width="164" height="236" alt="Bundle" />
          <?php }else{ ?>
          <img src="<?php echo $this->config->item("cdn_css_image")?>images/bundl-main-img.png" width="164" height="236" alt="Bundle" />
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="section-full">
<div class="sim-crs-hgt">
  <div id="similar_Course" class="col-lg-6 col-md-5 col-sm-5 left-side-sim" style="display:none;">
          <div class="sim-crs-wrp">
          <div class="smlr_Course sm-crs-sld">
            <div class="smlr_Course_inner">
              <div class="sml-heading">
                <h4>SIMILAR COURSES</h4>
                <a id="similar_close" class="close icon-cross" onclick="myclose();" href="javascript:void(0)"></a> </div>
              <div class="bdl_sc_Grd cust-scroll">
                <?php
			    if(count($similar_courses) > 0)
				{ 
					foreach($similar_courses as $simi_courses)
					{   
					    $auth_details = $this->course_mod->get_course_faculties($simi_courses['course_author']);
						$author_name = array();
						foreach($auth_details as $key => $authorsVal)
	 					{ 
	    						 $author_name[] = $authorsVal['first_name'].' '.$authorsVal['last_name'];
	 					}
	 					$author_list = implode(', ',$author_name);
						$credits = $this->course_mod->get_course_credits_count($simi_courses['course_id'],$course_state);
					 	if($credits == ''){
						   $credits = '0.00';
					 	}
						
				?>
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" <?php if(isset($simi_courses['back_color']) && $simi_courses['back_color']!=''){ echo 'style="background-color:'.$simi_courses['back_color'].'"';} ?>>
                    <?php
							    $simiimg_file = DIR_IMAGES.''.$simi_courses['course_image']; 
								if(isset($simi_courses['s3_images']) && $simi_courses['s3_images']!=''){
					?>
                    			<a href="<?php echo base_url();?>individual-courses/<?php echo $simi_courses['course_id']?>/<?php echo $course_state;?>"><img class="bdl-img" src="<?php echo $simi_courses['s3_images'];?>" width="69" alt="<?php echo trim($simi_courses['course_name']);?>"></a>
                    <?php				
								}elseif (file_exists($simiimg_file) || $simi_courses['course_image']!='') { 
						?>
                   <a href="<?php echo base_url();?>individual-courses/<?php echo $simi_courses['course_id']?>/<?php echo $course_state;?>"><img class="bdl-img" src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $simi_courses['course_image'];?>" width="69" alt="<?php echo trim($simi_courses['course_name']);?>"></a>
                    <?php }else{?>
                    <a href="<?php echo base_url();?>individual-courses/<?php echo $simi_courses['course_id']?>/<?php echo $course_state;?>"><img class="bdl-img" src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-starcbuks.png" width="69" alt="<?php echo trim($simi_courses['course_name']);?>"></a>
                    <?php } ?>
                    <div class="bund-type"> 
                     <?php 
					  if($simi_courses['course_format'] == 'Text')
					  {
						  $icon_image = 'bund-pdf.png';
					  }else if($simi_courses['course_format'] == 'Webcast'){
						  $icon_image = 'bund-video-icon.png';
					  }
					 ?>
                    <img width="18" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo $icon_image;?>" alt="Course Type" /> </div>
                    <div class="bund-price"><?php echo $simi_courses['course_price'];?></div>
                  </div>
                  <!-- /bund-img-sec -->
                  
                  <div class="bund-desc">
                    <h5><a href="<?php echo base_url();?>individual-courses/<?php echo $simi_courses['course_id']?>/<?php echo $course_state;?>" class="link-title"><?php echo trim($simi_courses['course_name']);?></a></h5>
                    <div class="bdl_small"><i><?php echo $author_list;?></i></div>
                    <div class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $simi_courses['cpe_credits'];//$credits;?> credits</div>
                    <a href="<?php echo base_url();?>individual-courses/<?php echo $simi_courses['course_id']?>/<?php echo $course_state;?>" class="btn small_btn btn-blue-text">VIEW Course</a> </div>
                  <!-- /bund-desc --> 
                </div>
                <!-- /bdl_Small -->
                <?php }
				  }else{
					  echo 'Sorry, You currently have no similar courses for the selected filters.!';
				  }
				 ?>
              </div>
              <!-- row --> 
              
            </div>
            <!-- /smlr_Course_inner --> 
            </div>
          </div>
        </div>
  <div class="container"> 
    
    <!--<div class="row bread-links hidden-xs">
<div class="row mg-space-xs">
<div class="col-lg-4 col-md-4 col-sm-4"> 
<div class="back-with-btn">
<a href="#" class="back-link"><span>Back To Bundles</span></a>
<a class="btn dull-blue medium pull-right sim-crs" href="#">SIMILAR COURSES</a>
</div>
</div>
</div>

</div>-->
    
    <div class="row  bdl-det-pg">
      <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 col-sm-offset-1 col-lg-offset-1 details-rgt pull-right" id="content1">
        <div class="row mg-space-xs">
          <div class="wht-panel bdl_dtl_info rmv-lr-xs">
            <div class="bdl_head clr-dl_blue"><?php echo trim($course_details[0]['course_name']);?>
              <div class="bdl_det_icon">
              <?php	if($course_details[0]['course_format'] == 'Webcast')
                {
                    $img_name='bund-video-icon.png';
                }
                if($course_details[0]['course_format'] == 'Text')
                {
                    $img_name='bund-pdf.png';
                } ?>
              <img width="20" height="30" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo  $img_name; ?>" alt="PDF" /></div>
            </div>
            <div class="row">
              <div class="col-xs-6 text-left"> 
                <?php if($course_details[0]['discount_price'] > 0){?>
                 <span class="bdl_prc prc_old">$<?php echo trim($course_details[0]['course_price']);?></span> <span class="bdl_prc prc_new">$<?php echo trim($course_details[0]['discount_price']);?></span>
                 <?php }else{ ?>
                   <span class="bdl_prc prc_new">$<?php echo trim($course_details[0]['course_price']);?></span>
                 <?php } ?>
              </div>
              <div class="col-xs-6 text-right">
                <?php
				       $myc_count = 0;
				       $check_item = $this->cart_mod->check_item('Course',$course_details[0]['course_id'],$cart_id); 
					 
					   if($cuserid > 0){
						     $myc_count = $this->course_mod->check_mycourse($course_details[0]['course_id'],$cuserid);
							 $myc_count = $myc_count['mycourse'];
					   }
					   
					   
					   if(count($check_item) > 0)
					   {
				   ?>
                <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('course',<?php echo $cart_id;?>,<?php echo $course_details[0]['course_id'];?>,'true')">Remove</a> <a class="btn fad-orange medium add-cart add" href="javascript:void(0)" onclick="add_to_cart(<?php echo $course_details[0]['course_id'];?>,'course','true')" style="display:none;">Add to Cart</a>
                <?php }else{ ?>
                <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('course',<?php echo $cart_id;?>,<?php echo $course_details[0]['course_id'];?>,'true')" style="display:none;">Remove</a>
                <?php 
				  if($remaining_days > 0) 
				  { 
				     if($myc_count > 0)
					 {
			    ?>
                	  <a class="btn fad-orange medium add-cart" href="<?php echo base_url()?>mycourses">View My Course</a>	 	
                <?php			 
					 }else{   
				?>
                	<a id="mycourse_link" class="btn fad-orange medium add-cart" href="javascript:void(0)" onclick="add_to_mycourse(<?php echo $course_details[0]['course_id'];?>,'course','true',<?php echo $order_id;?>)">Add to My Courses</a>
                <?php
					 }
				 }else{
					if($myc_count > 0){
			    ?>	
                	 <a class="btn fad-orange medium add-cart" href="<?php echo base_url()?>mycourses">View My Course</a>		
				<?php		
				    }else{
				?>
                 <a class="btn fad-orange medium add-cart add" href="javascript:void(0)" onclick="add_to_cart(<?php echo $course_details[0]['course_id'];?>,'course','true')">Add to Cart</a>
                 <?php }
				  } ?>
                <?php } ?>
              </div>
            </div>
            <div class="subs_text" style="display:none;">This course is included in your subscription</div>
          </div>
          <div class="panel-head-sep pre-pos-xs text-center">
          <?php
		     if(isset($course_details[0]['s3_intropdf']) &&  $course_details[0]['s3_intropdf']!='')
			 {
		  ?>
              <a href="<?php echo $course_details[0]['s3_intropdf'];?>" class="pre-crs-lnk" target="_blank">
                <span class="icon icon-open"></span> <span>PREVIEW COURSE</span>
               </a>
          <?php		 
			 }else if($course_details[0]['intro_video'] == '' && $course_details[0]['introPDF'] !='') { //course_con/get_file/?file=<?php echo $course_details[0]['introPDF'];?>
              <a href="<?php echo CLOUDFRONT_URL;?>material/intropdf/<?php echo $course_details[0]['introPDF'];?>" class="pre-crs-lnk" target="_blank">
                <span class="icon icon-open"></span> <span>PREVIEW COURSE</span>
               </a>
           <?php }else if($course_details[0]['intro_video'] != ''){ ?>
           <a href="javascript:void(0);"  data-target="#preview_course_model" data-toggle="modal" data-backdrop="false" class="pre-crs-lnk">
                <span class="icon icon-open"></span> <span>PREVIEW COURSE</span>
               </a>
           <?php } ?>
           </div>
          <div class="wht-panel credit-sec">
            <?php if(isset($cuserid) && $cuserid!=0){?>
            <!-- popup -->
            <div class="cust_pop_Sec cr_cnt_p reg_Ac" id="cr_inf">
              <div class="cus_Pop_Inner"> <a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross "></a>
                <h4 class="track_head visible-xs">Credit Tracker</h4>
                <i class="cr_inst">This course would earn you an additional <span id="addcredit"></span> credits <span id="creditcats"></span></i>
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
            <?php }else{ ?>
            <!-- no register -->
            <div class="cust_pop_Sec cr_cnt_p user_reg_Ac" id="cr_inf">
              <div class="cus_Pop_Inner"> <a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross"></a>
                <div class="non-register text-center"> <i class="cr_inst">Sorry, this feature is available to registered users only.</i> <a href="#" data-toggle="modal" data-target="#free_Join" class="btn fad-orange medium">JOIN NOW FOR FREE!</a> </div>
              </div>
            </div>
            <!-- no register close --> 
            <!-- /popup -->
            <?php } ?>
            <div class="cust_pop_Sec cr_cnt_p user_reg_Ac" id="cr_inf1">
              <div class="cus_Pop_Inner"> <a href="javascript:void(0)" onclick="toggler('cr_inf1');" class="close icon-cross"></a>
                <div class="non-register text-center"> <i class="cr_inst">You do not currently have <span id="stname"></span> set as a credit state in your profile. Please add it in your profile, or select another state to see your credit tracker.</i> </div>
              </div>
            </div>
            <div class="credit-details">
       
              <div class="crd-icon"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-diamond-blc.png" width="24" height="22" alt="Credit Diamond" /></div>
              <div class="cr-head"> <span class="text-line-select smp-drop max-scroll">
                <select id="categories" data-width="100%" class="selectpicker" onchange="credit_type(this,<?php echo $param_course;?>)">
                  <?php
				  foreach($dataArray as $key => $states)
				 {
					  if($states['state_id'] == $course_state){
						  $selected = 'selected = "selected"';
						  $default_state = $key;
					  }else{
						  $selected = '';
					  }
					  $credit_word = " Credits - ";
					  if($states['credits'] == 1){
						  $credit_word = " Credit - ";
					  }
				 ?>
                  <option value="<?php echo $states['state_id'];?>" <?php echo $selected?> id="<?php echo $key;?>"><?php echo $states['credits'];echo $credit_word; echo $key;?></option>
                  <?php } ?>
                </select>
                 <input type="hidden" name="drop-down_state" value="<?php echo $default_state;?>" id="drop-down_state"/>
                </span> </div>
              <ul class="cr-list list-unstyled" id="credit_types">
              </ul>
            </div>
            <!-- /credit-sec -->
            
            <div class="cr-cnt"><!--<a onclick="toggler('cr_inf');" href="javascript:void(0)">How does this affect my credit count?</a>--> 
            <a class="showtrack" href="javascript:void(0)">How does this affect my credit count?</a>
              <!--<a class="showtrack" href="javascript:void(0)">This course earned you an additional <span id="addcredit1"></span> credits in <span id="creditcats1"></span></a>-->
            </div>
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
            </div>
            <!-- /lrn_chp_wrp --> 
            
          </div>
        </div>
        <!-- /mg-space --> 
        
      </div>
      <!-- / col -->
      
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 details-left pull-left">
        <div class="bread-links hidden-xs">
          <div class="back-with-btn"> <a href="<?php echo base_url();?>individual-courses" class="back-link"><span>Back To Courses</span></a> <a class="btn dull-blue medium pull-right sim-crs" onclick="simillar();" href="javascript:void(0)">SIMILAR COURSES</a> </div>
        </div>
        <div class="row" id="preview_courses">
          <div class="wht-panel details-sidebar crs-info-sdb">
            <div class="panel-head-sep text-center hidden-xs">
                <?php
				if(isset($course_details[0]['s3_intropdf']) &&  $course_details[0]['s3_intropdf']!='NULL')
			    {
			   ?>		
				<a class="pre-crs-lnk" href="<?php echo $course_details[0]['s3_intropdf'];?>" target="_blank"><span class="icon icon-open"></span> <span>PREVIEW COURSE</span></a>
                <?php 
				}else if($course_details[0]['intro_video'] == '' && $course_details[0]['introPDF'] !='') {  //course_con/get_file/?file=<?php echo $course_details[0]['introPDF'];?>
                <a class="pre-crs-lnk" href="<?php echo CLOUDFRONT_URL;?>material/intropdf/<?php echo $course_details[0]['introPDF'];?>" target="_blank">
                 	<span class="icon icon-open"></span> <span>PREVIEW COURSE</span>
                 </a>
                 <?php }else if($course_details[0]['intro_video'] != ''){ ?>
                 <a class="pre-crs-lnk" href="javascript:void(0);"  data-target="#preview_course_model" data-toggle="modal" data-backdrop="false">
                 	<span class="icon icon-open"></span> <span>PREVIEW COURSE</span>
                 </a>
                 <?php } ?>
             </div>
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
                <?php echo date('m/d/Y',strtotime($course_details[0]['course_date']));?> </li>
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
        
        
        <!-- /Similar Course --> 
        
      </div>
      <!-- /col --> 
      
    </div>
  </div>
</div>
</div>

</div> <!-- /bd-min-hgt -->
<!-- /added to cart pop-up satrt  --> <!--modal fade cst-flat-popup-->
<input name="ckstate" id="ckstate" type="hidden" />
<input name="statename" id="statename" type="hidden" />
<div style="overflow:hidden;" role="dialog" class=" modal fade vdo_Popup preview_course" id="preview_course_model">
  <div class="modal-dialog mdl-cs-wd">     
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button" style="z-index:9"></button>
        
      </div>
      <div class="modal-body">
      <iframe class="myplayer" width="696" height="520" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="<?php echo $course_details[0]['intro_video'];?>"></iframe></div>
    </div>
  </div>
</div>
<!-- /added to cart pop-up ends  -->
<style>
.modal-open .modal.preview_course::after {
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
</style>
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/cart.js"></script> 
<script type="text/javascript">
$('document').ready(function(){
	    $("#categories").trigger('change');
		
		$(".showtrack").click(function(){
			var ckstate = $("#ckstate").val();
			var sname = $("#statename").val();
			
			if(ckstate == 'yes')
			{
				toggler('cr_inf');	
			}
			if(ckstate == 'no')
			{
			   var uid = '<?php echo $cuserid; ?>';
			   
			    if(uid > 0)
				{
				 $("#stname").html(sname);	
				 toggler('cr_inf1');	
				}else{
					 toggler('cr_inf');
				}
			}
			})
			
});
function myclose()
{
	$('#similar_Course').hide();
	$('#preview_courses').show();
}
function responsive_close()
{
	$('#preview_courses').show();
	$('#similar_Course').hide();
	$('#content1').show();
	$('#top_header').show();
	$('#similar_close').attr('onclick','responsive_close();');
}
function simillar_responsive()
{
	$('#preview_courses').hide();
	$('#similar_Course').show();
	$('#content1').hide();
	$('#top_header').hide();
	$('#similar_close').attr('onclick','responsive_close();');
}
function simillar()
{
	$('#similar_Course').show();
	$('#preview_courses').hide();
}

	
 jQuery(function(){
    jQuery('.sim-crs-hgt') .css({'min-height': ((jQuery(window).height() - 463))+'px'});
    jQuery(window).resize(function(){
        jQuery('.sim-crs-hgt') .css({'min-height': ((jQuery(window).height() - 463))+'px'});
    });
});
</script>
<?php
 }else{
	  echo "No course are found...!";
 }
?>
