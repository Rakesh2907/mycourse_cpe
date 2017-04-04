<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registration</title>
</head>

<body style="background:#fff; font-family:Arial, Helvetica, sans-serif; font-size:14px;color:#000;padding:0;">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:600px;padding:25px 28px 10px;" >
<tr>
<td style="border-bottom:1px solid #dddddd;padding-bottom:35px;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="middle"><img style="max-width:228px;width:100%;" src="<?php echo $this->config->item("cdn_css_image")?>images/cpe-logo-email.png" alt="CPE Nation" /></td>
<td align="right" valign="top" style="font-size:12px;padding-left:10px;">433 Broadway, Suite 618<br>
New York, NY 10013<br>
http://www.cpenation.com<br>
1-888-525-3244</td>
</tr>
</table>
</td>
</tr>

<tr>
<td valign="top" style="padding-top:10px;">
<h2 style="margin-top:0;margin-bottom:25px;font-size:24px;">Welcome to CPE Nation!</h2>
<p style="background-color: #e5e5e5;margin-top: 0;margin-bottom:25px;padding: 20px 18px;">Thank you for joining CPE Nation, your account details are below.</p>

<p style="margin-top:0;margin-bottom:28px;">
<strong>User Email -</strong> <?php echo $e_mail;?><br>
<strong>Name -</strong> <?php echo $first_name.' '.$last_name;?><br>
<strong>Professional Designations -</strong> <?php echo $designations;?>
</p>

<p style="min-height:210px;">To make changes to your account details, please visit <a href="<?php echo base_url()?>" style="color:#324aff">cpenation.com</a> and log in to your account.</p>
</td>
</tr>

<tr><td align="center" style="padding-top:40px;padding-bottom:40px;border-top:1px solid #dddddd;font-size:12px;">
  <em>You are receiving this email because you completed an action at cpenation.com</em></td>
</tr>

</table>

</body>
</html>
