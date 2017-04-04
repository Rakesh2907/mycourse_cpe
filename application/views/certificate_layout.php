<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CPE Certificate</title>
<link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">
</head>

<body>
<table width="1050" border="0" cellspacing="0" cellpadding="0" align="center" style="background:url(<?php echo $this->config->item("cdn_css_image")?>images/certificate_template.png) no-repeat center top; background-size: 100% auto;font-family: 'Raleway', sans-serif;font-size:16px;color:#000000;height:665px;">
  <tr>
    <td valign="top" style="padding: 66px 40px 60px;"><table cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
          <td align="center"><img width="160" alt="CPE Nation" src="<?php echo $this->config->item("cdn_css_image")?>images/certificate_logo.png"></td>
        </tr>
        <tr>
          <td align="center" style="font-size: 40px;font-weight:bold;padding-bottom: 10px;padding-top: 18px;">Certificate of Completion</td>
        </tr>
        <tr>
          <td align="center" style="font-size: 19px;padding-bottom: 6px;">This certificate is presented to</td>
        </tr>
        <tr>
          <td align="center" style="font-size: 27px;font-weight:bold;padding-bottom: 5px;"><?php echo trim($full_name);?></td>
        </tr>
        <tr>
          <td align="center" style="font-size: 19px;">For completion of</td>
        </tr>
        <tr>
          <td align="center" style="font-size: 27px;font-weight:bold;padding-top:15px;"><?php echo trim($course_details[0]['course_name']);?></td>
        </tr>
        
        <tr>
          <td height="38"></td>
        </tr>
        
        <tr>
        <td align="center">  <div class="award-details" style="padding-bottom:30px;">Awarded: <?php echo date('F d,Y',strtotime($completed_date));?><br>
Location: <?php echo $state_name;?><br>
National Registry of CPE Sponsors Number: 138340<br>
Delivery Method: QAS Self-Study </div> <!-- award-details -->
        </td>
        </tr>
        
        <tr>
        <td align="center">
            
            <table class="certf-sub" width="400">
  			<?php
			      $total = 0.00;
				  
			     foreach($mycredits as $credit_type_id => $credit_type)
				 {
					 foreach($credit_type as $points => $type)
					 {
						  $points = round($points,1); 
						  if($points > 1){
							$mycredit = $points.' Credits';  
						  }else{
							$mycredit = $points.' Credit';
						  }
						  
						  if($type == 'Taxes' && $state_name == 'New York')
						  	$type = 'Taxation';
			  ?>
                        <tr>
                          <td align="left"><?php echo $type;?></td>
                          <td align="right" width="112"><?php echo $mycredit;?></td>
                        </tr>
                <?php
				      $total += $points;
				   }
				 } ?>
              <tr class="sepr">
                <td colspan="2"><hr style="margin-top: 5px; margin-bottom: 5px;"></td>
              </tr>
              <tr>
                <td align="left">Total</td>
                <?php if($total > 1){
					    $total_credit = $total.' Credits';
					}else{
						$total_credit = $total.' Credit';
					}
				?>
               
                <td align="right" width="112"><?php echo $total_credit;?></td>
              </tr>
               <tr><td colspan="2">&nbsp;</td></tr>
            </table></td>
        </tr>
        
    </table></td>
  </tr>

</table>
</body>
</html>