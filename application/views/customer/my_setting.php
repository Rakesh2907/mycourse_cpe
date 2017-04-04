<?php 
//echo "<pre>";print_r($userinfo);die;
$fname 		=	$userinfo[0]['first_name'];
$lname 		=	$userinfo[0]['last_name'];
$email 		=	$userinfo[0]['email'];
$certification =$userinfo[0]['certifications'];
$pref_courses =$userinfo[0]['preferred_course'];
$intrest_area =$userinfo[0]['interest_area'];
$frm 		  =$userinfo[0]['firm_size'];
$prev_states	= $userinfo[0]['state'];
$percentage = 0;
$basic = $prefer='';
if($fname !='' && $lname !='' && $email !='' && $certification!='' && $comm_states !='' )
{
	$percentage += 50;
	 $basic ='checked';
}

if($pref_courses !='' && $intrest_area !='' && $frm !='' )
{
	$percentage += 50;
	 $prefer ='checked';
}
//echo "<pre>";print_r($push_state);die;
?>

<div class="section-full small-inner-head">
<div class="container">
<h4>Your Account</h4>
</div>
</div>

<div class="container side-bar-brd">
<div class="row acc_details_wrp">
 
  <?php $this->load->view('layouts/myaccount_sidebar'); ?> <!-- /drop-nav -->
 <div class="clearfix visible-xs"></div>
 

 
 <div class="col-lg-5 col-lg-offset-1 col-md-5 col-sm-7 acc-page-right acc_Setting_wrp">
    <?php if($suc_msg !=''){ ?>
    <div class="alert alert-success">
          <?php echo $suc_msg;?>
        </div>
        <?php } ?>
<div class="custom-tab-sec">
<ul  class="nav nav-tabs">
			<li class="active">
        <a  href="#basic_info" data-toggle="tab">Basic Info</a>
			</li>
			<li><a href="#preferences" data-toggle="tab">Preferences</a>
			</li>
		</ul>
<div class="tab-content clearfix">
			  <div class="tab-pane basic_Info active" id="basic_info">
  <div class="form-outer">
  
<!--<form class="cust_Form inline-label">-->
<?php  
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/user_setting/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
<div class="form-group"><label class="control-label">First Name</label>
<div class="inline-fld"><input type="text" class="form-control" value="<?php echo $fname; ?>" name="fname" id="fname"></div></div>

<div class="form-group"><label class="control-label">Last Name</label>
<div class="inline-fld"><input type="text" class="form-control" value="<?php echo $lname; ?>" name="lname" id="lname"></div></div>

 
<div class="form-group email-fld"><label class="control-label">Email</label>
<div class="inline-fld"><input type="text" class="form-control" value="<?php echo $email; ?>" name="emailid" id="emailid"></div>
</div>
<div class="form-group hidden-xs">
<label class="control-label">Password</label>
<div class="inline-fld"><a href="#" data-toggle="modal" data-target="#ch_Pass">Change your password</a></div>

</div>
<div class="form-group state_sear">
<label class="control-label"><span class="hidden">Credit States</span></label>
<div class="inline-fld"><ul class="list-inline state_tags" id="selction-ajax">
<?php if(count($states > 0))
      {
		  foreach ($states as $row)
		  {
 ?>
<li id="selstate_<?php echo $row['state_id']; ?>"><span><?php echo $row['state']; ?> <a onclick="close_state(<?php echo $row['state_id']; ?>)" class="close icon-cross" href="javascript:void(0)"></a></span></li>
<?php
		  }}?>

</ul></div>
</div><!--<li><span>New York <a href="#" class="close icon-cross"></a></span></li>-->
<div class="form-group">
<label class="control-label">Credit States</label>
<div class="inline-fld"><div class="srch-sec">
    <button type="submit" class="btn"><span class="icon-search"></span></button>
     <input type="text" placeholder="Search for States" class="form-control" name="course_state" id="autocomplete-ajax" autocomplete="off" ></div>
     </div>
