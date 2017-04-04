<?php
 $enddate1=date('Y-m-d',strtotime($bundle_details[0]['end_date']));
 $enddate=date('Y-m-d',strtotime($bundle_details[0]['end_date']));
//$enddate = '2016-10-20 23:59:59'; 
$enddate = ''.$enddate.' 23:59:59'; 
$now = new DateTime();
$future_date = new DateTime(''.$enddate1.' 23:59:59');
$interval = $future_date->diff($now);
$remday =$interval->format("%a");
$remhr=$interval->format("%h");
$remmin=$interval->format("%i");
$remsec=$interval->format("%s");
//echo $remday."hr".$remhr."min".$remmin."sec".$remsec;
    $intro_video=$bundle_details[0]['intro_video'];
	
	$bundle_courses = $this->landing_mod->get_bundle_courses($bundle_details[0]['bundle_courses']);
	
	$param_course = "'".trim($bundle_details[0]['bundle_courses'])."'";
	if(count($bundle_courses) > 0)
	{
		foreach($bundle_courses as $key => $courses){
			$authors[] = $courses['course_author'];
		}
		$myauthors = implode(',',$authors);
		$myauthors = implode(',', array_unique(explode(',',$myauthors)));
		$authors_details = $this->course_mod->get_course_faculties($myauthors);
	}
//echo "<pre>";print_r($authors_details);die;
 ?>
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
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.plugin.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.countdown.js"></script> 
<link href="<?php echo $this->config->item("cdn_css_image")?>css/jquery.countdown.css" rel="stylesheet">

<?php if($bundle_details[0]['hidedays']){
	
	$difference = strtotime($enddate) - time();
	$days = floor($difference / 86400);
	$enddate = time() + $difference - ($days * 86400);
	$formatdate = 'HMS';
	
}else{
	$enddate = strtotime($enddate);
	$formatdate = 'DHMS';
	}
?>

 <script>
  $(function () {
   var austDay = new Date(<?php echo $enddate * 1000;?>);
   $('#countdown_timer').countdown({until: austDay,format: '<?php echo $formatdate;?>'}); 
  });
 </script>
    
   
<div class="section-full landing-top  grd-bg">
<div class="container">
<div class="row">
<div class="col-lg-7 col-lg-offset-1 col-md-5 col-sm-7 col-xs-6 bdl-top-info">
<div class="text-uppercase tm-lmt">FOR A LIMITED TIME ONLY</div>
<h1><?php echo $bundle_details[0]['bundle_name']; ?></h1>

<div class="cr_info_Details hidden-xs">
<div class="credit-head"><div class="crd-icon"><img width="21" alt="Credit Diamond" src="<?php echo $this->config->item("cdn_css_image")?>images/credit-diamond-wht.png"></div> 
<?php echo $total_credit; ?> Credits</div>
<ul class="list-unstyled">
<?php
if(count($credits) > 0)
		{	
			 foreach($credits as $credit)
			 {
				$dataArray[$credit['type']]['credits'] += $credit['credit_numbers'];
				$dataArray[$credit['type']]['type'] = $credit['type'];
			 }
			 foreach($dataArray as $data)
			 {?>
<li><?php echo round($data['credits'],1).' credit - '.$data['type'];  ?></li>
 <?php }
 }?>

</ul>

</div>
</div> <!-- /col -->

<div class="col-lg-3 col-lg-offset-right-1 col-md-3 col-sm-4 col-sm-offset-1 col-xs-6 landing-right-info text-right pull-right">
<div class="prc-info">

<?php if($offer_price < ($bundle_details[0]['bundle_price']) && ($offer_price != 0.00) ){ ?>
<h1>$<?php echo $offer_price; ?></h1>

<span class="pre-prc">PREVIOUSLY <span>$<?php echo $bundle_details[0]['bundle_price']; ?></span></span>
<?php }else{?>
<h1>$<?php echo $bundle_details[0]['bundle_price']; ?></h1>

<?php }?>

</div> <!-- /prc-info -->
<!--<button class="btn fad-orange large">Buy Now</button>-->
      <?php            if($landing_status =='pendding')
	                  {
				       $check_item = $this->cart_mod->check_item('Bundle',$bundle_details[0]['bundle_id'],$cart_id); 
					   //echo "<pre>";print_r($check_item);die;
					   if(count($check_item) > 0)
					   {
				   ?>
                    <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('landing',<?php echo $cart_id;?>,<?php echo $bundle_details[0]['bundle_id'];?>,'true')">Remove</a>
                     <a class="btn btn fad-orange large add-cart add"  style="display:none;" href="javascript:void(0)" onclick="add_to_cart(<?php echo $bundle_details[0]['bundle_id'];?>,'landing','true')">Buy Now</a>
                   <?php }else{ ?>
                     <a class="btn btn fad-orange large add-cart add" href="javascript:void(0)" onclick="add_to_cart(<?php echo $bundle_details[0]['bundle_id'];?>,'landing','true')">Buy Now</a>
                     <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('landing',<?php echo $cart_id;?>,<?php echo $bundle_details[0]['bundle_id'];?>,'true')" style="display:none;">Remove</a>
				   <?php }}else{ ?>  
                 <a class="btn btn fad-orange large add-cart add" href="javascript:void(0)" >Already purchased</a>
                  <?php }?>
