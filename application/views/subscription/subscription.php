<?php if(count($subscription_details) > 0) { ?>
<script type="text/javascript">var current_user_id = '<?php echo $cuserid;?>';</script>
<div class="bd-min-hgt">
<div class="section-full subscr_top">
  <div class="col-sm-6 grd-bg sbc-prc-inf">
    <div class="subs_prc_wrp">
      <div class="subs_prc">$<?php echo number_format($subscription_details[0]['price'],0)?></div>
    </div>
  </div>
  <!-- /subs_prc_wrp -->
  
  <div class="col-sm-6 subs_info_wrp">
    <div class="subs_text-cont">
      <h4>Unlimited Access to Our Entire Catalog</h4>
      <h1><?php echo trim($subscription_details[0]['title']);?></h1>
      <ul class="list-unstyled">
        <li>Access to all of our courses</li>
        <li>Written and video content</li>
        <li>Save up to 90% on your CPE</li>
      </ul>
      <?php
	     $check_item = $this->cart_mod->check_item('Subscription',$subscription_details[0]['subscription_id'],$cart_id); 
		 if(count($check_item) > 0)
		 {
	 ?>
     		<div class="btn-sec text-center"><a class="btn fad-orange large remove" href="javascript:void(0)" onclick="remove_item('subscription',<?php echo $cart_id;?>,<?php echo $subscription_details[0]['subscription_id'];?>,'true')">REMOVE</a><a class="btn fad-orange large add" href="javascript:void(0)" style="display:none;" onclick="add_to_cart(<?php echo $subscription_details[0]['subscription_id'];?>,'subscription','true')">BUY NOW</a></div>
     <?php }else{ ?>
        <div class="btn-sec text-center"><a class="btn fad-orange large remove" href="javascript:void(0)" onclick="remove_item('subscription',<?php echo $cart_id;?>,<?php echo $subscription_details[0]['subscription_id'];?>,'true')" style="display:none;">REMOVE</a><a class="btn fad-orange large add" href="javascript:void(0)" onclick="add_to_cart(<?php echo $subscription_details[0]['subscription_id'];?>,'subscription','true')">BUY NOW</a></div>
	 <?php	 } ?>
      
    </div>
    <!-- /subs_text-cont --> 
  </div>
  <!-- /subs_info_wrp --> 
  
</div>
<!-- /section-full -->

<div class="section-full bg-pale-grey-clr">
  <div class="section-full bg-wht">
    <div class="container how-work-wrp">
      <h3 class="txt-head text-center">How it Works</h3>
      <div class="row">
        <div class="col-sm-4 text-center wrk-steps-outer">
          <div class="wrk_img"><img class="img-circle" src="<?php echo $this->config->item("cdn_css_image")?>images/work-step-1.png" width="177" alt="Step 1" /></div>
          <h4>Buy a Subscription</h4>
          <p>Pay once up front, your subscription will last for a full year.</p>
        </div>
        <!-- /wrk-steps-outer -->
        
        <div class="col-sm-4 text-center wrk-steps-outer">
          <div class="wrk_img"><img class="img-circle" src="<?php echo $this->config->item("cdn_css_image")?>images/work-step-2.png" width="177" alt="Step 2" /></div>
          <h4>Select Your Courses</h4>
          <p>Browse our full catalog. Any course you'd like to take, regardless of format, can be added to your account for free.</p>
        </div>
        <!-- /wrk-steps-outer -->
        
        <div class="col-sm-4 text-center wrk-steps-outer">
          <div class="wrk_img"><img class="img-circle" src="<?php echo $this->config->item("cdn_css_image")?>images/work-step-3.png" width="177" alt="Step 3" /></div>
          <h4>Earn Your Credit</h4>
          <p>Complete your courses at your own pace. Finish them within a year to earn your credit!</p>
        </div>
        <!-- /wrk-steps-outer --> 
        
      </div>
      <!-- /row --> 
    </div>
    <!-- container --> 
    
  </div>
  <!-- /section-full bg-wht -->
  
  <div class="section-full bg-pale-grey faq-content-outer">
    <div class="container">
      <div  class="row">
        <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1">
          <h3 class="text-head text-center">Subscription FAQ</h3>
          <?php 
		  		foreach($subscription_faq as $key => $faq)
		  		{ 
		  ?>
                  <div class="faq_sec_wrap">
                    <h4><?php echo trim($faq['question']);?></h4>
                    <p><?php echo trim($faq['answer']);?></p>
                  </div>
         <?php  } ?> 
        </div>
        <!-- /col --> 
        
      </div>
    </div>
  </div>
  <!-- /section-full --> 
  
</div>
 </div> <!-- /bd-min-hgt -->
<input type="hidden" value="<?php echo $mystate_abr;?>" id="drop-down_state" />
<!-- /bd-min-hgt -->
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/cart.js"></script>
<?php }else{ ?>
 <div class="container">
   <div id="norecord" class="col-md-8 col-md-offset-2">
			<div class="not-found">
			<img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" alt="Not Found" width="50">
			<i>Sorry, no subscription were found...!</i>
			</div>
   </div>
 </div>  
 

<?php }?>