</div>
<div class="form-group certi">
<label class="control-label">Certifications</label>
<div class="inline-fld"><ul class="list-unstyled list-inline check_stl sp-chk">
<?php 
 $CPAck =$CFPck=$EAck=$RTRPck= '';
if (strpos($certification,'CPA') !== false) {
    $CPAck = 'checked';
} 

if (strpos($certification,'CFP') !== false) {
    $CFPck = 'checked';
}
if (strpos($certification,'EA') !== false) {
    $EAck = 'checked';
}
if (strpos($certification,'RTRP') !== false) {
    $RTRPck = 'checked';
}

?>
<li><input type="checkbox" class="css-checkbox" id="checkboxG1" name="certifications[]" value="CPA" <?php echo $CPAck; ?>  > <label class="css-label" for="checkboxG1">CPA</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG2" name="certifications[]" value="CFP" <?php echo $CFPck; ?>><label class="css-label" for="checkboxG2">CFP</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG3" name="certifications[]" value="EA" <?php echo $EAck; ?>><label class="css-label" for="checkboxG3">EA</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG4" name="certifications[]" value="RTRP" <?php echo $RTRPck; ?>><label class="css-label" for="checkboxG4">RTRP</label></li>
 </ul></div>
</div>
<div class="form-group text-center ch-pass-txt visible-xs">
<a href="#" data-toggle="modal" data-target="#ch_Pass">Change your password</a>
</div>
<div class="btn-sec">
<!--<button class="btn fad-orange md-large">Save</button>-->
<input type="hidden" name="selected_states" value="<?php echo $comm_states;?>" id="selected_states"/>
<input type="hidden" name="prev_states" value="<?php echo $prev_states;?>" id="prev_states"/>
<input  class="btn fad-orange md-large" type="submit" name="submit" value="save" />
</div>
<?php	
echo form_close();
?>
     
     </div><!-- /form-outer -->
          
          
		</div> <!-- /tab-pane -->
        
		<div class="tab-pane pref_wrp" id="preferences">
        
      <!-- <form class="cust_Form inline-label">-->
<?php  
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/user_setting/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
$firm_data		=	$userinfo[0]['firm_size'];
$arrfirm[''] = "----Select----" ;
			$arrfirm['1'] = '1';
			$arrfirm['2-10'] = 'Between 2-10';
			$arrfirm['11-50'] = 'Between 11-50';
			$arrfirm['51-250'] = 'Between 51-250';
			$arrfirm['251-500'] = 'Between 251-500';
			$arrfirm['501-1000'] = 'Between 501-1000';
			$arrfirm['1000+'] = '1000+';

$text = $video =$webinr = $live ='';

if (strpos($pref_courses,'Self study text') !== false) {
    $text = 'checked';
} 

if (strpos($pref_courses,'Self study video') !== false) {
    $video = 'checked';
}
if (strpos($pref_courses,'Webinar') !== false) {
    $webinr = 'checked';
}
if (strpos($pref_courses,'Live Lecture') !== false) {
    $live = 'checked';
}


$accnt=$bussineslaws=$businessmangmt=$finance=$managment= $paandapp=$taxes;

if (strpos($intrest_area,'Accounting') !== false) {
    $accnt = 'checked';
} 

if (strpos($intrest_area,'Audits') !== false) {
    $audit = 'checked';
}
if (strpos($intrest_area,'Business Law') !== false) {
    $bussineslaws = 'checked';
}
if (strpos($intrest_area,'Business Management') !== false) {
    $businessmangmt = 'checked';
}
if (strpos($intrest_area,'Finance') !== false) {
    $finance = 'checked';
}
if (strpos($intrest_area,'Management') !== false) {
    $managment = 'checked';
}
if (strpos($intrest_area,'pecialized Knowledge & Applications') !== false) {
    $paandapp = 'checked';
}
if (strpos($intrest_area,'Taxes') !== false) {
    $taxes = 'checked';
}
//echo "<pre>";print_r($arrfirm);
?>        
        <div class="form-group"><label class="control-label">Firm Size</label>
<div class="inline-fld">
<div class="sel-drop">

