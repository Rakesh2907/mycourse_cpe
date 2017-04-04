<?php

$arrformat[0]['type'] = 'text';
$arrformat[0]['format'] = 'Text';
$arrformat[1]['type'] = 'webcast';
$arrformat[1]['format'] = 'webcast';

$arrformat[2]['type'] = 'web';
$arrformat[2]['format'] = 'Webinar';

$arrformat[3]['type'] = 'live';
$arrformat[3]['format'] = 'Live seminar';


 ?>
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
     <ul class="list-unstyled" id="couresstateList">
                <?php foreach($states as $key => $stateval){?>
                <li>
                  <input type="checkbox" name="states[]" id="chkboxG<?php echo $stateval['state_id'];?>" class="css-checkbox" value="<?php echo $stateval['state_id'];?>" data-label="<?php echo trim($stateval['state']);?>"/>
                  <label for="chkboxG<?php echo $stateval['state_id'];?>" class="css-label"><?php echo trim($stateval['state']);?></label>
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
     <ul class="list-unstyled" id="topicList">
                <?php foreach($coursetypes as $key => $type){?>
                <li>
                  <input type="checkbox" name="topics[]" id="chkboxT<?php echo $type['type_id'];?>" class="css-checkbox" value="<?php echo $type['type_id'];?>" data-label="<?php echo trim($type['type']);?>"/>
                  <label for="chkboxT<?php echo $type['type_id'];?>" class="css-label"><?php echo trim($type['type']);?></label>
                </li>
                <?php } ?>
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
       <ul class="list-unstyled" id="formatlist">
                <?php foreach($arrformat as $key => $type){?>
                <li>
                  <input type="checkbox" name="topics[]" id="chkboxF<?php echo $type['type'];?>" class="css-checkbox" value="<?php echo $type['format'];?>" data-label="<?php echo trim($type['format']);?>"/>
                  <label for="chkboxF<?php echo $type['type'];?>" class="css-label"><?php echo trim($type['format']);?></label>
                </li>
                <?php } ?>
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
 <li><input type="checkbox" name="Cr_hr-chkboxG1" id="Cr_hr-chkboxG1" class="css-checkbox"/> <label for="Cr_hr-chkboxG1" class="css-label">1</label></li>
 <li><input type="checkbox" name="Cr_hr-chkboxG1" id="Cr_hr-chkboxG2" class="css-checkbox"/><label for="Cr_hr-chkboxG2" class="css-label">2</label></li>
<li><input type="checkbox" name="Cr_hr-chkboxG1" id="Cr_hr-chkboxG3" class="css-checkbox"/><label for="Cr_hr-chkboxG3" class="css-label">3</label></li>
<li><input type="checkbox" name="Cr_hr-chkboxG1" id="Cr_hr-chkboxG4" class="css-checkbox"/> <label for="Cr_hr-chkboxG4" class="css-label">4</label></li>
<li><input type="checkbox" name="Cr_hr-chkboxG1" id="Cr_hr-chkboxG5" class="css-checkbox"/> <label for="Cr_hr-chkboxG5" class="css-label">5</label></li>
<li><input type="checkbox" name="Cr_hr-chkboxG1" id="Cr_hr-chkboxG6" class="css-checkbox"/> <label for="Cr_hr-chkboxG6" class="css-label">6</label></li>
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
    
      <div class="panel-body filter-max-ht cust-scroll">
     <ul class="list-unstyled" id="couresfaculty">
                <?php foreach($faculty_list as $key => $faculty){?>
                <li>
                  <input type="checkbox" name="faculty[]" id="chkboxI<?php echo $faculty['faculty_member_id'];?>" class="css-checkbox" value="<?php echo $faculty['faculty_member_id'];?>" data-label="<?php echo trim($faculty['first_name']);?>"/>
                  <label for="chkboxI<?php echo $faculty['faculty_member_id'];?>" class="css-label"><?php echo trim($faculty['first_name']);?></label>
                </li>
                <?php } ?>
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
 <li><input type="checkbox" name="reqr-chkboxG1" id="reqr-chkboxG1" class="css-checkbox"/> <label for="reqr-chkboxG1" class="css-label">IRS APPROVED</label></li>
 <li><input type="checkbox" name="reqr-chkboxG1" id="reqr-chkboxG2" class="css-checkbox"/><label for="reqr-chkboxG2" class="css-label">CFP APPROVED</label></li>
<li><input type="checkbox" name="reqr-chkboxG1" id="reqr-chkboxG3" class="css-checkbox"/><label for="reqr-chkboxG3" class="css-label">YELLOW-BOOK</label></li>
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

<div class="col-sm-8" id="search_bx">
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
  <select class="selectpicker" id="sortordr">
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
<strong class="pull-left">Selected Fillters:</strong> <a href="#" class="reset_fl1 pull-right">Reset All</a>
</div>
<ul class="list-inline list-unstyled" id="selected_cstate">
            <li class="select-flt-head"><strong>Selected <span class="f_fil">Filters</span><span class="f_state">states</span>:</strong></li>
            <?php foreach($states as $key => $stateval){?>
            <li id="state_line_item<?php echo $stateval['state_id'];?>" style="display:none"><span><?php echo trim($stateval['state']);?></span> <a class="close-tag close_selected" href="javascript:void(0)" id="" data-close="<?php echo $stateval['state_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php } ?>
            <?php foreach($coursetypes as $key => $type){?>
            <li id="type_line_item<?php echo $type['type_id'];?>" style="display:none"><span><?php echo trim($type['type']);?></span> <a class="close-tag close_typeselected" href="javascript:void(0)" id="" data-close="<?php echo $type['type_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php } ?>
            
			<?php foreach($arrformat as $key => $type1){?>
            <li id="format_line_item<?php echo $type1['format'];?>" style="display:none"><span><?php echo trim($type1['format']);?></span> <a class="close-tag close_formatselected" href="javascript:void(0)" id="" data-close="<?php echo $type1['format'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php } ?>
            
             <?php foreach($faculty_list as $key => $faculty){?>
            <li id="faculty_line_item<?php echo $faculty['faculty_member_id'];?>" style="display:none"><span><?php echo trim($faculty['first_name']);?></span> <a class="close-tag close_facultyselected" href="javascript:void(0)" id="" data-close="<?php echo $faculty['faculty_member_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
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
<div id="container_div" class="col-sm-12 col-md-12 col-lg-12"> <!-- col-sm-offset-4 col-sm-8 col-md-offset-3 col-md-9 col-lg-offset-3 col-lg-9  col-sm-12 col-md-12 col-lg-12-->
<div class="row">
    <!-- /filter-tags -->
       <div  id="courselist1" class="courselist">
           <div id="loader" style="display:none; position:relative; left:40%; top:35%;"><img src="<?php echo $this->config->item("cdn_css_image")?>images/ajax-loader.gif" alt="close" /></div>
       </div>
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

<input type="hidden" name="colsp" id="colsp" value=""  />
</div> <!-- /row -->




</div>



</div> <!-- /section-full -->
<script type="text/javascript">
	
$(document).ready(function() {
	var sel_cstate_id = '<?php echo $selected_state_id;?>';
	var course_state = new Array();
	var search_course = '';
	var order_by ='course_name ASC';
	
	var reset_search = 0;
	var state_id;
	if(sel_cstate_id!=''){
				course_state.push(sel_cstate_id);
	}
	 var col=4;
	      
	     $("#loader").show();
		  $.ajax({
				  url: base_url+'course_con/get_courses',
				  dataType: 'html',
				  type: 'POST',
				  data: {
						state_id: course_state,
						orderby: order_by,
						colspan:col
				  }
			}).done(function(response) {
				//alert(response);
				 $("#loader").hide();
				 $('.courselist').html('');
				if(response !='no'){
					if(sel_cstate_id!=''){
						$('#chkboxG'+sel_cstate_id).trigger('click');
					}
					$('.courselist').html(response);
				}else{
					if(sel_cstate_id!=''){
						$('#chkboxG'+sel_cstate_id).trigger('click');
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
	    var course_state = new Array();		
		$('#couresstateList input[type=checkbox]').click(function () {
			if(this.checked){
			   state_id = this.value;
			   course_state.push(state_id);
			   $(".list-inline #state_line_item"+state_id).show();
			}else{
				  $(".list-inline #state_line_item"+this.value).hide();
				  if ((index = course_state.indexOf(this.value)) !== -1) {
						course_state.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course);
        });
		
	    var course_topic = new Array();		
		$('#topicList input[type=checkbox]').click(function () {
			
			if(this.checked){
			   type_id = this.value;
			   course_topic.push(type_id);
			   $(".list-inline #type_line_item"+type_id).show();
			}else{
				  $(".list-inline #type_line_item"+this.value).hide();
				  if ((index = course_topic.indexOf(this.value)) !== -1) {
						course_topic.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,'','',course_topic);
        });
		
		var course_format = new Array();		
		$('#formatlist input[type=checkbox]').click(function () {
			
			if(this.checked){
			   format_type= this.value;
			  
			   course_format.push(format_type);
			   $(".list-inline #format_line_item"+format_type).show();
			}else{
				  $(".list-inline #format_line_item"+this.value).hide();
				  if ((index = course_format.indexOf(this.value)) !== -1) {
						course_format.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,'','','',course_format);
        });
			
		 var course_faculty = new Array();		
		$('#couresfaculty input[type=checkbox]').click(function () {
			if(this.checked){
			   faculty_id = this.value;
			   course_faculty.push(faculty_id);
			   $(".list-inline #faculty_line_item"+faculty_id).show();
			}else{
				  $(".list-inline #faculty_line_item"+this.value).hide();
				  if ((index = course_faculty.indexOf(this.value)) !== -1) {
						course_faculty.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,'','','',course_format,course_faculty);
        });	
			
		$('#course_filter').keyup(function( event ) {
			
		 if($(this).val().length > 0){
			 search_course = $(this).val();
		 }else{
			 search_course = '';
		 }
		 search_course_ajax(base_url,course_state,search_course,reset_search); 
	});	
	
		$('.selectpicker').change(function( event ) {
		
			
		 if($(this).val().length > 0){
			 order_course = $(this).val();
			 if(order_course == 'A to Z')
			 {
				   order_by = 'course_name ASC';
			 }
			 if(order_course == 'Z to A')
			 {
			 	  order_by = 'course_name DESC';
			 }
			 if(order_course == 'Price')
			 {
			 	   order_by = 'course_price ASC';
			 }
			 if(order_course == 'No. of credits')
			 {
			       order_by = 'credit_numbers ASC';
			 }
		
		 }else{
			 order_by = '';
		 }
		 search_course_ajax(base_url,course_state,search_course,reset_search,order_by); 
	});	
	
	$('#selected_cstate li').each(function() {
		$('#'+$(this).attr('id')+' .close_selected').click(function(){
			var removed_state_id = $(this).attr('data-close');
			if ((index = course_state.indexOf(removed_state_id)) !== -1) 
			{
                    course_state.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxG'+removed_state_id).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,'','',course_topic);	 
            }
			
			
		});
		$('#'+$(this).attr('id')+' .close_typeselected').click(function(){
			var removed_type_id = $(this).attr('data-close');
			if ((index = course_topic.indexOf(removed_type_id)) !== -1) 
			{
                    course_topic.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxT'+removed_type_id).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,'','',course_topic);	 
            }
			
			
		});
		
		$('#'+$(this).attr('id')+' .close_formatselected').click(function(){
			var removed_format_id = $(this).attr('data-close');
			
			if ((index = course_format.indexOf(removed_format_id)) !== -1) 
			{
                    course_format.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxF'+removed_format_id).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,'','',course_topic,course_format);	 
            }
			
			
		});
		
			$('#'+$(this).attr('id')+' .close_facultyselected').click(function(){
			var removed_faculty_id = $(this).attr('data-close');
			
			if ((index = course_faculty.indexOf(removed_faculty_id)) !== -1) 
			{
                    course_faculty.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxI'+removed_faculty_id).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,'','',course_topic,course_format,course_faculty);	 
            }
			
			
		});
	});
	
	function search_course_ajax(base_url,course_state,search_course,reset_search,order_by,topic_id,course_format,course_faculty)
	{
		   $("#loader").show();
		   $.ajax({
			  url: base_url+'course_con/get_courses',
			  dataType: 'html',
			  type: 'POST',
			  data: {
        					state_id: course_state,
							searchcourse: search_course,
							reset_filter: reset_search,
							orderby:order_by,
							topic_ids: topic_id,
							format:course_format,
							faculty:course_faculty
    		  	}
			}).done(function(response) {
				$("#loader").hide();
				$('.courselist').html('');
				if(response !='no'){
							$('.courselist').html(response);
				}else{
							$('.courselist').html('Sorry, no bundles were found with that combination of filters and search terms. Try a different search term, or reset your filters.');
				}
		    });
	}		
		
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