<?php if($bundle_details[0]['intro_video'] !=''){ ?>
<div class="vdo-prev hidden-xs"><a href="#" data-toggle="modal" data-target="#bdl_Prev" data-backdrop="false"> <span>PREVIEW THIS BUNDLE</span> </a></div>
<?php }?>
</div> <!-- /col -->


</div>
</div>
<div class="gr-texture"><img width="578" src="<?php echo $this->config->item("cdn_css_image")?>images/head-texture.png" alt="Texture"></div>
</div>

<div class="section-full bg-pale-grey visible-xs cr_info_Resp">
<div class="container">
<div class="credit-head"><span class="crd-icon"><img width="16" alt="Credit Diamond" src="<?php echo $this->config->item("cdn_css_image")?>images/credit-diamond-dull-bl.png"></span> 
<?php echo $total_credit; ?> Credits</div>
<ul class="list-unstyled">

<?php
if(count($credits) > 0)
		{
			 foreach($credits as $credit)
			 {?>
<li><?php echo round($credit['credit_numbers'],1).' credit - '.$credit['type'];  ?></li>
 <?php }}?>

</ul>
</div>
</div>

<div class="section-full bg-pale-grey offer-exp" <?php if($bundle_details[0]['hidecountdown']){echo 'style="display:none;"';}?>>

<div class="container text-center" id="clockdiv">

<h5 class="text-uppercase">ACT FAST! THIS OFFER EXPIRES IN</h5>
<div class="time-left" id="countdown_timer">
 </div>
<!--<div id="clockdiv">
<ul class="list-unstyled">
<li>
<span class="exp-fig days"></span>
<div class="exp-time">Days</div>
</li>
<li>
<span class="exp-fig hours"></span>
<div class="exp-time">Hours</div>
</li>
<li>
<span class="exp-fig minutes"></span>
<div class="exp-time">Minutes</div>
</li>
<li>
<span class="exp-fig seconds"></span>
<div class="exp-time">Seconds</div>
</li>
</ul>
</div>-->
</div>
</div> <!-- /offer-exp -->

<div class="container page-content landing-pg-cont bd-min-hgt">
<div class="row">
<div class="col-lg-10 col-lg-offset-1">

<div class="about-bdls">
<h3 class="heading_tx">About This Bundle</h3>
<p><?php echo $bundle_details[0]['bundle_desc']; ?></p>
</div>
 
<div class="bdl_sc_Grd all_bdl_grd">
<h3 class="heading_tx">Online Courses in This Bundle</h3>
<div class="row">
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
					 $credits = $this->landing_mod->get_course_credits($courses['course_id'],$bundle_details[0]['state_id']);
					 if($credits == ''){
						 $credits = '0.00';
					 }
			?>

<div class="bdl-col-adj col-md-4 col-sm-6">
<div class="bund-list-sec bdl_Small">
<div class="bund-img-sec" style="background-color:<?php echo $courses['back_color']; ?>">
<!--<img width="69" class="bdl-img" src="images/bundle-starcbuks.png" alt="bundle">-->
<?php $img_course = DIR_IMAGES.''.$courses['course_image']; 
		        		 if(isset($courses['s3_images']) && $courses['s3_images']!='')
				        {
		?>
        				<a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php  echo $bundle_details[0]['state_id'];?>"><img alt="<?php echo trim($courses['course_name']);?>" title="<?php echo trim($courses['course_name']);?>" src="<?php echo $courses['s3_images'];?>" width="69" class="bdl-img"></a>		
        <?php					
					    }else if (file_exists($img_course) || $courses['course_image']!='') { ?> 
                      <a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php  echo $bundle_details[0]['state_id'];?>"><img alt="<?php echo trim($courses['course_name']);?>" title="<?php echo trim($courses['course_name']);?>" src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $courses['course_image'];?>" width="69" class="bdl-img"></a>
                     <?php }else{?>
                       <a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php  echo $bundle_details[0]['state_id'];?>"><img alt="<?php echo trim($courses['course_name']);?>" title="<?php echo trim($courses['course_name']);?>" src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-starcbuks.png" width="69" class="bdl-img"></a>
                     <?php } ?> 
<div class="bund-type">

<img width="18" src="<?php echo $this->config->item("cdn_css_image")?>images/bund-pdf.png" alt="PDF">

</div>
</div> <!-- /bund-img-sec -->

<div class="bund-desc">
<div class="bdl-hd">
<h5><?php echo trim($courses['course_name']);?></h5>
<div class="bdl_small"><i><?php 
if(strlen($course_authors) > 45)
			{
			$course_authors=substr($course_authors, 0, 45);	
			}
echo $course_authors;
?></i></div>
</div>
<div class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $courses['cpe_credits'];//$credits;?> credits</div>
<a href="<?php echo base_url();?>individual-courses/<?php echo $courses['course_id']?>/<?php  echo $bundle_details[0]['state_id'];?>" class="btn small_btn btn-blue-text">VIEW Course</a>
</div> <!-- /bund-desc -->
</div>
</div> <!-- /bdl-col-adj -->
    <?php
				 }
			 } ?>  

