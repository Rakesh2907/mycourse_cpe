<?php 
			$image_name  = $faculty_info[0]['faculty_image'];
			$faculty_name= ucfirst($faculty_info[0]['first_name'])." ".ucfirst($faculty_info[0]['last_name']);
			$faculty_practice=$faculty_info[0]['practice_area_id'];
			$faculty_firm = $faculty_info[0]['firm_name'];
			
			if($faculty_info[0]['s3_image_path']!='')
			{
				$image_name = $faculty_info[0]['s3_image_path'];
		    }else if($faculty_info[0]['faculty_image']!=''){ //$this->config->item("upload_path");
				$image_name = CLOUDFRONT_URL.'faculties/'.$faculty_info[0]['faculty_image'];
			}else{
			  	$image_name= $this->config->item("upload_path").'faculty/default.jpg';	
		    }
			
?>

<div class="bd-min-hgt">
  <div class="section-full bg-pale-grey-clr fac-bio-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 col-lg-offset-1 col-md-3 col-sm-3 col-xs-12">
          <div class="fac-prf-mng">
            <div class="fac-img img-circle"><img src="<?php echo $image_name ;?>" width="124" alt="Faculty" /></div>
          </div>
        </div>
        <div class="col-sm-9 col-xs-12">
          <div class="fac-head-info">
            <h4><?php echo $faculty_name;?>
              <?php //echo $faculty_practice;  ?>
            </h4>
            <div class="otr-text"><?php echo $faculty_firm; ?></div>
          </div>
          <!-- /fac-head-info --> 
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-3 col-sm-9 col-sm-offset-3">
        <div class="fc-bio-Sec">
          <div class="abt-fac"> <?php echo nl2br($faculty_info[0]['bio_data']); ?> </div>
          <div class="user_Crs col-sm-offset-right-1 col-md-offset-right-0">
            <?php
$count_courses = count($facultt_course);
if($count_courses > 0)
{ ?>
            <h5 class="head-sm">Courses by <?php echo $faculty_name; ?></h5>
            <div class="row bdl_sc_Grd all_bdl_grd">
              <?php foreach($facultt_course as $course )
					{
?>
              <div class="col-md-4 col-sm-6">
                <div class="bund-list-sec bdl_Small">
                  <div class="bund-img-sec" <?php if(isset($course['back_color']) && $course['back_color']!=''){ echo 'style="background-color:'.$course['back_color'].'"';} ?>>
                    <?php $img_file = DIR_IMAGES.''.$course['course_image']; 
				    if(isset($course['s3_images']) && $course['s3_images']!='')
				    {
		 		 ?>	
		   			 <a href="<?php echo base_url();?>individual-courses/<?php echo $course['cid'];?>/<?php echo $stateid;?>"><img src="<?php echo $course['s3_images'];?>" class="bdl-img"></a>
           		<?php 			
					}elseif (file_exists($img_file) || $course['course_image']!='') { // $this->config->item("upload_path");	
			 	?>
                    <a href="<?php echo base_url();?>individual-courses/<?php echo $course['cid'];?>/<?php echo $stateid;?>"><img src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $course['course_image'];?>" class="bdl-img"></a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url();?>individual-courses/<?php echo $course['cid'];?>/<?php echo $stateid;?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/bundl-main-img.png" class="bdl-img" /></a>
                    <?php }?>
                    <div class="bund-type">
                      <?php 
					  if($course['course_format'] == 'Text')
					  {
						  $icon_image = 'bund-pdf.png';
					  }else if($course['course_format'] == 'Webcast'){
						  $icon_image = 'bund-video-icon.png';
					  }
					 ?>
                      <img width="18" alt="Bag" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo $icon_image;?>">
                    </div>
                    <div class="bund-price">$<?php echo $course['course_price'];?></div>
                  </div>
                  <!-- /bund-img-sec -->
                  <div class="bund-desc">
                    <div class="bdl-hd">
                      <h5><a href="<?php echo base_url();?>individual-courses/<?php echo $course['cid'];?>/<?php echo $stateid;?>" class="link-title"><?php echo $course['coursename'];?></a></h5>
                      <div class="bdl_small"><i><?php echo $course['faculty_name'];?></i></div>
                    </div>
                    <div class="ttl-credit"><img alt="credit-icon" src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png"><?php echo $course['cpe_credits'];//$course['credit'];?> credits</div>
                    <a class="btn small_btn btn-blue-text" href="<?php echo base_url();?>individual-courses/<?php echo $course['cid'];?>/<?php echo $stateid;?>">VIEW Course</a> </div>
                  <!-- /bund-desc --> 
                </div>
                <!-- /bdl_Small --> 
              </div>
              <!-- /col -->
              <?php } ?>
            </div>
            <!-- /row -->
            <?php }?>
          </div>
          <!-- /user_Crs --> 
          
        </div>
        <!-- /fC-text-Sec --> 
      </div>
    </div>
    <!-- /row --> 
  </div>
  <!-- /container --> 
  
</div>
<!-- /bd-min-hgt -->