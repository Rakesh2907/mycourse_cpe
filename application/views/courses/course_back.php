<div class="section-full bd-pd-tp-16 mng-filter mng-filter-catalog bd-min-hgt">



<div id="filt_Cont" class="filter-sidebar br-cat-Flt mult-filter" style="display:none !important;">
<div class="filter_inner">
<div class="close-sec">Hide Filters <span class="close icon-cross" id="hideFilter" onclick="toggler('filt_Cont');"></span></div>

<div class="panel-group custom-panel" id="accordion">
  <div class="panel flt_state">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          State  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseOne" class="panel-collapse collapse in">
    
    <div class="search-sec">
    <button class="btn" type="submit"><span class="icon-search"></span></button>
     <input type="text" class="form-control" placeholder="Search States" /></div>
    
      <div class="panel-body filter-max-ht cust-scroll">
        
        <ul class="list-unstyled" id="stateList">
                <?php foreach($states as $key => $stateval){?>
                <li>
                  <input type="checkbox" name="states[]" id="checkboxG<?php echo $stateval['state_id'];?>" class="css-checkbox" value="<?php echo $stateval['state_id'];?>" data-label="<?php echo trim($stateval['state']);?>"/>
                  <label for="checkboxG<?php echo $stateval['state_id'];?>" class="css-label"><?php echo trim($stateval['state']);?></label>
                </li>
                <?php } ?>
              </ul>
      </div>
    </div>
  </div> <!-- panel -->
  
  <div class="panel flt_Topic">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Topic  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseTwo" class="panel-collapse collapse in">
    
    <div class="search-sec">
    <button class="btn" type="submit"><span class="icon-search"></span></button>
     <input type="text" class="form-control" placeholder="Search Topics" /></div>
    
      <div class="panel-body filter-max-ht cust-scroll">
     <ul class="list-unstyled" id="accordionsub">
 <li class="sub-item"><input type="checkbox" name="topic-checkboxG1" id="topic-checkboxG1" class="css-checkbox" checked="checked"/> <label for="topic-checkboxG1" class="css-label">Accounting 
<a data-toggle="collapse" data-parent="#accordionsub" href="#collapseSub" class="arrow glyphicon glyphicon-menu-up"></a>
 </label>
 <div id="collapseSub" class="panel-collapse collapse">
 
 <ul class="list-unstyled sub-filter">
 <li><input type="checkbox" name="topic-sub-checkboxG1" id="topic-sub-checkboxG1" class="css-checkbox" /><label for="topic-sub-checkboxG1" class="css-label check-round">Financial</label> </li>
  <li><input type="checkbox" name="topic-sub-checkboxG1" id="topic-sub-checkboxG2" class="css-checkbox" /><label for="topic-sub-checkboxG2" class="css-label check-round">Governmental</label> </li>

 </ul>
 </div>
  </li>
 
 <li><input type="checkbox" name="topic-checkboxG1" id="topic-checkboxG2" class="css-checkbox" /><label for="topic-checkboxG2" class="css-label">Management</label></li>
<li><input type="checkbox" name="topic-checkboxG1" id="topic-checkboxG3" class="css-checkbox" /><label for="topic-checkboxG3" class="css-label">Taxation</label></li>
<li><input type="checkbox" name="topic-checkboxG1" id="topic-checkboxG4" class="css-checkbox" /> <label for="topic-checkboxG4" class="css-label">Taxation</label></li>
     </ul>   
        
      </div>
    </div>
  </div> <!-- panel -->
  
  <div class="panel flt_Format">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          FORMAT  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseThree" class="panel-collapse collapse in">
    
      <div class="panel-body">
     <ul class="list-unstyled">
 <li><input type="checkbox" name="format-checkboxG1" id="format-checkboxG1" class="css-checkbox" checked="checked"/> <label for="format-checkboxG1" class="css-label">Text</label></li>
 <li><input type="checkbox" name="format-checkboxG1" id="format-checkboxG2" class="css-checkbox"/><label for="format-checkboxG2" class="css-label">Webcast</label></li>
<li><input type="checkbox" name="format-checkboxG1" id="format-checkboxG3" class="css-checkbox"/><label for="format-checkboxG3" class="css-label">Webinar</label></li>
<li><input type="checkbox" name="format-checkboxG1" id="format-checkboxG4" class="css-checkbox"/> <label for="format-checkboxG4" class="css-label">Live seminar</label></li>
     </ul>   
        
      </div>
    </div>
  </div> <!-- /panel -->
 
 
 <div class="panel flt_Cr_hr">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
          CREDIT HOURS  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseFour" class="panel-collapse collapse in">
    
      <div class="panel-body">
     <ul class="list-unstyled list-col-2">
 <li><input type="checkbox" name="Cr_hr-checkboxG1" id="Cr_hr-checkboxG1" class="css-checkbox"/> <label for="Cr_hr-checkboxG1" class="css-label">1</label></li>
 <li><input type="checkbox" name="Cr_hr-checkboxG1" id="Cr_hr-checkboxG2" class="css-checkbox"/><label for="Cr_hr-checkboxG2" class="css-label">2</label></li>
