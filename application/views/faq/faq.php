<div class="bd-min-hgt">

<div class="section-full small-inner-head rem-mrg">
<div class="container">
<div class="row">
<div class="col-md-12 col-lg-12">
<h4>Customer Support</h4>
</div>
</div>
</div>
</div>

<div class="container side-bar-brd contact_wrp">
<div class="row acc_details_wrp">
 <div class="col-lg-2 col-md-2">
 <div class="sidebar-links">
 
 <div class="drop-nav-outer">
 <button data-toggle="dropdown" id="inp_impact" class="dropdown-toggle btn drp-btn visible-xs visible-sm">
 <span id="text">FAQ</span><span class="caret"></span></button>
 
 <ul id="drop-nav" class="dropdown-menu list-unstyled my_ac_nav">
 <li <?php if($navigation == 'faq'){ ?>class="active" <?php }?>><a href="javascript:void(0);">FAQ</a></li>
 <li><a href="<?php echo base_url();?>faq_con/contactus">Contact Us</a></li>
 </ul>
 </div> <!-- /drop-nav -->
 </div>
 </div> <!-- /col -->
 

 
 <div class="col-lg-7 col-lg-offset-1 col-md-9 page-content contact_wrp faq_wrp">
 
<div class="cont-form faq-content">
<div class="head-sec">
<h2>Frequently Asked Questions</h2>

<div class="srch-sec small-src">
<button class="btn" type="submit"><span class="icon-search"></span></button>
<input type="text" class="form-control" placeholder="Search FAQ" id="faq_search" ></div>
</div>
<div class="test1">
   <?php //ssecho "ll<pre>";print_r($faq_list); 
		     $count_faq = count($faq_list);
				if($count_faq > 0)
				{ 
				  foreach($faq_list as $row )
				  {
		   ?>
<div class="faq_Sec faqlist" id="faqlist1">
<h4><?php  echo $row['question']; ?></h4>
<p><?php  echo $row['answer']; ?></p>
</div> <!-- /Frequently Asked Questions -->

<?php
	 }
}?> 

</div>

</div> <!-- /cont-form -->
 
 </div>
 
</div><!-- /row -->
</div> <!-- container -->

</div> <!-- /bd-min-hgt -->
<script>
 
  $("#faq_search" ).keyup(function() {
	  var key1=$("#faq_search").val();
  
    	$.ajax({
				  url: base_url+'faq_con/get_faq_search',
				  dataType: 'html',
				  type: 'POST',
				  data: {
						key: key1
				  }
			}).done(function(response) {
				 //$("#loader").hide();
				 $('.test1').html('');
				if(response !='no'){
					
					$('.test1').html(response);
				}else{
					$('.test1').html('No faq found');
				}
		   });
});

 jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
</script>


