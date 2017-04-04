<?php 
$state_name=$state_detail[0]['state'];
$state_desc=$state_detail[0]['state_desc'];
$address = nl2br($state_detail[0]['state_contact']);
$phone = $state_detail[0]['state_phone'];
$fax = $state_detail[0]['state_fax'];
$website =$state_detail[0]['state_website'];	

?>
<div class="bd-min-hgt">

 <div class="section-full state-req-header">
 <div class="container">
 <div class="main-Head-sect text-center">
 <h1>CPE State Requirements</h1>
 <div class="state-looking">I'm looking for CPE requirements in 
 <span class="text-line-select sm-size">
<select class="selectpicker" data-width="100%" name="dropdown_states" id="dropdown_states">
            <option value="">Select States</option>
			   <?php 
			         foreach($states as $key => $stateval)
					 {
						 if($stateid == $stateval['state_id']){
							 $selected = 'selected="selected"';
						 }else{
							 $selected = '';
						 }
			   ?>
                    <option value="<?php echo $stateval['state_id'];?>" <?php echo $selected;?>><?php echo $stateval['state'];?></option>		
               <?php } ?>
</select>

</span> 
 </div>
 </div><!-- /head-sect  -->
 </div> <!-- container -->
 </div> <!-- /section-full -->

<div class="container page-content st_Req_wrp">


<div class="row">

<div class="col-lg-10 col-lg-offset-1 col-md-12">
<h1 class="state-head"><?php echo $state_name; ?></h1>

<div class="cont-sec">
<?php echo $state_desc; ?>
</div> 

<div class="cont-sec">
<h5 class="text-uppercase clr-blc">REQUIREMENT</h5>
<p><?php echo $totalhr; ?> hours total</p>
</div> 

<div class="cont-sec hrs-wrp">
<ul class="list-unstyled">
<?php if(count($state_reuirement) > 0) {
	
	foreach($state_reuirement as $require)
	{
	?>
<li class="sky-blue" style="border-color:<?php echo $require['back_color']; ?>">

<h6 class="text-uppercase clr-blc"><?php echo $require['requirment_hours']; ?> Hours</h6>
<p><?php echo $require['requirment_desc']; ?></p>
</li>
<?php }} ?>

</ul>
</div> <!-- /cont-sec -->


<div class="cont-sec">
<h5 class="text-uppercase">Courses</h5>
<ul class="list-unstyled clearfix crs-sec">
<li><div class="crs-txt">Complete all your state compliance credits at once </div>
<div class="crs-lnk"><a href="<?php echo base_url();?>compliance-bundles/<?php echo $stateid; ?>" class="btn dull-blue medium">View Bundles</a></div></li>
<li><div class="crs-txt">Missing out on an individual course?</div>
<div class="crs-lnk"><a href="<?php echo base_url();?>individual-courses/<?php echo $stateid; ?>" class="btn dull-blue medium">View Catalog</a></div></li>
</ul>
</div> <!-- /cont-sec -->

<div class="cont-sec cont_Info-sec">
<h5 class="text-uppercase">Contact Info</h5>
<ul class="list-unstyled">
<li class="address_info"><?php echo $address;?></li>
<li class="cont_info">Phone: <?php echo $phone;?><br>
FAX: <?php echo $fax;?></li>
<li class="link_info"><a href="<?php echo $website;?>" target="_blank"><?php echo $website;?></a></li>
</ul>
</div> <!-- /cont-sec -->

<div class="cont-sec inform-prov">
*Information provided as a reference only. Applicants are required to check with their State Board of Accountancy to determine their requirements for CPE credit. 
</div>

</div> <!-- col -->

</div> <!-- /row -->
</div> <!-- /page-content -->

</div> <!-- /bd-min-hgt  -->

 

 <!-- /footer -->




<!-- drawer Menu -->

<script>

$(document).ready(function(e) {

		   	$('#dropdown_states').change(function( event ) {
				 stateid = $(this).val();
				window.location.href =stateid;
			});
});


</script>