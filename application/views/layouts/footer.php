<div class="help-wrp rmv-tp-mrg">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 text-left help-que"><strong>Questions?</strong> <a href="<?php echo base_url();?>faq_con/contactus">Get some help</a></div>
      <div class="col-sm-6 text-right help-no">888.656.5334 | <a href="mailto:help@cpenation.com">help@cpenation.com</a></div>
    </div>
  </div>
</div>
<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-9 col-xs-12 pull-right footer-links">
        <ul class="list-unstyled list-inline">
          <li><a href="<?php echo base_url();?>index_con/get_cms/about">ABOUT</a></li>
          <li><a href="<?php echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
          <li><a href="<?php echo base_url();?>individual-courses">COURSES</a></li>
          <li><a href="<?php echo base_url();?>faq_con/get_faq">FAQ</a></li>
          <li><a href="<?php echo base_url();?>index_con/get_cms/terms">Terms</a></li>
        </ul>
      </div>
      <div class="col-md-4 col-sm-3 col-xs-12 footer-logo"><a href="<?php echo base_url();?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-wht.png" alt="CPENATION" /></a></div>
    </div>
    <div class="row"><div class="col-md-12 col-sm-12 col-xs-12 nasba-number">CPE Nation is a registered sponsor on the National Registry of CPE Sponsors. Our Sponsor Identification Number is 138340.</div></div>
  </div>
</div>
<!-- /footer -->

</div>
<!-- /page --> 

<!-- drawer Menu -->
<div class="mobile-nav sidebar-off-canvas main-nav">
  <ul class="nav navbar-nav">
    <li class="active"><a href="<?php echo base_url();?>">Home</a></li>
    <li><a href="<?php echo base_url();?>compliance-bundles">BUNDLES</a></li>
   <li><a href="<?php echo base_url();?>subscriptions">SUBSCRIPTIONS</a></li>
    <li><a href="<?php echo base_url();?>individual-courses">CATALOG</a></li>
      <li><a href="<?php echo base_url();?>state_con/state_equirement/">REQUIREMENTS</a></li>
    <li><a href="<?php echo base_url();?>faq_con/contactus">HELP</a></li>

     <?php if($this->session->userdata('user_id')){?> 
         
 			<li><a href="<?php echo base_url();?>mycourses">ACCOUNT</a></li>
            <li><a class="cart-mn" href="<?php echo base_url();?>cart">
            <img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /> 
            <span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
          <li class="btn-link"><a href="<?php echo base_url();?>logout" class="btn">LOG OUT</a></li>
        <?php }else{ ?>
          <li><a class="cart-mn" href="<?php echo base_url();?>cart"><img class="cart-bsk menu_ic_wht" src="<?php echo $this->config->item("cdn_css_image")?>images/cart-basket.png" width="24" alt="cart" /><span id="mycount" class="mycount">Cart (<?php if($this->session->userdata('cart_count')!=''){ echo $this->session->userdata('cart_count');}else{echo '0';}?>)</span></a></li>
        <li class="btn-link"><a href="<?php echo base_url();?>customer_con/login" class="btn">LOG IN</a></li>
    <?php } ?>

  </ul>
