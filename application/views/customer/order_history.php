<?php
$today=date('Y-m-d');
$disable_dates= date('Y').','.(int)date('m').','.(int)date('d', strtotime($today . ' +1 day'));
?>
<link href="<?php echo $this->config->item("cdn_css_image")?>css/BeatPicker.min.css" rel="stylesheet">
<div class="section-full small-inner-head">
<div class="container">
<h4>Your Account</h4>
</div>
</div>

<div class="container side-bar-brd">
<div class="row acc_details_wrp">
<?php $this->load->view('layouts/myaccount_sidebar'); ?>
 

 
 <div class="col-lg-8 col-lg-offset-1 col-md-9 ord-right">
 
 <div class="filter-form hidden-xs">
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
<!--<form class="form-inline">-->
<?php  
       
	    	$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('customer_con/get_order_details/'.$custid,$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			 ?>

  <div class="form-group">
  <label class="control-label">Filter by Date:</label>
  <input type="text"
               data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="startmyDatePicker"
                name="fromdate" value="<?php echo $stardate?>" data-beatpicker-disable="{from:[<?php echo $disable_dates; ?>],to:'>'}"   data-beatpicker-extra="customOptions" required="required" />
  <!--<input type="text" class="form-control">-->

  </div>
  <div class="form-group">
  <label class="control-label">to</label>
   <input type="text"
               data-beatpicker="true" class="form-control"
               data-beatpicker-position="['*','*']"
               data-beatpicker-id="endtmyDatePicker"
                 name="enddate" value="<?php echo $enddate?>" data-beatpicker-disable="{from:[<?php echo $disable_dates; ?>],to:'>'}"  data-beatpicker-extra="customOptions" required="required"/>

  </div>
  <input  type="submit" name="submit" value="Filter"   class="btn btn-wht"/>
  <!--<button type="submit"  value="submit" class="btn btn-wht">Filter</button>-->
  <?php //echo form_submit($arr_submit)?>
       <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>
  <!--</form>-->
 </div>
 
 
 <?php $count_order_details = sizeof($order_details);
      //echo '<pre>';print_r($order_details);die;
			//secho $count_order_details ;die;	
				if($count_order_details > 0)
				{ 
				  foreach($order_details as $row )
				  {
					  
				?>
 <div class="panel panel-wht ord-panel">
  <div class="panel-heading">Order # <?php echo $row['order_no']; ?><span class="date"><?php echo date_format($row['order_date'], 'Y/m/d ');  ?></span></div>
  <div class="panel-body">
  
<table class="table table-borderless cst-tbl ord-hist">
  <thead class="hidden-xs">
<tr>
  <th>Item</th>
  <th class="typ">Type</th>
  <th class="crd">Credits</th>
  <th class="prc text-center">Price</th>
</tr>
</thead>
<tbody class="hidden-xs">
<?php 
  $item=$row['items'];
 foreach($item as $row1 )
				  {  ?>
<tr>
<td><?php echo $row1['name']; ?></td>
<td><?php echo $row1['Type']; ?></td>
<?php if($row1['Type'] == 'Subscription'){?>
<td>n/a</td>
<?php } else{?>
<td><?php echo $row1['credit']; ?> credits</td>
<?php }?>
<td class="text-right">$<?php echo number_format($row1['itemprice'],2); ?></td>
</tr>
<?php }?>

<tr>
<td colspan="4"><hr></td>
</tr>
</tbody>
<tfoot class="ord-ttl-detal">
<tr>
<td colspan="2" rowspan="4" class="hidden-xs"></td>
<td><strong>Subtotal</strong></td><td class="text-right">$<?php echo $row['ordertotal']; ?></td></tr>
<tr><td class="pad-lef"><strong>Tax</strong></td><td class="text-right">$<?php echo $row['order_tax']; ?></td></tr>
<?php if($row['discount'] != 0.00) {?>
<tr><td class="pad-lef"><strong>Discount</strong></td><td class="text-right">$<?php echo $row['discount']; ?></td></tr>
<?php } ?>
<tr><td class="pad-lef"><strong>Total</strong></td><td class="text-right">$<?php echo number_format((($row['ordertotal']+$row['order_tax'])-$row['discount']),2); ?></td></tr>
</tfoot>
</table>

<a href="<?php echo base_url()?>customer_con/download_receipt/<?php echo $row['order_id'];?>" class="btn fad-orange medium rec-btn"><span class="icon icon-download"></span> DOWNLOAD RECEIPT</a>

  </div>
</div> 
<!-- /panel -->
 <?php
	 }
}else{?>
<div class="col-md-8 col-md-offset-2" id="norecord" >
<div class="not-found">
<img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" />
<i>Sorry, no orders were found in that date range. Please try a different date range.</i>
</div> <!-- /not-found -->
</div>
<?php }?>
 <!-- /panel -->
 
 </div>
 
</div><!-- /row -->
</div> <!-- container -->





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
            })

 jQuery(function(){
    jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    jQuery(window).resize(function(){
        jQuery('.side-bar-brd') .css({'min-height': ((jQuery(window).height() - 236))+'px'});
    });
});
        </script>