<select class="selectpicker" name="firm_size" id="firm_size">
<?php foreach($arrfirm as $keyfirm => $firm){ 
if($firm_data == $keyfirm)
{
 	$select ='selected';	
}else{
	$select='';
}
?>
   <option <?php echo $select;?> value="<?php echo $keyfirm;?>"><?php echo $firm; ?></option>
    <?php }?>
    

</select>
</div> <!-- /sel-drop -->
</div>
</div> <!-- /form-group -->

<div class="form-group chk-fld"><label class="control-label">Preferred Course Format</label>
<div class="inline-fld">
<ul class="list-unstyled check_stl sp-chk">
<li><input type="checkbox" class="css-checkbox" id="checkboxG1_1" name="preferred_course[]" value="Self study text" <?php echo $text; ?>> <label class="css-label" for="checkboxG1_1">Self-Study Text</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG2_1" name="preferred_course[]" value="Self study video" <?php echo $video; ?>><label class="css-label" for="checkboxG2_1">Self-Study VIdeo</label></li>
<!--<li><input type="checkbox" class="css-checkbox" id="checkboxG3_1" name="preferred_course[]" value="Webinar" <?php echo $webinr; ?>><label class="css-label" for="checkboxG3_1">Webinar</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG4_1" name="preferred_course[]" value="Live Lecture" <?php echo $live; ?>><label class="css-label" for="checkboxG4_1">Live Lecture</label></li>-->
<!--<li><input type="checkbox" class="css-checkbox" id="checkboxG3_1" name="preferred_course[]" value="Webinar" < ?php echo $webinr; ?>><label class="css-label" for="checkboxG3_1">Webinar</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG4_1" name="preferred_course[]" value="Live Lecture" < ?php echo $live; ?>><label class="css-label" for="checkboxG4_1">Live Lecture</label></li>-->
 </ul>
</div></div> <!-- /form-group -->

<div class="form-group chk-fld"><label class="control-label">Areas of Interest</label>
<div class="inline-fld">
<ul class="list-unstyled check_stl sp-chk">
<li><input type="checkbox" class="css-checkbox" id="checkboxG1_2" name="interest_area[]" value="Accounting" <?php echo $accnt; ?>> <label class="css-label" for="checkboxG1_2">Accounting</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG2_2" name="interest_area[]" value="Audits" <?php echo $audit; ?>><label class="css-label" for="checkboxG2_2">Audits</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG3_2" name="interest_area[]" value="Business Law" <?php echo $bussineslaws; ?>><label class="css-label" for="checkboxG3_2">Business Law</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG4_2" name="interest_area[]" value="Business Management" <?php echo $businessmangmt; ?>><label class="css-label" for="checkboxG4_2">Business Management</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG5_2" name="interest_area[]" value="Finance" <?php echo $finance; ?>><label class="css-label" for="checkboxG5_2">Finance</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG6_2" name="interest_area[]" value="Management" <?php echo $managment; ?>><label class="css-label" for="checkboxG6_2">Management</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG7_2" name="interest_area[]" value="pecialized Knowledge & Applications" <?php echo $paandapp; ?>><label class="css-label" for="checkboxG7_2">Specialized Knowledge & Applications</label></li>
<li><input type="checkbox" class="css-checkbox" id="checkboxG8_2" name="interest_area[]" value="Taxes" <?php echo $taxes; ?>><label class="css-label" for="checkboxG8_2">Taxes</label></li>
 </ul>
</div></div> <!-- /form-group -->
 
 <div class="btn-sec">
<!--<button class="btn fad-orange md-large">Save</button>-->
<input  class="btn fad-orange md-large" type="submit" name="mysubmit" value="save" />
</div>
 
      <?php	
echo form_close();
?>
        
