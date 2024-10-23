<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="telephone=no" name="format-detection" />
<title>Receipt</title>
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
<script language="javascript">
    function myFunction()
    {
        var surchare = 0;//prompt("Enter Surcharge");
        var total = document.getElementById("hidtotal").value;
        
        document.getElementById("spsurcharge").innerHTML = surchare;
        document.getElementById("grosstotal").innerHTML = (+surchare + +total);
        window.print();
    }
</script>

<body style="margin:0px; padding:0px;" bgcolor="#ffffff" onload="myFunction();" >
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
                            <td width="70%">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                <tr> 
                                  <td width="100%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->businessname; ?></td>  
                                </tr> 
                                <tr> 
                                  <td width="100%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->postal_address; ?></td>  
                                </tr>
                                <tr> 
                                  <td width="100%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;">Tel: <?php echo $data->row(0)->mobile_no; ?></td>  
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
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr> 
                    <tr>
                      <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr>
                    <tr>
                      <td style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#222; text-transform: uppercase; font-weight: bold;">Transaction Details</td>
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
                      <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%"  valign="top">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Transfer Date:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->add_date; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Sender Mobile No:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->RemiterMobile; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Transfer Type:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->mode; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Transaction ID:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->Id; ?></td>  
                                </tr>
                                
                              </table>
                            </td>
                            <td width="50%" valign="top">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#666; ">Name as per Bank:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->RESP_name; ?></td> 
                                </tr>
                                
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Accont No:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->AccountNumber; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">IFSC Code:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->IFSC; ?></td>  
                                </tr>
                                <tr>
                                  <td width="40%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#666; ">Bank Name:</td>
                                  <td width="60%" align="left" valign="top" style="font-family:Arial, sans-serif; font-size:12px; line-height:20px; text-decoration:none; color:#222; font-weight: bold;"><?php echo $data->row(0)->bank_name; ?></td>  
                                </tr>
                                
                              </table>
                            </td>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="10" style="line-height: 1px; font-size: 1px; ">&nbsp;</td>
                    </tr>  
                    <tr>
                      <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 10px; border:1px solid #ddd;">   
                          <tr>
                            <td>
                              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="padding: 5px 2px 3px 2px;">
                                  <tr>
                                      <td>Sr.</td>
                                      <td>Account Number</td>
                                      <td>BankName</td>
                                      <td>Amount</td>
                                      <td>Ref.No</td>
                                      <td>Status</td>
                                  </tr>
                                  <?php
                                  error_reporting(-1);
                                  ini_set('display_errors',1);
                                  $this->db->db_debug = TRUE;
                                  $i = 1;
                                  $total = 0.00;
                                  
                                 
                        		    $rsltunique = $this->db->query("SELECT a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username,info.postal_address,b.mobile_no,info.emailid,
r.name as remittername,
bank.BankName as bank_name

FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join beneficiaries bene on a.BeneficiaryId = bene.paytm_bene_id
left join bank_master bank on bene.bank_id = bank.Id
left join tblusers_info info on a.user_id = info.user_id
left join mt3_remitter_registration r on a.remitter_id = r.remitter_id and r.RESP_statuscode = 'TXN'
 where a.unique_id = ? order by a.Id desc",array($data->row(0)->unique_id));
                                     if($rsltunique->num_rows() == 0)
                                     {
                                                                            $rsltunique = $this->db->query("SELECT a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
                                    a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
                                    a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
                                    a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
                                    b.businessname,b.username,info.postal_address,b.mobile_no,info.emailid,
                                    r.name as remittername
                                    
                                    FROM masterpa_archive.mt3_transfer a
                                    left join tblusers b on a.user_id = b.user_id
                                    left join tblusers_info info on a.user_id = info.user_id
                                    left join mt3_remitter_registration r on a.remitter_id = r.remitter_id and r.RESP_statuscode = 'TXN'
                                     where a.unique_id = ? order by a.Id desc",array($data->row(0)->unique_id));
                                    }
                        		
                                    
                                    foreach($rsltunique->result() as $r)
                                    {
                                  ?>
                                <tr>
                                  <td> <?php echo $i; ?></td>
                                  <td> <?php echo $r->AccountNumber; ?></td>
                                  <td> <?php echo $r->bank_name; ?></td>
                                  <td> <?php echo $r->Amount; ?></td>
                                  <td> <?php echo $r->RESP_opr_id; ?></td>
                                  <td> <?php echo $r->Status; ?></td>
                                </tr>
                                <?php 
                                /*if($r->Status == "SUCCESS")
                                {*/
                                    $total += $r->Amount;
                                //}
                                $i ++;} ?>
                              </table>
                            </td>
                          </tr>   
                          <tr>
                            <td height="1" style="line-height: 0px; font-size: 0px; border-bottom:1px solid #ddd;">&nbsp;</td>
                          </tr> 
                          <tr>
                            <td height="10" style="line-height: 0px; font-size: 0px;">&nbsp;</td>
                          </tr> 

                          <tr>
                            <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px 0 3px 0;">
                                <tr>
                                  <td width="65%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;"> </td>
                                  <td width="20%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;">Total Amount :</td> 
                                  <td width="" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;"><?php echo $total; ?>
                                    <input type="hidden" id="hidtotal" value="<?php echo $total; ?>">

                                  </td>
                                </tr>
                                <tr>
                                  <td width="65%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;"> </td>
                                  <td width="20%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;">Convenience Fee :</td> 
                                  <td width="" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;"><span id="spsurcharge">0</span></td>
                                </tr>

                                <tr>
                                  <td width="65%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;"> </td>
                                  <td width="20%" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;">Total :</td> 
                                  <td width="" align="left" valign="middle" style="font-family:Arial, sans-serif; font-size:12px; line-height:14px; text-decoration:none; color:#222; font-weight: bold; text-transform: uppercase;"><span id="grosstotal">0</span></td>
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
                      <td style="font-family:Arial, sans-serif; font-size:12px; text-align: center; line-height:20px; text-decoration:none; color:#222; font-weight: bold;">Thank you For Using <?php echo $this->white->getName(); ?></td>
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
