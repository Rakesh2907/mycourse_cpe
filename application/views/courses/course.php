<?php
//echo "<pre>";print_r($_COOKIE);die;
$arrformat[0]['type'] = 'text';
$arrformat[0]['format'] = 'Text';
$arrformat[1]['type'] = 'webcast';
$arrformat[1]['format'] = 'Webcast';

//$arrlimit=array('1,2,3,4,5,6');
$arrlimit[0]=1;
$arrlimit[1]=2;
$arrlimit[2]=3;
$arrlimit[3]=4;
$arrlimit[4]=5;
$arrlimit[5]=6;


//echo "<pre>";print_r($arrlimit);die;
/*$arrformat[2]['type'] = 'web';
$arrformat[2]['format'] = 'Webinar';

$arrformat[3]['type'] = 'live';
$arrformat[3]['format'] = 'Live seminar';*/
/*$arrformat[0]['type'] = 'Text';
$arrformat[0]['format'] = 'Text';
$arrformat[1]['type'] = 'Video';
$arrformat[1]['format'] = 'Video';

$arrformat[2]['type'] = 'Webinar';
$arrformat[2]['format'] = 'Webinar';

$arrformat[3]['type'] = 'Live seminar';
$arrformat[3]['format'] = 'Live seminar';
*/
$state_f= array();
$state_f	=	$_SESSION['states_f'];
//echo "<pre>";print_r($state_f); echo "</pre>";
if(count($state_f) > 0)
{
	
	if (!in_array($selected_state_id, $state_f)) {
	   array_push($state_f,$selected_state_id);
	}
}else{
	$state_f= array();
	array_push($state_f,$selected_state_id);

}
//echo ">>".$selected_state_id;
//echo "<pre>";print_r($state_f);die;
$topic_f  = $_SESSION['topic_f'];
$format_f=array();
$format_f = $_SESSION['format_f'];
$faculty_f=array();
$faculty_f=$_SESSION['faculty_f'];

$credit_f=array();

$credit_f=$_SESSION['credit_f'];
$require_f=array();
$require_f=$_SESSION['require_f'];
//echo "<pre>";print_r($credit_f);die;
 ?>
<div class="section-full bd-min-hgt">
<div class="bd-pd-tp-16 mng-filter mng-filter-catalog">
<div id="filt_Cont" class="filter-sidebar br-cat-Flt mult-filter" style="display:none !important;">
<div class="filter_inner">
<div class="close-sec" id="hideFilter" onclick="toggler('filt_Cont');">Hide Filters <span class="close icon-cross" ></span></div>

