<?php
 	$bundle_courses = $this->bundle_mod->get_bundle_courses($details[0]['bundle_courses']);
	$param_course = "'".trim($details[0]['bundle_courses'])."'";
	if(count($bundle_courses) > 0)
	{
		foreach($bundle_courses as $key => $courses){
			$authors[] = $courses['course_author'];
		}
		$myauthors = implode(',',$authors);
		$myauthors = implode(',', array_unique(explode(',',$myauthors)));
		$authors_details = $this->course_mod->get_course_faculties($myauthors);
	}
	$course_credits = $this->course_mod->get_credits($details[0]['bundle_courses']);
	$credits_states = array(); 
	foreach($course_credits as $mycredits)
	{
		
		$dataArray[$mycredits['state_abbr']]['credits'] += $mycredits['credit_numbers'];
		$dataArray[$mycredits['state_abbr']]['state_id'] = $mycredits['state_id'];
		$dataArray[$mycredits['state_abbr']]['state'] = $mycredits['state'];
		$dataArray[$mycredits['state_abbr']]['type'][][$mycredits['type']]= $mycredits['credit_numbers'];
		
	}
	
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
<div class="bg-lg-gray pad-tb bdl_det_wrp bd-min-hgt">
<div class="section-full inner-header" <?php if(isset($details[0]['back_color']) && $details[0]['back_color']!=''){ echo 'style="background-color:'.$details[0]['back_color'].'"';} ?>>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 text-center">
        
        <div class="bnd_img">
           <?php $img_file = DIR_IMAGES.''.$details[0]['bundle_image']; 
		        if(isset($details[0]['s3_images']) && $details[0]['s3_images']!='')
				{
		  ?>
          		<img src="<?php echo $details[0]['s3_images'];?>" width="164" height="236" alt="<?php echo trim($details[0]['bundle_name']);?>" title="<?php echo trim($details[0]['bundle_name']);?>"/>
          <?php				
				}else if (file_exists($img_file) || $details[0]['bundle_image']!='') {   //$this->config->item("upload_path")
		   ?>
           		<img src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $details[0]['bundle_image'];?>" width="164" height="236" alt="<?php echo trim($details[0]['bundle_name']);?>" title="<?php echo trim($details[0]['bundle_name']);?>"/>
           <?php  }else{ ?>
                 <img src="<?php echo $this->config->item("cdn_css_image")?>images/bundl-main-img.png" width="164" height="236" alt="<?php echo trim($details[0]['bundle_name']);?>" title="<?php echo trim($details[0]['bundle_name']);?>"/>
           <?php } ?> 
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /inner-header -->