<li><input type="checkbox" name="Cr_hr-checkboxG1" id="Cr_hr-checkboxG3" class="css-checkbox"/><label for="Cr_hr-checkboxG3" class="css-label">3</label></li>
<li><input type="checkbox" name="Cr_hr-checkboxG1" id="Cr_hr-checkboxG4" class="css-checkbox"/> <label for="Cr_hr-checkboxG4" class="css-label">4</label></li>
<li><input type="checkbox" name="Cr_hr-checkboxG1" id="Cr_hr-checkboxG5" class="css-checkbox"/> <label for="Cr_hr-checkboxG5" class="css-label">5</label></li>
<li><input type="checkbox" name="Cr_hr-checkboxG1" id="Cr_hr-checkboxG6" class="css-checkbox"/> <label for="Cr_hr-checkboxG6" class="css-label">6</label></li>
     </ul>   
        
      </div>
    </div>
  </div> <!-- panel -->
  
 
 <div class="panel flt_Instruct">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
          INSTRUCTOR  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseFive" class="panel-collapse collapse in">
    
      <div class="panel-body">
     <ul class="list-unstyled">
 <li><input type="checkbox" name="instruct-checkboxG1" id="instruct-checkboxG1" class="css-checkbox"/> <label for="instruct-checkboxG1" class="css-label">Jae Kim</label></li>
 <li><input type="checkbox" name="instruct-checkboxG1" id="instruct-checkboxG2" class="css-checkbox"/><label for="instruct-checkboxG2" class="css-label">Micheal Law</label></li>
<li><input type="checkbox" name="instruct-checkboxG1" id="instruct-checkboxG3" class="css-checkbox"/><label for="instruct-checkboxG3" class="css-label">Mark</label></li>
<li><input type="checkbox" name="instruct-checkboxG1" id="instruct-checkboxG4" class="css-checkbox"/> <label for="instruct-checkboxG4" class="css-label">Sheila</label></li>
<li><input type="checkbox" name="instruct-checkboxG1" id="instruct-checkboxG5" class="css-checkbox"/> <label for="instruct-checkboxG5" class="css-label">Henry H</label></li>
     </ul>   
        
      </div>
    </div>
  </div> <!-- /panel -->
  
  <div class="panel flt_Require">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
          REQUIREMENTS  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseSix" class="panel-collapse collapse in">
    
      <div class="panel-body">
     <ul class="list-unstyled">
 <li><input type="checkbox" name="reqr-checkboxG1" id="reqr-checkboxG1" class="css-checkbox"/> <label for="reqr-checkboxG1" class="css-label">IRS APPROVED</label></li>
 <li><input type="checkbox" name="reqr-checkboxG1" id="reqr-checkboxG2" class="css-checkbox"/><label for="reqr-checkboxG2" class="css-label">CFP APPROVED</label></li>
<li><input type="checkbox" name="reqr-checkboxG1" id="reqr-checkboxG3" class="css-checkbox"/><label for="reqr-checkboxG3" class="css-label">YELLOW-BOOK</label></li>
     </ul>   
        
      </div>
    </div>
  </div> <!-- /panel -->
  
</div>


</div> <!-- /filter_inner -->
</div>  <!-- /filter-sidebar  -->


<div class="container">



<div class="row">
<div class="col-sm-2 hidden-xs" id="showFilter">
<a class="btn shw-filter" href="javascript:void(0);">Show Filters</a>
</div> <!-- /col -->

<div class="col-sm-8">
<div class="search-area br-cat-srch">
<div class="form-group text-center">
<input type="text" class="form-control" placeholder="Search Courses"  id="course_filter"/> <button class="btn" type="submit"><span class="icon-search"></span></button>
</div>
</div>

<div class="row visible-xs br-cat-filt">
<div class="col-xs-6 flt-res">
<div class="filter-btn"><a href="#" class="btn fad-orange medium" onclick="toggler('filt_Cont');">Filters</a></div>
</div>
<div class="col-xs-6 sort-opt sort-opt-resp">
<span class="text-line-select smp-drop right-select">
  <select class="selectpicker">
      <option selected>SORT</option>
      <option>A to Z</option>
      <option>Z to A</option>
      <option>Price</option>
      <option>No. of credits</option>
  </select>
  </span>
</div>
</div> <!-- row  br-cat-filt-->


