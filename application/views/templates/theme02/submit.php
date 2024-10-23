<?php
date_default_timezone_set('Asia/Calcutta'); 
$to = "info@rechargeunlimited.com";
$name = ($_POST['name']);
$phone = ($_POST['phone']);
$email = ($_POST['email']);
$service = ($_POST['service']);
$message = ($_POST['message']);
$cdate = date('d-M-Y h:i:s');
$message = "<table width='500' border='1' cellpadding='2'>
			<tr><td><b>Registration</b></td><td><b>New User Registred</b></td></tr>
			<tr><td width='100'>Name</td><td width='400'>$name</td></tr>
			<tr><td>Contact No. :</td><td>$phone</td></tr>
			<tr><td>Email Id</td><td>$email</td></tr>  
			<tr><td>Selected Service</td><td>$service</td></tr> 
			<tr><td>Comments :</td><td>$message</td></tr>
			<tr><td>Date & Time</td><td>$cdate</td></tr>	
			</table>" ; 
$headers = "";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; ";
$headers .= "charset=iso-8859-1\r\n";
$headers .= "From: $email";
$subject = "One New Registration - From: PayuOnline";
$mail = mail($to, $subject, $message, $headers);
if($mail){	
	//header("location:contact.php?msg=success");
	echo "<div class=\"alert alert-success\"><i class=\"fa fa-check\"></i> Your request has been Sent Successfully</div>";
} else{
	//header("location:contact.php?msg=fail");
	echo "<div class=\"alert alert-danger\"><i class=\"fa fa-times\"></i> Your request has not been Sent, Please try again</div>";
}
?>