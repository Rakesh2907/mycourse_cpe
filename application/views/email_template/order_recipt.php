<?php
  //echo "<pre>";
  //print_r($order_details); 
  //echo "</pre>";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CPENATION</title>
</head>
<body style="font-family:Arial, Helvetica, sans-serif; font-size:15px;">
<?php $count_order_details = sizeof($data_order); 
 if($count_order_details > 0){
?>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td>&nbsp;</td>
  </tr>
<tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img style="width:200px;" src="<?php echo $this->config->item("cdn_css_image")?>images/logo.jpg" /></td>
    <td style="text-align:right;">433 Broadway, Suite 618 <br>
New York, NY 10013<br>
http://www.cpenation.com<br>
1-888-525-3244</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td style="padding:15px 0px;"><hr /></td>
  </tr>
  
 		 <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2 style="margin: 0px; font-size: 30px;">Order Receipt</h2><h4 style="margin: 0px; font-size: 20px; font-weight: normal; font-style: italic;">Order #<?php echo $order_details[0]['order_number'];?></h4></td>
    <td valign="top" style="text-align: right; font-size: 20px; font-weight: bold;"><?php echo date('F d, Y',strtotime($order_details[0]['order_date']));?></td>
  </tr>
</table>
    </td>
  </tr>
  
 		 <tr>
    <td style="padding-top: 28px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom: 50px;">
  <tr>
    <td width="100%" style="background: rgb(229, 229, 229) none repeat scroll 0% 0%; padding: 15px; font-size: 17px; line-height: 23px;">
<strong>Customer Details</strong> <br>
<?php echo $full_name;?> <br>
<?php echo $cemail;?></td>
    <td width="52%" style="text-align:right;">&nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
  		 <tr>
    <td style="font-size: 22px; font-weight: bold; border-bottom: 1px solid rgb(0, 0, 0); padding-bottom: 5px;">Order Summary</td>
  </tr>
  <?php 
 		foreach($data_order as $detail )
 		{ 
  ?>
         <tr>
            <td style="padding-top:20px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <?php if($detail['purchase_type']=='Bundle'){ 
			     $getdetails = $this->bundle_mod->get_bundle_details($detail['course_id']); 
			?>
              <tr>
                <td><h2 style="margin: 0px; font-weight: normal; font-size: 20px;"><?php echo trim($getdetails[0]['bundle_name']); ?></h2><h4 style="margin: 0px; font-weight: normal; font-style: italic; font-size: 16px;"><?php echo 'Compliance Bundle'; ?></h4></td>
                <td valign="top" style="margin: 0px; font-weight: normal; font-size: 20px; text-align:right;">$<?php echo number_format($detail['course_amount'],2); ?></td>
              </tr>
            <?php }else if($detail['purchase_type']=='Course'){
				 $getdetails = $this->course_mod->get_course_details($detail['course_id']); 						  
			 ?>
               <tr>
                <td><h2 style="margin: 0px; font-weight: normal; font-size: 20px;"><?php echo trim($getdetails[0]['course_name']); ?></h2><h4 style="margin: 0px; font-weight: normal; font-style: italic; font-size: 16px;"><?php echo 'Course'; ?></h4></td>
                <td valign="top" style="margin: 0px; font-weight: normal; font-size: 20px; text-align:right;">$<?php echo number_format($detail['course_amount'],2); ?></td>
              </tr>
             <?php }else if($detail['purchase_type']=='Subscription'){ 
			 		$getdetails = $this->subscription_mod->get_subscription_details($detail['course_id']);
			 ?>
               <tr>
                <td><h2 style="margin: 0px; font-weight: normal; font-size: 20px;"><?php echo trim($getdetails[0]['title']); ?></h2><h4 style="margin: 0px; font-weight: normal; font-style: italic; font-size: 16px;"><?php echo 'Subscription'; ?></h4></td>
                <td valign="top" style="margin: 0px; font-weight: normal; font-size: 20px; text-align:right;">$<?php echo number_format($detail['course_amount'],2); ?></td>
              </tr>
			 <?php } ?>
        </table>
            </td>
          </tr>
   <?php } ?>
 		 
 		 <tr>
    <td style="padding:15px 0px;"><hr /></td>
  </tr>
 		 <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="margin: 0px; font-weight: normal; font-size: 18px; font-style:italic;"></td>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 17px; line-height: 27px;">
  <tr>
    <td>Subtotal</td>
    <td>&nbsp;</td>
    <td style="text-align:right;">$<?php echo $order_details[0]['order_total']; ?></td>
  </tr>
  <tr>
  <?php if($prices['tax_amount'] != 0.00) {?>
       <td>Tax</td>
       <td>&nbsp;</td>
       <td style="text-align:right;">$<?php echo $prices['tax_amount']; ?></td>
      </tr>
   <?php } ?>
  <?php if($order_details[0]['discount'] != 0.00) {?>
  <tr>
    <td>Discount</td>
    <td>&nbsp;</td>
    <td style="text-align:right;">-$<?php echo $order_details[0]['discount']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td><strong>Total</strong></td>
    <td>&nbsp;</td>
    <td style="text-align:right;"><strong>$<?php echo number_format((($order_details[0]['order_total']+$prices['tax_amount'])-$order_details[0]['discount']),2); ?></strong></td>
  </tr>
</table>

    </td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
  <td style="text-align: center; padding-top: 200px; font-size: 18px; font-style: italic;">Thank you for your patronage!</td>
  </tr>
  <tr><td align="center" style="padding-top:40px;padding-bottom:40px;border-top:1px solid #dddddd;font-size:12px;">
  <em>You are receiving this email because you completed an action at cpenation.com</em></td>
</tr>
</table>
<?php } ?>
</body>
</html>