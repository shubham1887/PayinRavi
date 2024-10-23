<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="telephone=no" name="format-detection" />
<title>Dezire Money</title>
<style type="text/css">
body {
	-webkit-text-size-adjust: 100% !important;
	-ms-text-size-adjust: 100% !important;
	-webkit-font-smoothing: antialiased !important;
}
p {
	Margin: 0px !important;
	Padding: 0px !important;
}
.ExternalClass * {
	line-height: 100%;
}
span.MsoHyperlink {
	mso-style-priority: 99;
	color: inherit;
}
span.MsoHyperlinkFollowed {
	mso-style-priority: 99;
	color: inherit;
}
.ef_white a {
	color: #ffffff;
	text-decoration: none;
}
.ef_grey a {
	color: #818183;
	text-decoration: none;
}
.ef_blue a {
	color: #97d6c5;
	text-decoration: none;
}
.ef_black a {
	color: #000000;
	text-decoration: none;
}
 @media only screen and (min-width:481px) and (max-width:800px) {
.ef_wrapper {
	width: 100% !important;
	height: auto !important;
}
.ef_side {
	width: 20px !important;
}
.ef_height {
	height: 20px !important;
}
.ef_hide {
	display: none !important;
}
span[class=ef_divhide] {
	display: none !important;
}
.ef_brk {
	display: block !important;
}
.ef_bottom {
	padding-bottom: 20px !important;
}
}
@media only screen and (min-width:414px) and (max-width:480px) {
.ef_wrapper {
	width: 100% !important;
	height: auto !important;
}
.ef_side {
	width: 20px !important;
}
.ef_height {
	height: 20px !important;
}
.ef_hide {
	display: none !important;
}
.ef_body1 {
	min-width: 100%;
	min-width: 100vw;
}
body[class=ef_body1] {
	min-width: 414px !important;
}
.ef_bottom {
	padding-bottom: 20px !important;
}
}
@media only screen and (max-width:413px) {
.ef_wrapper {
	width: 100% !important;
	height: auto !important;
}
.ef_side {
	width:20px !important;
}
.ef_height {
	height: 20px !important;
}
.ef_hide {
	display: none !important;
}
span[class=ef_divhide] {
	display: none !important;
}
.ef_bottom {
	padding-bottom: 20px !important;
}
}
</style>
<!--[if gte mso 9]>
<xml>
  <o:OfficeDocumentSettings>
    <o:AllowPNG/>
    <o:PixelsPerInch>96</o:PixelsPerInch>
 </o:OfficeDocumentSettings>
</xml>
<![endif]-->
</head>

<?php

$agent_info = $this->db->query("select * from tblusers where user_id = ?",array($AgentId));
$payment_info = $this->db->query("SELECT * FROM payu_transactions where Id = ? and user_id = ?",array($UID,$AgentId));

?>
<body style="margin:0px; padding:0px;" bgcolor="#ffffff">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff">
   <tr>
      <td height="10" style="line-height: 1px; font-size:1px;">&nbsp;</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><table align="center" class="ef_wrapper" width="800" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;width:800px; border-radius: 10px;-webkit-box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.50);. -moz-box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.50);. box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.50); border-top: 1px solid #ddd;" bgcolor="#ffffff"> 
        
        <tr>
          <td align="center" valign="middle" bgcolor="#f5f5f5" style="padding: 10px 0px;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10" style="width:20px;" class="ef_side">&nbsp;</td>
                <td  align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr>  
                    <tr>
                      <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%" valign="top" align="left" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;"><img alt="" src="<?php echo base_url(); ?>images/logo-dezire-main.png" width="auto" border="0" style="display:inline-block; max-width:200px;height:40px; font-family:Arial, sans-serif; font-size:15px; line-height:20px; color:#000000; font-weight:bold;" /></a></td> 
                            
                          </tr>
                          <tr>
                              <td width="50%">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#666; ">Agent Name:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $agent_info->row(0)->business_name; ?></td>  
                                </tr> 
                                
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Email:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $agent_info->row(0)->emailid; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Contact No:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $agent_info->row(0)->mobile_no; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Address:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $agent_info->row(0)->address_line1."<br>".$agent_info->row(0)->address_line2."<br>".$agent_info->row(0)->address_line3; ?></td>  
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr> 
                    <tr>
                      <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#222; text-transform: uppercase; font-weight: bold;">PAYMENT ACKNOWLEDGEMENT</td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 10px; border:1px solid #ddd;">   
                          <tr>
                            <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                
                              </table>
                            </td>
                          </tr> 
                          <tr>
                            <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                  <tr>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#666; ">Bank Ref Id:</td>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $payment_info->row(0)->RESP_bank_ref_num; ?></td> 
                                  </tr><tr>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#666; ">Date Time:</td>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $payment_info->row(0)->add_date; ?></td> 
                                </tr>
                                <tr>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#666; ">Bank Code :</td>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $payment_info->row(0)->RESP_bankcode; ?></td> 
                                 </tr><tr>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#666; ">Response Message:</td>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $payment_info->row(0)->RESP_field9; ?></td> 
                                </tr>
                                <tr>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#666; ">Amount:</td>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $payment_info->row(0)->Amount; ?></td> 
                                 </tr><tr> 
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#666; ">Status:</td>
                                  <td width="25%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $payment_info->row(0)->status; ?></td>  
                                </tr>
                              </table>
                            </td>
                          </tr> 
                          <tr>
                            <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                
                              </table>
                            </td>
                          </tr> 
                          <tr>
                            <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                          </tr>
                         
                          <tr>
                            <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                          </tr> 
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-family:Arial, sans-serif; font-size:12px; text-align: center; line-height:20px; text-decoration:none; color:#F00; font-weight: bold;">Thank you For Using DezireMoney</td>
                    </tr>

                  </table></td>
                <td width="10" style="width:20px;" class="ef_side">&nbsp;</td>
              </tr>
            </table></td>
        </tr> 
      </table></td>
  </tr>
  <tr>
    <td height="10" style="line-height: 1px; font-size:1px;">&nbsp;</td>
  </tr>
</table>
<div class="ef_hide" style="white-space:nowrap;font:20px courier;color:#E0F1FF; background-color:#E0F1FF; font-size:0px; line-height:0px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
</body>
</html>
