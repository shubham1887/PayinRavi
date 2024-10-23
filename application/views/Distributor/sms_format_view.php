<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Mobile Recharge, DTH Recharge - SMS Format</title>
   <?php include("script.php"); ?> 
   <style>
   table
   {
   	font-size:14px;
   }
   </style>
</head>
<body class="twoColFixLtHdr">
<div id="container" class="container">
  <div id="header">
  <a href="<?php echo base_url(); ?>" class="logo"></a>
  </div>
  <div id="back-border">
  </div>  
  <div style="text-align:left;">
    <h2>Mobile Recharge Format</h2>
    
    <table width="60%" border="1" cellspacing="0" cellpadding="3">
  <tr>
    <th scope="col">Company Name</th>
    <th scope="col">Recharge Format</th>
  </tr>
  <tr>
    <td>AIRTEL</td>
    <td>A RA 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>AIRCEL</td>
    <td>A RA 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
	
    <td>VODAFONE</td>
    <td>RA RV 10 9898098980 To 8866107107</td>
  </tr>
  
  <tr>
    <td>BSNL - STV</td>
    <td>A RB 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>BSNL - TOPUP</td>
    <td>A TB 10 9898098980 To 8866107107</td>
  </tr>  
  <tr>
    <td>VIRGIN - GSM</td>
    <td>A RD 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>VIRGIN - CDMA</td>
    <td>A RD 10 9898098980 To 8866107107</td>
  </tr>  
  <tr>
    <td>DOCOMO</td>
    <td>A RD 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>DOCOMO-SPECIAL</td>
    <td>A TD 10 9898098980 To 8866107107</td>
  </tr>  
  <tr>
    <td>RECHARGE VIDEOCON</td>
    <td>A RM 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>RECHARGE VIDEOCON - SPL</td>
    <td>A TM 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>RELIANCE - GSM</td>
    <td>A RG 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>RELIANCE - CDMA</td>
    <td>A RR 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>IDEA</td>
    <td>A RI 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>TATA INDICOM</td>
    <td>A RD 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>MTS</td>
    <td>A RM 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>UNINOR - SPL<br></td>
    <td>A TU 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>UNINOR</td>
    <td>A RU 10 9898098980 To 8866107107</td>
  </tr>
  
      <tr>
    <td align="center" colspan="2"><strong style="font-size:18px;color:#00C;">A CODE AMOUNT MOBILENO TO 8866107107</strong></td>
  </tr>
</table>
    <h2>DTH Recharge Format</h2>
    <table width="60%" border="1" cellspacing="0" cellpadding="3">
  <tr>
    <th scope="col">Company Name</th>
    <th scope="col">Recharge Format</th>
  </tr>
  <tr>
    <td>AIRTEL DIGITAL DTH TV</td>
    <td>A DA 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>SUNDIRECT DTH TV</td>
    <td>A DS 10 9898098980 To 8866107107</td>
  </tr>
  <tr>	
    <td>TATASKY DTH TV</td>
    <td>A DT 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>BIG TV</td>
    <td>A DB 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>VIDEOCON DTH TV</td>
    <td>A DV 10 9898098980 To 8866107107</td>
  </tr>
  <tr>
    <td>DISH TV</td>
    <td>A DD 10 9898098980 To 8866107107</td>
  </tr>
        <tr>
    <td align="center" colspan="2"><strong style="font-size:18px;color:#00C;">A CODE SMARTNO TO 8866107107</strong></td>
  </tr>
</table>
<h2>Balance & Transaction Format</h2>
    <table width="60%" border="1" cellspacing="0" cellpadding="3">
  <tr>
    <td>GET CURRENT BALANCE</td>
    <td>A BAL To 8866107107</td>
  </tr>
  <tr>
    <td>GET LAST THREE TRANSACTION</td>
    <td>A LST To 8866107107</td>
  </tr>
</table>
<center>
<br><br>
<input type="button" onClick="window.print()" class="button" value="Print" />
</center>
<br><br>
</div>
<div id="footer">
     <?php require_once("general_footer.php"); ?>
  <!-- end #footer --></div>
	<!-- end #mainContent --></div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
    
<!-- end #container --></div>

</body>
</html>