</div>
<!-- /drawer --> 
<!-- Modal -->
<div id="free_Join" class="modal fade cst-flat-popup" role="dialog" style="overflow:hidden;">
  <div class="modal-dialog mdl-cs-wd"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center">Join Now</h4>
      </div>
      <div class="modal-body"> 
        <!-- Form -->
        <div id="loader_acc" style="display:none; position:relative; left:40%; top:35%;"><img src="<?php echo $this->config->item("cdn_css_image")?>images/ajax-loader.gif" alt="close" /></div>

        <form class="cust_Form" id="account_form" method="post" name="account_form">
          <div class="row form-adj-col">
            <div class="col-sm-6 col-1">
              <div class="form-group">
                <label class="control-label up_text">First Name</label>
                <input type="text" class="form-control" name="fname" id="fname" required="required"/>
              </div>
            </div>
            <div class="col-sm-6 col-2">
              <div class="form-group">
                <label class="control-label up_text">Last Name</label>
			    <input type="text" class="form-control" name="lname" id="lname" required="required"/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label up_text">Email</label>
            <input type="email" class="form-control" name="email" id="email" required="required"/>
          </div>
          <div class="form-group max-field">
            <label class="control-label up_text">Create Password</label>
            <div class="pass-fld">
            <input type="password" class="form-control pwd" name="password" id="password" required="required">

              <a href="javascript:void(0)" class="reveal" id="show_hide">Show</a> </div>
          </div>
          <div class="form-group state_sear">
            <label class="control-label up_text">Credit States</label>
            <ul class="list-inline state_tags" id="selction-ajax"></ul>
          </div>
          <div class="form-group max-field">
            <div class="srch-sec">
              <button type="submit" class="btn"><span class="icon-search"></span></button>
              <input type="text" placeholder="Search for States" class="form-control" name="course_state" id="autocomplete-ajax" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label up_text">CERTIFICATIONS</label>
            <ul class="list-unstyled list-inline check_stl">
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG1" name="certifications[]" value="CPA">

                <label class="css-label" for="checkboxG1">CPA</label>
              </li>
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG2" name="certifications[]" value="CFP">
                <label class="css-label" for="checkboxG2">CFP</label>
              </li>
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG3" name="certifications[]" value="EA">
                <label class="css-label" for="checkboxG3">EA</label>
              </li>
              <li>
                <input type="checkbox" class="css-checkbox" id="checkboxG4" name="certifications[]" value="RTRP">
                <label class="css-label" for="checkboxG4">RTRP</label>
              </li>
            </ul>
          </div>
           <div class="btn-sec text-center">
           <!-- <a class="btn fad-orange medium" href="javascript:void(0)" id="create_account">Create Account</a>-->
             <input class="btn fad-orange medium" type="submit" value="Create Account" onfocus="this.blur()" />
             <input type="hidden" name="selected_states" value="" id="selected_states"/>
          </div>
        </form>
        <!-- /Form --> 
      </div>
    </div>
  </div>
</div>
<!-- Modal close --> 
<!-- Modal -->
<div id="leave-comment" class="modal fade cst-flat-popup" role="dialog">
  <div class="modal-dialog mdl-cs-wd leave_com"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center">Leave Course Feedback&nbsp;&nbsp;<span id="feedbackstatus"></span></h4>
      </div>
      <div class="modal-body"> 
        <!-- Form -->
        <div id="loader_feedback" style="display:none; position:relative; left:40%; top:35%;"><img src="<?php echo $this->config->item("cdn_css_image")?>images/ajax-loader.gif" alt="close" /></div>
        <form class="cust_Form" id="cfeedback_form" method="post" name="cfeedback_form">
          <div class="form-group">
            <textarea class="form-control" placeholder="Leave feedback or ask a question about this course." id="comment"></textarea>
          </div>
          <div class="form-group">
            <div class="check_stl">
             <!-- <input type="checkbox" class="css-checkbox" id="checkboxG1" name="checkboxG1">-->
              <label class="css-label" for="checkboxG1">This feedback is for the author of this course.</label>
            </div>
          </div>
          <div class="btn-sec text-center">
            <!-- <a class="btn fad-orange medium" href="#">SEND FEEDBACK</a>-->
              <input class="btn fad-orange medium" type="submit" value="SEND FEEDBACK" onfocus="this.blur()" />
           </div>
        </form>
        <!-- /Form --> 
      </div>
    </div>
  </div>
</div>
<!-- Modal close -->
<!-- Modal -->


<!-- /added to cart pop-up satrt  --> 
<div style="overflow:hidden;" role="dialog" class="modal fade cst-flat-popup" id="added_to_cart">
  <div class="modal-dialog mdl-cs-wd">     
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button" style="z-index:9"></button>
        
      </div>
      <div class="modal-body" id="show_message" > </div>
    </div>
  </div>
</div>
<!-- /added to cart pop-up ends  -->

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/bootstrap.min.js"></script> 

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

