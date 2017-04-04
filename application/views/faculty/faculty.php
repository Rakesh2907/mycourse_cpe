<div class="section-full small-inner-head rem-mrg">
<div class="container">
<div class="row">
<div class="col-md-12 col-lg-11 col-lg-offset-1">
<h4>Faculty</h4>
</div>
</div>
</div>
</div>

<div class="section-full bg-pale-grey-clr bd-min-hgt">
<div class="section-full bg-wht">
<div class="container athr_grd faculty-wrp">
<div class="row">
 
 <div class="fac-mng"> 
 
 <?php 
			
	$count_faculty = count($faculty);
	if($count_faculty > 0)
	{ 
	 foreach($faculty as $row )
		{
			$image_name=$row['faculty_image'];
			if($row['s3_image_path']!='')
			{
				$image_name = $row['s3_image_path'];
		    }else if($row['faculty_image']!=''){ //$this->config->item("upload_path")
				$image_name = CLOUDFRONT_URL.'faculties/'.$row['faculty_image'];
			}else{
			  	$image_name= $this->config->item("upload_path").'faculty/default.jpg';	
		    }
			?>
 <div class="col-sm-2 col-xs-4 sec-wrp">
 <div class="auth_sec text-center">
<div class="fac-img img-circle"><a href="<?php echo $this->config->item('base_url');?>faculty_con/faculty_details/<?php echo $row['faculty_member_id']; ?>"><img width="125" alt="Faculty" src="<?php echo $image_name ;?>"></a></div>
<div class="athr_name"><a href="<?php echo $this->config->item('base_url');?>faculty_con/faculty_details/<?php echo $row['faculty_member_id'];?>"><?php echo ucfirst($row['first_name'])." ".ucfirst($row['last_name']);?></a></div>
<div class="athr_des"><?php //echo $row['practice_area_id']; ?></div>
</div> <!-- /auth_sec -->
 </div>
 
  <?php
				 }
}?>
 
 
 
  
 
  
 
  </div> <!-- /fac-mng -->

</div><!-- /row -->
</div> <!-- container -->

</div> <!-- /section-full bg-wht -->

<div class="section-full bg-pale-grey fac-text-outer">
<div class="container">
<div  class="row">

<div class="col-md-10 col-md-offset-1">

<div class="fac-text-section text-center">
<h3>Join the most innovative CPE provider in the country</h3>
<p>At CPE Nation, we are dedicated to providing the most innovative and relevant courses, and it is through our team of distinguished faculty members that we are able to accomplish this goal.  We are always seeking new faculty members to join our team.  If you are interested in becoming part of the CPE Nation team, please complete the contact form below.  We look forward to hearing from you!</p>

<a href="<?php echo base_url();?>faculty_con/join_faculty" class="btn fad-orange large">JOIN US</a>
</div> <!-- /fac-test-section -->

</div> <!-- /col -->

</div>
</div>
</div> <!-- /section-full -->

</div> <!-- /bd-min-hgt -->





<!-- drawer Menu -->

<!-- /drawer -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
        
        <!-- Sticky -->
    <script type="text/javascript">
		$(document).ready(function() {
			// grab the initial top offset of the navigation 
		   	var stickyNavTop = $('.header-top').offset().top;
		   	
		   	// our function that decides weather the navigation bar should have "fixed" css position or not.
		   	var stickyNav = function(){
			    var scrollTop = $(window).scrollTop(); // our current vertical position from the top
			         
			    // if we've scrolled more than the navigation, change its position to fixed to stick to top,
			    // otherwise change it back to relative
			    if (scrollTop > stickyNavTop) { 
			        $('.header-top').addClass('sticky');
			    } else {
			        $('.header-top').removeClass('sticky'); 
			    }
			};

			stickyNav();
			// and run it again every time you scroll
			$(window).scroll(function() {
				stickyNav();
			});
		});
		
	
	</script>
 
     <!-- close Sticky -->
        
        
        <script src="js/bootstrap-select.js"></script>
        <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>
        
        
        <!-- drawer -->
        <script src="js/TweenMax.min.js"></script>
     <script src="js/jv-jquery-mobile-menu-min.js"></script>
     <script src="js/script-right.js"></script>
    <!-- /drawer -->
    
   <!-- accordian -->
    <script>
	$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-up").removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-down").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
});
	</script>
    <!-- accordian close -->
    
    <!-- /scroller -->
       <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
       <script>
		(function($){
			$(window).load(function(){
				
			
				$(".max-scroll .bootstrap-select .dropdown-menu.inner").mCustomScrollbar({
					theme:"dark-2"
				});
											
			});
		})(jQuery);
	</script>
    <!-- /scroller close -->
    
    <!-- filter show hide -->
        <script>
    function toggler(divId) {
    $("#" + divId).toggle();
}
</script>
<!-- /filter show hide -->
<!-- password to text -->
<script>
$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
</script>
<!-- /password to text -->

<!-- Dropdown links -->
 <script>
 $('.dropdown-toggle').dropdown();
$('#drop-nav li > a').click(function(){
    $('#text').text($(this).html());
});
 </script>
 <!-- Dropdown links close -->

</body>
</html>