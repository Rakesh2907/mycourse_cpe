<?php 

$start_date= date("M d Y",strtotime($reg_date)); 

$end_date = date("M d Y",strtotime($to_date)); 

$today=date('Y-m-d');


$diff = abs(strtotime($to_date) - strtotime($today));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$disable_startdate= date('Y',strtotime($reg_date)).','.(int)date('m',strtotime($reg_date)).','.(int)date('d',strtotime($reg_date)); 
$test_end= date('Y',strtotime($to_date)).','.(int)date('m',strtotime($to_date)).','.(int)date('d',strtotime($to_date)); 
//echo $enddate = date('Y-m-d',strtotime(date('Y-m-d') . " + 1 year"));die;
//echo $disable_startdate;die;
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
<script type="text/javascript">var current_user_id = '<?php echo $cuserid;?>';</script>
<script src="<?php echo $this->config->item("cdn_css_image")?>js/Chart.min.js"></script> 
<style>
.cr_cir .mng_ch {
  margin-left: -70px;
  position: relative;
}
.cr-graph .cr_cir {
  overflow: hidden;
}
.mng_ch canvas {
  height: 150px !important;
  width: 300px !important;
}

.modal-open .modal.cst-flat-popup::after {
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
</style>



<div class="section-full small-inner-head">
<div class="container">
<h4>Your Account</h4>
</div>
</div>

<div class="container side-bar-brd">
<div class="row acc_details_wrp">
  <?php $this->load->view('layouts/myaccount_sidebar'); ?>
 

 
 <div class="col-lg-8 col-lg-offset-1 col-md-9 col-sm-12 ord-right">
 <div class="my-credit-wrp">
 
<div class="row">
 <div class="col-sm-5">
 <div class="cred-summery">
 <h4>Credit Summary</h4>
 <p>This tool is only intended as a tracking aid,
and should not be relied on for compliance.</p>
<a href="<?php echo base_url();?>state_con/state_equirement/<?php echo $select_state;?>" target="_blank">Full state requirements for <span id="statename"></span></a>
 </div> <!-- /cred-summery -->
 </div>
 <div class="col-sm-4">
 <div class="report-period">
 <h6 class="text-capitalize">REPORTING PERIOD</h6>
 <div class="report-date"><span id="sdate"><?php echo $start_date; ?></span> - <span id="edate"><?php echo $end_date; ?></span>  <a class="sprite-icons crs-edit-Icon sk" href="#" data-target="#chg_report_Period" data-toggle="modal" data-backdrop="false"><!-- <img width="12" src="images/pen-Icon.png" alt="Edit" />--></a></div>
 <i>You have <?php echo $months; ?> months and <?php echo $days; ?> days left</i>
 </div>
 </div>
 <div class="col-sm-3">
 <div class="cred-state">
 <h6 class="text-capitalize">CREDIT STATE</h6>
 <div class="sel-drop">
<select id="credit_state" class="selectpicker"  onchange="mycredit(this,0)">
   <?php 
    $selected = '';
	$data_state_id = '';
	foreach($user_state as $key => $stateval)
	{ 
	    if($stateval['state_id'] == $select_state){
			$selected = 'selected="selected"';
			$data_state_id = 'data-state ='.$stateval['state_id'].'';
			$state_name = $stateval['state'];
		
		}else{
		     $selected = '';
			 $data_state_id ='data-state ='.$stateval['state_id'].'';	
			 //$state_name ='';
			}
	?>
     <option value="<?php echo $stateval['state_id'];?>" <?php echo $selected;?> <?php echo $data_state_id;?> ><?php echo $stateval['state'];?></option>		
     <?php } ?>
</select>
</div> <!-- /sel-drop -->
 
 <a href="<?php base_url()?>mysetting">Edit My Credit States</a>
 </div><!-- /cred-state -->
 </div>
</div> <!-- row -->
  
<div class="row">
<div class="cr-graph">
<div class="col-sm-4 col-xs-12 pull-right">
<h4 class="trck-head visible-xs">Credit Tracker</h4>
<div class="cr_pie text-center">

   <div class="cr_cir">
   <div class="mng_ch"><canvas id="myChart"></canvas></div>
   </div>
</div>
</div>
<div class="col-sm-8 col-xs-12 pull-left">
<div class="cr-track">
<ul class="list-unstyled graph-list" id="state_credit_types">


</ul>

</div> <!-- /cr-track -->
</div>
</div>
</div> <!-- row -->
 

<div class="external-crs">
<div class="head-cont">
<h4>External Courses</h4>
<p>Below you can add courses and credits taken with another CPE provider. These credits will show up in your Credit Tracker.</p>
</div>
 
 <ul class="list-unstyled crs-Listing">
 <li class="header hidden-xs">
<div class="crs-col crs-title">Course Title</div>
<div class="crs-col dt-comp text-center">Date Completed</div>
<div class="crs-col crdt text-center">Credits</div>
<div class="crs-col category text-center">Category</div>
<div class="crs-col crs-action"></div>
 </li>
 <?php
    if(sizeof($external_courses) > 0)
	{
		foreach($external_courses as $key => $val)
		{ 
		  //echo "<pre>";print_r($val);
		  $cdate= date("M d Y",strtotime($val['credit_date'])); 
  ?>
 
  <li>
<div class="crs-col crs-title"><?php echo $val['external_course_name'];?></div>
<div class="crs-col dt-comp text-center"><?php echo $cdate;?></div>
<div class="crs-col crdt text-center"><?php echo $val['total_points'];?> <span class="ttl-crdt">credits</span></div>
<div class="crs-col category text-center"><?php echo $val['type'];?></div>
<div class="crs-col crs-action"> <ul class="crs-act-lnk">
<li><a class="delete" href="javascript:void(0)" onclick="delete_credits(<?php echo $val['id'];?>)"><span class="icon icon-trash"></span></a></li>
<li>
<!--<a class="sprite-icons crs-edit-Icon" href="javascript:void(0)" data-target="#chg_report_Period" data-toggle="modal"></a>-->
<a class="sprite-icons crs-edit-Icon" href="javascript:void(0)" onclick="edit_credit(<?php echo $val['id'];?>)"></a>
</li>
</ul></div> <!-- /crs-action -->
 </li>
 
  
 
 <?php 
	  }
	}else{
		 echo '<tr><td colspan="4">No records found</td></tr>';
	}
 ?>

 <li class="add-crs-sec" id="addecourse">
 <input type="hidden" name="user_cid" id="user_cid" />
<div class="crs-col crs-title"><input type="text" class="form-control" name="course_title" id="course_title" placeholder="Course Title" required="required"></div>
<div class="crs-col dt-comp text-center">
<!--<input type="text"  class="form-control" placeholder="Date">-->
<input type="text"
               data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="startmyDatePicker"
                name="exdate" id="exdate"  data-beatpicker-extra="customOptions" required="required" />

</div>


<div class="crs-col crdt text-center"><input type="text" name="excredit" id="excredit" class="form-control" placeholder="Credits"></div>
<div class="crs-col category text-center">
<div class="sel-drop">
<select class="selectpicker" id="credit_type">
   <option selected="">Select Category</option>
    <?php 
	foreach($credit_type as $key => $credit_type)
	{ 
	?>
     <option value="<?php echo $credit_type['type_id'];?>"><?php echo $credit_type['type'];?></option>		
     <?php } ?>
</select></div>
</div>
<div class="crs-col crs-action"> <ul class="crs-act-lnk">
<li><a class="delete close-crs" href="javascript:void(0)" onclick="remove_add_user_credit()"><span class="icon icon-circle-cross"></span></a></li>
<li><a class="delete add-crs" href="javascript:void(0)" id="add_credit"><span class="icon icon-circle-check"></span></a></li>
</ul></div> <!-- /crs-action -->
 </li>
 

 </ul>


</div> <!-- /external-crs -->

 <a href="#" data-toggle="modal" data-target="#add_edit_card" class="add-new-lnk" onclick="show_addcourse();"><span>Add a new External Course</span></a>

</div> <!-- /my-credit-wrp -->
 </div>
 
</div><!-- /row -->
</div> <!-- container -->



 

 <!-- /footer -->





<!-- drawer Menu -->

<!-- /drawer -->


<!-- Change Reporting Period Modal -->
<div role="dialog" class="modal fade cst-flat-popup" id="chg_report_Period">
  <div class="modal-dialog mdl-cs-wd leave_com chg_Rep_popup">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button"></button>
        <h4 class="modal-title text-center">Change Reporting Period</h4>
      </div>
      <div class="modal-body">

<div class="rep_Info text-center">
The reporting period for <strong><?php echo $state_name; ?></strong> is: <br>
<strong><?php echo $start_date; ?> - <?php echo $end_date; ?></strong> biennially ending on odd number years.
</div>
<div class="st-Requ-lnk hidden-xs text-right"><a href="<?php echo base_url();?>state_con/state_equirement/<?php echo $select_state;?>" target="_blank">View State Requirements</a></div>

<!-- <form class="cust_Form inline-label repo_Form">-->
<?php  
	    	$attributes = array('class' => 'cust_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/my_credit/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			 ?>
<div class="form-group">
<label class="control-label">Start Date</label>
<div class="inline-fld">
<!--<input type="text" class="form-control" value="Jan 1 2016">-->
<input type="text"
               data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="startmyDatePicker"
              data-beatpicker-disable="{from:[<?php echo $disable_startdate; ?>],to:'<'}"  name="fromdate" id="strtdate"  data-beatpicker-extra="customOptions" required="required" value="<?php echo $reg_date; ?>" />
</div> <!-- /inline-fld> -->
</div>

<div class="form-group">
<label class="control-label">End Date</label>
<div class="inline-fld">
<!--<input type="text" class="form-control" value="Dec 31 2018">$test_end-->
<input type="text"
               data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="endtmyDatePicker"
                name="enddate" data-beatpicker-extra="customOptions" id="enddate" required="required" value="<?php echo $to_date; ?>"/>
</div> <!-- /inline-fld>data-beatpicker-disable="{from:[<?php// echo date(Y); ?>,<?php //echo (int) date(m); ?>,<?php //echo date(d); ?>],to:'<'}" -->
</div>
<input type="hidden" name="stateid" id="stateid" />
<div class="btn-sec text-center">
<!--<button class="btn fad-orange md-large" onClick="apply_date()" type="button">SAVE REPORTING PERIOD</button>-->
 <input  class="btn fad-orange md-large" type="submit" name="my_submit" value="SAVE REPORTING PERIOD" />
</div>

 <?php	
			echo form_close();
		  ?>
     
     </div>
    </div>

  </div>
</div>
<div class="modal fade" id="delete_record" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Delete</h4>
        </div>
        <div class="modal-body">
          Are you sure want delete?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" id="yes">Yes</button>
        	<button type="button" class="btn default" id="no" data-dismiss="modal">No</button>
        </div>
    </div>
   </div>
</div>
<!-- Change Reporting Period Modal -->      
 <script>
$(document).ready(function(e) {
	$("#statename").html('<?php echo $state_name; ?>');
	$("#addecourse").hide();
   var default_state =  $('option:selected',$('#credit_state')).attr('data-state');
  
   $("#user_cid").val();
    $("#stateid").val(default_state);
   my_credit(default_state);
   
   $('#add_credit').click(function(){
		var coursename = $('#course_title').val();
		var credittype = $('#credit_type').val();
		var credits = $('#excredit').val();
		var cdate = $('#exdate').val();
		var state_id = $('#credit_state').val();
		var user_cid = $('#user_cid').val();
		
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(cdate == '')
		{
			alert('Please select date.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		
		var url = base_url+'customer_con/add_credit';
		$.post(url,
		    {
				course_name:coursename,
				adddate:cdate,
				credit_type:credittype,
				credits:credits,
				stateid:state_id,
				credit_id:user_cid,
				action: 'add'
			},
			function(responseText){
				
				var obj = responseText;
			    if(obj == 'true')
				{
					location.href = base_url+'mycredits/'+state_id;
				}else{
					// alert(obj.message);
				}
				
		});
	});
	 $("#credit_type").attr('selected', false);
});
function show_addcourse()
{
	$("#addecourse").show();
}
function edit_credit(id)
{
		$("#user_cid").val(id);
		var url = base_url+'customer_con/edit_credit';
		$.post(url,
		    {
				creditid:id,
			},
			function(responseText){
				
				var obj = JSON.parse(responseText);
			    if(obj != '')
				{
				   var result =responseText;
				   $("#addecourse").show();
				   $('#course_title').val(obj.cname);
				   //$('#credit_type').val(obj.type);
				   $('#excredit').val(obj.points);
				  //$("#credit_type option[value="+obj.type+"]").attr('selected', true);
				   $('#credit_type').val(obj.type).trigger('change');
				   $('#exdate').val(obj.cdate);
					//location.href = base_url+'customer_con/my_credit/';
				}else{
					// alert(obj.message);
				}
				
		});

}
function remove_add_user_credit()
{
				  
				   $('#course_title').val('');
				   //$('#credit_type').val(obj.type);
				   $('#excredit').val('');
				  //$("#credit_type option[value="+obj.type+"]").attr('selected', true);
				  $('#credit_type').val('').trigger('change');
				   $('#exdate').val('');	
				  $("#addecourse").hide(); 
}
function delete_credits(id)
{
     var state_id =  $('option:selected',$('#credit_state')).attr('data-state');
	var url =  base_url+'customer_con/delete_credits';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  credit_id:id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'mycredits/'+state_id;
			  }
		  }
		 );  
	});
		 $('#delete_record').modal({
  backdrop: false,
  show: true
});
	
}
function apply_date()
{
    var default_state =  $('option:selected',$('#credit_state')).attr('data-state');
	 var start_date=$("#strtdate").val();
	 var end_date=$("#enddate").val();
	
	location.href = base_url+'mycredits/'+default_state;
	 //my_credit(default_state);
	
}
function mycredit()
{
 var default_state =  $('option:selected',$('#credit_state')).attr('data-state');
//alert(default_state)
	location.href = base_url+'mycredits/'+default_state;
}
 function my_credit(state,defaultstate)
{
	 if(defaultstate == 0)
	 {
	var sel_state_id = $(state).val();
	 }else
	 {
		var sel_state_id = state; 
	}
	     var start_date=$("#strtdate").val();
		 var end_date=$("#enddate").val();
	 
	     $("#stateid").val(sel_state_id);
		 $.ajax({
			  url: base_url+'customer_con/get_my_credits',
			  dataType: 'json',
			  type: 'POST',
			  data: {
        					stateid: sel_state_id,
							sdate: start_date,
							edate: end_date,
							
    		  	}
			}).done(function(response) {
				
				if(response['sucess'] =='True'){
					
					  	// $('#cr_inf').show();
						 $('#state_credit_types').html();
							
							$('#state_credit_types').html(response['trackhtml']);
							
							 //$('#cr_inf').hide();
							
				}else{
							$('#state_credit_types').html('<li>No credits are found</li>');
				}
		    });
	
}

 
 </script>       
<script  src="<?php echo $this->config->item("cdn_css_image")?>js/BeatPicker.min.js"></script>    
        <!-- Sticky -->
     <script type="text/javascript" >
            $(document).ready(function(){ 
			$('.sk').click(function(){
				$( "#enddate" ).datepicker( "setDate", "25/11/2017" );
				});
			
                customOptions = {
                view : {
                    alwaysVisible:true
                },
                buttons: {
                    clear: false,
                    icon: false
                }
            }
            })
			
 jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
        </script>
        