<script src="<?php echo $this->config->item("cdn_css_image")?>js/bootstrap-select.js"></script> 
<script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script> 

<!-- drawer --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/TweenMax.min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jv-jquery-mobile-menu-min.js"></script> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/script-right.js"></script> 
<!-- /drawer --> 

<!-- accordian --> 
<script>
/*	$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-up").removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-down").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
});*/
	</script> 
<!-- accordian close --> 

<!-- /scroller --> 
<script src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.mCustomScrollbar.concat.min.js"></script> 
<script>
		(function($){
			$(window).load(function(){
				
				$(".filter-max-ht").mCustomScrollbar({
					theme:"dark-2"
				});
					
				$(".max-scroll .bootstrap-select .dropdown-menu.inner, .smlr_Course .bdl_sc_Grd, .notes_sec").mCustomScrollbar({
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

$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
	    $('#show_hide').html('Hide');
    } else {
        $pwd.attr('type', 'password');
	    $('#show_hide').html('Show');
    }
});
</script> 
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.autocomplete.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>js/mycustom.js"></script> 

<!-- /filter show hide -->
<script>
    var account_states = new Array();
	var myselected_state = '';
   $('document').ready(function(){	 
       if(my_selecte_state!='')
	   {
				    account_states = my_selecte_state;
	   }
	    
       $('#autocomplete-ajax').autocomplete({
        serviceUrl: base_url+'state_con/get_states',
        onSelect: function (suggestion) {
            $("#autocomplete-ajax").val('');
			//alert(account_states+'---'+suggestion.data);
			 if($.inArray(suggestion.data, account_states) !== -1)
			 {
				 alert('Already selected');
			 }else{
			
            	$('#selction-ajax').append('<li id="selstate_'+suggestion.data+'"><span>'+suggestion.value+' <a href="javascript:void(0)" class="close icon-cross" onclick="close_state('+suggestion.data+')"></a></span></li>');
			     		 
            	account_states.push(suggestion.data);
				myselected_state = account_states.join();
				$("#selected_states").val(myselected_state);
				$('#autocomplete-ajax').removeAttr('required');
			 }
        }
});
       
       $('#account_form').submit( function(e){
          e.preventDefault();
          var certificate = new Array(); 
          $("#free_Join input:checked").each(function() {
               certificate.push($(this).val());
          });
          $("#account_form").hide();
          $("#loader_acc").show();
          $.ajax({
              url: base_url+'customer_con/registration',
              dataType: 'html',
              type: 'POST',
              data: {
                            mysubmit: 'registration',
                            email: $('#email').val(),
                            fname: $('#fname').val(),
                            lname: $('#lname').val(),
                            password: $('#password').val(),
                            course_state: account_states,
                            ajax_login: 1,
                            certifications: certificate
                  }
            }).done(function(response){
                if(response == 'success'){
                    location.reload();
                }else if(response == 'email_exits'){
                     $("#account_form").show();
                       $("#loader_acc").hide();
                    alert('Email already exits...!');
                }else{
                    $("#account_form").show();
                      $("#loader_acc").hide();
                    alert('Login failed...!');
                }
            });  
    });
      
   });
   function close_state(state_id)
   {
        //var account_states = my_selecte_state;
	   $('#selstate_'+state_id).remove();
       $("#autocomplete-ajax").val('');
	   var selected_states = $("#selected_states").val();
	   /*index = account_states.indexOf(state_id);
	   alert(state_id);
       if (index > -1) 
       {
                    account_states.splice(index, 1);
					alert(account_states);
					$("#selected_states").val(account_states);
       }*/
	   
	   account_states = $.grep(account_states, function(value) {
  			return value != state_id;
	   });
	   $("#selected_states").val(account_states);
	   //alert('Array after removing the element = '+account_states);
	   
   } 
</script>
    <script>
	$('.main-nav ul li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeIn(400);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeOut(230);
});
	</script>
<!-- /filter show hide -->
<?php include_once("ga.php") ?>
</body></html>