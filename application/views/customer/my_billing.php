<?php $del_msg = $_REQUEST['delete']; 

if($del_msg == 1)
{
 $success_msg = 'Card Deleted Succesfully';	
}

?>

<style>
.modal-open .modal::after {
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
 <div class="col-lg-6 col-lg-offset-1 col-md-6 col-sm-8 ord-right">
<div class="billing-wrp">
  <?php if($success_msg !=''){?>
                <div class="alert alert-success display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                   <?php echo $success_msg; ?>
                </div>
            <?php } ?>
<div id="deltemsg" style="display:none;"><span style="text-align:center; color:green;">Card Deleted successfully.....</span></div> 
<div class="billing-head">
<div id="loader_bill" style="display:none; position:relative; left:40%; top:35%;"><img src="<?php echo $this->config->item("cdn_css_image")?>images/ajax-loader.gif" alt="close" /></div>
<?php if($err_msg){ ?>
   <div class="alert alert-danger"> <?php echo $err_msg; ?> </div>
<?php } ?> 
<div class="card-inf">Credit / Debit Card</div> 
<div class="card-exp-date">Expires</div> 
</div>
 
 <div id="accordion" class="panel-group billing_Acc custom-panel">

<?php 

if(count($cards) > 0){
	$i=0;
	 foreach ($cards as $card)
	 {
		 $i++;
		
		if($card['card_brand'] == 'Visa')
		{
			 $card_class ='sprite-card-visa';
		}
		if($card['card_brand'] == 'MasterCard')
		{
			 $card_class ='sprite-card-mc';
		}
		if($card['card_brand'] == 'American Express')
		{
			 $card_class ='sprite-card-amex';
		}
	   if($card['card_brand'] == 'Discover')
		{
			 $card_class ='sprite-card-descover';
		}
	 ?>
          <!-- /panel -->
          
  <div class="panel">
 <div class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>">
 <span class="dflt"><?php if($i == 1){?>Default<?php }?></span>
 <div class="card-inf"><div class="card-icon sprite-image <?php echo $card_class; ?> " id="card_<?php echo $i;?>" data-id=="cust_<?php echo $card['card_brand'].'_'.$card['last4'].'_'.$card['zipcode'].'_'.$card['exp_month'].'_'.$card['exp_year'];?>"></div> Mastercard ending in 4480</div> 
 <div class="card-exp-date"><?php echo $card['exp_month']; ?>/<?php echo $card['exp_year']; ?></div> 
 <a class="accordion-toggle">
 <span class="glyphicon glyphicon-menu-up"></span>
 </a>
 </div> <!-- /panel-title -->
 
 <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
 <div class="bill_Deatils">
 <div class="billing-info"><h6>Zip Code</h6>
<?php echo $card['zipcode']; ?> </div>
  <div class="card-act">
  <a href="javascript:void(0);" data-toggle="modal"  data-id="<?php echo $card['cardid']; ?>" id="<?php echo $i;?>" class="btn editcard">Edit</a>
 <a href="javascript:void(0);" class="delt delt1" data-id="<?php echo $card['cardid']; ?> ">Delete</a>
          <?php if($i != 1){?><br /><a href="javascript:void(0);" class="delt default" data-id="<?php echo $card['cardid']; ?> " style="margin-left:0px;">Make Default Card</a><?php }?>
  </div>
  </div> <!-- /bill_Deatils -->
</div> <!-- /panel-collapse -->
  </div>
 
 <?php }
 } else{?>
              <div class="col-md-12 col-md-offset-2" id="norecord" >
                <div class="not-found"> <img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" width="50" alt="Not Found" /> <i>Sorry, no Credit cards found.</i> </div>
                <!-- /not-found --> 
              </div>
              <?php }?>
  
<input type="hidden" name="custid" id="custid" value="<?php echo $custid; ?>">
 </div> <!-- /panel-group -->
 
 
<a href="#" data-toggle="modal" data-backdrop="false" data-target="#add_edit_card" class="add-new-lnk"><span>Add New Credit / Debit Card</span></a>
 
</div> <!-- /billing-wrp -->
 </div>
 
</div><!-- /row -->
</div> <!-- container -->



 

 <!-- /footer -->

</div> <!-- /page -->

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
		$payurl=base_url().'customer_con/my_billing';	
			 ?>
 <form id="payment-form" class="cust_Form billing_Form inline-label" method="post" name="account_form" action="<?php echo $payurl;?>">
 <div class="alert alert-danger" id="a_x200" style="display: none;"> <strong>Error!</strong> <span class="payment-errors"></span> </div> 
<!--<div class="form-group card-fld"><label class="control-label">Card #</label>
<div class="inline-fld">
<input type="text" class="form-control card-number"  name="cardnumber" required="required">
<img width="29" alt="Card" src="<?php //echo $this->config->item("cdn_css_image")?>images/m-c-icon.png" class="m-card" id="crdimg"></div>
</div>-->
<div class="form-group card-fld"><label class="control-label">Card #</label>
<div class="inline-fld">
<input type="text" class="form-control card-number"  name="cardnumber" required="required"  value="<?php echo $cid; ?>">
<div class="m-card card-inf"><div class="" id="crdimg"></div>
</div>

</div></div>
<div class="form-group">
<label class="control-label">Expires</label>
<div class="inline-fld">
<div class="smll-field">
<input type="text" placeholder="MM" class="form-control card-expiry-month" name="add_month" id="add_month" required="required" maxlength="2" value="<?php echo $cmonth; ?>"></div>
<div class="smll-field">
<input type="text" placeholder="YYYY" class="form-control card-expiry-year" name="add_year" id="add_year" required="required" maxlength="4" value="<?php echo $cyear; ?>"></div>

</div> <!-- /inline-fld> -->
</div>

<div class="form-group">
<label class="control-label">CVV</label>
<div class="inline-fld">
<div class="smll-field full-xs cvv-fld">
<input type="text" class="form-control card-cvc" name="cvv" id="cvv" required="required" value="<?php echo $cccv; ?>"> <img width="39" alt="CVV" src="<?php echo $this->config->item("cdn_css_image")?>images/cvv_icon.png" class="cvv-icon"></div>
</div> <!-- /inline-fld> -->
</div>

<div class="form-group">
<label class="control-label" onBlur="zip" >Zip Code</label>
<div class="inline-fld">
<input type="text" class="form-control card-zipcode" id="zip" name="zip" required="required" maxlength="7" value="<?php echo $czip; ?>">
</div> <!-- /inline-fld> -->
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

<!-- Modal Close -->



<!-- Edit Card Modal -->
<div role="dialog" class="modal fade cst-flat-popup" id="add_edit_card_Edit">
  <div class="modal-dialog mdl-cs-wd leave_com add-Edit-Card">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close icon-cross" type="button"></button>
        
        <h4 class="modal-title text-center">Edit your card</h4>
      </div>
      <div class="modal-body">
<!-- Edit card Form -->
<?php  
	    	$attributes = array('class' => 'cust_Form billing_Form edit-card inline-label', 'id' => 'myform');
			echo form_open('customer_con/my_billing/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
			 ?>
 <!--<form class="cust_Form billing_Form edit-card inline-label">-->
 
<div class="form-group card-line"><label class="control-label card-inf">
<span class="card-icon sprite-image sprite-card-mc-2"></span>
</label>
<div class="inline-fld"><span class="card-name"><span id='edit_card_name'></span> ending in <span id="edit_card_last"></span></span></div></div>

<div class="form-group">
<label class="control-label">Expires</label>
<div class="inline-fld">
<div class="smll-field">
<input type="text" placeholder="MM" class="form-control" name="edit_card_month" id='edit_card_month' maxlength="2" required="required"></div>
<div class="smll-field">
<input type="text" placeholder="YYYY" class="form-control" name="edit_card_year" id='edit_card_year' maxlength="4" required="required"></div>
</div> <!-- /inline-fld> -->
</div>

<div class="form-group">
<label class="control-label">Zip Code</label>
<div class="inline-fld">
<input type="text" class="form-control" id="edit_card_zip" name="edit_card_zip" maxlength="7" required="required">
<input type="hidden" class="form-control" id="edit_custid" name="edit_custid"  value="<?php echo $custid; ?>">
<input type="hidden" class="form-control" id="edit_cardid" name="edit_cardid">

</div> <!-- /inline-fld> -->
</div>

<div class="btn-sec"><!--<button class="btn fad-orange md-large" type="button">Save Card</button>-->
<input  class="btn fad-orange md-large" type="submit" name="editcard" value="Save Card"/></div>
<?php	
echo form_close();
?>
        <!-- /Edit card Form close here -->
     </div>
    </div>

  </div>
</div>

<script>
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
<!-- drawer Menu -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/bootstrapValidator-min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/jquery.creditCardValidator.js"></script>
<script>
$( ".default" ).click(function() {
 
 //$("#loader_bill").show();
  var cardid=$(this).data("id");
  
    var custid= $("#custid").val();

  	$.ajax({
				type:'POST',
				url: base_url+"customer_con/set_default_card/",
				
				data:{
					card_id: cardid,
					cust_id:custid
					},
				async:false,
				
				success: function(result){
					
					location.href = base_url+'mybilling/';
					$("#loader_bill").hide();
					if(result == 1)
					{
					 //$("#deltemsg").show();
					}
					
				}
			});	
});
$( ".delt1" ).click(function() {
 //$("#loader_bill").show();
  var cardid=$(this).data("id");
    var custid= $("#custid").val();

  	$.ajax({
				type:'POST',
				url: base_url+"customer_con/delete_card/",
				
				data:{
					card_id: cardid,
					cust_id:custid
					},
				async:false,
				
				success: function(result){
					$("#loader_bill").hide();
					if(result == 1)
					{
						
					// $("#deltemsg").show();
					 window.location.href=base_url+"customer_con/my_billing/?delete=1";
					}
					
				}
			});	
});

$( ".editcard" ).click(function() {
	  var cust_id=$(this).data("id");
	  
	 var cnt= $(this).attr('id');
	  var vartext1=$('#card_'+cnt).data("id");
	  var array = vartext1.split('_');
	   
	    $("#edit_card_name").html(array[1]);
	    $("#edit_card_last").html(array[2]);
		$("#edit_card_month").val(array[4]);
		$("#edit_card_year").val(array[5].slice(0, -1));
		$("#edit_card_zip").val(array[3]);
		$("#edit_cardid").val(cust_id);
		 $('#add_edit_card_Edit').modal('show');
	
	});	
$('#payment-form').bootstrapValidator({
	
				 submitHandler: function(validator, form, submitButton) {
					 
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
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.card.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val(),
						address_zip: $('.card-zipcode').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
        		 }
});	
</script>
<script>
    $(function() {
        $('.card-number').validateCreditCard(function(result) {
			
            //alert(result.card_type.name)
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
                    // and submit
                    form$.get(0).submit();
                }
            }
 

$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-up").removeClass("glyphicon-menu-up").addClass("glyphicon-menu-down");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-menu-down").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
});


</script>