<div class="section-full">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12 col-lg-offset-right-1 details-rgt pull-right">
        <div class="row mg-space">
          <div class="wht-panel bdl_dtl_info rmv-lr-xs">
            <div class="bdl_head clr-dl_blue"><?php echo trim($details[0]['bundle_name']);?>
              <div class="bdl_det_icon"><img width="19" height="23" src="<?php echo $this->config->item("cdn_css_image")?>images/bund-bag.png" alt="bag" /></div>
            </div>
            <div class="row">
              <div class="col-xs-6 text-left"><span class="bdl_prc">$<?php echo trim($details[0]['bundle_price']);?></span></div>
              <div class="col-xs-6 text-right">
                   <?php
				       $check_item = $this->cart_mod->check_item('Bundle',$details[0]['bundle_id'],$cart_id); 
					   if(count($check_item) > 0)
					   {
				   ?>
                    <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('bundle',<?php echo $cart_id;?>,<?php echo $details[0]['bundle_id'];?>,'true')">Remove</a>
                     <a class="btn fad-orange medium add-cart add" href="javascript:void(0)" style="display:none;" onclick="add_to_cart(<?php echo $details[0]['bundle_id'];?>,'bundle','true')">Add to Cart</a>
                   <?php }else{ ?>
                     <a class="btn fad-orange medium add-cart add" href="javascript:void(0)" onclick="add_to_cart(<?php echo $details[0]['bundle_id'];?>,'bundle','true')">Add to Cart</a>
                     <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('bundle',<?php echo $cart_id;?>,<?php echo $details[0]['bundle_id'];?>,'true')" style="display:none;">Remove</a>
				   <?php } ?>    
              </div>
            </div>
          </div>
          <div class="wht-panel credit-sec">
           <?php if(isset($cuserid) && $cuserid!=0){?>
             <!-- popup -->
            <div class="cust_pop_Sec cr_cnt_p reg_Ac" id="cr_inf">
              <div class="cus_Pop_Inner"> <!--<a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross visible-sm visible-xs"></a>--><a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross "></a>
                <h4 class="track_head visible-xs">Credit Tracker</h4>
                <i class="cr_inst">This course earned you an additional <span id="addcredit"></span> credits in <span id="creditcats"></span></i>
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
              <div class="cus_Pop_Inner"> <!--<a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross visible-sm visible-xs"></a>--><a href="javascript:void(0)" onclick="toggler('cr_inf');" class="close icon-cross "></a>
                <div class="non-register text-center"> <i class="cr_inst">Sorry, this feature is available to registered users only.</i> <a href="#" data-toggle="modal" data-target="#free_Join" class="btn fad-orange medium">JOIN NOW FOR FREE!</a> </div>
              </div>
            </div>
            <!-- no register close --> 
            <!-- /popup -->
             <?php } ?> 
            <div class="credit-details">
              <div class="crd-icon"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-diamond-blc.png" width="24" height="22" alt="Credit Diamond" /></div>
              <div class="cr-head"> <span class="text-line-select smp-drop max-scroll">
                <select id="categories" data-width="100%" class="selectpicker" onchange="credit_type(this,<?php echo $param_course;?>)">
                 <?php foreach($dataArray as $key => $states)
				 {
					  if($states['state_id'] == $details[0]['state_id']){
						  $selected = 'selected = "selected"';
						   $default_state = $key;
					  }else{
						  $selected = '';
					  }
				 ?>
                  <option value="<?php echo $states['state_id'];?>" <?php echo $selected?> id="<?php echo $key;?>"><?php echo $states['credits'];?> Credits - <?php echo $key;?></option>
                 <?php } ?> 
                </select>
                <input type="hidden" name="drop-down_state" value="<?php echo $default_state;?>" id="drop-down_state"/>
                </span> </div>
              <ul class="cr-list list-unstyled" id="credit_types"></ul>
            </div>
            <!-- /credit-sec -->
            
            <div class="cr-cnt"><a href="javascript:void(0)" onclick="toggler('cr_inf');">How does this affect my credit count? </a></div>
          </div>
          <div class="wht-panel bdl_desc rmv-lr-xs">
            <h5 class="head-sm">Bundle Description</h5>
            <p><?php echo $details[0]['bundle_desc']?></p>
            <h5 class="head-sm desc_head_2">Courses In This Bundle</h5>
            <div class="row bdl_sc_Grd bdl_2col_Grd">
            <?php if(count($bundle_courses) > 0){
				 foreach($bundle_courses as $key => $courses)
				 {
					 $cauthors_details = $this->course_mod->get_course_faculties($courses['course_author']);
					 $get_authors = array();
					 $course_authors = '';
					 foreach($cauthors_details as $cfaculties){
						 $get_authors[] = $cfaculties['first_name'].' '.$cfaculties['last_name'];
					 } 
					 
					 $course_authors = implode(', ',$get_authors);
					 $credits = $this->bundle_mod->get_course_credits($courses['course_id'],$details[0]['state_id']);
					 if($credits == ''){
						 $credits = '0.00';
					 }
			?>
              <div class="col-sm-6">
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" <?php if(isset($courses['back_color']) && $courses['back_color']!=''){ echo 'style="background-color:'.$courses['back_color'].'"';} ?>> 
                     <?php $img_course = DIR_IMAGES.''.$courses['course_image']; 
					 
					  if(isset($courses['s3_images']) && $courses['s3_images']!='')
				      {
					 ?>
                       <a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php echo $details[0]['state_id']?>"><img alt="<?php echo trim($courses['course_name']);?>" title="<?php echo trim($courses['course_name']);?>" src="<?php echo $courses['s3_images'];?>" class="bdl-img"></a> 	  
					 <?php }else if (file_exists($img_course) || $courses['course_image']!='') { ?> 
                      <a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php echo $details[0]['state_id']?>"><img alt="<?php echo trim($courses['course_name']);?>" title="<?php echo trim($courses['course_name']);?>" src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $courses['course_image'];?>" class="bdl-img"></a>
                     <?php }else{?>
                       <a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php echo $details[0]['state_id']?>"><img alt="<?php echo trim($courses['course_name']);?>" title="<?php echo trim($courses['course_name']);?>" src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-starcbuks.png" class="bdl-img"></a>
                     <?php } ?> 
                    <div class="bund-type">
                        <?php 
						  if($courses['course_format'] == 'Text')
						  {
							  $icon_image = 'bund-pdf.png';
						  }else if($courses['course_format'] == 'Video'){
							  $icon_image = 'bund-video-icon.png';
						  }
					 ?>
                      <img width="15" alt="Bag" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo $icon_image;?>">
                    </div>
                  </div>
                  <!-- /bund-img-sec -->
                  
                  <div class="bund-desc">
                    <div class="bdl-hd bundle-courses-listing">
	                    <h5><a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php echo $details[0]['state_id']?>" class="link-title"><?php echo trim($courses['course_name']);?></a></h5>
	                    <div class="bdl_small"><i><?php echo $course_authors;?></i></div>
                    </div>
                    <div class="ttl-credit"><img alt="credit-icon" src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png"><?php echo $courses['cpe_credits'];//$credits;?> credits</div>
                    <!--<div class="pre-cource"><a href="#"><i><img src="<?php //echo $this->config->item("cdn_css_image")?>images/ext-link.png" data-rjs="<?php //echo $this->config->item("cdn_css_image")?>images/2x/ext-link.png" width="10" alt="link" /> <span>preview course</span></i></a></div>-->
                    <a class="btn small_btn btn-blue-text" href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php echo $details[0]['state_id']?>">VIEW COURSE</a> </div>
                  <!-- /bund-desc --> 
                  
                </div>
                <!-- /bdl_Small --> 
              </div>
              <!-- /col -->
            <?php
				 }
			 } ?>  
            </div>
          </div>
        </div>
        <!-- /mg-space --> 
        
      </div>
      <!-- / col -->
      
      <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 details-left pull-left">
         
         <div class="bread-links hidden-xs">
