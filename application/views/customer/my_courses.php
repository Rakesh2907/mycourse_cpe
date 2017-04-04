<div class="section-full small-inner-head">
  <div class="container">
    <h4>Your Account</h4>
  </div>
</div>
<div class="container side-bar-brd">
  <div class="row acc_details_wrp">
    <?php $this->load->view('layouts/myaccount_sidebar'); ?>
    <div class="col-lg-8 col-lg-offset-1 col-md-9 acc-page-right">
      <div class="custom-tab-sec">
        <ul  class="nav nav-tabs">
          <li class="active"> <a  href="#not-started" data-toggle="tab">Not started <span class="badge"><?php echo sizeof($course_not_started); ?></span></a> </li>
          <li><a href="#in-prog" data-toggle="tab">In Progress <span class="badge"><?php echo sizeof($course_inprogres); ?></span></a> </li>
          <li id="comp"><a href="#complete" data-toggle="tab" >Complete <span class="badge"><?php echo sizeof($course_complete); ?></span></a> </li>
          <li id="arch" class="hidden-xs"><a href="#archived" data-toggle="tab">Archived <span class="badge"><?php echo sizeof($course_archive); ?></span></a> </li>
        </ul>
        <div class="tab-content clearfix">
          <div class="tab-pane active" id="not-started">
            <div class="row bdl_sc_Grd all_bdl_grd my-course-gr">
              <?php $notstarted_count=sizeof($course_not_started); 
      if($notstarted_count > 0)
      {
		 foreach($course_not_started as $arr_notstart)
		 {
			  
			 $fname=$arr_notstart['faculty_name'];
			 if(strlen($fname) > 75)
			{
			  $fname =	substr($fname, 0, 75);
			}
			$course_name=$arr_notstart['course_name'];
			
			if(strlen($course_name) > 55)
						{
						$pos = strpos($course_name,' ',50);
						if($pos)
							$course_name=substr($course_name, 0, $pos).'...';	
						}
			
			$course_formt =$arr_notstart['course_format'];
			
			if($course_formt == 'Webcast')
			{
			  $img_name='bund-video-icon.png';
			}
			elseif($course_formt == 'Text')
			{
			  $img_name='bund-pdf.png';
			}
?>
              <div class="col-sm-6">
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" style="background-color:<?php echo $arr_notstart['course_backcor'];?>"> 
                  
                   <?php 
				     if(isset($arr_notstart['s3_images']) && $arr_notstart['s3_images']!='')
					 { 
					?>
                     <img width="69" class="bdl-img" src="<?php echo $arr_notstart['s3_images']; ?>" alt="bundle">
                  <?php }else{ //$this->config->item("upload_path");?>
                  <img width="69" class="bdl-img" src="<?php echo CLOUDFRONT_URL?>images/<?php echo $arr_notstart['course_img']?>" alt="bundle">
                  <?php } ?> 
                    <div class="bund-type"><img width="18" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo $img_name; ?>" alt="PDF"></div>
                  </div>
                  <!-- /bund-img-sec -->
                  
                  <div class="bund-desc">
                    <div class="bdl-hd">
                      <h5><?php echo $course_name; ?></h5>
                      <div class="bdl_small"><i><?php echo $fname; ?></i></div>
                    </div>
                    <!-- /bdl-hd -->
                    <div class="cr-rev-wrp"><span class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $arr_notstart['course_credit']; ?> credits</span></div>
                    <div class="bdl-btn text-center"><a href="<?php echo base_url()?>take-course/<?php echo $arr_notstart['user_courses_id']?>" class="btn small_btn btn-blue-text">START COURSE</a></div>
                  </div>
                  <!-- /bund-desc --> 
                </div>
                <!-- /bdl_Small --> 
              </div>
              <?php  }}else{?>
              <div class="col-md-8 col-md-offset-2" id="norecord" >
                <div class="not-found"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" /> <i>Sorry, you have no courses to display in this tab.</i> </div>
                <!-- /not-found --> 
              </div>
              <?php }?>
            </div>
            <!--row --> 
            
          </div>
          <!-- /tab-pane -->
          
          <div class="tab-pane" id="in-prog">
            <div class="row bdl_sc_Grd all_bdl_grd my-course-gr">
              <?php $inprogres_count=sizeof($course_inprogres); 
      if($inprogres_count > 0)
      {
		 foreach($course_inprogres as $arr_inprogress)
		 { 
			 $fname1= $arr_inprogress['faculty_name'];
			 if(strlen($fname1) > 75)
			{
			  $fname1 =	substr($fname1, 0, 75);
			}			
			$course_name1=$arr_inprogress['course_name'];
			
			if(strlen($course_name1) > 55)
						{
						$pos = strpos($course_name1,' ',50);
						if($pos)
							$course_name1=substr($course_name1, 0, $pos).'...';	
						}
			$percentage=$arr_inprogress['completed_percentage'];
			
			$course_formt_in =$arr_inprogress['course_format'];
			
			if($course_formt_in == 'Webcast')
			{
			  $img_name_in='bund-video-icon.png';
			}
			elseif($course_formt_in == 'Text')
			{
			  $img_name_in='bund-pdf.png';
			}
?>
              <div class="col-sm-6">
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" style="background-color:<?php echo $arr_inprogress['course_backcor'];?>"> 
                  <?php 
				     if(isset($arr_inprogress['s3_images']) && $arr_inprogress['s3_images']!=''){ 
				  ?>
                     <img width="69" class="bdl-img" src="<?php echo $arr_inprogress['s3_images']; ?>" alt="bundle">
                  <?php }else{ //$this->config->item("upload_path");?>
                  <img width="69" class="bdl-img" src="<?php echo CLOUDFRONT_URL?>images/<?php echo $arr_inprogress['course_img']; ?>" alt="bundle">
                  <?php }?>
                    <div class="bund-type"><img width="18" src="<?php echo $this->config->item("cdn_css_image").'images/'.$img_name_in.''?>" alt="PDF"></div>
                  </div>
                  <!-- /bund-img-sec -->
         
                  <div class="bund-desc">
	                <div class="bdl-hd">
                    <h5><?php echo $course_name1; ?></h5>
                    <div class="bdl_small"><i><?php echo $fname1; ?></i></div>
	                </div>
                    <div class="cr-rev-wrp rev-crs-link"><span class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $arr_inprogress['course_credit']; ?> credits</span></div>
                    <div class="bdl-btn text-center"><a href="<?php echo base_url()?>take-course/<?php echo $arr_inprogress['user_courses_id']?>" class="btn small_btn btn-blue-text">TAKE COURSE</a></div>
                  </div>
                  <!-- /bund-desc --> 
                  <!-- progress bar -->
                  <div class="thm-progress clearfix">
                    <div class="progr-cap"><?php echo number_format($percentage,0); ?>% COMPLETE</div>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo number_format($percentage,0); ?>" aria-valuemin="0" aria-valuemax="<?php echo number_format($percentage,0); ?>" style="width:<?php echo number_format($percentage,0); ?>%"> </div>
                    </div>
                  </div>
                  <!-- progress bar close --> 
                </div>
                <!-- /bdl_Small --> 
              </div>
              <?php  }}else{?>
              <div class="col-md-8 col-md-offset-2" id="norecord" >
                <div class="not-found"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" /> <i>Sorry, you have no courses to display in this tab.</i> </div>
                <!-- /not-found --> 
              </div>
              <?php }?>
            </div>
            <!--row --> 
            
          </div>
          <!-- /tab-pane -->
          
          <div class="tab-pane" id="complete">
     <div class="hidden-xs note-wrp"><i>Note: courses completed more than 1 year ago will be automatically moved to the <a href="#archived" data-toggle="tab" id="arch1">Archived</a> tab.</i> </div>
            <div class="row bdl_sc_Grd all_bdl_grd my-course-gr">
              <?php $complete_count=sizeof($course_complete); 
      if($complete_count > 0)
      {
		 foreach($course_complete as $arr_complete)
		 {  
			 $fname2= $arr_complete['faculty_name'];
			
			if(strlen($fname2) > 75)
			{
			  $fname2 =	substr($fname2, 0, 75);
			}
			$course_name2=$arr_complete['course_name'];
			if(strlen($course_name2) > 55)
						{
						$pos = strpos($course_name2,' ',50);
						if($pos)
							$course_name2=substr($course_name2, 0, $pos).'...';	
						}
			
		$course_formt_comp =$arr_complete['course_format'];
			
			if($course_formt_comp == 'Webcast')
			{
			  $img_name_cm='bund-video-icon.png';
			}
			elseif($course_formt_comp == 'Text')
			{
			  $img_name_cm='bund-pdf.png';
			}
?>
              <div class="col-sm-6">
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" style="background-color:<?php echo $arr_complete['course_backcor'];?>"> 
                  
                   <?php 
				     if(isset($arr_complete['s3_images']) && $arr_complete['s3_images']!='')
					 { 
					?>
                     <img width="69" class="bdl-img" src="<?php echo $arr_complete['s3_images']; ?>" alt="bundle">
                  <?php }else{ ?>
                  <img width="69" class="bdl-img" src="<?php echo CLOUDFRONT_URL?>images/<?php echo $arr_complete['course_img']; ?>" alt="bundle">
                  <?php } ?>
                    <div class="bund-type"><img width="18" src="<?php echo $this->config->item("cdn_css_image").'images/'.$img_name_cm.''?>" alt="PDF"></div>
                  </div>
                  <!-- /bund-img-sec -->
                  
                  <div class="bund-desc">
	                  <div class="bdl-hd">
                    <h5><?php echo $course_name2; ?> </h5>
                    <div class="bdl_small"><i><?php echo $fname2; ?></i></div>
	                  </div>
                    <div class="cr-rev-wrp rev-crs-link"><a class="rv-crs" href="<?php echo base_url()?>take-course/<?php echo $arr_complete['user_courses_id'];?>">review course</a><span class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $arr_complete['course_credit'];?> credits</span></div>
                    
                    <?php
					
					      $download_pdf = $arr_complete['course_name_clean'].'_'.$arr_complete['user_courses_id'].'.pdf';
					?>
                    
                    <div class="bdl-btn text-center">
                      <?php 
					     if(isset($arr_complete['s3_course_certificate']) && $arr_complete['s3_course_certificate']!='')
				         {
					  ?>
                         <a href="<?php echo base_url()?>customer_con/download_awspdf/?file=<?php echo trim($arr_complete['s3_course_certificate']);?>&course_name=<?php echo trim($arr_complete['course_name_clean']);?>" class="btn small_btn btn-blue-text">DOWNLOAD CERTIFICATE</a>
                      <?php		 
                         }else{
                      ?>
                         <a href="<?php echo base_url()?>customer_con/dowload_pdf/?file=<?php echo $download_pdf;?>" class="btn small_btn btn-blue-text">DOWNLOAD CERTIFICATE</a>
                      <?php } ?>
                         </div>
                  </div>
                  <!-- /bund-desc --> 
                  <!-- progress bar -->
                  <div class="thm-progress comp-prg clearfix">
                    <div class="progr-cap"><span class="icon icon-circle-check"></span> Passed <?php echo date("m/d/Y", strtotime($arr_complete['course_complete_date']));?></div>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"> </div>
                    </div>
                  </div>
                  <!-- progress bar close --> 
                </div>
                <!-- /bdl_Small --> 
              </div>
              <?php  }}else{?>
              <div class="col-md-8 col-md-offset-2" id="norecord" >
                <div class="not-found"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" /> <i>Sorry, you have no courses to display in this tab.</i> </div>
                <!-- /not-found --> 
              </div>
              <?php }?>
            </div>
            <!--row --> 
            
          </div>
          <!-- tab-pane -->
          <div class="tab-pane" id="archived">
            <div class="row bdl_sc_Grd all_bdl_grd my-course-gr">
              <?php $archive_count=sizeof($course_archive); 
      if($archive_count > 0)
      {
		 foreach($course_archive as $arr_archive)
		 {
			$fname3= $arr_archive['faculty_name'];
			
			if(strlen($fname3) > 75)
			{
			  $fname3 =	substr($fname3, 0, 75);
			}
			$course_name3=$arr_archive['course_name'];
			if(strlen($course_name3) > 55)
						{
						$pos = strpos($course_name3,' ',50);
						if($pos)
							$course_name3=substr($course_name3, 0, $pos).'...';	
						}
			$course_formt_arr =$arr_archive['course_format'];
			
			if($course_formt_arr == 'Webcast')
			{
			  $img_name_arr='bund-video-icon.png';
			}
			elseif($course_formt_arr == 'Text')
			{
			  $img_name_arr='bund-pdf.png';
			}
			
?>
              <div class="col-sm-6">
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" style="background-color:<?php echo $arr_archive['course_backcor'];?>"> 
                   <?php 
				     if(isset($arr_archive['s3_images']) && $arr_archive['s3_images']!='')
					 { 
					?>
                     <img width="69" class="bdl-img" src="<?php echo $arr_archive['s3_images']; ?>" alt="bundle">
                  <?php }else{ ?>   
                  <img width="69" class="bdl-img" src="<?php echo CLOUDFRONT_URL?>images/<?php echo $arr_complete['course_img']; ?>" alt="bundle">
                  <?php } ?>
                    <div class="bund-type"><img width="18" src="<?php echo $this->config->item("cdn_css_image").'images/'.$img_name_arr.''?>" alt="PDF"></div>
                  </div>
                  <!-- /bund-img-sec -->
                  
                  <div class="bund-desc">
	                  <div class="bdl-hd">
                    <h5><?php echo $course_name3; ?> </h5>
                    <div class="bdl_small"><i><?php echo $fname3; ?></i></div>
	                  </div>
                    <div class="cr-rev-wrp"><span class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $arr_archive['course_credit'];?> credits</span></div>
                    
                    
                    <?php
					      $download_pdf = $arr_archive['course_name_clean'].'_'.$arr_archive['user_courses_id'].'.pdf';
					?>
                    
                    <div class="bdl-btn text-center">
                      <?php 
					     if(isset($arr_archive['s3_course_certificate']) && $arr_archive['s3_course_certificate']!='NULL')
				         {
					  ?>
                         <a href="<?php echo base_url()?>customer_con/download_awspdf/?file=<?php echo trim($arr_archive['s3_course_certificate']);?>&course_name=<?php echo trim($arr_archive['course_name_clean']);?>" class="btn small_btn btn-blue-text">DOWNLOAD CERTIFICATE</a>
                      <?php		 
                         }else{
                      ?>
                         <a href="<?php echo base_url()?>customer_con/dowload_pdf/?file=<?php echo $download_pdf;?>" class="btn small_btn btn-blue-text">DOWNLOAD CERTIFICATE</a>
                      <?php } ?>
                     </div>
                  </div>
                  <!-- /bund-desc --> 
                </div>
                <!-- /bdl_Small --> 
              </div>
              <?php  }}else{?>
              <div class="col-md-8 col-md-offset-2" id="norecord" >
                <div class="not-found"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" /> <i>Sorry, you have no courses to display in this tab.</i> </div>
                <!-- /not-found --> 
              </div>
              <?php }?>
            </div>
            <!--row --> 
            
          </div>
          <!-- tab-pane --> 
        </div>
      </div>
      <!-- /custom-tab-sec --> 
      
    </div>
  </div>
  <!-- /row --> 
</div>
<!-- container --> 
<script>
$("#arch1").click(function (){
	
	$("#arch").addClass('active');
	$("#comp").removeClass('active');
	});
	
 jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
</script>
