<div class="bd-min-hgt">
<div class="container body-content checkout-wrp">
  <div class="row">
    <div class="col-lg-5 col-lg-offset-1 col-md-6 col-sm-6"> 
      
      <!-- Wizard Test -->
      <div class="wizard check-form">
        <div class="wizard-inner ch-links">
          <ul class="nav-tabs tab-nav list-inline">
            <li><a href="#">1. Checkout </a></li>
            <li class="active"><a href="#">2. Order Complete</a> </li>
          </ul>
        </div>
        <!-- /wizard-inner -->
        
        <div class="tab-content"> 
          <!-- /tab-pane -->
          
          <div class="tab-pane active" role="tabpanel">
            <div class="order-complete">
              <h4 class="heading">Your Order is Complete</h4>
              <h4>Order #<?php if(isset($order_num) && $order_num!=''){echo $order_num;}else{ echo $order_id;}?></h4>
              <p>We have emailed a copy of your receipt to <a class="usr-mail" href="mailto:<?php echo $cust_email;?>"><?php echo $cust_email;?></a>.<br>
                Your courses have been added to the <strong>My Courses</strong> section, and are available immediately!</p>
              <div class="btn-sec">
                <a href="<?php echo base_url()?>mycourses"><button class="btn fad-orange md-large next-step" type="button">VISIT MY COURSES</button></a>
              </div>
            </div>
            <!-- /order-complpete --> 
            
          </div>
          <!-- /tab-pane -->
          <div class="clearfix"></div>
        </div>
        <!-- /tab-content --> 
      </div>
      <!-- /wizard --> 
      <!-- /wizard test --> 
      
    </div>
    <!-- col-->
    
    <div class="col-lg-4 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-6 ord-comp-sec">
      <div class="order-right row">
        <div class="wht-panel with-shdw ord-smr ord-comp">
          <h4 class="text-center">Order Summary</h4>
         <!-- <div class="edit text-right"><a class="font-small" href="#">Edit Cart</a></div>-->
          <table class="table table-borderless cst-tbl">
            <tbody>
             <?php
			   $subtotal = 0.00;   
			  foreach($order_item_details as $items)
			  { 
			      if($items['purchase_type'] == 'Bundle')
				  {
					     $bundle_details = $this->bundle_mod->get_bundle_details($items['course_id']);
			  ?>
                      <tr>
                        <td colspan="2"><?php echo trim($bundle_details[0]['bundle_name']);?></td>
                        <td class="text-right ord-prs"><span class="fnt-hlv">$<?php echo number_format($items['course_amount'],2);?></span></td>
                      </tr>
              <?php }
			        if($items['purchase_type'] == 'Course')
				    {
						$course_details = $this->course_mod->get_course_details($items['course_id']); 
			  ?> 
              		  <tr>
                        <td colspan="2"><?php echo trim($course_details[0]['course_name']);?></td>
                        <td class="text-right ord-prs"><span class="fnt-hlv">$<?php echo number_format($items['course_amount'],2);?></span></td>
                      </tr>  
             <?php
				   }
				   if($items['purchase_type'] == 'Subscription')
				  {
					     $sub_details = $this->subscription_mod->get_subscription_details($items['course_id']);
			 ?>
             		 <tr>
                		<td colspan="2"><?php echo trim($sub_details[0]['title']);?></td>
                		<td class="text-right ord-prs"><span class="fnt-hlv">$<?php echo number_format($items['course_amount'],2);?></span></td>
              		 </tr>
             <?php 			 
				  }
				   $subtotal =  ($subtotal + $items['course_amount']);  
				   
			 } 
			    $total_amount = (($subtotal - $discount) + $tax);
				
			 ?> 
              
              <tr>
                <td colspan="3"><hr></td>
              </tr>
            </tbody>
            <tfoot class="ord-ttl-detal">
              <tr>
                <td class="promo-code" rowspan="4">
                  <?php if(isset($coupon_code) && $coupon_code!='') {?>
                   	<div class="prm-link prm-apply">Promo Code <?php echo $coupon_code;?> has been applied!</div>
                   <?php } ?> 
                </td>
                <td class="left-no-pad ord-ttl">Subtotal</td>
                <td class="text-right"><span class="fnt-hlv">$<?php echo $subtotal?></span></td>
              </tr>
             	<?php if($tax > 0) {?>
              <tr>
                <td>Taxes</td>
                <td class="text-right"><span class="fnt-hlv">+$<?php echo $tax;?></span></td>
              </tr>
              <?php } ?>
              <?php if($discount > 0) {?>
               <tr>
                <td>Discount</td>
                <td class="text-right"><span class="fnt-hlv">-$<?php echo $discount;?></span></td>
              </tr>
              <?php } ?>
              <tr>
                <td><strong>Total</strong></td>
                <td class="text-right"><strong class="fnt-hlv">$<?php echo $total_amount?></strong></td>
              </tr>
            </tfoot>
          </table>
          <!-- /table --> 
        </div>
        <!-- /wht-panel -->
        
        <div class="wht-panel faq-sec">
          <div id="accordion" class="panel-group custom-panel">
            <div class="panel">
              <div class="panel-title fq-head"> Order FAQ <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="pull-right arrow accordion-toggle glyphicon glyphicon-menu-up"></a> </div>
              <div class="panel-collapse collapse in" id="collapseOne">
                <ul id="faq-accordion" class="list-unstyled all-faq">
                 <?php if(count($checkout_faq) > 0){
					  foreach($checkout_faq as $key => $checkoutval)
					  {
				 ?>
                          <li>
                            <div class="faq-ttl"> <a href="#faq_<?php echo $key;?>" data-parent="#faq-accordion" data-toggle="collapse" aria-expanded="false" class="accordion-toggle"> <?php echo trim($checkoutval['question']);?> <span class="arrow glyphicon glyphicon-menu-down"></span></a> </div>
                            <div class="faq-ans panel-collapse collapse " id="faq_<?php echo $key;?>"> <?php echo trim($checkoutval['answer']);?> </div>
                            <!-- /faq-ans --> 
                          </li>
                  <?php }
				  
				   } ?>
                </ul>
                <!-- /all-faq --> 
                
              </div>
              <!-- /panel-collapse --> 
              
            </div>
          </div>
          <!-- /accordion --> 
          
        </div>
      </div>
      <!-- /row --> 
    </div>
    <!-- col--> 
    
  </div>
  <!-- /row --> 
</div>
<!-- container -->

</div> <!-- /bd-min-hgt -->
<script>
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-title')
        .find(".arrow")
        .toggleClass('glyphicon-menu-down glyphicon-menu-up');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);
</script>
    <!-- close accordian Arrow -->
    
    <!-- Sub accordian  -->
    <script>
function toggleChevron(e) {
    $(e.target)
        .prev('.faq-ttl')
        .find(".arrow")
        .toggleClass('glyphicon-menu-down glyphicon-menu-up');
}
$('#faq-accordion').on('hidden.bs.collapse', toggleChevron);
$('#faq-accordion').on('shown.bs.collapse', toggleChevron);
</script>