</div> <!-- /row -->
</div> <!-- /bdl_sc_Grd all_bdl_grd -->

<div class="athr_grd faculty-wrp">
<h3 class="heading_tx">Authors</h3>

<div class="row">

 <?php if(count($authors_details) > 0){
				 foreach($authors_details as $key => $authorsVal)
				 { 
				   $full_name = $authorsVal['first_name'].' '.$authorsVal['last_name'];
			 ?>
<div class="col-lg-3 col-md-2 col-sm-3 col-xs-4 sec-wrp">
 <div class="auth_sec text-center">
<div class="fac-img img-circle">
<?php  $filename = DIR_FACULTY_IMAGES.''.$authorsVal['faculty_image'];
                     if($authorsVal['s3_image_path']!='' || $authorsVal['s3_image_path']!=''){
				?>
       					<a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><img src="<?php echo $authorsVal['s3_image_path'];?>" width="143" alt="<?php echo $full_name?>" title="<?php echo $full_name?>"/></a>
                <?php		 
					 }else if (file_exists($filename) || $authorsVal['faculty_image']!='') {
				   ?>		 
                      <a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><img src="<?php echo CLOUDFRONT_URL;?>faculties/<?php echo $authorsVal['faculty_image'];?>" width="143" alt="<?php echo $full_name?>" title="<?php echo $full_name?>"/></a>
                   <?php }else{ ?>
                      <a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/fac-3-full.jpg" width="143" alt="<?php echo $full_name?>" title="<?php echo $full_name?>"/></a>
                   <?php } ?>  
<!--<a href="#"><img width="143" src="images/fac-1.png" alt="Faculty"></a>-->

</div>
<div class="athr_name"><a href="<?php echo base_url();?>faculty_con/faculty_details/<?php echo $authorsVal['faculty_member_id'];?>"><?php echo trim($full_name);?></a></div>
<div class="athr_des"><?php echo trim($authorsVal['firm_name']);?></div>
</div> <!-- /auth_sec -->
 </div> 
 
   <?php
	 }
} ?>
 
</div> <!-- row -->

</div> <!-- /faculty-wrp -->
<input type="hidden" id="drop-down_state" value="<?php echo $state_abr;?>"  />
<div class="btn-sec with_links">
<?php
                        if($landing_status =='pendding')
	                  {
				       $check_item = $this->cart_mod->check_item('Bundle',$bundle_details[0]['bundle_id'],$cart_id); 
					  
					   if(count($check_item) > 0)
					   {
				   ?>
                    <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('landing',<?php echo $cart_id;?>,<?php echo $bundle_details[0]['bundle_id'];?>,'true')">Remove</a>
                     <a class="btn btn fad-orange large add-cart add" href="javascript:void(0)" style="display:none;" onclick="add_to_cart(<?php echo $bundle_details[0]['bundle_id'];?>,'landing','true')">Buy Now</a>
                   <?php }else{ ?>
                     <a class="btn btn fad-orange large add-cart add" href="javascript:void(0)" onclick="add_to_cart(<?php echo $bundle_details[0]['bundle_id'];?>,'landing','true')">Buy Now</a>
                     <a class="btn fad-orange medium add-cart remove" href="javascript:void(0)" onclick="remove_item('landing',<?php echo $cart_id;?>,<?php echo $bundle_details[0]['bundle_id'];?>,'true')" style="display:none;">Remove</a>
				   <?php }}else{ ?>
                    <a class="btn btn fad-orange large add-cart add" href="javascript:void(0)" >Already purchased</a>  
                    <?php } ?>
                   <span class="view-all"><a href="<?php echo base_url();?>compliance-bundles">View All Bundles</a></span>	
</div>

</div> <!-- /col -->
</div> <!-- /row -->
</div> <!-- /bd-min-hgt -->


 




<!-- drawer Menu -->

<!-- /drawer -->

<div role="dialog" class="modal fade vdo_Popup onl-vdo" id="bdl_Prev">
  <div class="modal-dialog mdl-cs-wd">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button"></button>
      </div>
      <div class="modal-body">
        
        <!-- overlay -->
        <div class="vdo-overlap1">
<!--<div class="play-icon"><img width="100" src="<?php echo $this->config->item("cdn_css_image")?>images/video-play.png" alt="Play"></div>-->

        
        <iframe width="696" height="520" src="<?php echo $intro_video; ?>" id="player_1"></iframe>
        
        </div><!-- overlay -->
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">var current_user_id = '<?php echo $cuserid;?>';</script>
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/cart.js"></script>
<!--<script>
function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}
function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');
  function updateClock() {
    var t = getTimeRemaining(endtime);
    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }
  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}
var deadline = new Date(Date.parse(new Date()) + <?php //echo $remday; ?> * 24 * 60 * 60 * 1000);
//var deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000);
initializeClock('clockdiv', deadline);
</script>
-->