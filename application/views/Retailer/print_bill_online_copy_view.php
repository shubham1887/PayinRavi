<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="telephone=no" name="format-detection" />
<title>MyPayMall</title>
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
@media only screen and (max-width:800px) {
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
table, tr, td, img {float: left; width: 100%; padding: 0; height: auto;}
table tr td {float: left; width: 100%; padding: 0; margin-bottom: 10px; height: auto;}
table:first-child {padding: 10px;}
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


<body style="margin:0px; padding:0px;" bgcolor="#ffffff"  onload="window.print();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff">
   <tr>
      <td height="10" style="line-height: 1px; font-size:1px;">&nbsp;</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><table align="center" class="ef_wrapper" width="800" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;width:800px;" bgcolor="#ffffff"> 
        
        <tr>
          <td align="center" valign="middle"  style="padding: 10px 0px;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                            <td width="70%">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                
                                
                                <tr> 
                                  <td width="100%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;">Transaction Receipt</td>  
                                </tr>
                                <tr> 
                                  <td width="100%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222;">Thank You For Transacting at <?php echo $this->white->getDomainName(); ?></td>  
                                </tr> 
                              </table>
                            </td>
                            <td width="30%" valign="top" align="left" style="font-size:0px; line-height:0px;"><a href="#" target="_blank" style="text-decoration:none;">
                                <img alt="" src="<?php echo base_url()."MPM3.png"; ?>" width="auto" border="0" style="display:inline-block; max-width:150px; font-family:Arial, sans-serif; font-size:15px; line-height:20px; color:#000000; font-weight:bold;" />
                                </a></td> 
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; "></td>
                    </tr> 
                    
                    <tr>
                      <td>
                          
                          <table width="100%" border="1" cellspacing="0" cellpadding="0" style="padding: 5px 2px 3px 2px;">
                                  <tr>
                                      <td>Retailer Name</td><td><?php echo $data->row(0)->businessname;?></td>
                                  </tr>
                                  <tr>
                                      <td>Consumer Name</td><td><?php echo $data->row(0)->customer_name;?></td>
                                  </tr>
                                  <tr>
                                      <td>Consumer Mobile Number</td><td><?php echo $data->row(0)->customer_mobile;?></td>
                                  </tr>
                                  <tr>
                                      <td>Transaction Date</td><td><?php echo date_format(date_create($data->row(0)->add_date),'d-m-Y h:i:s A');?></td>
                                  </tr>
                                   <tr>
                                      <td>Transaction Id</td>
                                      <td>
                                          <?php 
                                            if($data->row(0)->status == "Pending")
                                            {
                                                echo $data->row(0)->Id;
                                            }
                                            else
                                            {
                                                echo $data->row(0)->opr_id;
                                            }
                                            
                                          ?>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>Biller Name</td><td><?php echo $data->row(0)->company_name;?></td>
                                  </tr>
                                  <tr>
                                      <td>Consumer Account Number</td>
                                      <td><?php echo $data->row(0)->service_no;?></td>
                                  </tr>
                                  <tr>
                                      <td>Bill Date</td>
                                      <td><?php echo $data->row(0)->billdate;?></td>
                                  </tr>
                                  <tr>
                                      <td>Bill Amount</td>
                                      <td><?php echo $data->row(0)->bill_amount;?></td>
                                  </tr>
                                  <tr>
                                      <td>Status</td>
                                      <td><?php 
                                        if($data->row(0)->status == "Pending")
                                        {
                                            echo "Success";    
                                        }
                                        else
                                        {
                                            echo $data->row(0)->status;
                                        }
                                        
                                        
                                        ?>
                                      </td>
                                  </tr>
                                  
                                <tr>
                                      <td colspan=2>This is a system generated receipt hence does not require any signature</td>
                                  </tr>
                              </table>
                    </td>
                    </tr>
                   
                    
                   
            </table></td>
        </tr> 
      </table></td>
  </tr>
  
</table>

</body>

</html>