</div> <!-- /tab-pane -->
                
  
</div>
</div> <!-- /custom-tab-sec -->
 
 </div> <!-- acc-page-right -->
 
 
 <div class="col-lg-3 col-lg-offset-1 col-md-4 col-sm-5 hidden-xs acc-page-right">
 <div class="prf_Status text-center">
 <div class="comp_grp">
   <div class="mng_ch"><canvas id="myChart"></canvas></div>
 </div>
 
 <div class="prof_comp">Your profile is <strong><?php echo $percentage; ?>% complete.</strong></div>
 
 <ul class="list-unstyled check_stl ch_tick">
 <li> <input type="checkbox" <?php echo $basic; ?> name="checkboxG1_1_1" id="checkboxG1_1_1" class="css-checkbox" disabled><label for="checkboxG1_1_1" class="css-label">Basic Info</label> </li>
  <li> <input type="checkbox" <?php echo $prefer; ?>  name="checkboxG1_2_1" id="checkboxG1_2_1" class="css-checkbox" disabled><label for="checkboxG1_2_1" class="css-label"><a href="javascript:void(0);" id="complete_pref">Complete your preferences</a></label> </li>
 </ul>
 
 </div> <!-- /prf_Status -->
 </div>
 
</div><!-- /row -->
</div> <!-- container -->



 

 <!-- /footer -->

</div> <!-- /page -->



<!-- Modal -->
<div id="ch_Pass" class="modal fade cst-flat-popup" role="dialog">
  <div class="modal-dialog mdl-cs-wd leave_com ch_pass-wrp">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center">Change Your Password</h4>
      </div>
      <div class="modal-body">
      
        <!-- Form -->
     <!--<form class="cust_Form inline-label">-->
     <?php  
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/user_setting/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
  <div class="form-group"><label class="control-label">Old Password</label>
<div class="inline-fld"><input type="password" class="form-control" name="oldpassword" id="oldpassword" required></div></div> <!-- /form-group -->

<div class="form-group"><label class="control-label">New Password</label>
<div class="inline-fld"><div class="pass-fld">  <input type="password" class="form-control pwd" name="password" id="password"> <a href="#" class="reveal" id="show_hide">Show</a></div></div>
</div> <!-- /form-group -->

<div class="btn-sec text-center">
<!--<button class="btn fad-orange medium">Save</button>-->
<input  class="btn fad-orange mediume" type="submit" name="mypassword" value="save" />
</div>
     <?php	
echo form_close();
?>
        <!-- /Form -->
      </div>
    </div>

  </div>
</div> <!-- Modal close -->
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/Chart.min.js"></script> 
<script>
 $("#complete_pref").click(function () {
        $('.nav a[href="#preferences"]').tab('show');           
    });
	
  //var my_selecte_state = new Array();
  <?php foreach($push_state as $key => $val)
  {?>
       my_selecte_state.push(<?php echo $val;?>);
  <?php 
  }?>
  
 </script>
 <script> 
    Chart.types.Doughnut.extend({
        name: "DoughnutTextInside",
        showTooltip: function() {
            this.chart.ctx.save();
            Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
            this.chart.ctx.restore();
        },
        draw: function() {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var width = this.chart.width,
                height = this.chart.height;

            var fontSize = (height / 100).toFixed(2);
            this.chart.ctx.font = fontSize + "em Verdana";
            this.chart.ctx.textBaseline = "middle";
            this.chart.ctx.fillStyle = "black";
            var text = "<?php echo $percentage; ?>%" ,
                textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
                textY = height / 2;

            this.chart.ctx.fillText(text, textX, textY);
        }
    });
<?php if($percentage > 50){ ?>
    var data = [{
        value: 100,
        color: "#FA7E50"
    }];
<?php }elseif($percentage == 0){?>
var data = [{
        value: 50,
        color: "#E8E8E8"
    },{value: 50,
        color: "#E8E8E8"
    }];
<?php }else{?>
var data = [{
        value: 50,
        color: "#FA7E50"
    },{value: 50,
        color: "#E8E8E8"
    }];
	<?php }?>
    var DoughnutTextInsideChart = new Chart($('#myChart')[0].getContext('2d')).DoughnutTextInside(data, {
        responsive: true
    });
	
	jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
 jQuery(function(){
    jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    jQuery(window).resize(function(){
        jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    });
});
	</script>