<div class="panel-group custom-panel" id="accordion">
  <div class="panel flt_state">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
          State  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseOne" class="panel-collapse collapse in">
    
    <div class="search-sec">
    <button class="btn" type="submit"><span class="icon-search"></span></button>
     <input type="text" class="form-control" placeholder="Search States"  onkeyup="cstate_filter(this)"/></div>
    
      <div class="panel-body filter-max-ht cust-scroll">
     <ul class="list-unstyled" id="couresstateList">
                <?php foreach($states as $key => $stateval){?>
                <li>
                  <input type="checkbox" name="states[]" id="chkboxG<?php echo $stateval['state_id'];?>" class="css-checkbox" value="<?php echo $stateval['state_id'];?>" data-label="<?php echo trim($stateval['state']);?>"  <?php if (in_array($stateval['state_id'], $state_f)) {
    echo 'checked="checked"';}?> />
                  <label for="chkboxG<?php echo $stateval['state_id'];?>" class="css-label"><?php echo trim($stateval['state']);?></label>
                </li>
                <?php } ?>
              </ul>   
        
      </div>
    </div>
  </div> <!-- panel -->
  
  <div class="panel flt_Topic">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
          Topic  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseTwo" class="panel-collapse collapse in">
    
    <div class="search-sec">
    <button class="btn" type="submit"><span class="icon-search"></span></button>
     <input type="text" class="form-control" placeholder="Search Topics"  onkeyup="topics_filter(this)"/></div>
    
      <div class="panel-body filter-max-ht cust-scroll">
     <ul class="list-unstyled" id="topicList">
                <?php foreach($coursetypes as $key => $type){?>
                <li>
                  <input type="checkbox" name="topics[]" id="chkboxT<?php echo $type['type_id'];?>" class="css-checkbox" value="<?php echo $type['type_id'];?>" data-label="<?php echo trim($type['type']);?>" <?php if (in_array($type['type_id'], $topic_f)) {
    echo 'checked="checked"';}?>/>
                  <label for="chkboxT<?php echo $type['type_id'];?>" class="css-label"><?php echo trim($type['type']);?></label>
                </li>
                <?php } ?>
              </ul>   
        
      </div>
    </div>
  </div> <!-- panel -->
  
  <div class="panel flt_Format">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
          FORMAT  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseThree" class="panel-collapse collapse in">
    
      <div class="panel-body">
       <ul class="list-unstyled" id="formatlist">
                <?php foreach($arrformat as $key => $type){?>
                <li>
                  <input type="checkbox" name="topics[]" id="chkboxF<?php echo $type['type'];?>" class="css-checkbox" value="<?php echo $type['format'];?>" data-label="<?php echo trim($type['format']);?>" <?php if (in_array($type['format'], $format_f)) {
    echo 'checked="checked"';}?> />
                  <label for="chkboxF<?php echo $type['type'];?>" class="css-label"><?php echo trim($type['format']);?></label>
                </li>
                <?php } ?>
              </ul>   

      </div>
    </div>
  </div> <!-- /panel -->
 
 
 <div class="panel flt_Cr_hr">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour">
          CREDIT HOURS  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseFour" class="panel-collapse collapse">
    
      <div class="panel-body">
     <ul class="list-unstyled list-col-2" id="creditlimit">
     <?php foreach($arrlimit as $key => $credits){?>
                
                   <li><input type="checkbox" name="credit_count[]" <?php if (in_array($credits, $credit_f)) {
    echo 'checked="checked"';}?> id="credit_count<?php echo $credits;?>" class="css-checkbox" value="<?php echo $credits;?>" /> <label for="credit_count<?php echo $credits;?>" class="css-label">
               <?php 
					echo $credits;?><?php if($credits == 6) echo '+';?>
               
               </label></li>
                <?php } ?>
                
     </ul>   
        
      </div>
    </div>
  </div> <!-- panel -->
  
 
 <div class="panel flt_Instruct">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseFive">
          INSTRUCTOR  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseFive" class="panel-collapse collapse">
    
      <div class="panel-body filter-max-ht cust-scroll">
     <ul class="list-unstyled" id="couresfaculty">
                <?php  
				foreach($faculty_list as $key => $faculty){
					
					$lastname = explode(",",$faculty['last_name']);
					 
					?>
                <li>
                  <input type="checkbox"  name="faculty[]" id="chkboxI<?php echo $faculty['faculty_member_id'];?>" class="css-checkbox" value="<?php echo $faculty['faculty_member_id'];?>" data-label="<?php echo trim(substr($faculty['first_name'],0,1)).". ".trim($lastname[0]);?>" <?php if(in_array($faculty['faculty_member_id'],$faculty_f)) {
    echo 'checked="checked"';}?>/>
                  <label for="chkboxI<?php echo $faculty['faculty_member_id'];?>" class="css-label"><?php echo trim(substr($faculty['first_name'],0,1)).". ".trim($lastname[0]);?></label>
                </li>
                <?php } ?>
              </ul>  
        
      </div>
    </div>
  </div> <!-- /panel -->
  
  <div class="panel flt_Require">
      <div class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseSix">
          CERTIFICATIONS  <span class="glyphicon glyphicon-menu-down"></span>
        </a>
      </div>
    <div id="collapseSix" class="panel-collapse collapse">
    
      <div class="panel-body filter-max-ht cust-scroll">
        <ul class="list-unstyled" id="couresreq">
                <?php foreach($course_require as $key => $require){?>
                <li>
                  <input type="checkbox" name="req[]" id="chkboxR<?php echo $require['req_id'];?>" class="css-checkbox" value="<?php echo $require['req_id'];?>" data-label="<?php echo trim($require['req_name']);?>" <?php if (in_array($require['req_id'], $require_f)) {
    echo 'checked="checked"';}?>/>
                  <label for="chkboxR<?php echo $require['req_id'];?>" class="css-label"><?php echo trim($require['req_name']);?></label>
                </li>
                <?php } ?>
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
<div class="filter-btn"><a href="javascript:void(0);" class="btn fad-orange medium" onclick="toggler('filt_Cont');">Filters</a></div>
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
<strong class="pull-left">Selected Filters:</strong> <a href="#" class="reset_fl1 pull-right">Reset All</a>
</div>
<ul class="list-inline list-unstyled" id="selected_cstate">
            <li class="select-flt-head"><strong>Selected <span class="f_fil">Filters</span><span class="f_state">states</span>:</strong></li>
            <?php foreach($states as $key => $stateval){
				if(in_array($stateval['state_id'], $state_f)){
				 ?>
            <li id="state_line_item<?php echo $stateval['state_id'];?>"><span><?php echo trim($stateval['state']);?></span> <a class="close-tag close_selected" href="javascript:void(0)" id="" data-close="<?php echo $stateval['state_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }else{ ?>
			 <li id="state_line_item<?php echo $stateval['state_id'];?>" style="display:none"><span><?php echo trim($stateval['state']);?></span> <a class="close-tag close_selected" href="javascript:void(0)" id="" data-close="<?php echo $stateval['state_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
			
			<?php } } ?>
            
			<?php foreach($coursetypes as $key => $type){
				if(in_array($type['type_id'], $topic_f)){ 
				?>
            <li id="type_line_item<?php echo $type['type_id'];?>"><span><?php echo trim($type['type']);?></span> <a class="close-tag close_typeselected" href="javascript:void(0)" id="" data-close="<?php echo $type['type_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }else{ ?>
           <li id="type_line_item<?php echo $type['type_id'];?>" style="display:none"><span><?php echo trim($type['type']);?></span> <a class="close-tag close_typeselected" href="javascript:void(0)" id="" data-close="<?php echo $type['type_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>  
            <?php }} ?>
            
			<?php foreach($arrformat as $key => $format){
				if(in_array($format['format'], $format_f)){ 
				?>
            <li id="format_line_item<?php echo $format['format'];?>" ><span><?php echo trim($format['format']);?></span> <a class="close-tag close_formatselected" href="javascript:void(0)" id="" data-close="<?php echo $format['format'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }else{ ?>
             
              <li id="format_line_item<?php echo $format['format'];?>" style="display:none"><span><?php echo trim($format['format']);?></span> <a class="close-tag close_formatselected" href="javascript:void(0)" id="" data-close="<?php echo $format['format'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }} ?>
                     
             <?php
			     //
			     foreach($faculty_list as $key => $faculty){
				
				 if(in_array($faculty['faculty_member_id'],$faculty_f)){ 
				 
				 ?>
            <li id="faculty_line_item<?php echo $faculty['faculty_member_id'];?>"><span><?php echo trim($faculty['first_name']);?></span> <a class="close-tag close_facultyselected" href="javascript:void(0)" id="" data-close="<?php echo $faculty['faculty_member_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }else{ ?>
           <li id="faculty_line_item<?php echo $faculty['faculty_member_id'];?>" style="display:none"><span><?php echo trim($faculty['first_name']);?></span> <a class="close-tag close_facultyselected" href="javascript:void(0)" id="" data-close="<?php echo $faculty['faculty_member_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }} ?>
            
            <!--/* start new credit code */-->
           <?php foreach($arrlimit as $key => $credit){
			if(in_array($credit,$credit_f)){ 
			?>
           
            <li id="credit_line_item<?php echo $credit;?>"><span><?php echo $credit;?><?php if($credit == 6) echo '+'; ?></span> <a class="close-tag close_credit" href="javascript:void(0)" id="<?php echo $credit;?>" data-close="<?php echo $credit;?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
           
            <?php }else{ ?>
			 <li id="credit_line_item<?php echo $credit;?>" style="display:none"><span><?php echo $credit;?></span> <a class="close-tag close_credit" href="javascript:void(0)" id="<?php echo $credit;?>" data-close="<?php echo $credit;?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
			
			<?php }} ?>
             
             <!--/* end new credit code */-->
            

        
                <?php foreach($course_require as $key => $requirement){
					 if(in_array($requirement['req_id'],$require_f)){ 
					?>
           
            <li id="req_line_item<?php echo $requirement['req_id'];?>" ><span><?php echo trim($requirement['req_name']);?></span> <a class="close-tag close_coursereq" href="javascript:void(0)" id="" data-close="<?php echo $requirement['req_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php }else{ ?>
			  <li id="req_line_item<?php echo $requirement['req_id'];?>" style="display:none"><span><?php echo trim($requirement['req_name']);?></span> <a class="close-tag close_coursereq" href="javascript:void(0)" id="" data-close="<?php echo $requirement['req_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
			<?php }} ?>
            
            
            <li class="reset-flt"><a href="javascript:void(0)" id="reset_course_filter">Reset All<!--<span>Filters</span>--></a></li>
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
 
</div> <!-- /pagination-wrap -->

<div class="col-md-8 col-md-offset-2" id="norecord" style="display:none;">
<div class="not-found">
<img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" />
<i>Sorry, no courses were found with that combination of filters and search terms. Try a different search term, or reset your filters.</i>
</div> <!-- /not-found -->
</div>
</div>

<input type="hidden" name="colspan" id="colspan" value=""  />
	<input type="hidden" name="hdfilter" id="hdfilter" value="0"  />	
</div> <!-- /row -->




</div>

</div>

</div> <!-- /section-full -->
<script type="text/javascript">
	
$(document).ready(function() { 

	var sel_cstate_id = '<?php //echo $selected_state_id;?>';
	
	var course_state = course_topic = course_format =  new Array();
	var search_course  = '';
	var order_by ='course_name ASC';
	var col= credit = '';
	var reset_search  = 0;
	var state_id;
	var test=new Array();
	if(sel_cstate_id!=''){
				course_state.push(sel_cstate_id);
	}
	

	<?php
	     $cnt=count($state_f);
	     if(sizeof($state_f) > 0){
			
		 for($i=0; $i<$cnt; $i++){ ?>
	course_state.push(<?php echo $state_f[$i] ?>);

	<?php }}?>
	var course_topic=new Array();
<?php
	     $cnt_t=count($topic_f);
	     if(sizeof($topic_f) > 0){
			
		 for($j=0; $j<$cnt_t; $j++){ ?>
	course_topic.push(<?php echo $topic_f[$j] ?>);

	<?php }}?>
	
		var course_format=new Array();
<?php
	     $cnt_f=count($format_f);
	     if(sizeof($format_f) > 0){
			
		 for($k=0; $k<$cnt_f; $k++){ ?>
	course_format.push('<?php echo $format_f[$k] ?>');

	<?php }}?>
	
var course_faculty =new Array();
	//alert(course_faculty)
<?php
	     $cnt_f=count($faculty_f);
	     if(sizeof($faculty_f) > 0){
			
		 for($k=0; $k<$cnt_f; $k++){ ?>
	course_faculty.push(<?php echo $faculty_f[$k] ?>);

	<?php }}?>	
	
	var credit = new Array();
	<?php
	     $cnt_c=count($credit_f);
	     if(sizeof($cnt_c) > 0){
			
		 for($k=0; $k<$cnt_c; $k++){ ?>
	credit.push(<?php echo $credit_f[$k] ?>);

	<?php }}?>	


var course_req=new Array();
<?php
	     $cnt_r=count($require_f);
	     if(sizeof($require_f) > 0){
			
		 for($k=0; $k<$cnt_r; $k++){ ?>
	course_req.push('<?php echo $require_f[$k] ?>');

	<?php }}?>	
	 var col=4;
	      
	     $("#loader").show();
		  $.ajax({
				  url: base_url+'course_con/get_courses',
				  dataType: 'json',
				  type: 'POST',
				  data: {
						state_id: course_state,
						topic_ids: course_topic,
						format:course_format,
						faculty:course_faculty,
						creditlimit:credit,
						coursereq:course_req,
						orderby: order_by,
						colum:col
				  }
			}).done(function(response) {
				//alert(response);
				 $("#loader").hide();
				 $('.courselist').html('');
				 $('.pagination-wrap').html('');
			/*	if(response !='no'){
					if(sel_cstate_id!=''){
						$('#chkboxG'+sel_cstate_id).trigger('click');
					}
					$('.courselist').html(response);
				}else{
					if(sel_cstate_id!=''){
						$('#chkboxG'+sel_cstate_id).trigger('click');
					}
					$('.courselist').html('Sorry, no bundles were found with that combination of filters and search terms. Try a different search term, or reset your filters.');
				}*/
					if(response['sucess'] =='True'){
					        $("#norecord").hide();
							$('.courselist').html(response['html']);
							$('.pagination-wrap').html(response['pagination']);
							if(sel_cstate_id!=''){
						$('#chkboxG'+sel_cstate_id).trigger('click');
					}
				}else{
					        if(sel_cstate_id!=''){
						       $('#chkboxG'+sel_cstate_id).trigger('click');
					         }
							$("#norecord").show();
							
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
				$("#colspan").val("1");
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
				$("#colspan").val("0");
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
	    //var course_state = new Array();		
		$('#couresstateList input[type=checkbox]').click(function () {
			if(this.checked){
			   state_id = parseInt(this.value);
			   course_state.push(state_id);
			   $(".list-inline #state_line_item"+state_id).show();
			}else{
				
				  $(".list-inline #state_line_item"+this.value).hide();
				   state_id = parseInt(this.value);
				   //index = course_state.indexOf(this.value)
				// alert(course_state);
				// alert(this.value);
				// alert(jQuery.inArray( state_id, course_state ));
				  var a = course_state.indexOf(state_id);
				 // alert(a)
				  if ((index = course_state.indexOf(state_id)) !== -1) {
						course_state.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);
        });
		
	    //var course_topic = new Array();		
		$('#topicList input[type=checkbox]').click(function () {
			
			if(this.checked){
			   type_id = parseInt(this.value);
			   course_topic.push(type_id);
			   $(".list-inline #type_line_item"+type_id).show();
			}else{
				  $(".list-inline #type_line_item"+this.value).hide();
				 type_id = parseInt(this.value);
				  if ((index = course_topic.indexOf(type_id)) !== -1) {
						course_topic.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);
        });
		
		//var course_format = new Array();		
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
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);
        });
		
		
			
		$('#creditlimit input[type=checkbox]').click(function () {
			
			if(this.checked){
			   credit_type= parseInt(this.value);
			   credit.push(credit_type);
			   $(".list-inline #credit_line_item"+credit_type).show();
			}else{
				
				  $(".list-inline #credit_line_item"+this.value).hide();
				  
				  if ((index = credit.indexOf(parseInt(this.value))) !== -1) {
						credit.splice(index, 1);
						
				  }
				/*  if ((this.value) !== -1) {
						var credit='';
				  }*/ 
				   
			}
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);
        });
			
		
		//var course_req = new Array();		
		$('#couresreq input[type=checkbox]').click(function () {
			if(this.checked){
			   req_id = this.value;
			   course_req.push(req_id);
			   $(".list-inline #req_line_item"+req_id).show();
			}else{
				  $(".list-inline #req_line_item"+this.value).hide();
				  if ((index = course_req.indexOf(this.value)) !== -1) {
						course_req.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);
        });		
		// var course_faculty = new Array();		
		$('#couresfaculty input[type=checkbox]').click(function () {
			if(this.checked){
			   faculty_id = parseInt(this.value);
			   course_faculty.push(faculty_id);
			   $(".list-inline #faculty_line_item"+faculty_id).show();
			}else{
				  $(".list-inline #faculty_line_item"+this.value).hide();
				  if ((index = course_faculty.indexOf(parseInt(this.value))) !== -1) {
						course_faculty.splice(index, 1);
				  }  
			}
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);
        });	
		
		
	
			
		$('#course_filter').keyup(function( event ) {
			
		 if($(this).val().length > 0){
			 search_course = $(this).val();
		 }else{
			 search_course = '';
		 }
		 search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req); 
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
		 search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req); 
	});	
	
	$('#selected_cstate li').each(function() {
		$('#'+$(this).attr('id')+' .close_selected').click(function(){
			var removed_state_id = parseInt($(this).attr('data-close'));
			
			if ((index = course_state.indexOf(removed_state_id)) !== -1) 
			{
                    course_state.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxG'+removed_state_id).attr('checked', false);
				search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }
			
			
		});
		$('#'+$(this).attr('id')+' .close_typeselected').click(function(){
			var removed_type_id = parseInt($(this).attr('data-close'));
			
			if ((index = course_topic.indexOf(removed_type_id)) !== -1) 
			{
                    course_topic.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxT'+removed_type_id).attr('checked', false);
				search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }
			
			
		});
		
		$('#'+$(this).attr('id')+' .close_formatselected').click(function(){
			var removed_format_id =$(this).attr('data-close');
			index = course_format.indexOf(removed_format_id);
			
			if ((index = course_format.indexOf(removed_format_id)) !== -1) 
			{       
                    course_format.splice(index, 1);
					$(this).parent().hide();
					val = removed_format_id.charAt(0).toLowerCase() + removed_format_id.substr(1);
					
					//$('#chkboxFtext').attr('checked', false);;
					$('#chkboxF'+val).attr('checked', false);
					
				search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }
			
			
		});
		
			$('#'+$(this).attr('id')+' .close_facultyselected').click(function(){
			var removed_faculty_id = parseInt($(this).attr('data-close'));
			
			if ((index = course_faculty.indexOf(removed_faculty_id)) !== -1) 
			{
                    course_faculty.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxI'+removed_faculty_id).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }
			
			
		});
		
		$('#'+$(this).attr('id')+' .close_credit').click(function(){
			var removed_credit = parseInt($(this).attr('data-close'));
			
		/*	if ((removed_credit) !== -1) 
			{
                    credit='';
					$(this).parent().hide();
					$('#credit_count'+removed_credit).attr('checked', false);
			search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }*/
			
			if ((index = credit.indexOf(removed_credit)) !== -1) 
			{       
                    credit.splice(index, 1);
					$(this).parent().hide();
					$('#credit_count'+removed_credit).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }
			
			
		});
		
		$('#'+$(this).attr('id')+' .close_coursereq').click(function(){
			var removed_req_id = $(this).attr('data-close');
			 
			 test =course_req.indexOf(removed_req_id);
			
			
			if ((index = course_req.indexOf(removed_req_id)) !== -1) 
			{
                    course_req.splice(index, 1);
					$(this).parent().hide();
					$('#chkboxR'+removed_req_id).attr('checked', false);
					search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req);	 
            }
			
			
		});
	
	$('#showFilter').trigger('click');	
	
		
	});
	
	$('#reset_course_filter').click(function(){
		  
		   
			
		   $("#loader").show();
		   $.ajax({
			  url: base_url+'course_con/get_courses',
			  dataType: 'json',
			  type: 'POST',
			
			}).done(function(response) {
				
				$("#loader").hide();
				$('.courselist').html('');
				$('.pagination-wrap').html('');
				if(response['sucess'] =='True'){
				location.href=base_url+'individual-courses';
				}else{
							$("#norecord").show();
				}
		    });
	
		   //location.href=base_url+'individual-courses';
	});
	
	function search_course_ajax(base_url,course_state,search_course,reset_search,order_by,topic_id,course_format,course_faculty,credit,course_req,pageno)
	{
		    var cols = $('#colspan').val();
			
		   $("#loader").show();
		   $.ajax({
			  url: base_url+'course_con/get_courses',
			  dataType: 'json',
			  type: 'POST',
			  data: {
        					state_id: course_state,
							searchcourse: search_course,
							reset_filter: reset_search,
							orderby:order_by,
							topic_ids: topic_id,
							format:course_format,
							faculty:course_faculty,
							colum:cols,
							creditlimit:credit,
							coursereq:course_req,
							page_no:pageno
    		  	}
			}).done(function(response) {
				$("#loader").hide();
				$('.courselist').html('');
				$('.pagination-wrap').html('');
				if(response['sucess'] =='True'){
					        $("#norecord").hide();
							$('.courselist').html(response['html']);
							$('.pagination-wrap').html(response['pagination']);
				}else{
							$("#norecord").show();
				}
		    });
	}	
	$(document).on("click",".page_no",function(e){
		 var aarpageno = this.id;
		 var aarpage = aarpageno.split('_');
		 var pageno = aarpage[1];
		 //alert(pageno);
		search_course_ajax(base_url,course_state,search_course,reset_search,order_by,course_topic,course_format,course_faculty,credit,course_req,pageno);	 
		 });	
		
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
function topics_filter(element) 
{
  var value = $(element).val();
  $("#topicList li").each(function() {
    if ($(this).text().search(new RegExp(value, "i")) > -1) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
}
function cstate_filter(element) 
{
  var value = $(element).val();
  $("#couresstateList li").each(function() {
    if ($(this).text().search(new RegExp(value, "i")) > -1) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
}
	$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-up").removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-down").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
});




 $(document).ready(function() {
   var flagfilter = $("#hdfilter").val();
   if(flagfilter == 0)	
	{
   
        if (screen.width <= 767) {
			
            width = screen.width;
            height = screen.height;
            $('#filt_Cont').hide();
			$('.shw-filter').show();
			$("#hdfilter").val(1);
        }
	}else{		
		$("#hdfilter").val(0);	
		
	}
   	
});

	</script>