<a href="<?php echo base_url();?>compliance-bundles" class="back-link"><span>Back To Bundles</span></a>
</div>
        <div class="row mg-space-left">
          <div class="wht-panel details-sidebar athr_grd">
            <h5 class="head-14">Course Authors:</h5>
            <div class="row fac-3col">
             <?php if(count($authors_details) > 0){
				 foreach($authors_details as $key => $authorsVal)
				 { 
				   $full_name = $authorsVal['first_name'].' '.$authorsVal['last_name'];
			 ?>
              <div class="col-xs-4">
                <div class="auth_sec text-center">
                  <div class="fac-img img-circle">
                   <?php  $filename = DIR_FACULTY_IMAGES.''.$authorsVal['faculty_image'];
				      if(isset($authorsVal['s3_image_path']) && $authorsVal['s3_image_path']!='')
				      {
					 ?>
                       <a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><img src="<?php echo $authorsVal['s3_image_path'];?>" width="78" height="78" alt="<?php echo $full_name?>" title="<?php echo $full_name?>"/></a>
                       
                 <?php }else if (file_exists($filename) || $authorsVal['faculty_image']!='') {
				   ?>		 
                      <a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><img src="<?php echo CLOUDFRONT_URL;?>faculties/<?php echo $authorsVal['faculty_image'];?>" width="78" height="78" alt="<?php echo $full_name?>" title="<?php echo $full_name?>"/></a>
                   <?php }else{ ?>
                      <a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/fac-3-full.jpg" width="78" height="78" alt="<?php echo $full_name?>" title="<?php echo $full_name?>"/></a>
                   <?php } ?>  
                   </div>
                  <div class="athr_name"><a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><?php echo trim($full_name);?></a></div>
                 <!-- <div class="athr_des"><?php //echo trim($authorsVal['firm_name']);?></div>-->
                </div>
                <!-- /auth_sec --> 
              </div>
              <!-- /col -->
              <?php
				 }
			   } ?>
            </div>
            <!-- /row -->
            
            <div class="row">
              <div class="col-xs-12 note-sec"> <strong>Please Note:</strong><br>
                <p>This course must be completed within 1 year of date of receipt of this course for CPE credit.</p>
              </div>
            </div>
            <!-- note-sec --> 
            
          </div>
          <!-- /wht-panel --> 
        </div>
        <!-- /mg-space-left --> 
      </div>
      <!-- /col --> 
      
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $('document').ready(function(){ 
	    $("#categories").trigger('change');
  })
</script>
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/cart.js"></script>