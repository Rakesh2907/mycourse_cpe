<link href="<?php echo $this->config->item("cdn_css_image")?>css/bootstrapValidator-min.css" rel="stylesheet">


<div class="container body-content checkout-wrp">
  <div class="row">
    <div class="pull-right col-lg-4 col-lg-offset-right-1 col-md-5 col-md-offset-1 col-sm-6 col-xs-12">
      <div class="wizard-inner ch-links visible-xs">
        <ul class="nav-tabs tab-nav list-inline">
          <li class="active"><a href="#">1. Checkout </a></li>
          <li><a href="#">2. Order Complete</a> </li>
        </ul>
      </div>
      <!-- /wizard-inner -->
      
      <div class="order-right row">
        <div class="wht-panel with-shdw ord-smr">
          <h4 class="text-center">Order Summary</h4>
          <div class="edit text-right"><a class="font-small" href="<?php echo base_url();?>cart">Edit Cart</a></div>
          <table class="table table-borderless cst-tbl">
            <tbody>
              <?php
		      $subtotal = 0; 
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
              <?php 
				  }
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
			  $CI = & get_instance();
			  $tax = $CI->calculate_tax($subtotal,$tax_per);
			  $total_amount = ($subtotal + $tax);
			 ?>
            
              <td colspan="3"><hr></td>
            </tr>
              </tbody>
            
            <tfoot class="ord-ttl-detal">
              <tr>
                <td class="promo-code" rowspan="3"><a class="prm-link" href="javascript:void(0)" id="enter_code">Enter a promo code</a>
                  <div class="prm-link prm-apply hidden" id="correct_promo">Promo Code MKTG1234 has been applied!</div>
                  <div id="promo-form" class="prm-link prom-form-wrp hidden">
                    <div class="promo-form">
                      <input type="text" class="form-control" placeholder="Promo Code" id="promocode">
                      <button type="submit" class="btn dull-blue small" id="apply_coupon">Apply</button>
                      <div class="prm-link prm-apply hidden margin_bottom" id="promo-code-error"></div>
                    </div>
                  </div></td>
                <td class="left-no-pad ord-ttl">Subtotal</td>
                <td class="text-right"><span class="fnt-hlv">$<?php echo $subtotal;?></span></td>
              </tr>
              <?php if($tax > 0){ ?>
              <tr>
                <td>Taxes</td>
                <td class="text-right"><span class="fnt-hlv">+$<?php echo $tax;?></span></td>
              </tr>
              <?php }?>
              <tr id="discount_amt" style="display:none">
                <td>Discount</td>
                <td class="text-right"><span class="fnt-hlv"></span></td>
              </tr>
              <tr id="total">
                <td><strong>Total</strong></td>
                <td class="text-right"><strong class="fnt-hlv">$<?php echo $total_amount;?></strong></td>
              </tr>
            </tfoot>
          </table>
          <!-- /table --> 
        </div>
        <!-- /wht-panel -->
        
        <div class="wht-panel faq-sec hidden-xs">
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
                    <div class="faq-ttl"> <a href="#faq_<?php echo $checkoutval['id'];?>" data-parent="#faq-accordion<?php echo $checkoutval['id'];?>" data-toggle="collapse" aria-expanded="false" class="accordion-toggle"> <?php echo trim($checkoutval['question']);?> <span class="arrow glyphicon glyphicon-menu-down"></span></a> </div>
                    <div class="faq-ans panel-collapse collapse " id="faq_<?php echo $checkoutval['id'];?>"> <?php echo trim($checkoutval['answer']);?> </div>
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
    
    <div class="pull-left col-lg-5 col-lg-offset-1 col-md-6 col-sm-6 col-xs-12"> 
      
      <!-- Wizard Test -->
      <?php 
		 	$stipe_id = trim($customers[0]['stripe_id']);
			
			if(isset($stipe_id) && $stipe_id!='' && $cuser_id != 0)
			{
			     $payurl = base_url().'checkout_con/payment_direct';
				 $myforrmid = 'direct-payment';
		    }else{
				 $payurl = base_url().'checkout_con/registration';	
				 $myforrmid = 'payment-form';
			}
			
		?>
      <div class="wizard check-form">
        <form id="<?php echo $myforrmid;?>" class="cust_Form checkout-form inline-label billing_Form" method="post" name="account_form" action="<?php echo $payurl;?>">
          <div class="wizard-inner ch-links hidden-xs">
            <ul class="nav-tabs tab-nav list-inline">
              <li class="active"><a href="#">1. Checkout </a></li>
              <li><a href="#">2. Order Complete</a> </li>
            </ul>
          </div>
          <!-- /wizard-inner -->
          
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="step1">
              <?php 
			 	   if(isset($cuser_id) && $cuser_id != 0)
				   {
					  if($err_msg){ 
					  
					   //echo "<pre>";print_r($_COOKIE);die; 
					  $cid    = $_COOKIE['cokecid'];
					  $cmonth = $_COOKIE['cokemonth'];
					  $cyear  = $_COOKIE['cokeyear'];
					  $cccv   = $_COOKIE['cokecvv'];
					  $czip   = $_COOKIE['cokezip'];
					
				
					setcookie('cokecid', null, -1, '/');
					setcookie('cokemonth', null, -1, '/');
					setcookie('cokeyear', null, -1, '/');
					setcookie('cokecvv', null, -1, '/');
					setcookie('cokezip', null, -1, '/');
			 ?>
              			<div class="alert alert-danger"> <?php echo $err_msg; ?> </div>
                     <?php }else{
						 
						 $cid    = '';
					  $cmonth = '';
					  $cyear  = '';
					  $cccv   = '';
					  $czip   = '';
					
				
					setcookie('cokecid', null, -1, '/');
					setcookie('cokemonth', null, -1, '/');
					setcookie('cokeyear', null, -1, '/');
					setcookie('cokecvv', null, -1, '/');
					setcookie('cokezip', null, -1, '/');
						 
						 } ?>     
              <!-- After login Message -->
              <div class="aft-lgoin text-center">
                <div class="text-line">Hi <?php echo $customers[0]['first_name']?> <?php echo $customers[0]['last_name']?>, you are logged in as <a class="mail-lnk" href="mailto:ashancock@gmail.com"><?php echo $customers[0]['email']?></a>.</div>
                Want to checkout as someone else? <a href="<?php echo base_url();?>logout?page=checkout">Logout</a> </div>
              <!-- After login Message close here -->
              <?php }else{
				   if($err_msg){
			 ?>
              <div class="alert alert-danger"> <?php echo $err_msg; ?> </div>
              <?php } ?>
              <!--<form id="account_form" class="cust_Form checkout-form inline-label billing_Form" method="post" name="account_form">-->
              <div class="alr-ac text-center"> Already have an account? <a href="javascript:void(0)" data-toggle="modal" data-target="#log_In">Please log in.</a> </div>
              <div class="form-group">
                <label class="control-label">First Name</label>
                <div class="inline-fld">
                  <input type="text" class="form-control" id="fname" name="fname" required="required" maxlength="15">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Last Name</label>
                <div class="inline-fld">
                  <input type="text" class="form-control" name="lname" id="lname" required="required" maxlength="15"/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Email</label>
                <div class="inline-fld">
                  <input type="email" class="form-control" name="email" id="email" required="required" maxlength="50"/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Create Password</label>
                <div class="inline-fld">
                  <div class="pass-fld">
                    <input type="password" class="form-control pwd" required="required" name="password" id="password" maxlength="8">
                    <a href="javascript:void(0)" class="reveal" id="show_hide">Show</a></div>
                </div>
              </div>
              <div class="form-group state_sear">
                <label class="control-label"></label>
                <div class="inline-fld">
                  <ul class="list-inline state_tags" id="selction-ajax">
                  </ul>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Credit States</label>
                <div class="inline-fld">
                  <div class="srch-sec">
                    <button class="btn" type="submit"><span class="icon-search"></span></button>
                    <input type="text" placeholder="Search for States" class="form-control" name="course_state" id="autocomplete-ajax" autocomplete="off" required="required">
                  </div>
                </div>
              </div>
              <div class="form-group certi">
                <label class="control-label">Certifications</label>
                <div class="inline-fld">
                  <ul class="list-unstyled list-inline check_stl sp-chk">
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
                      <label for="checkboxG4" class="css-label">RTRP</label>
                    </li>
                  </ul>
                </div>
              </div>
              <input type="hidden" name="selected_states" id="selected_states"  value=""/>
              <!--</form>--> 
              <!-- checkout-form -->
              <?php } ?>
              <div class="billing">
                <h4 class="text-center"><img width="15" src="<?php echo $this->config->item("cdn_css_image")?>images/Shape-billing.png" alt="Billing" />Billing</h4>
                <?php if($err_msg1){?>
              		<div class="alert alert-danger"> <?php echo $err_msg1; ?> </div>
                 <?php } ?>
                <div class="alert alert-danger" id="a_x200" style="display: none;"> <strong>Error!</strong> <span class="payment-errors"></span> </div>
                <ul class="list-unstyled list-inline cust-check">
                  <li>
                    <input id="strip_payment" type="radio" checked="checked" class="css-checkbox" name="radiog_dark" value="strip">
                    <label class="css-label radGroup2" for="strip_payment">Secure Checkout</label>
                  </li>
                  <li>
                    <input id="paypal_payment" type="radio" class="css-checkbox" name="radiog_dark" value="paypal">
                    <label class="css-label radGroup2" for="paypal_payment">Paypal</label>
                  </li>
                </ul>
                <?php 
				if(isset($stipe_id) && $stipe_id!='')
			    {
					  /*echo "<pre>"; 
					   print_r($cards);
					  echo "</pre>";*/
				?>
                <!-- Save Cards -->
                
                <div class="save-cards">
                  <p class="text-center">We have a saved card on file for you. </p>
                  <span class="text-line-select card-list smp-drop">
                  <select class="selectpicker" name="mycards" id="mycards">
                  <?php if(count($cards) == 0){ ?>
                    <option class="sprite-image sprite-card-add-more" value="add_new">Select Cards</option>
                  <?php } ?>  
                    <?php 
							  $class = 'sprite-card-mc';
							  $k = 0;
						foreach($cards as $card_id => $card_val)
						{
							if($card_val['card_brand'] == 'Visa')
							{
							   $class = 'sprite-card-visa';
							}
							if($card_val['card_brand'] == 'MasterCard')
							{
								$class = 'sprite-card-mc';
							}
							if($card_val['card_brand'] == 'American Express')
							{
								$class = 'sprite-card-amex';
							}
							if($card_val['card_brand'] == 'Discover')
							{
								$class = 'sprite-card-descover';
							}
							if($k == 0){
								$selectedCard = $class;
							}
							$k++;
							
						?>
                    <option class="sprite-image <?php echo $class;?>" value="<?php echo $card_id;?>">XXXX XXXX XXXX <?php echo $card_val['last4']?>&nbsp;&nbsp;exp.&nbsp;&nbsp;<?php echo $card_val['exp_month']?>/<?php echo $card_val['exp_year']?></option>
                    <?php }?>
                    <option class="sprite-image sprite-card-add-more" value="add_new">Add a new card</option>
                  </select>
                  </span> </div>
                <!-- Save Cards close here -->
                <?php 
				}
				else{
				?>
                <!-- <form class="cust_Form billing_Form inline-label">-->
                <div id="strip_form">
                  <div class="form-group card-fld">
                    <label class="control-label">Card #</label>
                    <div class="inline-fld">
                      <input type="text" class="form-control card-number" maxlength="17">
          <!--<img class="m-card card-number" src="<?php //echo $this->config->item("cdn_css_image")?>images/m-c-icon.png" width="29" alt="Card" />-->
         <div class="m-card card-inf">
<div class="" id="crdimg"></div>
</div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Expires</label>
                    <div class="inline-fld">
                      <div class="smll-field">
                        <input type="text" class="form-control card-expiry-month" placeholder="MM" maxlength="2">
                      </div>
                      <div class="smll-field">
                        <input type="text" class="form-control card-expiry-year" placeholder="YYYY" maxlength="4">
                      </div>
                    </div>
                    <!-- /inline-fld> --> 
                  </div>
                  <div class="form-group">
                    <label class="control-label">CVV</label>
                    <div class="inline-fld">
                      <div class="smll-field full-xs cvv-fld">
                        <input type="text" class="form-control card-cvc" placeholder="CVV" maxlength="4">
                        <img class="cvv-icon" src="<?php echo $this->config->item("cdn_css_image")?>images/cvv_icon.png" width="37" alt="CVV" /></div>
                    </div>
                    <!-- /inline-fld> --> 
                  </div>
                  <div class="form-group">
                    <label class="control-label">Billing ZIP</label>
                    <div class="inline-fld">
                      <div class="smll-field full-xs">
                        <input type="text" class="form-control zip" placeholder="XXXXX" maxlength="7">
                      </div>
                    </div>
                    <!-- /inline-fld> --> 
                  </div>
                </div>
                <!--</form>-->
                <?php } ?>
                
                <!-- paypal -->
                <div class="paypal_info text-center hidden"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/paypal-img.png" alt="Paypal" width="227" />
                  <p>You will be taken to PayPal, and return to this site for your order confirmation once your order is complete.</p>
                </div>
                <!-- paypal close here --> 
                
              </div>
              <!-- /billing -->
              
              <div class="order-cmp btn-sec text-center"> 
                <!-- <button  type="button" class="btn fad-orange md-large next-step">Complete Order</button>-->
                <button class="btn fad-orange md-large next-step" type="submit" id="stripe_complete">Complete Order</button>
                <button class="btn fad-orange md-large next-step" type="submit" id="paypal_complete" style="display:none;">Complete Order</button>
                
                <input type="hidden" name="mysubmit" value="registration"/>
                <div class="sml-info"><i>Your card will be charged.</i></div>
              </div>
            </div>
          </div>
          <!-- /tab-pane -->
          <input type="hidden" name="counpon_id" value="" id="apply_coupon_id"/>
          <input type="hidden" name="payment_type" value="mystrip" id="payment_type"/>
          <div class="clearfix"></div>
        </form>
      </div>
      <!-- /tab-content --> 
    </div>
    <!-- /wizard --> 
    <!-- /wizard test -->
    
    <div class="wht-panel faq-sec visible-xs">
      <div id="res_accordion" class="panel-group custom-panel">
        <div class="panel">
          <div class="panel-title fq-head"> Order FAQ <a href="#res_collapseOne" data-parent="#res_accordion" data-toggle="collapse" aria-expanded="true" class="pull-right arrow accordion-toggle glyphicon glyphicon-menu-up"></a> </div>
          <div class="panel-collapse collapse in" id="res_collapseOne">
            <ul id="res_faq-accordion" class="list-unstyled all-faq">
              <?php if(count($checkout_faq) > 0){
					  foreach($checkout_faq as $key => $checkoutval)
					  {
				 ?>
              <li>
                <div class="faq-ttl"> <a href="#faqm_<?php echo $checkoutval['id'];?>" data-parent="#faqm-accordion<?php echo $checkoutval['id'];?>" data-toggle="collapse" aria-expanded="false" class="accordion-toggle"> <?php echo trim($checkoutval['question']);?> <span class="arrow glyphicon glyphicon-menu-down"></span></a> </div>
                <div class="faq-ans panel-collapse collapse " id="faqm_<?php echo $checkoutval['id'];?>"> <?php echo trim($checkoutval['answer']);?> </div>
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
  <!-- col--> 
  
</div>
<!-- /row -->

</div>

<?php if($cuser_id == 0){?>
<div role="dialog" class="modal fade cst-flat-popup" id="log_In">
  <div class="modal-dialog mdl-cs-wd leave_com log_In_popup"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button"></button>
        <h4 class="modal-title text-center">Welcome Back!</h4>
      </div>
      <div class="modal-body">
        <p class="intr-txt">It looks like you already have an account with us, please log in to your account to complete your order.</p>
        <!-- Form -->
        <form class="cust_Form inline-label" action="<?php echo base_url()?>customer_con/login" method="post">
          <div class="form-group">
            <label class="control-label">Email</label>
            <div class="inline-fld">
              <input class="form-control" name="username" required="required" type="email">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <div class="inline-fld">
              <input type="password" class="form-control" required="required" name="password">
            </div>
          </div>
          <div class="form-group text-right for-pass"><a href="javascript:void(0)" onclick="forgot_popup()">forgot your password?</a></div>
          <div class="btn-sec text-center">
            <!--<button class="btn fad-orange md-large">Log In</button>-->
            <input type="hidden" name="page" value="checkout" />
            <input type="submit" name="submit" value="login" class="btn fad-orange md-large"  />
          </div>
        </form>
        <!-- /Form --> 
      </div>
    </div>
  </div>
</div>
<div id="forget_Pass" class="modal fade cst-flat-popup">
  <div class="modal-dialog mdl-cs-wd leave_com f-Pass">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close icon-cross" data-dismiss="modal"></button>
        <h4 class="modal-title text-center">Password Reset</h4>
      </div>
      <div class="modal-body">
      <p class="intr-txt text-center">Please enter your email below, and we will send you instructions for resetting your password.</p>
        <!-- Form -->

     	    	<?php $attributes = array('class' => 'cust_Form inline-label', 'id' => 'myforgotform');
					echo form_open('customer_con/forgotpassword/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
  <div class="form-group"><label class="control-label">Email</label>
<div class="inline-fld"><input type="email" class="form-control" name="forgotmail" id="forgotmail" required></div></div>

<div class="btn-sec text-center">
  <input type="hidden" name="page" value="checkout" />
 <input  type="submit" name="submit" value="RESET PASSWORD"   class="btn dull-blue md-large"/>
</div>
 <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>
        <!-- /Form -->
      </div>
    </div>

  </div>
</div>
<?php } ?>
<!-- container -->
<div role="dialog" class="modal fade cst-flat-popup" id="add_edit_card">
  <div class="modal-dialog mdl-cs-wd leave_com add-Edit-Card"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button"></button>
        <h4 class="modal-title text-center">Add a New Card</h4>
      </div>
      <div class="modal-body" > 
        
        <!-- Add new card Form -->
        
        <?php  
	    /*	$attributes = array('class' => 'cust_Form billing_Form inline-label', 'id' => 'myform');
			echo form_open('customer_con/my_billing/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			*/
		$payurl=base_url().'checkout_con/add_card';	
			 ?>
        <form id="addcard-form" class="cust_Form billing_Form inline-label" method="post" name="account_form" action="<?php echo $payurl;?>">
          <div class="alert alert-danger" id="a_x201" style="display: none;"> <strong>Error!</strong> <span class="payment-errors1"></span> </div>
          <div class="form-group card-fld">
            <label class="control-label">Card #</label>
            <div class="inline-fld">
              <input type="text" class="form-control card-number"  name="cardnumber" required="required" maxlength="17" value="<?php echo $cid; ?>">
              <!--<img width="29" alt="Card" src="<?php echo $this->config->item("cdn_css_image")?>images/m-c-icon.png" class="m-card">-->
              <div class="m-card card-inf"><div class="" id="crdimg"></div>
</div>
              </div>
          </div>
          <div class="form-group">
            <label class="control-label">Expires</label>
            <div class="inline-fld">
              <div class="smll-field">
                <input type="text" placeholder="MM" class="form-control card-expiry-month" name="add_month" id="add_month" required="required" maxlength="2" value="<?php echo $cmonth; ?>">
              </div>
              <div class="smll-field">
                <input type="text" placeholder="YYYY" class="form-control card-expiry-year" name="add_year" id="add_year" required="required" maxlength="4" value="<?php echo $cyear; ?>">
              </div>
            </div>
            <!-- /inline-fld> --> 
          </div>
          <div class="form-group">
            <label class="control-label">CVV</label>
            <div class="inline-fld">
              <div class="smll-field full-xs cvv-fld">
                <input type="text" class="form-control card-cvc" name="cvv" id="cvv" required="required" maxlength="4" value="<?php echo $cccv; ?>">
                <img width="39" alt="CVV" src="<?php echo $this->config->item("cdn_css_image")?>images/cvv_icon.png" class="cvv-icon"></div>
            </div>
            <!-- /inline-fld> --> 
          </div>
          <div class="form-group">
            <label class="control-label" onBlur="zip" >Zip Code</label>
            <div class="inline-fld">
              <input type="text" class="form-control card-zipcode" id="zip" name="zip" required="required" maxlength="7" value="<?php echo $czip; ?>">
            </div>
            <!-- /inline-fld> --> 
          </div>
          <div class="btn-sec text-center"> 
            <!--<button class="btn fad-orange md-large" type="button">Save Card</button>--> 
            <!--<input  class="btn fad-orange md-large" type="submit" name="addcard" value="Save Card"/>-->
            <button class="btn fad-orange md-large next-step" type="submit">Save Card</button>
            <input type="hidden" name="mysubmit" value="registration"/>
          </div>
        </form>
      </div>
      
      <!-- /Add new card Form close here --> 
      
    </div>
  </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script> 
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/bootstrapValidator-min.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.creditCardValidator.js"></script>
<script type="text/javascript">
     function forgot_popup()
	 {
		 $('#log_In').modal('hide'); 
		 $('#forget_Pass').modal();
	 }
	 
     $(document).ready(function() {
				
			$('.promo-code').click(function(){
					$("#promo-form").removeClass('hidden');		  
			});
		    
			$("#enter_code").click(function(){
					$(this).hide();
			});
			
			$("#mycards").change(function(){
				if($(this).val()=='add_new')
				{
					$('#add_edit_card').modal();
				}
			});
			
			$("#apply_coupon").click(function(){
				 var promo_val = $("#promocode").val();
				 $.ajax({
			  			url: base_url+'checkout_con/apply_coupon',
			  			dataType: 'json',
			 			type: 'POST',
					    data: {
						    promocode: promo_val				
						}
					}).done(function(response) {
						if($.isNumeric(response.coupon_id))
						{
							$("#discount_amt .fnt-hlv").html('-$'+response.discount_amount);
							$("#discount_amt").show();
							$(".promo-code").attr('rowspan','4');
							$("#total .fnt-hlv").html('$'+response.new_amount);
							$("#apply_coupon_id").val(response.coupon_id);
							$("#promo-form").hide();
							$("#correct_promo").removeClass('hidden').html('Promo Code '+promo_val+' has been applied!');
						//alert($("#total .fnt-hlv").text().replace('$', ''));
						}else{
							$("#promo-code-error").removeClass('hidden');
							$("#promo-code-error").html(response.coupon_id);	
						}
					});
			});
			var flag = '';
			$("#strip_payment").click(function(){
				 $("#strip_form").show();
				 $(".save-cards").show();
				 $(".paypal_info").addClass('hidden');
				 $("#payment_type").val('mystrip');
				 $("#paypal_complete").hide();
				 $("#stripe_complete").show();
				  var flag = '1';
				 <?php if($cuser_id == 0){?>
				   $(".cust_Form").attr('id','payment-form');
				 <?php } ?>
				
			});
			
			$("#paypal_payment").click(function(){
				 $("#strip_form").hide();
				 $(".save-cards").hide();
				 $(".paypal_info").removeClass('hidden');
				 $("#payment_type").val('mypaypal');
				 $("#paypal_complete").show();
				 $("#stripe_complete").hide();
				 var flag2 = '0';
				 <?php if($cuser_id == 0){?>
				   $(".cust_Form").attr('id','paymentpayform');
				 <?php } ?>
			});
			
			$("#stripe_complete").click(function(){
					$('#payment-form').bootstrapValidator({
					 submitHandler: function(validator, form, submitButton) { 
						// createToken returns immediately - the supplied callback submits the form if there are no errors
						Stripe.card.createToken({
							number: $('.card-number').val(),
							cvc: $('.card-cvc').val(),
							exp_month: $('.card-expiry-month').val(),
							exp_year: $('.card-expiry-year').val()
						}, stripeResponseHandler);
						return false; // submit from callback
					 }
		    	  });	
			});
			
		
			$('#paypal_complete').click(function(){
				   //alert('here...');
				  $('#paymentpayform').submit();
			});	
			
		  $('#addcard-form').bootstrapValidator({
					 submitHandler: function(validator, form, submitButton) { 
						// createToken returns immediately - the supplied callback submits the form if there are no errors
						var cid = $(".card-number").val();
                    //document.cookie = "cokecid="+cid+""; 
					document.cookie ="cokecid="+cid+";''; path=/";
					var month = $(".card-expiry-month").val();
     				document.cookie = "cokemonth="+month+";'';path=/";
					var year = $(".card-expiry-year").val();
     				document.cookie = "cokeyear="+year+";'';path=/";
					var ccv = $(".card-cvc").val();
     				document.cookie = "cokecvv="+ccv+";'';path=/";
					var zip = $(".card-zipcode").val();
     				document.cookie = "cokezip="+zip+";'';path=/";
						Stripe.card.createToken({
							number: $('.card-number').val(),
							cvc: $('.card-cvc').val(),
							exp_month: $('.card-expiry-month').val(),
							exp_year: $('.card-expiry-year').val()
						}, stripeResponseHandler2);
						return false; // submit from callback
					 }
		  });	
			
     });
	
	 var selectedCard = '<?php echo $selectedCard; ?>';
	 //alert(selectedCard);
	 $(window).load(function() { 
		  setTimeout(function () {
       		 //alert('page is loaded and 1 minute has passed');  
			 $("#mycards").trigger('change'); 
    	  }, 2000);
	 });
			
	 $("#mycards").change(function(){
		 $(".dropdown-toggle .pull-left").removeClass('sprite-image sprite-card-add-more');
		 $(".dropdown-toggle .pull-left").removeClass('sprite-image sprite-card-visa');
		 $(".dropdown-toggle .pull-left").removeClass('sprite-image sprite-card-mc');
		 $(".dropdown-toggle .pull-left").removeClass('sprite-image sprite-card-amex');
		 $(".dropdown-toggle .pull-left").removeClass('sprite-image sprite-card-descover');
		 var card_class = $('option:selected').attr('class');
		 //alert(card_class);
		 $(".dropdown-toggle .pull-left").addClass(card_class);
	 })		
  </script> 
<script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('<?php echo STRIP_KEY_JAVASCRIPT?>'); 
 
            function stripeResponseHandler(status, response) 
			{
			
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
					// show hidden div
					document.getElementById('a_x200').style.display = 'block';
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' id='stripeToken' name='stripeToken' value='" + token + "' />");
					form$.append("<input type='hidden' id='totalAmount' name='totalAmount' value='"+$("#total .fnt-hlv").text().replace('$', '')+"' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
			
			function stripeResponseHandler2(status, response)
			{
				  if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
					// show hidden div
					document.getElementById('a_x201').style.display = 'block';
                    // show the errors on the form
                    $(".payment-errors1").html(response.error.message);
                } else {
                    var form$ = $("#addcard-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' id='stripeToken' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
			}
 

</script> 
<script>
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-title')
        .find(".arrow")
        .toggleClass('glyphicon-menu-down glyphicon-menu-up');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);


function toggleChevron(e) {
    $(e.target)
        .prev('.panel-title')
        .find(".arrow")
        .toggleClass('glyphicon-menu-down glyphicon-menu-up');
}
$('#res_accordion').on('hidden.bs.collapse', toggleChevron);
$('#res_accordion').on('shown.bs.collapse', toggleChevron);
</script> 
<!-- close accordian Arrow --> 
<script>
    $(function() {
		$( ".card-number" ).keyup(function() {
       		 $('.card-number').validateCreditCard(function(result) {
			
			$("#crdimg").removeClass();
			if((result.card_type.name) == 'visa')
			{
			   $("#crdimg").addClass('card-icon sprite-image sprite-card-visa');	
			}
			if((result.card_type.name) == 'mastercard')
			{
			   $("#crdimg").addClass('card-icon sprite-image sprite-card-mc');	
			}
			if((result.card_type.name) == 'discover')
			{
			   $("#crdimg").addClass('card-icon sprite-image sprite-card-descover');	
			}
			if((result.card_type.name) == 'amex')
			{
			   $("#crdimg").addClass('card-icon sprite-image sprite-card-amex');	
			}
			        
        });
		});
    });
</script>
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



function toggleChevronm(e) {
    $(e.target)
        .prev('.faq-ttl')
        .find(".arrow")
        .toggleClass('glyphicon-menu-down glyphicon-menu-up');
}
$('#res_faq-accordion').on('hidden.bs.collapse', toggleChevronm);
$('#res_faq-accordion').on('shown.bs.collapse', toggleChevronm);


 jQuery(function(){
    jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    jQuery(window).resize(function(){
        jQuery('body .page') .css({'min-height': ((jQuery(window).height() - 109))+'px'});
    });
});
</script>