<div class="filter-tags br_catlog">
<div class="filter-head">
<strong class="pull-left">Selected States:</strong> <a href="javascript:void(0)" id="reset_filter">Reset All<!--<span>Filters</span>--></a>
</div>
<ul class="list-inline list-unstyled" id="selected_state">
            <li class="select-flt-head"><strong>Selected <span class="f_fil">States</span><span class="f_state">states</span>:</strong></li>
            <?php foreach($states as $key => $stateval){?>
            <li id="state_line_item<?php echo $stateval['state_id'];?>" style="display:none"><span><?php echo trim($stateval['state']);?></span> <a class="close-tag close_selected" href="javascript:void(0)" id="" data-close="<?php echo $stateval['state_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php } ?>
            <li class="reset-flt"><a href="javascript:void(0)" id="reset_filter">Reset All<!--<span>Filters</span>--></a></li>
          </ul>

</div> <!-- /filter-tags -->

</div> <!-- /col-->

<div class="col-sm-2 sort-opt hidden-xs">
<span class="text-line-select smp-drop right-select">
  <select class="selectpicker">
      <option selected>SORT</option>
      <option>A to Z</option>
      <option>Z to A</option>
      <option>Price</option>
      <option>No. of credits</option>
  </select>
  </span>
</div> <!-- /col-->

</div> <!-- /row -->


<div class="row bdl_sc_Grd all_bdl_grd">
<div id="container_div" class="col-sm-12 col-md-12 col-lg-12">
<div class="row courselist" id="courselist1">
    <!-- /filter-tags -->
       
           <div id="loader" style="display:none; position:relative; left:40%; top:35%;"><img src="<?php echo $this->config->item("cdn_css_image")?>images/ajax-loader.gif" alt="close" /></div>
       
        <!-- /courselist --> 
</div>
<div class="pagination-wrap text-center">
 <ul class="pagination">
 <li class="pre"><a href="#">Previous</a></li>
  <li><a href="#">1</a></li>
  <li class="active"><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li class="next"><a href="#">Next</a></li>
</ul>
</div> <!-- /pagination-wrap -->
</div>

</div> <!-- /row -->




</div>



</div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
   

        
        <!-- Sticky -->
    <script type="text/javascript">
	
		$(document).ready(function() {
			 var sel_state_id = '<?php echo $selected_state_id;?>';
	  var checked_state = new Array();
	  if(sel_state_id!=''){
	  	checked_state.push(sel_state_id);
	  }
	     $("#loader").show();
		  $.ajax({
				  url: base_url+'course_con/get_courses',
				  dataType: 'html',
				  type: 'POST',
				  data: {
						stateid: checked_state
				  }
			}).done(function(response) {
				//alert(response);
				 $("#loader").hide();
				 $('.courselist').html('');
				if(response !='no'){
					if(sel_state_id!=''){
						$('#checkboxG'+sel_state_id).trigger('click');
					}
					$('.courselist').html(response);
				}else{
					if(sel_state_id!=''){
						$('#checkboxG'+sel_state_id).trigger('click');
					}
					$('.courselist').html('Sorry, no bundles were found with that combination of filters and search terms. Try a different search term, or reset your filters.');
				}
		   });
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
			
			// Code by Pravin
			$('#showFilter').click(function(){
				$('#container_div').removeClass();
				$('#container_div').addClass('col-sm-offset-4 col-sm-8 col-md-offset-3 col-md-9 col-lg-offset-3 col-lg-9');
				$('#search_bx').removeClass();
				$('#search_bx').addClass('col-sm-6 col-sm-offset-2 col-md-7 col-md-offset-1');
				$('#container_div .bdl-col-adj').removeClass('col-sm-4 col-md-3');
				$('#container_div .bdl-col-adj').addClass('col-sm-6 col-md-4');
				$('#filt_Cont').show();
				$('.shw-filter').hide();
				// col-sm-offset-4 col-sm-8 col-md-offset-3 col-md-9 col-lg-offset-3 col-lg-9  col-sm-12 col-md-12 col-lg-12
			});
			$('#hideFilter').click(function(){
				$('#container_div').removeClass();
				$('#container_div').addClass('col-sm-12 col-md-12 col-lg-12');
				//$('#search_bx').addClass('col-sm-8');
				$('#search_bx').removeClass();
				$('#search_bx').addClass('col-sm-8');
				$('#container_div .bdl-col-adj').removeClass('col-sm-6 col-md-4');
				$('#container_div .bdl-col-adj').addClass('col-sm-4 col-md-3');
				$('#filt_Cont').hide();
				$('.shw-filter').show();
				// col-sm-offset-4 col-sm-8 col-md-offset-3 col-md-9 col-lg-offset-3 col-lg-9  col-sm-12 col-md-12 col-lg-12
			});
			// Ends here
			
			
			
		});
		
	
	</script>
 
     <!-- close Sticky -->
        
        
        
        <script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
    </script>
        
        
        <!-- drawer -->



    <!-- /drawer -->
    
    <!-- accordian -->
    <script>
	$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-up").removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-down").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
});
	</script>


