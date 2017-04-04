<?php
$today=date('Y-m-d');
$disable_dates= date('Y').','.(int)date('m').','.(int)date('d', strtotime($today . ' +1 day'));
?>
<link href="<?php echo $this->config->item("cdn_css_image")?>css/BeatPicker.min.css" rel="stylesheet">
<style>
 .form-inline .input-parent {
  display: inline-block;
}
.filter-form .form-control {
  background-color: #fff;
  border:1px solid #979797 !important;
  background-image: none !important;
  
}
.beatpicker-clear beatpicker-clearButton button{ display:none !important;
	}
</style>
<div class="section-full small-inner-head">
  <div class="container">
    <h4>Your Account</h4>
  </div>
</div>
<div class="container side-bar-brd">
  <div class="row acc_details_wrp">
  <?php $this->load->view('layouts/myaccount_sidebar'); ?>
    <!-- /col -->
    
    <div class="col-lg-8 col-lg-offset-1 col-md-9 ord-right">
      <div class="filter-form with-sort hidden-xs">
      <form id="myForm" name="<?php base_url().'mycertificates';?>" method="post" class="form-inline pull-left" style="width:100%"/>
          <div class="form-group">
            <label class="control-label">Filter by Date:</label>
            <input type="text" data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="startmyDatePicker"
                name="fromdate" value="<?php echo $start?>" data-beatpicker-disable="{from:[<?php echo $disable_dates; ?>],to:'>'}" data-beatpicker-extra="customOptions" required="required" >
          </div>
          <div class="form-group">
            <label class="control-label">to</label>
            <input type="text" data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="endtmyDatePicker"
                 name="enddate" value="<?php echo $end?>" data-beatpicker-disable="{from:[<?php echo $disable_dates; ?>],to:'>'}" data-beatpicker-extra="customOptions" required="required">
          </div>
          <!--<button type="submit" name="submit" value="Filter" class="btn btn-wht">Filter</button>-->
          <input  type="submit" name="submit" value="Filter"   class="btn btn-wht" id="submit"/>
        <!-- sort -->
        <div class="sort-opt bg-lght pull-right"> <span class="text-line-select smp-drop right-select">
          <select class="selectpicker" id="sorting" name="sorting">
            <option selected="">SORT</option>
            <option value="ASC" <?php if($mysort == 'ASC'){ echo 'selected="selected"'; }?>>A to Z</option>
            <option value="DESC" <?php if($mysort == 'DESC'){ echo 'selected="selected"'; }?>>Z to A</option>
            <option value="new" <?php if($mysort == 'new'){ echo 'selected="selected"'; }?>>Newest</option>
            <option value="old" <?php if($mysort == 'old'){ echo 'selected="selected"'; }?>>Oldest</option>
          </select>
          </span> </div>
        <!-- sort close --> 
       </form>
      </div>
      <?php if(isset($err_msg)){ 
	  ?>
              			<div class="alert alert-danger"> <?php echo $err_msg; ?> </div>
      <?php } ?> 
      <div class="table-outer my-cert-wrp">
        <table class="table table-borderless cst-tbl">
          <thead class="hidden-xs">
            <tr>
              <th>Title</th>
              <th class="dt_comp">Date Completed</th>
              <th class="crds text-center">Credits</th>
              <th class="dwn-cert"></th>
            </tr>
          </thead>
          <tbody>
          <?php 
		   if(sizeof($certificates) > 0)
		   {
			   $this->load->library('zip');
			   foreach($certificates as $key => $course_list)
			   {
				 $credits = json_decode($course_list['course_credits']);
				  
			     foreach($credits as $key => $mycredits)
				 {
					 if($key == $course_list['course_state'])
					 {
						  $mydata = array();
					      foreach($mycredits as $creadit_type_id => $val)
						  {
							  $mydata[$creadit_type_id][$val] = $this->course_mod->course_type($creadit_type_id);
						  }	 
					
					 }
					 
			     }
			     $total = 0.00;
			     foreach($mydata as $points => $credit_type)
				 {
					 foreach($credit_type as $points => $type)
					 {
				        $total += $points; 
					 }
				 } 
				 
					$download_pdf = $course_list['course_name_clean'].'_'.$course_list['id'].'.pdf';
				
			  ?>
				<tr>
				  <td><span class="title"><?php echo trim($course_list['course_name']);?></span></td>
				  <td><?php echo date('m/d/Y',strtotime($course_list['completed_date']));?></td>
				  <td class="text-center"><?php echo $total;?> credits</td>
				  <td>
                      <?php 
					  if(isset($course_list['s3_course_certificate']) && $course_list['s3_course_certificate']!='NULL')
				      {
					  ?>
                       <a href="<?php echo base_url()?>customer_con/download_awspdf/?file=<?php echo trim($course_list['s3_course_certificate']);?>&course_name=<?php echo trim($course_list['course_name_clean']);?>">Download Certificate</a>
                      <?php	  
					  }else{
					  ?>		  
                       <a href="<?php echo base_url()?>customer_con/dowload_pdf/?file=<?php echo $download_pdf;?>">Download Certificate</a>
                      <?php } ?> 
                  </td>
				</tr>
				<?php
				 }
		   }else{
			    echo '<tr><td colspan="4">
				<div class="col-md-8 col-md-offset-2" id="norecord" >
				<div class="not-found">
				<img src="'.$this->config->item("cdn_css_image").'images/not-found.png" width="50" alt="Not Found" />
				<i>Sorry, You currently have no certificates for the selected date range.</i>
				</div> <!-- /not-found -->
				</div>
				</td></tr>';
		   } ?>
          </tbody>
        </table>
        <?php if(sizeof($certificates) > 0) { ?>
        <div class="btn-sec"><a href="<?php echo base_url()?>customer_con/download_zip/<?php echo $user_id;?>/?start=<?php echo $start;?>&end=<?php echo $end; ?>&sort=<?php echo $mysort;?>" class="btn fad-orange medium rec-btn"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/zip-icon.png" class="icon" width="24" alt="Zip" /> <img src="<?php echo $this->config->item("cdn_css_image")?>images/zip-icon2x.png" class="icon icon-2x" width="22" alt="Zip" /> Download Certificate (<?php echo count($certificates)?>)</a></div>
        <?php } ?>
      </div>
      <!-- /table-outer --> 
      
    </div>
  </div>
  <!-- /row --> 
</div>
<script  src="<?php echo $this->config->item("cdn_css_image")?>js/BeatPicker.min.js"></script>    
        <!-- Sticky -->
<script type="text/javascript" >
       $(document).ready(function(){ 
                customOptions = {
                view : {
                    alwaysVisible:true
                },
                buttons: {
                    clear: false,
                    icon: false
                }
            }
	
		
        });
		$("#sorting").on("change", function() {
    			$('#submit').click();		
		});

 jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
</script>